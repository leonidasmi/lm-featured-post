(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
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


	$(function() {
		
	    if ($( '.under-header' ).length){
	        $( "header" ).after( $('.under-header') );
	        // If we want the featured post to be displayed inside the header we can use instead: 
	        // $( "header" ).append( $('.under-header') );
	        $( '.under-header' ).show();
	    }

	    if ($( '.top-header' ).length){       	
			$('.top-header').prependTo( "body" );
	        $( '.top-header' ).show();
	    }

     });
})( jQuery );
