/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*/

YUI.add('redcms-widget', function(Y) {
	 
	function RedCMSWidget() {

	    this.publish("reload", {
	    	 emitFacade: false
	    } );
	    this.publish("success"
	    	//	, { 
	     //   defaultTargetOnly: true,
	    //    defaultFn: this._defAddChildFn 
	   // }
	    );
	}
	
	RedCMSWidget.ATTRS = {
	
	};
	
	RedCMSWidget.prototype = {
	    
	};
	
	Y.namespace('RedCMS').RedCMSWidget = RedCMSWidget;

});
