<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="woocommerce-order">

	<?php if ( $order ) : ?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'woocommerce' ) ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php _e( 'My account', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</p>

		<?php else : ?>

			<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'woocommerce' ), $order ); ?></p>

			<table class="woocommerce-order-overview woocommerce-thankyou-order-details order_details table table-hover table-responsive">
				<thead>
					<tr>
						<th class="<?php _e( 'order-number-header', 'woocommerce' ); ?>">
							<?php _e( 'Order number', 'woocommerce' ); ?>
						</th>
						<th class="<?php _e( 'date-header-cell', 'woocommerce' ); ?>">
							<?php _e( 'Date', 'woocommerce' ); ?>
						</th>
						<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
						<th class="<?php _e( 'email-header-cell', 'woocommerce' ); ?>">
							<?php _e( 'Email', 'woocommerce' ); ?>
						</th>
						<?php endif; ?>
						<th class="<?php _e( 'total-header-cell', 'woocommerce' ); ?>">
							<?php _e( 'Total', 'woocommerce' ); ?>
						</th>
						<?php if ( $order->get_payment_method_title() ) : ?>
						<th class="<?php _e( 'payment-method-header', 'woocommerce' ); ?>">
							<?php _e( 'Payment method', 'woocommerce' ); ?>
						</th>
						<?php endif; ?>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<strong><?php echo $order->get_order_number(); ?></strong>
						</td>
						<td>
							<strong><?php echo wc_format_datetime( $order->get_date_created() ); ?></strong>
						</td>
						<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
						<td>
							<strong><?php echo $order->get_billing_email(); ?></strong>
						</td>
						<?php endif; ?>
						<td>
							<strong><?php echo $order->get_formatted_order_total(); ?></strong>
						</td>
						<?php if ( $order->get_payment_method_title() ) : ?>
						<td>
							<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
						</td>
						<?php endif; ?>
					</tr>
				</tbody>
			</table>
		<?php endif; ?>

		<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
		<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

	<?php else : ?>

		<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'woocommerce' ), null ); ?></p>

	<?php endif; ?>

</div>
