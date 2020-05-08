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
 * @package WooCommerce/Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="woocommerce-shipping-fields">


	<?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>

				<div class="woocommerce-shipping-fields__field-wrapper">
				<?php
				if ( ! WC()->cart->needs_shipping() ) :
					$fields = $checkout->get_checkout_fields( 'billing' );
					?>


					<h5><?php _e( 'Billing Details', 'woocommerce' ); ?></h5>

					<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

					<div class="woocommerce-billing-fields__field-wrapper">
						<?php

						foreach ( $fields as $key => $field ) {
							if ( isset( $field['country_field'], $fields[ $field['country_field'] ] ) ) {
								$field['country'] = $checkout->get_value( $field['country_field'] );
							}
							woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
						}
						?>
					</div>

					<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>

					<?php
				else :
					$fields = $checkout->get_checkout_fields( 'shipping' );
					?>

					<h5><?php _e( 'Shipping Address', 'woocommerce' ); ?></h5>
					<?php
					foreach ( $fields as $key => $field ) {
						if ( isset( $field['country_field'], $fields[ $field['country_field'] ] ) ) {
							$field['country'] = $checkout->get_value( $field['country_field'] );
						}

						if ( strtolower( $key ) !== 'shipping_email' ) :
							woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
						endif;

						if ( strtolower( $key ) === 'shipping_email' ) :
							if ( ! isset( $field['placeholder'] ) ) :
								$field['placeholder'] = $field['label'];
								$field['required']    = true;
							endif;

							woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
							?>
							<div class="wonka-newletter-form-check checkbox">
								<label for="mc4wp-subscribe">
									<input type="checkbox" class="wonka-checkbox form-checkbox" name="mc4wp-subscribe" checked="checked" value="1" />
									Keep me up to date on news and exclusive offers.	</label>
							</div>
							<?php
					endif;
					}
				endif;
				?>
			</div>

			<?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>

</div><!-- .woocommerce-shipping-fields -->

<?php if ( WC()->cart->needs_shipping() ) : ?>
<div class="woocommerce-additional-fields">
	<?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>

	<?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>

		<div class="woocommerce-additional-fields__field-wrapper">
			<?php
			foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) :
				if ( $key === 'order_comments' ) :

					if ( isset( $field['class'] ) && is_array( $field['class'] ) ) :
						array_push( $field['class'], 'wonka-form-group', 'form-group' );
					else :
						$field['class'] = array( 'wonka-form-group', 'form-group' );
					endif;

					if ( isset( $field['label_class'] ) ) :
						array_push( $field['label_class'], 'wonka-sr-only', 'sr-only' );
					else :
						$field['label_class'] = array( 'wonka-sr-only', 'sr-only' );
					endif;

					if ( isset( $field['input_class'] ) ) :
						array_push( $field['input_class'], 'wonka-form-control', 'form-control' );
					else :
						$field['input_class'] = array( 'wonka-form-control', 'form-control' );
					endif;
					woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
					?>
				<?php endif; ?>
					
			<?php endforeach; ?>
		</div>
		
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
</div><!-- .woocommerce-additional-fields -->
<?php endif; ?>
