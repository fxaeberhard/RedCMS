/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*/

YUI.add('redcms-menunav', function(Y) {
	Y.RedCMS.MenuNav = Y.Base.create("redcmsnavmenu", Y.Widget, [Y.WidgetStdMod, Y.RedCMS.RedCMSWidget], {
		renderUI : function() {
			this.get("contentBox").one('.yui3-menu').plug(Y.Plugin.NodeMenuNav);
		}
	}, {} );
}, '0.1.1');