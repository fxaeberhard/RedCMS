/* 
 Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
 Code licensed under the BSD License:
 http://redcms.red-agent.com/license.html
 */

YUI.add('redcms-action', function(Y) {
	var DeleteAction, RedCMS = Y.namespace('RedCMS'),
		CONTENTBOX = 'contentBox', BODY = 'body', CLICK = 'click';

	/**
	 * Default block
	 */
	RedCMS.Block = Y.Base.create("redcms-block", Y.Widget, [RedCMS.RedCMSWidget], {}, {});

	/**
	 * Delete action
	 */
	DeleteAction = Y.Base.create("redcms-deleteaction", Y.Widget, [RedCMS.RedCMSWidget], {
		CONTENT_TEMPLATE: null,
		bindUI: function() {
			this.get(CONTENTBOX).on(CLICK, function(e) {
				e.preventDefault();
				if (confirm('Are you sure you want to delete this field?')) {

					var cb = this.get(CONTENTBOX),
						paramsLit = cb.getAttribute('params'),
						params = paramsLit ? Y.JSON.parse(paramsLit) : [];

					Y.io(cb.one('a').get('href'), {//Then request its content to the server
						data: params,
						on: {
							success: function() {
								//Y.log("DeleteAction.onRequestSuccess(): "+ o.responseText+ params, 'log');
								this.fire('success');
							}
						},
						context: this
					});
				}
			}, this);
		}
	}, {});
	RedCMS.DeleteAction = DeleteAction;
	RedCMS.DeleteBlockAction = DeleteAction;
	RedCMS.DeleteGroupAction = DeleteAction;
	RedCMS.DeleteUserAction = DeleteAction;

	/**
	 * NewWindowOpenAction
	 */
	RedCMS.NewWindowHrefAction = Y.Base.create("redcms-newwindowrefction", Y.Widget, [RedCMS.RedCMSWidget], {
		CONTENT_TEMPLATE: null,
		bindUI: function() {
			this.get(CONTENTBOX).on(CLICK, function(e) {
				e.preventDefault();
				window.open(this.get(CONTENTBOX).one('a').get('href'), '_blank');//,'_blank','left=10000,screenX=10000');
				//tmpWindow.blur();
				//window.focus();
			}, this);
		}
	}, {});

	/**
	 * HrefAction
	 */
	RedCMS.HrefAction = Y.Base.create("redcms-hrefaction", Y.Widget, [RedCMS.RedCMSWidget], {
		CONTENT_TEMPLATE: null,
		bindUI: function() {
			this.get(CONTENTBOX).on(CLICK, function(e) {
				e.preventDefault();
				window.location = this.get(CONTENTBOX).one('a').get('href');
			}, this);
		}
	}, {});

	/**
	 * ForceDownloadAction
	 */
	RedCMS.AsyncRequestAction = Y.Base.create("redcms-asyncrequestaction", Y.Widget, [RedCMS.RedCMSWidget], {
		CONTENT_TEMPLATE: null,
		bindUI: function() {
			this.get(CONTENTBOX).on(CLICK, function(e) {
				var cb = this.get(CONTENTBOX),
					paramsList = cb.getAttribute('params'),
					params = paramsList ? Y.JSON.parse(paramsList) : [],
					target = cb.one('a') || cb;

				e.preventDefault();

				Y.io(target.getAttribute('href'), {//Then request its content to the server
					data: params,
					on: {
						success: function(id, o) {
							Y.log("AsyncRequestAction.onRequestSuccess(): " + o.responseText + params, 'log');
							this.fire(this.get("fires"));
						}
					},
					context: this
				});
			}, this);
		}
	}, {
		ATTRS: {
			fires: {
				value: "success"
			}
		}
	});

	/**
	 * 
	 */
	RedCMS.LoginAction = Y.Base.create("redcms-loginaction", Y.Widget, [], {
		CONTENT_TEMPLATE: null,
		bindUI: function() {
			this.get(CONTENTBOX).on(CLICK, function() {
				if (RedCMS.Config.loggedIn) {
					Y.io(RedCMS.RedCMSManager.getLink("LoginManager"), {
						method: "POST",
						data: "action=logout",
						on: {
							success: function() {
								window.location = RedCMS.Config.path;		//We reload the page as the login is completed
							}
						}
					});
				} else {
					Y.use('json', 'redcms-form', "redcms-panel", function(Y) {
						/** First create an overlay window widget */
						var panel = new Y.RedCMS.Panel({
							headerContent: 'Login',
							width: 400,
							constrain: true,
							x: Y.DOM.winWidth() / 2 - 200,
							y: 150
						}).render();

						var form, form2,
							showLoginForm = function() {
								/** Then fill it with a custom form */
								form = new RedCMS.Form({
									method: 'POST',
									action: RedCMS.RedCMSManager.getLink("LoginManager"),
									blockType: "form",
									children: [
										{name: "lusername", required: true, label: "User", size: 20, typeInvite: "username or e-mail", showMsg: false},
										{name: "lpassword", type: 'password', required: true, label: "Password", size: 20, showMsg: false},
										{name: "action", type: 'hidden', value: 'login'},
										{name: 'rememberme', type: 'boolean', label: ".", rightLabel: 'Remember me', value: true}
									],
									on: {
										success: function() {
											window.location.reload();
										},
										cancel: function() {
											form.destroy();
											panel.destroy();
										},
										loaded: function() {
											panel.getStdModNode(BODY).one("fieldset").insert('<a href="#" class="login-resetpassword" style="display:block;padding:10px 0 10px 117px;">Mot de passe oublié?</a>');
										}
									}
								}).render(panel.getStdModNode(BODY));
							},
							showResetForm = function() {
								form.destroy();
								form2 = new RedCMS.Form({
									action: RedCMS.RedCMSManager.getLink("LoginManager"),
									children: [
										{name: "lmail", required: true, label: "Your mail", typeInvite: "a new password will be sent", size: 28, showMessage: false},
										{name: "action", type: 'hidden', value: 'resetpassword'}
									],
									on: {
										success: function() {
											panel.getStdModNode(BODY).one(".inputEx-Group").hide();
										},
										cancel: function() {
											form2.destroy();
											panel.destroy();
										}
									}
								}).render(panel.getStdModNode(BODY));
							};

						showLoginForm();
						panel.getStdModNode(BODY).delegate("click", showResetForm, ".login-resetpassword");
					});
				}
			});
		}
	});
}, '0.1.1');
