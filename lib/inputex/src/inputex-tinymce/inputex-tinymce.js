/**
 * @module inputex-tinymce
 */
YUI.add("inputex-tinymce", function(Y) {

	var lang = Y.Lang,
		inputEx = Y.inputEx;

	/**
	 * Wrapper for the TinyMCE Editor
	 * @class inputEx.TinyMCEField
	 * @extends inputEx.Field
	 * @constructor
	 * @param {Object} options Added options:
	 * <ul>
	 *   <li>opts: the options to be added when calling the TinyMCE constructor</li>
	 * </ul>
	 */
	inputEx.TinyMCEField = function(options) {
		if (!window.tinymce) {
			alert("TinyMCE was not found on this page !");
		}
		inputEx.TinyMCEField.superclass.constructor.call(this, options);
	};
	Y.extend(inputEx.TinyMCEField, inputEx.Field, {
		defaultOpts: {
			mode: "textareas",
			language: "en",
			theme: "advanced",
			plugins: "paste,autolink,lists,table,inlinepopups,media,contextmenu,advlist", // past plugin for raw text pasting
			//advlink, advimage
			paste_auto_cleanup_on_paste: true,
			paste_remove_styles: true,
			paste_remove_styles_if_webkit: true,
			paste_strip_class_attributes: true,
			file_browser_callback: function(field_name, url, type, win) {
				var label = "Files", href = "/RedCMS/fileManager/";
				switch (type) {
					case "page":
						label = "Pages";
						href = "/RedCMS/pageManager/";
						break;
					case "image":
						href += "?filter=jpg%2Cjpeg%2Cpng%2Cbmp%2Cgif"
						break;
				}
				new Y.RedCMS.Panel({
					headerContent: label,
					zIndex: Y.one(".clearlooks2").getStyle("zIndex") + 1
				}).render()
					.load(href, {})
					.on("redcms:select", function(e) {
						win.document.forms[0].elements[field_name].value = e.href;
					});
			},
			theme_advanced_buttons1: "fontselect,fontsizeselect,formatselect,|,bold,italic,underline,strikethrough,|,forecolor,backcolor,|,undo,redo,|,iespell,cleanup,removeformat,code",
			theme_advanced_buttons2: "justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,outdent,indent,|,link,unlink,image,|, tablecontrols,",
			theme_advanced_buttons3: "",
			height: "270",
			width: "728",
			verify_html: true,
			cleanup_on_startup: true,
			cleanup: true,
			theme_advanced_resizing: true,
			theme_advanced_resize_vertical: true,
			theme_advanced_resize_horizontal: false,
//            force_br_newlines: true,
//            force_p_newlines: false,
			autofocus: false,
			theme_advanced_path: false
//            theme_advanced_statusbar_location: "none",
//		// Example content CSS (should be your site CSS)
//		content_css : "css/content.css",
//		// Drop lists for link/image/media/template dialogs
//		template_external_list_url : "lists/template_list.js",
//		external_link_list_url : "lists/link_list.js",
//		external_image_list_url : "lists/image_list.js",
//		media_external_list_url : "lists/media_list.js",
		},
		/**
		 * Set the default values of the options
		 * @method setOptions
		 * @param {Object} options Options object as passed to the constructor
		 */
		setOptions: function(options) {
			inputEx.TinyMCEField.superclass.setOptions.call(this, options);

			this.options.opts = options.opts || this.defaultOpts;
		},
		/**
		 * Render the field using the YUI Editor widget
		 * @method renderComponent
		 */
		renderComponent: function() {
			if (!inputEx.TinyMCEfieldsNumber) {
				inputEx.TinyMCEfieldsNumber = 0;
			}
			tinyMCE.baseURL = Y.RedCMS.Config.path + "lib/tinymce/jscripts/tiny_mce/";

			var id = "inputEx-TinyMCEField-" + inputEx.TinyMCEfieldsNumber;
			this.id = id;
			var attributes = {
				id: id,
				className: "mceAdvanced"
			};
			if (this.options.name) {
				attributes.name = this.options.name;
			}

			this.el = inputEx.cn('textarea', attributes);

			inputEx.TinyMCEfieldsNumber += 1;
			this.fieldContainer.appendChild(this.el);

			this.editor = new tinymce.Editor(this.id, this.options.opts);

			// this place the render phase of the component after
			Y.later(0, this, function() {
				this.editor.render();
			});
		},
		/**
		 * Set the html content
		 * @method setValue
		 * @param {String} value The html string
		 * @param {boolean} [sendUpdatedEvt] (optional) Wether this setValue should fire the 'updated' event or not (default is true, pass false to NOT send the event)
		 */
		setValue: function(value, sendUpdatedEvt) {

			var editor = tinymce.get(this.id);

			if (editor && editor.initialized) {
				editor.setContent(value, {
					format: 'raw'
				});
			} else {
				this.editor.onInit.add(function(ed) {
					ed.setContent(value, {
						format: 'raw'
					});
				});
			}

			if (sendUpdatedEvt !== false) {
				// fire update event
				this.fireUpdatedEvt();
			}
		},
		/**
		 * Get the html string
		 * @method getValue
		 * @return {String} the html string
		 */
		getValue: function() {

			var editor = tinymce.get(this.id);

			if (editor && editor.initialized) {
				return editor.getContent();
			} else {
				return null;
			}
		},
		/**
		 * @method getText
		 */
		getText: function() {

			var editor = tinymce.get(this.id);

			if (editor && editor.initialized) {
				return editor.getContent({format: "raw"});
			} else {
				return null;
			}
		}


	});

	// Register this class as "tinymce" type
	inputEx.registerType("tinymce", inputEx.TinyMCEField, []);

}, '3.1.0', {
	requires: ["inputex-field"]
});