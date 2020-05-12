<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="wonka checkout-form-section-title"><h5 class="wonka wonka-h5">2. Delivery Options <span>(US only)</span></h5></div>
<?php
$available_methods = WC()->session->get( 'shipping_for_package_0' )['rates'];
$chosen_method     = ( array_key_exists( 0, WC()->session->get( 'chosen_shipping_methods' ) ) ) ? WC()->session->get( 'chosen_shipping_methods' )[0] : '';
$shipping_methods  = WC()->shipping->get_shipping_methods();
?>

<?php if ( ! is_user_logged_in() ) : ?>
<div class="card wonka-card wonka-card-shipping-ads">

		<ul id="shipping_ad" class="woocommerce-shipping-ads list-group list-group-flush">
			<li class="list-group-item card-title"><h6>Perks Members</h6></li>
			<?php
			foreach ( $shipping_methods as $index => $method ) :
				$current_method = '';

				if ( 'free_shipping' === $index && 25 < WC()->cart->subtotal ) :
					?>
					<li class="list-group-item">
					<?php

					printf( '<input type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_ad checkout-signup-pop" />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ) ); // WPCS: XSS ok.

					printf( '<label for="shipping_method_%1$s_%2$s" data-label="%1$d">%3$s</label>', $index, esc_attr( sanitize_title( $method->id ) ), $method->method_title . ' <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>0</span>' ); // WPCS: XSS ok.


					do_action( 'woocommerce_after_shipping_rate', $method, $index );
					?>
					</li>
					<?php
				endif;

				if ( 'USPS_Priority_Mail_under_25' === $index && 25 > WC()->cart->subtotal ) :
					?>
					<li class="list-group-item">
					<?php
					$current_method = new WC_Priority_Mail_under_25_Method();

					printf( '<input type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_ad checkout-signup-pop" />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ) ); // WPCS: XSS ok.

					printf( '<label for="shipping_ad_%1$s_%2$s" data-label="%1$d">%3$s</label>', $index, esc_attr( sanitize_title( $method->id ) ), $method->title . ' <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>10.00</span>' ); // WPCS: XSS ok.


					do_action( 'woocommerce_after_shipping_rate', $method, $index );
					?>
					</li>
					<?php
				endif;

				if ( 'USPS_Priority_Mail_Express' === $index ) :
					?>
					<li class="list-group-item">
					<?php
					$current_method = new WC_Priority_Mail_Express_Shipping_Method();

					printf( '<input type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_ad checkout-signup-pop" />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ) ); // WPCS: XSS ok.

					printf( '<label for="shipping_method_%1$s_%2$s" data-label="%1$d">%3$s</label>', $index, esc_attr( sanitize_title( $method->id ) ), $method->title . ' <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>30.00</span>' ); // WPCS: XSS ok.


					do_action( 'woocommerce_after_shipping_rate', $method, $index );
					?>
					</li>
				<?php endif; ?>

			<?php endforeach; ?>
		</ul>
</div>
<?php endif; ?>
<div class="card wonka-card wonka-card-shipping-selection">

<?php if ( $available_methods ) : ?>
		<ul id="shipping_method" class="woocommerce-shipping-methods list-group list-group-flush">
			<?php
			if ( ! is_user_logged_in() ) :
				?>
				<li class="list-group-item card-title"><h6>Guests</h6></li>
				<?php
			else :
				?>
				<li class="list-group-item card-title"><h6>Perks Members</h6></li>
			<?php endif; ?>
			<?php foreach ( $available_methods as $index => $method ) : ?>
				<li class="list-group-item">
					<?php

					if ( 1 < count( $available_methods ) ) {
						printf( '<input type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" %4$s />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ), checked( $method->id, $chosen_method, false ) ); // WPCS: XSS ok.
					} else {
						printf( '<input type="hidden" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ) ); // WPCS: XSS ok.
					}

					printf( '<label for="shipping_method_%1$s_%2$s" data-label="%1$d">%3$s</label>', $index, esc_attr( sanitize_title( $method->id ) ), wc_cart_totals_shipping_method_label( $method ) ); // WPCS: XSS ok.

					do_action( 'woocommerce_after_shipping_rate', $method, $index );
					?>
				</li>
			<?php endforeach; ?>
		</ul>
<?php endif; ?>
</div>
