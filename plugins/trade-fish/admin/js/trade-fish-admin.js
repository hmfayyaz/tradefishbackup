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
	jQuery(document).ready(function ($) {

		if(custom_admin_vars.post_type == 'signals') {
			$("#posts-filter").submit(function (event) {
				event.preventDefault(); // Prevent the default form submission

				// Base URL
				var baseUrl = "https://tradefish.app/wp-admin/edit.php?";

				// Collect form data
				var postType = "signals"; // Assuming 'signals' is a constant
				var postStatus = "all"; // Assuming 'all' is a constant for post_status
				var paged = 1; // Assuming 1 is a constant for paged

				// Get the selected value from an input or select field
				// Get the selected value from inputs and selects
				var m = $("select[name='m']").val(); // Get the selected value of a select input with name 'm'
				var filterByType = $("select[name='filter_by_type']").val(); // Get the selected value of a select input with name 'filter_by_type'
				var seoFilter = $("select[name='seo_filter']").val(); // Get the selected value of a select input with name 'seo_filter'
				var readabilityFilter = $("select[name='readability_filter']").val(); // Get the selected value of a select input with name 'readability_filter'

				// Build the query string
				var queryString = [
					"s", // search parameter empty
					"post_status=" + postStatus,
					"post_type=" + postType,
					"action=-1", // Assuming no specific action is selected
					"m=" + encodeURIComponent(m),
					"filter_by_type=" + encodeURIComponent(filterByType),
					"seo_filter=" + encodeURIComponent(seoFilter),
					"readability_filter=" + encodeURIComponent(readabilityFilter),
					"filter_action=Filter",
					"paged=" + paged
				].join("&");

				// Construct the full URL
				var fullUrl = baseUrl + queryString;

				// Redirect to the constructed URL
				window.location.href = fullUrl;
			});
		}
		$(".status_radio").click(function () {
			// console.log('here');
			var radioValue = $(this).val();
			var sec = $(this).attr("data-sec");
			if(radioValue == 'incorrect' || radioValue == 'correct'){
				$('#'+sec).show();
			}
			else{
				$('#'+sec).hide();
			}
		});


		$('.signal_result_save_button').on('click', function () {
			var postID = $(this).attr("data-id");
			var signal_value = $(this).closest('._signal_values').find('input[name="signal_result_'+postID+'"]:checked').val();

			var closing_price = $(this).closest('._signal_values').find('input[name="_closing_prize"]').val();
			var post_id = $(this).closest('._signal_values').find('input[name="_post_id_'+postID+'"]').val();
			var realized_profit_or_loss = $(this).closest('._signal_values').find('input[name="realized_profit_or_loss"]').val();
			var _leverage = $(this).closest('._signal_values').find('input[name="_leverage"]').val();
			var platform_name = $(this).closest('._signal_values').find('input[name="platform_name"]').val();
			var platform_url = $(this).closest('._signal_values').find('input[name="platform_url"]').val();

			// console.log(post_id,'==',signal_value,'==',closing_price);

			// return

			// AJAX request
			$.ajax({
				url: custom_admin_vars.ajax_url,
				data: {
					action: 'save_signal_result',
					// security: custom_admin_vars.custom_nonce,
					post_id: post_id,
					signal_value: signal_value,
					_closing_prize: closing_price,
					realized_profit_or_loss: realized_profit_or_loss,
					_leverage: _leverage,
					platform_name: platform_name,
					platform_url: platform_url,
				},
				success: function (response) {
					// Handle success
					location.reload();
				},
				error: function (error) {
					// Handle error
					console.error('Error saving data: ' + error.responseText);
				}
			});
		});
	});

})( jQuery );
