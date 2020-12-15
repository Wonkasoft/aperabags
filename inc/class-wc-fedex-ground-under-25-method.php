<?php
/**
 * Class WC_FedEx_Ground_Under_25_Method
 *
 * @author Wonkasoft,LLC <support@wonkasoft.com>
 * @package aperabags
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WC_FedEx_Ground_Under_25_Method' ) ) {
	/**
	 * Begin class
	 */
	class WC_FedEx_Ground_Under_25_Method extends WC_Shipping_Method {

		/**
		 * Constructor for your shipping class
		 *
		 * @access public
		 * @return void
		 */
		public function __construct() {
				$this->id                 = 'FedEx_Ground_Under_25'; // Id for your shipping method. Should be uunique.
				$this->method_title       = __( 'FedEx Ground' );  // Title shown in admin.
				$this->method_description = __( 'FedEx Ground Flate Rate for orders under $25' ); // Description shown in admin.
				$this->enabled            = 'yes'; // This can be added as an setting but for this example its forced enabled.
				$this->title              = 'FedEx Ground® 1-5 business days'; // This can be added as an setting but for this example its forced.
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
		 * @param mixed $package array or string for setup.
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
