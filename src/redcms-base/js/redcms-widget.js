/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*/

//YUI.add('redcms-widget', function(Y) {
	 
	function RedCMSWidget() {

		this.publish("redcms:select", {
			emitFacade: false
		});
		this.publish("reload", {
			emitFacade: false
		});
		this.publish("success"
			//	, { 
			//   defaultTargetOnly: true,
			//    defaultFn: this._defAddChildFn 
			// }
		);
	}
	
	/*RedCMSWidget.ATTRS = {
	
	};*/
	
	RedCMSWidget.prototype = {
		_overlay: null,
		
		hideReloadOverlay: function(){
			this._overlay.hide();
		},
	
		showReloadOverlay: function(){
			var bb = this.get('boundingBox');

			if (!this._overlay) {
				this._overlay = Y.Node.create('<div class="yui3-redcms-loading-overlay"><div></div></div>');
				bb.prepend(this._overlay);
			}
			this._overlay.one('div').setStyle('height', bb.getComputedStyle('height'));
			this._overlay.show();
		}
	};

	Y.namespace('RedCMS').RedCMSWidget = RedCMSWidget;
//});
