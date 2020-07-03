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

if ( is_home() ) :
	/* This can be used to filter slide object */
	do_action( 'get_mods_before_section', 'top_slider' );

	$page_mods = get_section_mods( 'top_slider' );
	
	do_action( 'get_mods_after_section', 'top_slider', $page_mods );

	/* This gets the slides as an object */
	$top_slider = $page_mods->top_slider;
	do_action( 'get_mods_before_section', 'top_slider', $top_slider );

	/* This checks for slider object in order to parse slider section */
	if ( ! empty( $top_slider->slides ) ) :
		?>
		<section class="header-slider-section">
			<div class="top-page-slider-wrap">
		<?php
		/* Foreach loop to build slider according to slides entered in the customizer */
		foreach ( $top_slider->slides as $slide ) :

			/* Checks for an img set in the slide object */
			if ( ! empty( $slide->slide_img_id ) ) :
				?>
				<div class="top-page-slide">
				<?php
				if ( wp_is_mobile() ) :
					?>
				<div class="top-slide-img-holder" data-img-url="<?php echo esc_attr( wp_get_attachment_url( $slide->slide_mobile_img_id ) ); ?>" style="background-image:url('<?php echo esc_url( wp_get_attachment_url( $slide->slide_mobile_img_id ) ); ?>');">
					<?php
			else :

				if ( strpos( wp_get_attachment_url( $slide->slide_img_id ), '.mp4' ) !== false ) {
					?>
						<div class="top-slide-img-holder" data-img-url="<?php echo esc_attr( wp_get_attachment_url( $slide->slide_img_id ) ); ?>">
						<video autoplay="true" loop muted class="cta-slide">
						<source src="<?php echo esc_attr( wp_get_attachment_url( $slide->slide_img_id ) ); ?>" type="video/mp4">
							Your browser does not support the video tag.
						</video>
						<?php
				} else {
					?>
					<div class="top-slide-img-holder" data-img-url="<?php echo esc_attr( wp_get_attachment_url( $slide->slide_img_id ) ); ?>" style="background-image:url('<?php echo esc_url( wp_get_attachment_url( $slide->slide_img_id ) ); ?>');">
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
									<h1 class="img-header-text text-center">
									<?php echo wp_kses_data( $slide->slide_header_message ); ?></h1>
								<?php
								/* Checks for an subheader set in the slide object */
								if ( ! empty( $slide->slide_subheader ) ) :
									?>
										<h2 class="img-subheader-text text-center">
									<?php echo wp_kses_data( $slide->slide_subheader ); ?></h2>
									<?php endif; ?>
									<?php
									if ( ! empty( $slide->slide_link_btn ) ) :
										?>
										<a href="<?php echo esc_url( get_the_permalink( $slide->slide_link, false ) ); ?>" class="wonka-btn img-header-slide-link text-center"><?php echo wp_kses_data( $slide->slide_link_btn ); ?></a>
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
		<section class="info-section-1">
			<div class="container">
				<div class="row">
					<div class="col-12 col-md-4">
						<h3>Discover a bag that's as tough as you are</h3>
						<p>Don't let your underperforming gym bag hold you back.</p>
						<p>You've stepped up your workout. Now it's time to upgrade your bag.</p>
						<div class="text-center">
							<a href="<?php echo esc_url( get_site_url() . '/shop/' ); ?>" class="btn wonka-btn mx-auto">Shop all bags</a>
						</div>
					</div>
					<div class="col-12 col-md-8">
						<img src="" class="img-responsive" />
					</div>
				</div>
			</div>
		</section>
		<section class="featured-bags-section">
			<div class="container">
				<div class="row justify-content-space-around">
					<div class="col-12">
						<h2 class="shop-section-title text-center">Reimagine Your Gym Bag</h2>
						<p class="shop-section-subtitle text-center mx-auto">Shop Bestsellers</p>
					</div>
				</div>
				<div class="row justify-content-space-around">
				<?php
					// The tax query
					$tax_query[] = array(
						'taxonomy' => 'product_visibility',
						'field'    => 'name',
						'terms'    => 'featured',
						'operator' => 'IN', // or 'NOT IN' to exclude feature products
					);

					// The query
					$pro_query = new WP_Query(
						array(
							'post_type'           => 'product',
							'post_status'         => 'publish',
							'ignore_sticky_posts' => 1,
							'posts_per_page'      => -1,
							'orderby'             => 'post_title',
							'order'               => 'desc',
							'tax_query'           => $tax_query,
						)
					);
					
				if ( $pro_query->have_posts() ) :
					while ( $pro_query->have_posts() ) : $pro_query->the_post();
						$post_id = get_the_ID(); 
						?>
						<div class="col-12 col-md-4 featured-product-wrap">
							<div class="featured-product-image" style="background-image: url('<?php the_post_thumbnail_url( 'medium' ); ?>');">
								<a href="<?php esc_url( the_permalink( $post_id ) ); ?>" class="btn wonka-btn">
									<h6 class="featured-product-title"><?php the_title(); ?></h6>
								</a>
							</div>
						</div>
						<?php
					endwhile;
					wp_reset_postdata();
				else: ?>
					<p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
				<?php endif; ?>
				</div><!-- justify-content-space-around -->
			</div>
		</section>
		<section class="info-section-2">
		<div class="container">
				<div class="row">
					<div class="col-12 col-md-7"></div>
						<img src="" class="img-responsive" />
					<div class="col-12 col-md-5">
						<h3>Engineered to perform</h3>
						<p>Our bags keep your gear separated and organized Cutting-edge, anti-microbial fabrics are designed to fight odor.</p>
						<h3>Built to Last</h3>
						<p>We use top-quality materials and construction to create tough bags with a lifetime guarantee.</p>
						<div class="text-center">
							<a class="btn wonka-btn mx-auto">Save $10 & Get Free Shipping</a>
						</div>
					</div>
				</div>
			</div>
		</section>

		<?php
		$args         = array(
			'meta_query' => array(
				array(
					'key'     => 'featured',
					'value'   => 'checked',
					'compare' => 'LIKE',
				),
			),
		);
		$testimonials = new Wonkasoft_Testimonial_Query( $args );
		$testimonials->get_testimonials();

		if ( $testimonials->results->have_posts() ) :
		?>
		<section class="testimonial-section">
			<div class="container-fluid">
				<div class="row justify-content-center testimonial-row">
					<div class="col-10 testimonial-wrap text-center">
					<?php
					while( $testimonials->results->have_posts() ) : $testimonials->results->the_post();
						$post_id = get_the_ID();
						?>
						<div class="text-center testimonial-box">
							<p><span class="testimonial-quotes">"</span><?php echo esc_html( $post->post_content ); ?><span class="testimonial-quotes">"</span><br />- <?php echo esc_html( $post->post_title ); ?></p>
						</div>
						<?php
					endwhile;
					?>
					</div>
				</div>
			</div>
		</section>
		<?php endif; ?>
		<section class="category-section">
			<div class="container">
				<div class="row justify-content-space-around">
					<div class="col-12">
						<h3 class="cat-section-title">Crush Your Next Workout<br /> & Look Good Doing It</h3>
					</div>
				<?php
				$term_args = array(
					'taxonomy'   => 'product_cat',
					'orderby'    => 'name',
					'order'      => 'ASC',
					'hide_empty' => true,
				);
				$cats      = new WP_Term_Query( $term_args );
				list( $accessories, $all_bags, $backpacks, $duffles, $onemore, $logo, $organiztion, $over_shoulder, $totes ) = $cats->terms;
				$ordered_cats   = array();
				$ordered_cats[] = $duffles;
				$ordered_cats[] = $backpacks;
				$ordered_cats[] = $totes;
				$ordered_cats[] = $accessories;
				foreach ( $ordered_cats as $cur_cat ) :
					if ( 'Backpacks' === $cur_cat->name || 'Duffels' === $cur_cat->name || 'Accessories' === $cur_cat->name || 'Totes' === $cur_cat->name ) :
						?>
						<?php
							$thumbnail_id = get_woocommerce_term_meta( $cur_cat->term_id, 'thumbnail_id', true );
							$src          = wp_get_attachment_image_src( $thumbnail_id, 'full', false );
						?>
							<div class="col-6 cat-col">
								<div class="cat-container" style="background-image: url('<?php echo esc_url( $src[0] ); ?>');">
									<a href="<?php echo esc_url( get_term_link( $cur_cat->term_id ) ); ?>" class="btn wonka-btn"><?php echo esc_html( $cur_cat->name ); ?></a>
								</div>
							</div>
						<?php
					endif;
				endforeach;
				?>
				</div>
			</div>
		</section>
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
