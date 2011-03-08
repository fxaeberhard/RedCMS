

 YUI.add('redcms-form-date', function(Y) {
	
	 var CONTENTBOX = 'contentBox';
	 
	 Y.DateField = Y.Base.create('editor-field', Y.TextField, [], {
		 _overlay : null,
		 _clickHandler: null,
		_calendar : null,

		_showCalendar:function(e){
			this._overlay.show();
			this._overlay.set("align", {node:this._fieldNode, points:['tc', 'bc']});
			e.halt();
			if (!this._clickHandler) {
				this._clickHandler = Y.on('click', Y.bind(function (e) {
					e.halt();
					var a = e.currentTarget.ancestor('.yui3-form-calendar-overlay', true);
					if (!a) {
						this._overlay.hide();
						this._clickHandler.detach();
						this._clickHandler = null;
					}
				}, this), 'body div');
			}
		},
		_padNumber: function(number) {
			return (number < 10 ? '0' : '') + number;
		},
		renderUI : function () {
			Y.DateField.superclass.renderUI.apply(this, arguments);
			
			this._fieldNode.setAttribute('readonly', 'readonly');
			
			Y.use('yui2-calendar', Y.bind( function(Y) {
				var YAHOO = Y.YUI2,
					olNode = Y.Node.create('<div class="yui3-form-calendar-overlay"></div>'),
					calNode = Y.Node.create('<div></div>'),
					calendar,
					overlay = new Y.Overlay({
						contentBox : olNode,
						visible : false,
						width : '170px',
						zIndex : 1000,
						align : {node:this._fieldNode, points:['tc', 'bl']}
					});
	
				Y.one('body').appendChild(olNode);
	
				olNode.appendChild(calNode);
				overlay.render();
	
				this._overlay = overlay;
				calendar = new YAHOO.widget.Calendar(olNode.get('id'));
				calendar.render();
	
				this._calendar = calendar;
				
				this._calendar.selectEvent.subscribe(Y.bind(function(e, oDate) {
					var oDate = oDate[0][0];
					this.set('value', this._padNumber(oDate[1]) + '/' + this._padNumber(oDate[2]) + '/' + oDate[0]); 
					this._overlay.hide();
					this._clickHandler.detach();
					this._clickHandler = null;
				}, this));
			}, this));
		},

		bindUI : function () {
			Y.DateField.superclass.bindUI.apply(this, arguments);

			this._fieldNode.on('click', this._showCalendar, this);
			this._fieldNode.on('focus', this._showCalendar, this);
		}
	 }, {
		NAME : 'date-field'
	 });
 });
