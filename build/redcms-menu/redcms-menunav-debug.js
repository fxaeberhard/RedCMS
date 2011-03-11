YUI.add('redcms-menunav', function(Y) {

/**
 * Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
 * Code licensed under the BSD License:
 * http://redcms.red-agent.com/license.html
 */

//YUI.add('redcms-menunav', function(Y) {
	
	var MenuNav,
		CONTENT_BOX = 'contentBox';
	/**
     * <p>
     * A Widget that instanciates a node-menunav plugin. If the user has write rights on the block, 
     * it also make the menu sortable and handles server request to update the positions (through the
     * PositionManager server Object).
     * </p>
     *
     * <p>
     * The static <a href="#property_Base.NAME">NAME</a> property of each class extending 
     * from Base will be used as the identifier for the class, and is used by Base to prefix 
     * all events fired by instances of that class.
     * </p>
     *
     * @class MenuNav
     * @constructor
     * @uses RedCMS.RedCMSWidget
     * @uses Plugin.NodeMenuNav
     *
     * @param {Object} config Object with configuration property name/value pairs. The object can be 
     * used to provide default values for the objects published attributes.
     */
	MenuNav = Y.Base.create("redcmsnavmenu", Y.Widget, [Y.RedCMS.RedCMSWidget], {
		/**
		 * 
		 */
		_lastOpenedMenuNode: null,
		
		_menuNode: null,
		
		_sortable: null,
		
		_syncEmptyNodes: function() {
			this._menuNode.all('ul').each(function(n){
				var children = n.get('children');
				if (children.size() === 0) {
					n.append('<li class="yui3-menuitem yui3-menuitem-empty"><a class="yui3-menuitem-content" ><em>No item in this category.</em></a></li>');
				} else if (children.size() == 2){
					children.each(function(n2){
						if (n2.hasClass('yui3-menuitem-empty')) { n2.remove(); }
					});
				}
			});
		},
		
		renderUI: function() {
			this._menuNode = this.get(CONTENT_BOX).one('.yui3-menu');
			this._menuNode.all(".yui3-menu").each(function (node) {
				node.append('<div class="yui3-menu-shadow"></div>');			// Append a shadow element to the bounding box of each submenu
		    });
			
			//FIXME these values should be stored during DD and restored at the end
			//but they are marked as writeonce ...
			this._menuNode.plug(Y.Plugin.NodeMenuNav, { 
				mouseOutHideDelay : 200000 ,
				submenuHideDelay : 200000	
			});
			this._menuNode.removeClass('redcms-hidden');
			
			this._syncEmptyNodes();
		},
		
		bindUI: function(){
			var cb = this.get(CONTENT_BOX);
			
			if (!cb.hasClass('yui3-redcms-canwrite')) { return; }
			
			Y.use('sortable', Y.bind(function(Y){							// We defered load this, so we don't have it in the widget dependency, and it's not loaded when user cannot edit sorting
			
				var sortable = new Y.Sortable({
						container: cb.one('ul'),
						nodes: 'li',
						handles: ['a'],
						opacity: '0.4'
					});
				sortable.delegate.dd.removeInvalid('a');
	
				sortable.delegate.on('drag:mouseDown', function(e){
					if (!e.target.get('node').hasAttribute('redid')) {
						e.preventDefault();									// Stop the drag event AND the corresponding mouse event
						e.ev.halt();
					}
				});
				
				sortable.delegate.on('drag:start', function(e) {
					var drag = e.target.get('dragNode');
					drag.setStyles({'z-index': 999, 'opacity': '0.7'});
					drag.all('.yui3-menu').addClass("yui3-menu-hidden");
				});
				
				sortable.delegate.on('drop:over', function(e) {
			        var drag = e.drag.get('node'),
			            drop = e.drop.get('node'),
			            target = drop.one('.yui3-menu'),
			            firstItem;
			         
					if (target && drag != drop) {
						if (this._lastOpenedMenuNode && !this._lastOpenedMenuNode.contains(target)) {
							this._menuNode.menuNav._hideMenu(this._lastOpenedMenuNode);
						}
						this._menuNode.menuNav._showMenu(target);
						this._lastOpenedMenuNode = target;
						firstItem = target.one('li');
						this._menuNode.menuNav._focusItem(firstItem);
						this._menuNode.menuNav._setActiveItem(firstItem);
					}
					this._syncEmptyNodes();
					Y.DD.DDM.syncActiveShims(true);
				}, this);
				
				sortable.delegate.on('drag:end', function(e){
					var drag = e.target.get('node'),
						parent = drag.ancestor("[redid]"),
						prev = drag.previous('[redid]'),
						params = {
							id: drag.getAttribute('redid'),
							parentId: parent.getAttribute('redid'),
							redaction: 'submit'
						};
					
					if (prev) {
						params.targetId = prev.getAttribute('redid');
					}
					Y.io(Y.RedCMS.RedCMSManager.getLink('PositionManager'), {		//Then request its content to the server
						data: params,
						on: {
							success: function(id, o, args) {
								// FIXME do sthg (parse reply, display error msg
								//Y.log("DeleteAction.onRequestSuccess(): "+ o.responseText+ params, 'log');
							}
						},
						context :this
					});
	
					this._syncEmptyNodes();
				}, this);
				
				this._sortable = sortable;
			}, this));
		},
		destructor : function() {
			this._menuNode.unplug(Y.Plugin.NodeMenuNav);
			this._sortable.destroy();
		}
	}, {} );
	
	Y.namespace('RedCMS').MenuNav = MenuNav;
	
//}, '0.1.1');



}, '@VERSION@' ,{requires:['node-menunav', 'widget-position', 'sortable', 'redcms-base']});
