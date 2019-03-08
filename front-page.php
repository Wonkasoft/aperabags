<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Apera_Bags
 */

get_header();
?>
	<?php if ( is_home() ) : ?>
		<?php if ( get_theme_mod( 'top_slider_class' ) ) : ?>
			<section class="row header-slider-section">
				<div class="<?php echo get_theme_mod( 'top_slider_class' ); ?>" style="background:url('<?php echo get_theme_mod( 'slider_1' ); ?>');">
					<?php echo get_theme_mod( 'slider_text_position_1' ); ?>
				</div><!-- .col-12 -->
			</section><!-- .header-slider-section -->
		<?php endif; ?>
		<?php if ( get_theme_mod( 'shop_num_of_products' ) && get_theme_mod( 'shop_product_per_row' ) ) : ?>
			<section class="row shop-section">
				<div class="col text-center">
					<h3 class="shop-title">SHOP</h3>
					<div class="product-grid">
					<?php 
						$numofproducts = get_theme_mod( 'shop_num_of_products' );
						$productsperrow = get_theme_mod( 'shop_product_per_row' );
						$proshortcode = "[recent_products per_page='$numofproducts' columns='$productsperrow']";
						echo do_shortcode( $proshortcode ); 
					?>
					</div> <!-- .product-grid -->
				</div>
			</section><!-- .shop-section -->
		<?php endif; ?>
		<?php if ( get_theme_mod( 'cta_slider_1' ) ) : ?>
			<section class="row desirable-slider-section text-<?php echo get_theme_mod( 'cta_slider_text_position_1' );?>" style="background:url('<?php echo get_theme_mod( 'cta_slider_1' ); ?>');">
				<div class="desirable-section-message">
					<?php echo get_theme_mod( 'cta_slider_text_1' ); ?>
			</section><!-- .desirable-slider-section -->
		<?php endif; ?>
		<?php if ( get_theme_mod( 'cause_option_1' ) ) : ?>
			<section class="row our-cause-section">
				<div class="col text-center">
					<h3 class="our-cause-title">Our Cause</h3>
				</div>
			</section><!-- .our-cause-section -->
		<?php endif; ?>
		<?php if ( get_theme_mod( 'social_shortcode' ) ) : ?>
			<section class="row instagram-section">
				<div class="col">
					<?php 
					$social_short = get_theme_mod( 'social_shortcode' );
					echo do_shortcode( $social_short ); ?>
				</div>
			</section><!-- .instagram-section -->
		<?php endif; ?>
	<?php else: ?>
		<div id="primary" class="content-area row">
			<main id="main" class="site-main col col-12">
			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

			</main><!-- #main .col-12 -->
		</div><!-- #primary .row -->
	<?php endif; ?>

<?php
get_footer();
