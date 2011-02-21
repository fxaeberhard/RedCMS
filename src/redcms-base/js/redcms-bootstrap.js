/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*/
var Y = YUI({
	//lang: 'en-US',
	charset: 'utf-8',
	loadOptional: true,
	filter: 'raw',
    useBrowserConsole: true,
	//debug: true,
	//timeout: 10000,
    insertBefore: 'customstyles',
    gallery: 'gallery-2011.01.03-18-30',
	groups: {
		redcms: {
			combine: false,
			base: '/redcms2/',
			// comboBase: 'http://yui.yahooapis.com/combo?',
			// root: '2.8.0r4/build/',
			modules:  {
				"redcms-menunav": {
					path: 'src/redcms-menunav/js/redcms-menunav.js',
					requires: ['node-menunav', 'widget', 'widget-parent', 'widget-child', 'widget-position']
				},
				"redcms-treeview": {
					path: 'src/redcms-menunav/js/redcms-treeview.js',
					requires: ['gallery-yui3treeview']
				},
				"redcms-admin": {
					path: 'src/redcms-admin/js/redcms-admin.js',
					requires: ["widget", "widget-position", "widget-stack", "widget-position-align", "async-queue", 'json', 'redcms-menunav', 'gallery-outside-events']
				},
				'redcms-action': {
					path: 'src/redcms-base/js/redcms-action.js',
					requires: ['widget', 'widget-parent', 'widget-child', 'widget-position']
				},
				'redcms-widget': {
					path: 'src/redcms-base/js/redcms-widget.js',
					requires: []
				},
				'redcms-msgbox': {
					path: 'src/redcms-base/js/redcms-msgbox.js',
					requires: ['widget']
				},
				'redcms-overlay-window': {
					path: 'src/redcms-overlay-window/js/redcms-overlay-window.js',
					requires: ['widget', 'plugin', 'event-focus']
				},
				'redcms-form': {
					path: 'src/redcms-form/js/redcms-form.js',
					requires: ['gallery-form', 'io-upload-iframe']
				},
				'redcms-openpanelaction': {
					path: 'src/redcms-base/js/redcms-openpanelaction.js',
					requires: ['overlay', 'widget-anim', 'json', 'redcms-overlay-window', 'dd-plugin', 'io-base', 'resize']
				}
			}
		}
	}  
}).use("node", 'widget', 'io-base', 'widget-stdmod', 'redcms-widget', 'redcms-menunav', 'redcms-action', 'redcms-msgbox', 'redcms-admin', 'redcms-openpanelaction', function (Y) {
	var URLSEPARATOR = '/',
		conf = Y.RedCMS.Config,
		RedCMSManager;
	
	if (conf.debug) Y.use('console', function() {
		new Y.Console({ logSource: Y.Global }).render();						// Render a console for debug purpose
	});
	
	RedCMSManager = function () {
	    return {
	    	escapeAttribute: function(text) {
    	        if(text) {
    	        	text += "";
    	            return text.replace(/"/g, "&quot;");
    	        }
    	        return "";
	    	},
	    	getLink : function() {
	    		return conf.path+conf.lang+URLSEPARATOR+
	    			Array.prototype.join.call(arguments, URLSEPARATOR)+URLSEPARATOR;
	    	},
	    	reloadWidget : function(widget) {
				var cb = widget.get('contentBox'),
					bb = widget.get('boundingBox'),
					request = Y.io(Y.RedCMS.RedCMSManager.getLink(cb.getAttribute("redid")), {
						on: {
							success: function(id, o, args) {
								Y.log("RedCMS.onWidgetReloadContentReceived():"+  o.responseText, 'log');
								
								var newNode = Y.Node.create( o.responseText );
								bb.replace(newNode);
								widget.destroy();
								Y.RedCMS.RedCMSManager.render(newNode);
							}
						}
					});
	    	},
	    	renderWidget : function(node) {
	    		console.log('RedCMSManager.renderWidget:', node, node.getAttribute('widget'));
				try {
					var widget = new Y.RedCMS[node.getAttribute('widget')]({
						contentBox: node,
						render: true
					});
					return widget;
				} catch (e) {
					Y.log('Error creating widget with class: Y.RedCMS.'+node.getAttribute('widget'), 'error', 'RedCMSManager');
				}
			},
			renderWidgets : function(widgetNodes, fn, Y) {
	    		console.log('RedCMSManager.renderWidgets:', widgetNodes);
				var widgets = new Array();
				widgetNodes.some(function(node){
					var newWidget = RedCMSManager.renderWidget(node);
					if (newWidget) widgets.push(newWidget);
				})
				if (fn != undefined) {
					fn(widgets);
				}
			},
			render : function(node, fn){
				var widgets = node.all('[widget]'),
					requires = new Array();
				if (node.test('[widget]')) widgets.push(node);
				//console.log("RedCMSManager.render()", node, widgets);
				widgets.some(function(n){
					var r = n.getAttribute('requires');
					if (r) requires.push(r);
				});

				if (requires.length>0){
					requires.push(Y.bind(this.renderWidgets, this, widgets, fn));
					Y.use.apply(Y, requires);
				}else {
					RedCMSManager.renderWidgets(widgets, fn);
				}
			}
	    }
	}();

	RedCMSManager.render(Y.one('body'));
	
	Y.namespace('RedCMS').RedCMSManager = RedCMSManager;
	
});