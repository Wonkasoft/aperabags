<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package Apera_Bags
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
 *
 * @return void
 */
defined( 'ABSPATH' ) || exit;

function apera_bags_woocommerce_setup() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'apera_bags_woocommerce_setup' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function apera_bags_woocommerce_scripts() {
	wp_enqueue_style( 'apera-bags-woocommerce-style', get_template_directory_uri() . '/woocommerce.css' );

	$font_path   = WC()->plugin_url() . '/assets/fonts/';
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
add_action( 'wp_enqueue_scripts', 'apera_bags_woocommerce_scripts' );

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
	 * Product columns wrapper.
	 *
	 * @return  void
	 */
	function apera_bags_woocommerce_product_columns_wrapper() {
		$columns = apera_bags_woocommerce_loop_columns();
		echo '<div class="row wonka-row row-columns-' . absint( $columns ) . '">';
	}
}
add_action( 'woocommerce_before_shop_loop', 'apera_bags_woocommerce_product_columns_wrapper', 40 );

if ( ! function_exists( 'apera_bags_woocommerce_product_columns_wrapper_close' ) ) {
	/**
	 * Product columns wrapper close.
	 *
	 * @return  void
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
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function apera_bags_woocommerce_wrapper_before() {
		global $post;
		$post_type = ( !empty( $post->post_type ) ) ? ' main-' . $post->post_type: '';
		$post_slug = ( !empty( $post->post_name ) ) ? ' main-' . $post->post_name: '';
		?>
		<div id="primary" class="content-area">
			<main id="main" class="site-main<?php _e( $post_slug ); _e( $post_type ); ?>" role="main">
				<?php
			}
		}
		add_action( 'woocommerce_before_main_content', 'apera_bags_woocommerce_wrapper_before' );

		if ( ! function_exists( 'apera_bags_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
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
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function apera_bags_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		apera_bags_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}

add_filter( 'woocommerce_add_to_cart_fragments', 'apera_bags_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'apera_bags_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function apera_bags_woocommerce_cart_link() {
		?>
		<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'apera-bags' ); ?>">
			<?php
			$item_count_text = sprintf(
				/* translators: number of items in the mini cart. */
				_n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'apera-bags' ),
				WC()->cart->get_cart_contents_count()
			);
			?>
			<span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span> <span class="count"><?php echo esc_html( $item_count_text ); ?></span>
		</a>
		<?php
	}
}

/**
 * This sets up the image flipper class
 * @param  array $classes contains all the classes for the current product
 * @return array $classes posts all classes to the current product.
 */
function setting_up_image_flipper_class( $classes ) {
	global $product;
	$post_type = get_post_type( get_the_ID() );
		if ( ! is_admin() ) {
			if ( $post_type == 'product' ) {
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
 * 
 */
function wonka_customized_shop_loop() {
	/*========================================================
	=            For setting up the image flipper            =
	========================================================*/
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
		$attachment_ids     = array_values( $attachment_ids );
		$secondary_image_id = $attachment_ids['0'];
		$secondary_image_alt = get_post_meta( $secondary_image_id, '_wp_attachment_image_alt', true );
		$secondary_image_title = get_the_title($secondary_image_id);
	endif;

	/*=====  End of For setting up the image flipper  ======*/
	
	$output = '';
	$output .= '<div class="wonka-shop-img-wrap">';
	$output .= '<img src="' . esc_url( get_the_post_thumbnail_url( get_the_ID(), 'full' ) ) . '" class="img-fluid wonka-img-fluid" />';
	if ( $attachment_ids ) :
		$output .= '<img src="' . esc_url( wp_get_attachment_url( $secondary_image_id ) ) . '" title="' . $secondary_image_title . '" alt="' . $secondary_image_alt . '" class="secondary-image attachment-shop-catalog wp-post-image wp-post-image--secondary" />';
	endif;
	$output .= '</div><!-- .wonka-shop-img-wrap -->';

	_e( $output );
}

if ( !get_theme_mod( 'enable_sale_banner' ) ) :
	remove_filter( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
endif;
remove_filter( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_filter( 'woocommerce_before_shop_loop_item_title', 'wonka_customized_shop_loop', 11 );

/* removing the side bar */
remove_filter( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/**
 * Changes the description tab title
 * @param  array $tabs setting up the changed titles
 * @return 
 */
function wonka_product_tabs_retitle( $tabs ) {
	
	$new_title = get_post_meta( get_the_ID(), 'product_statement', true );
	$tabs['reviews']['priority'] = 10;			// Reviews first
	$tabs['description']['priority'] = 20;			// Description second
	unset( $tabs['additional_information'] );	// Additional information third
	$tabs['description']['title'] = __( $new_title );

	return $tabs;
}

add_filter( 'woocommerce_product_tabs', 'wonka_product_tabs_retitle', 98 );

/**
 * This is for moving the cross sells items on the cart page setting the display of how many items and columns to show
 * 
 */
function wonka_cart_cross_sells() {

	add_filter( 'woocommerce_cross_sells_columns', function() {
		return 3;
	} );
	add_filter( 'woocommerce_cross_sells_total', function() {
		return 3;
	} );
}

add_action( 'woocommerce_after_cart', 'wonka_cart_cross_sells', 10 );
add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display' );


function wonka_add_continue_shopping_notice_to_cart() {
	$shopping = sprintf( '<div class="return-shopping-wrap"><i class="fa fa-long-arrow-left"></i> <a href="%s" class="continue-shopping">%s</a></div>', esc_url( '/shop' ), esc_html__( 'Continue shopping', 'woocommerce' ) );

	echo $shopping;
}
add_action( 'woocommerce_before_cart', 'wonka_add_continue_shopping_notice_to_cart' );

function wonka_checkout_remove_actions() {
	remove_action( 'woocommerce_before_checkout_form',  array( 'Angelleye_PayPal_Express_Checkout_Helper', 'angelleye_display_custom_message_review_page' ), 5 );
	remove_action( 'woocommerce_before_checkout_form', array( 'Angelleye_PayPal_Express_Checkout_Helper', 'checkout_message' ), 5 );
	remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
	remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
	add_action( 'wonka_checkout_login_form', 'woocommerce_checkout_login_form', 10 );
}

add_action( 'plugins_loaded', 'wonka_checkout_remove_actions', 99 );

function wonka_checkout_wrap_before( $checkout ) {
	$output = '';
	$output .= '<div class="row wonka-checkout-row">';
	$output .= '<div class="col col-12 col-md-7 checkout-form-left-side">';

	_e( $output );
}

add_action( 'woocommerce_before_checkout_form', 'wonka_checkout_wrap_before', 25, 1 );

function wonka_thwmsc_multi_step_before_tab_panels( $checkout ) {
// 	add_action( 'wonka_checkout_express_btns', array( 'Angelleye_PayPal_Express_Checkout_Helper', 'angelleye_display_custom_message_review_page' ), 5 );
// add_action('wonka_checkout_express_btns', array( 'Angelleye_PayPal_Express_Checkout_Helper', 'checkout_message' ), 5 );
	ob_start();
	$output = '';

	$output .= '<div class="row wonka-row-express-checkout-btns">';
	$output .= '<div class="col col-12">';
	$output .= '<div class="express-checkout-btns"><span class="express-btns-text">' . __( 'Express checkout', 'aperabags') . '</span>';
	$output .= do_action( 'wonka_checkout_express_btns' );
	$output .= '</div>';
	$output .= '</div>';
	$output .= '<div class="col col-12">';
	$output .= '<div class="row below-express-checkout-btns no-gutters"><div class="col"><hr /></div><div class="col"><span class="continue-past-btns-text">' . __( 'Or continue below to pay with a credit card', 'aperabags') . '</span></div><div class="col"><hr /></div></div>';
	$output .= '</div>';
	$output .= '</div>';

	$output .= ob_get_clean();
	_e( $output ); 
	do_action( 'wonka_checkout_login_form' );

}
add_action( 'thwmsc_multi_step_before_tab_panels', 'wonka_thwmsc_multi_step_before_tab_panels', 4 );

function wonka_before_checkout_shipping_form( $checkout ) {
	_e( '<h5 class="wonka-contact-information">Contact Information</h5>', 'aperabags' );
	$fields = $checkout->get_checkout_fields( 'billing' );

	foreach ( $fields as $key => $field ) :
		if ( strtolower( $key ) === 'billing_email' ) :
			if ( !isset($field['placeholder'] ) ) :
				$field['placeholder'] = $field['label'];
			endif;

			if ( isset( $field['class'] ) ) :
				$field['class'] = array( 'wonka-form-group' ) ;
			else:
				$field['class'] = array( 'wonka-form-group' );
			endif;

			if ( isset( $field['label_class'] ) ) :
				array_push( $field['label_class'], 'wonka-sr-only', 'sr-only' ) ;
			else:
				$field['label_class'] = array( 'wonka-sr-only', 'sr-only' );
			endif;

		woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
		endif;
	endforeach; ?>
	<p class="wonka-form-check checkbox">
		<label for="mc4wp-subscribe">
			<input type="checkbox" class="wonka-checkbox form-checkbox" name="mc4wp-subscribe" checked="checked" value="1" />
			Keep me up to date on news and exclusive offers.	</label>
	</p>
<?php
}
add_action( 'woocommerce_before_checkout_shipping_form', 'wonka_before_checkout_shipping_form', 15 );

/**
 * This builds a custom table of order details on the checkout page.
 * @param  [type] $checkout [description]
 * 
 */
function wonka_checkout_wrap_after( $checkout ) {
	?>
		</div><!-- .col -->
		<div class="col col-12 col-md-5 checkout-order-details">
			<table class="table table-hover">
				<tbody>
					<?php
						do_action( 'woocommerce_review_order_before_cart_contents' );
						foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
							$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
							if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
								?>
								<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
									<td class="product-thumbnail">
									<?php
									$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

									if ( ! $product_permalink ) {
										echo $thumbnail; // PHPCS: XSS ok.
										echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity badge wonka-badge">' . sprintf( '%s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key );
									} else {
										printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
									}
									?>
									</td>
									<td class="product-name">
										<?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;'; ?>
										
										<?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>
									</td>
									<td class="product-total">
										<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
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
						<th><?php _e( 'Subtotal', 'woocommerce' ); ?></th>
						<td colspan="2"><?php wc_cart_totals_subtotal_html(); ?></td>
					</tr>

					<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
						<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
							<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
							<td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
						</tr>
					<?php endforeach; ?>

					<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

						<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

						<?php wc_cart_totals_shipping_html(); ?>

						<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

					<?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>

						<tr class="shipping">
							<th scope="row" colspan="1"><?php _e( 'Shipping', 'woocommerce' ); ?></th>
							<td colspan="2"><?php _e( '(Shipping only within the US)', 'woocommerce' ); ?></td>
						</tr>
						<tr class="shipping-methods">
							<td></td>
							<td colspan="2" data-title="<?php esc_attr_e( 'Shipping', 'woocommerce' ); ?>"><?php woocommerce_shipping_calculator(); ?></td>
						</tr>

					<?php endif; ?>

					<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
						<tr class="fee">
							<th><?php echo esc_html( $fee->name ); ?></th>
							<td colspan="2"><?php wc_cart_totals_fee_html( $fee ); ?></td>
						</tr>
					<?php endforeach; ?>

					<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
						<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
							<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
								<tr class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
									<th><?php echo esc_html( $tax->label ); ?></th>
									<td><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
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
		</div><!-- .col-12 -->
		</div><!-- .row -->
		<?php
}

add_action( 'woocommerce_after_checkout_form', 'wonka_checkout_wrap_after', 50, 1 );

/**
 * This filters the display of the single product page image parse.
 * 
 */
function wonka_single_product_display() {
	global $product;

	// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
	if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
		return;
	}

	$output = '';
	$output .= '<img src="' . esc_url( get_the_post_thumbnail_url( $product->get_data()['id'], 'full' ) ) . '" class="img-fluid wonka-img-fluid" />';

	$attachment_ids = $product->get_gallery_image_ids();

	if ( $attachment_ids && $product->get_image_id() ) {
		foreach ( $attachment_ids as $attachment_id ) {
			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', wc_get_gallery_image_html( $attachment_id ), $attachment_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped
		}
	}

	_e( $output );

}

// remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
// add_action( 'woocommerce_before_single_product_summary', 'wonka_single_product_display', 20 );

/**
 * Remove Sku info only for users. Sku will still show for admins
 *
 * @since  1.0.0
 * 
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
 * @param  array $options Contains options that are being passed to the slider
 * @return [type]          [description]
 */
function wonka_product_carousel_options($options) {
  $options['animation'] = 'slide';
  $options['animationSpeed'] = 1200;
  $options['useCSS'] = true;
  $options['easing'] = 'swing';
  $options['direction'] = 'vertical';
  return $options;
}

add_filter("woocommerce_single_product_carousel_options", "wonka_product_carousel_options", 10);

/**
 * This adds custom meta fields to the product edit interface
 * @param  int $post_id contains the post id for current product
 * 
 */
function wonka_product_meta_add( $post_id ) {

	$product_statement = ( get_metadata( 'product', $post_id, 'product_statement' ) ) ? get_metadata( 'product', $post_id, 'product_statement', true ): '';

	$product_specs = ( get_metadata( 'product', $post_id, 'product_specs' ) ) ? get_metadata( 'product', $post_id, 'product_specs', true ): '';

	$key_features = ( get_metadata( 'product', $post_id, 'key_features' ) ) ? get_metadata( 'product', $post_id, 'key_features', true ): '';

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

function wonka_woo_add_custom_general_fields( $product_type ) {
	if( isset($product_type) && !empty($product_type) ) {
	    $product_type['enable_wonka_express_button'] = array(
	            'id'            => '_enable_wonka_express_button',
	            'wrapper_class' => '',
	            'label'         => __( 'Enable Wonka Express Checkout Button', 'aperabags' ),
	            'description'   => __( 'Adds the Wonka Express Checkout button to the product page allowing buyers to go directly to the checkout directly from the product page.', 'aperabags' ),
	            'default'       => 'yes'
	    );
	    return $product_type;
	} else {
	        return $product_type;
	}
	
}
add_action( 'product_type_options', 'wonka_woo_add_custom_general_fields' );

/**
 * This adds a custom express checkout button to the product page
 * @return [type] [description]
 */
function wonka_express_checkout_add() {
	global $post;
	$post_id = get_the_ID();
	if ( get_post_meta( $post_id, '_enable_wonka_express_button', true ) === 'yes' ) :
	?>
	<div class="wonka-express-checkout-wrap">
		<a href="#" class="wonka-btn">Express Checkout</a>
	</div>
	<?php
	endif;
}
	
add_action( 'woocommerce_after_add_to_cart_button', 'wonka_express_checkout_add', 10 );

/**
 * This is for adding the opening tags for a wrap around the reviews meta data
 * @param  object $comment contains review data
 * @return [type]          [description]
 */
function wonka_before_comment_meta_add( $comment ) {
	?>
		<div class="wonka-rating-and-meta-wrap col-4">
		<?php
		/**
		 * The woocommerce_review_before hook
		 *
		 * @hooked woocommerce_review_display_gravatar - 10
		 */
		do_action( 'woocommerce_review_before', $comment );
		?>
	<?php
}
add_action( 'woocommerce_review_before_comment_meta', 'wonka_before_comment_meta_add', 5 );

function wonka_before_comment_text_add( $comment ) {
	?>
		</div><!-- .wonka-rating-and-meta-wrap -->
		<div class="wonka-review-text-wrap col-7">
	<?php
}
add_action( 'woocommerce_review_before_comment_text', 'wonka_before_comment_text_add', 5 );

function wonka_after_comment_text_add( $comment ) {
	?>
		</div><!-- .wonka-review-text-wrap -->
	<?php
}
add_action( 'woocommerce_review_after_comment_text', 'wonka_after_comment_text_add', 5 );
