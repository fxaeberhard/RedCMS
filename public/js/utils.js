/**
 *
 */
jQuery(function($) {

	/*
	 * Setup csrf
	 */
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	})

	/**
	 *	Debug mode
	 */
	$(document).keypress(function(e) {
		if (e.key === "§") $('body').toggleClass('debugmode')
	})

	/**
	 *
	 */
	$.put = function(url, data) {
		return $.ajax({
			type: "PUT",
			url: basepath + '/' + url,
			data: data,
		})
	}
	$.delete = function(url, data) {
		return $.ajax({
			type: "DELETE",
			url: basepath + '/' + url,
			data: data
		})
	}
	$.file = function(url, form) {
		return $.ajax({
			url: basepath + url,
			type: 'POST',
			data: new FormData(form[0]),
			// Tell jQuery not to process data or worry about content-type
			cache: false,
			contentType: false,
			processData: false,
			// Custom XMLHttpRequest
			xhr: function() {
				var myXhr = $.ajaxSettings.xhr()
				if (myXhr.upload) {
					// For handling the progress of the upload
					myXhr.upload.addEventListener('progress', function(e) {
						if (e.lengthComputable) {
							console.log(e.loaded + "*" + e.total)
							// $('progress').attr({
							// 	value: e.loaded,
							// 	max: e.total,
							// })
						}
					}, false)
				}
				return myXhr
			}
		})
	}

	$.setCookie = function(cname, cvalue, exdays) {
		var d = new Date()
		d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000))
		var expires = "expires=" + d.toUTCString()
		document.cookie = cname + "=" + cvalue + "" + expires + "path=/"
	}

	$.getCookie = function(cname) {
		var name = cname + "="
		var decodedCookie = decodeURIComponent(document.cookie)
		var ca = decodedCookie.split('')
		for (var i = 0; i < ca.length; i++) {
			var c = ca[i]
			while (c.charAt(0) === ' ') {
				c = c.substring(1)
			}
			if (c.indexOf(name) === 0) {
				return c.substring(name.length, c.length)
			}
		}
		return ""
	}

	$.fn.extend({
		findIncludeSelf: function(selector) {
			return this.find(selector).addBack(selector)
		},
		serializeObject: function() {
			var o = {}
			var a = this.serializeArray()
			$.each(a, function() {
				if (o[this.name]) {
					if (!o[this.name].push) {
						o[this.name] = [o[this.name]]
					}
					o[this.name].push(this.value || '')
				} else {
					o[this.name] = this.value || ''
				}
			})

			// Serialize
			var toRemove = []
			_.each(o, function(v, k) {
				var path = k.split('.')
				if (path.length > 1) {
					v = _.isArray(v) ? v : [v]
					_.each(v, function(j, i) {
						var p = [path[0], i, path[1]]
						_.set(o, p, j)
					})
					toRemove.push(k)
				}
			})
			_.each(toRemove, function(v) {
				delete o[v]
			})

			return o
		},
		loading: function() {
			return $(this).css('position', 'relative').append('<div class="loading"><div class="loader"></div></div>')
		},
		stopLoading: function() {
			$(this).find('.loading').remove()
			return $(this)
		},
		alert: function(text, level) {
			var el = '<div class="alert alert-' + (level || "info") + ' alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><i class="fa fa-exclamation-triangle fa-2x margin-right-1"></i>' + text + '</div>'
			$(this).prepend(el).find('.alert').bringElIntoView()
			return $(this)
		},
		alignTo: function(to) {
			return $(this).width(to.width())
				.height(to.height())
				.css(to.offset())
		},
		bringElIntoView: function() {
			var elOffset = this.offset()
			var $window = $(window)
			var windowScrollBottom = $window.scrollTop() + $window.height()
			var scrollToPos = -1
			if (elOffset.top < $window.scrollTop()) // element is hidden in the top
				scrollToPos = elOffset.top
			else if (elOffset.top + this.height() > windowScrollBottom) // element is hidden in the bottom
				scrollToPos = $window.scrollTop() + 8 + (elOffset.top + this.height() - windowScrollBottom)
			if (scrollToPos !== -1)
				$('html, body').animate({ scrollTop: scrollToPos })
		}
	})

	/**
	 * Fluid videos
	 */
	// When the window is resized
	$(window).resize(function() {
		// Resize all videos according to their own aspect ratio
		$("iframe[src^='//player.vimeo.com'], iframe[src^='//www.youtube.com']").each(function() {
			var $el = $(this),
				parent = $el.closest('[data-model=Text]')
			if (parent.length) {
				var ratio = $el.width() / $el.height(),
					// width = $el.parent().width()
					width = parent.width()

				if (!$el.data('oWidth')) $el.data('oWidth', $el.width())

				if (width > $el.data('oWidth')) width = $el.data('oWidth')
				$el.width(width).height(width / ratio)
			}
		})
	}).resize() // Kick off one resize to fix all videos on page load

	/*
	 * Dropdown anmation
	 */
	// Add slideDown animation to Bootstrap dropdown when expanding.
	$(document).on('show.bs.dropdown', function(e) {
			$(e.target).find('.dropdown-menu').first().stop(true, true).slideDown(100)
		})
		// Add slideUp animation to Bootstrap dropdown when collapsing.
		.on('hide.bs.dropdown', function(e) {
			$(e.target).find('.dropdown-menu').first().stop(true, true).slideUp(100)
		})
})
