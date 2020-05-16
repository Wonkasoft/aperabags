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
		jQuery(document).on('gform_confirmation_loaded', function(event, formId){
			alert('Hey');
		});
	</script>
		<?php
	}
}

add_action( 'gform_pre_submission', 'pre_submission_handler' );
