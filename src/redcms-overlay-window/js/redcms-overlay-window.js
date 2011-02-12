/* 
Overlay Window Plugin

Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.sourceforge.net/license.html
*/

 YUI.add('redcms-overlay-window', function(Y) {
	 
	var OverlayWindow,
		OVERLAY_WINDOW = 'overlayWindow',
		
		HOST = 'host',
		BOUNDING_BOX = 'boundingBox',
		
		OVERLAY = 'overlay',
		WINDOW = 'window',
		CLOSE = 'close',
		
		getCN = Y.ClassNameManager.getClassName,
		
		CLASSES = {
			window	: getCN(OVERLAY, WINDOW),
			close	: getCN(OVERLAY, CLOSE)
		};
		
	// *** Constructor *** //
	
	OverlayWindow = function (config) {
		
		OverlayWindow.superclass.constructor.apply(this, arguments);
	};
	
	// *** Static *** //
	
	Y.mix(OverlayWindow, {
		
		NAME : OVERLAY_WINDOW,
		
		NS : WINDOW,
		
		CLASSES : CLASSES
		
	});
	
	// *** Prototype *** //
	
	Y.extend(OverlayWindow, Y.Plugin.Base, {
		
		// *** Instance Members *** //
		_closeNode : null,
		
		// *** Lifecycle Methods *** //
		
		initializer : function (config) {
			
			this.doAfter('renderUI', this.renderUI);
			this.doAfter('bindUI', this.bindUI);
			this.doAfter('syncUI', this.syncUI);
			
			if (this.get(HOST).get('rendered')) {
				this.renderUI();
				this.bindUI();
				this.syncUI();
			}
		},
		
		destructor : function () {
			this.get(HOST).get(BOUNDING_BOX).removeClass(CLASSES.window);
		},
		
		renderUI : function () {
			var host = this.get(HOST),
				bb = host.get(BOUNDING_BOX);

			this._closeNode = Y.Node.create('<a href="#"></a>');
			this._closeNode.addClass(CLASSES.close);
			bb.append(this._closeNode);
			
			bb.addClass(CLASSES.window);
		},
		
		bindUI : function () {
			this._closeNode.on('click', function(e) {
				this.get(HOST).destroy();
			}, this);
		},
		
		syncUI : function () {
			
		}
		
		// *** Public Methods *** //
		
		// *** Private Methods *** //
	});
	
	Y.namespace('Plugin').OverlayWindow = OverlayWindow;
	
 });