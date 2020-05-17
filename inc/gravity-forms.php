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
			console.log(jQuery('#shipping_first_name').val());
			console.log(jQuery('#shipping_last_name').val());
			console.log(jQuery('#shipping_company').val());
			console.log(jQuery('#shipping_address_1').val());
			console.log(jQuery('#shipping_address_2').val());
			console.log(jQuery('#shipping_city').val());
			console.log(jQuery('#select2').val());-shipping_state-container
			console.log(jQuery('#shipping_postcode').val());
			console.log(jQuery('#shipping_phone').val());
			console.log(jQuery('#shipping_email').val());
			console.log(jQuery("input['name']['mc4wp-subscribe']").val());
			console.log(jQuery('#order_comments').val());
	</script>
		<?php
	}
}

add_action( 'gform_pre_submission', 'pre_submission_handler' );
