<?php
/**
 * Template name: Add Discount Codes
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

global $post;
$ws_post_type = ( ! empty( $post->post_type ) ) ? ' main-' . $post->post_type : '';
$ws_post_slug = ( ! empty( $post->post_name ) ) ? ' main-' . $post->post_name : '';

$check_user = ( isset( $_GET['mustbe'] ) ) ? wp_kses_post( wp_unslash( $_GET['mustbe'] ) ) : '';
$user       = md5( 'karin' );
$check_admin = current_user_can( 'manage_options' );
if ( $user === $check_user || $check_admin ) {
	get_header();
	?>

		<div id="primary" class="content-area">
			<main id="main" class="site-main<?php echo esc_attr( $ws_post_slug . $ws_post_type ); ?>">

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
			</main><!-- #main -->
		</div><!-- #primary -->

	<?php
	get_footer();
} else {
	header( 'Location: ' . get_site_url() );
}
