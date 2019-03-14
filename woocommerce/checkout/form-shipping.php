<?php
/**
 * Checkout shipping information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-shipping.php.
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

?>
<div class="woocommerce-shipping-fields">
	<?php if ( true === WC()->cart->needs_shipping_address() ) : ?>

		<h3 id="ship-to-different-address">
			<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
				<input id="ship-to-different-address-checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" <?php checked( apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 ), 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" /> <span><?php _e( 'Ship to a different address?', 'woocommerce' ); ?></span>
			</label>
		</h3>

		<div class="shipping_address">

			<?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>

			<div class="woocommerce-shipping-fields__field-wrapper">
				<?php
					$fields = $checkout->get_checkout_fields( 'shipping' );

					foreach ( $fields as $key => $field ) {
						
						if ( !isset($field['placeholder'] ) ) :
							if ( $field['type'] !== 'select' ) :
								$field['placeholder'] = $field['label'];
							endif;
						endif;

						if ( isset( $field['class'] ) ) :
							array_push( $fields[$key]['class'], 'wonka-form-group', 'form-group' ) ;
						else:
							$field['class'] = array( 'wonka-form-group', 'form-group' );
						endif;

						if ( isset( $field['label_class'] ) ) :
							array_push( $fields[$key]['label_class'], 'wonka-sr-only', 'sr-only' ) ;
						else:
							$field['label_class'] = array( 'wonka-sr-only', 'sr-only' );
						endif;

						if ( isset( $field['input_class'] ) ) :
							array_push( $fields[$key]['input_class'], 'wonka-form-control', 'form-control' ) ;
						else:
							$field['input_class'] = array( 'wonka-form-control', 'form-control' );
						endif;

						if ( isset( $field['country_field'], $fields[ $field['country_field'] ] ) ) {
							$field['country'] = $checkout->get_value( $field['country_field'] );
						}
						woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
					}
				?>
			</div>

			<?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>

		</div>

	<?php endif; ?>
</div>
<div class="woocommerce-additional-fields">
	<?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>

	<?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>
		
		<div class="row wonka-row">
			<div class="col col-12">
		<?php if ( ! WC()->cart->needs_shipping() || wc_ship_to_billing_address_only() ) : ?>

			<h3><?php _e( 'Additional information', 'woocommerce' ); ?></h3>

		<?php endif; ?>

		<div class="woocommerce-additional-fields__field-wrapper">
			<?php foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) :
				if ( isset( $field['class'] ) ) :
					array_push( $fields[$key]['class'], 'wonka-form-group', 'form-group' ) ;
				else:
					$field['class'] = array( 'wonka-form-group', 'form-group' );
				endif;

				if ( isset( $field['label_class'] ) ) :
					array_push( $fields[$key]['label_class'], 'wonka-sr-only', 'sr-only' ) ;
				else:
					$field['label_class'] = array( 'wonka-sr-only', 'sr-only' );
				endif;

				if ( isset( $field['input_class'] ) ) :
					array_push( $fields[$key]['input_class'], 'wonka-form-control', 'form-control' ) ;
				else:
					$field['input_class'] = array( 'wonka-form-control', 'form-control' );
				endif;
				woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
			<?php endforeach; ?>
		</div>
		</div><!-- .col-12 -->
	</div><!-- .wonka-row -->
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
</div>
