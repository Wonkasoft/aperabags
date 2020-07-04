<?php
/**
 * Customized Coupon Data
 *
 * Display the coupon data meta box.
 *
 * @author      Wonkasoft
 * @category    Admin
 * @package     WooCommerce/Admin/Meta Boxes
 * @version     2.1.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

	/**
	 * Wonkasoft_WC_Meta_Box_Coupon_Data Class.
	 */
class Wonkasoft_WC_Meta_Box_Coupon_Data {

	/**
	 * Output the metabox.
	 *
	 * @param WP_Post $post
	 */
	public static function output( $post ) {

		$coupon_id = absint( $post->ID );
		$coupon    = new Wonkasoft_WC_Coupon( $coupon_id );

		?>

		<style type="text/css">
			#edit-slug-box, #minor-publishing-actions { display:none }
		</style>
		<div id="coupon_options" class="panel-wrap coupon_data">

			<div class="wc-tabs-back"></div>

			<ul class="coupon_data_tabs wc-tabs" style="display:none;">
			<?php
			$coupon_data_tabs = apply_filters(
				'woocommerce_coupon_data_tabs',
				array(
					'general'           => array(
						'label'  => __( 'General', 'woocommerce' ),
						'target' => 'general_coupon_data',
						'class'  => 'general_coupon_data',
					),
					'usage_restriction' => array(
						'label'  => __( 'Usage restriction', 'woocommerce' ),
						'target' => 'usage_restriction_coupon_data',
						'class'  => '',
					),
					'usage_limit'       => array(
						'label'  => __( 'Usage limits', 'woocommerce' ),
						'target' => 'usage_limit_coupon_data',
						'class'  => '',
					),
				)
			);

			foreach ( $coupon_data_tabs as $key => $tab ) :
				?>
					<li class="<?php echo $key; ?>_options <?php echo $key; ?>_tab <?php echo implode( ' ', (array) $tab['class'] ); ?>">
						<a href="#<?php echo $tab['target']; ?>">
							<span><?php echo esc_html( $tab['label'] ); ?></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
			<div id="general_coupon_data" class="panel woocommerce_options_panel">
					<?php

					// Type.
					woocommerce_wp_select(
						array(
							'id'      => 'discount_type',
							'label'   => __( 'Discount type', 'woocommerce' ),
							'options' => wc_get_coupon_types(),
							'value'   => $coupon->get_discount_type( 'edit' ),
						)
					);

					// Amount.
					woocommerce_wp_text_input(
						array(
							'id'          => 'coupon_amount',
							'label'       => __( 'Coupon amount', 'woocommerce' ),
							'placeholder' => wc_format_localized_price( 0 ),
							'description' => __( 'Value of the coupon.', 'woocommerce' ),
							'data_type'   => 'percent' === $coupon->get_discount_type( 'edit' ) ? 'decimal' : 'price',
							'desc_tip'    => true,
							'value'       => $coupon->get_amount( 'edit' ),
						)
					);

					// Free Shipping.
					if ( wc_shipping_enabled() ) {
						woocommerce_wp_checkbox(
							array(
								'id'          => 'free_shipping',
								'label'       => __( 'Allow free shipping', 'woocommerce' ),
								'description' => sprintf( __( 'Check this box if the coupon grants free shipping. A <a href="%s" target="_blank">free shipping method</a> must be enabled in your shipping zone and be set to require "a valid free shipping coupon" (see the "Free Shipping Requires" setting).', 'woocommerce' ), 'https://docs.woocommerce.com/document/free-shipping/' ),
								'value'       => wc_bool_to_string( $coupon->get_free_shipping( 'edit' ) ),
							)
						);
					}

					// Expiry date.
					$expiry_date = $coupon->get_date_expires( 'edit' ) ? $coupon->get_date_expires( 'edit' )->date( 'Y-m-d' ) : '';
					woocommerce_wp_text_input(
						array(
							'id'                => 'expiry_date',
							'value'             => esc_attr( $expiry_date ),
							'label'             => __( 'Coupon expiry date', 'woocommerce' ),
							'placeholder'       => 'YYYY-MM-DD',
							'description'       => __( 'The coupon will expire at 00:00:00 of this date.', 'woocommerce' ),
							'desc_tip'          => true,
							'class'             => 'date-picker',
							'custom_attributes' => array(
								'pattern' => apply_filters( 'woocommerce_date_input_html_pattern', '[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])' ),
							),
						)
					);

					do_action( 'woocommerce_coupon_options', $coupon->get_id(), $coupon );

					?>
			</div>
			<div id="usage_restriction_coupon_data" class="panel woocommerce_options_panel">
				<?php

				echo '<div class="options_group">';

				// minimum spend.
				woocommerce_wp_text_input(
					array(
						'id'          => 'minimum_amount',
						'label'       => __( 'Minimum spend', 'woocommerce' ),
						'placeholder' => __( 'No minimum', 'woocommerce' ),
						'description' => __( 'This field allows you to set the minimum spend (subtotal) allowed to use the coupon.', 'woocommerce' ),
						'data_type'   => 'price',
						'desc_tip'    => true,
						'value'       => $coupon->get_minimum_amount( 'edit' ),
					)
				);

				// maximum spend.
				woocommerce_wp_text_input(
					array(
						'id'          => 'maximum_amount',
						'label'       => __( 'Maximum spend', 'woocommerce' ),
						'placeholder' => __( 'No maximum', 'woocommerce' ),
						'description' => __( 'This field allows you to set the maximum spend (subtotal) allowed when using the coupon.', 'woocommerce' ),
						'data_type'   => 'price',
						'desc_tip'    => true,
						'value'       => $coupon->get_maximum_amount( 'edit' ),
					)
				);

				// Individual use.
				woocommerce_wp_checkbox(
					array(
						'id'          => 'individual_use',
						'label'       => __( 'Individual use only', 'woocommerce' ),
						'description' => __( 'Check this box if the coupon cannot be used in conjunction with other coupons.', 'woocommerce' ),
						'value'       => wc_bool_to_string( $coupon->get_individual_use( 'edit' ) ),
					)
				);

				// Exclude Sale Products.
				woocommerce_wp_checkbox(
					array(
						'id'          => 'exclude_sale_items',
						'label'       => __( 'Exclude sale items', 'woocommerce' ),
						'description' => __( 'Check this box if the coupon should not apply to items on sale. Per-item coupons will only work if the item is not on sale. Per-cart coupons will only work if there are items in the cart that are not on sale.', 'woocommerce' ),
						'value'       => wc_bool_to_string( $coupon->get_exclude_sale_items( 'edit' ) ),
					)
				);

				$exclude_sale_prices = get_post_meta( $post->ID, 'exclude_sale_prices', true );
				// Exclude Sale Prices.
				woocommerce_wp_checkbox(
					array(
						'id'          => 'exclude_sale_prices',
						'label'       => __( 'Exclude sale prices', 'woocommerce' ),
						'description' => __( 'Check this box if the coupon should not apply to items sale price.', 'woocommerce' ),
						'value'       => wc_bool_to_string( $exclude_sale_prices ),
					)
				);

				echo '</div><div class="options_group">';

				// Product ids.
				?>
				<p class="form-field">
					<label><?php _e( 'Products', 'woocommerce' ); ?></label>
					<select class="wc-product-search" multiple="multiple" style="width: 50%;" name="product_ids[]" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;', 'woocommerce' ); ?>" data-action="woocommerce_json_search_products_and_variations">
					<?php
					$product_ids = $coupon->get_product_ids( 'edit' );

					foreach ( $product_ids as $product_id ) {
						$product = wc_get_product( $product_id );
						if ( is_object( $product ) ) {
							echo '<option value="' . esc_attr( $product_id ) . '"' . selected( true, true, false ) . '>' . wp_kses_post( $product->get_formatted_name() ) . '</option>';
						}
					}
					?>
					</select>
					<?php echo wc_help_tip( __( 'Products that the coupon will be applied to, or that need to be in the cart in order for the "Fixed cart discount" to be applied.', 'woocommerce' ) ); ?>
				</p>

					<?php // Exclude Product ids. ?>
				<p class="form-field">
					<label><?php _e( 'Exclude products', 'woocommerce' ); ?></label>
					<select class="wc-product-search" multiple="multiple" style="width: 50%;" name="exclude_product_ids[]" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;', 'woocommerce' ); ?>" data-action="woocommerce_json_search_products_and_variations">
						<?php
						$product_ids = $coupon->get_excluded_product_ids( 'edit' );

						foreach ( $product_ids as $product_id ) {
							$product = wc_get_product( $product_id );
							if ( is_object( $product ) ) {
								echo '<option value="' . esc_attr( $product_id ) . '"' . selected( true, true, false ) . '>' . wp_kses_post( $product->get_formatted_name() ) . '</option>';
							}
						}
						?>
					</select>
						<?php echo wc_help_tip( __( 'Products that the coupon will not be applied to, or that cannot be in the cart in order for the "Fixed cart discount" to be applied.', 'woocommerce' ) ); ?>
				</p>
					<?php

					echo '</div><div class="options_group">';

					// Categories.
					?>
				<p class="form-field">
					<label for="product_categories"><?php _e( 'Product categories', 'woocommerce' ); ?></label>
					<select id="product_categories" name="product_categories[]" style="width: 50%;"  class="wc-enhanced-select" multiple="multiple" data-placeholder="<?php esc_attr_e( 'Any category', 'woocommerce' ); ?>">
					<?php
					$category_ids = $coupon->get_product_categories( 'edit' );
					$categories   = get_terms( 'product_cat', 'orderby=name&hide_empty=0' );

					if ( $categories ) {
						foreach ( $categories as $cat ) {
							echo '<option value="' . esc_attr( $cat->term_id ) . '"' . wc_selected( $cat->term_id, $category_ids ) . '>' . esc_html( $cat->name ) . '</option>';
						}
					}
					?>
					</select> <?php echo wc_help_tip( __( 'Product categories that the coupon will be applied to, or that need to be in the cart in order for the "Fixed cart discount" to be applied.', 'woocommerce' ) ); ?>
				</p>

					<?php // Exclude Categories. ?>
				<p class="form-field">
					<label for="exclude_product_categories"><?php _e( 'Exclude categories', 'woocommerce' ); ?></label>
					<select id="exclude_product_categories" name="exclude_product_categories[]" style="width: 50%;"  class="wc-enhanced-select" multiple="multiple" data-placeholder="<?php esc_attr_e( 'No categories', 'woocommerce' ); ?>">
						<?php
						$category_ids = $coupon->get_excluded_product_categories( 'edit' );
						$categories   = get_terms( 'product_cat', 'orderby=name&hide_empty=0' );

						if ( $categories ) {
							foreach ( $categories as $cat ) {
								echo '<option value="' . esc_attr( $cat->term_id ) . '"' . wc_selected( $cat->term_id, $category_ids ) . '>' . esc_html( $cat->name ) . '</option>';
							}
						}
						?>
					</select>
						<?php echo wc_help_tip( __( 'Product categories that the coupon will not be applied to, or that cannot be in the cart in order for the "Fixed cart discount" to be applied.', 'woocommerce' ) ); ?>
				</p>
			</div>
			<div class="options_group">
					<?php
					// Customers.
					woocommerce_wp_text_input(
						array(
							'id'                => 'customer_email',
							'label'             => __( 'Allowed emails', 'woocommerce' ),
							'placeholder'       => __( 'No restrictions', 'woocommerce' ),
							'description'       => __( 'Whitelist of billing emails to check against when an order is placed. Separate email addresses with commas. You can also use an asterisk (*) to match parts of an email. For example "*@gmail.com" would match all gmail addresses.', 'woocommerce' ),
							'value'             => implode( ', ', (array) $coupon->get_email_restrictions( 'edit' ) ),
							'desc_tip'          => true,
							'type'              => 'email',
							'class'             => '',
							'custom_attributes' => array(
								'multiple' => 'multiple',
							),
						)
					);
					?>
			</div>
				<?php do_action( 'woocommerce_coupon_options_usage_restriction', $coupon->get_id(), $coupon ); ?>
			</div>
			<div id="usage_limit_coupon_data" class="panel woocommerce_options_panel">
				<div class="options_group">
					<?php
					// Usage limit per coupons.
					woocommerce_wp_text_input(
						array(
							'id'                => 'usage_limit',
							'label'             => __( 'Usage limit per coupon', 'woocommerce' ),
							'placeholder'       => esc_attr__( 'Unlimited usage', 'woocommerce' ),
							'description'       => __( 'How many times this coupon can be used before it is void.', 'woocommerce' ),
							'type'              => 'number',
							'desc_tip'          => true,
							'class'             => 'short',
							'custom_attributes' => array(
								'step' => 1,
								'min'  => 0,
							),
							'value'             => $coupon->get_usage_limit( 'edit' ) ? $coupon->get_usage_limit( 'edit' ) : '',
						)
					);

					// Usage limit per product.
					woocommerce_wp_text_input(
						array(
							'id'                => 'limit_usage_to_x_items',
							'label'             => __( 'Limit usage to X items', 'woocommerce' ),
							'placeholder'       => esc_attr__( 'Apply to all qualifying items in cart', 'woocommerce' ),
							'description'       => __( 'The maximum number of individual items this coupon can apply to when using product discounts. Leave blank to apply to all qualifying items in cart.', 'woocommerce' ),
							'desc_tip'          => true,
							'class'             => 'short',
							'type'              => 'number',
							'custom_attributes' => array(
								'step' => 1,
								'min'  => 0,
							),
							'value'             => $coupon->get_limit_usage_to_x_items( 'edit' ) ? $coupon->get_limit_usage_to_x_items( 'edit' ) : '',
						)
					);

					// Usage limit per users.
					woocommerce_wp_text_input(
						array(
							'id'                => 'usage_limit_per_user',
							'label'             => __( 'Usage limit per user', 'woocommerce' ),
							'placeholder'       => esc_attr__( 'Unlimited usage', 'woocommerce' ),
							'description'       => __( 'How many times this coupon can be used by an individual user. Uses billing email for guests, and user ID for logged in users.', 'woocommerce' ),
							'desc_tip'          => true,
							'class'             => 'short',
							'type'              => 'number',
							'custom_attributes' => array(
								'step' => 1,
								'min'  => 0,
							),
							'value'             => $coupon->get_usage_limit_per_user( 'edit' ) ? $coupon->get_usage_limit_per_user( 'edit' ) : '',
						)
					);
					?>
				</div>
					<?php do_action( 'woocommerce_coupon_options_usage_limit', $coupon->get_id(), $coupon ); ?>
			</div>
				<?php do_action( 'woocommerce_coupon_data_panels', $coupon->get_id(), $coupon ); ?>
			<div class="clear"></div>
		</div>
			<?php
	}

	/**
	 * Save meta box data.
	 *
	 * @param int     $post_id
	 * @param WP_Post $post
	 */
	public static function save( $post_id, $post ) {
		// Check for dupe coupons.
		$coupon_code  = wc_format_coupon_code( $post->post_title );
		$id_from_code = wc_get_coupon_id_by_code( $coupon_code, $post_id );
		if ( isset( $_POST['exclude_sale_prices'] ) ) :
			$exclude_sale_prices = isset( $_POST['exclude_sale_prices'] );
			update_post_meta( $post_id, 'exclude_sale_prices', $exclude_sale_prices );
		endif;
	}
}

/**
 * Coupon class.
 */
class Wonkasoft_WC_Coupon extends WC_Coupon {

	/**
	 * Data array, with defaults.
	 *
	 * @since 3.0.0
	 * @var array
	 */
	protected $data = array(
		'code'                        => '',
		'amount'                      => 0,
		'date_created'                => null,
		'date_modified'               => null,
		'date_expires'                => null,
		'discount_type'               => 'fixed_cart',
		'description'                 => '',
		'usage_count'                 => 0,
		'individual_use'              => false,
		'product_ids'                 => array(),
		'excluded_product_ids'        => array(),
		'usage_limit'                 => 0,
		'usage_limit_per_user'        => 0,
		'limit_usage_to_x_items'      => null,
		'free_shipping'               => false,
		'product_categories'          => array(),
		'excluded_product_categories' => array(),
		'exclude_sale_items'          => false,
		'exclude_sale_prices'         => false,
		'minimum_amount'              => '',
		'maximum_amount'              => '',
		'email_restrictions'          => array(),
		'used_by'                     => array(),
		'virtual'                     => false,
	);

	// Coupon message codes.
	const E_WC_COUPON_INVALID_FILTERED               = 100;
	const E_WC_COUPON_INVALID_REMOVED                = 101;
	const E_WC_COUPON_NOT_YOURS_REMOVED              = 102;
	const E_WC_COUPON_ALREADY_APPLIED                = 103;
	const E_WC_COUPON_ALREADY_APPLIED_INDIV_USE_ONLY = 104;
	const E_WC_COUPON_NOT_EXIST                      = 105;
	const E_WC_COUPON_USAGE_LIMIT_REACHED            = 106;
	const E_WC_COUPON_EXPIRED                        = 107;
	const E_WC_COUPON_MIN_SPEND_LIMIT_NOT_MET        = 108;
	const E_WC_COUPON_NOT_APPLICABLE                 = 109;
	const E_WC_COUPON_NOT_VALID_SALE_ITEMS           = 110;
	const E_WC_COUPON_PLEASE_ENTER                   = 111;
	const E_WC_COUPON_MAX_SPEND_LIMIT_MET            = 112;
	const E_WC_COUPON_EXCLUDED_PRODUCTS              = 113;
	const E_WC_COUPON_EXCLUDED_CATEGORIES            = 114;
	const WC_COUPON_SUCCESS                          = 200;
	const WC_COUPON_REMOVED                          = 201;

	/**
	 * Cache group.
	 *
	 * @var string
	 */
	protected $cache_group = 'coupons';

	/**
	 * Coupon constructor. Loads coupon data.
	 *
	 * @param mixed $data Coupon data, object, ID or code.
	 */
	public function __construct( $data = '' ) {
		parent::__construct( $data );

		// If we already have a coupon object, read it again.
		if ( $data instanceof Wonkasoft_WC_Coupon ) {
			$this->set_id( absint( $data->get_id() ) );
			$this->read_object_from_database();
			return;
		}

		// This filter allows custom coupon objects to be created on the fly.
		$coupon = apply_filters( 'woocommerce_get_shop_coupon_data', false, $data, $this );

		if ( $coupon ) {
			$this->read_manual_coupon( $data, $coupon );
			return;
		}

		// Try to load coupon using ID or code.
		if ( is_int( $data ) && 'shop_coupon' === get_post_type( $data ) ) {
			$this->set_id( $data );
		} elseif ( ! empty( $data ) ) {
			$id = wc_get_coupon_id_by_code( $data );
			// Need to support numeric strings for backwards compatibility.
			if ( ! $id && 'shop_coupon' === get_post_type( $data ) ) {
				$this->set_id( $data );
			} else {
				$this->set_id( $id );
				$this->set_code( $data );
			}
		} else {
			$this->set_object_read( true );
		}

		$this->read_object_from_database();
	}

	/**
	 * If the object has an ID, read using the data store.
	 *
	 * @since 3.4.1
	 */
	protected function read_object_from_database() {
		$this->data_store = WC_Data_Store::load( 'coupon' );

		if ( $this->get_id() > 0 ) {
			$this->data_store->read( $this );
		}
	}
	/**
	 * Checks the coupon type.
	 *
	 * @param  string $type Array or string of types.
	 * @return bool
	 */
	public function is_type( $type ) {
		return ( $this->get_discount_type() === $type || ( is_array( $type ) && in_array( $this->get_discount_type(), $type, true ) ) );
	}

	/**
	 * Prefix for action and filter hooks on data.
	 *
	 * @since  3.0.0
	 * @return string
	 */
	protected function get_hook_prefix() {
		return 'woocommerce_coupon_get_';
	}

	/*
	|--------------------------------------------------------------------------
	| Getters
	|--------------------------------------------------------------------------
	|
	| Methods for getting data from the coupon object.
	|
	*/

	/**
	 * Get coupon code.
	 *
	 * @since  3.0.0
	 * @param  string $context What the value is for. Valid values are 'view' and 'edit'.
	 * @return string
	 */
	public function get_code( $context = 'view' ) {
		return $this->get_prop( 'code', $context );
	}

	/**
	 * Get coupon description.
	 *
	 * @since  3.0.0
	 * @param  string $context What the value is for. Valid values are 'view' and 'edit'.
	 * @return string
	 */
	public function get_description( $context = 'view' ) {
		return $this->get_prop( 'description', $context );
	}

	/**
	 * Get discount type.
	 *
	 * @since  3.0.0
	 * @param  string $context What the value is for. Valid values are 'view' and 'edit'.
	 * @return string
	 */
	public function get_discount_type( $context = 'view' ) {
		return $this->get_prop( 'discount_type', $context );
	}

	/**
	 * Get coupon amount.
	 *
	 * @since  3.0.0
	 * @param  string $context What the value is for. Valid values are 'view' and 'edit'.
	 * @return float
	 */
	public function get_amount( $context = 'view' ) {
		return wc_format_decimal( $this->get_prop( 'amount', $context ) );
	}

	/**
	 * Get coupon expiration date.
	 *
	 * @since  3.0.0
	 * @param  string $context What the value is for. Valid values are 'view' and 'edit'.
	 * @return WC_DateTime|NULL object if the date is set or null if there is no date.
	 */
	public function get_date_expires( $context = 'view' ) {
		return $this->get_prop( 'date_expires', $context );
	}

	/**
	 * Get date_created
	 *
	 * @since  3.0.0
	 * @param  string $context What the value is for. Valid values are 'view' and 'edit'.
	 * @return WC_DateTime|NULL object if the date is set or null if there is no date.
	 */
	public function get_date_created( $context = 'view' ) {
		return $this->get_prop( 'date_created', $context );
	}

	/**
	 * Get date_modified
	 *
	 * @since  3.0.0
	 * @param  string $context What the value is for. Valid values are 'view' and 'edit'.
	 * @return WC_DateTime|NULL object if the date is set or null if there is no date.
	 */
	public function get_date_modified( $context = 'view' ) {
		return $this->get_prop( 'date_modified', $context );
	}

	/**
	 * Get coupon usage count.
	 *
	 * @since  3.0.0
	 * @param  string $context What the value is for. Valid values are 'view' and 'edit'.
	 * @return integer
	 */
	public function get_usage_count( $context = 'view' ) {
		return $this->get_prop( 'usage_count', $context );
	}

	/**
	 * Get the "indvidual use" checkbox status.
	 *
	 * @since  3.0.0
	 * @param  string $context What the value is for. Valid values are 'view' and 'edit'.
	 * @return bool
	 */
	public function get_individual_use( $context = 'view' ) {
		return $this->get_prop( 'individual_use', $context );
	}

	/**
	 * Get product IDs this coupon can apply to.
	 *
	 * @since  3.0.0
	 * @param  string $context What the value is for. Valid values are 'view' and 'edit'.
	 * @return array
	 */
	public function get_product_ids( $context = 'view' ) {
		return $this->get_prop( 'product_ids', $context );
	}

	/**
	 * Get product IDs that this coupon should not apply to.
	 *
	 * @since  3.0.0
	 * @param  string $context What the value is for. Valid values are 'view' and 'edit'.
	 * @return array
	 */
	public function get_excluded_product_ids( $context = 'view' ) {
		return $this->get_prop( 'excluded_product_ids', $context );
	}

	/**
	 * Get coupon usage limit.
	 *
	 * @since  3.0.0
	 * @param  string $context What the value is for. Valid values are 'view' and 'edit'.
	 * @return integer
	 */
	public function get_usage_limit( $context = 'view' ) {
		return $this->get_prop( 'usage_limit', $context );
	}

	/**
	 * Get coupon usage limit per customer (for a single customer)
	 *
	 * @since  3.0.0
	 * @param  string $context What the value is for. Valid values are 'view' and 'edit'.
	 * @return integer
	 */
	public function get_usage_limit_per_user( $context = 'view' ) {
		return $this->get_prop( 'usage_limit_per_user', $context );
	}

	/**
	 * Usage limited to certain amount of items
	 *
	 * @since  3.0.0
	 * @param  string $context What the value is for. Valid values are 'view' and 'edit'.
	 * @return integer|null
	 */
	public function get_limit_usage_to_x_items( $context = 'view' ) {
		return $this->get_prop( 'limit_usage_to_x_items', $context );
	}

	/**
	 * If this coupon grants free shipping or not.
	 *
	 * @since  3.0.0
	 * @param  string $context What the value is for. Valid values are 'view' and 'edit'.
	 * @return bool
	 */
	public function get_free_shipping( $context = 'view' ) {
		return $this->get_prop( 'free_shipping', $context );
	}

	/**
	 * Get product categories this coupon can apply to.
	 *
	 * @since  3.0.0
	 * @param  string $context What the value is for. Valid values are 'view' and 'edit'.
	 * @return array
	 */
	public function get_product_categories( $context = 'view' ) {
		return $this->get_prop( 'product_categories', $context );
	}

	/**
	 * Get product categories this coupon cannot not apply to.
	 *
	 * @since  3.0.0
	 * @param  string $context What the value is for. Valid values are 'view' and 'edit'.
	 * @return array
	 */
	public function get_excluded_product_categories( $context = 'view' ) {
		return $this->get_prop( 'excluded_product_categories', $context );
	}

	/**
	 * If this coupon should exclude items on sale.
	 *
	 * @since  3.0.0
	 * @param  string $context What the value is for. Valid values are 'view' and 'edit'.
	 * @return bool
	 */
	public function get_exclude_sale_items( $context = 'view' ) {
		return $this->get_prop( 'exclude_sale_items', $context );
	}

	/**
	 * If this coupon should exclude items sale price.
	 *
	 * @since  3.0.0
	 * @param  string $context What the value is for. Valid values are 'view' and 'edit'.
	 * @return bool
	 */
	public function get_exclude_sale_prices( $context = 'view' ) {
		return $this->get_prop( 'exclude_sale_prices', $context );
	}

	/**
	 * Get minimum spend amount.
	 *
	 * @since  3.0.0
	 * @param  string $context What the value is for. Valid values are 'view' and 'edit'.
	 * @return float
	 */
	public function get_minimum_amount( $context = 'view' ) {
		return $this->get_prop( 'minimum_amount', $context );
	}
	/**
	 * Get maximum spend amount.
	 *
	 * @since  3.0.0
	 * @param  string $context What the value is for. Valid values are 'view' and 'edit'.
	 * @return float
	 */
	public function get_maximum_amount( $context = 'view' ) {
		return $this->get_prop( 'maximum_amount', $context );
	}

	/**
	 * Get emails to check customer usage restrictions.
	 *
	 * @since  3.0.0
	 * @param  string $context What the value is for. Valid values are 'view' and 'edit'.
	 * @return array
	 */
	public function get_email_restrictions( $context = 'view' ) {
		return $this->get_prop( 'email_restrictions', $context );
	}

	/**
	 * Get records of all users who have used the current coupon.
	 *
	 * @since  3.0.0
	 * @param  string $context What the value is for. Valid values are 'view' and 'edit'.
	 * @return array
	 */
	public function get_used_by( $context = 'view' ) {
		return $this->get_prop( 'used_by', $context );
	}

	/**
	 * If the filter is added through the woocommerce_get_shop_coupon_data filter, it's virtual and not in the DB.
	 *
	 * @since 3.2.0
	 * @param  string $context What the value is for. Valid values are 'view' and 'edit'.
	 * @return boolean
	 */
	public function get_virtual( $context = 'view' ) {
		return (bool) $this->get_prop( 'virtual', $context );
	}

	/**
	 * Get discount amount for a cart item.
	 *
	 * @param  float      $discounting_amount Amount the coupon is being applied to.
	 * @param  array|null $cart_item          Cart item being discounted if applicable.
	 * @param  boolean    $single             True if discounting a single qty item, false if its the line.
	 * @return float Amount this coupon has discounted.
	 */
	public function get_discount_amount( $discounting_amount, $cart_item = null, $single = false ) {
		$discount      = 0;
		$cart_item_qty = is_null( $cart_item ) ? 1 : $cart_item['quantity'];

		if ( $this->is_type( array( 'percent' ) ) ) {
			$discount = (float) $this->get_amount() * ( $discounting_amount / 100 );
		} elseif ( $this->is_type( 'fixed_cart' ) && ! is_null( $cart_item ) && WC()->cart->subtotal_ex_tax ) {
			/**
			 * This is the most complex discount - we need to divide the discount between rows based on their price in.
			 * proportion to the subtotal. This is so rows with different tax rates get a fair discount, and so rows.
			 * with no price (free) don't get discounted.
			 *
			 * Get item discount by dividing item cost by subtotal to get a %.
			 *
			 * Uses price inc tax if prices include tax to work around https://github.com/woocommerce/woocommerce/issues/7669 and https://github.com/woocommerce/woocommerce/issues/8074.
			 */
			if ( wc_prices_include_tax() ) {
				$discount_percent = ( wc_get_price_including_tax( $cart_item['data'] ) * $cart_item_qty ) / WC()->cart->subtotal;
			} else {
				$discount_percent = ( wc_get_price_excluding_tax( $cart_item['data'] ) * $cart_item_qty ) / WC()->cart->subtotal_ex_tax;
			}
			$discount = ( (float) $this->get_amount() * $discount_percent ) / $cart_item_qty;

		} elseif ( $this->is_type( 'fixed_product' ) ) {
			$discount = min( $this->get_amount(), $discounting_amount );
			$discount = $single ? $discount : $discount * $cart_item_qty;
		}

		return apply_filters( 'woocommerce_coupon_get_discount_amount', round( min( $discount, $discounting_amount ), wc_get_rounding_precision() ), $discounting_amount, $cart_item, $single, $this );
	}

	/*
	|--------------------------------------------------------------------------
	| Setters
	|--------------------------------------------------------------------------
	|
	| Functions for setting coupon data. These should not update anything in the
	| database itself and should only change what is stored in the class
	| object.
	|
	*/

	/**
	 * Set coupon code.
	 *
	 * @since 3.0.0
	 * @param string $code Coupon code.
	 */
	public function set_code( $code ) {
		$this->set_prop( 'code', wc_format_coupon_code( $code ) );
	}

	/**
	 * Set coupon description.
	 *
	 * @since 3.0.0
	 * @param string $description Description.
	 */
	public function set_description( $description ) {
		$this->set_prop( 'description', $description );
	}

	/**
	 * Set discount type.
	 *
	 * @since 3.0.0
	 * @param string $discount_type Discount type.
	 */
	public function set_discount_type( $discount_type ) {
		if ( 'percent_product' === $discount_type ) {
			$discount_type = 'percent'; // Backwards compatibility.
		}
		if ( ! in_array( $discount_type, array_keys( wc_get_coupon_types() ), true ) ) {
			$this->error( 'coupon_invalid_discount_type', __( 'Invalid discount type', 'woocommerce' ) );
		}
		$this->set_prop( 'discount_type', $discount_type );
	}

	/**
	 * Set amount.
	 *
	 * @since 3.0.0
	 * @param float $amount Amount.
	 */
	public function set_amount( $amount ) {
		$amount = wc_format_decimal( $amount );

		if ( ! is_numeric( $amount ) ) {
			$amount = 0;
		}

		if ( $amount < 0 ) {
			$this->error( 'coupon_invalid_amount', __( 'Invalid discount amount', 'woocommerce' ) );
		}

		if ( 'percent' === $this->get_discount_type() && $amount > 100 ) {
			$this->error( 'coupon_invalid_amount', __( 'Invalid discount amount', 'woocommerce' ) );
		}

		$this->set_prop( 'amount', $amount );
	}

	/**
	 * Set expiration date.
	 *
	 * @since  3.0.0
	 * @param string|integer|null $date UTC timestamp, or ISO 8601 DateTime. If the DateTime string has no timezone or offset, WordPress site timezone will be assumed. Null if there is no date.
	 */
	public function set_date_expires( $date ) {
		$this->set_date_prop( 'date_expires', $date );
	}

	/**
	 * Set date_created
	 *
	 * @since  3.0.0
	 * @param string|integer|null $date UTC timestamp, or ISO 8601 DateTime. If the DateTime string has no timezone or offset, WordPress site timezone will be assumed. Null if there is no date.
	 */
	public function set_date_created( $date ) {
		$this->set_date_prop( 'date_created', $date );
	}

	/**
	 * Set date_modified
	 *
	 * @since  3.0.0
	 * @param string|integer|null $date UTC timestamp, or ISO 8601 DateTime. If the DateTime string has no timezone or offset, WordPress site timezone will be assumed. Null if there is no date.
	 */
	public function set_date_modified( $date ) {
		$this->set_date_prop( 'date_modified', $date );
	}

	/**
	 * Set how many times this coupon has been used.
	 *
	 * @since 3.0.0
	 * @param int $usage_count Usage count.
	 */
	public function set_usage_count( $usage_count ) {
		$this->set_prop( 'usage_count', absint( $usage_count ) );
	}

	/**
	 * Set if this coupon can only be used once.
	 *
	 * @since 3.0.0
	 * @param bool $is_individual_use If is for individual use.
	 */
	public function set_individual_use( $is_individual_use ) {
		$this->set_prop( 'individual_use', (bool) $is_individual_use );
	}

	/**
	 * Set the product IDs this coupon can be used with.
	 *
	 * @since 3.0.0
	 * @param array $product_ids Products IDs.
	 */
	public function set_product_ids( $product_ids ) {
		$this->set_prop( 'product_ids', array_filter( wp_parse_id_list( (array) $product_ids ) ) );
	}

	/**
	 * Set the product IDs this coupon cannot be used with.
	 *
	 * @since 3.0.0
	 * @param array $excluded_product_ids Exclude product IDs.
	 */
	public function set_excluded_product_ids( $excluded_product_ids ) {
		$this->set_prop( 'excluded_product_ids', array_filter( wp_parse_id_list( (array) $excluded_product_ids ) ) );
	}

	/**
	 * Set the amount of times this coupon can be used.
	 *
	 * @since 3.0.0
	 * @param int $usage_limit Usage limit.
	 */
	public function set_usage_limit( $usage_limit ) {
		$this->set_prop( 'usage_limit', absint( $usage_limit ) );
	}

	/**
	 * Set the amount of times this coupon can be used per user.
	 *
	 * @since 3.0.0
	 * @param int $usage_limit Usage limit.
	 */
	public function set_usage_limit_per_user( $usage_limit ) {
		$this->set_prop( 'usage_limit_per_user', absint( $usage_limit ) );
	}

	/**
	 * Set usage limit to x number of items.
	 *
	 * @since 3.0.0
	 * @param int|null $limit_usage_to_x_items Limit usage to X items.
	 */
	public function set_limit_usage_to_x_items( $limit_usage_to_x_items ) {
		$this->set_prop( 'limit_usage_to_x_items', is_null( $limit_usage_to_x_items ) ? null : absint( $limit_usage_to_x_items ) );
	}

	/**
	 * Set if this coupon enables free shipping or not.
	 *
	 * @since 3.0.0
	 * @param bool $free_shipping If grant free shipping.
	 */
	public function set_free_shipping( $free_shipping ) {
		$this->set_prop( 'free_shipping', (bool) $free_shipping );
	}

	/**
	 * Set the product category IDs this coupon can be used with.
	 *
	 * @since 3.0.0
	 * @param array $product_categories List of product categories.
	 */
	public function set_product_categories( $product_categories ) {
		$this->set_prop( 'product_categories', array_filter( wp_parse_id_list( (array) $product_categories ) ) );
	}

	/**
	 * Set the product category IDs this coupon cannot be used with.
	 *
	 * @since 3.0.0
	 * @param array $excluded_product_categories List of excluded product categories.
	 */
	public function set_excluded_product_categories( $excluded_product_categories ) {
		$this->set_prop( 'excluded_product_categories', array_filter( wp_parse_id_list( (array) $excluded_product_categories ) ) );
	}

	/**
	 * Set if this coupon should excluded sale items or not.
	 *
	 * @since 3.0.0
	 * @param bool $exclude_sale_items If should exclude sale items.
	 */
	public function set_exclude_sale_items( $exclude_sale_items ) {
		$this->set_prop( 'exclude_sale_items', (bool) $exclude_sale_items );
	}

	/**
	 * Set if this coupon should excluded sale prices or not.
	 *
	 * @since 3.0.0
	 * @param bool $exclude_sale_prices If should exclude sale prices.
	 */
	public function set_exclude_sale_prices( $exclude_sale_prices ) {
		$this->set_prop( 'exclude_sale_prices', (bool) $exclude_sale_prices );
	}

	/**
	 * Set the minimum spend amount.
	 *
	 * @since 3.0.0
	 * @param float $amount Minium amount.
	 */
	public function set_minimum_amount( $amount ) {
		$this->set_prop( 'minimum_amount', wc_format_decimal( $amount ) );
	}

	/**
	 * Set the maximum spend amount.
	 *
	 * @since 3.0.0
	 * @param float $amount Maximum amount.
	 */
	public function set_maximum_amount( $amount ) {
		$this->set_prop( 'maximum_amount', wc_format_decimal( $amount ) );
	}

	/**
	 * Set email restrictions.
	 *
	 * @since 3.0.0
	 * @param array $emails List of emails.
	 */
	public function set_email_restrictions( $emails = array() ) {
		$emails = array_filter( array_map( 'sanitize_email', array_map( 'strtolower', (array) $emails ) ) );
		foreach ( $emails as $email ) {
			if ( ! is_email( $email ) ) {
				$this->error( 'coupon_invalid_email_address', __( 'Invalid email address restriction', 'woocommerce' ) );
			}
		}
		$this->set_prop( 'email_restrictions', $emails );
	}

	/**
	 * Set which users have used this coupon.
	 *
	 * @since 3.0.0
	 * @param array $used_by List of user IDs.
	 */
	public function set_used_by( $used_by ) {
		$this->set_prop( 'used_by', array_filter( $used_by ) );
	}

	/**
	 * Set coupon virtual state.
	 *
	 * @param boolean $virtual Whether it is virtual or not.
	 * @since 3.2.0
	 */
	public function set_virtual( $virtual ) {
		$this->set_prop( 'virtual', (bool) $virtual );
	}

	/*
	|--------------------------------------------------------------------------
	| Other Actions
	|--------------------------------------------------------------------------
	*/

	/**
	 * Developers can programmatically return coupons. This function will read those values into our WC_Coupon class.
	 *
	 * @since 3.0.0
	 * @param string $code   Coupon code.
	 * @param array  $coupon Array of coupon properties.
	 */
	public function read_manual_coupon( $code, $coupon ) {

		foreach ( $coupon as $key => $value ) {
			switch ( $key ) {
				case 'excluded_product_ids':
				case 'exclude_product_ids':
					if ( ! is_array( $coupon[ $key ] ) ) {
						wc_doing_it_wrong( $key, $key . ' should be an array instead of a string.', '3.0' );
						$coupon['excluded_product_ids'] = wc_string_to_array( $value );
					}
					break;
				case 'exclude_product_categories':
				case 'excluded_product_categories':
					if ( ! is_array( $coupon[ $key ] ) ) {
						wc_doing_it_wrong( $key, $key . ' should be an array instead of a string.', '3.0' );
						$coupon['excluded_product_categories'] = wc_string_to_array( $value );
					}
					break;
				case 'product_ids':
					if ( ! is_array( $coupon[ $key ] ) ) {
						wc_doing_it_wrong( $key, $key . ' should be an array instead of a string.', '3.0' );
						$coupon[ $key ] = wc_string_to_array( $value );
					}
					break;
				case 'individual_use':
				case 'free_shipping':
				case 'exclude_sale_items':
					if ( ! is_bool( $coupon[ $key ] ) ) {
						wc_doing_it_wrong( $key, $key . ' should be true or false instead of yes or no.', '3.0' );
						$coupon[ $key ] = wc_string_to_bool( $value );
					}
					break;
				case 'exclude_sale_prices':
					if ( ! is_bool( $coupon[ $key ] ) ) {
						wc_doing_it_wrong( $key, $key . ' should be true or false instead of yes or no.', '3.0' );
						$coupon[ $key ] = wc_string_to_bool( $value );
					}
					break;
				case 'expiry_date':
					$coupon['date_expires'] = $value;
					break;
			}
		}
		$this->set_props( $coupon );
		$this->set_code( $code );
		$this->set_id( 0 );
		$this->set_virtual( true );
	}

	/**
	 * Increase usage count for current coupon.
	 *
	 * @param string   $used_by  Either user ID or billing email.
	 * @param WC_Order $order  If provided, will clear the coupons held by this order.
	 */
	public function increase_usage_count( $used_by = '', $order = null ) {
		if ( $this->get_id() && $this->data_store ) {
			$new_count = $this->data_store->increase_usage_count( $this, $used_by, $order );

			// Bypass set_prop and remove pending changes since the data store saves the count already.
			$this->data['usage_count'] = $new_count;
			if ( isset( $this->changes['usage_count'] ) ) {
				unset( $this->changes['usage_count'] );
			}
		}
	}

	/**
	 * Decrease usage count for current coupon.
	 *
	 * @param string $used_by Either user ID or billing email.
	 */
	public function decrease_usage_count( $used_by = '' ) {
		if ( $this->get_id() && $this->get_usage_count() > 0 && $this->data_store ) {
			$new_count = $this->data_store->decrease_usage_count( $this, $used_by );

			// Bypass set_prop and remove pending changes since the data store saves the count already.
			$this->data['usage_count'] = $new_count;
			if ( isset( $this->changes['usage_count'] ) ) {
				unset( $this->changes['usage_count'] );
			}
		}
	}

	/*
	|--------------------------------------------------------------------------
	| Validation & Error Handling
	|--------------------------------------------------------------------------
	*/

	/**
	 * Returns the error_message string.

	 * @return string
	 */
	public function get_error_message() {
		return $this->error_message;
	}

	/**
	 * Check if a coupon is valid for the cart.
	 *
	 * @deprecated 3.2.0 In favor of WC_Discounts->is_coupon_valid.
	 * @return bool
	 */
	public function is_valid() {
		$discounts = new WC_Discounts( WC()->cart );
		$valid     = $discounts->is_coupon_valid( $this );

		if ( is_wp_error( $valid ) ) {
			$this->error_message = $valid->get_error_message();
			return false;
		}

		return $valid;
	}

	/**
	 * Check if a coupon is valid.
	 *
	 * @return bool
	 */
	public function is_valid_for_cart() {
		return apply_filters( 'woocommerce_coupon_is_valid_for_cart', $this->is_type( wc_get_cart_coupon_types() ), $this );
	}

	/**
	 * Check if a coupon is valid for a product.
	 *
	 * @param WC_Product $product Product instance.
	 * @param array      $values  Values.
	 * @return bool
	 */
	public function is_valid_for_product( $product, $values = array() ) {
		if ( ! $this->is_type( wc_get_product_coupon_types() ) ) {
			return apply_filters( 'woocommerce_coupon_is_valid_for_product', false, $product, $this, $values );
		}

		$valid        = false;
		$product_cats = wc_get_product_cat_ids( $product->is_type( 'variation' ) ? $product->get_parent_id() : $product->get_id() );
		$product_ids  = array( $product->get_id(), $product->get_parent_id() );

		// Specific products get the discount.
		if ( count( $this->get_product_ids() ) && count( array_intersect( $product_ids, $this->get_product_ids() ) ) ) {
			$valid = true;
		}

		// Category discounts.
		if ( count( $this->get_product_categories() ) && count( array_intersect( $product_cats, $this->get_product_categories() ) ) ) {
			$valid = true;
		}

		// No product ids - all items discounted.
		if ( ! count( $this->get_product_ids() ) && ! count( $this->get_product_categories() ) ) {
			$valid = true;
		}

		// Specific product IDs excluded from the discount.
		if ( count( $this->get_excluded_product_ids() ) && count( array_intersect( $product_ids, $this->get_excluded_product_ids() ) ) ) {
			$valid = false;
		}

		// Specific categories excluded from the discount.
		if ( count( $this->get_excluded_product_categories() ) && count( array_intersect( $product_cats, $this->get_excluded_product_categories() ) ) ) {
			$valid = false;
		}

		// Sale Items excluded from discount.
		if ( $this->get_exclude_sale_items() && $product->is_on_sale() ) {
			$valid = false;
		}

		return apply_filters( 'woocommerce_coupon_is_valid_for_product', $valid, $product, $this, $values );
	}

	/**
	 * Converts one of the WC_Coupon message/error codes to a message string and.
	 * displays the message/error.
	 *
	 * @param int $msg_code Message/error code.
	 */
	public function add_coupon_message( $msg_code ) {
		$msg = $msg_code < 200 ? $this->get_coupon_error( $msg_code ) : $this->get_coupon_message( $msg_code );

		if ( ! $msg ) {
			return;
		}

		if ( $msg_code < 200 ) {
			wc_add_notice( $msg, 'error' );
		} else {
			wc_add_notice( $msg );
		}
	}

	/**
	 * Map one of the WC_Coupon message codes to a message string.
	 *
	 * @param integer $msg_code Message code.
	 * @return string Message/error string.
	 */
	public function get_coupon_message( $msg_code ) {
		switch ( $msg_code ) {
			case self::WC_COUPON_SUCCESS:
				$msg = __( 'Coupon code applied successfully.', 'woocommerce' );
				break;
			case self::WC_COUPON_REMOVED:
				$msg = __( 'Coupon code removed successfully.', 'woocommerce' );
				break;
			default:
				$msg = '';
				break;
		}
		return apply_filters( 'woocommerce_coupon_message', $msg, $msg_code, $this );
	}

	/**
	 * Map one of the WC_Coupon error codes to a message string.
	 *
	 * @param int $err_code Message/error code.
	 * @return string Message/error string
	 */
	public function get_coupon_error( $err_code ) {
		switch ( $err_code ) {
			case self::E_WC_COUPON_INVALID_FILTERED:
				$err = __( 'Coupon is not valid.', 'woocommerce' );
				break;
			case self::E_WC_COUPON_NOT_EXIST:
				/* translators: %s: coupon code */
				$err = sprintf( __( 'Coupon "%s" does not exist!', 'woocommerce' ), esc_html( $this->get_code() ) );
				break;
			case self::E_WC_COUPON_INVALID_REMOVED:
				/* translators: %s: coupon code */
				$err = sprintf( __( 'Sorry, it seems the coupon "%s" is invalid - it has now been removed from your order.', 'woocommerce' ), esc_html( $this->get_code() ) );
				break;
			case self::E_WC_COUPON_NOT_YOURS_REMOVED:
				/* translators: %s: coupon code */
				$err = sprintf( __( 'Sorry, it seems the coupon "%s" is not yours - it has now been removed from your order.', 'woocommerce' ), esc_html( $this->get_code() ) );
				break;
			case self::E_WC_COUPON_ALREADY_APPLIED:
				$err = __( 'Coupon code already applied!', 'woocommerce' );
				break;
			case self::E_WC_COUPON_ALREADY_APPLIED_INDIV_USE_ONLY:
				/* translators: %s: coupon code */
				$err = sprintf( __( 'Sorry, coupon "%s" has already been applied and cannot be used in conjunction with other coupons.', 'woocommerce' ), esc_html( $this->get_code() ) );
				break;
			case self::E_WC_COUPON_USAGE_LIMIT_REACHED:
				$err = __( 'Coupon usage limit has been reached.', 'woocommerce' );
				break;
			case self::E_WC_COUPON_EXPIRED:
				$err = __( 'This coupon has expired.', 'woocommerce' );
				break;
			case self::E_WC_COUPON_MIN_SPEND_LIMIT_NOT_MET:
				/* translators: %s: coupon minimum amount */
				$err = sprintf( __( 'The minimum spend for this coupon is %s.', 'woocommerce' ), wc_price( $this->get_minimum_amount() ) );
				break;
			case self::E_WC_COUPON_MAX_SPEND_LIMIT_MET:
				/* translators: %s: coupon maximum amount */
				$err = sprintf( __( 'The maximum spend for this coupon is %s.', 'woocommerce' ), wc_price( $this->get_maximum_amount() ) );
				break;
			case self::E_WC_COUPON_NOT_APPLICABLE:
				$err = __( 'Sorry, this coupon is not applicable to your cart contents.', 'woocommerce' );
				break;
			case self::E_WC_COUPON_EXCLUDED_PRODUCTS:
				// Store excluded products that are in cart in $products.
				$products = array();
				if ( ! WC()->cart->is_empty() ) {
					foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
						if ( in_array( intval( $cart_item['product_id'] ), $this->get_excluded_product_ids(), true ) || in_array( intval( $cart_item['variation_id'] ), $this->get_excluded_product_ids(), true ) || in_array( intval( $cart_item['data']->get_parent_id() ), $this->get_excluded_product_ids(), true ) ) {
							$products[] = $cart_item['data']->get_name();
						}
					}
				}

				/* translators: %s: products list */
				$err = sprintf( __( 'Sorry, this coupon is not applicable to the products: %s.', 'woocommerce' ), implode( ', ', $products ) );
				break;
			case self::E_WC_COUPON_EXCLUDED_CATEGORIES:
				// Store excluded categories that are in cart in $categories.
				$categories = array();
				if ( ! WC()->cart->is_empty() ) {
					foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
						$product_cats = wc_get_product_cat_ids( $cart_item['product_id'] );
						$intersect    = array_intersect( $product_cats, $this->get_excluded_product_categories() );

						if ( count( $intersect ) > 0 ) {
							foreach ( $intersect as $cat_id ) {
								$cat          = get_term( $cat_id, 'product_cat' );
								$categories[] = $cat->name;
							}
						}
					}
				}

				/* translators: %s: categories list */
				$err = sprintf( __( 'Sorry, this coupon is not applicable to the categories: %s.', 'woocommerce' ), implode( ', ', array_unique( $categories ) ) );
				break;
			case self::E_WC_COUPON_NOT_VALID_SALE_ITEMS:
				$err = __( 'Sorry, this coupon is not valid for sale items.', 'woocommerce' );
				break;
			default:
				$err = '';
				break;
		}
		return apply_filters( 'woocommerce_coupon_error', $err, $err_code, $this );
	}

	/**
	 * Map one of the WC_Coupon error codes to an error string.
	 * No coupon instance will be available where a coupon does not exist,
	 * so this static method exists.
	 *
	 * @param int $err_code Error code.
	 * @return string Error string.
	 */
	public static function get_generic_coupon_error( $err_code ) {
		switch ( $err_code ) {
			case self::E_WC_COUPON_NOT_EXIST:
				$err = __( 'Coupon does not exist!', 'woocommerce' );
				break;
			case self::E_WC_COUPON_PLEASE_ENTER:
				$err = __( 'Please enter a coupon code.', 'woocommerce' );
				break;
			default:
				$err = '';
				break;
		}
		// When using this static method, there is no $this to pass to filter.
		return apply_filters( 'woocommerce_coupon_error', $err, $err_code, null );
	}
}

