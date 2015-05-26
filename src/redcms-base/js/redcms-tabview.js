/* 
 Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
 Code licensed under the BSD License:
 http://redcms.red-agent.comw/license.html
 */

YUI.add('redcms-panel', function(Y) {

	var TabView,
		CONTENT_BOX = 'contentBox';

	TabView = Y.Base.create("redcms-tabview", Y.Widget, [Y.RedCMS.RedCMSWidget], {
		//	***	Instance members ***	//
		CONTENT_TEMPLATE: null,
		//	***	Life cycle methods ***	//
		renderUI: function() {
		},
		destructor: function() {
			this._overlay && this._overlay.destroy();
		}
	});
	Y.RedCMS.TabView = TabView;

}, '0.1.1');
