/* 
 Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
 Code licensed under the BSD License:
 http://redcms.red-agent.com/license.html
 */

YUI.add('redcms-admin', function(Y) {

	// *** OverlayAutohide *** //
	var ContextMenu, CONTENTBOX = 'contentBox';

	ContextMenu = Y.Base.create("overmenu", Y.Widget, [Y.WidgetPosition, Y.WidgetPositionAlign], {
		CONTENT_TEMPLATE: '<div><div class="yui3-menu redcmas-over-menu yui3-menu-horizontal"></div></div>',
		// *** Instance Members *** //

		// *** Private Methods *** //

		// *** Lifecycle Methods *** //

		renderUI: function() {
			this.get(CONTENTBOX).one('.yui3-menu').plug(Y.Plugin.NodeMenuNav);
		},
		bindUI: function() {
			Y.one("doc").on("key", function() {
				Y.one("body").toggleClass("redcms-debugmode");
			}, "167");

			Y.one('body').delegate('mouseover', function(e) {
				if (!e.treated) {
					var menuCB = this.get(CONTENTBOX).one('div'),
						targetAdminNodes = e.currentTarget.ancestor(function(n) {
							return n.getAttribute('redadmin');
						}, true);

					if (targetAdminNodes) {
						e.treated = true;
						if (e.currentTarget.getAttribute("data-noover") && !Y.one(".redcms-debugmode"))
							return;
						menuCB.setContent(this._getMenuMarkupFromAdminNodesList(e.currentTarget, targetAdminNodes));
						Y.RedCMS.RedCMSManager.render(menuCB, Y.bind(this._onContextMenuItemsRendered, this, e.currentTarget));

						menuCB.toggleClass("yui3-overmenu-small", parseInt(e.currentTarget.getComputedStyle("height").replace("px")) < 50);

						var w = 0;
						menuCB.all(">div>ul>li").each(function(n) {
							w += parseInt(n.getComputedStyle("width").replace("px")) + parseInt(n.getComputedStyle("marginLeft").replace("px")) + parseInt(n.getComputedStyle("marginRight").replace("px"));
						});
						menuCB.setStyle("width", (w + 5) + "px");
						if (menuCB.getContent()) {
							this.showOverlay(e.currentTarget);
						}
					}
				}
			}, "[redid]", this);

			Y.one('body').delegate('mouseout', function(e) {
				if (!e.treated) {
					e.treated = true;
					this.hideOverlay();
				}
			}, "[redid]", this);

			this.get(CONTENTBOX).on("mouseover", function() {
				this.timer && this.timer.cancel();
			}, this);
			this.get(CONTENTBOX).on("mouseout", this.hideOverlay, this);
		},
		showOverlay: function(target) {
			this.timer && this.timer.cancel();
			this.show();
			this.align(target, ["tr", "tr"]);
			Y.all(".redcms-admin-over").removeClass("redcms-admin-over");
			target.addClass("redcms-admin-over");
		},
		hideOverlay: function() {
			this.timer && this.timer.cancel();
			this.timer = Y.later(20, this, this.doHideOverlay);
		},
		doHideOverlay: function() {
			this.hide();
			this.timer && this.timer.cancel();
			Y.all(".redcms-admin-over").removeClass("redcms-admin-over");
		},
		// *** Private Methods *** //
		_onContextMenuItemsRendered: function(targetNode, widgets) {
			//console.log("ContextMenu._onContextMenuItemsRendered(): ");

			if (widgets.length !== this._adminNodes.length) {									//HACK
				Y.log("ContextMenu._onContextMenuItemsRendered(): widget count does not match _adminNodes count", 'info');
			}

			for (var i = 0; i < widgets.length; i++) {
				//console.log("adding succes callback on a menu item");
				widgets[i].on('success', Y.bind(this._onContextMenuItemSuccess, this, targetNode, this._adminNodes[i]));
			}
		},
		_onContextMenuItemSuccess: function(targetBlock, targetAdminNode) {
			//console.log("ContextMenu._onContextMenuItemSuccess(): ", targetBlock, targetAdminNode, 'log');
			var targetAdminWidget = Y.Widget.getByNode(targetAdminNode),
				targetAdmin;
			if (!targetAdminWidget) {														//HACK
				targetAdmin = targetBlock.ancestor(function(e) {
					return  e.getAttribute('redadmin') !== '';
				}, true);
				targetAdminWidget = Y.Widget.getByNode(targetAdmin);
			}
			Y.RedCMS.RedCMSManager.reloadWidget(targetAdminWidget);
		},
		_adminNodes: null,
		_getMenuMarkupFromAdminNodesList: function(targetNode, currentAdminNode) {
			var ret = ['<div class="yui3-menu-content"><ul class="first-of-type">'], jsonConf;

			this._adminNodes = [];                                              //HACK

			try {
				jsonConf = Y.JSON.parse(decodeURI(currentAdminNode.getAttribute('redadmin')));
			} catch (e) {
				Y.log('RedCMSAdmin._getMenuMarkupFromAdminNodesList(): Unable to parse admin menu JSON configuration', 'error');
			}

			if (Y.one(".redcms-debugmode")) {
				jsonConf = jsonConf.concat([
					{widget: 'OpenPanelAction', label: '[root]Edit', href: Y.RedCMS.Config.path + '210', action: 'editCurrent'},
					{widget: 'OpenPanelAction', label: '[root]Permission', href: Y.RedCMS.Config.path + '109', action: 'editCurrent'},
					{widget: 'OpenPanelAction', label: '[root]New sibling', href: Y.RedCMS.Config.path + '210', action: 'addSibling'},
					{widget: 'OpenPanelAction', label: '[root]New child', href: Y.RedCMS.Config.path + '210', action: 'addChild'},
					{widget: 'DeleteBlockAction', label: '[root]Delete', href: Y.RedCMS.Config.path + '103', action: 'editCurrent'}
				]);
			}

			ret = ret.concat(this._getMenuMarkupFromAdminNode(targetNode, currentAdminNode, jsonConf));

			if (ret.length > 2) {
				return ret.join('');
			} else {
				return '';
			}
		},
		_getMenuMarkupFromAdminNode: function(targetNode, targetAdminNode, adminConfObj) {
			var ret = [], row, i, isValidRow, href, params, parentNode;
			//Y.log("ContextMenu._getMenumarkupFromObject(): "+ this._targetBlock, 'log');

			adminConfObj = adminConfObj.reverse();

			for (i = 0; i < adminConfObj.length; i++) {
				row = adminConfObj[i];
				isValidRow = true;
				if (row.filter !== undefined && row.filter.split('|').indexOf(targetNode.getAttribute('widget')) === -1) {
					continue;
				}
				href = row.href;
				params = {};
				parentNode = Y.RedCMS.RedCMSManager.getParentBlock(targetNode);
				switch (row.action) {
					case 'editCurrent':
						params.id = targetNode.getAttribute('redid');
						break;
					case 'addSibling':
						if (parentNode) {
							params.parentId = parentNode.getAttribute('redid');
						} else {
							isValidRow = false;
						}
						break;
					case 'addChild':
						params.parentId = targetNode.getAttribute('redid');
						break;
					case  'editRoot':
						if (targetAdminNode) {
							params.id = targetAdminNode.getAttribute('redid');
						} else {
							isValidRow = false;
						}
						break;
					case 'addChildToRoot':
						if (targetAdminNode) {
							params.parentId = targetAdminNode.getAttribute('redid');
						} else {
							isValidRow = false;
						}
						break;
					case  'replaceHref':
						href = (targetNode.one('a') || targetNode).get('href');
						break;
				}

				if (isValidRow) {
					var l = row.label.toLowerCase(), icon = "";                     // Append font awesome icons

					if (l.indexOf("edit groups") > -1) {
						icon = "<i class='fa fa-users fa-1 fa-fw'></i>";
					} else if (l.indexOf("edit") > -1) {
						icon = "<i class='fa fa-pencil fa-1 fa-fw'></i>";
					} else if (l.indexOf("restore") > -1) {
						icon = "<i class='fa fa-undo fa-1 fa-fw'></i>";
					} else if (l.indexOf("open") > -1) {
						icon = "<i class='fa fa-external-link fa-1 fa-fw'></i>";
					} else if (l.indexOf("download") > -1) {
						icon = "<i class='fa fa-download fa-1 fa-fw'></i>";
					} else if (l.indexOf("upload") > -1) {
						icon = "<i class='fa fa-upload fa-1 fa-fw'></i>";
					} else if (l.indexOf("permission") > -1 || l.indexOf("group") > -1) {
						icon = "<i class='fa fa-users fa-1 fa-fw'></i>";
					} else if (l.indexOf("create") > -1 || (l.indexOf("new") > -1 && l.indexOf("news") === -1)) {
						icon = "<i class='fa fa-plus fa-1 fa-fw'></i>";
					} else if (l.indexOf("delete") > -1) {
						icon = "<i class='fa fa-trash fa-1 fa-fw'></i>";
					}

					ret.push('<li ');
					if (!row.children) {
						ret.push('class="yui3-menuitem" ');
					}
					ret.push('widget="', row.widget, '" params="', Y.RedCMS.RedCMSManager.escapeAttribute(Y.JSON.stringify(params)), '" >');
					if (row.children) {
						ret.push('<a class="yui3-menu-label" href="', href, '" title="', row.label, '">', icon, row.label,
							'</a><div class="yui3-menu yui3-menu-hidden"><div class="yui3-menu-content"><ul class="first-of-type">');
						ret = ret.concat(this._getMenuMarkupFromAdminNode(targetNode, targetAdminNode, row.children));
						ret.push('</ul></div></div>');
					} else {
						this._adminNodes.push(targetAdminNode);											//HACK
						ret.push('<a class="yui3-menuitem-content" href="', href, '" title="', row.label, '" >', icon, row.label, '</a>');
					}
					ret.push('</li>');
				}
			}
			return ret;
		}
	});

	Y.namespace('RedCMS').ContextMenu = ContextMenu;

	Y.RedCMS.cm = new ContextMenu({
		zIndex: 100000,
		visible: false
	}).render();

}, '0.1.1');