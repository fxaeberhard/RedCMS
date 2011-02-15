/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.sourceforge.net/license.html
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

	OpenPanelAction = Y.Base.create("redcms-openpanelaction", Y.Widget, [], {
		initializer : function (config) {
			this.publish('submit');
		},
		bindUI : function() {
			console.log("mm", this);
			this.get(CONTENTBOX).on(CLICK, function(e) {
				var overlay = new Y.Overlay({												// First create an overlay window widget
					bodyContent : '<div></div>',
					headerContent : this.get(CONTENTBOX).one('a').getContent(),
					//width       : '600px',
					//height		: '100px',
					zIndex      : 100,
					constrain   : true,
					render      : true,
					visible     : true,
					plugins     : [
						{ fn: Y.Plugin.OverlayWindow },
						{ fn: Y.Plugin.Drag}
					]
				});
				overlay.getStdModNode(BODY).addClass(CLASSES.LOADING);
				//overlay.get(CONTENTBOX).plug( Y.Plugin.Resize );
				
				
				overlay.after('render', function(e) {
				console.log(this.getStdModNode(BODY));
					var resize = new Y.Resize({
						node: this.getStdModNode(BODY)
						//node: this.get(BOUNDINGBOX)
						//node: overlay.getStdModNode(BODY)
					});
					//Get the bounding box node and plug
					//this.get('boundingBox').plug(Y.Plugin.Drag, {
                  //Set the handle to the header element.
					//	handles: ['.yui-widget-hd']
					//});
				});
				
				var request = Y.io('test2.html', {		//Then request its content to the server
					method: "POST",
					data: "action=logout",
					on: {
						success: function(id, o, args) {
							console.log(id, o, args);
						},
						complete: function(id, o, args) {
							var body = this.getStdModNode(BODY);
							//body.setContent(o.responseText);
							body.append(o.responseText);
							body.removeClass(CLASSES.LOADING);
							
							Y.RedCMS.RedCMSManager.render(body);
						}

					},
					context :overlay
				});
			}, this);
		}
	}, {} );
	
	Y.namespace('RedCMS').OpenPanelAction = OpenPanelAction;
}, '0.1.1');