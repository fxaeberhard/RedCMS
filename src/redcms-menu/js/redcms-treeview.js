/* 
 Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
 Code licensed under the BSD License:
 http://redcms.red-agent.com/license.html
 */

YUI.add('redcms-treeview', function(Y) {


	var TreeView, RedCMS = Y.RedCMS, BOUNDING_BOX = 'boundingBox', CONTENT_BOX = 'contentBox';

	TreeView = Y.Base.create("redcms-treeview", Y.Widget, [RedCMS.RedCMSWidget], {
		// *** Instance members *** //
		_treeview: null,
		_tooltip: null,
		// *** Life Cycle methods *** //
		renderUI: function() {
			var fields = this.get("children"),
				cb = this.get(CONTENT_BOX),
				target = cb.one("div") || cb,
				striplast = function(fields) {
					var last = fields.pop();
					if (Y.Object.size(last) > 0)
						fields.push(last);
					Y.Array.each(fields, function(f) {
						f.children && striplast(f.children);
					});
				};

			try {
				fields = Y.JSON.parse(decodeURIComponent(target.getContent()));
//				fields = Y.JSON.parse(target.getContent());
				striplast(fields);
				this.set("children", fields);

			} catch (e) {
				Y.log('Treeview._parseFields(): Unable to parse cfg', 'log', 'RedCMS.Form');
			}
			target.setContent('');

			this._treeview = new CTreeView({
				//startCollapsed: false,
				children: fields
			}).render(cb);
			this._treeview.on("nodeclick", this.treenodeClick);

			cb.removeClass('yui3-redcms-loading');

			this._tooltip = new RedCMS.Tooltip({
				triggerNodes: ".yui3-treenode-label",
				delegate: cb.one('ul'),
				shim: false,
				zIndex: 100000,
				autoHideDelay: 10000
			}).render();
		},
		destructor: function() {
			this._tooltip.destroy();
			this._treeview.destroy();
		},
		// *** Private Methods *** //
		treenodeClick: function(e) {
			if (!e.treenode.get("isLeaf"))
				return;

			var bb = e.treenode.get(BOUNDING_BOX).one("a"),
				href = bb.getAttribute("href");

			this.fire('redcms:select', {
				id: bb.getAttribute('redid'),
				href: href,
				label: bb.get("text")
			});

			if (bb.hasAttribute('widget') && bb.getAttribute('widget') === 'PageLinkAction'
				&& href !== '#') {
				window.location = href;
			}
		}
	});
	RedCMS.TreeView = TreeView;

	var RTreeNode = Y.Base.create("treenode", Y.TreeNode, [], {
		syncUI: function() {
			RTreeNode.superclass.syncUI.call(this);
			var target = this.get(BOUNDING_BOX).one("a");

			if (this.get("attrs")) {
				Y.Object.each(this.get("attrs"), function(i, k) {
					target.setAttribute(k, i);
				});
			}
			if (this.get("icon")) {
				target.one("span").prepend("<i class='yui3-redcms-icon yui3-redcms-icon-" + this.get("icon") + "'></i>");
			}
		}
	}, {
		ATTRS: {
			icon: {},
			attrs: {},
			defaultChildType: {
				value: "RTreeNode"
			}
		}
	});
	Y.RTreeNode = RTreeNode;

	var CTreeView = Y.Base.create("treeview", Y.TreeView, [], {}, {
		ATTRS: {
			defaultChildType: {
				value: RTreeNode
			}
		}
	});

}, '0.1.1');