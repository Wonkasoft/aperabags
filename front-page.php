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
	do_action( 'get_mods_before_section', 'all' );

	$page_mods = get_section_mods( 'all' );

	do_action( 'get_mods_after_section', 'all', $page_mods );

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

		</section>
		<section class="featured-bags-section">
			<?php echo do_shortcode( '[featured_products]' ); ?>
		</section>
		<section class="info-section-2">

		</section>
		<section class="testimonial-section">

		</section>
		<section class="category-section">
			<?php
			echo "<pre>\n";
			print_r( Wonkasoft_Testimonial_Query::get_testimonials() );
			echo "</pre>\n";
			$cats = get_terms( 'product_cat' );
			foreach ( $cats as $cat ) :
				if ( 'Backpacks' === $cat->name || 'Duffels' === $cat->name || 'Accessories' === $cat->name || 'Totes' === $cat->name ) :

					echo "<pre>\n";
					print_r( $cat );
					echo "</pre>\n";
				endif;
			endforeach;
			?>
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
