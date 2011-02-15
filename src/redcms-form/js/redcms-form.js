/* 
RedCMS Form Widget

Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.sourceforge.net/license.html
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
				
			if (form) {
				fields = Y.JSON.parse(form.getContent());
				form.setContent('');
			}
			return fields;
		},
		
		//	***	Life cycle methods	***	//
		renderUI : function () {
			Y.log("renderUI", 'info', 'Y.RedCMS.Form');
			_msgBox = new Y.RedCMS.MsgBox({visible:false});
			_msgBox.render();
			
			this.get(CONTENT_BOX).appendChild(_msgBox.get(BOUNDING_BOX)); 
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

				console.log(LABEL_BOUNDINGBOX_TEMPLATE)
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

 });