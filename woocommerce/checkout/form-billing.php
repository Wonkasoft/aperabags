<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
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
 * @global WC_Checkout $checkout
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="woocommerce-billing-fields">
	<?php if ( true === WC()->cart->needs_shipping_address() ) : ?>

	<div class="checkout-form-section-title"><h5 class="billing-address-section-title">Billing Address</h5></div>

	<div class="card">
		<ul class="list-group list-group-flush billing-address-options">
			<li class="list-group-item">
				<div id="bill-to-different-address-radio1" class="custom-control custom-radio">
					<input id="bill-to-different-address-checkbox1" class="input-radio custom-control-input" type="radio" <?php checked( apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 ), 1 ); ?> name="ship_to_different_address" />
					<label class="custom-control-label wonka-custom-control-label" for="bill-to-different-address-checkbox1"><span><?php esc_html_e( 'Same as shipping address', 'woocommerce' ); ?></span></label>
				</div>
			</li>
			<li class="list-group-item">
				<div id="bill-to-different-address-radio2" class="custom-control custom-radio">
					<input id="bill-to-different-address-checkbox2" class="input-radio custom-control-input" type="radio" <?php checked( apply_filters( 'woocommerce_ship_to_different_address_checked', 'billing' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 ), 1 ); ?> name="ship_to_different_address" />
					<label class="custom-control-label wonka-custom-control-label" for="bill-to-different-address-checkbox2"><span><?php esc_html_e( 'Use a different billing address', 'woocommerce' ); ?></span></label>
				</div>
				<div class="billing_address">

					<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

					<div class="woocommerce-billing-fields__field-wrapper">
						<?php
						$fields = $checkout->get_checkout_fields( 'billing' );

						foreach ( $fields as $key => $field ) {

							if ( isset( $field['country_field'], $fields[ $field['country_field'] ] ) ) {
								$field['country'] = $checkout->get_value( $field['country_field'] );
							}
							woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
						}
						?>
					</div>

					<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>
				</div><!-- .billing_address -->
			</li>
		</ul><!-- .list-group -->
	</div><!-- .card -->
<?php endif; ?>
</div><!-- .woocommerce-billing-fields -->
