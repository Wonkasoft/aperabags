<?php
/**
 * Template Name: Page no Title
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

global $post;

$ws_post_type = ( ! empty( $post->post_type ) ) ? ' main-' . $post->post_type : '';
$ws_post_slug = ( ! empty( $post->post_name ) ) ? ' main-' . $post->post_name : '';
$ws_classes = $ws_post_slug . $ws_post_type;

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main<?php echo esc_attr( $ws_classes ); ?>">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page-notitle' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
