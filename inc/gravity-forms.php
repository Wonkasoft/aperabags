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

		echo "<script>
			console.log('shipping_first_name: '+ jQuery('#shipping_first_name').val());
			console.log('shipping_last_name: ' + jQuery('#shipping_last_name').val());
			console.log('shipping_company: ' + jQuery('#shipping_company').val());
			console.log('shipping_address_1: ' + jQuery('#shipping_address_1').val());
			console.log('shipping_address_2: ' + jQuery('#shipping_address_2').val());
			console.log('shipping_city: ' + jQuery('#shipping_city').val());
			console.log('shipping_state: ' + jQuery('#shipping_state').val());
			console.log('shipping_postcode: ' + jQuery('#shipping_postcode').val());
			console.log('shipping_phone: ' + jQuery('#shipping_phone').val());
			console.log('shipping_email: ' + jQuery('#shipping_email').val());
			console.log('mc4wp-subscribe: ' + jQuery('input[name='mc4wp-subscribe']').val());
			console.log('order_comments: ' + jQuery('#order_comments').val());
			" . $shipping_first_name = . " jQuery('#shipping_first_name').val();
			// $shipping_last_name =  jQuery('#shipping_last_name').val();
			// $shipping_company =  jQuery('#shipping_company').val();
			// $shipping_address_1 =  jQuery('#shipping_address_1').val();
			// $shipping_address_2 =  jQuery('#shipping_address_2').val();
			// $shipping_city =  jQuery('#shipping_city').val();
			// $shipping_state =  jQuery('#shipping_state').val();
			// $shipping_postcode =  jQuery('#shipping_postcode').val();
			// $shipping_phone =  jQuery('#shipping_phone').val();
			// $shipping_email =  jQuery('#shipping_email').val();
			// $mc4wp_subscribe =  jQuery('input[name='mc4wp-subscribe']').val();
			// $order_comments =  jQuery('#order_comments').val();
	 </script>";
		echo '<pre>';
		print_r( $shipping_first_name );
		echo '</pre>';
	}
}

add_action( 'gform_pre_submission', 'pre_submission_handler' );
