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
	 * 
	 */
	jQuery(document).ready(function($) {
		function fetchBooks(page = 1) {
			const data = {
				action: 'filter_books',
				author: $('#filter_author').val(),
				price: $('#filter_price').val(),
				sort: $('#filter_sort').val(),
				page: page
			};
	
			$.post(BooksAjax.ajax_url, data, function(response) {
				$('#books-results').html(response);
			});
		}
	
		$('#filter_author, #filter_price, #filter_sort').on('change', function () {
			fetchBooks(1);
		});
	
		$(document).on('click', '.books-pagination a', function (e) {
			e.preventDefault();
			const page = $(this).text();
			fetchBooks(page);
		});
	});
	

})( jQuery );
