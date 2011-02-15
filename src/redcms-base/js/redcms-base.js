/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.sourceforge.net/license.html
*/
var Y = YUI({
	//lang: 'en-US',
	charset: 'utf-8',
	loadOptional: true,
	filter: 'min',
    useBrowserConsole: true,
	debug: true,
	//timeout: 10000,
    insertBefore: 'customstyles',
	groups: {
		redcms: {
			combine: false,
//			base: '/redcms2/',
			base: '../RedCMS/',
			// comboBase: 'http://yui.yahooapis.com/combo?',
			// root: '2.8.0r4/build/',
			modules:  {
				"redcms-menunav": {
					path: 'src/redcms-navmenu/js/redcms-navmenu.js',
					requires: ['node-menunav', 'widget', 'widget-parent', 'widget-child', 'widget-position']
				},
				"redcms-admin": {
					path: 'src/redcms-admin/js/redcms-admin.js',
					requires: ["widget", "widget-position", "widget-stack", "widget-position-align", "async-queue", 'json', 'redcms-menunav', 'gallery-outside-events']
				},
				'redcms-action': {
					path: 'src/redcms-base/js/redcms-action.js',
					requires: ['widget', 'widget-parent', 'widget-child', 'widget-position']
				},
				'redcms-msgbox': {
					path: 'src/redcms-base/js/redcms-msgbox.js',
					requires: ['widget']
				},
				'redcms-overlay-window': {
					path: 'src/redcms-overlay-window/js/redcms-overlay-window.js',
					requires: ['widget', 'plugin']
				},
				'redcms-form': {
					path: 'src/redcms-form/js/redcms-form.js',
					requires: ['gallery-form']
				},
				'redcms-openpanelaction': {
					path: 'src/redcms-base/js/redcms-openpanelaction.js',
					requires: ['overlay', 'widget-anim', 'json', 'redcms-overlay-window', 'dd-plugin', 'io-base', 'resize']
				}
			}
		}
	}  
}).use("node", 'widget', 'widget-stdmod', 'redcms-menunav', 'console', 'redcms-action', 'redcms-msgbox', 'redcms-admin', 'redcms-openpanelaction', function (Y) {
	var URLSEPARATOR = '/',
		conf = Y.RedCMS.Config,
		RedCMSManager;

	if (conf.debug) Y.use('console', function() {
		new Y.Console({ logSource: Y.Global }).render();						// Render a console for debug purpose
	});
	
	RedCMSManager = function () {
	    return {
	    	getLink : function() {
	    		return conf.path+conf.lang+URLSEPARATOR+
	    			Array.prototype.join.call(arguments, URLSEPARATOR)+URLSEPARATOR;
	    	},
	    	renderWidget : function(Y, node) {
				try {
				console.log(Y.RedCMS[node.getAttribute('widget')]);
					var widget = new Y.RedCMS[node.getAttribute('widget')]({
						contentBox: node
					});
					widget.render();
				} catch (e) {
					Y.log('Error creating widget with class: Y.RedCMS.'+node.getAttribute('widget'), 'error', 'RedCMSManager');
				//	console.log(e.description);
				}
			},
			render : function(node){	
				node.all('[widget]').some( function(node) {						// For each in the source node, 
					var requires = node.getAttribute('requires');
					Y.log('Rendering widget '+node.getAttribute('widget')+" requiring "+requires, 'RedCMSManager');
					if (requires) {
						Y.use(requires, function(Y) {
							console.log("mmmmmooooo");
							RedCMSManager.renderWidget(Y, node);					// we render them with the mentionned widget.
						});
					} else {
						RedCMSManager.renderWidget(Y, node);
					}
				});
			}
	    }
	}();

	RedCMSManager.render(Y.one('body'));
	
	Y.namespace('RedCMS').RedCMSManager = RedCMSManager;
	
});