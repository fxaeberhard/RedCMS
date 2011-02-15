/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.sourceforge.net/license.html
*/

YUI.add('redcms-admin', function(Y) {
	
// *** OverlayAutohide *** //
	var ContextMenu
		BOUNDING_BOX = 'boundingBox',
		CONTENT_BOX = 'contentBox';
	
    ContextMenu = Y.Base.create("contextmenu", Y.Widget, [Y.WidgetPosition, Y.WidgetStack, Y.WidgetChild], {
		// *** Instance Members *** //
		
		// *** Lifecycle Methods *** //
		renderUI : function() {
			var bb = this.get(BOUNDING_BOX),
				cb = this.get(CONTENT_BOX),
				hide = Y.bind(this.hide, this);
				
			bb.setStyle('position', 'absolute');
			cb.setContent('<div class="yui3-menu" />');
			
			cb.one('.yui3-menu').plug(Y.Plugin.NodeMenuNav);
		},
		bindUI : function() {
			var bb = this.get(BOUNDING_BOX),
				cb = this.get(CONTENT_BOX),
				hide = Y.bind(this.hide, this);
			
			bb.on('mouseupoutside', hide);
			bb.on('click', hide);
		
			Y.one('body').on('contextmenu', function(e) {
				var targetBlock = e.target.ancestor('[redid]'),
					targetAdmin = e.target.ancestor('[redadmin]'),
					menuCB = cb.one('div');
				if (targetBlock) {
					e.halt();	
					this.show();
					this.move(e.clientX, e.clientY);
					/*cb.one('div').setContent('<div class="yui3-menu-content"><ul class="first-of-type">'+
						'<li class="yui3-menuitem"><a class="yui3-menuitem-content" href="#" >two</a></li>'+
						'</ul></div>');*/
					menuCB.setContent(this._getMenuMarkupFromObject(Y.JSON.parse(decodeURI(targetAdmin.getAttribute('redadmin')))));
					Y.RedCMS.RedCMSManager.render(menuCB);
				};
			}, this);
		}, 
		
		// *** Private Methods *** //
		_getMenuMarkupFromObject : function( o ) {
			var ret = new Array('<div class="yui3-menu-content"><ul class="first-of-type">');
			for (var i=0; i<o.length; i++) {
				var row = o[i];
				console.log(row);
				ret.push('<li class="yui3-menuitem" widget="',row.widget,'"><a class="yui3-menuitem-content" href="#" >',row.label,'</a></li>');
			}
			ret.push('</ul></div>');
			console.log(ret);
			return ret.join('');
		}
	});
    
	Y.namespace('RedCMS').ContextMenu = ContextMenu;
	
    var cm = new ContextMenu({
        width:"10em",
        zIndex:1000,
        render : true,
		visible : false
    });
	
}, '0.1.1', {requires:['gallery-outside-events', 'node-menunav']});