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
				<div class="top-page-slider-wrap">
				<?php 
				/* Foreach loop to build slider according to slides entered in the customizer */
				foreach ( $top_slider->slides as $slide ) :
					
					/* Checks for an img set in the slide object */
					if ( !empty( $slide->slide_img ) ) : ?>
						<div class="top-page-slide">
							<?php
							if ( wp_is_mobile() ) :
							?>
							<div class="top-slide-img-holder" style="background-image:url('<?php echo $slide->slide_mobile_img; ?>');">
								<?php
							else:
								?>
							<div class="top-slide-img-holder" style="background-image:url('<?php echo $slide->slide_img; ?>');">
							<?php 
							endif;
							/* Checks for an message set in the slide object */
							if ( ! empty( $slide->slide_header_message ) ) : ?>
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
							</div><!-- .top-slide-img-holder -->
						</div><!-- .top-page-slide -->
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

			<section class="row shop-section align-items-center justify-content-center" style="background-image:url(<?php echo esc_url( $shop_section->shop_mods->shop_background_image );?>);">
				<div class="col col-12">
					<div class="row">
						<div class="col col-12 text-center">
							<h3 class="section-title shop-title"><?php _e( $shop_section->shop_mods->shop_title ); ?></h3>
						</div>
					</div>
					<div class="row">
						<div class="col col-12">
							<?php
								$shop_shortcode = '[products limit="' . $shop_section->shop_mods->shop_num_of_products . '" columns="' . $shop_section->shop_mods->shop_product_per_row . '" visibility="featured"]';
								echo do_shortcode( $shop_shortcode );
							?>
						</div><!-- .col-12 -->
					</div><!-- .row -->
					<div class="row">
						<div class="col col-12 text-center">
							<a href="/shop" class="wonka-btn" target="_self"><?php _e( __( 'Shop All' ) ) ?></a>
						</div><!-- .col -->
					</div><!-- .row -->
				</div><!-- .col-12 -->
			</section><!-- .shop-section -->
		<?php endif; ?>
		<?php do_action( 'get_mods_before_section', 'cta' );
			$cta_slider = get_section_mods( 'cta' );
			if ( !empty( $cta_slider ) ) : ?>
				<section class="row desirable-slider-section">
					<div class="cta-section-slider-wrap">
					<?php 
					/* Foreach loop to build slider according to slides entered in the customizer */
					foreach ( $cta_slider->slides as $slide ) :
						
						/* Checks for an img set in the slide object */
						if ( !empty( $slide->slide_img ) ) : ?>
							<div class="cta-section-slide">
								<?php
								if ( wp_is_mobile ) :
								?>
								<div class="cta-slide-img-holder" style="background-image:url('<?php echo $slide->slide_img; ?>');">
								<?php
								else:
								?>
								<div class="cta-slide-img-holder" style="background-image:url('<?php echo $slide->slide_img; ?>');">
								<?php
								endif;
								/* Checks for an message set in the slide object */
								if ( !empty( $slide->slide_text_message ) ) : ?>
									<div class="row img-header-text-wrap">
										<div class="col col-12 img-header-text-container">
											<div class="text-box text-center<?php $set_text_align = ( !empty( $slide->slide_text_position ) ) ? ' set-align-' . $slide->slide_text_position: ' set-align-center'; echo $set_text_align; ?>">
												<h2 class="img-header-text text-center"><?php echo $slide->slide_text_message; ?></h2>
												<?php
												/* Checks for an subheader set in the slide object */
												if ( !empty( $slide->slide_link ) ) : ?>
													<a href="<?php echo $slide->slide_link; ?>" class="btn btn-primary wonka-btn img-cta-link text-center"><?php _e( $slide->slide_link_btn ); ?></a>
												<?php endif; ?>
											</div><!-- .text-box -->
										</div><!-- .img-header-text-container -->

									</div><!-- .img-header-text-wrap -->
									
								<?php endif; ?>

								</div><!-- .cta-slide-img-holder -->
							</div><!-- .cta-section-slide -->
						<?php endif; ?>
					<?php endforeach; ?>
					</div><!-- .cta-section-slider-wrap -->
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
						<div class="col col-12 col-md-4">
							<div class="cause-section-module">
								<div class="module-component-wrap">
									<div class="img-container">
										<img class="cause-img img-fluid" src="<?php _e( $cause->img ); ?>" />
									</div>
									<h3 class="cause-title text-<?php _e( $cause->position ); ?>"><?php _e( $cause->header ); ?></h3>
									<p class="cause-message text-<?php _e( $cause->position ); ?>"><?php _e( $cause->message ); ?></p>
								</div><!-- .module-component-wrap -->
							</div><!-- .cause-section-module -->
						</div>
					<?php endif; ?>
					<?php endforeach; ?>
		<?php endif; ?>

		<?php
		if ( ! empty( $cause->cause_modal_video ) ) : ?>
			
		<!-- Modal -->
			<div class="modal fade" id="videoModalpop" tabindex="-1" role="dialog" aria-labelledby="causeAperaModal" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-body">
			        <!-- 16:9 aspect ratio -->
					<div class="embed-responsive embed-responsive-16by9">
					<iframe width="780" height="442" src="https://www.youtube.com/embed/<?php _e( $cause->cause_modal_video ); ?>?mode=opaque&amp;rel=0&amp;autohide=1&amp;showinfo=0&amp;wmode=transparent" frameborder="0" allow="accelerometer; autoplay; gyroscope;" allowfullscreen></iframe>
					</div>
			       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">X</span>
			        </button>        
			      </div>
			    </div>
			  </div>
			</div> 
		<?php endif; ?>
			</section><!-- .our-cause-section -->


		<?php do_action( 'get_mods_before_section', 'about' );
		$about_section = get_section_mods( 'about' );

		if ( !empty( $about_section ) ) : ?>
			<section class="row about-brand-section align-items-center justify-content-around">
				<div class="col col-12 col-md-6 text-center">
					<div class="about-components-wrap">
						<h2 class="about-brand-header"><?php _e( $about_section->about_the_brand->about_header ); ?></h2>
						<h4 class="about-brand-subheader"><?php _e( $about_section->about_the_brand->about_subheader ); ?></h4>
						<p class="about-brand-message"><?php _e( $about_section->about_the_brand->about_message ); ?></p>
						<div class="about-brand-video">
							<?php
							$videoplaceholder = ( get_theme_mod( 'about_the_brand_video_placeholder' ) ) ? get_theme_mod( 'about_the_brand_video_placeholder' ) : '';
							$videocode = ( get_theme_mod( 'about_the_brand_video' ) ) ? get_theme_mod( 'about_the_brand_video' ) : '';
							if ( ! empty( $videoplaceholder ) ) :
							?>
							<a href="#" data-toggle="modal" data-src="https://www.youtube.com/embed/<?php _e( $videocode ); ?>?mode=opaque&amp;rel=0&amp;autohide=1&amp;showinfo=0&amp;wmode=transparent" data-target="#videoModal" class="video-img-link">
								<img src="<?php _e( $videoplaceholder ); ?>" />
								<span data-toggle="modal" data-target="#videoModal" class="video-img-symbol-link"><i class="fa fa-play-circle"></i></span>
							</a>
							
							<?php
								endif;
								?>
						</div>
						<?php
						if ( ! empty( $videoplaceholder ) ) : ?>
							
						<!-- Modal -->
							<div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="aboutAperaModal" aria-hidden="true">
							  <div class="modal-dialog" role="document">
							    <div class="modal-content">
							      <div class="modal-body">
							        <!-- 16:9 aspect ratio -->
									<div class="embed-responsive embed-responsive-16by9">
									<iframe width="780" height="442" src="https://www.youtube.com/embed/<?php _e( $videocode ); ?>?mode=opaque&amp;rel=0&amp;autohide=1&amp;showinfo=0&amp;wmode=transparent" frameborder="0" allow="accelerometer; autoplay; gyroscope;" allowfullscreen></iframe>
									</div>
							       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          <span aria-hidden="true">X</span>
							        </button>        
							      </div>
							    </div>
							  </div>
							</div> 
						<?php endif; ?>
						<?php
						if ( ! empty( $about_section->about_the_brand->about_the_brand_button_link ) ) : ?>
							<a class="btn btn-primary wonka-btn" href="<?php _e( $about_section->about_the_brand->about_the_brand_button_link ); ?>"><?php _e( $about_section->about_the_brand->about_the_brand_btn_text ); ?></a>
						<?php endif; ?>
					</div><!-- .about-components-wrap -->
				</div>
				<?php if ( ! empty( $about_section->about_the_brand->about_the_brand_second_image ) ) : ?>
				<div class="col col-12 col-md-5 text-center">
					<div class="img-container">
						<img class="about-second-image" src="<?php _e( $about_section->about_the_brand->about_the_brand_second_image ); ?>" />
					</div>
				</div>
				<?php endif; ?>
			</section>
		<?php endif; ?>

		<?php do_action( 'get_mods_before_section', 'social' );
		$social_section = get_section_mods( 'social' );

		if ( !empty( $social_section->social_mods->social_title ) ) : ?>
			<section class="row instagram-section align-items-center justify-content-around">
				<div class="col col-12 text-center">
					<h3 class="section-title social-title"><?php _e( $social_section->social_mods->social_title ); ?></h3>
				</div> <!-- .col -->
				<div class="col col-8 text-center">
					<p class="section-title social-message"><?php _e( $social_section->social_mods->social_message ); ?></p>
				</div> <!-- .col -->
				<div class="col col-12">
					<?php _e( do_shortcode( $social_section->social_mods->social_shortcode ) ); ?>
				</div>
				<div class="col col-12 shop-social-btn text-center">
					<a class="btn btn-lg btn-primary wonka-btn" href="<?php _e( $social_section->social_mods->social_shop_button);?>"><?php _e($social_section->social_mods->social_btn_text); ?></a>
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