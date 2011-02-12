/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.sourceforge.net/license.html
*/

YUI.add('redcms-navmenu', function(Y) {
	Y.RedCMS.NavMenu = Y.Base.create("redcmsnavmenu", Y.Widget, [Y.WidgetStdMod], {
		renderUI : function() {
			this.get("contentBox").one('.yui3-menu').plug(Y.Plugin.NodeMenuNav);
		}
	}, {} );
}, '0.1.1');