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
		<?php 

		/* This can be used to filter slide object */
		do_action( 'get_mods_before_section', 'top' );
		
		/* This gets the slides as an object */
		$top_slider = get_section_mods( 'top' );

		/* This checks for slider object in order to parse slider section */
		if ( !empty( $top_slider ) ) : ?>
			<section class="row header-slider-section">
				<div class="top-page-slider">
				<?php 
				/* Foreach loop to build slider according to slides entered in the customizer */
				foreach ( $top_slider->slides as $slide ) :
					
					/* Checks for an img set in the slide object */
					if ( !empty( $slide->slide_img ) ) : ?>
						<div class="top-page-slide" style="background-image:url('<?php echo $slide->slide_img; ?>');">

							<?php 
							/* Checks for an message set in the slide object */
							if ( !empty( $slide->slide_header_message ) ) : ?>
								<div class="row img-header-text-wrap">
									<div class="col col-12 img-header-text-container">
										<div class="text-box text-center<?php $set_text_align = ( !empty( $slide->slide_text_position ) ) ? ' set-align-' . $slide->slide_text_position: ' set-align-center'; echo $set_text_align; ?>">
											<h2 class="img-header-text text-center"><?php echo $slide->slide_header_message; ?></h2>
											<?php
											/* Checks for an subheader set in the slide object */
											if ( !empty( $slide->slide_subheader ) ) : ?>
												<h4 class="img-subheader-text text-center"><?php echo $slide->slide_subheader; ?></h4>
											<?php endif; ?>
										</div><!-- .text-box -->
									</div><!-- .img-header-text-container -->

								</div><!-- .img-header-text-wrap -->
								
							<?php endif; ?>

						</div><!-- .top-page-slide -->
					<?php endif; ?>
					
				<?php endforeach; ?>

			</div><!-- .top-page-slider -->

			</section><!-- .header-slider-section -->
		<?php endif; ?>
		<?php if ( get_theme_mod( 'shop_num_of_products' ) && get_theme_mod( 'shop_product_per_row' ) ) : ?>
					<?php 
						$numofproducts = get_theme_mod( 'shop_num_of_products' );
						$productsperrow = get_theme_mod( 'shop_product_per_row' );
						$proshortcode = "[recent_products per_page='$numofproducts' columns='$productsperrow']"; ?>
			<section class="row shop-section align-items-center justify-content-center">
				<div class="col col-12">
					<div class="row">
						<div class="col col-12 text-center">
							<h3 class="shop-title">SHOP</h3>
						</div>
					</div>
					<div class="row align-items-center justify-content-center">
						<?php
							echo do_shortcode( $proshortcode ); 
						?>
					</div>
				</div>
			</section><!-- .shop-section -->
		<?php endif; ?>
		<?php do_action( 'get_mods_before_section', 'cta' );
			$cta_slider = get_section_mods( 'cta' );
			if ( !empty( $cta_slider ) ) : ?>
				<section class="row desirable-slider-section">
					<?php 
					/* Foreach loop to build slider according to slides entered in the customizer */
					foreach ( $cta_slider->slides as $slide ) :
						
						/* Checks for an img set in the slide object */
						if ( !empty( $slide->slide_img ) ) : ?>
							<div class="cta-section-slider" style="background-image:url('<?php echo $slide->slide_img; ?>');">

								<?php 
								/* Checks for an message set in the slide object */
								if ( !empty( $slide->slide_text_message ) ) : ?>
									<div class="row img-header-text-wrap">
										<div class="col col-12 img-header-text-container">
											<div class="text-box text-center<?php $set_text_align = ( !empty( $slide->slide_text_position ) ) ? ' set-align-' . $slide->slide_text_position: ' set-align-center'; echo $set_text_align; ?>">
												<h2 class="img-header-text text-center"><?php echo $slide->slide_text_message; ?></h2>
												<?php
												/* Checks for an subheader set in the slide object */
												if ( !empty( $slide->slide_link ) ) : ?>
													<a href="<?php echo $slide->slide_link; ?>" class="btn btn-primary img-cta-link text-center"><?php _e( $slide->slide_link_btn ); ?></a>
												<?php endif; ?>
											</div><!-- .text-box -->
										</div><!-- .img-header-text-container -->

									</div><!-- .img-header-text-wrap -->
									
								<?php endif; ?>

							</div><!-- .col-12 -->
						<?php endif; ?>
					<?php endforeach; ?>

				</section><!-- .desirable-slider-section -->
		<?php endif; ?>
		<?php do_action( 'get_mods_before_section', 'cause' );
		$cause_section = get_section_mods( 'cause' );

		/* Check for Cause object */
		if ( !empty( $cause_section ) ) : ?>
			<section class="row our-cause-section">
				<div class="col col-12 text-center title-wrap">
					<h3 class="our-cause-title">Our Cause</h3>
				</div>
				<?php
				foreach ( $cause_section->causes as $cause ) :
				if ( !empty( $cause->cause_img ) ) :
				?>
					<div class="col">
						<div class="cause-section-module">
							<div class="module-component-wrap">
								<img class="cause-img" src="<?php _e( $cause->cause_img ); ?>" />
								<h3 class="cause-title text-<?php _e( $cause->cause_message_position ); ?>"><?php _e( $cause->cause_header ); ?></h3>
								<p class="cause-message text-<?php _e( $cause->cause_message_position ); ?>"><?php _e( $cause->cause_message ); ?></p>
							</div><!-- .module-component-wrap -->
						</div><!-- .cause-section-module -->
					</div>
				<?php endif; ?>
				<?php endforeach; ?>

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
