/**
 *
 */
jQuery(function($) {
	/**
	 * Js modal form
	 */
	function showModal(e, source) {
		var $this = $(source),
			href = $this.attr('href'),
			$target = $('<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalLabel">' +
				'<div class="modal-dialog modal-' + ($this.data('size') || 'lg') + '" role="document">' +
				'<div class="modal-content">' +
				'<div class="modal-header">' +
				'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times</span></button>' +
				'<h2 class="modal-title" id="modalLabel">' + ($this.attr('title') || $this.text()) + '</h2>' +
				'</div>' +
				'<div class="modal-body"><div class="loader"></div></div>' +
				// '<div class="modal-footer">' +
				// '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>' +
				// '<button type="button" class="btn btn-primary">Save changes</button>' +
				// '</div>' +
				'</div>' + '</div>' + '</div>')

		e.preventDefault()

		$('body').append($target)

		var option = $target.data('bs.modal') ? 'toggle' : $.extend({ remote: !/#/.test(href) && href }, $target.data(), $this.data())

		if ($this.is('a')) e.preventDefault()

		$target.one('show.bs.modal', function(showEvent) {
			if (showEvent.isDefaultPrevented()) return // only register focus restorer if modal will actually get shown
			$target.one('hidden.bs.modal', function() {
				if ($this.is(':visible')) $this.trigger('focus')
			})
		})

		$.fn.modal.call($target, option, this)

		$target.one('hidden.bs.modal', function() {
			$target.remove()
		})

		$target.one('sumitted.red', function() {
			$target.modal('hide')
			$this.trigger('reload.red')
		})

		return $target
	}

	/**
	 * Fix z-index and multi modal issues
	 */
	$(document).on({
		'show.bs.modal': function() {
			var zIndex = 1040 + (10 * $('.modal:visible').length)
			$(this).css('z-index', zIndex)
			setTimeout(function() {
				$('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack')
			}, 0)
		},
		// 'hide.bs.modal': function() {
		// },
		'hidden.bs.modal': function() {
			if ($('.modal:visible').length > 0) {
				// restore the modal-open class to the body element, so that scrolling works
				// properly after de-stacking a modal.
				setTimeout(function() {
					$(document.body).addClass('modal-open')
				}, 0)
			}
		}
	}, '.modal')

	$(document).on('click.bs.modal.data-api', '[data-toggle="redmodal"]', function(e) {
		var modal = showModal(e, this),
			$this = $(this)

		modal.on('reload.red', function(e) {
			e.stopPropagation()
			var url = $this.data('url')
			if (url.indexOf('%form.select%') > 0) {
				url = url.replace('%form.select%', $this.closest('.form-group').find('select').val())
			}
			modal.find('.modal-body').html('<div class="loader"></div>').load(basepath + '/' + url, null, function() {
				modal.trigger('loaded.red')
			})
		}).trigger('reload.red')
	})

	$(document).on('click.bs.modal.data-api', '[data-toggle="redmodaliframe"]', function(e) {
		var modal = showModal(e, this)
		modal.find('.modal-body').html('').append('<iframe src="' + basepath + '/' + $(this).data('url') + '" tabindex="-1"></iframe>')
	})

	$(document).on('click', '[data-toggle="filemanager"]', function(e) {
		var modal = showModal(e, this),
			$this = $(this)
		modal.find('.modal-body').html('')
			.append('<iframe src="' + basepath + '/laravel-filemanager?type=' + ($(this).data('type') || 'file') + '" tabindex="-1"></iframe>')

		window.SetUrl = function(preview, path) {
			modal.modal('hide')
			// if ($this.is('a')) {
			var parent = $this.closest('.admin-list-item')
			parent.find('input').first().val(path)
			// $this.text('path')
			// .next().val(path)
			// }

			window.SetUrl = null
		}
		// window.SetUrl("http://localhost/edsa-Work/julie2/public/files/shares/playlist/Dada_Life_-_Feed_The_Dada.mp3", '/files/shares/playlist/Dada_Life_-_Feed_The_Dada.mp3')
	})

})
