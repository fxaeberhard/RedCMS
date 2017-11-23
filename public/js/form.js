/**
 *
 */

jQuery(function($) {

	function updateClass() {
		target = $(this)
		var isEmpty = ($(this).val() || $(this).text()) === ''
		$(this).toggleClass('empty', isEmpty)
			.toggleClass('not-empty', !isEmpty)
	}

	/**
	 * Add empty class to form elements
	 */
	$(document).on('blur', 'input, textarea', updateClass)

	$('body').on('loaded.red.emptyinput', function(e) {
		$(this).find('input, textarea').each(updateClass)
		// setTimeout(function() { // Do it again, in case form has been auto filled
		// 	$(this).find('input').each(updateClass)
		// }.bind(this), 500)
	}).trigger('loaded.red.emptyinput')

	// if ($.browser.mozilla) {
	$(document).on('click', 'label', function(e) {
		if (e.currentTarget === this && e.target.nodeName !== 'INPUT') {
			$(this.control).click()
		}
	})
	// }

})
