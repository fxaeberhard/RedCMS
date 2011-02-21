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
		
		LABEL_BOUNDINGBOX_TEMPLATE = '<div />',
		
		getCN = Y.ClassNameManager.getClassName,
		
		CLASSES = {
			invalid	: getCN(FORM, INVALID),
			label : getCN(FORM, LABEL)
		}
		
	Form = Y.Base.create('redcms-form', Y.Form, [ ], {
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
			var form = contentBox.one('form'),
				fields = [];
			try {
				fields = Y.JSON.parse(contentBox.getContent());
				contentBox.setContent('');
			} catch (e) { 
				Y.log('unreported error', 'error', 'RedCMS.Form') 
			};
			return fields;
		},
		
		/**
		 * @method submit
		 * @description Submits the form using the defined method to the URL defined in the action
		 */
		submit : function () {
			if (this.get('skipValidationBeforeSubmit') === true || this._runValidation()) {
				var formAction = this.get('action'),
					formMethod = this.get('method'),
					submitViaIO = this.get('submitViaIO'),
					transaction, cfg;

				if (submitViaIO === true) {
					console.log("submit!!", this.get('encodingType'));
					cfg = {
						method : formMethod,
						form : {
							id : this.get('contentBox'),
							upload : (this.get('encodingType') === Y.Form.MULTIPART_ENCODED),
							useDisabled : true
						}
					};
		            
					transaction = Y.io(formAction, cfg);
					this._ioIds[transaction.id] = transaction;
				} else {
					this.get('contentBox').submit();
				}
			}
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
				this.set('encodingType', Y.Form.MULTIPART_ENCODED);
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
	        CLASSES : CLASSES
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
				labelNode = contentBox.one('label');
			
			if (!labelNode || labelNode.get('for') != this.get('id')) {

				labelBoundingBox = Y.Node.create(LABEL_BOUNDINGBOX_TEMPLATE);
				labelBoundingBox.addClass(CLASSES.label);
				contentBox.appendChild(labelBoundingBox);
				
				labelNode = Y.Node.create(Y.FormField.LABEL_TEMPLATE);
				labelBoundingBox.appendChild(labelNode);

				labelBoundingBox.destroy();			//Prevents memory leaks
			}
			
			this._labelNode = labelNode;	 
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
	
	Y.mix(Y.FormField, Y.RedCMS.FormField);
	Y.augment(Y.FormField, Y.RedCMS.FormField, true);
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
 });