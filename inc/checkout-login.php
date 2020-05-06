<?php
/**
 * Custom login/register form(s) shortcode.
 *
 * @author Louis <Support@wonkasoft.com>
 * @package aperabags
 * @since 1.0.3 Custom login/register page before checkout
 */

/**
 * This is the sign in form on checkout.
 */
function ws_wc_login_register() {
	ob_start();
	do_action( 'woocommerce_before_customer_login_form' ); ?>

	<div class="row justify-content-center" id="customer_login">
		<div class="col-12 col-lg-6 login">

			<h2><?php esc_html_e( 'Sign In and Earn Rewards', 'woocommerce' ); ?></h2>

			<form class="woocommerce-form woocommerce-form-login login" method="post">
			<?php
				do_action( 'woocommerce_login_form_start' );

			?>
				<div class="form-group">
				<label for="username" class="sr-only"><?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>&nbsp;<span class="required sr-only">*</span></label>			
				<div class="input-group">
					<input type="text" class="form-control input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" placeholder="<?php esc_html_e( 'Username or email address *', 'woocommerce' ); ?>" /><?php // @codingStandardsIgnoreLine ?>
					<div class="invalid-feedback username"></div>
				</div>
		
			</div>
				<div class="form-group">
				<label for="password" class="sr-only"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required sr-only">*</span></label>
				<div class="input-group">
					<input class="form-control input-text" type="password" name="password" id="password" autocomplete="current-password" placeholder="<?php esc_html_e( 'Password *', 'woocommerce' ); ?>" />
					<div class="input-group-append">
						<div class="input-group-text">
							<i toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></i>
						</div>
					</div>
					<div class="invalid-feedback password"></div>
				</div>
			</div>
				<?php

				do_action( 'woocommerce_login_form' );

				?>
				<div class="form-row">
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
				<button type="submit" class="woocommerce-Button button wonka-btn" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>
			</div>
				<div class="woocommerce-LostPassword lost_password">
				<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Forgot your password?', 'woocommerce' ); ?></a>
			</div>
				<?php

				do_action( 'woocommerce_login_form_end' );
				?>
			</form>

		</div>

			<div class="col-12 col-lg-6">
				<h2><?php echo esc_html( sprintf( __( 'Or Checkout as a Guest', 'woocommerce' ) ) ); ?></h2>

				<a href="<?php site_url(); ?>/checkout/?guestcheckout=true" class="btn wonka-btn">Guest Checkout</a>
			</div>
		</div>
	<?php

	return ob_get_clean();
}
add_shortcode( 'wc_login_register', 'ws_wc_login_register' );


/**
 * Redirect to login/register pre-checkout.
 *
 * Redirect guest users to login/register before completing a order.
 *
 * @author Louis <Support@wonkasoft.com>
 * @since 1.0.3 This is to force the login page before checkout
 */
function ws_redirect_pre_checkout() {
	if ( ! function_exists( 'wc' ) ) {
		return;
	}

	$guest            = ( isset( $_GET['guestcheckout'] ) ) ? wp_kses_data( wp_unslash( $_GET['guestcheckout'] ) ) : false;
	$redirect_page_id = 16367; // Update this to the page you would like to load before checkout.
	if ( is_checkout() ) :
		if ( is_user_logged_in() && is_page( $redirect_page_id ) || 'true' === $guest ) {
			wp_safe_redirect( get_permalink( wc_get_page_id( 'checkout' ) ) );
			die;
		} else {
			wp_safe_redirect( get_permalink( $redirect_page_id ) );
			die;
		}
	endif;
}
add_action( 'template_redirect', 'ws_redirect_pre_checkout' );
