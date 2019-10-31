<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package aperabags
 */

get_header();
?>

	<div id="primary" class="content-area container 404-background">
		<main id="main" class="site-main row">
			<section class="error-404 not-found text-center col">
				<header class="page-header text-center col">
					<h1 class="404-title col">404</h1>
					<h2 class="sub-title col"><?php esc_html_e( 'Four, oh four', 'apera-bags' ); ?></h2>
					<h3 class="title-message col">Wherefore Art Thou Four?</h3>

				</header><!-- .page-header -->

				<div class="page-content fixed-divider-460">
					<p><?php esc_html_e( 'Like a great workout coming to a grinding halt!', 'apera-bags' ); ?></p>
					<p><?php esc_html_e( "Unfortunately, this page doesn't seem to exist.", 'apera-bags' ); ?></p>
					<?php get_search_form(); ?> or... <a href="<?php echo get_site_url(); ?>" class="wonka-btn">Back Home</a>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
