/* 
RedCMS Form Widget

Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*/

 YUI.add('redcms-form', function(Y) {
	 
	var Form,
	
		HOST = 'host',
		BOUNDING_BOX = 'boundingBox',
		CONTENT_BOX = 'contentBox',
		
		FORM = 'form',
		LABEL = 'label',
		INVALID = 'invalid',
		INPUT = 'input',
		
		LABEL_BOUNDINGBOX_TEMPLATE = '<div ></div>',
		
		getCN = Y.ClassNameManager.getClassName,
		
		CLASSES = {
			invalid	: getCN(FORM, INVALID),
			label : getCN(FORM, LABEL),
			input : getCN(FORM, INPUT)
		},
	
	Form = Y.Base.create('redcms-form', Y.Form, [ Y.RedCMS.RedCMSWidget ], {
		// *** Instance members *** //
		_msgBox : null,
		
		// *** Private methods *** //
		_getMsgBox : function() {
			return _msgBox;
		},
		/**
		 * Overriden to use json parser as default action
		 *
		 * @method 	
		 * @private
		 * @param {Y.Node} contentBox
		 * @description Sets the 'fields' attribute based on parsed HTML
		 */
		_parseFields : function (contentBox) {		
			var fields = [];
			try {
				fields = Y.JSON.parse(contentBox.getContent());
				contentBox.setContent('');
			} catch (e) { 
				Y.log('_parseFields():Unable to parse form content.', 'log', 'RedCMS.Form');
			};
			return fields;
		},
		
		submit : function () {
			this.fire('submit');
			Y.RedCMS.Form.superclass.submit.apply(this);
		},
		
		//	***	Life cycle methods	***	//
		
		renderUI : function () {
			//Y.log("renderUI", 'info', 'Y.RedCMS.Form');
			_msgBox = new Y.RedCMS.MsgBox({visible:false});
			_msgBox.render();
			this.get(CONTENT_BOX).appendChild(_msgBox.get(BOUNDING_BOX)); 
			this.on('complete', function (args) {
				var ret = Y.JSON.parse(args.response.responseText);
				if (ret.result == 'success') {
					this.get('msgBox').setMessage(Y.RedCMS.MsgBox.CLASSES.success, ret.msg);
				} else {
					this.get('msgBox').setMessage(Y.RedCMS.MsgBox.CLASSES.error, ret.msg);
				}
			});
			this.on('failure', function (args) {
				this.get('msgBox').setMessage(Y.RedCMS.MsgBox.CLASSES.error, 'Error sending form content');
			});
			this.after('render', function(){
				this.set('resetAfterSubmit', false);
				this.get(CONTENT_BOX).setStyle('display', 'block');
				this.set('validateInline', true);								// In RedCMS inline validation is activated by default
				this.each(function (f) {										// We loop through the fields to see if one is a FileField,
					if (f instanceof Y.FileField){
						this.set('encodingType', Y.Form.MULTIPART_ENCODED);		// which requires multipart encoding
						this.on('complete', function(){
							this.fire('success');
						});
					}
				}, this);
			});
		}
	}, {

		// *** Static *** //
		
		//NAME : REDCMS_FORM,
		
		//NS : FORM,
		
		//CLASSES : CLASSES
		ATTRS : {
			msgBox : {
				getter		: '_getMsgBox',
				readOnly	: true
			}
		}
	});
	
	Y.namespace('RedCMS').Form = Form;
	
	// *** HACK: use our custom implementation on top of the original one. *** //	
	Y.RedCMS.FormField = function() {
	    return {
	    	LABEL_BOUNDINGBOX_TEMPLATE : '<div />',
	        CLASSES : CLASSES,

			ATTRS : {
				redid : {
					validator : Y.Lang.isNumber,
					writeOnce : true
				}
			}
	    }
	};

	Y.RedCMS.FormField.prototype =  {
		/**
		 * This method is overriden to
		 * + add a bounding box for better styling
		 * 
		 * TODO: the label is not handled by the HTML_PARSER yet
		 * 
		 * @method _renderLabelNode
		 * @protected
		 * @description Draws the form field's label node into the contentBox
		 */
		_renderLabelNode : function () {
			var contentBox = this.get('contentBox'),
				labelNode = contentBox.one('label'),
				labelBoundingBox;
			
			if (!labelNode || labelNode.get('for') != this.get('id')) {

				labelBoundingBox = Y.Node.create(LABEL_BOUNDINGBOX_TEMPLATE);
				labelBoundingBox.addClass(CLASSES.label);
				labelBoundingBox.addClass('yui3-u');
				contentBox.addClass('yui3-g');
				contentBox.setAttribute('redid', this.get('redid') );
				contentBox.setAttribute('widget', 'FormField' );
				contentBox.appendChild(labelBoundingBox);
				
				labelNode = Y.Node.create(Y.FormField.LABEL_TEMPLATE);
				labelBoundingBox.appendChild(labelNode);

				labelBoundingBox.destroy();			//Prevents memory leaks
			}
			
			this._labelNode = labelNode;	 
		},
		_syncLabelNode : function () {
			if (this._labelNode) {
				prefix = (this.get('required'))?'*':'';
				this._labelNode.setAttrs({
					innerHTML : prefix+this.get('label')+':'
				});
				this._labelNode.setAttribute('for', this.get('id') + Y.FormField.FIELD_ID_SUFFIX);
			}
		},
		/**
		 * @method _renderFieldNode
		 * @protected
		 * @description Draws the field node into the contentBox
		 */
		_renderFieldNode : function () {
			var contentBox = this.get('contentBox'),
				field = contentBox.one('#' + this.get('id')),
				fieldBoundingBox;
					
			if (!field) {

				fieldBoundingBox = Y.Node.create(LABEL_BOUNDINGBOX_TEMPLATE);
				fieldBoundingBox.addClass(CLASSES.input);
				fieldBoundingBox.addClass('yui3-u');
				contentBox.appendChild(fieldBoundingBox);
				
				field = Y.Node.create(Y.FormField.INPUT_TEMPLATE);
				fieldBoundingBox.appendChild(field);
			}

			this._fieldNode = field;
		},
		/**
		 * 
		 * This method is overriden to
		 * + place the error node as a last child
		 * + add error class on the label
		 * 
		 * @method _showError
		 * @param {String} errMsg
		 * @private
		 * @description Adds an error node with the supplied message
		 */
		_showError : function (errMsg) {
			var contentBox = this.get(CONTENT_BOX),
				errorNode = Y.Node.create('<span>' + errMsg + '</span>');
			
			errorNode.addClass('error');
			contentBox.append(errorNode);

			this._errorNode = errorNode;
			
			contentBox.addClass(CLASSES.invalid)
		},
		/** 
		 *  This method is overriden 
		 * + remove error class on the label
		 * 
		 * @method _clearError
		 * @private
		 * @description Removes the error node from this field
		 */
		_clearError : function () {
			if (this._errorNode) {
				var contentBox = this.get(CONTENT_BOX);
						
				contentBox.removeChild(this._errorNode);
				this._errorNode = null;
				
				contentBox.removeClass(CLASSES.invalid)
			}
		},
	};
	Y.mix(Y.FormField, Y.RedCMS.FormField(), true, [], 0, true);
	Y.augment(Y.FormField, Y.RedCMS.FormField, true);
	Y.ChoiceField.prototype._renderLabelNode = Y.RedCMS.FormField.prototype._renderLabelNode;
	
	Y.TextareaField.prototype._renderFieldNode = function () {
	        var contentBox = this.get('contentBox'),
	            field = contentBox.one('#' + this.get('id'));
	                
	        if (!field) {
				fieldBoundingBox = Y.Node.create(LABEL_BOUNDINGBOX_TEMPLATE);
				fieldBoundingBox.addClass(CLASSES.input);
				fieldBoundingBox.addClass('yui3-u');
				contentBox.appendChild(fieldBoundingBox);
				contentBox.setAttribute('redid', this.get('redid') );
	        	
	            field = Y.Node.create(Y.TextareaField.NODE_TEMPLATE);
	            field.setAttrs({
	                name : this.get('name'), 
	                innerHTML : this.get('value')
	            });
	            fieldBoundingBox.appendChild(field);
	        }

			field.setAttribute('tabindex', Y.FormField.tabIndex);
			Y.FormField.tabIndex++;
	        
	        this._fieldNode = field;
	    }
	
	
	/*: function () {
        var contentBox = this.get('contentBox'),
            titleNode = Y.Node.create('<span></span>');
        
        titleNode.set('innerHTML', this.get('label'));
        contentBox.appendChild(titleNode);
        
        this._labelNode = titleNode;
    },*/
	
	/*
	Y.RedCMS.CheckboxField = function(){ return {};};
	Y.RedCMS.CheckboxField.prototype = {
		_syncChecked : function () {
			this._fieldNode.set('checked', this.get('checked'));
			this.set('value', String(this.get('checked')));
		},

		initializer : function () {
			Y.CheckboxField.superclass.initializer.apply(this, arguments);
		},

		syncUI : function () {
			Y.CheckboxField.superclass.syncUI.apply(this, arguments);
			this._syncChecked();
		},

		bindUI :function () {
			Y.CheckboxField.superclass.bindUI.apply(this, arguments);
			this.after('checkedChange', Y.bind(function(e) {
				if (e.src != 'ui') {
					this._fieldNode.set('checked', e.newVal);
					this._fieldNode.set('value', String(e.newVal));
				}
			}, this));

			this._fieldNode.after('change', Y.bind(function (e) {
				//console.log("newVal", e.currentTarget.get('checked'),  String(e.currentTarget.get('checked')));
				this.set('checked', e.currentTarget.get('checked'), {src : 'ui'});
				this.set('value', String(e.currentTarget.get('checked')));
			}, this));
		}
			
	};
	Y.augment(Y.CheckboxField, Y.RedCMS.CheckboxField, true);
	*/
	var SimpleForm;
	
	SimpleForm = Y.Base.create("redcms-simpleform", Y.Widget, [ ], {

		//	***	Life cycle methods	***	//
		renderUI: function() {
			this.get(CONTENT_BOX).one("form").on('submit', Y.bind( function(e) {
				e.halt();
				//e.preventDefault();
				//console.log(e, e.target);
				
				var f = this.get(CONTENT_BOX).one('form');

				Y.io(f.get('action'), {
					method : f.get('method'),
					form : {
						id : f
					},
					on: {
						success: function(id, o, args) {
							Y.log("SimpleForm.onRequestSuccess(): "+ o.responseText, 'info');
							//FIXME here we should handle failure scenario
							this.fire('success');
						}
					},
					context :this
				})
			}, this));
		}
	}, {} );
	Y.namespace('RedCMS').SimpleForm = SimpleForm;
	
});