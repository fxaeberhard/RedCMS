/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*/

YUI.add('redcms-treeview', function(Y) {
	var TreeView = Y.Base.create("redcms-treeview", Y.Widget, [Y.RedCMS.RedCMSWidget], {
		renderUI : function() {
			var treeNode = this.get("contentBox").one('ul');
			var treeview = new Y.TreeView({  
				srcNode: treeNode,
				contentBox: treeNode,
				boundingBox: treeNode,
				type : "TreeView"
			});
			treeview.render();
		}
	}, {} );
	Y.namespace('RedCMS').TreeView = TreeView;
}, '0.1.1');