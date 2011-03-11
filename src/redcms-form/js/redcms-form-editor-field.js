/* 
RedCMS Form Editor Field

Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*/

//YUI.add('redcms-form-editor', function(Y) {
	
	Y.EditorField = Y.Base.create('editor-field', Y.TextareaField, [], {
		// *** Instance members *** //
		_editor : null,

		_createlinkRendered : false,
		_insertimageRendered : false,

		// *** Private Methods *** //
		_onWindowButtonSelect : function(inputNode, selectedItem) {
			//var targetInput = YAHOO.util.Dom.get(this.get('id') + '_insertimage_url');
			inputNode.set('value', selectedItem.href);
			inputNode.focus();											//HACK we simulate the blur event to trigger the editor's image update
			inputNode.blur();	
		},
		_onWindowButtonRendered : function(inputNode, widgets) {
			var onWindowButtonSelect = Y.bind(this._onWindowButtonSelect, this, inputNode),
				i = 0;
			for (;i<widgets.length; i++) {
				widgets[i].on('redcms:select', onWindowButtonSelect);
			}
		},
		_renderFieldNode : function () {
			
			Y.EditorField.superclass._renderFieldNode.apply(this);
			
			Y.use('yui2-editor', Y.bind( function(Y) {
				var YAHOO = Y.YUI2,
					editor = new YAHOO.widget.Editor(this._fieldNode._node, {
						//dompath: true,
						height: '200px',
						width: '98%',
						animate: true, 
						autoHeight: true,
						filterWord: true
						//extracss:'p {margin:0} '+
						//' .yui-media { height: 240px; width: 410px; border: 1px solid black; background-color: #f2f2f2; background-image: url('+redcms.path+'modules/src/base/assets/sprite-video.png); background-position: center; background-repeat: no-repeat; }'+
						//' .yui-media * { display:none; }'
					});
				
				this.get("parent").on('submit', function(e) {
					this._editor.saveHTML();
				}, this);
				
				this._editor = editor;
				
				editor.addListener('toolbarLoaded', function(e,o) {
					this._editor.subscribe( 'afterOpenWindow', function(e){  //afterOpenWindow or windowRender
						var oWin=e.win,
							targetNode = new Y.Node(oWin.body.firstChild),
							inputNode = targetNode.get('children').item(1),
							onWindowButtonRendered = Y.bind(this._onWindowButtonRendered, this, inputNode),
							btnChoosePage,
							btnChooseFile;
						
						switch (oWin.name){
						case 'insertimage':		
							//if the newly inserted window is the image manager, we catch and modify
							// The image windows also manages videos: small modif in the interfaces,
							// it generates a img tag, with width and height and a "rel" attribute
							// pointing to the target video. The player is added as a post-render plugin
							// to the page.
							if ( !this._insertimageRendered ){
								inputNode.setStyle('width', '270px');
								
								// Create the choose file button
								btnChooseFile = Y.Node.create('<span class="yui3-redcms-button" widget="OpenPanelAction"'+
											'params="'+Y.RedCMS.RedCMSManager.escapeAttribute('{"filter":"jpg,jpeg,png,bmp,gif"}')+'" requires="redcms-panel"><span>'+
											'<a class="yui3-redcms-button-addfile" href="'+Y.RedCMS.RedCMSManager.getLink('fileManager')+'" ></a>'+
										'</span></span>');
								btnChooseFile.appendTo(targetNode);
								
								Y.RedCMS.RedCMSManager.render(targetNode, onWindowButtonRendered);
								
								this._insertimageRendered= true;
							}
							break;
						case 'createlink':
							if ( !this._createlinkRendered ){
								inputNode.setStyle('width', '190px');
								// Create the choose page button
								btnChoosePage = Y.Node.create('<span class="yui3-redcms-button" widget="OpenPanelAction" requires="redcms-panel"><span>'+
											'<a class="yui3-redcms-button-addpage" href="'+Y.RedCMS.RedCMSManager.getLink('pageManager')+'" ></a>'+
										'</span></span>');
								btnChoosePage.setStyle('float', 'left');
								btnChoosePage.appendTo(targetNode);
								
								// Create the choose file button
								btnChooseFile = Y.Node.create('<span class="yui3-redcms-button" widget="OpenPanelAction" requires="redcms-panel"><span>'+
											'<a class="yui3-redcms-button-addfile" href="'+Y.RedCMS.RedCMSManager.getLink('fileManager')+'" ></a>'+
										'</span></span>');
								btnChooseFile.setStyle('float', 'left');
								btnChooseFile.appendTo(targetNode);
								
								Y.RedCMS.RedCMSManager.render(targetNode, onWindowButtonRendered);
								this._createlinkRendered= true;
							}
							break;
						}
					}, null, this);
				}, null, this);

				editor.render();
			}, this));
		}
	}, {
	});
	
//});
