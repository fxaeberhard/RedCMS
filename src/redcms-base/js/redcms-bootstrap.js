/* 
 Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
 Code licensed under the BSD License:
 http://redcms.red-agent.com/license.html
 */
var debug = /[\\?&]debug/.exec(window.location.href) !== null;

var Y = YUI({
	charset: 'utf-8',
	useBrowserConsole: true,
	insertBefore: 'customstyles',
	loadOptional: true,
	gallery: 'gallery-2012.08.29-20-10',
	base: Config.path + "bower_components/yui/build/",
	root: "bower_components/yui/build/",
	combine: true,
	comboSep: ",",
	comboBase: Config.path + 'lib/min/f=',
	filter: 'raw',
	//debug: true,
	//filter: 'debug',
	//debug: Config.debug,
	//lang: 'en-US',
	//timeout: 10000,
	groups: {
		redcms: {
			combine: !debug,
			base: Config.path,
			//comboBase: Config.path + 'lib/min/f=',
			root: '/',
			modules: {
				// *** BASE MODULES *** //	
				'redcms-base': {
					path: 'src/redcms-base/js/redcms-base.js',
					requires: ["base", "node", 'widget', 'widget-parent', 'widget-child', 'io-base', "json"],
					use: ['redcms-widget', "redcms-action"]
				},
				'redcms-action': {
					path: 'src/redcms-base/js/redcms-action.js',
					requires: ['base', "widget"]
				},
				'redcms-widget': {
					path: 'src/redcms-base/js/redcms-widget.js',
					requires: ["node", 'widget']
				},
				// *** MENU MODULES *** //
				"redcms-menunav": {
					path: 'src/redcms-menu/js/redcms-menunav.js',
					requires: ['node-menunav', 'redcms-base']
				},
				"redcms-accordion": {
					path: 'src/redcms-menu/js/redcms-accordion.js',
					requires: ['redcms-base', 'transition']
				},
				"redcms-treeview": {
					path: 'src/redcms-menu/js/redcms-treeview.js',
					requires: ['treeview', 'redcms-tooltip', "json"]
				},
				"treeview": {
					path: 'src/redcms-menu/js/treeview.js',
					requires: ["substitute", "widget", "widget-parent", "widget-child",
						"node-focusmanager", "array-extras"
					]
				},
				// *** ADMIN MODULES *** //
				"redcms-admin": {
					path: 'src/redcms-admin/js/redcms-admin.js',
					requires: ["widget", "widget-position", "widget-stack", "widget-position-align",
						'json', 'redcms-menunav', 'redcms-panel', "event-key"
					]
				},
				"redcms-context": {
					path: 'src/redcms-admin/js/redcms-context.js',
					requires: ["widget", "widget-position", "widget-stack", "widget-position-align", "async-queue",
						'json', 'redcms-menunav', 'gallery-outside-events', 'redcms-panel'
					]
				},
				// *** PANEL MODULES *** //
				'redcms-msgbox': {
					path: 'src/redcms-base/js/redcms-msgbox.js',
					requires: 'widget'
				},
				'redcms-panel': {
					path: 'src/redcms-panel/js/redcms-action-openpanel.js',
					requires: ["panel", 'json', 'io-base', 'event-resize']
				},
				'redcms-overlay-window': {
					path: 'src/redcms-panel/js/redcms-overlay-window.js',
					requires: ['plugin', 'event-focus']
				},
				'redcms-tooltip': {
					path: 'src/redcms-panel/js/redcms-tooltip.js',
					requires: ["event-mouseenter", "widget", "widget-position", "widget-stack"]
				},
				// *** FORM MODULES *** //
				'redcms-form': {
					path: 'src/redcms-form/js/redcms-form.js',
					requires: ['redcms-base', "inputex", 'io-upload-iframe', 'io-form', 'redcms-msgbox', 'json', "array-extras"]
				},
				'redcms-tabview': {
					path: "src/redcms-base/js/recms-treeview",
					requires: ["redmcs-base", "tabview"]
				},
				tinymce: {
					path: "lib/tinymce/jscripts/tiny_mce/tiny_mce_src.js"
				}
			}
		}
	}
}).use('redcms-menunav', 'redcms-base', function(Y) {

	YUI_config.groups.inputex.base = Config.path + 'lib/inputex/src/';
	YUI_config.groups.inputex.combine = true;
	YUI_config.groups.inputex.comboBase = Config.path + 'lib/min/f=';
	YUI_config.groups.inputex.root = 'lib/inputex/src/';

	var URLSEPARATOR = '/',
		RedCMS = Y.namespace('RedCMS'),
		RedCMSManager;

	RedCMS.Config = Config;

	if (Config.debug)
		Y.use('console', function() {
			new Y.Console({ logSource: Y.Global }).render(); // Render a console for debug purpose
		});

	// Singleton
	RedCMSManager = function() {
		return {
			urldecode: function(psEncodeString) {
				var lsRegExp = /\+/g; // Create a regular expression to search all +s in the string
				return unescape(String(psEncodeString).replace(lsRegExp, " ")); // Return the decoded string
			},
			escapeAttribute: function(text) {
				if (text) {
					text += "";
					return text.replace(/"/g, "&quot;");
				}
				return "";
			},
			getLink: function() {
				return Config.path + /*Config.lang + URLSEPARATOR + */ Array.prototype.join.call(arguments, URLSEPARATOR) + URLSEPARATOR;
			},
			getParentBlock: function(n) {
				return n.ancestor(function(e) {
					return e.getAttribute('redid') !== '';
				});
			},
			getParentAdminBlock: function(n) {
				return n.ancestor(function(e) {
					return e.getAttribute('redadmin') !== '';
				});
			},
			reload: function(node) {
				var targetAdmin = node.ancestor(function(e) {
					return e.getAttribute('redadmin') !== '';
				}, true);

				RedCMSManager.reloadWidget(Y.Widget.getByNode(targetAdmin));
			},
			reloadWidget: function(widget) {
				var cb = widget.get('contentBox'),
					bb = widget.get('boundingBox'),
					request, bParams,
					requestData = { 'redreload': true };

				// if (cb.getAttribute('redparams') !== '') {
				// 	bParams = Y.JSON.parse(cb.getAttribute('redparams'));
				// 	requestData = Y.merge(requestData, bParams);
				// }
				widget.showReloadOverlay();
				request = Y.io(RedCMSManager.getLink(cb.getAttribute("redid")), {
					data: requestData,
					on: {
						success: function(id, o) {
							//	Y.log("RedCMS.onWidgetReloadContentReceived():"+  o.responseText, 'log');
							var newNode = Y.Node.create(o.responseText);
							bb.replace(newNode);
							RedCMSManager.render(newNode, Y.bind(function(widgets) {
								this.fire('reload', widgets);
								this.destroy();
							}, widget));
						}
					}
				});
			},
			renderWidget: function(node) {
				//Y.log('RedCMSManager.renderWidget(): ' + node.getAttribute('widget'));
				try {
					var widgetClass = RedCMS[node.getAttribute('widget')],
						cfg = node.getAttribute("data-cfg");
					if (!widgetClass) {
						//Y.log('Unable to find widget with class: Y.RedCMS.' + node.getAttribute('widget'), 'info', 'RedCMSManager');
						return;
					}
					var widget = new widgetClass(Y.mix({
						srcNode: node
					}, cfg ? Y.JSON.parse(RedCMSManager.urldecode(cfg)) : {})).render();
					return widget;
				} catch (e) {
					Y.log('Error creating widget with class: Y.RedCMS.' + node.getAttribute('widget'), 'error', 'RedCMSManager');
				}
			},
			renderWidgets: function(widgetNodes, fn) {
				//Y.log('RedCMSManager.renderWidgets:', widgetNodes);
				var widgets = [];
				widgetNodes.each(function(node) {
					var newWidget = RedCMSManager.renderWidget(node);
					newWidget && widgets.push(newWidget);
				});
				fn && fn(widgets);
			},
			render: function(node, fn) {
				var widgets = node.all('[widget]'),
					requires = new Array();

				if (node.test('[widget]'))
					widgets.push(node);
				//Y.log("RedCMSManager.render()", 'log', 'RedCMS.RedCMSManager');
				widgets.each(function(n) {
					if (n.hasAttribute("requires"))
						requires.push(n.getAttribute('requires'));
				});

				Y.use(requires, Y.bind(this.renderWidgets, this, widgets, fn));
			}
		};
	}();

	RedCMSManager.render(Y.one('body'));

	RedCMS.RedCMSManager = RedCMSManager;

});
