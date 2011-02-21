YUI.add('redcms-menunav', function(Y) {

	var NavMenu = Y.Base.create("redcms-menunav", Y.Widget, [Y.WidgetStdMod], {
		renderUI : function() {
			this.get("contentBox").one('.yui3-menu').plug(Y.Plugin.NodeMenuNav);
		}
	}, {} );
	
	Y.namespace('RedCMS').NavMenu = NavMenu;
	console.log('Navemenu added');
}, '@VERSION@' );
