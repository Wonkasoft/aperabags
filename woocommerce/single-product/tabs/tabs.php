<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $product_tabs ) ) : ?>
	<section class="product-tabs-section">
	<div class="wonka-tabs wonka-tabs-wrapper">
		<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
			<?php if ( ! empty( $product_tab['section'] ) ) : ?>
				<?php
				$serialize_section_title = str_replace( ' ', '-', strtolower( $product_tab['section'] ) );
				if ( 'reviews' === $serialize_section_title && wc_review_ratings_enabled() || 'reviews' !== $serialize_section_title ) :
					?>
				<section id="section-<?php echo esc_attr( $serialize_section_title ); ?>" class="wonka-section wonka-section-<?php echo esc_attr( $serialize_section_title ); ?>">
					<div class="wonka-Tabs-panel wonka-Tabs-panel--<?php echo esc_attr( $serialize_section_title ); ?> panel entry-content" id="tab-<?php echo esc_attr( $serialize_section_title ); ?>" aria-data="tab-title-<?php echo esc_attr( $serialize_section_title ); ?>">
						<?php
						if ( isset( $product_tab['callback'] ) ) {
							call_user_func( $product_tab['callback'], $key, $product_tab ); }
						?>
					</div>
				</section>
					<?php
				endif;
				else :
					?>
				<section id="section-<?php echo esc_attr( $key ); ?>" class="wonka-section wonka-section-<?php echo esc_attr( $key ); ?>">
					<div class="wonka-Tabs-panel wonka-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content" id="tab-<?php echo esc_attr( $key ); ?>" aria-data="tab-title-<?php echo esc_attr( $key ); ?>">
						<?php
						if ( isset( $product_tab['callback'] ) ) {
							call_user_func( $product_tab['callback'], $key, $product_tab ); }
						?>
					</div>
				</section>
				<?php endif; ?>
		<?php endforeach; ?>
	</div>
	</section>
<?php endif; ?>
