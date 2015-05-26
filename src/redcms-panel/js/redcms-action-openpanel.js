/* 
 Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
 Code licensed under the BSD License:
 http://redcms.red-agent.comw/license.html
 */

YUI.add('redcms-panel', function(Y) {

	var OpenPanelAction,
		CONTENT_BOX = 'contentBox', BODY = 'body', CLICK = 'click',
		OPENPANELACTIONCLASSES = 'yui3-redcms-loading',
		counter = 0;

	OpenPanelAction = Y.Base.create("redcms-panel", Y.Widget, [Y.RedCMS.RedCMSWidget], {
		//	***	Instance members ***	//
		CONTENT_TEMPLATE: null,
		_overlay: null,
		_widgets: null,
		//	***	Life cycle methods ***	//
		initializer: function() {
			this.publish('submit');
		},
		bindUI: function() {
			var target = this.get(CONTENT_BOX).one('a') || this.get(CONTENT_BOX);
			target.on(CLICK, function(e) {
				e.preventDefault();

				var paramsString = this.get(CONTENT_BOX).getAttribute('params'),
					params = paramsString ? Y.JSON.parse(paramsString) : [];

				this._overlay = new Y.RedCMS.Panel({
					headerContent: target.get("text")
				})
					.render()
					.load(target.getAttribute('href'), params)
					.on("success", function() {
						this.fire(this.get("onSuccessEvent"));
					}, this);
			}, this);
		},
		destructor: function() {
			this._overlay && this._overlay.destroy();
		}
//		_onSelect: function(selectedItem) {
//			var evt = this.getEvent('redcms:select'),
//				hasSubscribers = false, o;
//			for (o in evt.subscribers) {
//				hasSubscribers = true;
//			}
//			if (hasSubscribers) {
//				this.fire("redcms:select", selectedItem);
//				this._overlay.destroy();
//			}
//		}
	}, {
		ATTRS: {
			onSuccessEvent: {
				value: "success"
			}
		}
	});
	Y.RedCMS.OpenPanelAction = Y.RedCMS.OpenPanel = OpenPanelAction;

	var counter = 0;
	Y.RedCMS.Panel = Y.Base.create("panel", Y.Panel, [Y.RedCMS.RedCMSWidget], {
		initializer: function() {
			this.widgets = [];
		},
		load: function(href, params) {
			this.getStdModNode(BODY).addClass(OPENPANELACTIONCLASSES);
			Y.io(href, {//Then request its content to the server
				data: params,
				on: {
					success: function(id, o) {
						var body = this.getStdModNode(BODY);
						body.append(o.responseText);
						Y.RedCMS.RedCMSManager.render(body, Y.bind(this._onWidgetsRendered, this));
					}
				},
				context: this
			});
			return this;
		},
		_onWidgetsRendered: function(widgets) {
			this.getStdModNode(BODY).removeClass(OPENPANELACTIONCLASSES);

			var onSuccess = Y.bind(this._onSuccess, this),
				onReload = Y.bind(this._onWidgetsRendered, this),
				onSelect = Y.bind(this._onSelect, this),
				onCancel = Y.bind(this.destroy, this),
				i = 0;
			for (; i < widgets.length; i++) {
				widgets[i].on("cancel", onCancel);
				widgets[i].on("success", onSuccess);
				widgets[i].on("reload", onReload);
				widgets[i].on("redcms:select", onSelect);
			}
			this.widgets = widgets;
		},
		_onSelect: function(selectedItem) {
			if (Y.Object.size(this.getEvent('redcms:select')._subscribers) > 0) {
				this.fire("redcms:select", selectedItem);
				this.destroy();
			}
		},
		_onSuccess: function() {
			this.fire("success");
			this.destroy();
		},
		destructor: function() {
			Y.Array.each(this.widgets, function(w) {
				w.destroy();
			});
		}
	}, {
		ATTRS: {
			bodyContent: {
				value: ""
			},
			width: {
				value: 900
			},
			x: {
				valueFn: function() {
					return Y.DOM.winWidth() / 2 - 450;
				}
			},
			y: {
				value: 30
			},
			modal: {
				value: true
			},
			zIndex: {
				valueFn: function() {
					counter++;
					return 100 + counter;
				}
			},
			focusOn: {
				value: []
			}
			//hideOn: [{
			//        node: Y.one("document"),
			//        eventName: "key",
			//        keyCode: "esc"
			//    }, {
			//        eventName: 'clickoutside'
			//    }]
		}
	});

}, '0.1.1');
