/* 
RedCMS Form Editor Field

Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*/

//YUI.add('redcms-form-editor', function(Y) {
	
	Y.EditorField = Y.Base.create('editor-field', Y.TextareaField, [], {
		
		_editor: null,
		
		_renderFieldNode : function () {
			
			Y.EditorField.superclass._renderFieldNode.apply(this);
			
			Y.use('yui2-editor', Y.bind( function(Y) {
				var YAHOO = Y.YUI2,
					editor = new YAHOO.widget.Editor(this._fieldNode._node, {
					//dompath: true,
					height: '200px',
					width: '98%',
					animate: true, 
					autoHeight: true,
					filterWord: true
					//extracss:'p {margin:0} '+
					//' .yui-media { height: 240px; width: 410px; border: 1px solid black; background-color: #f2f2f2; background-image: url('+redcms.path+'modules/src/base/assets/sprite-video.png); background-position: center; background-repeat: no-repeat; }'+
					//' .yui-media * { display:none; }'
				});
				editor.render();
				
				
				this.get("parent").on('submit', function(e) {
					this._editor.saveHTML();
				}, this);
				
				this._editor = editor;
			}, this));
		}
	}, {
	});
	
 //});
