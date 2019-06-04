<?php
/**
 * Template Name: posts-with-sidebar
 * Template Post Type: post
 * 
 * The template for displaying all single posts with sidebar
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package aperabags
 */

global $post;
$ws_post_type = ( !empty( $post->post_type ) ) ? ' main-' . $post->post_type: '';
$ws_post_slug = ( !empty( $post->post_name ) ) ? ' main-' . $post->post_name: '';

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main<?php echo esc_attr( $ws_post_slug . $ws_post_type ); ?>">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

			the_post_navigation();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
		<?php get_sidebar(); ?>
	</div><!-- #primary -->

<?php
get_footer();