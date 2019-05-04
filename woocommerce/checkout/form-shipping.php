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
<div class="row wonka-row">
	<div class="col col-12">
<div class="woocommerce-shipping-fields">


	<?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>

				<?php
				ob_start();
					_e( '<h5 class="wonka-contact-information">Contact Information</h5>', 'aperabags' );
					$fields = $checkout->get_checkout_fields( 'shipping' );

					foreach ( $fields as $key => $field ) :
						if ( strtolower( $key ) === 'shipping_email' ) :
							if ( !isset($field['placeholder'] ) ) :
								$field['placeholder'] = $field['label'];
								$field['required'] = true;
							endif;

							$field['priority'] = 1;

							if ( isset( $field['class'] ) ) :
								$field['class'] = array( 'wonka-form-group', 'form-group' );
							else :
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

						woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
						endif;
					endforeach; 
					echo ob_get_clean();
					?>

					<div class="wonka-newletter-form-check checkbox">
						<label for="mc4wp-subscribe">
							<input type="checkbox" class="wonka-checkbox form-checkbox" name="mc4wp-subscribe" checked="checked" value="1" />
							Keep me up to date on news and exclusive offers.	</label>
					</div>

				<div class="woocommerce-shipping-fields__field-wrapper">

				<?php if ( wc_ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>


					<h5><?php _e( 'Shipping &amp; Billing', 'woocommerce' ); ?></h5>

				<?php else : ?>

					<h5><?php _e( 'Shipping details', 'woocommerce' ); ?></h5>

				<?php endif;
				ob_start();
				$fields = $checkout->get_checkout_fields( 'shipping' );
					foreach ( $fields as $key => $field ) {
						if ( $key !== 'shipping_email') :

							if ( $key !== 'shipping_company' || $key !== 'shipping_address_2_field' ) :
								$field['required'] = true;
							endif;
							if ( $key === 'shipping_first_name' ) :
								$field['priority'] = 5;
							endif;

							if ( $key === 'shipping_country' ) :
								$field['priority'] = 95;
							endif;
							
							if ( !isset($field['placeholder'] ) ) :
								$field['placeholder'] = $field['label'];
							endif;

							if ( isset( $field['class'] ) && is_array( $field['class'] ) ) :
								array_push( $field['class'], 'wonka-form-group', 'form-group' ) ;
							else:
								$field['class'] = array( 'wonka-form-group', 'form-group' );
							endif;

							if ( isset( $field['label_class'] ) && is_array( $field['label_class'] ) ) :
								array_push( $field['label_class'], 'wonka-sr-only', 'sr-only' ) ;
							else:
								$field['label_class'] = array( 'wonka-sr-only', 'sr-only' );
							endif;

							if ( isset( $field['input_class'] ) && is_array( $field['input_class'] ) ) :
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
				echo ob_get_clean();
				?>
			</div>

			<?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>

</div><!-- .woocommerce-shipping-fields -->
<div class="woocommerce-additional-fields">
	<?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>

	<?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>
		
		<?php if ( ! WC()->cart->needs_shipping() || wc_ship_to_billing_address_only() ) : ?>

			<h3><?php _e( 'Additional information', 'woocommerce' ); ?></h3>

		<?php endif; ?>

		<div class="woocommerce-additional-fields__field-wrapper">
			<?php foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) :
				if ( $key === 'order_comments' ) :
					
					if ( isset( $field['class'] ) && is_array( $field['class'] ) ) :
						array_push( $field['class'], 'wonka-form-group', 'form-group' );
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
					woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
				<?php endif; ?>
					
			<?php endforeach; ?>
		</div>
		
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
</div><!-- .woocommerce-additional-fields -->
<?php if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>
	<div class="woocommerce-account-fields">
		<?php if ( ! $checkout->is_registration_required() ) : ?>
				<ul class="list-group list-group-flush">
					<li class="list-group-item">
			<div class="custom-control custom-checkbox">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox custom-control-input" id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true ) ?> type="checkbox" name="createaccount" value="1" /> 
				<label class="woocommerce-form__label custom-control-label" for="createaccount"><span><?php _e( 'Create an account?', 'woocommerce' ); ?></span></label>
			</div><!-- .custom-control -->
					</li>
		<?php endif; ?>

		<?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

		<?php if ( $checkout->get_checkout_fields( 'account' ) ) : ?>
			<li class="list-group-item">
			<div class="create-account">
				<?php foreach ( $checkout->get_checkout_fields( 'account' ) as $key => $field ) : ?>
					<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
				<?php endforeach; ?>
				<div class="clear"></div>
			</div><!-- .create-account -->
			</li>
		<?php endif; ?>
		<?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>
				</ul>
	</div><!-- .woocommerce-account-fields -->
<?php endif; ?>
		</div><!-- .col-12 -->
	</div><!-- .wonka-row -->