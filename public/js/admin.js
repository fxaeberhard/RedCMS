jQuery(function($) {

	/*
	 * Reload block on submit
	 */
	$(document).on('reload.red', '[data-block-id]', function(e) {
			e.stopPropagation()
			var $this = $(this).loading()
			$.get(basepath + '/PageBlock/' + $this.data('block-id'))
				.done(function(r) {
					$this.html(r).trigger('loaded.red')
				})
		})
		.on('reload.red', 'body', function() {
			$('body').loading()
			location.reload()
		})

	/**
	 * Admin overlay
	 */
	// $('body').on('mouseenter', '[data-model-id]', function() {
	//      // console.log("mouseenter", this)
	//      var $this = $(this),
	//          overlay = $('<div class="redcms-overlay"><div>' +
	//              '<button data-toggle="redmodal" data-url="edit?model=' + $this.data('model') + '&modelId=' + $this.data('model-id') + '&blockId=1" data-action="edit" title="Edit"><i class="fa fa-edit"></i></button>' +
	//              '<button data-delete="' + $this.data('model') + '/' + $this.data('model-id') + '" title="Delete"><i class="fa fa-trash"></i></button>' +
	//              '</div></div>')
	//          .alignTo($this)

	//      $('body').append(overlay)

	//      this._overlay = overlay
	//      overlay[0]._target = $this
	//  })
	//  .on('mouseleave', '[data-block-id]', function() {
	//      console.log("mouseleave", this)
	//      this._overlay && this._overlay.remove()
	//  })
	//  .on('sumitted.red', '.redcms-overlay', function() {
	//      this._target.trigger('sumitted.red')
	//  })

	/**
	 * Admin menu
	 */
	function initAdmin(target) {
		$(target).findIncludeSelf('[data-model-id]').each(function() {
			var $this = $(this),
				overlay = $('<div class="redcms-overlay"><div class="btn-group">' +
					'<button data-toggle="redmodal" data-url="edit?model=' + $this.data('model') + '&modelId=' + $this.data('model-id') + '" title="Edit" class="btn btn-red"><i class="fa fa-edit fa-fw"></i></button>' +
					'<button data-delete title="Delete" class="btn btn-red"><i class="fa fa-trash fa-fw"></i></button>' +
					'</div></div>')

			overlay[0]._target = $this
			$this.append(overlay)
		})

		$(target).findIncludeSelf('[data-sortable]').each(function() {
			$(this).sortable({
				handle: $(this).data('sortable-handle'),
				update: function() {
					if ($(this).data('sortable')) {
						var positions = []
						$(this).find("> *").each(function() {
							var id = $(this).data('model-id')
							if (id) positions.push(id)
						})
						// this.loading()
						$.post({
							url: basepath + $(this).data('sortable'),
							data: { positions: positions }
						})
					}
				}
			})
		})
	}

	$('body').on('loaded.red.adminoverlay', function(e) {
		initAdmin(e.target)
	}).trigger('loaded.red.adminoverlay')

	/**
	 * Highlight target on admin menu mouseover
	 */
	$(document).on('mouseenter', '.redcms-overlay', function() {
			$(this).after('<div class="highlight"></div>')
		})
		.on('mouseleave', '.redcms-overlay', function() {
			$(this).next().remove()
		})

	/**
	 * Admin menu click
	 */
	$(document).on('click', '[data-delete]', function(e) {
		e.preventDefault()

		var overlay = $(this).closest('.redcms-overlay')
		var target = overlay[0]._target

		target.loading()

		$.delete(target.data('model') + '/' + target.data('model-id'))
			.done(function() {
				target.remove()
			})
	})

	/**
	 * Admin forms lists
	 */
	$(document).on('click', '[data-append]', function() {
			var newEl = $($(this).next().text())

			$($(this).data('append')).append(newEl)

			newEl.find('[data-toggle]').first().click()
		})
		.on('click', '[data-remove]', function() {
			$(this).closest($(this).data('remove')).remove()
		})

	/**
	 * Admin Forms upload
	 */
	$(document).on('click', '[data-toggle="upload"]', function() {
		var $this = $(this),
			form = $('<form class="upload-form"><input name="file" type="file"></form>')
		$('body').append(form)

		form.find('input').one('change', function() {
			var file = $(this).val().split('\\').pop()

			$this.closest('div').loading()

			$.file('/FileManager', form).done(function() {
				$this.closest('div').stopLoading()

				$this.attr('src', basepath + '/upload/' + file)
					.next().val(file)
			})
			form.remove()
		}).click()
	})

	/**
	 * Admin actions (create block, etc.)
	 */
	$(document).on('click', '[data-toggle="reload"]', function() {
		var $this = $(this).loading()
		$.ajax({
				// type: $this.data('submit'),
				url: basepath + $this.data('url'),
				// data: $this.serializeObject()
			})
			.done(function() {
				$this.trigger("sumitted.red")
			})
	})

	/**
	 * Date time picker
	 */
	$('body').on('loaded.red.datetimepicker', function(e) {
		$(e.target).find('[data-toggle=datetimepicker]').datetimepicker({
			// timepicker: false,
			format: 'Y-m-d H:i:s' /*'unixtime'*/
		})
	}).trigger('loaded.red.datetimepicker')

})
