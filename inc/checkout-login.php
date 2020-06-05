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
		<div class="col-12 col-lg-6 checkout-login login">

			<h2><?php esc_html_e( 'Get $10 off this order', 'woocommerce' ); ?></h2>
			<ul class="disclosure-list">
				<li class="disclosure-list-item"><sup>Plus</sup></li>
				<li class="disclosure-list-item"><sup><i class="fas fa-check"></i> Free Priority Shipping</sup></li>
				<li class="disclosure-list-item"><sup><i class="fas fa-check"></i> Earn AperaCash</sup></li>
			</ul>

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
				<div class="form-row form-button-row">
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
				<button type="submit" class="woocommerce-Button button wonka-btn" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>
			</div>
				<div class="woocommerce-LostPassword lost_password">
				<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Forgot your password?', 'woocommerce' ); ?></a>
			</div>

				<div class="woocommerce-needAccount needAcount">
					Already have an account, <a href="#" class="checkout-signup-pop">sign in</a>
			</div>
				<?php

				do_action( 'woocommerce_login_form_end' );
				?>
			</form>

		</div>

			<div class="col-12 col-lg-6 guest-checkout-side">
				<h2><?php echo esc_html( sprintf( __( 'Or Checkout as a Guest', 'woocommerce' ) ) ); ?></h2>

				<a href="<?php echo esc_url( get_site_url() ) . '/checkout/?guestcheckout=true'; ?>" class="btn wonka-btn">Guest Checkout</a>
			</div>
		</div>
	<?php

	return ob_get_clean();
}
add_shortcode( 'wc_login_register', 'ws_wc_login_register' );
