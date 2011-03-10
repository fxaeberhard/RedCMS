/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*/



//YUI.add('redcms-admin', function(Y) {
	
// *** OverlayAutohide *** //
	var ContextMenu,
		BOUNDINGBOX = 'boundingBox',
		CONTENTBOX = 'contentBox';
	
    ContextMenu = Y.Base.create("contextmenu", Y.Widget, [Y.WidgetPosition, Y.WidgetStack], {
		// *** Instance Members *** //

		// *** Private Methods *** //

		// *** Lifecycle Methods *** //

		renderUI : function() {
			var bb = this.get(BOUNDINGBOX),
				cb = this.get(CONTENTBOX);
				
			bb.setStyle('position', 'absolute');
			cb.setContent('<div class="yui3-menu" />');
			
			cb.one('.yui3-menu').plug(Y.Plugin.NodeMenuNav);
		},
		
		bindUI : function() {
			var bb = this.get(BOUNDINGBOX),
				cb = this.get(CONTENTBOX),
				hide = Y.bind(this.hide, this);
			
			bb.on('mouseupoutside', hide);
			bb.on('click', hide);
		
			Y.one('body').on('contextmenu', function(e) {
				//Y.log('ContextMenu.onContextMenu()', 'info');

				var targetNode = e.target.ancestor('[redid]', true),
					//targetAdmin = e.target.ancestor('[redadmin]', true),
					targetAdminNodes = e.target.ancestors(function(n){
						return (n.getAttribute('redadmin') != '');
					}, true),
					
					menuCB = cb.one('div');
				
				if (targetNode && targetAdminNodes.size() > 0) {
					e.halt();	
					this.show();
					this.move(e.clientX + Y.DOM.docScrollX(), e.clientY + Y.DOM.docScrollY());
					menuCB.setContent(this._getMenuMarkupFromAdminNodesList(targetNode, targetAdminNodes));
					Y.RedCMS.RedCMSManager.render(menuCB, Y.bind(this._onContextMenuItemsRendered, this, targetNode));
				}
			}, this);
		}, 
		
		
		// *** Private Methods *** //
		_onContextMenuItemsRendered: function(targetNode, widgets) {
			//console.log("ContextMenu._onContextMenuItemsRendered(): ");
			
			if (widgets.length != this._adminNodes.length) {									//HACK
				Y.log("ContextMenu._onContextMenuItemsRendered(): widget count does not match _adminNodes count", 'error');
			}
			
			for (var i=0; i<widgets.length; i++) {
				//console.log("adding succes callback on a menu item");
				widgets[i].on('success', Y.bind(this._onContextMenuItemSuccess, this, targetNode, this._adminNodes[i]));
			}
		},
		_onContextMenuItemSuccess: function(targetBlock, targetAdminNode) {
			//console.log("ContextMenu._onContextMenuItemSuccess(): ", targetBlock, 'log');
			var targetAdminWidget = Y.Widget.getByNode(targetAdminNode),
				targetAdmin;
			
			if (!targetAdminWidget) {														//HACK
				targetAdmin = Y.RedCMS.RedCMSManager.getParentAdminBlock(targetBlock);
				targetAdminWidget = Y.Widget.getByNode(targetAdmin);
			}
			Y.RedCMS.RedCMSManager.reloadWidget(targetAdminWidget);
		},
		_adminNodes : null,
		
		_getMenuMarkupFromAdminNodesList : function( targetNode, targetAdminNodesList ) {
			var ret = ['<div class="yui3-menu-content">'],
				firstOfType = false,
				currentAdminNode, i, jsonConf;
				
				this._adminNodes = [];							//HACK
			
				for (i=targetAdminNodesList.size()-1; i>=0; i--) {
					currentAdminNode = targetAdminNodesList.item(i);
					try {
						jsonConf = Y.JSON.parse(decodeURI(currentAdminNode.getAttribute('redadmin')));
					} catch(e) {
						Y.log('RedCMSAdmin._getMenuMarkupFromAdminNodesList(): Unable to parse admin menu JSON configuration', 'error');
					}
					if (jsonConf.length>0) {
						if (firstOfType) { ret.push('<ul>'); }
						else { ret.push('<ul class="first-of-type">'); }
						ret = ret.concat(this._getMenuMarkupFromAdminNode(targetNode, currentAdminNode, jsonConf));
						ret.push('</ul>');
						firstOfType = true;
					}
				}

				ret.push('</div>');
				if (ret.length>2) { return ret.join(''); }
				else { return ''; }
		},
		_getMenuMarkupFromAdminNode : function( targetNode, targetAdminNode, adminConfObj ) {
			var ret = [],
				row, i, isValidRow, href, params, parentNode;
			//Y.log("ContextMenu._getMenumarkupFromObject(): "+ this._targetBlock, 'log');
			
			for (i=0; i<adminConfObj.length; i++) {
				row = adminConfObj[i];
				isValidRow = true;
				if (row.filter !== undefined) {
					isValidRow =  row.filter.split('|').indexOf(targetNode.getAttribute('widget')) > -1;
				}
				if (isValidRow) {
					href = row.href;
					params = {};
					//parentTuple = this._targetBlock.ancestor('[redid]'),
					parentNode = Y.RedCMS.RedCMSManager.getParentAdminBlock(targetNode);
					if (row.action == 'editCurrent') {
						params.id = targetNode.getAttribute('redid');
					} else if (row.action == 'addSibling' ){
						if (parentNode) { params.parentId = parentNode.getAttribute('redid'); }
						else { isValidRow = false; }
					} else if (row.action == 'addChild'){
						params.parentId = targetNode.getAttribute('redid');			
					} else if (row.action == 'editRoot') {
						if (targetAdminNode) { params.id = targetAdminNode.getAttribute('redid'); }
						else  { isValidRow = false; }
					} else if (row.action == 'addChildToRoot') {
						if (targetAdminNode) { params.parentId = targetAdminNode.getAttribute('redid'); }
						else { isValidRow = false; }
					} else if (row.action == 'replaceHref') {
						//console.log('replacing', this._targetBlock, this._targetBlock.get(CONTENTBOX), CONTENTBOX);
						href = targetNode.one('a').get('href');
					}
				}
				if (isValidRow) {
					ret.push('<li ');
					if (!row.children) { ret.push('class="yui3-menuitem" '); }
					ret.push('widget="',row.widget,'" params="',Y.RedCMS.RedCMSManager.escapeAttribute(Y.JSON.stringify(params)),'" >');
					if (row.children) {
						ret.push('<a class="yui3-menu-label" href="',href,'" >', row.label, 
								'</a><div class="yui3-menu yui3-menu-hidden"><div class="yui3-menu-content"><ul class="first-of-type">');
						ret = ret.concat( this._getMenuMarkupFromAdminNode( targetNode, targetAdminNode, row.children));
						ret.push('</ul></div></div>');	
					} else {
						this._adminNodes.push(targetAdminNode);											//HACK
						ret.push('<a class="yui3-menuitem-content" href="',href,'" >',row.label,'</a>');	
					}
					ret.push('</li>');
				}
			}
			return ret;
		}
	});
    
	Y.namespace('RedCMS').ContextMenu = ContextMenu;
	
	Y.RedCMS.cm = new ContextMenu({
        zIndex:1000,
        render : true,
		visible : false
    });
	
//}, '0.1.1', {requires:['gallery-outside-events', 'node-menunav']});