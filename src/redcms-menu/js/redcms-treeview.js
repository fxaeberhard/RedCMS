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
				target = cb.one("div") || cb;

			try {
				fields = Y.JSON.parse(RedCMS.RedCMSManager.urldecode(target.getContent()));
				this.set("children", fields);
			} catch (e) {
				Y.log('Form._parseFields(): Unable to parse form content.', 'log', 'RedCMS.Form');
			}
			target.setContent('');

			this._treeview = new CTreeView({
				startCollapsed: false,
				children: fields
			}).render(cb);

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
		_treeLeafClick: function(e) {
			var cb = e.target.get(CONTENT_BOX),
				blockNode = cb.get('parentNode'),
				selectedElem = {
					id: blockNode.getAttribute('redid'),
					href: cb.getAttribute('href'),
					label: cb.getContent()
				};
			this.fire('redcms:select', selectedElem);

			if (blockNode.hasAttribute('widget') && blockNode.getAttribute('widget') === 'PageLinkAction'
				&& selectedElem.href !== '#') {
				window.location = selectedElem.href;
			}
		}
	});
	RedCMS.TreeView = TreeView;

	var TreeNode = Y.Base.create("treeview", Y.TreeNode, [], {
		syncUI: function() {
			TreeNode.superclass.syncUI.call(this);
			var target = this.get(BOUNDING_BOX).one("a");

			if (this.get("attrs")) {
				Y.Object.each(this.get("attrs"), function(i, k) {
					target.setAttribute(k, i);
				});
			}
		}
	}, {
		ATTRS: {
			attrs: {}
		}
	});

	var CTreeView = Y.Base.create("treenode", Y.TreeView, [], {}, {
		ATTRS: {
			defaultChildType: {
				value: TreeNode
			}
		}
	});

}, '0.1.1');