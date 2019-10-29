<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
<div class="row row-account-wrapper justify-content-center">
	<div class="col-8">


<div class="row justify-content-center" id="customer_login">

	<div class="col-12 col-lg-6 login">

<?php endif; ?>

		<h2><?php esc_html_e( 'Welcome Back', 'woocommerce' ); ?></h2>

		<form class="login" method="post">

			<?php do_action( 'woocommerce_login_form_start' ); ?>

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
					<input class="form-control input-text" type="password" name="password" id="password" autocomplete="current-password" placeholder="<?php esc_html_e( 'Password *', 'woocommerce' ); ?>" /><div class="input-group-append"><div class="input-group-text"><i toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></i></div></div>
					<div class="invalid-feedback password"></div>
				</div>
			</div>
			<p class="form-row">
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
				<button type="submit" class="woocommerce-Button button wonka-btn" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
				</label>
			</p>

			<p class="woocommerce-LostPassword lost_password">
				<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
			</p>
			
			<?php do_action( 'woocommerce_login_form' ); ?>

			<?php do_action( 'woocommerce_login_form_end' ); ?>

		</form>

<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

	</div>

	<div class="col-12 col-lg-6 register text-center">

		<h2><?php esc_html_e( 'I\'m New Here...', 'woocommerce' ); ?></h2>

		<!-- <p class="create-account-wrapper form-row"> -->
				<button type="button" class="create-account-full button wonka-btn" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Create Account', 'woocommerce' ); ?></button>
		<!-- </p> -->

		<form method="post" class="woocommerce-form woocommerce-form-register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

			<?php do_action( 'woocommerce_register_form_start' ); ?>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
				<div class="form-group">
					<label for="reg_username" class="sr-only"><?php esc_html_e( 'Username', 'woocommerce' ); ?>&nbsp;<span class="required sr-only">*</span></label>	
					<div class="input-group">

						<input type="text" class="form-control input-text" name="username" id="reg_username" placeholder="<?php esc_html_e( 'Username *', 'woocommerce' ); ?>" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
						<div class="invalid-feedback reg_username"></div>
					</div>
				</div>

			<?php endif; ?>

			<div class="form-group">
				<label for="reg_email" class="sr-only"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required sr-only">*</span></label>			
				<div class="input-group">

					<input type="email" class="form-control input-text" name="email" id="reg_email" autocomplete="email" placeholder="<?php esc_html_e( 'Email address *', 'woocommerce' ); ?>" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
					<div class="invalid-feedback reg_email"></div>
				</div>
			</div>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
			<div class="form-group">
				<label for="register_password" class="sr-only"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required sr-only">*</span></label>
				<div class="input-group">
					
					<input type="password" class="form-control input-text" name="password" id="register_password" autocomplete="new-password" placeholder="<?php esc_html_e( 'Password *', 'woocommerce' ); ?>" /><div class="input-group-append"><div class="input-group-text"><i toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></i></div></div>
					<div class="invalid-feedback register_password"></div>
				</div>
		</div>

			<?php endif; ?>

			<p class="woocommerce-FormRow form-row">
				<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
				<button type="submit" class="woocommerce-Button button wonka-btn" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Create My Account', 'woocommerce' ); ?></button>
			</p>

			<?php do_action( 'woocommerce_register_form' ); ?>

			<?php do_action( 'woocommerce_register_form_end' ); ?>

		</form>
			<div class="loggin-toggle-wrapper">
				<p><?php esc_html_e( 'Already have an account?', 'woocommerce' ); ?></p>
				<button type="submit" class="login-slide-btn button wonka-btn" name="register" ><?php esc_html_e( 'Back to Login', 'woocommerce' ); ?></button>
			</div>

	</div>

</div>

</div>
</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
