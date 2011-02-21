/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*/

YUI.add('redcms-action', function(Y) {
	var LoginAction,
		DeleteAction,
		CONTENTBOX = 'contentBox',
		BODY = 'body',
		
		CLICK = 'click';

	DeleteAction = Y.Base.create("redcms-deleteaction", Y.Widget, [Y.RedCMS.RedCMSWidget], {
		bindUI : function() {
			this.get(CONTENTBOX).on(CLICK, function(e) {
				e.preventDefault();
				if (confirm('Are you sure you want to delete this field?')) {

					var params = new Array(),
						cb = this.get(CONTENTBOX),
						paramsLit = cb.getAttribute('params');
					if (paramsLit) params = Y.JSON.parse(paramsLit);
					
					var request = Y.io(cb.one('a').get('href'), {		//Then request its content to the server
						data: params,
						on: {
							success: function(id, o, args) {
								Y.log("DeleteAction.onRequestSuccess(): "+ o.responseText+ params, 'log');
								this.fire('success');
							}
						},
						context :this
					});
				}
			}, this);
		}
	}, {} );
	
	Y.namespace('RedCMS').DeleteAction = DeleteAction;
	
	LoginAction = Y.Base.create("redcms-loginaction", Y.Widget, [], {
		bindUI : function() {
			this.get(CONTENTBOX).on(CLICK, function(e) {
				if ( Y.RedCMS.Config.loggedIn) {
					Y.use('io-base', function(Y) {
						var request = Y.io(Y.RedCMS.RedCMSManager.getLink("LoginManager"), {
							method: "POST",
							data: "action=logout",
							on: {
								success: function(id, o, args) {
									window.location.reload();									//We reload the page as the login is completed
								}
							}
						});
					});
				} else {
					Y.use('overlay', 'widget-anim', 'json', 'gallery-overlay-extras', 'redcms-overlay-window', 'redcms-form', function(Y){
						
						/** First create an overlay window widget */
						var overlay = new Y.Overlay({
							bodyContent : '<div></div>',
							headerContent : 'Login',
							width       : '400px',
							zIndex      : 100,
							centered    : true,
							constrain   : true,
							render      : true,
							visible     : true,
							plugins     : [
								{ fn: Y.Plugin.OverlayModal },
								{ fn: Y.Plugin.OverlayKeepaligned },
								{ fn: Y.Plugin.OverlayWindow }
							]
						});
						/** Then fill it with a custom form */
						var f = new Y.RedCMS.Form({
							boundingBox: overlay.getStdModNode(BODY).one('div'),
							action : Y.RedCMS.RedCMSManager.getLink("LoginManager"),
							method : 'post',
							inlineValidation : true,
							children : [
								{name : "username", required : true, label : "User name"},
								{name : "password", type : 'PasswordField', required : true, label : "Password"},
								{name : "action", type : 'HiddenField', value: 'login'},
								//{name : 'rememberme', type : 'CheckboxField', label : 'Remember me'},
								{name : 'submit', type : 'SubmitButton', value : 'Submit'}
								]
						});
						f.on('success', function (args) {
							var ret = Y.JSON.parse(args.response.responseText);
							if (ret.result == 'success') {
								window.location.reload();
							}
						});
						f.render();
					});
				}
			});
		}
	}, {} );
	
	Y.namespace('RedCMS').LoginAction = LoginAction;
}, '0.1.1');