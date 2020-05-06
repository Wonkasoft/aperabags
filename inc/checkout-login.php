<?php

/**
 * Custom login/register form(s) shortcode.
 *
 * @author Louis <Support@wonkasoft.com>
 * @since 1.0.3 Custom login/register page before checkout
 */

function ws_wc_login_register() {
	ob_start();
	do_action( 'woocommerce_before_customer_login_form' ); ?>

	<div class="u-columns col2-set" id="customer_login">
		<div class="u-column1 col-1">

			<h3><?php esc_html_e( 'Existing customer', 'woocommerce' ); ?></h3>

			<form class="woocommerce-form woocommerce-form-login login" method="post">
			<?php
				do_action( 'woocommerce_login_form_start' );

			?>
				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="username"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>
					<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
				</p>
				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>
					<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
				</p>
				<?php

				do_action( 'woocommerce_login_form' );

				?>
				<p class="form-row">
				<?php
					wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' );

				?>
					<button type="submit" class="woocommerce-Button button" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>
					<label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
						<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
					</label>
				</p>
				<p class="woocommerce-LostPassword lost_password">
					<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
				</p>
				<?php

				do_action( 'woocommerce_login_form_end' );
				?>
			</form>

		</div>

		<div class="u-column2 col-2">

			<h3><?php echo sprintf( __( 'New at %s?', 'woocommerce' ), get_option( 'blogname' ) ); ?></h3>

			<form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >
																											 <?php
																												do_action( 'woocommerce_register_form_start' );

																												?>
				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>
					<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
				</p>
				<?php

				do_action( 'woocommerce_register_form' );

				?>
				<p class="woocommerce-FormRow form-row">
				<?php
					wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' );
				?>
					<button type="submit" class="woocommerce-Button button" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Continue ordering', 'woocommerce' ); ?></button>
				</p>
				<?php

				do_action( 'woocommerce_register_form_end' );
				?>
			</form>

		</div>
	</div>
	<?php

	do_action( 'woocommerce_after_customer_login_form' );

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
function ace_redirect_pre_checkout() {
	if ( ! function_exists( 'wc' ) ) {
		return;
	}

	$redirect_page_id = 2555; // Update this to the page you would like to load before checkout
	if ( ! is_user_logged_in() && is_checkout() ) {
		wp_safe_redirect( get_permalink( $redirect_page_id ) );
		die;
	} elseif ( is_user_logged_in() && is_page( $redirect_page_id ) ) {
		wp_safe_redirect( get_permalink( wc_get_page_id( 'checkout' ) ) );
		die;
	}
}
add_action( 'template_redirect', 'ace_redirect_pre_checkout' );
