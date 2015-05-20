/** 
 * Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
 * Code licensed under the BSD License:
 * http://redcms.red-agent.com/license.html
 */

YUI.add('redcms-accordion', function(Y) {
	var Accordion,
		CONTENT_BOX = 'contentBox',  ACCORDION = 'redcms-accordion',
		TITLE = 'title', ITEM = 'item', TOGGLED = 'toggled',
		getCN = Y.ClassNameManager.getClassName,
		CLASSES = {
			title: getCN(ACCORDION, TITLE),
			item: getCN(ACCORDION, ITEM),
			toggled: getCN(ACCORDION, TOGGLED)
		};

	Accordion = Y.Base.create("redcms-accordion", Y.Widget, [Y.RedCMS.RedCMSWidget], {
		_accordion: null,
		_currentOpenedNode: null,
		_closeNode: function(n) {
			var tn = n.next('.' + CLASSES.item);
			tn.transition({
				duration: 0.3,
				easing: 'ease-in',
				height: 0
			});
			n.removeClass(CLASSES.toggled);
		},
		_showNode: function(n) {
			var tn = n.next('.' + CLASSES.item);
			tn.transition({
				duration: 0.3,
				easing: 'ease-in',
				height: tn.one('div').getComputedStyle('height')
			});
			n.addClass(CLASSES.toggled);
		},
		_onTitleClicked: function(e) {
			if (e.currentTarget.hasClass(CLASSES.toggled)) {
				this._closeNode(e.currentTarget);
			} else {
				if (this._currentOpenedNode && this._currentOpenedNode != e.currentTarget) {
					this._closeNode(this._currentOpenedNode);
				}
				this._showNode(e.currentTarget);
				this._currentOpenedNode = e.currentTarget;
			}
		},
		renderUI: function() {
			this.get(CONTENT_BOX).delegate('click', this._onTitleClicked, '.' + CLASSES.title, this);
		}
	});

	Y.namespace('RedCMS').Accordion = Accordion;
}, '0.1.1');
