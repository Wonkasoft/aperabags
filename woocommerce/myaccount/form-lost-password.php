<?php
/**
 * Lost password form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.2
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_lost_password_form' );
?>

<div class="container">
<form method="post" class="form woocommerce-ResetPassword lost_reset_password">

	<div class="row">
		<div class="col form-message">
			<p><?php echo apply_filters( 'woocommerce_lost_password_message', esc_html__( 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'woocommerce' ) ); ?></p><?php // @codingStandardsIgnoreLine ?>
		</div>
	</div>

	<div class="row justify-content-md-center align-items-center">
			<div class="col-md-5">
				<label for="user_login"><?php esc_html_e( 'Username or email', 'woocommerce' ); ?></label>
				<div class="woocommerce-form-row form-group input-group woocommerce-form-row--first form-row form-row-first">
					<input class="woocommerce-Input form-control woocommerce-Input--text input-text" placeholder="Enter Email" type="text" name="user_login" id="user_login" autocomplete="username" />
					<div class="invalid-feedback user_login"></div>
				</div>
			</div>

				<div class="clear"></div>

				<?php do_action( 'woocommerce_lostpassword_form' ); ?>

			<div class="col-md-3 lost-btn-row pt-2">
					<div class="woocommerce-form-row">
						<input type="hidden" name="wc_reset_password" value="true" />
						<button type="submit" class="woocommerce-Button button wonka-btn" value="<?php esc_attr_e( 'Reset password', 'woocommerce' ); ?>"><?php esc_html_e( 'Reset password', 'woocommerce' ); ?></button>
					</div>

			</div>
	</div>

	<?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>


	<div class="form-message">
		<p><?php echo apply_filters( 'woocommerce_lost_password_message', esc_html__( "If you don't see the reset email in your inbox, check you spam/junk folder.  If you resubmit your request again, please verify the email you used to set up the account is spelled correctly.  Any other issues, simply submit a request using the \"blue help\" button on the lower left of this page.", 'woocommerce' ) ); ?>
	</p>
		
	</div>
</form>
</div>
<?php
do_action( 'woocommerce_after_lost_password_form' );