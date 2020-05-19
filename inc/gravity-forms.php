<?php
/**
 * All Gravity form customizations
 *
 * @author Louis <Support@wonkasoft.com>
 * @package aperabags
 * @since 1.0.3 All Gravity form customizations
 */


/**
 * This filter is for all gforms pre submission use $form['title'] to scope the form
 *
 * @param  string $form All form fields and data
 * @return void       This filter is for all gforms pre submission
 */
function pre_submission_handler( $form ) {
	if ( 'Apera Perks Registration Checkout' == $form['title'] ) {
		?>
	<script>
			console.log("shipping_first_name: "+ jQuery('#shipping_first_name').val());
			console.log("shipping_last_name: " + jQuery('#shipping_last_name').val());
			console.log("shipping_company: " + jQuery('#shipping_company').val());
			console.log("shipping_address_1: " + jQuery('#shipping_address_1').val());
			console.log("shipping_address_2: " + jQuery('#shipping_address_2').val());
			console.log("shipping_city: " + jQuery('#shipping_city').val());
			console.log("shipping_state: " + jQuery('#shipping_state').val());
			console.log("shipping_postcode: " + jQuery('#shipping_postcode').val());
			console.log("shipping_phone: " + jQuery('#shipping_phone').val());
			console.log("shipping_email: " + jQuery('#shipping_email').val());
			console.log("mc4wp-subscribe: " + jQuery("input[name='mc4wp-subscribe']").val());
			console.log("order_comments: " + jQuery('#order_comments').val());


			var url = window.location.href;
			var shipping_first_name = jQuery('#shipping_first_name').val();
			var shipping_last_name =  jQuery('#shipping_last_name').val();
			var shipping_company =  jQuery('#shipping_company').val();
			var shipping_address_1 =  jQuery('#shipping_address_1').val();
			var shipping_address_2 =  jQuery('#shipping_address_2').val();
			var shipping_city =  jQuery('#shipping_city').val();
			var shipping_state =  jQuery('#shipping_state').val();
			var shipping_postcode =  jQuery('#shipping_postcode').val();
			var shipping_phone =  jQuery('#shipping_phone').val();
			var shipping_email =  jQuery('#shipping_email').val();
			var mc4wp_subscribe =  jQuery("input[name='mc4wp-subscribe']").val();
			var order_comments =  jQuery('#order_comments').val();
			console.log(url);
			url = encodeURI(url + "&shipping_first_name=" + shipping_first_name + "&shipping_last_name=" + shipping_last_name + "&shipping_company=" + shipping_company + "&shipping_address_1=" + "&shipping_address_2=" + shipping_address_2 + "&shipping_city=" + shipping_city + "&shipping_state=" + shipping_state + "&shipping_postcode=" + shipping_postcode + "&shipping_phone=" + shipping_phone + "&shipping_email=" + shipping_email + "&mc4wp_subscribe=" + mc4wp_subscribe + "&order_comments=" + order_comments);
			window.location.href = url;
			console.log(url);
	 </script>
		<?php
	}
}

add_action( 'gform_pre_submission', 'pre_submission_handler' );
