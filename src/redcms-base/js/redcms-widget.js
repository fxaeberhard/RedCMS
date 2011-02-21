/**
 * 
 */

YUI.add('redcms-widget', function(Y) {
	 
	function RedCMSWidget(config) {
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
