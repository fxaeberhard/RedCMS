/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.sourceforge.net/license.html
*/

YUI.add('redcms-admin', function(Y) {
	
// *** OverlayAutohide *** //
	var OVERLAY = 'overlay',
		HOST = 'host',
		RENDER_UI = 'renderUI',
		BIND_UI = 'bindUI',
		SYNC_UI = 'syncUI',
		RENDERED = 'rendered',
		BOUNDING_BOX = 'boundingBox',
		VISIBLE = 'visible',
		Z_INDEX = 'zIndex',
		
		CHANGE = 'Change',
		
		isBoolean = Y.Lang.isBoolean,
		getCN = Y.ClassNameManager.getClassName,
		
		OverlayAutohide,
		OVERLAY_AUTOHIDE = 'overlayAutohide',
		AUTOHIDE = 'autohide',
		CLICKED_OUTSIDE = 'clickedOutside',
		FOCUSED_OUTSIDE = 'focusedOutside',
		PRESSED_ESCAPE = 'pressedEscape';
		
	OverlayAutohide = Y.Base.create(OVERLAY_AUTOHIDE, Y.Plugin.Base, [], {
		// *** Instance Members *** //
		_uiHandles : null,
		// *** Lifecycle Methods *** //
		initializer : function (config) {
			this.afterHostMethod(BIND_UI, this.bindUI);
			this.afterHostMethod(SYNC_UI, this.syncUI);
			
			if (this.get(HOST).get(RENDERED)) {
				this.bindUI();
				this.syncUI();
			}
		},
		destructor : function () {
			this._detachUIHandles();
		},
		
		bindUI : function () {
			this.afterHostEvent(VISIBLE+CHANGE, this._afterHostVisibleChange);
		},
		
		syncUI : function () {
			this._uiSetHostVisible(this.get(HOST).get(VISIBLE));
		},
		
		// *** Private Methods *** //
		
		_uiSetHostVisible : function (visible) {
			
			if (visible) {
				Y.later(1, this, '_attachUIHandles');
			} else {
				this._detachUIHandles();
			}
		},
		
		_attachUIHandles : function () {
			console.log("_attachUIHandles")
			if (this._uiHandles) { return; }

			console.log("attaching new ones")
			var host = this.get(HOST),
				bb = host.get(BOUNDING_BOX),
				hide = Y.bind(host.hide, host),
				uiHandles = [];
			
			if (this.get(CLICKED_OUTSIDE)) {
				uiHandles.push(bb.on('clickoutside', hide));
				bb.on('clickoutside', function(){console.log("click outside")});
			}
			
			if (this.get(FOCUSED_OUTSIDE)) {
				uiHandles.push(bb.on('focusoutside', hide));
				console.log("attaching");
				bb.on('focusoutside', function(){console.log("focus outside")});
			}
			
			if (this.get(PRESSED_ESCAPE)) {
//				uiHandles.push(bb.on('key', hide, 'down:27')); // doesn't work because of event-key metadata issue
				uiHandles.push(bb.on('keydown', function(e){
					if (e.keyCode === 27) {
						hide();
					}
				}));
			}
			
			this._uiHandles = uiHandles;
		},
		
		_detachUIHandles : function () {
			Y.each(this._uiHandles, function(h){
				h.detach();
			});
			this._uiHandles = null;
		},
		
		_afterHostVisibleChange : function (e) {	
			this._uiSetHostVisible(e.newVal);
		}
	}, {
		// *** Static *** //
		NS : AUTOHIDE,
		ATTRS : {
			clickedOutside	: {
				value		: true,
				validator	: isBoolean
			},
			focusedOutside	: {
				value		: true,
				validator	: isBoolean
			},
			pressedEscape	: {
				value		: true,
				validator	: isBoolean
			}	
		}
	});
	
	
    var Positionable = Y.Base.create("redcms-contextmenu", Y.Widget, [Y.WidgetPosition, Y.WidgetStack, Y.WidgetChild]);
    
    var positionable = new Positionable({
        width:"10em",
        zIndex:100,
        render : true,
        visible : true,
      /*  plugins     : [
  			{ fn: Y.Plugin.OverlayAutohide, cfg: {
				focusedOutside : true  // disables the Overlay from auto-hiding on losing focus
			}}
		]*/
    });
    positionable.get('boundingBox').setStyle('position', 'absolute');
    positionable.get('contentBox').setContent('<div class="yui3-menu"><div class="yui3-menu-content"><ul class="first-of-type">'+
			'<li class="yui3-menuitem"><a class="yui3-menuitem-content" href="#" >one</a></li>'+
			'</ul></div></div>');
    positionable.move(30, 30);
    positionable.plug(OverlayAutohide);
/*    positionable.get("contentBox").one('div').plug(Y.Plugin.NodeMenuNav
    		//{ autoSubmenuDisplay: false, mouseOutHideDelay: 0 }
    );*/
    
    /*
    var positionable = new Positionable({
        width : "10em",
        render : true,
        zIndex : 100,
        focused : true,
        visible : true,
      //  contentBox : '<div><div></div></div>'
    });
    console.log("positionnable", positionable.get('contentBox'));
 
    var xy = Y.one("#widget2-example > p").getXY();
 
    positionable.move(xy[0], xy[1]);
	
	
	var contextMenu = new Y.Overlay({
		bodyContent : '<div></div>',
		headerContent : 'Login',
		width       : '400px',
		zIndex      : 100,
		render      : true,
		plugins     : [
			{ fn: Y.Plugin.OverlayAutohide, cfg: {
				focusedOutside : false  // disables the Overlay from auto-hiding on losing focus
			}}
		]
	});
	*/
	Y.on('contextmenu', function(e) {
		var targetBlock = e.target.ancestor('[redid]');
		if (targetBlock) {
			e.halt();			
		}
	});
}, '0.1.1');