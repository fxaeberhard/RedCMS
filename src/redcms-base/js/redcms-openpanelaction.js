/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.comw/license.html
*/

YUI.add('redcms-openpanelaction', function(Y) {
	var OpenPanelAction,
		
		CONTENTBOX = 'contentBox',
		BOUNDINGBOX = 'boundingBox',
		BODY = 'body',
		
		CLICK = 'click',
		
		CLASSES = {
			LOADING : 'yui3-redcms-loading',
		};
	

	OpenPanelAction = Y.Base.create("redcms-openpanelaction", Y.Widget, [Y.RedCMS.RedCMSWidget], {
		//	***	***	//
		_overlay: null,
		
		//	***	***	//
		initializer : function (config) {
			this.publish('submit');
		},
		bindUI : function() {
			this.get(CONTENTBOX).one('a').on(CLICK, function(e) {

				e.preventDefault();
				
				var cb = this.get(CONTENTBOX),
					overlay = new Y.Overlay({												// First create an overlay window widget
						bodyContent : '<div></div>',
						headerContent : cb.one('a').getContent(),
						zIndex      : 100,
						constrain   : true,
						render      : true,
						visible     : true,
				        align : {
				            node: "body",
				            points: ["tc", "tc"]
				        },
						plugins     : [
							{ fn: Y.Plugin.OverlayWindow },
							{ fn: Y.Plugin.Drag}
						]
					});
				overlay.getStdModNode(BODY).addClass(CLASSES.LOADING);
				this._overlay = overlay;
				
				overlay.after('render', function(e) {
					var resize = new Y.Resize({
						node: this.getStdModNode(BODY),
						handles: ['b', 'r', 'br', 'bl']
					});
				});
				
				var params = new Array(),
					paramsLit = cb.getAttribute('params');
				if (paramsLit) params = Y.JSON.parse(paramsLit);
				//console.log("OpenPanelAction.bindUI():", this, cb, cb.getAttribute('params'));
				
				var request = Y.io(cb.one('a').get('href'), {		//Then request its content to the server
					data: params,
					on: {
						success: function(id, o, args) {
						//	console.log("OpenPanelAction.onRequestSuccess(): ", o.responseText)
							var body = this._overlay.getStdModNode(BODY);
							body.append(o.responseText);
							body.removeClass(CLASSES.LOADING);
							
							Y.RedCMS.RedCMSManager.render(body, Y.bind(this._onWidgetsRendered, this));
						}
					},
					context :this
				});
			}, this);
		},
		_onWidgetsRendered: function(widgets) {
			//console.log("OpenPanelAction._onWidgetsRendered()", widgets, arguments);
			var onSuccess = Y.bind(this._onSuccess, this),
				onReload = Y.bind(this._onWidgetsRendered, this);
			for (var i=0;i<widgets.length;i++) {
				widgets[i].on("success", onSuccess);
				widgets[i].on("reload", onReload);					
			}
		},
		_onSuccess: function(){
			this.fire("success");

			try {
				this._overlay.destroy();
			} catch(e) {
				// FIXME Need to find a way to destroy overlay without triggering dd error
				//Y.log("OverlayWindow._closeNode.onClick(): Uncaught error destroying plugin host", "error");
			}
		}
	}, {} );
	
	Y.namespace('RedCMS').OpenPanelAction = OpenPanelAction;
}, '0.1.1');