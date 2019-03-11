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
						<div class="slider-slide">
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
					</div><!-- .slider-slide -->
					<?php endif; ?>

				<?php endforeach; ?>

			</div><!-- .top-page-slider -->

			</section><!-- .header-slider-section -->
		<?php endif; ?>

		<?php 

			do_action( 'get_mods_before_section', 'shop' );

			$shop_section = get_section_mods( 'shop' );
			if ( !empty( $shop_section->shop_mods->shop_title ) ) : 
		?>

			<section class="row shop-section align-items-center justify-content-center" style="background-image:url(<?php echo $shop_section->shop_mods->shop_background_image;?>), rgba( 255, 255, 255, 0.7 );">
				<div class="col col-12">
					<div class="row">
						<div class="col col-12 text-center">
							<h3 class="section-title shop-title"><?php echo $shop_section->shop_mods->shop_title; ?></h3>
						</div>
					</div>
					<div class="row align-items-center justify-content-center">
						<?php
							// $shop_shortcode = '[recent_products per_page="$shop_section->shop_mods->shop_num_of_products" columns="$shop_section->shop_mods->shop_product_per_row"]';
							$args = array(

							);
							$shop_shortcode = apply_filters( 'recent_products_shortcode_tag');
							echo do_shortcode( $shop_shortcode ); 
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
		if ( !empty( $cause_section->cause_mods->cause_section_title ) ) : ?>
			<section class="row our-cause-section">
				<div class="col col-12 text-center title-wrap">
					<h3 class="section-title our-cause-title"><?php echo $cause_section->cause_mods->cause_section_title; ?></h3>
				</div>
				<?php
				foreach ( $cause_section->causes as $cause ) :
				if ( !empty( $cause->img ) ) :
				?>
					<div class="col">
						<div class="cause-section-module">
							<div class="module-component-wrap">
								<img class="cause-img" src="<?php _e( $cause->img ); ?>" />
								<h3 class="cause-title text-<?php _e( $cause->position ); ?>"><?php _e( $cause->header ); ?></h3>
								<p class="cause-message text-<?php _e( $cause->position ); ?>"><?php _e( $cause->message ); ?></p>
							</div><!-- .module-component-wrap -->
						</div><!-- .cause-section-module -->
					</div>
				<?php endif; ?>
				<?php endforeach; ?>

			</section><!-- .our-cause-section -->
		<?php endif; ?>
		<?php do_action( 'get_mods_before_section', 'about' );
		$about_section = get_section_mods( 'about' );

		if ( !empty( $about_section ) ) : ?>
			<section class="row about-brand-section">
				<div class="col col-12 col-md-6">
					<h2 class="about-brand-header"><?php _e( $about_section->about_the_brand->about_header ); ?></h2>
					<h4 class="about-brand-subheader"><?php _e( $about_section->about_the_brand->about_subheader ); ?></h4>
					<p class="about-brand-message"><?php _e( $about_section->about_the_brand->about_message ); ?></p>
					<div class="about-brand-img"></div>
					<a class="btn btn-primary" href="<?php _e( $about_section->about_the_brand->about_the_brand_button_link ); ?>"><?php _e( $about_section->about_the_brand->about_the_brand_btn_text ); ?></a>
				</div>
				<div class="col col-12 col-md-5">
					<img class="about-second-image" src="<?php _e( $about_section->about_the_brand->about_the_brand_second_image ); ?>" />
				</div>
			</section>
		<?php endif; ?>

		<?php do_action( 'get_mods_before_section', 'social' );
		$social_section = get_section_mods( 'social' );

		if ( !empty( $social_section->social_mods->social_title ) ) : ?>
			<section class="row instagram-section">
				<div class="col col-12 text-center">
					<h3 class="section-title social-title"><?php _e( $social_section->social_mods->social_title ); ?></h3>
				</div> <!-- .col -->
				<div class="col col-12">
					<?php _e( do_shortcode( $social_section->social_mods->social_shortcode ) ); ?>
				</div>
				<div class="col col-12 shop-social-btn text-center">
					<a class="btn btn-lg btn-primary" href="<?php _e( $social_section->social_mods->social_shop_button);?>"><?php _e($social_section->social_mods->social_btn_text); ?></a>
				</div> <!-- .col -->
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
