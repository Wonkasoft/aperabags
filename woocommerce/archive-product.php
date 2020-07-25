<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
add_action( 'wonkasoft_moved_breadcrumb', 'woocommerce_breadcrumb', 10 );

do_action( 'woocommerce_before_main_content' );
$header_bg = get_stylesheet_directory_uri() . '/assets/img/shop-header.jpeg';
global $wp_query;
$cat = $wp_query->get_queried_object()->name;

if ( 'Accessories' === $cat || 'Backpacks' === $cat || 'Duffels' === $cat || 'Totes' === $cat ) :
	$cat_id       = $wp_query->get_queried_object()->term_id;
	$thumbnail_id = get_woocommerce_term_meta( $cat_id, 'thumbnail_id', true );
	$src          = wp_get_attachment_image_src( $thumbnail_id, 'full', false );
	$header_bg    = $src[0];
endif;

?>
<header class="woocommerce-products-header">
	<div class="breadcrumb-title-wrap" style="background-image: url( '<?php echo esc_url( $header_bg ); ?>' );">
	<?php
		do_action( 'wonkasoft_moved_breadcrumb' );
	if ( apply_filters( 'woocommerce_show_page_title', true ) ) :
		?>
		<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
	<?php endif; ?>
	</div>
</header>
<div class="shop-content-container">
	<?php
	/**
	 * Hook: woocommerce_archive_description.
	 *
	 * @hooked woocommerce_taxonomy_archive_description - 10
	 * @hooked woocommerce_product_archive_description - 10
	 */
	do_action( 'woocommerce_archive_description' );
	?>
<?php
if ( woocommerce_product_loop() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	do_action( 'woocommerce_before_shop_loop' );

	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {
		global $wp_query;
		if ( 'product' === $wp_query->get_queried_object()->name ) :
			$added_classes = array(
				'col',
				'col-6',
				'col-sm-4',
				'shop-box-text',
			);
			?>
			<li <?php wc_product_class( $added_classes ); ?>>
				<div class="wonka-shop-img-wrap">
					<h2>Engineered to perform.<br />Built to last.</h2>
					<p>
						Shop gym bags that meet the same high standards as your workout. Separate pockets for your shoes, gear, and technology.
					</p>
					<p>
						Antimicrobial materials and lifetime guarantee.
					</p>
				</div>
			</li><!-- END li -->
			<?php
		endif;
		while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 *
			 * @hooked WC_Structured_Data::generate_product_data() - 10
			 */
			do_action( 'woocommerce_shop_loop' );

			wc_get_template_part( 'content', 'product' );
		}
	}

	woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );
} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}
?>
</div>
<?php
/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/* removing sidebar for the products archive page */
remove_filter( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );
