<?php
/**
 * ZIP Program
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/zip-program.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  Wonkasoft
 * @package WooCommerce/Templates
 * @version 1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$user             = wp_get_current_user();
	$user_id      = $user->ID;
	$company_logo = ( ! empty( get_user_meta( $user_id, 'company_logo', true ) ) ) ? get_user_meta( $user_id, 'company_logo', true ) : null;

	$output = '';
if ( ! empty( $company_logo ) ) {
	$company_logo = json_decode( $company_logo );
}

?>
<div class="my-account-logo-content-wrap">
<h2>Club/Gym Logo</h2>
<?php
if ( ! empty( $company_logo->company_name ) ) {
	?>
	<span><?php esc_html_e( $company_logo->coupon_code ); ?></span>
	<?php
} else {
	?>
	<span>need a coupon code</span>
	<?php
}

if ( ! empty( $company_logo->url ) ) {
	?>
	<div class="current-logo-wrap">
		<img src="' . wp_get_attachment_image_src( $company_logo->id, 'thumbnail', false ) . '" srcset="' . wp_get_attachment_image_srcset( $company_logo->id, 'thumbnail', null ) . '" class="current-logo" />
	</div>
	<p>To update/change your logo, simply upload a new one below.</p>
	<div class="form-wrap">
	<div class="form-container">
	<?php gravity_form( 'Media Upload', false, false, false, null, true, 1, true ); ?>
	</div>
	</div>
	<?php
} else {
	?>

	<div class="current-logo-wrap">
	<div class="no-logo">You have no logo on file.</div>
	</div>
	<p>To update/change your logo, simply upload a new one below.</p>
	<div class="form-wrap">
	<div class="form-container">
	<?php gravity_form( 'Media Upload', false, false, false, null, true, 1, true ); ?>
	</div>
	</div>
	<?php
}

gravity_form( 'Design Fees Capture', false, false, false, null, true, 1, true );
?>

</div>
