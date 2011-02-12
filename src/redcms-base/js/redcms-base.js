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
	//timeout: 10000,
    insertBefore: 'customstyles',
	groups: {
		redcms: {
			combine: false,
			base: '/redcms2/',
			// comboBase: 'http://yui.yahooapis.com/combo?',
			// root: '2.8.0r4/build/',
			modules:  {
				"redcms-navmenu": {
					path: 'src/redcms-navmenu/js/redcms-navmenu.js',
					requires: ['node-menunav', 'widget', 'widget-parent', 'widget-child', 'widget-position']
				},
				"redcms-admin": {
					path: 'src/redcms-admin/js/redcms-admin.js',
					requires: ["widget", "widget-position", "widget-stack", "widget-position-align", "async-queue", 'json', 'redcms-navmenu', 'gallery-outside-events']
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
				}
			}
		}
	}  
}).use("node", 'widget', 'widget-stdmod', 'redcms-navmenu', 'console', 'redcms-action', 'redcms-msgbox', 'redcms-admin', function (Y) {
	var URLSEPARATOR = '/',
	conf = Y.RedCMS.Config,
	RedCMSManager;

	/* Render a console for debug purpose */
	if (conf.debug) Y.use('console', function() {new Y.Console({ logSource: Y.Global }).render();	 });
	
	RedCMSManager = function () {
	    return {
	    	getLink : function() {
	    		console.log(Array.prototype.join.call(arguments));
	    		return conf.path+conf.lang+URLSEPARATOR+
	    			Array.prototype.join.call(arguments, URLSEPARATOR)+URLSEPARATOR;
	    		
	    	},
	    	renderWidget : function(node) {
				var widget = new Y.RedCMS[node.getAttribute('widget')]({
				    contentBox: node
				});
				widget.render();
			},
			render : function(){	
				/* For each blocks on the page, we render them with the mentionned widget. */
				Y.all('[widget]').some( function(node) {
					Y.log('Rendering widget '+node.getAttribute('widget'));
					if (node.getAttribute('requires')) {
						Y.use(node.getAttribute('requires'), function(Y) {
							RedCMSManager.renderWidget(node);
						});
					} else {
						RedCMSManager.renderWidget(node);
					}
				});
			}
	    }
	}();

	RedCMSManager.render();
	Y.namespace('RedCMS').RedCMSManager = RedCMSManager;
	
});