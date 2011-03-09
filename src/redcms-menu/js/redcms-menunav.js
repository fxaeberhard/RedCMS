/**
 * Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
 * Code licensed under the BSD License:
 * http://redcms.red-agent.com/license.html
 */

YUI.add('redcms-menunav', function(Y) {
	
	var MenuNav,
		CONTENTBOX = 'contentBox';
	
	Y.RedCMS.MenuNav = Y.Base.create("redcmsnavmenu", Y.Widget, [Y.RedCMS.RedCMSWidget], {
		_menuNode: null,
		
		renderUI : function() {
			this._menuNode = this.get(CONTENTBOX).one('.yui3-menu');
			this._menuNode.all(".yui3-menu").each(function (node) {
			node.append('<div class="yui3-menu-shadow"></div>');			// Append a shadow element to the bounding box of each submenu
		    });
			
			this._menuNode.plug(Y.Plugin.NodeMenuNav, { 
				mouseOutHideDelay : 200000 ,
				submenuHideDelay : 200000	
			});
			this._menuNode.removeClass('redcms-hidden');
		},
		
		_lastEvent:null,
		
		bindUI: function(){

			return; 
			
			var cb = this.get(CONTENTBOX),
				sortable, sortable2,
				baseUl = cb.one('ul');
			
			baseUl.all('self>li').each(function(v){
				console.log("vvv", v.one('a').get('innerHTML'));
			});
			sortable = new Y.Sortable({
				container: baseUl,
				nodes: '>li',
				opacity: '.1',
				handles: ['a']
			});
			sortable.delegate.dd.removeInvalid('a');
	      
			console.log(sortable);
			baseUl.all('ul').each(function(n){
				sortable2 = new Y.Sortable({
				container: n,
				nodes: 'self>li',
				opacity: '.1',
					handles: ['a']
			    });
				sortable2.delegate.dd.removeInvalid('a');
			 	sortable.join(sortable2, 'full');
			});
			
				// Y.DD.DDM.on('drag:drophit', function(e) {
			Y.DD.DDM.on('drop:over', function(e) {
			//sortable.delegate.dd.on('drop:over', function(e) {
			 //Get a reference to our drag and drop nodes
			 var drag = e.drag.get('node'),
			     drop = e.drop.get('node');
			 
			 console.log('drop:over', drag, drop);
			 //Are we dropping on a li node?
			 if (drop.get('tagName').toLowerCase() === 'li') {
				 //drop.one('.yui3-menu-hidden').removeClass('yui3-menu-hidden');
				 var tar = drop.one('.yui3-menu');
				 if (tar) {
					 this._menuNode.menuNav._showMenu(tar);
					 var firstItem = tar.one('li');
					 this._menuNode.menuNav._focusItem(firstItem);
					 this._menuNode.menuNav._setActiveItem(firstItem);
					 
				 }
			 }
		     }, this);
			 
			/*
	   var handle = Y.one('doc').on('mouseover', function ( e ) {
		   if (!this._lastEvent) return;
		   console.log('removing _lastEvent', this._lastEvent);
		   this._lastEvent.simulate("mouseout", { relatedTarget: document.body });
		   this._lastEvent = null;
			       }, this);*/
			/*
		 	 Y.DD.DDM.on('drop:over', function(e) {
			 //Get a reference to our drag and drop nodes
			 var drag = e.drag.get('node').get('parentNode'),
			     drop = e.drop.get('node').get('parentNode');
			 
			 console.log('drop:over', e.drop.get('node').get('innerHTML'), drag, drop,e.drop.get('node'), e);
			 //Are we dropping on a li node?
			 if (drop.get('tagName').toLowerCase() === 'li') {

				 var a =  drop.one('a');
				 if (this._lastEvent){
					// this._lastEvent.simulate("mouseout", { relatedTarget: document.body });
				 }
				 
				 //drop.one('.yui3-menu-hidden').removeClass('yui3-menu-hidden');
				 
				 var tar = drop.one('.yui3-menu');
				 if (tar) {
					 this._menuNode.menuNav._showMenu(tar);
					 var firstItem = tar.one('li');
					 this._menuNode.menuNav._focusItem(firstItem);
					 this._menuNode.menuNav._setActiveItem(firstItem);
					 
				 }
				 if (drop.one('ul')){
//					 console.log(this._menuNode);
					 //
					 	//a.simulate("mouseover", { relatedTarget: document.body });
					 	//Y.later('2000',this, function(){
						// 	console.log('removing _lastEvent',this );
							 	//	this._lastEvent.simulate("mouseout", { relatedTarget: document.body });
					 	//});
					 	
				//	 	a.simulate("mouseout", { relatedTarget: document.body });
					 	this._lastEvent = a;
				 };
			     //Are we not going up?
			     if (!goingUp) {
				 drop = drop.get('nextSibling');
			     }
			     //Add the node to this list
			     try{
			    	 console.log(drag, drop);
			    	 drop.get('parentNode').insertBefore(drag, drop);
			     }catch(e){
			    	 console.log('error');
			    	 console.log("mmmmm",  drop.get('parentNode'));
			     }
			     //Resize this nodes shim, so we can drop on it later.
			     e.drop.sizeShim();
			 }
		     }, this);
		     //Listen for all drag:drag events
		     Y.DD.DDM.on('drag:drag', function(e) {
			 //Get the last y point
			 var y = e.target.lastXY[1];
			 //is it greater than the lastY var?
			 if (y < lastY) {
			     //We are going up
			     goingUp = true;
			 } else {
			     //We are going down.
			     goingUp = false;
			 }
			 //Cache for next check
			 lastY = y;
		     });
		     //Listen for all drag:start events
		     Y.DD.DDM.on('drag:start', function(e) {
			 //Get our drag object
			 var drag = e.target;
			 //Set some styles here
			 drag.get('node').setStyle('opacity', '.25');
			 drag.get('dragNode').set('innerHTML', drag.get('node').get('innerHTML'));
			 drag.get('dragNode').setStyles({
			     opacity: '.5',
			     borderColor: drag.get('node').getStyle('borderColor'),
			     backgroundColor: drag.get('node').getStyle('backgroundColor')
			 });
		     });
		     //Listen for a drag:end events
		     Y.DD.DDM.on('drag:end', function(e) {
			 var drag = e.target;
			 //Put our styles back
			 drag.get('node').setStyles({
			     visibility: '',
			     opacity: '1'
			 });
		     });
		     //Listen for all drag:drophit events
		     Y.DD.DDM.on('drag:drophit', function(e) {
			 var drop = e.drop.get('node').get('parentNode'),
			     drag = e.drag.get('node').get('parentNode');
		  
			 //if we are not on an li, we must have been dropped on a ul
			 if (drop.get('tagName').toLowerCase() !== 'li') {
			     if (!drop.contains(drag)) {
				 drop.appendChild(drag);
			     }
			 }
		     });
		     
		     //Static Vars
		     var goingUp = false, lastY = 0;
		  
		     //Get the list of li's in the lists and make them draggable
		     
		     var lis = cb.all('a');
		     lis.each(function(v, k) {
		    	 console.log('li',v, k, v.get('innerHTML'));

		    	 v.on('mouseover', function() {
		    		 console.log("mouseover", this.get('innerHTML'));
		    	 })
		    	 
		    	 var dd = new Y.DD.Drag({
			     node: v,
			     target: {
				 padding: '0 0 0 20'
			     }
			 }).plug(Y.Plugin.DDProxy, {
			     moveOnEnd: false
			 }).plug(Y.Plugin.DDConstrained, {
			    // constrain2node: cb
			 });
		    	 dd.set('throttleTime', 100);
		    	 //dd.set('dragMode', 'strict');
			 dd.removeInvalid('a');
		     });
		  */
		     //Create simple targets for the 2 lists.
		 /*    var uls = cb.all('ul');
		     uls.each(function(v, k) {
			 var tar = new Y.DD.Drop({
			     node: v
			 });
		     });*/
		},
		destroy : function() {
			this.get(CONTENTBOX).one('.yui3-menu').unplug(Y.Plugin.NodeMenuNav);
		}
	}, {} );
}, '0.1.1');