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
		?>
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
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
 * Image Flipper class
 */
if ( ! class_exists( 'WC_pif' ) ) {
	class WC_pif 
	{
		public function __construct() {
			add_action( 'init', array( $this, 'pif_init' ) );
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'woocommerce_template_loop_second_product_thumbnail' ), 11 );
			add_filter( 'post_class', array( $this, 'product_has_gallery' ) );
		}
		/**
		 * Plugin initilisation
		 */
		public function pif_init() {
			load_plugin_textdomain( 'woocommerce-product-image-flipper', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}
		
		public function product_has_gallery( $classes ) {
			global $product;
			$post_type = get_post_type( get_the_ID() );
			if ( ! is_admin() ) {
				if ( $post_type == 'product' ) {
					$attachment_ids = $this->get_gallery_image_ids( $product );
					if ( $attachment_ids ) {
						$classes[] = 'pif-has-gallery';
					}
				}
			}
			return $classes;
		}
		/**
		 * Frontend functions
		 */
		public function woocommerce_template_loop_second_product_thumbnail() {
			global $product, $woocommerce;
			$attachment_ids = $this->get_gallery_image_ids( $product );
			if ( $attachment_ids ) {
				$attachment_ids     = array_values( $attachment_ids );
				$secondary_image_id = $attachment_ids['0'];
				$secondary_image_alt = get_post_meta( $secondary_image_id, '_wp_attachment_image_alt', true );
				$secondary_image_title = get_the_title($secondary_image_id);
				echo wp_get_attachment_image(
					$secondary_image_id,
					'shop_catalog',
					'',
					array(
						'class' => 'secondary-image attachment-shop-catalog wp-post-image wp-post-image--secondary',
						'alt' => $secondary_image_alt,
						'title' => $secondary_image_title
					)
				);
			}
		}
		/**
		 * WooCommerce Compatibility Functions
		 */
		public function get_gallery_image_ids( $product ) {
			if ( ! is_a( $product, 'WC_Product' ) ) {
				return;
			}
			if ( is_callable( 'WC_Product::get_gallery_image_ids' ) ) {
				return $product->get_gallery_image_ids();
			} else {
				return $product->get_gallery_attachment_ids();
			}
		}
	}

	
	/* This is the init for this class */
	$WC_pif = new WC_pif();
}

/**
 * This function is to override the parsing of the images during a shop loop
 * 
 */
function wonka_customized_shop_loop() {
	$output = '';
	ob_start();
	$output .= '<div class="wonka-shop-img-wrap">';
	$output .= '<img src="' . esc_url( get_the_post_thumbnail_url( get_the_ID(), 'full' ) ) . '" class="img-fluid wonka-img-fluid" />';
	$output .= '</div><!-- .wonka-shop-img-wrap -->';
	ob_end_clean();

	_e( $output );
}

if ( !get_theme_mod( 'enable_sale_banner' ) ) :
	remove_filter( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
endif;
remove_filter( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_filter( 'woocommerce_before_shop_loop_item_title', 'wonka_customized_shop_loop', 5 );