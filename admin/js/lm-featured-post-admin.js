(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

    // Add Color Picker to all inputs that have 'color-field' class
    $(function() {
        $('.color-field').wpColorPicker();

		$('#has_expiration_date').click(function() {
		    $("#expiration-datetime").slideToggle(this.checked);
		});

		$('.timepicker').timepicki({
				show_meridian:false,
				min_hour_value:0,
				max_hour_value:23,
				step_size_minutes:1,
				overflow_minutes:true,
				increase_direction:'up',
				disable_keyboard_mobile: true
		});

	    $('.MyDate').datepicker({
	        dateFormat : 'yy-mm-dd'
	    });

    });




})( jQuery );
