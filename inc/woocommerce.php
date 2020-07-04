<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package aperabags
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
 */
defined( 'ABSPATH' ) || exit;

/**
 * This adds woocommerce theme support.
 */
function apera_bags_woocommerce_setup() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'apera_bags_woocommerce_setup' );

add_filter( 'woocommerce_shipping_chosen_method', '__return_false', 99 );

/**
 * WooCommerce specific scripts & stylesheets.
 */
function apera_bags_woocommerce_scripts() {
	wp_enqueue_style( 'apera-bags-woocommerce-style', str_replace( array( 'http:', 'https:' ), '', get_stylesheet_directory_uri() . '/woocommerce.css' ), array(), wp_get_theme()->get( 'Version' ), 'all' );

	$font_path = str_replace( array( 'http:', 'https:' ), '', WC()->plugin_url() . '/assets/fonts/' );

	$inline_font = '@font-face {
		font-family: "star";
		src: url("' . $font_path . 'star.eot");
		src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
		url("' . $font_path . 'star.woff") format("woff"),
		url("' . $font_path . 'star.ttf") format("truetype"),
		url("' . $font_path . 'star.svg#star") format("svg");
		font-weight: normal;
		font-style: normal;
	}';

	wp_add_inline_style( 'apera-bags-woocommerce-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'apera_bags_woocommerce_scripts', 9 );

require_once get_stylesheet_directory() . '/inc/class-wonkasoft-wc-meta-box-coupon-data.php';

/**
* Disable the default WooCommerce stylesheet.
*
* Removing the default WooCommerce stylesheet and enqueing your own will
* protect you during WooCommerce core updates.
*
* @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
*/
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function apera_bags_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'apera_bags_woocommerce_active_body_class' );

/**
 * Products per page.
 *
 * @return integer number of products.
 */
function apera_bags_woocommerce_products_per_page() {
	return 12;
}
add_filter( 'loop_shop_per_page', 'apera_bags_woocommerce_products_per_page' );

/**
 * Product gallery thumnbail columns.
 *
 * @return integer number of columns.
 */
function apera_bags_woocommerce_thumbnail_columns() {
	return 4;
}
add_filter( 'woocommerce_product_thumbnails_columns', 'apera_bags_woocommerce_thumbnail_columns' );

/**
 * Default loop columns on product archives.
 *
 * @return integer products per row.
 */
function apera_bags_woocommerce_loop_columns() {
	return 3;
}
add_filter( 'loop_shop_columns', 'apera_bags_woocommerce_loop_columns' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function apera_bags_woocommerce_related_products_args( $args ) {

	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'apera_bags_woocommerce_related_products_args' );

if ( ! function_exists( 'apera_bags_woocommerce_product_columns_wrapper' ) ) {
	/**
	 Product columns wrapper.

	 @return  void
	 */
	function apera_bags_woocommerce_product_columns_wrapper() {
		$columns = apera_bags_woocommerce_loop_columns();
		echo '<div class="row wonka-row row-columns-' . absint( $columns ) . '">';
	}
}
add_action( 'woocommerce_before_shop_loop', 'apera_bags_woocommerce_product_columns_wrapper', 40 );

if ( ! function_exists( 'apera_bags_woocommerce_product_columns_wrapper_close' ) ) {
	/**
	 Product columns wrapper close.

	 @return  void
	 */
	function apera_bags_woocommerce_product_columns_wrapper_close() {
		echo '</div><!-- close for product columns -->';
	}
}
add_action( 'woocommerce_after_shop_loop', 'apera_bags_woocommerce_product_columns_wrapper_close', 40 );

/**
* Remove default WooCommerce wrapper.
*/
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'apera_bags_woocommerce_wrapper_before' ) ) {
	/**
	 Before Content.

	 Wraps all WooCommerce content in wrappers which match the theme markup.

	 @return void
	 */
	function apera_bags_woocommerce_wrapper_before() {
		global $post;

		$ws_post_type = ( ! empty( $post->post_type ) ) ? ' main-' . $post->post_type : '';
		$ws_post_slug = ( ! empty( $post->post_name ) ) ? ' main-' . $post->post_name : '';
		?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main<?php echo esc_attr( $ws_post_slug . $ws_post_type ); ?>" role="main">
			<?php
	}
}
	add_action( 'woocommerce_before_main_content', 'apera_bags_woocommerce_wrapper_before' );

if ( ! function_exists( 'apera_bags_woocommerce_wrapper_after' ) ) {
	/**
	 After Content.

	 Closes the wrapping divs.

	 @return void
	 */
	function apera_bags_woocommerce_wrapper_after() {
		?>
</main><!-- #main -->
</div><!-- #primary -->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'apera_bags_woocommerce_wrapper_after' );

/**
* Sample implementation of the WooCommerce Mini Cart.
*
* You can add the WooCommerce Mini Cart to header.php like so ...
*
<?php
if ( function_exists( 'apera_bags_woocommerce_header_cart' ) ) {
apera_bags_woocommerce_header_cart();
}
?>
*/

if ( ! function_exists( 'apera_bags_woocommerce_cart_link_fragment' ) ) {
	/**
	 Cart Fragments.

	 Ensure cart contents update when products are added to the cart via AJAX.

	 @param array $fragments Fragments to refresh via AJAX.
	 @return array Fragments to refresh via AJAX.
	 */
	function apera_bags_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		$fragments['span.cart-contents-count.wonka-cart-badge.badge.badge-light'] = '<span class="cart-contents-count wonka-cart-badge badge badge-light">' . WC()->cart->get_cart_contents_count() . '</span>';
		ob_get_clean();
		return $fragments;
	}
}

add_filter( 'woocommerce_add_to_cart_fragments', 'apera_bags_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'apera_bags_woocommerce_cart_link' ) ) {
	/**
	 Cart Link.

	 Displayed a link to the cart including the number of items present and the cart total.

	 @return void
	 */
	function apera_bags_woocommerce_cart_link() {
		?>
	<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'apera-bags' ); ?>">
		<?php
		$item_count_text = sprintf(
			/* translators: number of items in the mini cart. */
			_n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'apera-bags' ),
			WC_Cart()->get_total()
		);
		?>
		<span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span> <span class="count"><?php echo esc_html( $item_count_text ); ?></span>
	</a>
		<?php
	}
}

/**
 * This sets up the image flipper class
 *
 * @param  array $classes contains all the classes for the current product.
 * @return array $classes posts all classes to the current product.
 */
function setting_up_image_flipper_class( $classes ) {
	global $product;
	$post_type = get_post_type( get_the_ID() );
	if ( ! is_admin() ) {
		if ( 'product' === $post_type ) {
			$attachment_ids = $product->get_gallery_image_ids( $product );
			if ( $attachment_ids ) {
				$classes[] = 'pif-has-gallery';
			}
		}
	}
	return $classes;
}
add_filter( 'post_class', 'setting_up_image_flipper_class', 8 );

/**
 * This function is to override the parsing of the images during a shop loop
 */
function wonka_customized_shop_loop() {

	// For setting up the image flipper.
	global $product;

	if ( ! is_a( $product, 'WC_Product' ) ) {
		return;
	}
	if ( is_callable( 'WC_Product::get_gallery_image_ids' ) ) {
		$attachment_ids = $product->get_gallery_image_ids();
	} else {
		$attachment_ids = $product->get_gallery_attachment_ids();
	}
	if ( $attachment_ids ) :
		$attachment_ids        = array_values( $attachment_ids );
		$secondary_image_id    = $attachment_ids['0'];
		$secondary_image_alt   = get_post_meta( $secondary_image_id, '_wp_attachment_image_alt', true );
		$secondary_image_title = get_the_title( $secondary_image_id );
	endif;

	/*=====  End of For setting up the image flipper  ======*/
	$post_id           = get_the_ID();
	$post_thumbnail_id = get_post_thumbnail_id( $post_id );

	$output  = '';
	$output .= '<div class="wonka-shop-img-wrap">';
	if ( is_front_page() || is_home() ) :
		$output .= '<img class="img wonka-img" data-src="' . str_replace( array( 'http:', 'https:' ), '', esc_attr( wp_get_attachment_image_src( $post_thumbnail_id, 'custom_products_size', false )[0] ) ) . '" data-srcset="' . str_replace( array( 'http:', 'https:' ), '', esc_attr( wp_get_attachment_image_srcset( $post_thumbnail_id, 'custom_products_size', null ) ) ) . '" />';
		if ( $attachment_ids ) :
			$output .= '<img title="' . $secondary_image_title . '" class="secondary-image attachment-shop-catalog wp-post-image wp-post-image--secondary" data-src="' . str_replace( array( 'http:', 'https:' ), '', esc_attr( wp_get_attachment_image_src( $secondary_image_id, 'custom_products_size', false )[0] ) ) . '" data-srcset="' . str_replace( array( 'http:', 'https:' ), '', esc_attr( wp_get_attachment_image_srcset( $secondary_image_id, 'custom_products_size', null ) ) ) . '" />';
	endif;
		else :
			$output .= '<img class="img wonka-img" src="' . str_replace( array( 'http:', 'https:' ), '', esc_attr( wp_get_attachment_image_src( $post_thumbnail_id, 'custom_products_size', false )[0] ) ) . '" srcset="' . str_replace( array( 'http:', 'https:' ), '', esc_attr( wp_get_attachment_image_srcset( $post_thumbnail_id, 'custom_products_size', null ) ) ) . '" />';
			if ( $attachment_ids ) :
				$output .= '<img title="' . $secondary_image_title . '" class="secondary-image attachment-shop-catalog wp-post-image wp-post-image--secondary" src="' . str_replace( array( 'http:', 'https:' ), '', esc_attr( wp_get_attachment_image_src( $secondary_image_id, 'custom_products_size', false )[0] ) ) . '" srcset="' . str_replace( array( 'http:', 'https:' ), '', esc_attr( wp_get_attachment_image_srcset( $secondary_image_id, 'custom_products_size', null ) ) ) . '" />';
			endif;
endif;
		$output .= '</div><!-- .wonka-shop-img-wrap -->';

		echo wp_kses(
			$output,
			array(
				'div' => array(
					'class' => array(),
				),
				'img' => array(
					'class'       => array(),
					'data-src'    => array(),
					'src'         => array(),
					'title'       => array(),
					'alt'         => array(),
					'data-srcset' => array(),
					'srcset'      => array(),
				),
			)
		);
}

if ( ! get_theme_mod( 'enable_sale_banner' ) ) :
	remove_filter( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
endif;
remove_filter( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_filter( 'woocommerce_before_shop_loop_item_title', 'wonka_customized_shop_loop', 11 );

/* removing the side bar */
remove_filter( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/**
 * Exclude products from a particular category on the shop page
 *
 * @author Louis <llister@wonkasoft.com>
 * @since 1.0.1
 * @param array $q contains the current query.
 */
function custom_pre_get_posts_query( $q ) {
	$tax_query = (array) $q->get( 'tax_query' );

	$tax_query[] = array(
		'taxonomy' => 'product_cat',
		'field'    => 'slug',
		'terms'    => array( 'outlet' ), // Don't display products in the outlet category on the shop page.
		'operator' => 'NOT IN',
	);

	$q->set( 'tax_query', $tax_query );
}
add_action( 'woocommerce_product_query', 'custom_pre_get_posts_query' );

/**
 * Add all outlet items after the main shop items
 *
 * @author Louis L <llister@wonkasoft.com>
 * @since 1.0.1 Updates
 */
function add_outlet_items() {
	echo "<div class='text-center outlet-title'><h2>Outlet Section</h2></div>";
	echo do_shortcode( '[products columns="2" category="outlet"]' );
}
add_action( 'woocommerce_after_shop_loop', 'add_outlet_items' );

/**
* This hooks into woocommerce templates to find the added key features and specs template.
*/
if ( ! function_exists( 'woocommerce_product_key_features_and_specs_tab' ) ) {

	/**
	 Output the description tab content.
	 */
	function woocommerce_product_key_features_and_specs_tab() {
		wc_get_template( 'single-product/tabs/key-features-and-specs.php' );
	}
}

/**
 * Changes the description tab title
 *
 * @param  array $tabs setting up the changed titles.
 *
 * @return array returns the product tabs.
 */
function wonka_product_tabs_retitle( $tabs ) {
	$new_title                       = get_post_meta( get_the_ID(), 'product_statement', true );
	$tabs['reviews']['priority']     = 30;          // Reviews first.
	$tabs['description']['priority'] = 20;          // Description second.
	unset( $tabs['additional_information'] );   // Additional information third.
	$tabs['description']['title']               = esc_html( $new_title );
	$tabs['description']['section']             = __( 'Product Statement' );
	$tabs['key_features_and_specs']['title']    = __( 'Key Featrues and Specs' );
	$tabs['key_features_and_specs']['priority'] = 10;
	$tabs['key_features_and_specs']['callback'] = 'woocommerce_product_key_features_and_specs_tab';
	$tabs['key_features_and_specs']['section']  = __( 'Key Featrues and Specs' );

	return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'wonka_product_tabs_retitle', 98 );

/**
 * This is for moving the cross sells items on the cart page setting the display of how many items and columns to show.
 */
function wonka_cart_cross_sells() {
	add_filter(
		'woocommerce_cross_sells_columns',
		function () {
			return 3;
		}
	);
	add_filter(
		'woocommerce_cross_sells_total',
		function () {
			return 3;
		}
	);
}

add_action( 'woocommerce_after_cart', 'wonka_cart_cross_sells', 10 );
add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display' );

/**
 * This places a continue shopping notice in the cart.
 */
function wonka_add_continue_shopping_notice_to_cart() {
	$shopping = sprintf( '<div class="return-shopping-wrap"><i class="fa fa-long-arrow-left"></i> <a href="%s" class="continue-shopping">%s</a></div>', esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ), esc_html__( 'Continue shopping', 'woocommerce' ) );

	echo wp_kses(
		$shopping,
		array(
			'div' => array(
				'class' => array(),
			),
			'i'   => array(
				'class' => array(),
			),
			'a'   => array(
				'href'  => array(),
				'class' => array(),
			),
		)
	);
}
add_action( 'woocommerce_before_cart', 'wonka_add_continue_shopping_notice_to_cart', 1 );

/**
 * This removes checkout login form and coupon form from unwanted places.
 */
function wonka_checkout_remove_actions() {
	remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
	remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
}
add_action( 'woocommerce_before_checkout_form', 'wonka_checkout_remove_actions', 1 );

/**
 * This adds some desired opening html tags to the checkout page.
 *
 * @param  array $checkout contains array of checkout parts.
 */
function wonka_checkout_wrap_before( $checkout ) {
	$output  = '';
	$output .= '<div class="row wonka-checkout-row">';
	$output .= '<div class="col col-12 col-md-7 checkout-form-left-side">';

	echo wp_kses(
		$output,
		array(
			'div' => array(
				'class' => array(),
			),
		)
	);
	if ( is_user_logged_in() ) :
		wc_print_notice( "Congrats! You've just earned an extra $10 & free shipping on this order.", 'notice' );
	endif;
}
add_action( 'woocommerce_before_checkout_form', 'wonka_checkout_wrap_before', 25, 1 );

/**
 * This is for adding custom fields to woocommerce shipping and billing fields
 *
 * @param  array $fields all woocommerce fields.
 */
function wonka_override_checkout_fields( $fields ) {

	$fields['shipping']['shipping_phone'] = array(
		'label'       => __( 'Phone', 'woocommerce' ),
		'placeholder' => _x( 'Phone', 'placeholder', 'woocommerce' ),
		'required'    => true,
		'class'       => array( 'form-row' ),
		'clear'       => true,
	);

	$fields['shipping']['shipping_email'] = array(
		'label'       => __( 'Email', 'woocommerce' ),
		'placeholder' => _x( 'Email Address', 'placeholder', 'woocommerce' ),
		'required'    => true,
		'class'       => array( 'form-row' ),
		'clear'       => true,
		'type'        => 'email',
	);

	foreach ( $fields['billing'] as $key => &$field ) {
		if ( 'billing_country' === $key ) :
			$field['priority'] = 95;
		endif;

		if ( ! isset( $field['placeholder'] ) ) :
			$field['placeholder'] = $field['label'];
		endif;

		$field['class'] = array( 'wonka-form-group', 'form-group' );

		$field['label_class'] = array( 'wonka-sr-only', 'sr-only' );

		$field['input_class'] = array( 'wonka-form-control', 'form-control' );
	}

	foreach ( $fields['shipping'] as $key => &$field ) {
		if ( 'shipping_company' === $key || 'shipping_address_2' === $key ) :
			$field['required'] = false;
		endif;

		if ( 'shipping_first_name' === $key ) :
			$field['priority'] = 5;
		endif;

		if ( 'shipping_country' === $key ) :
			$field['priority'] = 95;
		endif;

		if ( ! isset( $field['placeholder'] ) ) :
			$field['placeholder'] = $field['label'];
		endif;

		$field['class'] = array( 'wonka-form-group', 'form-group' );

		$field['label_class'] = array( 'wonka-sr-only', 'sr-only' );

		$field['input_class'] = array( 'wonka-form-control', 'form-control' );
	}

	return $fields;
}
add_filter( 'woocommerce_checkout_fields', 'wonka_override_checkout_fields' );

/**
 * This modifies the woocommerce form field.
 *
 * @param  array  $field array of the current field.
 * @param  string $key   key for the current field.
 * @param  array  $args  args that are passed in for the field.
 * @param  string $value value of the current field.
 * @return array        contains the modified field.
 */
function wonka_woocommerce_form_field( $field, $key, $args, $value ) {
	$defaults = array(
		'type'              => 'text',
		'label'             => '',
		'description'       => '',
		'placeholder'       => '',
		'maxlength'         => false,
		'required'          => false,
		'autocomplete'      => false,
		'id'                => $key,
		'class'             => array(),
		'label_class'       => array(),
		'input_class'       => array(),
		'return'            => false,
		'options'           => array(),
		'custom_attributes' => array(),
		'validate'          => array(),
		'default'           => '',
		'autofocus'         => '',
		'priority'          => '',
	);

	$args = wp_parse_args( $args, $defaults );
	$args = apply_filters( 'woocommerce_form_field_args', $args, $key, $value );

	if ( $args['required'] ) {
		$args['class'][] = 'validate-required';
		$required        = '&nbsp;<abbr class="required" title="' . esc_attr__( 'required', 'woocommerce' ) . '">*</abbr>';
	} else {
		$required = '&nbsp;<span class="optional">(' . esc_html__( 'optional', 'woocommerce' ) . ')</span>';
	}

	if ( is_string( $args['label_class'] ) ) {
		$args['label_class'] = array( $args['label_class'] );
	}

	if ( is_null( $value ) ) {
		$value = $args['default'];
	}

	// Custom attribute handling.
	$custom_attributes         = array();
	$args['custom_attributes'] = array_filter( (array) $args['custom_attributes'], 'strlen' );

	if ( $args['maxlength'] ) {
		$args['custom_attributes']['maxlength'] = absint( $args['maxlength'] );
	}

	if ( ! empty( $args['autocomplete'] ) ) {
		$args['custom_attributes']['autocomplete'] = $args['autocomplete'];
	}

	if ( true === $args['autofocus'] ) {
		$args['custom_attributes']['autofocus'] = 'autofocus';
	}

	if ( $args['description'] ) {
		$args['custom_attributes']['aria-describedby'] = $args['id'] . '-description';
	}

	if ( ! empty( $args['custom_attributes'] ) && is_array( $args['custom_attributes'] ) ) {
		foreach ( $args['custom_attributes'] as $attribute => $attribute_value ) {
			$custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
		}
	}

	if ( ! empty( $args['validate'] ) ) {
		foreach ( $args['validate'] as $validate ) {
			$args['class'][] = 'validate-' . $validate;
		}
	}

	$field           = '';
	$label_id        = $args['id'];
	$sort            = $args['priority'] ? $args['priority'] : '';
	$field_container = '<div class="%1$s" id="%2$s" data-priority="' . esc_attr( $sort ) . '">%3$s</div>';

	switch ( $args['type'] ) {
		case 'country':
			$countries = 'shipping_country' === $key ? WC()->countries->get_shipping_countries() : WC()->countries->get_allowed_countries();

			if ( 1 === count( $countries ) ) {
				$field .= '<strong>' . current( array_values( $countries ) ) . '</strong>';

				$field .= '<input type="hidden" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="' . current( array_keys( $countries ) ) . '" ' . implode( ' ', $custom_attributes ) . ' class="country_to_state" readonly="readonly" />';
			} else {
				$field = '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="country_to_state country_select ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . '><option value="">' . esc_html__( 'Select a country&hellip;', 'woocommerce' ) . '</option>';

				foreach ( $countries as $ckey => $cvalue ) {
					$field .= '<option value="' . esc_attr( $ckey ) . '" ' . selected( $value, $ckey, false ) . '>' . $cvalue . '</option>';
				}

				$field .= '</select>';

				$field .= '<noscript><button type="submit" name="woocommerce_checkout_update_totals" value="' . esc_attr__( 'Update country', 'woocommerce' ) . '">' . esc_html__( 'Update country', 'woocommerce' ) . '</button></noscript>';
			}

			break;
		case 'state':
			/* Get country this state field is representing */
			$for_country = isset( $args['country'] ) ? $args['country'] : WC()->checkout->get_value( 'billing_state' === $key ? 'billing_country' : 'shipping_country' );
			$states      = WC()->countries->get_states( $for_country );

			if ( is_array( $states ) && empty( $states ) ) {
				$field_container = '<p class="form-row %1$s" id="%2$s" style="display: none">%3$s</p>';

				$field .= '<input type="hidden" class="hidden" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="" ' . implode( ' ', $custom_attributes ) . ' placeholder="' . esc_attr( $args['placeholder'] ) . '" readonly="readonly" />';
			} elseif ( ! is_null( $for_country ) && is_array( $states ) ) {
				$field .= '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="state_select ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . ' data-placeholder="' . esc_attr( $args['placeholder'] ? $args['placeholder'] : esc_html__( 'Select an option&hellip;', 'woocommerce' ) ) . '">
			<option value="">' . esc_html__( 'Select an option&hellip;', 'woocommerce' ) . '</option>';

				foreach ( $states as $ckey => $cvalue ) {
					$field .= '<option value="' . esc_attr( $ckey ) . '" ' . selected( $value, $ckey, false ) . '>' . $cvalue . '</option>';
				}

				$field .= '</select>';
			} else {
				$field .= '<input type="text" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" value="' . esc_attr( $value ) . '"  placeholder="' . esc_attr( $args['placeholder'] ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" ' . implode( ' ', $custom_attributes ) . ' />';
			}

			break;
		case 'textarea':
			$field .= '<textarea name="' . esc_attr( $key ) . '" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" ' . ( empty( $args['custom_attributes']['rows'] ) ? ' rows="2"' : '' ) . ( empty( $args['custom_attributes']['cols'] ) ? ' cols="5"' : '' ) . implode( ' ', $custom_attributes ) . '>' . esc_textarea( $value ) . '</textarea>';

			break;
		case 'checkbox':
			$field = '<label class="checkbox ' . implode( ' ', $args['label_class'] ) . '" ' . implode( ' ', $custom_attributes ) . '>
		<input type="' . esc_attr( $args['type'] ) . '" class="input-checkbox ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="1" ' . checked( $value, 1, false ) . ' /> ' . $args['label'] . $required . '</label>';

			break;
		case 'text':
		case 'password':
		case 'datetime':
		case 'datetime-local':
		case 'date':
		case 'month':
		case 'time':
		case 'week':
		case 'number':
		case 'email':
		case 'url':
		case 'tel':
			$field .= '<input type="' . esc_attr( $args['type'] ) . '" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '"  value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . ' />';

			break;
		case 'select':
			$field   = '';
			$options = '';

			if ( ! empty( $args['options'] ) ) {
				foreach ( $args['options'] as $option_key => $option_text ) {
					if ( '' === $option_key ) {
						// If we have a blank option, select2 needs a placeholder.
						if ( empty( $args['placeholder'] ) ) {
							$args['placeholder'] = $option_text ? $option_text : __( 'Choose an option', 'woocommerce' );
						}
						$custom_attributes[] = 'data-allow_clear="true"';
					}
					$options .= '<option value="' . esc_attr( $option_key ) . '" ' . selected( $value, $option_key, false ) . '>' . esc_attr( $option_text ) . '</option>';
				}

				$field .= '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="select ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . ' data-placeholder="' . esc_attr( $args['placeholder'] ) . '">
			' . $options . '
			</select>';
			}

			break;
		case 'radio':
			$label_id .= '_' . current( array_keys( $args['options'] ) );

			if ( ! empty( $args['options'] ) ) {
				foreach ( $args['options'] as $option_key => $option_text ) {
					$field .= '<input type="radio" class="input-radio ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" value="' . esc_attr( $option_key ) . '" name="' . esc_attr( $key ) . '" ' . implode( ' ', $custom_attributes ) . ' id="' . esc_attr( $args['id'] ) . '_' . esc_attr( $option_key ) . '"' . checked( $value, $option_key, false ) . ' />';
					$field .= '<label for="' . esc_attr( $args['id'] ) . '_' . esc_attr( $option_key ) . '" class="radio ' . implode( ' ', $args['label_class'] ) . '">' . $option_text . '</label>';
				}
			}

			break;
	}

	if ( ! empty( $field ) ) {
		$field_html = '';

		if ( $args['label'] && 'checkbox' !== $args['type'] ) {
			$field_html .= '<label for="' . esc_attr( $label_id ) . '" class="' . esc_attr( implode( ' ', $args['label_class'] ) ) . '">' . $args['label'] . $required . '</label>';
		}

		$field_html .= $field;

		if ( $args['required'] ) {
			$field_html .= '<div class="error invalid-feedback">';
			$field_html .= sprintf( esc_html( '%s is a required field.' ), $args['label'] );
			$field_html .= '</div>';
		}

		if ( $args['description'] ) {
			$field_html .= '<span class="description" id="' . esc_attr( $args['id'] ) . '-description" aria-hidden="true">' . wp_kses_post( $args['description'] ) . '</span>';
		}

		$container_class = esc_attr( implode( ' ', $args['class'] ) );
		$container_id    = esc_attr( $args['id'] ) . '_field';
		$field           = sprintf( $field_container, $container_class, $container_id, $field_html );
	}

	return $field;
}
add_filter( 'woocommerce_form_field', 'wonka_woocommerce_form_field', 10, 4 );

/**
 * This builds a custom table of order details on the checkout page.
 *
 * @param  array $checkout contains the checkout items.
 */
function wonka_checkout_after_checkout_form_custom( $checkout ) {
	?>
	<div id="wonka-checkout-step-buttons" class="wonka-step-buttons tab-content">
		<div class="tab-pane fade show active" id="wonka_customer_information_buttons" role="tabpanel">
			<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'checkout' ) ) ); ?>" onclick="if ( typeof ga === 'function' )ga( 'send', { hitType: 'event', eventCategory: 'checkout-back-to-login', eventAction: 'click', eventLabel: 'Return to login' } );" data-target="#checkout" class="btn wonka-btn wonka-multistep-checkout-btn wonka-multistep-back-to-login-btn" 
				<?php
				$style = ( is_user_logged_in() ) ? 'style=visibility:hidden;' : '';
				echo esc_attr( $style );
				?>
				><i class="fa fa-angle-left"></i> Return to login</a>
				<a href="javascript:void(0);" data-target="#wonka_shipping_method_tab" onclick="if ( typeof ga === 'function' )ga( 'send', { hitType: 'event', eventCategory: 'checkout-delivery-options-step', eventAction: 'click', eventLabel: 'Delivery Option Page' } );" class="btn wonka-btn wonka-multistep-checkout-btn wonka-multistep-to-delivery-options-btn">Delivery Options <i class="fa fa-angle-right"></i></a>
			</div>
			<div class="tab-pane fade" id="wonka_shipping_method_buttons" role="tabpanel">
				<a href="#wonka_customer_information_tab" onclick="if ( typeof ga === 'function' )ga( 'send', { hitType: 'event', eventCategory: 'checkout-step-back-to-shipping', eventAction: 'click', eventLabel: 'Shipping' } );" data-target="#wonka_customer_information_tab" class="btn wonka-btn wonka-multistep-checkout-btn wonka-multistep-back-to-shipping-address-btn"><i class="fa fa-angle-left"></i> Back</a>
				<a href="#wonka_payment_method_tab" onclick="if ( typeof ga === 'function' )ga( 'send', { hitType: 'event', eventCategory: 'checkout-payment-method-step', eventAction: 'click', eventLabel: 'Payment Method' } );" data-target="#wonka_payment_method_tab" class="btn wonka-btn wonka-multistep-checkout-btn wonka-multistep-to-payment-methods-btn">Payment Method <i class="fa fa-angle-right"></i></a>
			</div>
			<div class="tab-pane fade" id="wonka_payment_method_buttons" role="tabpanel">
				<a href="#wonka_shipping_method_tab" onclick="if ( typeof ga === 'function' )ga( 'send', { hitType: 'event', eventCategory: 'checkout-step-back-to-delivery-options', eventAction: 'click', eventLabel: 'Back to Delivery Options' } );" data-target="#wonka_shipping_method_tab" class="btn wonka-btn wonka-multistep-checkout-btn wonka-multistep-back-to-delivery-options-btn"><i class="fa fa-angle-left"></i> Back</a>
				<a href="#place_order" onclick="if ( typeof ga === 'function' )ga( 'send', { hitType: 'event', eventCategory: 'checkout-place-order', eventAction: 'click', eventLabel: 'Place Order' } );" data-target="#place_order" class="btn wonka-btn wonka-multistep-checkout-btn wonka-multistep-place-order-btn" id="place_order">Place Order <i class="fa fa-angle-right"></i></a>
			</div>
		</div><!-- #wonka-checkout-step-buttons -->
	</div><!-- .checkout-form-left-side -->
	<div class="col-12 col-md-5 checkout-order-details">
		<h5 class="order-summary-title">Order Summary</h5>
		<div class="table-responsive">
			<table class="table">
				<tbody class="products-area">
					<?php
					foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
						$_product   = apply_filters( 'checkout_review_woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
						$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

						if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

							$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );

							$attributes = '';

							// Variation.
							$attributes .= $_product->is_type( 'variable' ) || $_product->is_type( 'variation' ) ? wc_get_formatted_variation( $_product ) : '';
							?>
							<tr class="product-start <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>" data-product-key="<?php echo esc_attr( $cart_item_key ); ?>">
								<td rowspan="2" class="product-thumbnail">
									<?php
									$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

									if ( ! $product_permalink ) {
										echo $thumbnail; // PHPCS: XSS ok.
										echo wp_kses(
											apply_filters( 'woocommerce_checkout_cart_item_quantity', sprintf( '<strong class="product-quantity wonka-badge" title="Quantity: %s">%s</strong>', $cart_item['quantity'], $cart_item['quantity'] ), $cart_item, $cart_item_key ),
											array(
												'strong' => array(
													'class' => array(),
													'title' => array(),
												),
											)
										);
									} else {
										printf(
											'<a href="%s">%s</a>',
											esc_url( $product_permalink ),
											$thumbnail
										); // PHPCS: XSS ok.
									}
									?>
</td>
<td colspan="2" class="product-name" data-product-key="<?php echo esc_attr( $cart_item_key ); ?>">
							<?php
							echo wp_kses(
								sprintf( '<a href="%s" class="product-link">%s</a>', esc_url( $product_permalink ), apply_filters( 'cart_and_review_woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ),
								array(
									'a' => array(
										'class' => array(),
										'href'  => array(),
									),
								)
							);
							?>
</td>
</tr>
<tr class="second-row <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>" data-product-key="<?php echo esc_attr( $cart_item_key ); ?>">
	<td class="product-name" data-product-key="<?php echo esc_attr( $cart_item_key ); ?>">
							<?php
							echo $attributes ? wp_kses(
								$attributes,
								array(
									'dl' => array(
										'class' => array(),
									),
									'dt' => array(),
									'dd' => array(),
								)
							) : '';
							?>

		<div class="wonkasoft-wsc-price" data-product-key="<?php echo esc_attr( $cart_item_key ); ?>">
			<span class="price-label"><?php _e( 'Price:', 'side-cart-woocommerce' ); ?></span> 
			<span class="price-amount"><?php echo WC()->cart->get_product_subtotal( $_product, 1 ); ?></span>
		</div>

							<?php
							$input_id    = uniqid( 'quantity_' );
							$input_name  = 'quantity';
							$input_value = $cart_item['quantity'];
							$max_value   = $_product->get_max_purchase_quantity();
							$min_value   = $_product->get_min_purchase_quantity();
							$step        = apply_filters( 'woocommerce_quantity_input_step', 1, $_product );
							$pattern     = apply_filters( 'woocommerce_quantity_input_pattern', has_filter( 'woocommerce_stock_amount', 'intval' ) ? '[0-9]*' : '' );

							$input_value = ! isset( $input_value ) ? $min_value : $input_value;

							$input_html = '<input type="number" data-product-key="' . esc_attr( $cart_item_key ) . '" class="wonkasoft-wsc-qty" max="' . esc_attr( 0 < $max_value ? $max_value : '' ) . '" min="' . esc_attr( $min_value ) . '" step="' . esc_attr( $step ) . '" value="' . $input_value . '" pattern="' . esc_attr( $pattern ) . '" name="' . esc_attr( $input_name ) . '" id="' . esc_attr( $input_id ) . '" >';

							if ( $_product->is_sold_individually() ) {
								$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" class="form-control" />', $cart_item_key );
							} else {
								$product_quantity  = '<div class="wonkasoft-wsc-qtybox" data-product-key="' . esc_attr( $cart_item_key ) . '" style="margin-right: 10px;">';
								$product_quantity .= '<span class="wonkasoft-wsc-minus wonkasoft-wsc-chng">-</span>';
								$product_quantity .= $input_html;
								$product_quantity .= '<span class="wonkasoft-wsc-plus wonkasoft-wsc-chng">+</span>';
							}

							echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
							?>
</td>
<td class="product-total">
							<?php
							sprintf(
								apply_filters(
									'woocommerce_cart_item_remove_link',
									printf(
										'<a href="%s" class="remove wonka-badge wonkasoft-wsc-icon-trash" aria-label="%s" data-product_id="%s" data-product_sku="%s" title="%s"></a>',
										esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
										esc_html__( 'Remove this item', 'woocommerce' ),
										esc_attr( $product_id ),
										esc_attr( $_product->get_sku() ),
										( 1 < $cart_item['quantity'] ) ? 'Remove items' : 'Remove item'
									),
									$cart_item_key
								)
							);
							echo '<span class="wonkasoft-wsc-subtotal" data-product-key="' . esc_attr( $cart_item_key ) . '">' . apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ) . '</span>';
							?>
</td>
</tr>
							<?php
						}
					}
					do_action( 'woocommerce_review_order_after_cart_contents' );
					?>
</tbody>
<tfoot>                                                                           
	<tr class="cart-subtotal">
		<th><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
		<td colspan="2"><?php wc_cart_totals_subtotal_html(); ?></td>
	</tr>
	<?php
	if ( empty( WC()->cart->get_coupons() ) ) :
		?>
	<tr class="cart-discount">
		<th colspan="2"></th>
		<td></td>
	</tr>
		<?php
else :
	foreach ( WC()->cart->get_coupons() as $code => $coupon ) :
		?>
	<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
		<th colspan="2"><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
		<td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
	</tr>
		<?php
endforeach;
endif;
?>

	<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
<tr class="fee">
	<th><?php echo esc_html( $fee->name ); ?></th>
	<td colspan="2"><?php wc_cart_totals_fee_html( $fee ); ?></td>
</tr>
<?php endforeach; ?>
	<?php
	$current_method = ( array_key_exists( 0, WC()->session->get( 'chosen_shipping_methods' ) ) ) ? WC()->session->get( 'chosen_shipping_methods' )[0] : '';
	if ( ! $current_method ) :
		?>

	<tr class="shipping-methods">
		<td colspan="2" class="ship-method-cell">

		</td>
		<td colspan="1" class="ship-method-cost-cell">

		</td>
	</tr>
		<?php else : ?>
		<tr class="shipping-methods">
			<?php foreach ( WC()->session->get( 'shipping_for_package_0' )['rates'] as $method_id => $rate ) : ?>
				<?php
				if ( WC()->session->get( 'chosen_shipping_methods' )[0] === $method_id ) :
					$rate_label = $rate->label;
					$rate_cost  = wc_format_decimal( $rate->cost, wc_get_price_decimals() );
					?>
			<td colspan="2" class="ship-method-cell">
					<?php echo esc_html( $rate_label ); ?>
			</td>
			<td colspan="1" class="ship-method-cost-cell">
					<?php
					echo wp_kses(
						sprintf( "<span class='woocommerce-Price-amount amount'>%1\$1s%2\$2s</span>", get_woocommerce_currency_symbol(), $rate_cost ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					);
					?>
			</td>
			<?php endif; ?>
	<?php endforeach; ?>
</tr>
<?php endif; ?>
	<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
		<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
			<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
	<tr class="tax-rate tax-rate-<?php echo esc_attr( $code ); ?>">
		<th><?php echo esc_html( $tax->label ); ?></th>
		<td colspan="2"><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
	</tr>
<?php endforeach; ?>
	<?php else : ?>
	<tr class="tax-total">
		<th><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
		<td colspan="2"><?php wc_cart_totals_taxes_total_html(); ?></td>
	</tr>
	<?php endif; ?>
	<?php endif; ?>

	<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

<tr class="order-total">
	<th><?php _e( 'Total', 'woocommerce' ); ?></th>
	<td colspan="2"><?php wc_cart_totals_order_total_html(); ?></td>
</tr>

	<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

</tfoot>
</table>
</div><!-- .table-responsive -->
</div><!-- .checkout-order-details -->
</div><!-- .row -->
	<?php
}
add_action( 'wonka_checkout_after_checkout_form_custom', 'wonka_checkout_after_checkout_form_custom', 50 );

/**
 * This function filters the coupon html.
 *
 * @param  string $coupon_html          contains the string of the captured html.
 * @param  object $coupon               contains the current coupon.
 * @param  string $discount_amount_html contains the discount amount html.
 * @return string                       returns the filtered html.
 */
function wonkasoft_woocommerce_cart_totals_coupon_html( $coupon_html, $coupon, $discount_amount_html ) {
	if ( ! is_user_logged_in() ) :
		$query_params = array(
			'guestcheckout' => 'true',
			'remove_coupon' => rawurlencode( $coupon->get_code() ),
		);
	else :
		$query_params = array( 'remove_coupon' => rawurlencode( $coupon->get_code() ) );
	endif;

	$coupon_html = '<a href="' . esc_url( add_query_arg( $query_params, wc_get_checkout_url() ) ) . '" class="wonkasoft-woocommerce-remove-coupon" data-coupon="' . esc_attr( $coupon->get_code() ) . '">' . __( ' <i class="fa fa-close"></i> ', 'woocommerce' ) . '</a> ' . $discount_amount_html;

	return $coupon_html;
}
add_filter( 'woocommerce_cart_totals_coupon_html', 'wonkasoft_woocommerce_cart_totals_coupon_html', 10, 3 );

/**
 * This updates the order review fragments.
 *
 * @param  array $fragments contains the fragments.
 * @return array            returns the fragments after being modified.
 */
function wonka_woocommerce_update_order_review_fragments( $fragments ) {
	$current_method = WC()->session->get( 'chosen_shipping_methods' )[0];

	foreach ( WC()->session->get( 'shipping_for_package_0' )['rates'] as $method_id => $rate ) :
		if ( $current_method === $method_id ) :
			$rate_label = $rate->label;
			$rate_cost  = wc_format_decimal( $rate->cost, wc_get_price_decimals() );
		endif;
	endforeach;

	ob_start();
	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
		$_product   = apply_filters( 'checkout_review_woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
		$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

		if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

			$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );

			$attributes = '';

			// Variation.
			$attributes .= $_product->is_type( 'variable' ) || $_product->is_type( 'variation' ) ? wc_get_formatted_variation( $_product ) : '';

			?>
		<tr class="product-start <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>" data-product-key="<?php echo esc_attr( $cart_item_key ); ?>">
			<td rowspan="2" class="product-thumbnail">
				<?php
				$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

				if ( ! $product_permalink ) {
					echo $thumbnail; // PHPCS: XSS ok.
					echo wp_kses(
						apply_filters( 'woocommerce_checkout_cart_item_quantity', sprintf( '<strong class="product-quantity wonka-badge" title="Quantity: %s">%s</strong>', $cart_item['quantity'], $cart_item['quantity'] ), $cart_item, $cart_item_key ),
						array(
							'strong' => array(
								'class' => array(),
								'title' => array(),
							),
						)
					);
				} else {
							printf(
								'<a href="%s">%s</a>',
								esc_url( $product_permalink ),
								$thumbnail
							); // PHPCS: XSS ok.
				}
				?>
</td>
<td colspan="2" class="product-name" data-product-key="<?php echo esc_attr( $cart_item_key ); ?>">
			<?php
			echo wp_kses(
				sprintf( '<a href="%s" class="product-link">%s</a>', esc_url( $product_permalink ), apply_filters( 'cart_and_review_woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ),
				array(
					'a' => array(
						'class' => array(),
						'href'  => array(),
					),
				)
			);
			?>
</td>
</tr>
<tr class="second-row <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>" data-product-key="<?php echo esc_attr( $cart_item_key ); ?>">
	<td class="product-name" data-product-key="<?php echo esc_attr( $cart_item_key ); ?>">
			<?php
			echo $attributes ? wp_kses(
				$attributes,
				array(
					'dl' => array(
						'class' => array(),
					),
					'dt' => array(),
					'dd' => array(),
				)
			) : '';
			?>

		<div class="wonkasoft-wsc-price" data-product-key="<?php echo esc_attr( $cart_item_key ); ?>">
			<span class="price-label"><?php _e( 'Price:', 'side-cart-woocommerce' ); ?></span>
			<span class="price-amount"><?php echo WC()->cart->get_product_subtotal( $_product, 1 ); ?></span>
		</div>

			<?php
			$input_id    = uniqid( 'quantity_' );
			$input_name  = 'quantity';
			$input_value = $cart_item['quantity'];
			$max_value   = $_product->get_max_purchase_quantity();
			$min_value   = $_product->get_min_purchase_quantity();
			$step        = apply_filters( 'woocommerce_quantity_input_step', 1, $_product );
			$pattern     = apply_filters( 'woocommerce_quantity_input_pattern', has_filter( 'woocommerce_stock_amount', 'intval' ) ? '[0-9]*' : '' );

			$input_value = ! isset( $input_value ) ? $min_value : $input_value;

			$input_html = '<input type="number" data-product-key="' . esc_attr( $cart_item_key ) . '" class="wonkasoft-wsc-qty" max="' . esc_attr( 0 < $max_value ? $max_value : '' ) . '" min="' . esc_attr( $min_value ) . '" step="' . esc_attr( $step ) . '" value="' . $input_value . '" pattern="' . esc_attr( $pattern ) . '" name="' . esc_attr( $input_name ) . '" id="' . esc_attr( $input_id ) . '" >';

			if ( $_product->is_sold_individually() ) {
				$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" class="form-control" />', $cart_item_key );
			} else {
				$product_quantity  = '<div class="wonkasoft-wsc-qtybox" data-product-key="' . esc_attr( $cart_item_key ) . '" style="margin-right: 10px;">';
				$product_quantity .= '<span class="wonkasoft-wsc-minus wonkasoft-wsc-chng">-</span>';
				$product_quantity .= $input_html;
				$product_quantity .= '<span class="wonkasoft-wsc-plus wonkasoft-wsc-chng">+</span>';
			}

			echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
			?>
</td>
<td class="product-total">
			<?php
			sprintf(
				apply_filters(
					'woocommerce_cart_item_remove_link',
					printf(
						'<a href="%s" class="remove wonka-badge wonkasoft-wsc-icon-trash" aria-label="%s" data-product_id="%s" data-product_sku="%s" title="%s"></a>',
						esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
						esc_html__( 'Remove this item', 'woocommerce' ),
						esc_attr( $product_id ),
						esc_attr( $_product->get_sku() ),
						( 1 < $cart_item['quantity'] ) ? 'Remove items' : 'Remove item'
					),
					$cart_item_key
				)
			);
			echo '<span class="wonkasoft-wsc-subtotal" data-product-key="' . esc_attr( $cart_item_key ) . '">' . apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ) . '</span>';
			?>
</td>
</tr>
			<?php
		}
endforeach;
	$fragments['tbody.products-area'] = '<tbody class="products-area">' . ob_get_contents() . ob_end_clean() . '</tbody>';

	if ( ! empty( $rate_label ) ) :
		$fragments['td.ship-method-cell'] = '<td colspan="2" class="ship-method-cell">' . $rate_label . '</td>';
endif;

	if ( ! empty( $rate_cost ) ) :
		$fragments['td.ship-method-cost-cell'] = '<td colspan="1" class="ship-method-cost-cell">' . sprintf( __( "<span class='woocommerce-Price-amount amount'>%1\$1s%2\$2s</span>", 'aperabags' ), get_woocommerce_currency_symbol(), $rate_cost ) . '</td>';
endif;

	$fragments['tr.cart-subtotal'] = '<tr class="cart-subtotal"><th>Subtotal</th><td colspan="2"><span class="woocommerce-Price-amount amount">' . wc_price( WC()->cart->get_subtotal() ) . '</span></td></tr>';

	if ( empty( WC()->cart->get_coupons() ) ) :
		$fragments['tr.cart-discount'] = '<tr class="cart-discount"><th colspan="2"></th><td></td></tr>';
else :
	foreach ( WC()->cart->get_coupons() as $code => $coupon ) :
		ob_start();
		$current_coupon_class          = 'coupon-' . esc_attr( sanitize_title( $code ) );
		$fragments['tr.cart-discount'] = '<tr class="cart-discount ' . $current_coupon_class . '"><th colspan="2">' . sprintf( 'Coupon: %s', $coupon->code ) . '</th><td>' . wc_cart_totals_coupon_html( $coupon ) . ob_get_contents() . '</td></tr>' . ob_end_clean();
endforeach;
endif;

if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) :
	foreach ( WC()->cart->get_tax_totals() as $code => $tax ) :
		$current_tax_class        = 'tax-rate-' . esc_attr( $code );
		$fragments['tr.tax-rate'] = '<tr class="tax-rate ' . $current_tax_class . '"><th>' . esc_html( $tax->label ) . '</th><td colspan="2">' . wp_kses_post( $tax->formatted_amount ) . '</td></tr>';
	endforeach;
	else :
		$fragments['tr.tax-total'] = '<tr class="tax-total"><th>' . esc_html( WC()->countries->tax_or_vat() ) . '</th><td colspan="2">' . wc_cart_totals_taxes_total_html() . '</td></tr>';
endif;

	$fragments['tr.order-total'] = '<tr class="order-total"><th>Total</th><td colspan="2"><strong><span class="woocommerce-Price-amount amount">' . WC()->cart->get_total() . '</span></strong></td></tr>';

	$fragments['span.aperacash-balance'] = '<span class="aperacash-balance">' . do_shortcode( '[balanceprice]' ) . '</span>';

	return $fragments;
}
add_filter( 'woocommerce_update_order_review_fragments', 'wonka_woocommerce_update_order_review_fragments', 10 );

/**
 * This function adds the coupon form to the checkout review section.
 */
function wonka_woocommerce_review_order_after_order_total() {
	if ( is_user_logged_in() ) :
		?>
		<tr class="aperacash-display">
			<td colspan="3">
				<div class="aperacash-input-group input-checkbox">
					<label for="aperacash-apply"> 
						<input type="checkbox" class="wonka-checkbox form-checkbox" name="aperacash-apply" id="aperacash-apply" 
						<?php
						if ( empty( WC()->cart->get_coupons() ) ) :
							if ( 'checked' === get_option( 'apply_all_aperacash', false ) ) :
								update_option( 'apply_all_aperacash', false );
								$apply_checked = get_option( 'apply_all_aperacash', false );
							else :
								$apply_checked = get_option( 'apply_all_aperacash', false );
							endif;
							else :
								foreach ( WC()->cart->get_coupons() as $code => $coupon ) :
									preg_match( '/aperacash_|sumo_|auto_redeem_|auto_aperacash_/', strtolower( $code ), $matches, PREG_UNMATCHED_AS_NULL );
									if ( ! empty( $matches ) ) :
										if ( 'checked' !== get_option( 'apply_all_aperacash', false ) ) :
											update_option( 'apply_all_aperacash', 'checked' );
										endif;
										$apply_checked = get_option( 'apply_all_aperacash', false );
									endif;
									endforeach;
						endif;
							echo wp_kses_post( $apply_checked );
							?>
						/>
						You have <span class="aperacash-balance"><?php echo do_shortcode( '[balanceprice]' ); ?></span> AperaCash, would you like to apply to this order.</label>
				</div>
			</td>
		</tr>
		<?php
	endif;
	if ( wc_coupons_enabled() ) :
		$query_params = ( ! is_user_logged_in() ) ? array(
			'guestcheckout' => 'true',
		) : '';
		?>
		<tr class="cart-promo">
			<th colspan="3">
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					<div class="panel panel-default activate-panel" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						<div class="panel-heading" role="tab" id="headingOne">
							<span class="panel-title">
								Add Promo Code (Optional)
							</span>
						</div>
					</div>
				</div>
				<div id="collapseOne" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingOne">
					<div class="panel-body">
						<form method="post" class="coupon form-group form-inline" action="<?php echo esc_url( add_query_arg( $query_params, wc_get_checkout_url() ) ); ?>">
							<label for="coupon_code" class="sr-only"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text form-control" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <button type="submit" class="button wonka-btn" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?></button>
							<?php do_action( 'woocommerce_cart_coupon' ); ?>
						</form>
					</div>
				</div>
			</th>
		</tr>
		<?php
	endif;
}
add_action( 'woocommerce_review_order_after_order_total', 'wonka_woocommerce_review_order_after_order_total', 50 );

/**
 * Ajax request for AperaCash apply on checkout.
 *
 * @param  [type] $params [description]
 * @return [type]         [description]
 */
function apply_all_aperacash() {

	$nonce = ( isset( $_REQUEST['security'] ) ) ? wp_kses_post( wp_unslash( $_REQUEST['security'] ) ) : false;
	wp_verify_nonce( $nonce, 'ws-request-nonce' ) || die( 'nonce failed' );

	$data                 = array();
	$add_discount         = ( isset( $_REQUEST['checkbox'] ) ) ? wp_kses_post( wp_unslash( $_REQUEST['checkbox'] ) ) : null;
	$data['add_discount'] = $add_discount;

	if ( $add_discount ) :
		WC()->session->set( 'auto_redeemcoupon', 'yes' );
		update_option( 'rs_enable_disable_auto_redeem_points', 'yes' );
		update_option( 'rs_enable_disable_auto_redeem_checkout', 'yes' );

		if ( ! is_user_logged_in() ) {
			return;
		}

		if ( empty( WC()->cart->get_cart_contents_count() ) ) {
			WC()->session->set( 'auto_redeemcoupon', 'yes' );
			foreach ( WC()->cart->applied_coupons as $code => $coupon ) {
				WC()->cart->remove_coupon( $code );
			}

			return;
		}

		$UserId     = get_current_user_id();
		$PointsData = new RS_Points_Data( $UserId );
		$Points     = $PointsData->total_available_points();

		if ( empty( $Points ) ) {
			return;
		}

		if ( $Points < get_option( 'rs_first_time_minimum_user_points' ) ) {
			return;
		}

		if ( $Points < get_option( 'rs_minimum_user_points_to_redeem' ) ) {
			return;
		}

		if ( check_if_pointprice_product_exist_in_cart() ) {
			return;
		}

		if ( get_option( 'rs_enable_disable_auto_redeem_points' ) != 'yes' ) {
			return;
		}

		$CartSubtotal = srp_cart_subtotal();

		$MinCartTotal = get_option( 'rs_minimum_cart_total_points' );
		$MaxCartTotal = get_option( 'rs_maximum_cart_total_points' );

		$capture = RSRedeemingFrontend::auto_redeeming_in_checkout( $UserId, $Points, $CartSubtotal, $MaxCartTotal, $MinCartTotal );

		update_option( 'rs_enable_disable_auto_redeem_points', 'no' );
		update_option( 'rs_enable_disable_auto_redeem_checkout', 'no' );
		WC()->session->set( 'auto_redeemcoupon', 'no' );
	endif;

	if ( 'false' === $add_discount ) :
		foreach ( WC()->cart->get_coupons() as $code => $coupon ) :
			preg_match( '/aperacash_|sumo_|auto_redeem_|auto_aperacash_/', strtolower( $code ), $matches, PREG_UNMATCHED_AS_NULL );
			if ( ! empty( $matches ) ) :
				if ( 'checked' === get_option( 'apply_all_aperacash', false ) ) :
					update_option( 'apply_all_aperacash', false );
				endif;
				WC()->cart->remove_coupon( $code );
				$data['coupon_removed'] = $code;
			endif;
		endforeach;
	endif;

	wp_send_json_success( $data, null );
}
add_action( 'wp_ajax_apply_all_aperacash', 'apply_all_aperacash' );

/**
 * This function filters the coupon display area on the order review of checkout page.
 *
 * @param  string  $captured contains the caputed string from the filter.
 * @param  object  $coupon   contains the current coupon.
 * @param  boolean $echo     contains echo option.
 * @return string            contains filtered label if not echo.
 */
function wonkasoft_woocommerce_cart_totals_coupon_label( $captured, $coupon, $echo = true ) {
	if ( is_string( $coupon ) ) {
		$coupon = new WC_Coupon( $coupon );
	}

	/* translators: %s: coupon code */
	$label = $captured;

	if ( $echo ) {
		echo $label; // WPCS: XSS ok.
	} else {
		return $label;
	}
}
if ( class_exists( 'RSRedeemingFrontend' ) ) :
	remove_filter( 'woocommerce_cart_totals_coupon_label', array( 'RSRedeemingFrontend', 'change_coupon_label' ), 1, 2 );
endif;

if ( class_exists( $GLOBALS['wjecf_extended_coupon_features'] ) ) :
	remove_filter( 'woocommerce_cart_totals_coupon_label', array( $GLOBALS['wjecf_extended_coupon_features']->get_plugins()['autocoupon'], 'woocommerce_cart_totals_coupon_label' ), 10, 2 );
endif;
add_filter( 'woocommerce_cart_totals_coupon_label', 'wonkasoft_woocommerce_cart_totals_coupon_label', 10, 3 );

/**
 * This adds custom html markup to the checkout page.
 *
 * @param  array $checkout contains the checkout parts.
 */
function wonka_woocommerce_before_custom_checkout( $checkout ) {
	$output = '';
	ob_start();
	$output .= '<div class="row wonka-row checkout-breadcrumb">';
	$output .= '<div class="col-12">';
	$output .= '<ul class="nav nav-fill shipping-address" id="wonka-checkout-nav-steps" role="tablist">';
	$output .= '<li class="nav-item">';
	$output .= '<a class="nav-link active" id="wonka_customer_information_tab" data-toggle="tab" data-target="#wonka_customer_information" role="tab" data-secondary="#wonka_customer_information_top" data-btns="#wonka_customer_information_buttons">';
	$output .= _x( 'Shipping', 'aperabags' );
	$output .= '</a></li>';
	$output .= '<li class="nav-item">';
	$output .= '<a class="nav-link disabled" id="wonka_shipping_method_tab" data-toggle="tab" data-target="#wonka_shipping_method" role="tab" data-secondary="#wonka_shipping_method_top" data-btns="#wonka_shipping_method_buttons">';
	$output .= _x( 'Delivery Options', 'aperabags' );
	$output .= '</a></li>';
	$output .= '<li class="nav-item">';
	$output .= '<a class="nav-link disabled" id="wonka_payment_method_tab" data-toggle="tab" data-target="#wonka_payment_method" role="tab" data-secondary="#wonka_payment_method_top" data-btns="#wonka_payment_method_buttons">';
	$output .= _x( 'Payment Method', 'aperabags' );
	$output .= '</a></li>';
	$output .= '</ul><!-- #wonka-checkout-nav-steps -->';
	$output .= '</div>';
	$output .= '</div><!-- .wonka-row -->';

	$output .= '<div class="tab-content" id="wonka-checkout-steps2">';
	$output .= '<div class="tab-pane fade col show active" id="wonka_customer_information_top" role="tabpanel">';
	$output .= '<div class="row wonka-row-express-checkout-btns">';
	$output .= '<div class="col col-12">';
	$output .= '<div class="express-btns-text-wrap">';
	$output .= '<span class="express-btns-text">';
	$output .= _x( 'Express checkout', 'aperabags' );
	$output .= '</span><!-- .express-btns-text -->';
	$output .= '</div><!-- .express-btns-text-wrap -->';
	$output .= '<div class="express-checkout-btns">';
	do_action( 'wonka_checkout_express_btns' );
	$output .= ob_get_clean();
	ob_start();
	$output .= '</div><!-- .express-checkout-btns -->';
	$output .= '</div><!-- .col-12 -->';
	$output .= '<div class="col col-12">';
	$output .= '<div class="row below-express-checkout-btns no-gutters"><div class="col-12 col-md"><hr /></div><!-- .col-12 --><div class="col-12 col-md">';
	$output .= '<span class="continue-past-btns-text">';
	$output .= _x( 'Or continue below to pay with a credit card', 'apera-bags' );
	$output .= '</span></div><!-- .col-12 -->';
	$output .= '<div class="col-12 col-md"><hr /></div><!-- .col-12 --></div><!-- .below-express-checkout-btns -->';
	$output .= '</div><!-- .col-12 -->';
	$output .= '</div><!-- .wonka-row-express-checkout-btns -->';

	$output .= do_action( 'wonka_checkout_login_form' );

	$output .= ob_get_clean();
	echo wp_kses(
		$output,
		array(
			'div'   => array(
				'class' => array(),
				'id'    => array(),
				'role'  => array(),
			),
			'ul'    => array(
				'class' => array(),
				'id'    => array(),
				'role'  => array(),
			),
			'li'    => array(
				'class' => array(),
			),
			'table' => array(
				'class' => array(),
			),
			'tbody' => array(
				'class' => array(),
			),
			'tr'    => array(
				'class' => array(),
			),
			'td'    => array(
				'class'   => array(),
				'colspan' => array(),
			),
			'span'  => array(
				'class' => array(),
			),
			'a'     => array(
				'class'          => array(),
				'href'           => array(),
				'id'             => array(),
				'role'           => array(),
				'data-toggle'    => array(),
				'data-target'    => array(),
				'data-secondary' => array(),
				'data-btns'      => array(),
			),
			'hr'    => array(),
		)
	);
}
add_action( 'wonka_checkout_before_checkout_form_custom', 'wonka_woocommerce_before_custom_checkout', 10, 1 );

/**
 * This adds custom html markup after the login form.
 */
function wonka_checkout_after_login_form() {
	$output = '';

	$output .= '</div><!-- .wonka_customer_information_top -->';
	$output .= '<div class="tab-pane fade" id="wonka_shipping_method_top" role="tabpanel">';
	$output .= '<div class="wonka-row">';
	$output .= '<div class="card">';
	$output .= '<div class="table-responsive">';
	$output .= '<table class="wonka-customer-information-table table table-borderless">';
	$output .= '<tbody class="wonka-customer-information-table-body">';
	$output .= '<tr class="contact-email-row">';
	$output .= '<td class="contact-email-text">';
	$output .= 'Contact';
	$output .= '</td>';
	$output .= '<td colspan="3" class="contact-email-cell">';
	$output .= '</td>';
	$output .= '<td class="contact-email-change">';
	$output .= '<a href="javascript:void(0);" class="contact-email-change-link">Change</a>';
	$output .= '</td>';
	$output .= '</tr>';
	$output .= '<tr>';
	$output .= '<td colspan="5" class="hr-spacer">';
	$output .= '<hr />';
	$output .= '</td>';
	$output .= '</tr>';
	$output .= '<tr class="ship-to-row">';
	$output .= '<td class="ship-to-text">';
	$output .= 'Shipping To';
	$output .= '</td>';
	$output .= '<td colspan="3" class="ship-to-address-cell">';
	$output .= '</td>';
	$output .= '<td class="ship-to-address-change">';
	$output .= '<a href="javascript:void(0);" class="ship-to-address-change-link">Change</a>';
	$output .= '</td>';
	$output .= '</tr>';
	$output .= '</tbody><!-- tbody -->';
	$output .= '</table><!-- .wonka-customer-information-table -->';
	$output .= '</div><!-- .table-responsive -->';
	$output .= '</div><!-- .card -->';
	$output .= '</div><!-- .wonka-row -->';
	$output .= '</div><!-- #wonka_shipping_method_top -->';

	$output .= '<div class="tab-pane fade" id="wonka_payment_method_top" role="tabpanel">';
	$output .= '<div class="wonka-row">';
	$output .= '<div class="card">';
	$output .= '<div class="table-responsive">';
	$output .= '<table class="wonka-customer-information-table table table-borderless">';
	$output .= '<tbody class="wonka-customer-information-table-body">';
	$output .= '<tr class="contact-email-row">';
	$output .= '<td class="contact-email-text">';
	$output .= 'Contact';
	$output .= '</td>';
	$output .= '<td colspan="3" class="contact-email-cell">';
	$output .= '</td>';
	$output .= '<td class="contact-email-change">';
	$output .= '<a href="javascript:void(0);" class="contact-email-change-link">Change</a>';
	$output .= '</td>';
	$output .= '</tr>';
	$output .= '<tr>';
	$output .= '<td colspan="5" class="hr-spacer">';
	$output .= '<hr />';
	$output .= '</td>';
	$output .= '</tr>';
	$output .= '<tr class="ship-to-row">';
	$output .= '<td class="ship-to-text">';
	$output .= 'Ship to';
	$output .= '</td>';
	$output .= '<td colspan="3" class="ship-to-address-cell">';
	$output .= '</td>';
	$output .= '<td class="ship-to-address-change">';
	$output .= '<a href="javascript:void(0);" class="ship-to-address-change-link">Change</a>';
	$output .= '</td>';
	$output .= '</tr>';
	$output .= '<tr>';
	$output .= '<td colspan="5" class="hr-spacer">';
	$output .= '<hr />';
	$output .= '</td>';
	$output .= '</tr>';
	$output .= '<tr class="ship-method-row">';
	$output .= '<td class="ship-method-text">';
	$output .= 'Method';
	$output .= '</td>';
	$output .= '<td colspan="2" class="ship-method-cell">';
	$output .= '</td>';
	$output .= '<td colspan="1" class="ship-method-cost-cell">';
	$output .= '</td>';
	$output .= '<td class="ship-method-change">';
	$output .= '<a href="javascript:void(0);" class="ship-method-change-link">Change</a>';
	$output .= '</td>';
	$output .= '</tr>';
	$output .= '</tbody><!-- tbody -->';
	$output .= '</table><!-- .wonka-customer-information-table -->';
	$output .= '</div><!-- .table-responsive -->';
	$output .= '</div><!-- .card -->';
	$output .= '</div><!-- .wonka-row -->';
	$output .= '</div><!-- #wonka_payment_method_top -->';

	$output .= '</div><!-- #wonka-checkout-steps2 -->';

	echo wp_kses(
		$output,
		array(
			'div'   => array(
				'class' => array(),
				'id'    => array(),
				'role'  => array(),
			),
			'table' => array(
				'class' => array(),
			),
			'tbody' => array(
				'class' => array(),
			),
			'tr'    => array(
				'class' => array(),
			),
			'td'    => array(
				'class'   => array(),
				'colspan' => array(),
			),
			'a'     => array(
				'class' => array(),
				'href'  => array(),
			),
			'hr'    => array(),
		)
	);
}

add_action( 'wonka_checkout_login_form', 'wonka_checkout_after_login_form', 20 );

/**
 * This adds custom html markup before the customer details.
 */
function wonka_checkout_before_customer_details() {
	$output = '';

	$output .= '<div class="tab-content" id="wonka-checkout-steps">';
	$output .= '<div class="tab-pane fade show active" id="wonka_customer_information" role="tabpanel">';

	echo wp_kses(
		$output,
		array(
			'div' => array(
				'class' => array(),
				'id'    => array(),
				'role'  => array(),
			),
		)
	);
}

add_action( 'woocommerce_checkout_before_customer_details', 'wonka_checkout_before_customer_details' );

/**
 * This add custom html markup after customer details.
 */
function wonka_checkout_after_customer_details() {
	$output = '';

	$output .= '</div><!-- #wonka_customer_information -->';

	echo wp_kses(
		$output,
		array(
			'div' => array(
				'class' => array(),
				'role'  => array(),
				'id'    => array(),
			),
		)
	);
}
add_action( 'woocommerce_checkout_after_customer_details', 'wonka_checkout_after_customer_details' );

/**
 * This add custom html markup before order review.
 */
function wonka_woocommerce_checkout_before_order_review() {
	$output = '';

	$output .= '<div class="tab-pane fade" id="wonka_shipping_method" role="tabpanel">';

	echo wp_kses(
		$output,
		array(
			'div' => array(
				'class' => array(),
				'role'  => array(),
				'id'    => array(),
			),
		)
	);
}
add_action( 'woocommerce_checkout_before_order_review', 'wonka_woocommerce_checkout_before_order_review' );

/**
 * This add custom html markup after customer details.
 */
function wonka_woocommerce_review_order_before_payment() {
	$output = '';

	$output .= '</div><!-- #wonka_shipping_method -->';
	$output .= '<div class="tab-pane fade" id="wonka_payment_method" role="tabpanel">';

	echo wp_kses(
		$output,
		array(
			'div' => array(
				'class' => array(),
				'role'  => array(),
				'id'    => array(),
			),
		)
	);
}
add_action( 'woocommerce_review_order_before_payment', 'wonka_woocommerce_review_order_before_payment' );

/**
 * This add custom html markup to review order before payment.
 */
function wonka_woocommerce_review_order_before_payment2() {
	do_action( 'woocommerce_checkout_billing' );
}
add_action( 'wonka_custom_billing_addition', 'wonka_woocommerce_review_order_before_payment2' );

/**
 * This add custom html markup to review order after payment.
 */
function wonka_woocommerce_review_order_after_payment() {
	$output = '';

	$output .= '</div><!-- #payment_method -->';
	$output .= '</div><!-- #wonka-checkout-steps -->';

	echo wp_kses(
		$output,
		array(
			'div' => array(
				'class' => array(),
				'role'  => array(),
				'id'    => array(),
			),
		)
	);
}
add_action( 'woocommerce_review_order_after_payment', 'wonka_woocommerce_review_order_after_payment' );

/**
 * Remove Sku info only for users. Sku will still show for admins
 *
 * @since  1.0.0
 *
 * @param bool $enabled  Contains true.
 * @return bool  returns true less set to false.
 */
function ws_remove_product_page_skus( $enabled ) {
	if ( ! is_admin() && is_product() ) {
		return false;
	}

	return $enabled;
}
add_filter( 'wc_product_sku_enabled', 'ws_remove_product_page_skus' );

/**
* Remove Meta information on single product page
*
* @since  1.0.0
*/
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

/**
 * This is for making the flexslider of woocommerce to slide vertical instead of horizontal
 *
 * @param  array $options Contains options that are being passed to the slider.
 * @return [type]          [description]
 */
function wonka_product_carousel_options( $options ) {
	$options['animation']      = 'slide';
	$options['animationSpeed'] = 1500;
	$options['useCSS']         = true;
	$options['easing']         = 'swing';
	$options['direction']      = 'vertical';
	return $options;
}
add_filter( 'woocommerce_single_product_carousel_options', 'wonka_product_carousel_options', 10 );

/**
 * This adds custom meta fields to the product edit interface
 *
 * @param  int $post_id contains the post id for current product.
 */
function wonka_product_meta_add( $post_id ) {

	$product_statement = ( get_metadata( 'product', $post_id, 'product_statement' ) ) ? get_metadata( 'product', $post_id, 'product_statement', true ) : '';

	$product_specs = ( get_metadata( 'product', $post_id, 'product_specs' ) ) ? get_metadata( 'product', $post_id, 'product_specs', true ) : '';

	$key_features = ( get_metadata( 'product', $post_id, 'key_features' ) ) ? get_metadata( 'product', $post_id, 'key_features', true ) : '';

	$_enable_wonka_express_button = isset( $_POST['_enable_wonka_express_button'] ) ? 'yes' : 'no';
	update_post_meta( $post_id, '_enable_wonka_express_button', $_enable_wonka_express_button );

	if ( ! add_post_meta( $post_id, 'product_statement', '', true ) ) {
		update_metadata( 'product', $post_id, 'product_statement', $product_statement );
	}

	if ( ! add_post_meta( $post_id, 'product_specs', '', true ) ) {
		update_metadata( 'product', $post_id, 'product_specs', $product_specs );
	}

	if ( ! add_post_meta( $post_id, 'key_features', '', true ) ) {
		update_metadata( 'product', $post_id, 'key_features', $key_features );
	}
}
add_action( 'woocommerce_process_product_meta', 'wonka_product_meta_add', 11, 1 );

/**
 * This adds a custom field to enable an express checkout btn.
 *
 * @param  obj $product_type Contains the product type.
 * @return obj               Returns the Product type object.
 */
function wonka_woo_add_custom_general_fields( $product_type ) {
	if ( isset( $product_type ) && ! empty( $product_type ) ) {
		$product_type['enable_wonka_express_button'] = array(
			'id'            => '_enable_wonka_express_button',
			'wrapper_class' => '',
			'label'         => __( 'Enable Wonka Express Checkout Button', 'apera-bags' ),
			'description'   => __( 'Adds the Wonka Express Checkout button to the product page allowing buyers to go directly to the checkout directly from the product page.', 'apera-bags' ),
			'default'       => 'yes',
		);
		return $product_type;
	} else {
		return $product_type;
	}
}
add_action( 'product_type_options', 'wonka_woo_add_custom_general_fields' );

/**
 * This adds the key features | product specs | reviews
 *
 * @since 1.0.0
 *
 * @param  string $post_excerpt [<description>]
 */
function wonka_filter_woocommerce_short_description( $post_excerpt ) {
	if ( ' ' == $post_excerpt || null == $post_excerpt ) :
		return $post_excerpt;
	else :
		if ( is_shop() ) :
			return $post_excerpt;
		else :
			global $product;
			$disclosure = '';

			if ( ! empty( $product ) ) :
				foreach ( $product->get_category_ids() as $value ) :

					if ( 'Outlet' === get_the_category_by_ID( $value ) ) :
						$disclosure = '<p class="final-sale-disclosure">*All Outlet purchases are FINAL SALE and can not be combined with any other sales or coupons at purchase. No returns or refunds.</p>';
					endif;
				endforeach;
			endif;

			ob_start();

			$compare_link_set = '';
			if ( class_exists( 'YITH_Woocompare_Frontend' ) ) :
				$YITH_Woocompare_Frontend_compare_link = new YITH_Woocompare_Frontend();
				$compare_link_set                      = ' | ' . $YITH_Woocompare_Frontend_compare_link->add_compare_link();
			endif;
			$add_links = '<a id="key-features-link" href="javascript:void(0);">Key Features</a> | <a id="product-specs-link" href="javascript:void(0);">Product Specs</a> | <a id="review-link" href="javascript:void(0);">Reviews</a>' . $compare_link_set;

			$post_excerpt = $post_excerpt . $disclosure . $add_links . ob_get_clean();
			return $post_excerpt;
		endif;

		return $post_excerpt;
	endif;
};
add_filter( 'woocommerce_short_description', 'wonka_filter_woocommerce_short_description', 10, 1 );

/**
 * This adds a custom express checkout button to the product page
 */
function wonka_express_checkout_add() {
	global $post;
	global $product;
	$variation_id = $product->get_variation_id();
	$post_id      = get_the_ID();
	if ( get_post_meta( $post_id, '_enable_wonka_express_button', true ) === 'yes' ) :
		?>
		<div class="wonka-express-checkout-wrap">
			<a href="<?php _e( get_site_url() . '/checkout/?add-to-cart=' ); ?>" id="express_checkout_btn" class="wonka-btn">Express Checkout</a>
		</div>
		<?php
	endif;
}

add_action( 'woocommerce_after_add_to_cart_button', 'wonka_express_checkout_add', 10 );

/**
 * This is for adding the opening tags for a wrap around the reviews meta data
 *
 * @param  object $comment contains review data.
 */
function wonka_before_comment_meta_add( $comment ) {
	?>
	<div class="wonka-rating-and-meta-wrap col-12 col-md-4">
		<?php
}

	add_action( 'woocommerce_review_before_comment_meta', 'wonka_before_comment_meta_add', 5 );

/**
 * This adds custom html markup before the comment text.
 *
 * @param  array $comment contains the comment data.
 */
function wonka_before_comment_text_add( $comment ) {
	?>
</div><!-- .wonka-rating-and-meta-wrap -->
<div class="wonka-review-text-wrap col-12 col-md-7">
	<?php
}
add_action( 'woocommerce_review_before_comment_text', 'wonka_before_comment_text_add', 5 );

/**
 * This adds custom html markup before the comment text.
 *
 * @param  array $comment contains the comment data.
 */
function wonka_after_comment_text_add( $comment ) {
	?>
</div><!-- .wonka-review-text-wrap -->
	<?php
}
add_action( 'woocommerce_review_after_comment_text', 'wonka_after_comment_text_add', 5 );

/*
====================================================================================
=            This is filtering the first thumbnail on single product page            =
====================================================================================*/
/**
 * Adding the active class to the first thumbnail
 *
 * @param  html $data html of the first thumbnail on the single product page
 * @return [type]       [description]
 */
function wonka_single_product_image_thumbnail_html_custom( $data, $attachment_id ) {
	global $product, $post;
	$post_thumbnail_id = $attachment_id;
	$wonka_post_id     = get_the_ID();

	$output = '';
	ob_start();
	if ( $post_thumbnail_id === $product->get_image_id() ) :
		$output .= '<a href="#scroll_image_' . esc_attr( $post_thumbnail_id ) . '_2" class="nav-link active woocommerce-product-gallery__image">';
		$output .= '<img class="wp-post-image" src="' . str_replace( array( 'http:', 'https:' ), '', esc_attr( wp_get_attachment_image_src( $post_thumbnail_id, 'medium', false )[0] ) ) . '" alt="' . esc_attr( get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) ) . '" title="' . esc_attr( get_the_title( $post_thumbnail_id ) ) . '" data-caption="' . esc_attr( wp_get_attachment_caption( $wonka_post_id ) ) . '" data-variant-color="' . esc_attr( get_post_meta( $post_thumbnail_id, 'ws_variant_name', true ) ) . '" data-src="' . esc_attr( wp_get_attachment_image_src( $post_thumbnail_id, 'medium' )[0] ) . '" data-large_image="' . wp_get_attachment_url( $post_thumbnail_id ) . '" srcset="' . str_replace( array( 'http:', 'https:' ), '', esc_attr( wp_get_attachment_image_srcset( $post_thumbnail_id, 'medium', null ) ) ) . '" />';
		$output .= '</a>';
	else :
		$output .= '<a href="#scroll_image_' . esc_attr( $post_thumbnail_id ) . '" class="nav-link woocommerce-product-gallery__image">';
		$output .= '<img class="wp-post-image" src="' . str_replace( array( 'http:', 'https:' ), '', esc_attr( wp_get_attachment_image_src( $post_thumbnail_id, 'medium', false )[0] ) ) . '" alt="' . esc_attr( get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) ) . '" title="' . esc_attr( get_the_title( $post_thumbnail_id ) ) . '" data-caption="' . esc_attr( wp_get_attachment_caption( $wonka_post_id ) ) . '" data-variant-color="' . esc_attr( get_post_meta( $post_thumbnail_id, 'ws_variant_name', true ) ) . '" data-src="' . esc_attr( wp_get_attachment_image_src( $post_thumbnail_id, 'medium' )[0] ) . '" data-large_image="' . wp_get_attachment_url( $post_thumbnail_id ) . '" srcset="' . str_replace( array( 'http:', 'https:' ), '', esc_attr( wp_get_attachment_image_srcset( $post_thumbnail_id, 'medium', null ) ) ) . '" />';
		$output .= '</a>';
	endif;
	$output .= ob_get_clean();
	return $output;
}
add_filter( 'wonka_single_product_image_thumbnail_html', 'wonka_single_product_image_thumbnail_html_custom', 10, 2 );

/**
 * This is the single product image parse.
 *
 * @param  html   $data          current html passed in.
 * @param  number $attachment_id the attachment ID
 * @return html                [description]
 */
function wonka_single_product_image_scroll_html_custom( $data, $attachment_id ) {
	global $product, $post;
	$post_thumbnail_id = $attachment_id;
	$wonka_post_id     = get_the_ID();

	$output = '';
	ob_start();
	$output .= '<div id="scroll_image_' . esc_attr( $post_thumbnail_id ) . '" class="woocommerce-product-gallery__image" data-variant-check="true" data-variant-color="' . esc_attr( get_post_meta( $post_thumbnail_id, 'ws_variant_name', true ) ) . '">';
	$output .= '<a href="#scroll_image_' . esc_attr( $post_thumbnail_id ) . '">';
	$output .= '<img class="wp-post-image" src="' . str_replace( array( 'http:', 'https:' ), '', esc_url( wp_get_attachment_image_src( $post_thumbnail_id, 'custom_products_size', false )[0] ) ) . '" alt="' . esc_attr( get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) ) . '" title="' . esc_attr( get_the_title( $post_thumbnail_id ) ) . '" data-caption="' . esc_attr( wp_get_attachment_caption( $wonka_post_id ) ) . '" data-variant-color="' . esc_attr( get_post_meta( $post_thumbnail_id, 'ws_variant_name', true ) ) . '" data-src="' . esc_attr( wp_get_attachment_image_src( $post_thumbnail_id, 'custom_products_size' ) ) . '" data-large_image="' . esc_attr( wp_get_attachment_url( $post_thumbnail_id ) ) . '" srcset="' . str_replace( array( 'http:', 'https:' ), '', esc_attr( wp_get_attachment_image_srcset( $post_thumbnail_id, 'custom_products_size', null ) ) ) . '" />';
	$output .= '</a></div>';
	$output .= ob_get_clean();

	return $output;
}
add_filter( 'wonka_single_product_scroll_image_html', 'wonka_single_product_image_scroll_html_custom', 10, 2 );
/*=====  End of This is filtering the first thumbnail on single product page  ======*/

function wonka_checkout_fields_in_label_error( $field, $key, $args, $value ) {
	if ( strpos( $field, '</label>' ) !== false && $args['required'] ) {
		$error  = '<span class="error" style="display:none">';
		$error .= sprintf( __( '%s is a required field.', 'woocommerce' ), $args['label'] );
		$error .= '</span>';
		$field  = substr_replace( $field, $error, strpos( $field, '</p>' ), 0 );
	}

	return $field;
}

add_filter( 'woocommerce_form_field', 'wonka_checkout_fields_in_label_error', 10, 4 );

function ws_shipping_to_billing() {
	// This is a security check, it validates a random number that is generated on the request.
	if ( ! check_ajax_referer( 'ws-request-nonce', 'security' ) ) {
		return wp_send_json_error( 'Invalid Nonce' );
	}

	if ( isset( $_GET['opt_set'] ) ) :
		update_option( 'woocommerce_ship_to_destination', $_GET['opt_set'], false );

		return wp_send_json_success( $_GET['opt_set'] );
	endif;

	return false;
}
add_action( 'wp_ajax_shipping_to_billing', 'ws_shipping_to_billing' );
add_action( 'wp_ajax_nopriv_shipping_to_billing', 'ws_shipping_to_billing' );

/**
 * Filter the except length to 20 words.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
function wonka_custom_excerpt_length( $text ) {
	$length    = 20;
	$str_array = explode( ' ', $text );
	$output    = '';
	if ( is_search() ) :
		for ( $i = 0; $i < $length; $i++ ) :
			if ( $i == ( $length - 1 ) ) :
				$output .= $str_array[ $i ] . '...';
			else :
				$output .= $str_array[ $i ] . ' ';
			endif;
		endfor;

		_e( $output, 'aperabags' );
		else :
			return $text;
	endif;
}
add_filter( 'get_the_excerpt', 'wonka_custom_excerpt_length', 999 );

/**
 * This sets up a way to search via ajax.
 */
function ws_ajax_search() {
	// This is a security check, it validates a random number that is generated on the request.
	if ( ! check_ajax_referer( 'ws-request-nonce', 'security' ) ) {
		return wp_send_json_error( 'Invalid Nonce' );
	}
	$results = new WP_Query(
		array(
			'post_type'      => array( 'product' ),
			'post_status'    => 'publish',
			'nopaging'       => true,
			'posts_per_page' => 100,
		)
	);
	$items   = array();
	if ( ! empty( $results->posts ) ) {
		foreach ( $results->posts as $result ) {
			$items[] = $result->post_title;
		}
	}
	wp_send_json_success( $items );
}

add_action( 'wp_ajax_search_site', 'ws_ajax_search' );
add_action( 'wp_ajax_nopriv_search_site', 'ws_ajax_search' );

/**
 * Define the woocommerce_product_review_list_args callback
 *
 * @param  object $comment contains current comment.
 */
function filter_woocommerce_product_review_list_args( $comment ) {
	// make filter magic happen here...

	$str_array          = explode( ' ', $comment->comment_content );
	$comment_word_count = count( (array) $str_array );
	$length             = ( 43 > $comment_word_count ) ? $comment_word_count : 43;
	$output             = '';

	for ( $i = 0; $i < $length; $i++ ) :
		if ( $i == ( $length - 1 ) && $comment_word_count > $length ) :
			$output .= $str_array[ $i ] . '...';
		else :
			$output .= $str_array[ $i ] . ' ';
		endif;
	endfor;

	ob_start();
	echo "<div class='wonka-comment-wrapper'>";
	echo "<p class='comment-text' ws-data-comment='" . esc_html( $comment->comment_content ) . "'>";
	echo $output;
	echo '</p>';
	if ( $comment_word_count > $length ) {
		echo "<a href='javascript:void(0);' class='ws-data-comment-btn'> <i class='fa fa-angle-down'></i> read more</a>";
	}
	echo '</div>';
	echo ob_get_clean();

}
// add the filter
remove_action( 'woocommerce_review_comment_text', 'woocommerce_review_display_comment_text', 10, 1 );
add_action( 'woocommerce_review_comment_text', 'filter_woocommerce_product_review_list_args', 10, 1 );

/**
 * This is for modifications before an order is submitted on checkout page.
 */
function wonka_woocommerce_review_order_before_submit() {
	?>
	<script>
		if ( document.querySelector( '#shipping_address_1' ) ) 
		{
			document.querySelector( '#shipping_address_1' ).addEventListener( 'onfocus', function( e ) 
			{
				e.stopImmediatePropagation();
			} );
		}

		var cybersource_form_field_group = document.querySelectorAll( '.payment_box.payment_method_cybersource .form-row' );
		cybersource_form_field_group.forEach( function( field_group, i ) 
		{
			var new_container, new_row_container;
			if ( i === 0 )
			{
				new_container = document.createElement( 'DIV' );
				new_container.classList.add( 'form-group', 'form-row' );
				new_container.innerHTML = field_group.innerHTML;
				field_group.parentElement.insertBefore( new_container, field_group );
				field_group.remove();
			}

			if ( i === 1 ) 
			{
				new_row_container = document.createElement( 'DIV' );
				new_row_container.classList.add( 'form-row', 'form-inline', 'justify-content-between', 'wonka-form-row' );
				new_container = document.createElement( 'DIV' );
				new_container.classList.add( 'form-group' );
				new_container.innerHTML = field_group.innerHTML;
				new_row_container.appendChild( new_container );
				field_group.parentElement.insertBefore( new_row_container, field_group );
				field_group.remove();
			}

			if ( i > 1 ) 
			{
				new_container = document.createElement( 'DIV' );
				new_container.classList.add( 'form-group', 'form-inline' );
				new_container.innerHTML = field_group.innerHTML;
				field_group.parentElement.querySelector( '.wonka-form-row' ).appendChild( new_container );
				field_group.parentElement.querySelector( '.clear' ).remove();
				field_group.remove();
			}
		});

		var cybersource_labels = document.querySelectorAll( '.payment_box.payment_method_cybersource label' );
		cybersource_labels.forEach( function( label, i ) 
		{
			label.classList.add( 'sr-only' );
		});

		var cybersource_inputs = document.querySelectorAll( '.payment_box.payment_method_cybersource input' );
		cybersource_inputs.forEach( function( input, i ) 
		{
			input.classList.add( 'form-control' );
			if ( input.id === 'cybersource_cvNumber' ) 
			{
				input.setAttribute( 'placeholder', 'CCV' );
			}
			else
			{
				input.setAttribute( 'placeholder', input.parentElement.querySelector( 'label' ).innerText );
			}
		});

		var cybersource_select_boxes = document.querySelectorAll( '.payment_box.payment_method_cybersource select' );
		cybersource_select_boxes.forEach( function( select, i ) 
		{
			select.classList.add( 'form-control' );
			if ( select.name === 'cybersource_cardType' ) 
			{
				select.firstElementChild.innerText = select.parentElement.querySelector( 'label' ).innerText;
			}

			if ( select.name === 'cybersource_expirationMonth' ) 
			{
				select.style.marginRight = 15 + 'px';
			}
		});

		var billing_to_radios = document.querySelectorAll( 'input[name="ship_to_different_address"]' );
		var billing_address_form = document.querySelector( '.billing_address' );
		var xhr = new XMLHttpRequest();
		if ( document.querySelector( '#bill-to-different-address-checkbox2' ) ) 
		{
			if ( document.querySelector( '#bill-to-different-address-checkbox2' ).checked ) 
			{
				billing_address_form.classList.add( 'active' );
				copy_to_billing();
			}
		}

		billing_to_radios.forEach( function( item, i ) 
		{

			item.addEventListener( 'change', function( event ) 
			{
				var target = event.target;
				if ( target.checked && target.id == 'bill-to-different-address-checkbox2' ) 
				{
					wonka_ajax_request( xhr, 'shipping_to_billing', '&opt_set=billing' );
					billing_address_form.classList.add( 'active' );
					copy_to_billing();
				}
				else
				{
					wonka_ajax_request( xhr, 'shipping_to_billing', '&opt_set=shipping' );
					if ( billing_address_form.classList.contains( 'active' ) ) 
					{
						billing_address_form.classList.remove( 'active' );
						copy_to_billing();
					}
				}

			});
		});

		function copy_to_billing() {

			var email = document.getElementsByName("shipping_email")[0].value;
			var first_name = document.getElementsByName("shipping_first_name")[0].value;
			var last_name = document.getElementsByName("shipping_last_name")[0].value;
			var company = document.getElementsByName("shipping_company")[0].value;
			var address_1 = document.getElementsByName("shipping_address_1")[0].value;
			var address_2 = document.getElementsByName("shipping_address_2")[0].value;
			var city = document.getElementsByName("shipping_city")[0].value;
			var state = document.getElementById("shipping_state").value;
			var postcode = document.getElementsByName("shipping_postcode")[0].value;
			var phone = document.getElementsByName("shipping_phone")[0].value;
			var contact_cells = document.querySelectorAll( '.contact-email-cell' );
			var ship_to_cells = document.querySelectorAll( '.ship-to-address-cell' );

			contact_cells.forEach( function( item, i ) 
			{
				item.innerText = email;
			});

			ship_to_cells.forEach( function( item, i ) 
			{
				item.innerHTML = '<span class="address-number">' +address_1 + ' ' + address_2 + '</span> <span class="city-state-zip">' + city + ', ' + state + ' ' + postcode + '</span>';
			});

			if ( document.getElementById( 'bill-to-different-address-checkbox2' ) ) 
			{
				if ( document.getElementById( 'bill-to-different-address-checkbox2' ).checked ) 
				{
					document.getElementById( "billing_address_1" ).classList.remove( 'input-text' );
					document.getElementById( "billing_address_1" ).removeEventListener( 'change', function() { return; }, true );
					document.getElementById( "billing_address_1" ).removeEventListener( 'keydown', function() { return; }, true );
					document.getElementById( "billing_address_2" ).classList.remove( 'input-text' );
					document.getElementById( "billing_address_2" ).removeEventListener( 'change', function() { return; }, true );
					document.getElementById( "billing_address_2" ).removeEventListener( 'keydown', function() { return; }, true );
					document.getElementById( "billing_city" ).classList.remove( 'input-text' );
					document.getElementById( "billing_city" ).removeEventListener( 'change', function() { return; }, true );
					document.getElementById( "billing_city" ).removeEventListener( 'keydown', function() { return; }, true );
					document.getElementById( "billing_state" ).addEventListener( 'change', function( e ) { e.stopImmediatePropagation(); return; } );
					document.getElementById( "billing_postcode" ).classList.remove( 'input-text' );
					document.getElementById( "billing_postcode" ).removeEventListener( 'change', function() { return; }, true );
					document.getElementById( "billing_postcode" ).removeEventListener( 'keydown', function() { return; }, true );
				}
				else
				{
					document.getElementById( "billing_email" ).value = email;
					document.getElementById( "billing_first_name" ).value = first_name;
					document.getElementById( "billing_last_name" ).value = last_name;
					document.getElementById( "billing_company" ).value = company;
					document.getElementById( "billing_address_1" ).value = address_1;
					document.getElementById( "billing_address_2" ).value = address_2;
					document.getElementById( "billing_city" ).value = city;
					document.getElementById( "billing_state" ).value = state;
					document.getElementById( "billing_postcode" ).value = postcode;
					document.getElementById( "billing_phone" ).value = phone;
				}
			}
		}

		function wonka_ajax_request( xhr, action, data ) 
		{   
			if ( action === "shipping_to_billing" ) 
			{

				xhr.onreadystatechange = function() {

					if ( this.readyState == 4 && this.status == 200 ) 
					{
						var response = JSON.parse( this.responseText );
					}
				};
				xhr.open('GET', wonkasoft_request.ajax + "?" + "action=" + action + data + "&security=" + wonkasoft_request.security);
				xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xhr.send();
			}

		}

		if ( document.querySelector( 'a[data-target="#place_order"]' ) ) 
		{
			document.querySelector( 'a[data-target="#place_order"]' ).addEventListener( 'click', function( e ) 
			{
				var target = e.target;
				var for_submit_id = target.getAttribute( 'data-target' );
				document.querySelector( for_submit_id ).click();
			});
		}
	</script>
	<?php
}

add_action( 'woocommerce_review_order_before_submit', 'wonka_woocommerce_review_order_before_submit', 999 );

/**
 * Styles and Code for compare plugin
 *
 * @author Carlos
 * @return    [return description]
 */
function add_theme_style_to_compare() {
	wp_enqueue_style( 'apera-bags-style', get_stylesheet_uri(), array(), time() );
}

if ( class_exists( 'YITH_Woocompare_Frontend' ) ) {
	add_action( 'wp_print_styles', 'add_theme_style_to_compare', 101 );
}

/**
 * This filters the label for products in the compare modal.
 *
 * @param  string $var contains html string.
 * @return string      returns the desired label.
 */
function filter_yith_woocompare_compare_added_label( $var ) {
	$var = 'Compare Bags';
	return $var;
};
add_filter( 'yith_woocompare_compare_added_label', 'filter_yith_woocompare_compare_added_label', 10, 1 );

/**
 * This filters the products description for products in the compare modal.
 *
 * @param  string $var contains html string.
 * @return string      returns the desired label.
 */
function wonkasoft_yith_woocompare_products_description( $var ) {
	$pieces = explode( '<a', html_entity_decode( $var ) );
	return $pieces[0];
};
add_filter( 'yith_woocompare_products_description', 'wonkasoft_yith_woocompare_products_description', 10, 1 );

/**
 * This is for making special note added for club greenwoood coupons
 *
 * @since 1.0.0
 */
function add_customer_order_notes( $order_id ) {

	// note this line is different
	// because I already have the ID from the hook I am using.
	$order        = new WC_Order( $order_id );
	$free_logo_id = '';
	$quantity     = 1;

	$query          = new WC_Product_Query();
	$query_products = $query->get_products();

	foreach ( $query_products as $single_product ) {
		$product_data = $single_product->get_data();
		if ( $product_data['slug'] === 'free-custom-logo' ) :
			$free_logo_id = $product_data['id'];
		endif;
	}

	if ( ! empty( $free_logo_id ) ) {
		$free_logo = wc_get_product( $free_logo_id );
	}

	$coupon_codes = $order->get_used_coupons();
	if ( empty( $coupon_codes ) ) {
		return;
	}

	$user_query = new WP_User_Query(
		array(
			'meta_key'     => 'company_logo',
			'meta_compare' => '=',
		)
	);

	foreach ( $user_query->results as $user ) {
		$company_logo = get_user_meta( $user->ID, 'company_logo', true );
		$company_logo = json_decode( $company_logo );

		if ( ! empty( $company_logo->coupon_code ) ) {
			foreach ( $coupon_codes as $coupon_code ) {
				$coupon_code = str_replace( ' ', '', strtolower( $coupon_code ) );

				if ( $coupon_code === $company_logo->coupon_code ) :
					if ( ! empty( $free_logo ) ) {
						$order->add_product( $free_logo, $quantity );
					}
					// The text for the note.
					$note  = 'This is a ' . $company_logo->company_name . " order, make sure to add custom logo before shipping\n";
					$note .= 'url: ' . $company_logo->url . '';

					// Add the note.
					$order->add_order_note( $note );

					// Save the data.
					$order->save();
				endif;
			}
		}
	}
}
add_action( 'woocommerce_payment_complete', 'add_customer_order_notes', 15, 1 );

/**
 * This is filtering the single product archive thumbnail size.
 *
 * @param  string $size contains the thumbnail size.
 * @return string       returns the thumbnail size.
 */
function wonkasoft_single_product_archive_thumbnail_size( $size ) {
	$size = 'cart_products_size';
	return $size;
}
add_filter( 'single_product_archive_thumbnail_size', 'wonkasoft_single_product_archive_thumbnail_size', 50 );

/**
 * This filters the table fields for the woocompare modal.
 *
 * @param  array $fields   contains the fields of the table.
 * @param  array $products contains the products in the compare modal.
 * @return array           returns the fields of the the table.
 */
function wonkasoft_filter_yith_woocompare_filter_table_fields( $fields, $products ) {
	$fields['title'] = 'Product';
	return $fields;
};

add_filter( 'yith_woocompare_filter_table_fields', 'wonkasoft_filter_yith_woocompare_filter_table_fields', 10, 2 );

/**
 * This is to add images to the new order email template
 *
 * @param  string $output filtered out.
 * @param  object $order  Order information.
 * @return filter         filtered content
 * @since 1.0.1 New requests
 */
function ws_add_wc_order_email_images( $table, $order ) {

	ob_start();

	$template = $plain_text ? 'emails/plain/email-order-items.php' : 'emails/email-order-items.php';
	wc_get_template(
		$template,
		array(
			'order'               => $order,
			'items'               => $order->get_items(),
			'show_download_links' => $show_download_links,
			'show_sku'            => $show_sku,
			'show_purchase_note'  => $show_purchase_note,
			'show_image'          => true,
			'image_size'          => array( 120, 120 ),
		)
	);

	return ob_get_clean();
}
add_filter( 'woocommerce_email_order_items_table', 'ws_add_wc_order_email_images', 10, 2 );

/**
 * This filters the edit order item name.
 *
 * @param  string $name contains the order item name.
 * @return string       returns the modified string.
 */
function ws_edit_order_item_name( $name ) {
	return '<div>' . $name . '</div>';
}
add_filter( 'woocommerce_order_item_name', 'ws_edit_order_item_name' );

/**
 * Limit the availability of this shipping method based
 * on the destination state. - Restriction
 *
 * Restricted locations include American Samoa,
 * Guam, North Mariana Islands, Puerto Rico,
 * US Minor Outlying Islands, and the US Virgin Islands.
 *
 * @param bool $is_available Is this shipping method available?.
 * @return bool
 */
function ws_restrict_free_shipping( $is_available ) {
	$restricted = array( 'AS', 'GU', 'MP', 'PR', 'UM', 'VI' );

	foreach ( WC()->cart->get_shipping_packages() as $package ) {
		if ( in_array( $package['destination']['state'], $restricted, true ) ) {
			return false;
		}

		if ( 25 > WC()->cart->subtotal ) {
			return false;
		}
	}
	return $is_available;
}
add_filter( 'woocommerce_shipping_free_shipping_is_available', 'ws_restrict_free_shipping' );

/**
 * This sets the availability of this shipping message.
 *
 * @param  bool  $is_available contains true or false.
 * @param  array $package      contains array of current package.
 * @return bool               returns if shipping package is available.
 */
function ws_restrict_usps_priority_mail_under_25( $is_available, $package ) {
	$restricted = array( 'AS', 'GU', 'MP', 'PR', 'UM', 'VI' );
	$user       = wp_get_current_user();

	foreach ( WC()->cart->get_shipping_packages() as $package ) {
		if ( in_array( $package['destination']['state'], $restricted, true ) ) {
			return false;
		}
	}
	return $is_available;
}
add_filter( 'woocommerce_shipping_USPS_Priority_Mail_under_25_is_available', 'ws_restrict_usps_priority_mail_under_25', 10, 2 );

/**
 * This sets the availability of this shipping message.
 *
 * @param  bool  $is_available contains true or false.
 * @param  array $package      contains array of current package.
 * @return bool               returns if shipping package is available.
 */
function ws_restrict_USPS_Priority_Mail_NP( $is_available, $package ) {
	$restricted = array( 'AS', 'GU', 'MP', 'PR', 'UM', 'VI' );
	$user       = wp_get_current_user();

	foreach ( WC()->cart->get_shipping_packages() as $package ) {
		if ( in_array( $package['destination']['state'], $restricted, true ) ) {
			return false;
		}

		if ( in_array( 'apera_perks_partner', (array) $user->roles, true ) ) {
			return false;
		}
	}
	return $is_available;
}
add_filter( 'woocommerce_shipping_USPS_Priority_Mail_NP_is_available', 'ws_restrict_USPS_Priority_Mail_NP', 10, 2 );

/**
 * This sets the availability of this shipping message.
 *
 * @param  bool  $is_available contains true or false.
 * @param  array $package      contains array of current package.
 * @return bool               returns if shipping package is available.
 */
function ws_restrict_USPS_Priority_Mail_Express( $is_available, $package ) {
	$restricted = array( 'AS', 'GU', 'MP', 'PR', 'UM', 'VI' );
	$user       = wp_get_current_user();

	foreach ( WC()->cart->get_shipping_packages() as $package ) {
		if ( in_array( $package['destination']['state'], $restricted, true ) ) {
			return false;
		}
	}
	return $is_available;
}
add_filter( 'woocommerce_shipping_USPS_Priority_Mail_Express_is_available', 'ws_restrict_USPS_Priority_Mail_Express', 10, 2 );

/**
 * This sets the availability of this shipping message.
 *
 * @param  bool  $is_available contains true or false.
 * @param  array $package      contains array of current package.
 * @return bool               returns if shipping package is available.
 */
function ws_restrict_USPS_Priority_Mail_Express_NP( $is_available, $package ) {
	$restricted = array( 'AS', 'GU', 'MP', 'PR', 'UM', 'VI' );
	$user       = wp_get_current_user();

	foreach ( WC()->cart->get_shipping_packages() as $package ) {
		if ( in_array( $package['destination']['state'], $restricted, true ) ) {
			return false;
		}

		if ( in_array( 'apera_perks_partner', (array) $user->roles, true ) ) {
			return false;
		}
	}
	return $is_available;
}
add_filter( 'woocommerce_shipping_USPS_Priority_Mail_Express_NP_is_available', 'ws_restrict_USPS_Priority_Mail_Express_NP', 10, 2 );

/**
* Add new custom shipping methods
*
* @since 1.0.1 New Requests
*/

/*
* Check if WooCommerce is active
*/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	/**
	 This initiates added shipping options.
	 */
	function ws_shipping_method_init() {

		if ( ! class_exists( 'WC_Priority_Mail_Shipping_NP_Method' ) ) {
			class WC_Priority_Mail_Shipping_NP_Method extends WC_Shipping_Method {

				/**
				 Constructor for your shipping class

				 @access public
				 @return void
				 */
				public function __construct() {
						$this->id                 = 'USPS_Priority_Mail_NP'; // Id for your shipping method. Should be uunique.
						$this->method_title       = __( 'USPS Priority Mail Non-Perks Members' );  // Title shown in admin
						$this->method_description = __( 'USPS Priority Mail Flat Rate for Non-perks Members' ); // Description shown in admin
						$this->enabled            = 'yes'; // This can be added as an setting but for this example its forced enabled
						$this->title              = 'Priority 1-3 business days'; // This can be added as an setting but for this example its forced.
						$this->init();
				}
				/**
				 Init your settings

				 @access public
				 @return void
				 */
				public function init() {
					// Load the settings API.
					$this->init_settings(); // This is part of the settings API. Loads settings you previously init.
					$this->init_form_fields(); // This is part of the settings API. Override the method to add your own settings.
					// Save settings in admin if you have any defined.
					add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
				}
				/**
				 Calculate_shipping function.

				 @access public
				 @param mixed $package contains the packages.
				 @return void
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

		if ( ! class_exists( 'WC_Priority_Mail_Express_Shipping_Method' ) ) {
			class WC_Priority_Mail_Express_Shipping_Method extends WC_Shipping_Method {

				/**
				 Constructor for your shipping class

				 @access public
				 @return void
				 */
				public function __construct() {
					$this->id                 = 'USPS_Priority_Mail_Express'; // Id for your shipping method. Should be uunique.
					$this->method_title       = __( 'USPS Priority Mail Express' );  // Title shown in admin.
					$this->method_description = __( 'USPS Priority Mail Express Flat Rate' ); // Description shown in admin.
					$this->enabled            = 'yes'; // This can be added as an setting but for this example its forced enabled.
					$this->title              = 'Overnight 1 business day'; // This can be added as an setting but for this example its forced.
					$this->init();
				}
				/**
				 Init your settings

				 @access public
				 @return void
				 */
				public function init() {
					// Load the settings API.
					$this->init_settings(); // This is part of the settings API. Loads settings you previously init.
					$this->init_form_fields(); // This is part of the settings API. Override the method to add your own settings.
					// Save settings in admin if you have any defined.
					add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
				}
				/**
				 Calculate_shipping function.

				 @access public
				 @param mixed $package contains the packages.
				 @return void
				 */
				public function calculate_shipping( $package = array() ) {
					$rate = array(
						'id'       => $this->id,
						'label'    => $this->title,
						'cost'     => '30.00',
						'calc_tax' => 'per_item',
					);
					// Register the rate.
					$this->add_rate( $rate );
				}
			}
		}

		if ( ! class_exists( 'WC_Priority_Mail_Express_Shipping_NP_Method' ) ) {
			class WC_Priority_Mail_Express_Shipping_NP_Method extends WC_Shipping_Method {

				/**
				 Constructor for your shipping class

				 @access public
				 @return void
				 */
				public function __construct() {
						$this->id                 = 'USPS_Priority_Mail_Express_NP'; // Id for your shipping method. Should be uunique.
						$this->method_title       = __( 'USPS Priority Mail Express Non-Perks Members' );  // Title shown in admin.
						$this->method_description = __( 'USPS Priority Mail Express Flat Rate for Non-Perks Members' ); // Description shown in admin.
						$this->enabled            = 'yes'; // This can be added as an setting but for this example its forced enabled.
						$this->title              = 'Overnight 1 business day'; // This can be added as an setting but for this example its forced.
						$this->init();
				}
				/**
				 Init your settings

				 @access public
				 @return void
				 */
				public function init() {
					// Load the settings API.
					$this->init_settings(); // This is part of the settings API. Loads settings you previously init.
					$this->init_form_fields(); // This is part of the settings API. Override the method to add your own settings.
					// Save settings in admin if you have any defined.
					add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
				}
				/**
				 calculate_shipping function.

				 @access public
				 @param mixed $package
				 @return void
				 */
				public function calculate_shipping( $package = array() ) {
					$rate = array(
						'id'       => $this->id,
						'label'    => $this->title,
						'cost'     => '50.00',
						'calc_tax' => 'per_item',
					);
					// Register the rate.
					$this->add_rate( $rate );
				}
			}
		}

		if ( ! class_exists( 'WC_Priority_Mail_under_25_Method' ) ) {
			class WC_Priority_Mail_under_25_Method extends WC_Shipping_Method {

				/**
				 Constructor for your shipping class

				 @access public
				 @return void
				 */
				public function __construct() {
						$this->id                 = 'USPS_Priority_Mail_under_25'; // Id for your shipping method. Should be uunique.
						$this->method_title       = __( 'USPS Priority Mail' );  // Title shown in admin.
						$this->method_description = __( 'USPS Priority Mail Flate Rate for orders under $25' ); // Description shown in admin.
						$this->enabled            = 'yes'; // This can be added as an setting but for this example its forced enabled.
						$this->title              = 'Priority 1-3 business days'; // This can be added as an setting but for this example its forced.
						$this->init();
				}
				/**
				 Init your settings

				 @access public
				 @return void
				 */
				public function init() {
					// Load the settings API.
					$this->init_settings(); // This is part of the settings API. Loads settings you previously init.
					$this->init_form_fields(); // This is part of the settings API. Override the method to add your own settings.
					// Save settings in admin if you have any defined.
					add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
				}
				/**
				 calculate_shipping function.

				 @access public
				 @param mixed $package
				 @return void
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
	}

	add_action( 'woocommerce_shipping_init', 'ws_shipping_method_init' );

	/**
	 This adds new shipping methods.

	 @param object $methods contains the current methods.
	 */
	function add_ws_shipping_methods( $methods ) {

		$methods['USPS_Priority_Mail']            = 'WC_Priority_Mail_under_25_Method';
		$methods['USPS_Priority_Mail_NP']         = 'WC_Priority_Mail_Shipping_NP_Method';
		$methods['USPS_Priority_Mail_Express']    = 'WC_Priority_Mail_Express_Shipping_Method';
		$methods['USPS_Priority_Mail_Express_NP'] = 'WC_Priority_Mail_Express_Shipping_NP_Method';

		return $methods;
	}
	add_filter( 'woocommerce_shipping_methods', 'add_ws_shipping_methods' );
}

/**
 * This function is used to call product images
 *
 * @param  [type] $image       [description]
 * @param  [type] $obj         [description]
 * @param  [type] $size        [description]
 * @param  [type] $attr        [description]
 * @param  [type] $placeholder [description]
 * @return [type]              [description]
 */
function wonka_woocommerce_product_get_image( $image, $obj, $size, $attr, $placeholder ) {

	$size = array( '220', '264' );

	if ( $obj->get_image_id() ) {
		$image = wp_get_attachment_image( $obj->get_image_id(), $size, false, $attr );
	} elseif ( $obj->get_parent_id() ) {
		$parent_product = wc_get_product( $obj->get_parent_id() );
		if ( $parent_product ) {
			$image = $parent_product->get_image( $size, $attr, $placeholder );
		}
	}

	if ( ! $image && $placeholder ) {
		$image = wc_placeholder_img( $size );
	}

	return $image;
}
add_filter( 'woocommerce_product_get_image', 'wonka_woocommerce_product_get_image', 10, 5 );

/**
 * [wonkasoft_woocommerce_cart_shipping_method_full_label description]
 *
 * @param  [type] $method [description]
 * @return [type]         [description]
 */
function wonkasoft_woocommerce_cart_shipping_method_full_label( $label, $method ) {
	$label     = $method->get_label();
	$has_cost  = 0 < $method->cost;
	$hide_cost = ! $has_cost && in_array( $method->get_method_id(), array( 'free_shipping', 'local_pickup' ), true );
	if ( 'free_shipping' === $method->get_method_id() ) :
		$label .= ' <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>0</span>';
	endif;

	if ( $has_cost && ! $hide_cost ) {
		if ( WC()->cart->display_prices_including_tax() ) {
			$label .= ' ' . wc_price( $method->cost + $method->get_shipping_tax() );
			if ( $method->get_shipping_tax() > 0 && ! wc_prices_include_tax() ) {
				$label .= ' <small class="tax_label">' . WC()->countries->inc_tax_or_vat() . '</small>';
			}
		} else {
			$label .= ' ' . wc_price( $method->cost );
			if ( $method->get_shipping_tax() > 0 && wc_prices_include_tax() ) {
				$label .= ' <small class="tax_label">' . WC()->countries->ex_tax_or_vat() . '</small>';
			}
		}
	}

	return $label;
}
add_filter( 'woocommerce_cart_shipping_method_full_label', 'wonkasoft_woocommerce_cart_shipping_method_full_label', 50, 2 );

function wonkasoft_woocommerce_register_form_start() {
	$output = '';

	$first_name = ( ! empty( $_POST['billing_first_name'] ) ) ? esc_attr( wp_unslash( $_POST['billing_first_name'] ) ) : '';
	$last_name  = ( ! empty( $_POST['billing_last_name'] ) ) ? esc_attr( wp_unslash( $_POST['billing_last_name'] ) ) : '';

	$output .= '<div class="form-group">';
	$output .= '<div class="input-group">';
	$output .= '<div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-user"></i></span></div>';
	$output .= '<input type="text" class="form-control" name="billing_first_name" id="reg_billing_first_name" placeholder="' . esc_html( 'First Name *', 'woocommerce' ) . '" autocomplete="billing_first_name" value="' . $first_name . '" />';
	$output .= '<input type="text" class="form-control" name="billing_last_name" id="reg_billing_last_name" placeholder="' . esc_html( 'Last Name *', 'woocommerce' ) . '" autocomplete="billing_last_name" value="' . $last_name . '" />';
	$output .= '<div class="invalid-feedback reg_billing_first_name"></div>';
	$output .= '</div>';
	$output .= '</div>';

	echo wp_kses(
		$output,
		array(
			'div'   => array(
				'class' => array(),
			),
			'i'     => array(
				'class' => array(),
			),
			'span'  => array(
				'class' => array(),
			),
			'input' => array(
				'type'         => array(),
				'class'        => array(),
				'name'         => array(),
				'id'           => array(),
				'placeholder'  => array(),
				'autocomplete' => array(),
				'value'        => array(),
			),
		)
	);
}
add_action( 'woocommerce_register_form_start', 'wonkasoft_woocommerce_register_form_start', 10 );

/**
 * This sets the role for woocommerce registration form
 *
 * @param  [type] $new_customer_data [description]
 * @return [type]                    [description]
 */
function wonkasoft_woocommerce_new_customer_data( $new_customer_data ) {

	$new_customer_data['role'] = get_option( 'default_role' );

	return $new_customer_data;
}
add_filter( 'woocommerce_new_customer_data', 'wonkasoft_woocommerce_new_customer_data', 10 );

/**
 * This sets the user first name last name and billing fields.
 *
 * @param  number $customer_id customer ID.
 */
function wonkasoft_woocommerce_created_customer( $customer_id ) {

	$nonce = ( isset( $_REQUEST['_wpnonce'] ) ) ? wp_kses_data( wp_unslash( $_REQUEST['_wpnonce'] ) ) : '';
	! wp_verify_nonce( $nonce, -1 ) || die( 'Nonce Failed' );

	if ( isset( $_POST['billing_first_name'] ) ) {
		$first_name = sanitize_text_field( wp_unslash( $_POST['billing_first_name'] ) );
		// First name field which is by default.
		update_user_meta( $customer_id, 'first_name', $first_name );
		// First name field which is used in WooCommerce.
		update_user_meta( $customer_id, 'billing_first_name', $first_name );
	}
	if ( isset( $_POST['billing_last_name'] ) ) {
		$last_name = sanitize_text_field( wp_unslash( $_POST['billing_last_name'] ) );
		// Last name field which is by default.
		update_user_meta( $customer_id, 'last_name', $last_name );
		// Last name field which is used in WooCommerce.
		update_user_meta( $customer_id, 'billing_last_name', $last_name );
	}
	if ( isset( $_POST['email'] ) && isset( $_POST['billing_first_name'] ) && isset( $_POST['billing_last_name'] ) ) {
		$campaign_name = 'perks_program_signups';
		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		$api_args = array(
			'email'         => sanitize_email( wp_unslash( $_POST['email'] ) ),
			'contact_name'  => $first_name . ' ' . $last_name,
			'campaign_name' => $campaign_name,
			'ip_address'    => $ip,
		);

		$api_args['contact_name'] = ucfirst( $api_args['contact_name'] );
		$getresponse              = new Wonkasoft_GetResponse_Api( $api_args );

		if ( empty( $getresponse->campaign_id ) ) :
			foreach ( $getresponse->campaign_list as $campaign ) :
				if ( $api_args['campaign_name'] === $campaign->name ) :
					$getresponse->campaign_id = $campaign->campaignId;
				endif;
			endforeach;
		endif;

		if ( empty( $getresponse->contact_id ) ) :
			foreach ( $getresponse->contact_list as $contact ) :
				if ( empty( $getresponse->campaign_id ) ) {
					$getresponse->contact_id = $contact->contactId;
				} else {
					if ( $getresponse->campaign_id === $contact->campaign->campaignId ) :
						$getresponse->contact_id = $contact->contactId;
					endif;
				}
			endforeach;
		endif;

		if ( ! empty( $getresponse->contact_id ) ) {
			$getresponse->update_contact_details();
		} else {
			$getresponse->create_a_new_contact();
		}
	}
}
add_action( 'woocommerce_created_customer', 'wonkasoft_woocommerce_created_customer', 1 );

remove_action( 'woocommerce_after_cart_table', array( 'RSRedeemingFrontend', 'default_redeem_field_in_cart_and_checkout' ) );
add_action( 'woocommerce_before_cart', array( 'RSRedeemingFrontend', 'default_redeem_field_in_cart_and_checkout' ), 11 );

remove_action( 'woocommerce_before_checkout_form', array( 'RSFrontendAssets', 'complete_message_for_purchase' ), 999 );
add_action( 'woocommerce_before_checkout_form', array( 'RSFrontendAssets', 'complete_message_for_purchase' ), 15 );

/**
 * This is for the adding of the endpoints to WordPress.x
 */
function wonkasoft_add_all_endpoints() {
	add_rewrite_endpoint( 'earn-aperacash', EP_PAGES );
	add_rewrite_endpoint( 'zip-program', EP_PAGES );
	add_rewrite_endpoint( 'ambassador-program', EP_PAGES );
}
add_action( 'init', 'wonkasoft_add_all_endpoints' );

/**
 * This is for adding the endpoints to the woocommerce query vars.
 *
 * @param  array $vars contains the current query vars to be filtered.
 * @return array       returns the modified query vars.
 */
function wonkasoft_add_endpoint_query_vars( $vars ) {
	$added_endpoints = array(
		'earn-aperacash',
		'zip-program',
		'ambassador-program',
	);

	foreach ( $added_endpoints as $key => $e ) {
		$vars[ $e ] = $e;
	}

	return $vars;
}
add_filter( 'woocommerce_get_query_vars', 'wonkasoft_add_endpoint_query_vars' );

/**
 * This is for the redirect after save address in the myaccount area.
 *
 * @param  number $user_id      contains user ID.
 * @param  string $load_address contains the load address.
 */
function wonkasoft_action_woocommerce_save_account_details( $user_id ) {
	wp_safe_redirect( wc_get_endpoint_url( 'edit-account' ) );
	exit;
};
add_action( 'woocommerce_save_account_details', 'wonkasoft_action_woocommerce_save_account_details', 10, 1 );

/**
 * This adds the my account menu link for the logo.
 *
 * @param  array $menu_links contains the current my account links.
 * @return [type]             [description]
 */
function wonkasoft_my_account_nav_menu_items( $menu_links ) {

	$user = wp_get_current_user();

	// Edits My Account Menu titles
	$menu_links = array(
		'dashboard'          => __( 'Dashboard', 'woocommerce' ),
		'earn-aperacash'     => __( 'Earn AperaCash', 'woocommerce' ),
		'orders'             => __( 'My Orders', 'woocommerce' ),
		'edit-account'       => __( 'Account Details', 'woocommerce' ),
		'zip-program'        => __( 'ZIP Program', 'woocommerce' ),
		'ambassador-program' => __( 'Ambassador', 'woocommerce' ),
	);

	if ( ! in_array( 'apera_zip_affiliate', $user->roles ) && ! in_array( 'administrator', $user->roles ) ) :
		unset( $menu_links['zip-program'] );
endif;

	if ( ! in_array( 'apera_ambassador_affiliate', $user->roles ) && ! in_array( 'administrator', $user->roles ) ) :
		unset( $menu_links['ambassador-program'] );
endif;

	return $menu_links;
}
add_filter( 'woocommerce_account_menu_items', 'wonkasoft_my_account_nav_menu_items', 50 );

/**
 * This adds my account dashboard extention.
 */
function wonkasoft_add_dashboard_extention() {
	include get_stylesheet_directory() . '/woocommerce/myaccount/dashboard-extention.php';
}
add_action( 'woocommerce_account_dashboard', 'wonkasoft_add_dashboard_extention' );

/**
 * This is the earn AperaCash endpoint page
 */
function wonkasoft_my_account_earn_aperacash_endpoint_content() {
	include get_stylesheet_directory() . '/woocommerce/myaccount/earn-aperacash.php';
}
add_action( 'woocommerce_account_earn-aperacash_endpoint', 'wonkasoft_my_account_earn_aperacash_endpoint_content' );

/**
 * This is the earn ZIP Program endpoint page
 *
 * @return echo parse the earn ZIP Program end-point content.
 */
function wonkasoft_my_account_zip_program_endpoint_content() {
	include get_stylesheet_directory() . '/woocommerce/myaccount/zip-program.php';
}
add_action( 'woocommerce_account_zip-program_endpoint', 'wonkasoft_my_account_zip_program_endpoint_content' );

/**
 * This is the earn Ambassador Program endpoint page
 */
function wonkasoft_my_account_ambassador_program_endpoint_content() {
	include get_stylesheet_directory() . '/woocommerce/myaccount/ambassador-program.php';
}
add_action( 'woocommerce_account_ambassador-program_endpoint', 'wonkasoft_my_account_ambassador_program_endpoint_content' );

/**
 * This filters the columns on the my orders dashboard.
 *
 * @param  array $columns contains an array of the columns.
 * @return array          returns columns.
 */
function wonkasoft_woocommerce_my_account_my_orders_columns( $columns ) {

	$columns = array(
		'order-date'      => __( 'Date', 'woocommerce' ),
		'order-price'     => __( 'Price', 'woocommerce' ),
		'order-aperacash' => __( 'AperaCash', 'woocommerce' ),
		'order-status'    => __( 'Status', 'woocommerce' ),
		'order-actions'   => __( 'Actions', 'woocommerce' ),
	);

	return $columns;
}
add_filter( 'woocommerce_my_account_my_orders_columns', 'wonkasoft_woocommerce_my_account_my_orders_columns', 10 );

/**
 * This makes sure that new users have proper roles.
 *
 * @param  number $user_id contains the user ID.
 */
function wonkasoft_registration_save( $user_id ) {
	$role         = 'apera_perks_partner';
	$role_display = 'Apera Perks Partner';

	$role2         = 'customer';
	$role_display2 = 'Customer';

	$user = new WP_User( $user_id );
	if ( ! in_array( $role, $user->roles ) ) :
		$user->add_role( $role, $role_display );
	endif;

	if ( ! in_array( $role2, $user->roles ) ) :
		$user->add_role( $role2, $role_display2 );
	endif;
}
add_action( 'user_register', 'wonkasoft_registration_save', 10, 1 );

if ( ! empty( $GLOBALS['wjecf_extended_coupon_features'] ) ) :
	remove_filter( 'woocommerce_cart_item_name', array( $_GLOBALS['ced_click_n_go'], 'ced_ocor_cart_item_data' ), 10, 3 );
endif;

/**
 * This function filters product name.
 *
 * @param  string $current     contains current items if any.
 * @param  array  $cart_item     contains the array of the cart item.
 * @param  string $cart_item_key contains the cart item key.
 * @return string                returns the cart items product name after filtering.
 * @author MrLister <rlister@wonkasoft.com>
 */
function wonkasoft_woocommerce_cart_item_name( $current, $cart_item, $cart_item_key ) {
	$current = $cart_item['data']->get_title();

	return $current;
}
add_filter( 'woocommerce_cart_item_name', 'wonkasoft_woocommerce_cart_item_name', 10, 3 );

/**
 * This function filters product name on checkout review.
 *
 * @param  string $current     contains current items if any.
 * @param  array  $cart_item     contains the array of the cart item.
 * @param  string $cart_item_key contains the cart item key.
 * @return string                returns the cart items product name after filtering.
 * @author MrLister <rlister@wonkasoft.com>
 */
function wonkasoft_cart_and_review_woocommerce_cart_item_name( $current, $cart_item, $cart_item_key ) {
	$current = $cart_item['data']->get_name();

	return $current;
}
add_filter( 'cart_and_review_woocommerce_cart_item_name', 'wonkasoft_cart_and_review_woocommerce_cart_item_name', 10, 3 );

/**
 * This function is to get rid of the product name on top of item in cart.
 *
 * @param  string $current     contains the array of the cart item.
 * @param  array  $cart_item     contains the array of the cart item.
 * @param  string $cart_item_key contains the cart item key.
 * @return empty returns empty to eleminate the parsing of this.
 */
function wonkasoft_woocommerce_cart_item_product( $current, $cart_item, $cart_item_key ) {
	return $cart_item['data'];
}
add_filter( 'woocommerce_cart_item_product', 'wonkasoft_woocommerce_cart_item_product', 10, 3 );

/**
 * Setting new discount conditions.
 *
 * @param  array $conditions Contains current discount conditions.
 * @return array             returns filtered conditions.
 */
function wonkasoft_wad_get_discounts_conditions( $conditions ) {
	$conditions['is-coupon-set'] = __( 'If coupon is', 'aperabags' );

	return $conditions;
}
add_filter( 'wad_get_discounts_conditions', 'wonkasoft_wad_get_discounts_conditions', 10 );

/**
 * This function sets the evaluable condition.
 *
 * @param  [type] $rule       [description]
 * @param  int    $product_id contains the product id.
 * @return array             returns the array to be for options.
 */
function wonkasoft_wad_get_evaluable_condition( $rule, $product_id = false ) {

	if ( 'is-coupon-set' == $rule['condition'] ) :

		$applied_coupons = WC()->cart->applied_coupons;

		$couponargs   = array(
			'post_type'      => 'shop_coupon',
			'orderby'        => 'title',
			'order'          => 'ASC',
			'posts_per_page' => '-1',
		);
		$coupon       = new WP_Query( $couponargs );
		$coupon_array = array();
		foreach ( $coupon->posts as $cur_coupon ) {
			if ( in_array( $cur_coupon->post_name, $applied_coupons ) ) :
				$coupon_array[] = $cur_coupon->ID;
			endif;
		}
		$evaluable_condition = $coupon_array;

	endif;

	return $evaluable_condition;
}

/**
 * [wonkasoft_wad_fields_values_match description]
 *
 * @param  [type] $current_rules      [description]
 * @param  [type] $condition      [description]
 * @param  [type] $selected_value [description]
 * @return [type]                 [description]
 */
function wonkasoft_wad_fields_values_match( $current_rules, $condition, $selected_value ) {
	$selected_value_arr = array();
	$selected_value_str = '';
	if ( is_array( $selected_value ) ) {
		$selected_value_arr = $selected_value;
	} else {
		$selected_value_str = $selected_value;
	}

	$field_name   = 'o-discount[rules][{rule-group}][{rule-index}][value]';
	$couponargs   = array(
		'post_type'      => 'shop_coupon',
		'orderby'        => 'title',
		'order'          => 'ASC',
		'posts_per_page' => '-1',
	);
	$coupon       = new WP_Query( $couponargs );
	$coupon_array = array();
	foreach ( $coupon->posts as $cur_coupon ) {
		preg_match( '/sumo_|aperacash_|auto_redeem_/', strtolower( $cur_coupon->post_title ), $matches, PREG_UNMATCHED_AS_NULL );
		if ( empty( $matches ) ) :
			$coupon_array[ $cur_coupon->ID ] = strtolower( $cur_coupon->post_title );
		endif;
	}

	$coupon_select = get_wad_html_select( $field_name . '[]', false, '', $coupon_array, $selected_value_arr, true, true );

	$current_rules['is-coupon-set'] = $coupon_select;
	$values_match                   = $current_rules;

	if ( isset( $values_match[ $condition ] ) ) {
		return $values_match[ $condition ];
	} else {
		return $values_match;
	}
}
add_filter( 'wad_fields_values_match', 'wonkasoft_wad_fields_values_match', 10, 3 );

/**
 * [wonkasoft_wad_operators_fields_match description]
 *
 * @param  array  $current_rules      contains an array of conditions.
 * @param  [type] $condition      [description]
 * @param  [type] $selected_value [description]
 * @return [type]                 [description]
 */
function wonkasoft_wad_operators_fields_match( $current_rules, $condition, $selected_value = '' ) {
	$field_name              = 'o-discount[rules][{rule-group}][{rule-index}][operator]';
	$arrays_operators        = array(
		'SET'     => __( 'SET', 'woo-advanced-discounts' ),
		'NOT SET' => __( 'NOT SET', 'woo-advanced-discounts' ),
	);
	$arrays_operators_select = get_wad_html_select( $field_name, false, '', $arrays_operators, $selected_value );

	$current_rules['is-coupon-set'] = $arrays_operators_select;
	$operators_match                = $current_rules;

	if ( isset( $operators_match[ $condition ] ) ) {
		return $operators_match[ $condition ];
	} else {
		return $operators_match;
	}
}
add_filter( 'wad_operators_fields_match', 'wonkasoft_wad_operators_fields_match', 10, 3 );

/**
 * [wonkasoft_wad_is_rule_valid description]
 *
 * @param  [type] $is_valid       [description]
 * @param  [type] $rule           [description]
 * @param  [type] $class_instance [description]
 * @return [type]                 [description]
 */
function wonkasoft_wad_is_rule_valid( $is_valid, $rule, $class_instance ) {

	$condition = wonkasoft_wad_get_evaluable_condition( $rule, $product_id );
	$value     = get_proper_value( $rule, 'value' );

	// We check if the condition is SET or NOT SET the value.
	if ( 'is-coupon-set' == $rule['condition'] ) {
		if ( ! is_array( $value ) ) {
			$error_msg = __( 'Discount', 'woo-advanced-discounts' ) . " #$class_instance->id: " . __( 'Rule ', 'woo-advanced-discounts' ) . $rule['condition'] . __( ' requires at least one parameter selected in the values', 'woo-advanced-discounts' );
			echo $error_msg . '<br>';
			$is_valid = false;
		} else {
			$is_valid = ( array_intersect( $condition, $value ) ) ? true : false;

			if ( 'NOT SET' == $rule['operator'] ) {
				$is_valid = ( ! $is_valid );
			}
		}
	}

	return $is_valid;
}
add_filter( 'wad_is_rule_valid', 'wonkasoft_wad_is_rule_valid', 10, 3 );

/**
 * [wonkasoft_wad_is_applicable description]
 *
 * @param  [type] $is_valid       [description]
 * @param  [type] $class_instance [description]
 * @param  [type] $product_id     [description]
 * @return [type]                 [description]
 */
function wonkasoft_wad_is_applicable( $is_valid, $class_instance, $product_id ) {

	return $is_valid;
}
add_filter( 'wad_is_applicable', 'wonkasoft_wad_is_applicable', 10, 3 );

/**
 * This removes the unsupported Credit Card icons from Strip Gateway.
 *
 * @param  array $icons Contains an array of the img elements.
 * @return array        Returns an array of the  img elements.
 */
function wonkasoft_wc_stripe_payment_icons( $icons ) {
	$new_icons = array(
		'visa'       => '<img src="' . WC_STRIPE_PLUGIN_URL . '/assets/images/visa.svg" class="stripe-visa-icon stripe-icon" alt="Visa" />',
		'amex'       => '<img src="' . WC_STRIPE_PLUGIN_URL . '/assets/images/amex.svg" class="stripe-amex-icon stripe-icon" alt="American Express" />',
		'mastercard' => '<img src="' . WC_STRIPE_PLUGIN_URL . '/assets/images/mastercard.svg" class="stripe-mastercard-icon stripe-icon" alt="Mastercard" />',
		'discover'   => '<img src="' . WC_STRIPE_PLUGIN_URL . '/assets/images/discover.svg" class="stripe-discover-icon stripe-icon" alt="Discover" />',
		'alipay'     => '<img src="' . WC_STRIPE_PLUGIN_URL . '/assets/images/alipay.svg" class="stripe-alipay-icon stripe-icon" alt="Alipay" />',
		'wechat'     => '<img src="' . WC_STRIPE_PLUGIN_URL . '/assets/images/wechat.svg" class="stripe-wechat-icon stripe-icon" alt="Wechat Pay" />',
		'bancontact' => '<img src="' . WC_STRIPE_PLUGIN_URL . '/assets/images/bancontact.svg" class="stripe-bancontact-icon stripe-icon" alt="Bancontact" />',
		'ideal'      => '<img src="' . WC_STRIPE_PLUGIN_URL . '/assets/images/ideal.svg" class="stripe-ideal-icon stripe-icon" alt="iDeal" />',
		'p24'        => '<img src="' . WC_STRIPE_PLUGIN_URL . '/assets/images/p24.svg" class="stripe-p24-icon stripe-icon" alt="P24" />',
		'giropay'    => '<img src="' . WC_STRIPE_PLUGIN_URL . '/assets/images/giropay.svg" class="stripe-giropay-icon stripe-icon" alt="Giropay" />',
		'eps'        => '<img src="' . WC_STRIPE_PLUGIN_URL . '/assets/images/eps.svg" class="stripe-eps-icon stripe-icon" alt="EPS" />',
		'multibanco' => '<img src="' . WC_STRIPE_PLUGIN_URL . '/assets/images/multibanco.svg" class="stripe-multibanco-icon stripe-icon" alt="Multibanco" />',
		'sofort'     => '<img src="' . WC_STRIPE_PLUGIN_URL . '/assets/images/sofort.svg" class="stripe-sofort-icon stripe-icon" alt="SOFORT" />',
		'sepa'       => '<img src="' . WC_STRIPE_PLUGIN_URL . '/assets/images/sepa.svg" class="stripe-sepa-icon stripe-icon" alt="SEPA" />',
	);

	return $new_icons;
}
add_filter( 'wc_stripe_payment_icons', 'wonkasoft_wc_stripe_payment_icons', 10 );

/**
 * This is to update the stripe api version.
 *
 * @param  [type] $headers [description]
 * @return [type]          [description]
 */
function wonkasoft_woocommerce_stripe_request_headers( $headers ) {
	$headers['Stripe-Version'] = '2020-03-02';
	return $headers;
}
add_filter( 'woocommerce_stripe_request_headers', 'wonkasoft_woocommerce_stripe_request_headers', 10 );

/**
 * Add new featured product image meta box.
 */
function wonkasoft_product_meta_box_add() {
	add_meta_box( 'featured-product-image', __( 'Featured Product Image', 'aperabags' ), 'wonkasoft_product_meta_box', 'product', 'side', 'low' );
}
add_action( 'add_meta_boxes', 'wonkasoft_product_meta_box_add' );

/**
 * Featured Product image meta box callback.
 *
 * @author Rudy <rlister@wonkasoft.com>
 */
function wonkasoft_product_meta_box() {
	global $post;
	?>
	<div class="editor-product-featured-image">
		<?php

		$featured_product_img_id = get_featured_product_img_id( $post );

		if ( ! empty( $featured_product_img_id ) ) :
			?>
			<div class="editor-product-featured-image__container">
				<button type="button" class="components-button editor-product-featured-image__toggle d-none">Set featured product image</button>
				<div class="components-drop-zone"></div>
				<img src="<?php echo esc_url( wp_get_attachment_image_src( $featured_product_img_id, 'woocommerce_thumbnail', false )[0] ); ?>" alt="<?php echo esc_attr( get_the_title( $featured_product_img_id ) ); ?>" style="max-width:100%;" />
			</div>
			<button type="button" class="btn btn-secondary components-button is-secondary">Replace Image</button>
			<button type="button" class="components-button is-link is-destructive">Remove testimonial image</button>
		<?php else : ?>
			<div class="editor-product-featured-image__container">
				<button type="button" class="components-button editor-product-featured-image__toggle">Set featured product image</button>
				<div class="components-drop-zone">
				</div>
			</div>
			<button type="button" class="btn btn-secondary components-button is-secondary d-none">Replace Image</button>
			<button type="button" class="components-button is-link is-destructive d-none">Remove testimonial image</button>
		<?php endif; ?>
		<input type="hidden" class="featured-product-img-id" name="_featured_product_img_id" id="_featured_product_img_id" value="<?php echo esc_attr( $featured_product_img_id ); ?>" />
	</div>
	<?php
}

function get_featured_product_img_id( $post = null ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return '';
	}
	return (int) get_post_meta( $post->ID, '_featured_product_img_id', true );
}

function wonkasoft_featured_product_img_save_post() {
	$nonce = ( isset( $_REQUEST['woocommerce_meta_nonce'] ) ) ? esc_html( wp_unslash( $_REQUEST['woocommerce_meta_nonce'] ) ) : '';

	wp_verify_nonce( $nonce, 'woocommerce_save_data' ) || die( 'Your nonce has failed.' );

	global $post;
	$post_id    = $post->ID;
	$meta_key   = '_featured_product_img_id';
	$meta_value = ( isset( $_REQUEST['_featured_product_img_id'] ) ) ? esc_html( wp_unslash( $_REQUEST['_featured_product_img_id'] ) ) : '';

	update_post_meta( $post_id, $meta_key, $meta_value, '' );

}
add_action( 'save_post', 'wonkasoft_featured_product_img_save_post', 10 );
