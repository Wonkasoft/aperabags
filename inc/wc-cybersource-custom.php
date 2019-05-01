<?php
/**
 * This is a extending of the WC_Gateway_CyberSource class
 */

defined( 'ABSPATH' ) or exit;

class WONKA_WC_Gateway_CyberSource extends WC_Gateway_CyberSource
{

	/**
	 * Payment fields for CyberSource.
	 *
	 * @see WC_Payment_Gateway::payment_fields()
	 */
	public function payment_fields() {
		?>
		<style type="text/css">#payment ul.payment_methods li label[for='payment_method_cybersource'] img:nth-child(n+2) { margin-left:1px; }</style>
		<fieldset>
			<?php if ( $this->get_description() ) : ?><?php echo wpautop( wptexturize( $this->get_description() ) ); ?><?php endif; ?>

			<div class="form-row form-row-first">
				<label for="cybersource_accountNumber" class="sr-only"><?php esc_html_e( 'Credit Card number', 'woocommerce-gateway-cybersource' ) ?> <span class="required">*</span></label>
				<input type="text" class="input-text" id="cybersource_accountNumber" name="cybersource_accountNumber" maxlength="19" autocomplete="off" />
			</div>
			<div class="form-row form-row-last">
				<label for="cybersource_cardType" class="sr-only"><?php esc_html_e( 'Card Type', 'woocommerce-gateway-cybersource' ); ?> <span class="required">*</span></label>
				<select name="cybersource_cardType" style="width:auto;"><br />
					<option value="">
					<?php
						foreach ( $this->card_types as $type ) :
							if ( isset( $this->card_type_options[ $type ] ) ) :
								?>
								<option value="<?php echo esc_attr( preg_replace( '/-.*$/', '', $type ) ); ?>" rel="<?php echo esc_attr( $type ); ?>"><?php esc_html_e( $this->card_type_options[ $type ], 'woocommerce-gateway-cybersource' ); ?></option>
								<?php
							endif;
						endforeach;
					?>
				</select>
			</div>
			<div class="clear"></div>

			<div class="form-row form-row-first">
				<label for="cybersource_expirationMonth" class="sr-only"><?php esc_html_e( 'Expiration date', 'woocommerce-gateway-cybersource' ) ?> <span class="required">*</span></label>
				<select name="cybersource_expirationMonth" id="cybersource_expirationMonth" class="woocommerce-select woocommerce-cc-month" style="width:auto;">
					<option value=""><?php esc_html_e( 'Month', 'woocommerce-gateway-cybersource' ) ?></option>
					<?php foreach ( range( 1, 12 ) as $month ) : ?>
						<option value="<?php echo sprintf( '%02d', $month ) ?>"><?php echo sprintf( '%02d', $month ) ?></option>
					<?php endforeach; ?>
				</select>
				<select name="cybersource_expirationYear" id="cybersource_expirationYear" class="woocommerce-select woocommerce-cc-year" style="width:auto;">
					<option value=""><?php _e( 'Year', 'woocommerce-gateway-cybersource' ) ?></option>
					<?php foreach ( range( date( 'Y' ), date( 'Y' ) + 20 ) as $year ) : ?>
						<option value="<?php echo $year ?>"><?php echo $year ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<?php if ( $this->is_cvv_required() ) : ?>

				<div class="form-row form-row-last">
					<label for="cybersource_cvNumber" class="sr-only"><?php esc_html_e( 'Card security code', 'woocommerce-gateway-cybersource') ?> <span class="required">*</span></label>
					<input type="text" class="input-text" id="cybersource_cvNumber" name="cybersource_cvNumber" maxlength="4" style="width:60px" autocomplete="off" />
				</div>
			<?php endif; ?>

			<div class="clear"></div>
		</fieldset>
		<?php
	}

}
// $new_fields = WONKA_WC_Gateway_CyberSource::payment_fields();
// runkit_method_redefine( 'WC_Gateway_CyberSource', 'payment_fields', '', function() {

// 	return "test"
// 	});
