<?php
/**
 * Login form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.6.0
 */

defined( 'ABSPATH' ) || exit;

if ( is_user_logged_in() ) {
	return;
}

?>
<form class="woocommerce-form col woocommerce-form-login login" method="post" <?php echo ( $hidden ) ? 'style="display:none;"' : ''; ?>>

	<?php do_action( 'woocommerce_login_form_start' ); ?>

	<?php echo ( $message ) ? wpautop( wptexturize( $message ) ) : ''; // @codingStandardsIgnoreLine ?>

	<div class="form-row form-row-first form-group wonka-form-group">

		<label for="username" class="sr-only"><?php esc_html_e( 'Username or email', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
		<div class="input-group">
			<input type="text" class="input-text form-control wonka-form-control" name="username" id="username" autocomplete="username" placeholder="<?php esc_html_e( 'Username or email', 'woocommerce' ); ?>" />
			<div class="invalid-feedback username"></div>
		</div>
	</div>

	<div class="form-row form-row-last form-group wonka-form-group">

		<label for="password" class="sr-only"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
		<div class="input-group">
			<input class="input-text form-control wonka-form-control" type="password" name="password" id="password" autocomplete="current-password" placeholder="<?php esc_html_e( 'Password', 'woocommerce' ); ?>" /><div class="input-group-append"><div class="input-group-text"><i toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></i></div></div>
			<div class="invalid-feedback password"></div>
		</div>
	</div>

	<?php do_action( 'woocommerce_login_form' ); ?>

	<div class="form-row form-group wonka-form-group">
		<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
		<button type="submit" class="button wonka-btn" name="login" value="<?php esc_attr_e( 'Login', 'woocommerce' ); ?>"><?php esc_html_e( 'Login', 'woocommerce' ); ?></button>
		<input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ); ?>" />
		<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
			<input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox wonka-input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
		</label>
	</div>
	<div class="lost_password">
		<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
	</div>

	<div class="clear"></div>

	<?php do_action( 'woocommerce_login_form_end' ); ?>

</form>
