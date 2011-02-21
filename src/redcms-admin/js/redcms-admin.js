/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*/

YUI.add('redcms-admin', function(Y) {
	
// *** OverlayAutohide *** //
	var ContextMenu
		BOUNDING_BOX = 'boundingBox',
		CONTENT_BOX = 'contentBox';
	
    ContextMenu = Y.Base.create("contextmenu", Y.Widget, [Y.WidgetPosition, Y.WidgetStack, Y.WidgetChild], {
		// *** Instance Members *** //
		_targetBlock: null,
    	
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
				var targetBlock = e.target.ancestor('[redid]', true),
					targetAdmin = e.target.ancestor('[redadmin]', true),
					menuCB = cb.one('div');
				
				this._targetBlock = targetBlock;
				
				if (targetBlock) {
					var jsonConf = Y.JSON.parse(decodeURI(targetAdmin.getAttribute('redadmin')));
					if (jsonConf.length>0) {
						e.halt();	
						this.show();
						this.move(e.clientX, e.clientY);
						/*cb.one('div').setContent('<div class="yui3-menu-content"><ul class="first-of-type">'+
							'<li class="yui3-menuitem"><a class="yui3-menuitem-content" href="#" >two</a></li>'+
							'</ul></div>');*/
						menuCB.setContent(this._getMenuMarkupFromObject(jsonConf));
						Y.RedCMS.RedCMSManager.render(menuCB, Y.bind(this._onContextMenuItemsRendered, this));
					}
				};
			}, this);
		}, 
		
		
		// *** Private Methods *** //

		_onContextMenuItemsRendered: function(widgets) {
			for (var i=0;i<widgets.length;i++){
				//console.log("adding succes callback on a menu item");
				widgets[i].on('success', Y.bind(this._onContextMenuItemSuccess, this));
			}
		},
		_onContextMenuItemSuccess: function() {
			//Y("ContextMenu._onContextMenuItemSuccess(): "+ targetWidget, 'log');
			
			//FIXME This should be replaced by a rootBlock attribute query
			var targetWidget = Y.Widget.getByNode(this._targetBlock.ancestor("[redadmin]", true));
			Y.RedCMS.RedCMSManager.reloadWidget(targetWidget);
		},
		_getMenuMarkupFromObject : function( o ) {
			var ret = new Array('<div class="yui3-menu-content"><ul class="first-of-type">'),
				row,
				params;
			
			//Y.log("ContextMenu._getMenumarkupFromObject(): "+ this._targetBlock, 'log');
			
			for (var i=0; i<o.length; i++) {
				row = o[i];
				params = new Object();
				if (row.filter == undefined || row.filter == this._targetBlock.getAttribute('widget')) {
					if (row.action=='editCurrent') {
						params['id'] = this._targetBlock.getAttribute('redid');
					} else if (row.action=='addSibling'){
						params['parentId'] = this._targetBlock.ancestor('[redid]').getAttribute('redid');
					} else if (row.action=='addChild'){
						params['parentId'] = this._targetBlock.getAttribute('redid');
					}
					ret.push('<li class="yui3-menuitem" widget="',row.widget,'" params="',Y.RedCMS.RedCMSManager.escapeAttribute(Y.JSON.stringify(params)),'" ><a class="yui3-menuitem-content" href="',row.href,'" >',row.label,'</a></li>');
				}
			}
			ret.push('</ul></div>');
			if (ret.length>2) return ret.join('');
			else return '';
		}
	});
    
	Y.namespace('RedCMS').ContextMenu = ContextMenu;
	
	Y.RedCMS.cm = new ContextMenu({
        width:"10em",
        zIndex:1000,
        render : true,
		visible : false
    });
	
}, '0.1.1', {requires:['gallery-outside-events', 'node-menunav']});