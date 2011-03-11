/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.comw/license.html
*/

//YUI.add('redcms-panel', function(Y) {
	
	var OpenPanelAction,
		BlockReloadOpenPanelAction, 
		CONTENT_BOX = 'contentBox',
		BOUNDING_BOX = 'boundingBox',
		BODY = 'body',
		
		CLICK = 'click',
		
		OPENPANELACTIONCLASSES = {
			LOADING : 'yui3-redcms-loading'
		};
	

	OpenPanelAction = Y.Base.create("redcms-panel", Y.Widget, [Y.RedCMS.RedCMSWidget], {
		//	***	Instance members ***	//
		_overlay: null,
		
		_widgets: null,
		
		//	***	Life cycle methods ***	//
		initializer : function (config) {
			this.publish('submit');
		},
		bindUI : function() {
			this.get(CONTENT_BOX).one('a').on(CLICK, function(e) {
				e.preventDefault();
				
				var cb = this.get(CONTENT_BOX),
					params = [],
					paramsString = cb.getAttribute('params');
				
				this._overlay = new Y.Overlay({												// First create an overlay window widget
					bodyContent : '<div></div>',
					headerContent : cb.one('a').getContent(),
					zIndex      : 100,
					constrain   : 'body',
					render      : true,
					visible     : true,
					align		: {points:["cc", "cc"]},
					plugins     : [
						{ fn: Y.Plugin.OverlayWindow},
						{ fn: Y.Plugin.Drag }
					]
				});

				this._overlay.dd.addHandle('.yui3-widget-hd');
				
				this._overlay.getStdModNode(BODY).addClass(OPENPANELACTIONCLASSES.LOADING);
				
				this._overlay.after('render', function(e) {
					var resize = new Y.Resize({
						node: this.getStdModNode(BODY),
						handles: ['b', 'r', 'br', 'bl']
					});
					this.set("align", {points:["cc", "cc"]});
				});
				
				
				if (paramsString) { params = Y.JSON.parse(paramsString);  }
				//console.log("OpenPanelAction.bindUI():", this, cb, cb.getAttribute('params'));
				
				Y.io(cb.one('a').get('href'), {						//Then request its content to the server
					data: params,
					on: {
						success: function(id, o, args) {
							var body = this._overlay.getStdModNode(BODY);
							body.append(o.responseText);
							this._overlay.set("align", {points:["cc", "cc"]});
							Y.RedCMS.RedCMSManager.render(body, Y.bind(this._onWidgetsRendered, this));
						}
					},
					context :this
				});
			}, this);
		},
		destructor: function(){
			this._destroyOverlay();
		},

		//	***	Private Methods ***	//
		_destroyOverlay: function() {
			try {
				for (var i=0; i< this._widgets.length;i++) {
					this._widgets[i].destroy();
				}
				this._overlay.destroy();
			} catch(e) {
				// FIXME Need to find a way to destroy overlay without triggering dd error
				//Y.log("OverlayWindow._closeNode.onClick(): Uncaught error destroying plugin host", "error");
			}
		},
		
		_onWidgetsRendered: function(widgets) {
			var onSuccess = Y.bind(this._onSuccess, this),
				onReload = Y.bind(this._onWidgetsRendered, this),
				onSelect = Y.bind(this._onSelect, this),
				i=0;
			for (;i<widgets.length;i++) {
				widgets[i].on("success", onSuccess);
				widgets[i].on("reload", onReload);		
				widgets[i].on("redcms:select", onSelect);					
			}
			this._overlay.getStdModNode(BODY).removeClass(OPENPANELACTIONCLASSES.LOADING);
			
			this._overlay.set("align", {points:["cc", "cc"]});
			this._widgets = widgets;
		},
		_onSelect: function(selectedItem){
			var evt = this.getEvent('redcms:select'),
				hasSubscribers = false, o;
			for (o in evt.subscribers) {
				hasSubscribers = true;
			}
			if (hasSubscribers) {
				this.fire("redcms:select", selectedItem);
				this._destroyOverlay();
			}
		},
		_onSuccess: function(){
			this.fire("success");
			this._destroyOverlay();
		}
	}, {} );
	
	Y.namespace('RedCMS').OpenPanelAction = OpenPanelAction;
	
	
	
	
	BlockReloadOpenPanelAction = Y.Base.create("redcms-blockreloadopenpanelaction", Y.RedCMS.OpenPanelAction, [], {
		//	***	***	//
		_reloadWidget : function() {
			var targetAdmin = this.get(CONTENT_BOX).ancestor(function(n) {
					return (n.getAttribute('redadmin') != '');
				}, true),
				targetAdminWidget = Y.Widget.getByNode(targetAdmin);
				
			Y.RedCMS.RedCMSManager.reloadWidget(targetAdminWidget);
		},
		bindUI : function() {
			BlockReloadOpenPanelAction.superclass.bindUI.apply(this, arguments);
			this.on('success', this._reloadWidget);
		}
	}, {} );
	Y.namespace('RedCMS').BlockReloadOpenPanelAction = BlockReloadOpenPanelAction;

//}, '0.1.1');