<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

$guest = ( isset( $_GET['guestcheckout'] ) ) ? wp_kses_post( wp_unslash( $_GET['guestcheckout'] ) ) : 'false';
WC()->session->set( 'chosen_shipping_methods', array() );

if ( ! is_user_logged_in() && 'false' === $guest ) :
	echo do_shortcode( '[wc_login_register]' );
else :
	$newly_registered = ( isset( $_GET['new_member'] ) ) ? wp_kses_post( wp_unslash( $_GET['new_member'] ) ) : false;
	if ( $newly_registered ) :
		$user = wp_get_current_user();

		if ( 0 !== $user ) :
			$redeem_msg = get_option( 'rs_message_user_points_redeemed_in_cart' );
			WC()->session->set( 'auto_redeemcoupon', 'yes' );
			update_option( 'rs_enable_disable_auto_redeem_points', 'yes' );
			update_option( 'rs_enable_disable_auto_redeem_checkout', 'yes' );
			update_option( 'rs_message_user_points_redeemed_in_cart', "Congrats! You've just earned an extra $10 in free shipping on this order." );
			$capture = RSRedeemingFrontend::redeem_points_for_user_automatically();
			update_option( 'rs_enable_disable_auto_redeem_points', 'no' );
			update_option( 'rs_enable_disable_auto_redeem_checkout', 'no' );
			update_option( 'rs_message_user_points_redeemed_in_cart', $redeem_msg );
		endif;
	endif;

	do_action( 'woocommerce_before_checkout_form', $checkout );

	// If checkout registration is disabled and not logged in, the user cannot checkout.
	if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
		echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
		return;
	}
		do_action( 'wonka_checkout_before_checkout_form_custom', $checkout );
	?>

	<form name="checkout" autocomplete="off" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
		

		<?php if ( $checkout->get_checkout_fields() ) : ?>

			<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

			<div class="row wonka-checkout-row">
			<div class="col-12" id="customer_details">
				<div class="row">
				<div class="col-12">
					<?php do_action( 'woocommerce_checkout_shipping' ); ?>
				</div><!-- .col-12 -->
				</div>
			</div><!-- #customer_details -->
			</div><!-- .row -->
			
			<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

		<?php endif; ?>

				<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
				

					<?php do_action( 'woocommerce_checkout_order_review' ); ?>

				
				<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
	</form>
	<?php do_action( 'wonka_checkout_after_checkout_form_custom', $checkout ); ?>

	<?php
	do_action( 'woocommerce_after_checkout_form', $checkout );

endif;
