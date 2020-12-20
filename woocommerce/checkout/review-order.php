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
$chosen_method     = isset( WC()->session->chosen_shipping_methods[0] ) ? WC()->session->chosen_shipping_methods[0] : '';
?>

<?php if ( ! is_user_logged_in() ) : ?>
<div class="card wonka-card wonka-card-shipping-ads">

		<ul id="shipping_ad" class="woocommerce-shipping-ads list-group list-group-flush checkout-signup-pop">
			<li class="list-group-item card-title"><h6>Perks Members</h6></li>
			<?php
			foreach ( $available_methods as $index => $method ) :
				if ( 'FedEx_Ground' === $method->method_id && 25 < WC()->cart->subtotal || 'FedEx_Ground_Under_25' === $method->method_id && 25 > WC()->cart->subtotal || 'FedEx_Express' === $method->method_id ) :
					?>
						<li class="list-group-item">
					<?php
					endif;

				if ( ( 'FedEx_Ground' === $method->method_id && 25 < WC()->cart->subtotal ) || ( 'FedEx_Ground_Under_25' === $method->method_id && 25 > WC()->cart->subtotal ) || ( 'FedEx_Express' === $method->method_id ) ) :
					if ( 1 < count( $available_methods ) ) {
						printf( '<input type="radio" value="%1$s" disabled class="shipping_method" %2$s />', esc_attr( sanitize_title( $method->id ) ), checked( $method->id, $chosen_method, false ) ); // WPCS: XSS ok.
					} else {
						printf( '<input type="hidden" value="%1$s" class="shipping_method" />', esc_attr( $method->id ) ); // WPCS: XSS ok.
					}

					printf( '<label for="shipping_method_%1$s_%2$s" data-label="%1$d">%3$s</label>', $index, esc_attr( sanitize_title( $method->id ) ), wc_cart_totals_shipping_method_label( $method ) ); // WPCS: XSS ok.
					endif;

				if ( 'FedEx_Ground' === $method->method_id && 25 < WC()->cart->subtotal || 'FedEx_Ground_Under_25' === $method->method_id && 25 > WC()->cart->subtotal || 'FedEx_Express' === $method->method_id ) :
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
				foreach ( $available_methods as $index => $method ) :

					if ( 'free_shipping' !== $method->method_id && 'USPS_Priority_Mail_NP' !== $method->method_id && 'USPS_Priority_Mail_Under_25' !== $method->method_id && 'FedEx_Ground' !== $method->method_id && 'FedEx_2day' !== $method->method_id && 'FedEx_Ground_Under_25' !== $method->method_id && 'FedEx_Express' !== $method->method_id ) :
						?>
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
					<?php endif; ?>
				<?php endforeach; ?>
			<?php else : ?>
				<li class="list-group-item card-title"><h6>Perks Members</h6></li>
				<?php
				foreach ( $available_methods as $index => $method ) :
					if ( 'FedEx_Ground' === $method->method_id && 25 < WC()->cart->subtotal || 'FedEx_Ground_Under_25' === $method->method_id && 25 > WC()->cart->subtotal || 'FedEx_2day' === $method->method_id || 'FedEx_Express' === $method->method_id ) :
						?>
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
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
		</ul>
<?php endif; ?>
</div>
<p class="shipping-message">
	<b>FedEx Last days to ship for delivery by December 25</b><br />
	<span style="color:red;">FedEx Ground | Tuesday, December 15 10am<br />
	FedEx 2Day | Tuesday, December 22 10am // Free December 19th and 20th<br />
	FedEx Standard Overnight | Wednesday, December 23 10am // Free December 21st<br /></span>
</p>
