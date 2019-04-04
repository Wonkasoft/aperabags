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
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/** @global WC_Checkout $checkout */

?>
<div class="woocommerce-billing-fields">
	<?php if ( true === WC()->cart->needs_shipping_address() ) : ?>

		<h3 id="ship-to-different-address">
			<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
				<input id="ship-to-different-address-checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" <?php checked( apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 ), 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" /> <span><?php _e( 'Bill to a different address?', 'woocommerce' ); ?></span>
			</label>
		</h3>

	<div class="shipping_address">

	<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

	<div class="woocommerce-billing-fields__field-wrapper">
		<?php
			$fields = $checkout->get_checkout_fields( 'billing' );

			foreach ( $fields as $key => $field ) {
				if ( $key !== 'billing_email' ) :
					
					if ( $key === 'billing_country' ) :
						$field['priority'] = 95;
					endif;

					if ( !isset($field['placeholder'] ) ) :
						$field['placeholder'] = $field['label'];
					endif;
					
					if ( isset( $field['class'] ) ) :
						array_push( $field['class'], 'wonka-form-group', 'form-group' ) ;
					else:
						$field['class'] = array( 'wonka-form-group', 'form-group' );
					endif;

					if ( isset( $field['label_class'] ) ) :
						array_push( $field['label_class'], 'wonka-sr-only', 'sr-only' ) ;
					else:
						$field['label_class'] = array( 'wonka-sr-only', 'sr-only' );
					endif;

					if ( isset( $field['input_class'] ) ) :
						array_push( $field['input_class'], 'wonka-form-control', 'form-control' ) ;
					else:
						$field['input_class'] = array( 'wonka-form-control', 'form-control' );
					endif;

					if ( isset( $field['country_field'], $fields[ $field['country_field'] ] ) ) {
						$field['country'] = $checkout->get_value( $field['country_field'] );
					}
					woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
				endif;
			}
		?>
	</div>

	<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>
	</div>
	<?php endif; ?>
</div>