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
			alert('Hey');
			console.log($('#shipping_first_name').val());
			console.log($('#shipping_last_name').val());
			console.log($('#shipping_company').val());
			console.log($('#shipping_address_1').val());
			console.log($('#shipping_address_2').val());
			console.log($('#shipping_city').val());
			console.log($('#select2').val());-shipping_state-container
			console.log($('#shipping_postcode').val());
			console.log($('#shipping_phone').val());
			console.log($('#shipping_email').val());
			console.log($("input['name']['mc4wp-subscribe']").val());
			console.log($('#order_comments').val());
	</script>
		<?php
	}
}

add_action( 'gform_pre_submission', 'pre_submission_handler' );
