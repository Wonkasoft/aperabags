<?php
/**
 * Description tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;

$heading = esc_html( apply_filters( 'woocommerce_product_description_heading', __( get_post_meta( get_the_ID(), 'product_statement', true ), 'woocommerce' ) ) ); ?>
<?php if ( $heading ) : ?>
	<div class="row wonka-row wonka-product-statement-header">
		<div class="col text-center">
			<h2 class="wonka wonka-h2"><?php echo $heading; ?></h2>
		</div><!-- .col -->
	</div><!-- .row -->
<?php endif; ?>

<div class="row wonka-row-">
	<div class="col text-center">
			<?php the_content(); ?>
	</div>
</div>
