

 YUI.add('redcms-form-editor', function(Y) {
	
	 var CONTENTBOX = 'contentBox';
	 
	 Y.EditorField = Y.Base.create('editor-field', Y.TextareaField, [], {
		
		_editor: null,
		
		_renderFieldNode : function () {
			
			Y.EditorField.superclass._renderFieldNode.apply(this);
			
			Y.use('yui2-editor', Y.bind( function(Y) {
				var YAHOO = Y.YUI2;
				//this = that;
				console.log("inside", this, this._fieldNode);
				var editor = new YAHOO.widget.Editor(this._fieldNode._node, {
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
		},
	/*	bindUI : function () {
			this._fieldNode.on('change', Y.bind(function (e) {
				this.set('value', this._fieldNode.get('value'), {src : 'ui'});
				this.fire('change', e);
			}, this));
			
			this.on('valueChange', Y.bind(function (e) {
				if (e.src != 'ui') {
					this._fieldNode.set('value', e.newVal);
				}			
			}, this));

			this._fieldNode.on('blur', Y.bind(function (e) {
				this.set('value', this._fieldNode.get('value'), {src : 'ui'});
				this.fire('blur', e);
			}, this));

			this._fieldNode.on('focus', Y.bind(function(e) {
				this.fire('focus', e);
			}, this));
			
			this.on('errorChange', Y.bind(function (e) {
				if (e.newVal) {
					this._showError(e.newVal);
				} else {
					this._clearError();
				}
			}, this));

			this.on('validateInlineChange', Y.bind(function (e) {
				if (e.newVal === true) {
					this._enableInlineValidation();
				} else {
					this._disableInlineValidation();
				}
			}, this));
			
			this.on('disabledChange', Y.bind(function (e) {
			    this._syncDisabled();
			}, this));
		},*/
	/*	_renderFieldNode : function () {
			console.log("mmmm", this);
			
			var contentBox = this.get('contentBox'),
	            field = contentBox.one('#' + this.get('id'));
	                
	        if (!field) {
	            field = Y.Node.create(Y.TextareaField.NODE_TEMPLATE);
	            field.setAttrs({
	                name : this.get('name'), 
	                innerHTML : this.get('value')
	            });
	            contentBox.appendChild(field);
	        }
	
			field.setAttribute('tabindex', Y.FormField.tabIndex);
			Y.FormField.tabIndex++;
	        
	        this._fieldNode = field;
	    }*/
	}, {
	   // NODE_TEMPLATE : '<textarea></textarea>'
	});
	
 });
