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

	<div id="primary" class="content-area container-fluid 404-background">
		<main id="main" class="site-main row">
			<section class="error-404 not-found text-center col">
				<header class="page-header text-center">
					<h1 class="404-title">404</h1>
					<h2 class="sub-title"><?php esc_html_e( 'Four, oh four', 'apera-bags' ); ?></h2>
					<h3 class="title-message">Wherefore Art Thou Four?</h3>

				</header><!-- .page-header -->

				<div class="page-content fixed-divider-460">
					<p><?php esc_html_e( 'Like a great workout coming to a grinding halt!', 'apera-bags' ); ?></p>
					<p><?php esc_html_e( "Unfortunately, this page doesn't seem to exist.", 'apera-bags' ); ?></p>
					<p><strong><?php esc_html_e( 'Try a search instead?', 'apera-bags' ); ?></strong></p>
					<span class="search-container"><?php get_search_form(); ?></span>  <span class="or-more">or...</span>  <span class="back-home"><a href="<?php echo get_site_url(); ?>" class="wonka-btn">Back Home</a></span>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
