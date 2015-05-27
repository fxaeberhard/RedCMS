/* 
 RedCMS Form Widget
 
 Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
 Code licensed under the BSD License:
 http://redcms.red-agent.com/license.html
 */

YUI.add('redcms-form', function(Y) {

	var Form, SimpleForm,
		BOUNDING_BOX = 'boundingBox', CONTENTBOX = 'contentBox';

	Form = Y.Base.create('redcms-form', Y.Widget, [Y.RedCMS.RedCMSWidget], {
		// *** Instance members *** //
		_msgBox: null,
		// *** Private methods *** //
		//***	Life cycle methods	***//
		renderUI: function() {
			//Y.log("renderUI", 'info', 'Y.RedCMS.Form');
			var fields = this.get("children"),
				cb = this.get(CONTENTBOX);

			try {
				fields = Y.JSON.parse(Y.RedCMS.RedCMSManager.urldecode(cb.getContent()));
				this.set("children", fields);
				console.log(fields);

				Y.Array.each(fields, function(f) {
					f.type = f.type.replace("Field", "").toLowerCase();
					switch (f.type) {
						case "textarea":
							f.type = "text";
							break;
						case "text":
							f.type = "string";
							break;
						case "editor":
							f.type = "tinymce";
							break;
						case "date":
						case "datepicker":
							if (f.value) {
								var date = f.value.replace(" 00:00:00", "").split("-");
								f.value = date[2] + "/" + date[1] + "/" + date[0];
							}
							break;
					}
				});
			} catch (e) {
				Y.log('Form._parseFields(): Unable to parse form content.', 'log', 'RedCMS.Form');
			}
			cb.setContent('');

			this._msgBox = new Y.RedCMS.MsgBox({visible: false}).render();
			cb.appendChild(this._msgBox.get(BOUNDING_BOX));

			var cfg = {
				type: "form",
				parentEl: cb,
				fields: fields,
				ajax: {
					method: 'POST',
					uri: this.get("action"),
					contentType: "application/x-www-form-urlencoded",
					callback: {
						success: Y.bind(function(tId, o) {
							var ret = Y.JSON.parse(o.responseText);
							if (ret.result === 'success') {
								this.get('msgBox').setMessage(Y.RedCMS.MsgBox.CLASSES.success, ret.msg);
							} else {
								this.get('msgBox').setMessage(Y.RedCMS.MsgBox.CLASSES.error, ret.msg);
							}
							this.fire("success", {response: o});
						}, this),
						failure: function() {
							this.get('msgBox').setMessage(Y.RedCMS.MsgBox.CLASSES.error, 'Error sending form content');
						}
					},
					showMask: true
				},
				buttons: [{
						type: 'submit',
						cssClass: "redcms-submit",
						value: 'Submit'
					}, {
						type: 'submit',
						value: 'Cancel',
						onClick: Y.bind(function() { // e === clickEvent (inputEx.widget.Button custom event)
							this.fire("cancel");
							return false;                                       // stop clickEvent, to prevent form submitting
						}, this)
					}]
			};

			Y.inputEx.use(cfg, Y.bind(function(cfg) {                           // Load form dependencies
				Y.inputEx(cfg);                                                 // Initialize and render form
			}, this, cfg));

			this.get(CONTENTBOX).removeClass('redcms-hidden');
		}
	}, {
		// *** Static *** //
		ATTRS: {
			msgBox: {
				getter: function() {
					return this._msgBox;
				},
				readOnly: true
			},
			children: {},
			action: {},
			method: {}
		}
	});
	Y.namespace('RedCMS').Form = Form;


	SimpleForm = Y.Base.create("redcms-simpleform", Y.Widget, [Y.RedCMS.RedCMSWidget], {
		//	***	Life cycle methods	***	//
		renderUI: function() {
			this.get(CONTENTBOX).one("form").on('submit', Y.bind(function(e) {
				e.halt();

				var f = this.get(CONTENTBOX).one('form');

				Y.io(f.get('action'), {
					method: f.get('method'),
					form: {
						id: f
					},
					on: {
						success: function(id, o, args) {
							Y.log("SimpleForm.onRequestSuccess(): " + o.responseText, 'info');
							//FIXME here we should parse json and handle failure scenario
							this.fire('success');
						}
					},
					context: this
				});
			}, this));
		}
	}, {});
	Y.namespace('RedCMS').SimpleForm = SimpleForm;

});