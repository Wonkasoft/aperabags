<?php
/**
 * Class WC_Priority_Mail_Shipping_NP_Method
 *
 * @author Wonkasoft,LLC <support@wonkasoft.com>
 * @package aperabags
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WC_Priority_Mail_Shipping_NP_Method' ) ) {
	/**
	 * Begin Class
	 */
	class WC_Priority_Mail_Shipping_NP_Method extends WC_Shipping_Method {

		/**
		 * Constructor for your shipping class
		 *
		 * @access public
		 * @return void
		 */
		public function __construct() {
				$this->id                 = 'USPS_Priority_Mail_NP'; // Id for your shipping method. Should be uunique.
				$this->method_title       = __( 'USPS Priority Mail Non-Perks Members' );  // Title shown in admin.
				$this->method_description = __( 'USPS Priority Mail Flat Rate for Non-perks Members' ); // Description shown in admin.
				$this->enabled            = 'yes'; // This can be added as an setting but for this example its forced enabled.
				$this->title              = 'Priority 1-3 business days'; // This can be added as an setting but for this example its forced.
				$this->init();
		}

		/**
		 * Init your settings
		 *
		 * @access public
		 * @return void
		 */
		public function init() {
			// Load the settings API.
			$this->init_settings(); // This is part of the settings API. Loads settings you previously init.
			$this->init_form_fields(); // This is part of the settings API. Override the method to add your own settings.
			// Save settings in admin if you have any defined.
			add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
		}
		/**
		 * Calculate_shipping function.
		 *
		 * @access public
		 * @param mixed $package contains the packages.
		 * @return void
		 */
		public function calculate_shipping( $package = array() ) {
			$rate = array(
				'id'       => $this->id,
				'label'    => $this->title,
				'cost'     => '10.00',
				'calc_tax' => 'per_item',
			);
			// Register the rate.
			$this->add_rate( $rate );
		}
	}
}
