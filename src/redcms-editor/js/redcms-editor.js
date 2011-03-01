/* 
RedCMS Editor Widget

Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*/

 YUI.add('redcms-editor', function(Y) {
	 
	var YAHOO = Y.YUI2,
		Editor,
	
		HOST = 'host',
		BOUNDINGBOX = 'boundingBox',
		CONTENTBOX = 'contentBox',
		
		//FORM = 'form',
		//LABEL = 'label',
		//INVALID = 'invalid',
		//INPUT = 'input',
		
		LABEL_BOUNDINGBOX_TEMPLATE = '<div ></div>',
		
		getCN = Y.ClassNameManager.getClassName,
		
		CLASSES = {
			//invalid	: getCN(FORM, INVALID),
			//label : getCN(FORM, LABEL),
			//input : getCN(FORM, INPUT)
		};
	
	console.log("YUI.EDITOR", YAHOO.widget.Editor);
	
	var editor = new YAHOO.widget.Editor('myEditor', {
		//dompath: true,
		//height: '400px',
		//width: '100%',
		//animate: true, 
		//dompath: true,
		//autoHeight: true,
		//extracss:'p {margin:0} '+
		//' .yui-media { height: 240px; width: 410px; border: 1px solid black; background-color: #f2f2f2; background-image: url('+redcms.path+'modules/src/base/assets/sprite-video.png); background-position: center; background-repeat: no-repeat; }'+
		//' .yui-media * { display:none; }'
	});
	editor.render();
	//Y.namespace('RedCMS').SimpleForm = SimpleForm;
	
});