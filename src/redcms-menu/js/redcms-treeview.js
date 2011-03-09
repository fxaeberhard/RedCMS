/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*/

//YUI.add('redcms-treeview', function(Y) {
	var TreeView = Y.Base.create("redcms-treeview", Y.Widget, [Y.RedCMS.RedCMSWidget], {

		// *** Instance members *** //
		_treeview:null,
		_tooltip:null,
		
		// *** Life Cycle methods *** //
		renderUI : function() {
			var cb = this.get("contentBox"),
				treeNode = cb.one('ul');
			
			this._treeview = new Y.TreeView({  
				srcNode: treeNode,
				contentBox: treeNode,
				boundingBox: treeNode,
				type : "TreeView"
			});
			this._treeview.render();
			
			this._tooltip = new Y.RedCMS.Tooltip({
		        triggerNodes:".yui3-treeleaf",
		        delegate: treeNode,
		        shim:false,
		        zIndex:1000,
		        autoHideDelay:10000
		    });
			this._tooltip.render();
		 
			this._tooltip.on("triggerEnter", function(e) {
		        var node = e.node,
		        	tooltipContent;
		        if (node) {
					tooltipContent = node.one('.redcms-tooltip-content');
			        if (tooltipContent) {
			            this.setTriggerContent(tooltipContent.getContent());
			        } else { e.preventDefault(); }
		        } else { e.preventDefault(); }
		    });
			
			cb.removeClass('redcms-hidden');
		}, 
		destroy: function() {
			this._tooltip.destroy();
			this._treeview.destroy();
		}
	}, {} );
	Y.namespace('RedCMS').TreeView = TreeView;
//}, '0.1.1');