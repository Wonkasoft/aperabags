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
	<?php endif; ?>
	<?php
	$discovery_section = ! empty( $page_mods->discovery_section ) ? $page_mods->discovery_section : '';

	if ( empty( $dicovery_section ) ) :
		$discovery_section = apply_filters( 'wonkasoft_filter_before_discovery_section', get_section_mods( 'discovery_section' ), 'discovery_section' );
	endif;

	$discovery_section = $discovery_section->discovery_section;
	do_action( 'wonkasoft_action_before_discovery_section', 'discovery_section', $discovery_section );

	?>
	<?php if ( ! empty( $discovery_section ) ) : ?>
		<section class="discovery-section">
			<div class="container-fluid">
				<div class="row align-items-center">
					<div class="col col-12 col-md-4">
						<h3><?php echo esc_html( $discovery_section->title ); ?></h3>
						<?php
							echo $discovery_section->body;
						?>
						<div class="text-left">
							<a href="<?php echo esc_url( $discovery_section->cta_link ); ?>" class="btn wonka-btn"><?php echo esc_html( $discovery_section->cta_text ); ?></a>
						</div>
					</div>
					<div class="col col-12 col-md-8 text-center">
						<a href="<?php echo esc_url( $discovery_section->cta_link ); ?>" class="img-link">
							<img src="<?php echo esc_url( wp_get_attachment_image_src( $discovery_section->image, 'medium', false )[0] ); ?>" class="img-responsive" srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( $discovery_section->image, 'medium', null ) ); ?>" />
							<img src="<?php echo esc_url( wp_get_attachment_image_src( $discovery_section->second_image, 'medium', false )[0] ); ?>" class="img-responsive flip-image" srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( $discovery_section->second_image, 'medium', null ) ); ?>" />
						</a>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>
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
	?>
	<?php if ( $pro_query->have_posts() ) : ?>
		<section class="featured-bags-section">
			<div class="container-fluid">
				<div class="row justify-content-space-around">
					<div class="col-12">
						<h2 class="shop-section-title text-center">Reimagine Your Gym Bag</h2>
						<p class="shop-section-subtitle text-center mx-auto">Shop Bestsellers</p>
					</div>
				</div>
				<div class="row justify-content-space-around">
				<?php

				while ( $pro_query->have_posts() ) :
					$pro_query->the_post();

					$post_id                   = get_the_ID();
					$featured_product_image_id = get_featured_product_img_id( $post );

					?>
						<div class="col col-12 col-md-4 featured-product-wrap">
							<a href="<?php esc_url( the_permalink( $post_id ) ); ?>" class="shop-link">
								<div class="featured-product-image" style="background-image: url('<?php echo esc_url( wp_get_attachment_image_src( $featured_product_image_id, 'full', false )[0] ); ?>');">
										<button class="btn wonka-btn"><h6 class="featured-product-title"><?php the_title(); ?></h6></button>
								</div>
							</a>
						</div>
						<?php
					endwhile;
					wp_reset_postdata();
				?>
				</div><!-- justify-content-space-around -->
			</div>
		</section>
	<?php endif; ?>
	<?php
	$our_brand_section = ! empty( $page_mods->our_brand_section ) ? $page_mods->our_brand_section : '';

	if ( empty( $our_brand_section ) ) :
		$our_brand_section = apply_filters( 'wonkasoft_filter_before_our_brand_section', get_section_mods( 'our_brand_section' ), 'our_brand_section' );
	endif;

	$our_brand_section = $our_brand_section->our_brand_section;
	do_action( 'wonkasoft_action_before_our_brand_section', 'our_brand_section', $our_brand_section );
	?>
	<?php if ( ! empty( $our_brand_section ) ) : ?>
		<section class="our-brand-section">
		<div class="container-fluid">
				<div class="row align-items-center">
					<div class="col col-12 col-md-8 text-center">
						<a href="<?php echo esc_url( $our_brand_section->cta_link ); ?>" class="img-link">
							<img src="<?php echo esc_url( wp_get_attachment_image_src( $our_brand_section->image, 'medium', false )[0] ); ?>" class="img-responsive" srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( $our_brand_section->image, 'medium', null ) ); ?>" />
							<img src="<?php echo esc_url( wp_get_attachment_image_src( $our_brand_section->second_image, 'medium', false )[0] ); ?>" class="img-responsive flip-image" srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( $our_brand_section->second_image, 'medium', null ) ); ?>" />
						</a>
					</div>
					<div class="col col-12 col-md-4">
						<h3><?php echo esc_html( $our_brand_section->title ); ?></h3>
						<?php
							echo $our_brand_section->body;
						?>
						<div class="text-left">
							<a href="<?php echo esc_url( $our_brand_section->cta_link ); ?>" class="btn wonka-btn"><?php echo esc_html( $our_brand_section->cta_text ); ?></a>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>
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
				<div class="row align-items-center justify-content-center testimonial-row">
					<div class="col-10 testimonial-wrap text-center">
					<?php
					while ( $testimonials->results->have_posts() ) :
						$testimonials->results->the_post();
						$post_id = get_the_ID();
						?>
						<div class="text-center testimonial-box">
							<p><span class="testimonial-quotes">"</span><?php echo get_the_content(); ?><span class="testimonial-quotes">"</span><br />- <?php the_title(); ?></p>
						</div>
						<?php
						endwhile;
					?>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>
	<?php
	$term_args = array(
		'taxonomy'   => 'product_cat',
		'orderby'    => 'name',
		'order'      => 'ASC',
		'hide_empty' => true,
	);
	$cats      = new WP_Term_Query( $term_args );
	?>
	<?php if ( ! empty( $cats ) ) : ?>
		<section class="category-section">
			<div class="container-fluid">
				<div class="row justify-content-space-around">
					<div class="col col-12">
						<h3 class="cat-section-title">Crush Your Next Workout<br /> & Look Good Doing It</h3>
					</div>
				<?php

				foreach ( $cats->get_terms() as $cur_cat ) :

					if ( 'Backpacks' === $cur_cat->name ) :
						?>
						<?php
							$thumbnail_id = get_woocommerce_term_meta( $cur_cat->term_id, 'thumbnail_id', true );
							$src          = wp_get_attachment_image_src( $thumbnail_id, 'full', false );
						?>
							<div class="col col-6 cat-col">
								<a href="<?php echo esc_url( get_term_link( $cur_cat->term_id ) ); ?>" class="cat-link">
									<div class="cat-container" style="background-image: url('<?php echo esc_url( $src[0] ); ?>');">
										<button class="btn wonka-btn"><?php echo esc_html( $cur_cat->name ); ?></button>
									</div>
								</a>
							</div>
						<?php
					endif;

					if ( 'Duffels' === $cur_cat->name ) :
						?>
						<?php
							$thumbnail_id = get_woocommerce_term_meta( $cur_cat->term_id, 'thumbnail_id', true );
							$src          = wp_get_attachment_image_src( $thumbnail_id, 'full', false );
						?>
							<div class="col col-6 cat-col">
								<a href="<?php echo esc_url( get_term_link( $cur_cat->term_id ) ); ?>" class="cat-link">
									<div class="cat-container" style="background-image: url('<?php echo esc_url( $src[0] ); ?>');">
										<button class="btn wonka-btn"><?php echo esc_html( $cur_cat->name ); ?></button>
									</div>
								</a>
							</div>
						<?php
					endif;

					if ( 'Accessories' === $cur_cat->name ) :
						?>
						<?php
							$thumbnail_id = get_woocommerce_term_meta( $cur_cat->term_id, 'thumbnail_id', true );
							$src          = wp_get_attachment_image_src( $thumbnail_id, 'full', false );
						?>
							<div class="col col-6 cat-col">
								<a href="<?php echo esc_url( get_term_link( $cur_cat->term_id ) ); ?>" class="cat-link">
									<div class="cat-container" style="background-image: url('<?php echo esc_url( $src[0] ); ?>');">
										<button class="btn wonka-btn"><?php echo esc_html( $cur_cat->name ); ?></button>
									</div>
								</a>
							</div>
						<?php
					endif;

					if ( 'Totes' === $cur_cat->name ) :
						?>
						<?php
							$thumbnail_id = get_woocommerce_term_meta( $cur_cat->term_id, 'thumbnail_id', true );
							$src          = wp_get_attachment_image_src( $thumbnail_id, 'full', false );
						?>
							<div class="col col-6 cat-col">
								<a href="<?php echo esc_url( get_term_link( $cur_cat->term_id ) ); ?>" class="cat-link">
									<div class="cat-container" style="background-image: url('<?php echo esc_url( $src[0] ); ?>');">
										<button class="btn wonka-btn"><?php echo esc_html( $cur_cat->name ); ?></button>
									</div>
								</a>
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
