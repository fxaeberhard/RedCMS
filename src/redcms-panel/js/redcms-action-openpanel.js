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

				var cb = this.get(CONTENT_BOX),
					paramsString = cb.getAttribute('params'),
					params = paramsString ? Y.JSON.parse(paramsString) : [];

				this._overlay = new Y.Panel({
					headerContent: target.get("text"),
					bodyContent: "",
					width: 900,
					x: Y.DOM.winWidth() / 2 - 450,
					y: 30,
					modal: true,
					zIndex: 100 + counter,
					focusOn: []
						//hideOn: [{
						//        node: Y.one("document"),
						//        eventName: "key",
						//        keyCode: "esc"
						//    }, {
						//        eventName: 'clickoutside'
						//    }]
				}).render();
				counter++;

				this._overlay.getStdModNode(BODY).addClass(OPENPANELACTIONCLASSES);

				//console.log("OpenPanelAction.bindUI():", this, cb, cb.getAttribute('params'));

				Y.io(target.getAttribute('href'), {//Then request its content to the server
					data: params,
					on: {
						success: function(id, o) {
							var body = this._overlay.getStdModNode(BODY);
							body.append(o.responseText);
							Y.RedCMS.RedCMSManager.render(body, Y.bind(this._onWidgetsRendered, this));
						}
					},
					context: this
				});
			}, this);
		},
		destructor: function() {
			this._destroyOverlay();
		},
		_destroyOverlay: function() {
			try {
				for (var i = 0; i < this._widgets.length; i++) {
					this._widgets[i].destroy();
				}
				this._overlay.destroy();
			} catch (e) {
				// FIXME Need to find a way to destroy overlay without triggering dd error
				//Y.log("OverlayWindow._closeNode.onClick(): Uncaught error destroying plugin host", "error");
			}
		},
		_onWidgetsRendered: function(widgets) {
			var onSuccess = Y.bind(this._onSuccess, this),
				onReload = Y.bind(this._onWidgetsRendered, this),
				onSelect = Y.bind(this._onSelect, this),
				onCancel = Y.bind(this._destroyOverlay, this),
				i = 0;
			for (; i < widgets.length; i++) {
				widgets[i].on("cancel", onCancel);
				widgets[i].on("success", onSuccess);
				widgets[i].on("reload", onReload);
				widgets[i].on("redcms:select", onSelect);
			}
			this._overlay.getStdModNode(BODY).removeClass(OPENPANELACTIONCLASSES);

			this._widgets = widgets;
		},
		_onSelect: function(selectedItem) {
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
		_onSuccess: function() {
			this.fire(this.get("onSuccessEvent"));
			this._destroyOverlay();
		}
	}, {
		ATTRS: {
			onSuccessEvent: {
				value: "success"
			}
		}
	});
	Y.namespace('RedCMS').OpenPanelAction = OpenPanelAction;

}, '0.1.1');
