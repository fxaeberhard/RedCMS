/**
 *
 */

jQuery(function($) {

	/**
	 * Mobile menu
	 */
	$(document).on('click', '#menu-icon', function() {
		if (!$('body').hasClass('menu-open')) {
			$('body').addClass('menu-open')
			setTimeout(function() {
				$('body').addClass('menu-openin')
			})
		} else {
			$('body').removeClass('menu-openin')
			setTimeout(function() {
				$('body').removeClass('menu-open')
			}, 500)
		}
	})


	/**
	 * Navbar hover
	 */
	$(document).on('mouseenter', 'ul.nav li.dropdown', function() {
			$(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(200)
		})
		.on('mouseleave', 'ul.nav li.dropdown', function() {
			$(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(200)
		})
		.on('click', 'ul.nav li.dropdown', function() {
			// $(this).find('.dropdown-menu').toggleClass('open');
		})

	/**
	 * Constrain menu to viewport
	 */
	$(document).on('mouseenter', '.menu .dropdown-toggle', function() {
		var target = $(this).next()
		target.css('top', "")
		setTimeout(function() {
			var p = $(window).height() - target.offset().top - target.outerHeight() + window.scrollY
			if (p < 0) {
				target.css('top', p)
			}
		}, 205)
	})

	/**
	 * Menu
	 */
	$(document).on('click', '.hamburger', function() {
		$('body').toggleClass('menu-open')
	})

	// function isTouchDevice() {
	// 	return !!('ontouchstart' in window)
	// }

	// // if (isTouchDevice()) {
	// $(document).on('click', '.drophover > a', function(e) {
	//     if (!$(this).parent().hasClass('opened')) {
	//         $('.drophover.opened').removeClass('opened')
	//         $(this).parent().addClass('opened')
	//         e.stopPropagation()
	//     }
	// }).on('click', function(e) {
	//     if (!$(e.target).is('[href]') && !$(e.target).is('[href]'))
	//         $('.drophover.opened').removeClass('opened')
	// })
	// // }

	/**
	 * Mailing list
	 */
	// $(document).on('submit', '[data-submit="mailinglist"]', function(e) {
	// 	if (!e.isDefaultPrevented()) {
	// 		e.preventDefault()
	// 		$(this).loading()
	// 		var $this = $(this)
	//
	// 		$.post({
	// 				url: basepath + "/mailinglist",
	// 				data: $(this).serialize()
	// 			})
	// 			.done(function() {
	// 				$this.stopLoading().alert("Message sent")
	// 				// .find('.done').css("display", "flex").hide().fadeIn()
	// 			})
	// 	}
	// })

	/**
	 * Login forms
	 */
	// $(document).on('submit', '[data-submit="login"]', function(e) {
	// 	if (!e.isDefaultPrevented()) {
	// 		e.preventDefault()
	//
	// 		var $this = $(this)
	// 		//inputs = $this.serializeArray()
	//
	// 		$.post({
	// 				url: basepath + '/login',
	// 				data: $this.serialize(),
	// 				// headers: { "X-CSRF-TOKEN": inputs[0].value }
	// 			})
	// 			.done(function() {
	// 				location.reload()
	// 			})
	// 			.fail(function() {
	// 				alert('Invalid email or password')
	// 			})
	// 	}
	// })

	/**
	 * Form submission
	 */
	$(document).on('submit', '[data-submit]', function(e) {
		if (!e.isDefaultPrevented()) {
			e.preventDefault()

			var $this = $(this).loading()

			$.ajax({
					type: $this.data('submit') || $this.attr('method') || 'POST',
					url: $this.attr('action'),
					data: $this.serializeObject()
				})
				.done(function() {
					$this[0].reset()
					$this.stopLoading()
						.alert($this.data('success-msg') || "Update successful.")
						.trigger("sumitted.red")
				})
				.fail(function() {
					$this.alert('Error')
						.stopLoading()
				})
		}
	})

	/**
	 *  Debug mode
	 */
	$(document).keypress(function(e) {
		if (e.key === "§") {
			$('body').toggleClass('debug-mode')
		}
	})

	/**
	 * Validation plugin on modal
	 */
	$('body').on('loaded.red.validator', function() {
		if ($.fn.validator)
			$(this).find('form').validator()
	}).trigger('loaded.red.validator')

	/**
	 * fullcalendar
	 */

	// $('body').on('loaded.red.fullcalendar', function(e) {
	// 	$('.fullcalendar').fullCalendar({
	// 	})
	// }).trigger('loaded.red.fullcalendar')
})
