/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.sourceforge.net/license.html
*/

YUI.add('redcms-action', function(Y) {
	var LoginAction,
		
		CONTENTBOX = 'contentBox',
		BODY = 'body',
		
		CLICK = 'click';

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
						f.subscribe('success', function (args) {
							var ret = Y.JSON.parse(args.response.responseText);
							if (ret.result == 'success') {
								f.get('msgBox').setMessage(Y.RedCMS.MsgBox.CLASSES.success, ret.msg);
								window.location.reload();
							} else {
								f.get('msgBox').setMessage(Y.RedCMS.MsgBox.CLASSES.error, ret.msg);
							}
						});
						f.subscribe('failure', function (args) {
							alert('Form submission failed');
							window.location.reload();
						});
						
						f.render();
					});
				}
			});
		}
	}, {} );
	
	Y.namespace('RedCMS').LoginAction = LoginAction;
}, '0.1.1');