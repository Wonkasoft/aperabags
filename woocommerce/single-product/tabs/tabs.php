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
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $tabs ) ) : ?>

	<div class="wonka-tabs wonka-tabs-wrapper">
		<?php foreach ( $tabs as $key => $tab ) : ?>
			<?php if ( $key === 'reviews' ) : ?>
				<section class="wonka-section wonka-section-<?php echo esc_attr( $key ); ?>">
					<div class="wonka-Tabs-panel wonka-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content" id="tab-<?php echo esc_attr( $key ); ?>" aria-data="tab-title-<?php echo esc_attr( $key ); ?>">
						<?php if ( isset( $tab['callback'] ) ) { call_user_func( $tab['callback'], $key, $tab ); } ?>
					</div>
				</section>
			<?php else: 
				$serial_title = str_replace(' ', '-', strtolower( $tab['title'] ) );
				?>
				<section class="wonka-section wonka-section-<?php echo esc_attr( $serial_title ); ?>">
					<div class="wonka-Tabs-panel wonka-Tabs-panel--<?php echo esc_attr( $serial_title ); ?> panel entry-content" id="tab-<?php echo esc_attr( $serial_title ); ?>" aria-data="tab-title-<?php echo esc_attr( $serial_title ); ?>">
						<?php if ( isset( $tab['callback'] ) ) { call_user_func( $tab['callback'], $key, $tab ); } ?>
					</div>
				</section>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>

<?php endif; ?>