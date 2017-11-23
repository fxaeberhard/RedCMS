jQuery(function($) {
	/**
	 * Tinymce
	 */
	$('body').on('loaded.red.rte', function() {

		autosize($('textarea.autosize'))

		if (window.tinymce) {
			tinymce.remove()
			tinymce.init({
				plugins: [
          'advlist autolink lists link image anchor',
          'searchreplace codemirror autoresize textcolor colorpicker', // code
          'media table contextmenu hr paste'
        ],
				// 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
				// 'searchreplace wordcount visualblocks visualchars code fullscreen',
				// 'insertdatetime media nonbreaking save table contextmenu directionality',
				// 'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
				selector: 'textarea.rte',
				extended_valid_elements: 'i[class]',
				menubar: false,
				branding: false,
				statusbar: false, //elementpath: false,
				codemirror: {
					indentOnInit: true,
					fullscreen: true, // Default setting is false
					saveCursorPosition: false // Insert caret marker
				},
				content_css: basepath + '/css/admin.css',
				autoresize_bottom_margin: 0,
				autoresize_min_height: 100,
				autoresize_max_height: 600,
				// media_dimensions: false,
				media_live_embeds: false,
				insert_button_items: 'hr playicon',
				// image_caption: true,
				image_advtab: true,
				image_class_list: [
					{ title: 'None', value: '' },
					{ title: 'Round', value: 'round' },
				],
				style_formats: [
					{ title: 'Normal', format: 'p' },
					{ title: 'Heading 1', format: 'h1' },
					{ title: 'Heading 2', format: 'h2' },
          // { title: 'Homepage quote - Author', format: 'h3' },
          // { title: 'Homepage quote - Source', format: 'h4' },
          // { title: 'Heading 3', format: 'h3' },
          // { title: 'Heading 4', format: 'h4' },
          // { title: 'Heading 5', format: 'h5' },
          // { title: 'Heading 6', format: 'h6' },
          // { title: 'Blockquote', format: 'blockquote' },
          // { title: 'Bold', icon: 'bold', format: 'bold' },
          // { title: 'Italic', icon: 'italic', format: 'italic' },
					{ title: 'Underline', icon: 'underline', format: 'underline' },
					{ title: 'Strikethrough', icon: 'strikethrough', format: 'strikethrough' },
          // { title: 'Superscript', icon: 'superscript', format: 'superscript' },
          // { title: 'Subscript', icon: 'subscript', format: 'subscript' },
          // { title: 'Code', icon: 'code', format: 'code' },
          // { title: 'Div', format: 'div' },
          // { title: 'Pre', format: 'pre' },
          // { title: 'Left', icon: 'alignleft', format: 'alignleft' },
          // { title: 'Center', icon: 'aligncenter', format: 'aligncenter' },
          // { title: 'Right', icon: 'alignright', format: 'alignright' },
          // { title: 'Justify', icon: 'alignjustify', format: 'alignjustify' }
        ],
				// undo redo | insert | outdent indent insrt2
				toolbar: 'styleselect bold italic forecolor | alignleft aligncenter alignright alignjustify | link image media  grid bullist numlist | removeformat code',
				setup: function(editor) {
					editor.addButton('grid', {
						// text: 'Table',
						context: 'Insert table',
						icon: 'table',
						type: 'menubutton',
						menu: [{
							icon: 'grid',
							image: basepath + '/images/grid/icon-6-6.png',
							onclick: function() {
								editor.insertContent('<div class="row"><div class="col-sm-6"><p>&nbsp</p></div><div class="col-sm-6"><p>&nbsp</p></div></div><br>')
								// editor.insertContent('<div class="row"><div class="col-sm-6"><p>C</p></div><div class="col-sm-6"><p>C</p></div></div>')
							}
						}, {
							icon: 'grid',
							image: basepath + '/images/grid/icon-4-8.png',
							onclick: function() {
								editor.insertContent('<div class="row"><div class="col-sm-4"><p>&nbsp</p></div><div class="col-sm-8"><p>&nbsp</p></div></div><br>')
							}
						}, {
							icon: 'grid',
							image: basepath + '/images/grid/icon-8-4.png',
							onclick: function() {
								editor.insertContent('<div class="row"><div class="col-sm-8"><p>&nbsp</p></div><div class="col-sm-4"><p>&nbsp</p></div></div><br>')
							}
						}, {
							icon: 'grid',
							image: basepath + '/images/grid/icon-4-4-4.png',
							onclick: function() {
								editor.insertContent('<div class="row"><div class="col-sm-4"><p>&nbsp</p></div><div class="col-sm-4"><p>&nbsp</p></div><div class="col-sm-4"><p>&nbsp</p></div></div><br>')
							}
						}, {
							icon: 'grid',
							image: basepath + '/images/grid/icon-3-9.png',
							onclick: function() {
								editor.insertContent('<div class="row"><div class="col-sm-3"><p>&nbsp</p></div><div class="col-sm-9"><p>&nbsp</p></div></div><br>')
							}
						}, {
							icon: 'grid',
							image: basepath + '/images/grid/icon-9-3.png',
							onclick: function() {
								editor.insertContent('<div class="row"><div class="col-sm-9"><p>&nbsp</p></div><div class="col-sm-3"><p>&nbsp</p></div></div><br>')
							}
						}, {
							icon: 'grid',
							image: basepath + '/images/grid/icon-3-3-3-3.png',
							onclick: function() {
								editor.insertContent('<div class="row"><div class="col-sm-3"><p>&nbsp</p></div><div class="col-sm-3"><p>&nbsp</p></div><div class="col-sm-3"><p>&nbsp</p></div><div class="col-sm-3"><p>&nbsp</p></div></div><br>')
							}
						}]
					})

					editor.addButton('playicon', {
						// icon: 'grid',
						text: "Play icon",
						onclick: function() {
							editor.insertContent('<i class="fa fa-play-circle"></i>')
						}
					})

					editor.addButton('insert2', {
						context: 'Insert table',
						icon: 'plus',
						type: 'menubutton',
						menu: [{
							icon: false,
							text: 'Horizontal line',
							onclick: function() {
								editor.insertContent('<hr />')
								// editor.insertContent('<div class="row"><div class="col-sm-6"><p>C</p></div><div class="col-sm-6"><p>C</p></div></div>')
							}
						}, {
							icon: false,
							text: "Play icon",
							onclick: function() {
								editor.insertContent('<i class="fa fa-play-circle"></i>')
							}
						}]
					})

					// Insert
					// editor.on('KeyDown', function(event) {
					//  if (event.keyCode == 13 && $(this.selection.getNode()).closest('.row')[0]) {
					//      this.insertContent('<br id="tmp_grid_id"/>')
					//      this.selection.select(this.dom.select('#tmp_grid_id')[0]) //select the inserted element
					//      this.selection.collapse(0) //collapses the selection to the end of the range, so the cursor is after the inserted element
					//      this.dom.setAttrib('id', 'id', '')
					//      event.preventDefault()
					//      event.stopPropagation()
					//      return false
					//  }
					// })
				},
				file_browser_callback: function(field_name, url, type) {
					var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth
					var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight

					var cmsURL = basepath + '/laravel-filemanager?field_name=' + field_name
					if (type === 'image') {
						cmsURL = cmsURL + "&type=Images"
					} else {
						cmsURL = cmsURL + "&type=Files"
					}

					tinymce.activeEditor.windowManager.open({
						file: cmsURL,
						title: 'Filemanager',
						width: x * 0.8,
						height: y * 0.8,
						resizable: "yes",
						close_previous: "no"
					})
				}
			})
		}
	}).trigger('loaded.red.rte')

	/**
	 * Fix issue in link edition with bootstrap & Tinymce
	 */
	$(document).on('focusin', function(e) {
		if ($(e.target).closest(".mce-window").length) {
			e.stopImmediatePropagation()
		}
	})

})
