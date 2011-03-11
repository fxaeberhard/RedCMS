/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*/
var Y = YUI({
	//lang: 'en-US',
	charset: 'utf-8',
	loadOptional: true,
	//filter: 'raw',
	//filter: 'debug',
	//combine: false,
    useBrowserConsole: true,
   // debug: true,
  // debug: Config.debug,
	//timeout: 10000,
    insertBefore: 'customstyles',
    gallery: 'gallery-2011.02.18-23-10',
	groups: {
		redcms: {
			combine: true,
			base: Config.path,
			comboBase: Config.path+'combo/?',
			root: '/',
			modules:  {
				// *** BASE MODULES *** //	
				'redcms-base': {
					path: 'build/redcms-base/redcms-base-min.js',
					requires: ["node", 'widget', 'widget-parent', 'widget-child', 'io-base']
				},
			/*	'redcms-action': {
					path: 'src/redcms-base/js/redcms-action.js',
					requires: ['widget', 'widget-parent', 'widget-child', 'widget-position', 'io-base']
				},
				'redcms-widget': {
					path: 'src/redcms-base/js/redcms-widget.js',
					requires: ["node", 'widget', 'widget-stdmod']
				},*/

				// *** MENU MODULES *** //
				"redcms-menunav": {
					//path: 'src/redcms-menu/js/redcms-menunav.js',
					path: 'build/redcms-menu/redcms-menunav-min.js',
					requires: ['node-menunav', 'redcms-base']
				},
				"redcms-accordion": {
					//path: 'src/redcms-menu/js/redcms-accordion.js',
					path: 'build/redcms-menu/redcms-accordion-min.js',
					requires: ['redcms-base', 'transition']
				},
				"redcms-treeview": {
					//path: 'src/redcms-menu/js/redcms-treeview.js',
					path: 'build/redcms-menu/redcms-treeview-min.js',
					requires: ['gallery-yui3treeview', 'redcms-tooltip']
				},
				
				// *** ADMIN MODULES *** //
				"redcms-admin": {
					path: 'build/redcms-admin/redcms-admin-min.js',
					//path: 'src/redcms-admin/js/redcms-admin.js',
					requires: ["widget", "widget-position", "widget-stack", "widget-position-align", "async-queue", 
					           'json', 'redcms-menunav', 'gallery-outside-events', 'redcms-panel']
				},
				
				// *** PANEL MODULES *** //
				'redcms-msgbox': {
					path: 'src/redcms-base/js/redcms-msgbox.js',
					requires: ['widget']
				},
				
				'redcms-panel': {
					path: 'build/redcms-panel/redcms-panel-min.js',
					requires: ['redcms-base', 'plugin', 'event-focus', 'overlay', 'widget-anim', 'json', 'dd-plugin', 'io-base', 'resize']
				},
				/*
				'redcms-panel': {
					path: 'src/redcms-panel/js/redcms-action-openpanel.js',
					requires: ['overlay', 'widget-anim', 'json', 'redcms-overlay-window', 'dd-plugin', 'io-base', 'resize']
				},
				'redcms-overlay-window': {
					path: 'src/redcms-panel/js/redcms-overlay-window.js',
					requires: ['plugin', 'event-focus']
				},
				*/
				'redcms-tooltip': {
					path: 'src/redcms-panel/js/redcms-tooltip.js',
					requires: ["event-mouseenter", "widget", "widget-position", "widget-stack"]
				},
				
				// *** FORM MODULES *** //
				'redcms-form': {
					//path: 'build/redcms-form/redcms-form.js',
					path: 'build/redcms-form/redcms-form-min.js',
					requires: ['redcms-base', 'gallery-form', 'io-upload-iframe', 'io-form', 'redcms-msgbox', 'json']
				},
				/*
				'redcms-form': {
					path: 'src/redcms-form/js/redcms-form.js',
					requires: ['gallery-form', 'io-upload-iframe', 'io-form', 'widget', 'redcms-form-editor', 'redcms-msgbox', 'json', 'redcms-form-date']
				},
				'redcms-form-editor': {
					path: 'src/redcms-form/js/redcms-form-editor-field.js'
				},	
				'redcms-form-date': {
					path: 'src/redcms-form/js/redcms-form-date-field.js'
				},
				*/
				
				// *** EDITOR MODULES *** //
				/*,
				'redcms-editor': {
					path: 'src/redcms-editor/js/redcms-editor.js',
					requires: ["yui2-editor"]
				}*/
			}
		}
	}  
}).use( 'redcms-menunav', 'redcms-base', function (Y) {
	
	Y.namespace('RedCMS').Config = Config;
	
	var URLSEPARATOR = '/',
		conf = Y.RedCMS.Config,
		RedCMSManager;
	
	if (conf.debug) Y.use('console', function() {
		new Y.Console({ logSource: Y.Global }).render();						// Render a console for debug purpose
	});
	
	RedCMSManager = function () {
	    return {
	    	urldecode : function(psEncodeString) {
				// Create a regular expression to search all +s in the string
				var lsRegExp = /\+/g;
				// Return the decoded string
				return unescape(String(psEncodeString).replace(lsRegExp, " "));
			},
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
	    	getParentBlock : function(n) {
	    		return n.ancestor( function(e) {
					return  (e.getAttribute('redid') != '');
				});
	    	},
	    	getParentAdminBlock : function(n) {
	    		return n.ancestor( function(e) {
					return  (e.getAttribute('redadmin') != '');
				});
	    	},
	    	reloadWidget : function(widget) {
				var cb = widget.get('contentBox'),
					bb = widget.get('boundingBox'),
					request,
					requestData = {'redreload':true};
				
					if (cb.getAttribute('redparams') != ''){
						bParams = Y.JSON.parse(cb.getAttribute('redparams'));
						requestData = Y.merge( requestData, bParams);
					}
					widget.showReloadOverlay();
					request = Y.io(Y.RedCMS.RedCMSManager.getLink(cb.getAttribute("redid")), {
						data: requestData,
						on: {
							success: function(id, o, args) {
							//	Y.log("RedCMS.onWidgetReloadContentReceived():"+  o.responseText, 'log');
				
								var newNode = Y.Node.create( o.responseText );
								bb.replace(newNode);
								Y.RedCMS.RedCMSManager.render(newNode, Y.bind(function(widgets){
									this.fire('reload', widgets);
									this.destroy();
								}, widget));
							}
						}
					});
	    	},
	    	renderWidget : function(node) {
	    		//Y.log('RedCMSManager.renderWidget(): ' + node.getAttribute('widget'));
				try {
					var widget = new Y.RedCMS[node.getAttribute('widget')]({
						contentBox: node,
						render: true
					});
					return widget;
				} catch (e) {
					//Y.log('Error creating widget with class: Y.RedCMS.'+node.getAttribute('widget'), 'error', 'RedCMSManager');
				}
			},
			renderWidgets : function(widgetNodes, fn, Y) {
	    		//console.log('RedCMSManager.renderWidgets:', widgetNodes);
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
				//Y.log("RedCMSManager.render()", 'log', 'RedCMS.RedCMSManager');
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