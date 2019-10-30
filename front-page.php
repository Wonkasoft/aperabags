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
 * @package aperabags
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
	if ( ! empty( $top_slider->slides ) ) :
		?>
		<section class="header-slider-section">
			<div class="top-page-slider-wrap">
				<?php
				/* Foreach loop to build slider according to slides entered in the customizer */
				foreach ( $top_slider->slides as $slide ) :
					/* Checks for an img set in the slide object */
					if ( ! empty( $slide->slide_img ) ) :
						?>
						<div class="top-page-slide">
							<?php
							if ( wp_is_mobile() ) :
								?>
								<div class="top-slide-img-holder" data-img-url="<?php echo esc_attr( $slide->slide_mobile_img ); ?>" style="background-image:url('<?php echo esc_url( $slide->slide_mobile_img ); ?>');">
									<?php
								else :
									if ( strpos( $slide->slide_img, '.mp4' ) !== false ) {
										?>
										<div class="top-slide-img-holder" data-img-url="<?php echo esc_attr( $slide->slide_img ); ?>">
											<video autoplay="true" loop muted controls class="cta-slide">
												<source src="<?php echo esc_attr( $slide->slide_img ); ?>" type="video/mp4">
													Your browser does not support the video tag.
												</video>
												<?php
									} else {
										?>
												<div class="top-slide-img-holder" data-img-url="<?php echo esc_attr( $slide->slide_img ); ?>" style="background-image:url('<?php echo esc_url( $slide->slide_img ); ?>');">
											<?php
									}
											endif;
											/* Checks for an message set in the slide object */
								if ( ! empty( $slide->slide_header_message ) ) :
									?>
												<div class="row img-header-text-wrap">
													<div class="col col-12 img-header-text-container">
														<div class="text-box text-center
											<?php
											$set_text_align = ( ! empty( $slide->slide_text_position ) ) ? ' set-align-' . $slide->slide_text_position : ' set-align-center';
											echo wp_kses_data( $set_text_align );
											?>
														">
														<h2 class="img-header-text text-center"><?php echo wp_kses_data( $slide->slide_header_message ); ?></h2>
														<?php
														/* Checks for an subheader set in the slide object */
														if ( ! empty( $slide->slide_subheader ) ) :
															?>
															<h4 class="img-subheader-text text-center"><?php echo wp_kses_data( $slide->slide_subheader ); ?></h4>
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
			if ( ! empty( $shop_section->shop_mods->shop_title ) ) :
				?>

				<section class="shop-section container-fluid" style="background-image:url(<?php echo esc_url( $shop_section->shop_mods->shop_background_image ); ?>);">
					<div class="row wonka-row align-items-center justify-content-center">
						<div class="col-12">
							<div class="row">
								<div class="col-12">
									<div class="wonka wonka-section-title text-center">
										<h3 class="wonka wonka-h3 section-title shop-title"><?php echo wp_kses_post( $shop_section->shop_mods->shop_title ); ?></h3>
									</div>
								</div>
							</div>
								<div class="row">
									<div class="col-12">
										<?php
										$shop_shortcode = '[products limit="' . $shop_section->shop_mods->shop_num_of_products . '" columns="' . $shop_section->shop_mods->shop_product_per_row . '" visibility="featured"]';
										echo do_shortcode( $shop_shortcode );
										?>
									</div><!-- .col-12 -->
								</div><!-- .row -->
								<div class="row">
									<div class="col col-12 text-center">
										<a href="<?php echo esc_url( get_site_url() ); ?>/shop" class="wonka-btn" target="_self"><?php esc_html_e( 'Shop All' ); ?></a>
									</div><!-- .col -->
								</div><!-- .row -->
							</div><!-- .col -->
						</div><!-- .wonka-row -->
					</section><!-- .shop-section -->
				<?php endif; ?>
				<?php
				do_action( 'get_mods_before_section', 'cta' );
				$cta_slider = get_section_mods( 'cta' );
				if ( ! empty( $cta_slider->slides ) ) :
					?>
					<section class="desirable-slider-section">
						<div class="cta-section-slider-wrap">
							<?php
							/* Foreach loop to build slider according to slides entered in the customizer */
							foreach ( $cta_slider->slides as $slide ) :
								/* Checks for an img set in the slide object */
								if ( ! empty( $slide->slide_img ) ) :
									?>
									<div class="cta-section-slide">
										<?php
										if ( wp_is_mobile() ) :
											?>
											<div class="cta-slide-img-holder" data-img-url="<?php echo esc_attr( $slide->slide_mobile_img ); ?>" style="background-image:url('<?php echo esc_url( $slide->slide_mobile_img ); ?>');">
												<?php
											else :
												if ( strpos( $slide->slide_img, '.mp4' ) !== false ) {
													?>
													<div class="cta-slide-img-holder" data-img-url="<?php echo esc_attr( $slide->slide_img ); ?>">
														<video autoplay loop muted controls class="cta-slide">
															<source src="<?php echo esc_attr( $slide->slide_img ); ?>" type="video/mp4">
																Your browser does not support the video tag.
															</video>
															<?php
												} else {
													?>
															<div class="cta-slide-img-holder" data-img-url="<?php echo esc_attr( $slide->slide_img ); ?>" style="background-image:url('<?php echo esc_url( $slide->slide_img ); ?>');">
														<?php
												}
														endif;
														/* Checks for an message set in the slide object */
											if ( ! empty( $slide->slide_text_message ) ) :
												?>
															<div class="row img-header-text-wrap">
																<div class="col col-12 img-header-text-container">
																	<div class="text-box text-center
														<?php
														$set_text_align = ( ! empty( $slide->slide_text_position ) ) ? ' set-align-' . $slide->slide_text_position : ' set-align-center';
														echo wp_kses_data( $set_text_align );
														?>
																	">
																	<h2 class="img-header-text text-center"><?php echo wp_kses_data( $slide->slide_text_message ); ?></h2>
																	<?php
																	/* Checks for an subheader set in the slide object */
																	if ( ! empty( $slide->slide_link ) ) :
																		?>
																		<a href="<?php echo esc_url( get_the_permalink( $slide->slide_link, false ) ); ?>" class="wonka-btn img-cta-link text-center"><?php echo wp_kses_data( $slide->slide_link_btn ); ?></a>
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
						<?php
						do_action( 'get_mods_before_section', 'cause' );
						$cause_section = get_section_mods( 'cause' );

						/* Check for Cause object */
						if ( ! empty( $cause_section->cause_mods->cause_section_title ) ) :
							?>
							<section class="container-fluid our-cause-section">
								<div class="row wonka-row">
									<div class="col-12 text-center title-wrap">
										<h3 class="section-title our-cause-title"><?php echo wp_kses_data( $cause_section->cause_mods->cause_section_title ); ?></h3>
									</div>
								</div>
								<div class="row wonka-row">
									<?php
									foreach ( $cause_section->causes as $cause ) :
										if ( ! empty( $cause->img ) ) :
											?>
											<div class="col-12 col-md-4">
												<div class="cause-section-module">
													<div class="module-component-wrap">
														<div class="img-container">
															<a href="<?php echo esc_url( $cause->img_link ); ?>">
																<img class="cause-img img-fluid" srcset="<?php echo esc_attr( $cause->img_srcset ); ?>" />
															</a>
														</div>
														<?php if ( ! empty( $cause->header_link ) ) : ?>
															<a href="<?php echo esc_url( $cause->header_link ); ?>" >
																<h3 class="cause-title text-<?php echo esc_attr( $cause->position ); ?>"><?php echo wp_kses_data( $cause->header ); ?></h3>
															</a>
														<?php else : ?>
															<h3 class="cause-title text-<?php echo esc_attr( $cause->position ); ?>"><?php echo wp_kses_data( $cause->header ); ?></h3>										
														<?php endif; ?>
														<p class="cause-message text-<?php echo esc_attr( $cause->position ); ?>">
															<?php
																echo wp_kses(
																	$cause->message,
																	array(
																		'a' => array(
																			'href' => array(),
																			'data-toggle' => array(),
																			'data-target' => array(),
																			'id' => array(),
																		),
																	)
																);
															?>
														</p>
													</div><!-- .module-component-wrap -->
												</div><!-- .cause-section-module -->
											</div>
										<?php endif; ?>
									<?php endforeach; ?>
								</div>

									<!-- Modal -->
									<div class="modal fade" id="videoModalpop" tabindex="-1" role="dialog" aria-labelledby="causeAperaModal" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-body">
													<!-- 16:9 aspect ratio -->
													<div class="embed-responsive embed-responsive-16by9" id="cause-youtube-source">
														
													</div>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">X</span>
													</button>        
												</div>
											</div>
										</div>
									</div> 
							</section><!-- .our-cause-section -->
						<?php endif; ?>



						<?php
						do_action( 'get_mods_before_section', 'about' );
						$about_section = get_section_mods( 'about' );

						if ( ! empty( $about_section->about_the_brand->about_header ) ) :
							?>
							<section class="container-fluid about-brand-section align-items-center justify-content-around">
								<div class="row wonka-row">
									<div class="col-12 col-sm-6 text-center">
										<div class="about-components-wrap">
											<h2 class="about-brand-header"><?php echo wp_kses_post( $about_section->about_the_brand->about_header ); ?></h2>
											<h4 class="about-brand-subheader"><?php echo wp_kses_post( $about_section->about_the_brand->about_subheader ); ?></h4>
											<p class="about-brand-message"><?php echo wp_kses_post( $about_section->about_the_brand->about_message ); ?></p>
											<div class="about-brand-video">
												<?php

												if ( ! empty( $about_section->about_the_brand->about_videoplaceholder ) ) :
													?>
													<a id="about-modal-link" href="#" data-toggle="modal" data-target="#videoModal" class="video-img-link">
														<img srcset="<?php echo esc_attr( $about_section->about_the_brand->about_videoplaceholder ); ?>" />
														<span data-toggle="modal" data-target="#videoModal" class="video-img-symbol-link"><i class="fa fa-play-circle"></i></span>
													</a>
													<?php
												endif;
												?>
											</div>
											<?php
											if ( ! empty( $about_section->about_the_brand->about_videoplaceholder ) ) :
												?>

												<!-- Modal -->
												<div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="aboutAperaModal" aria-hidden="true">
													<div class="modal-dialog" role="document">
														<div class="modal-content">
															<div class="modal-body">
																<!-- 16:9 aspect ratio -->
																<div id="about-youtube-source" class="embed-responsive embed-responsive-16by9">
																	
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
											if ( ! empty( $about_section->about_the_brand->about_the_brand_button_link ) ) :
												?>
												<a class="wonka-btn" href="<?php echo esc_url( $about_section->about_the_brand->about_the_brand_button_link ); ?>"><?php echo wp_kses_post( $about_section->about_the_brand->about_the_brand_btn_text ); ?></a>
											<?php endif; ?>
										</div><!-- .about-components-wrap -->
									</div>
									<?php if ( ! empty( $about_section->about_the_brand->about_the_brand_second_image ) ) : ?>
										<div class="col-12 col-sm-6 text-center">
											<div class="img-container">
												<a href="<?php echo esc_url( $about_section->about_the_brand->about_the_brand_image_link ); ?>">
													<img class="about-second-image" srcset="<?php echo esc_attr( $about_section->about_the_brand->about_the_brand_second_image ); ?>"/>
												</a>
											</div>
										</div>
									<?php endif; ?>
								</div>
							</section>
						<?php endif; ?>

						<?php
						do_action( 'get_mods_before_section', 'perks' );
						$apera_perks = get_section_mods( 'perks' );

						if ( ! empty( $apera_perks->apera_perks->perks_checkbox ) ) :
							?>
							<section class="container-fluid perks-section text-center">
								<h3 class="section-title perks-title">Apera Perks</h3>
								<div class="row row-perks">
									<div class="col-6 col-perks-content">
										<?php echo '<p class="social-message">' . esc_html( $apera_perks->apera_perks->perks_message ) . '</p>'; ?>
										<a class="wonka-btn" href="https://aperabags.com/my-account/">Join Now</a>
									</div>
									<div class="col-6 col-perks-image">
									<img class="cause-img img-fluid" srcset="<?php echo esc_attr( $apera_perks->apera_perks->perks_image ); ?>" />

									</div>
								</div>
							</section>

						<?php endif; ?>

						<?php
						do_action( 'get_mods_before_section', 'social' );
						$social_section = get_section_mods( 'social' );

						if ( ! empty( $social_section->social_mods->social_title ) ) :
							?>
							<section class="container-fluid social-section">
								<div class="row wonka-row align-items-center justify-content-around">
									<div class="col-12 text-center">
										<h3 class="section-title social-title"><?php echo wp_kses_post( $social_section->social_mods->social_title ); ?></h3>
									</div> <!-- .col -->
									<div class="col-12 col-md-8 text-center">
										<p class="social-message"><?php echo wp_kses_post( $social_section->social_mods->social_message ); ?></p>
									</div> <!-- .col -->
									<div class="col-12 social-shortcode">
										<?php echo do_shortcode( $social_section->social_mods->social_shortcode ); ?>
									</div>
									<div class="col-12 shop-social-btn text-center">
										<a class="wonka-btn" href="<?php echo esc_url( $social_section->social_mods->social_shop_button ); ?>"><?php echo wp_kses_post( $social_section->social_mods->social_btn_text ); ?></a>
									</div> <!-- .col -->
								</div>
							</section><!-- .instagram-section -->
						<?php endif; ?>
						<?php else : ?>
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
