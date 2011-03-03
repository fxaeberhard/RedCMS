/**
 * Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
 * Code licensed under the BSD License:
 * http://redcms.red-agent.com/license.html
 */

YUI.add('redcms-menunav', function(Y) {
	Y.RedCMS.MenuNav = Y.Base.create("redcmsnavmenu", Y.Widget, [Y.WidgetStdMod, Y.RedCMS.RedCMSWidget], {
		renderUI : function() {
			var menuNode = this.get("contentBox").one('.yui3-menu');
			menuNode.all(".yui3-menu").each(function (node) {
		        node.append('<div class="yui3-menu-shadow"></div>');			// Append a shadow element to the bounding box of each submenu
		    });
			
			menuNode.plug(Y.Plugin.NodeMenuNav);
			menuNode.removeClass('redcms-hidden');
		},
		destroy : function() {
			this.get("contentBox").one('.yui3-menu').unplug(Y.Plugin.NodeMenuNav);
		}
	}, {} );
}, '0.1.1');