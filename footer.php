<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Apera_Bags
 */

?>

	</div><!-- #content .container-fluid -->

	<footer id="colophon" class="site-footer">
		<div class="container-fluid">
			<div class="row">

				<div class="col">
					<?php
						wp_nav_menu( array(
						    'theme_location'   => 'menu2'
						) );
					?>
				</div>
				<div class="col">
					<?php
						wp_nav_menu( array(
						    'theme_location'   => 'menu2'
						) );
					?>
				</div>
				<div class="col">
					<?php
						wp_nav_menu( array(
						    'theme_location'   => 'menu3'
						) );
					?>
				</div>
				<div class="col">
					<?php
						wp_nav_menu( array(
						    'theme_location'   => 'menu4'
						) );
					?>
				</div>
				<div class="col">
					<?php
						wp_nav_menu( array(
						    'theme_location'   => 'menu5'
						) );
					?>
				</div>
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'apera-bags' ) ); ?>">
				<?php
				/* translators: %s: CMS name, i.e. WordPress. */
				printf( esc_html__( 'Proudly powered by %s', 'apera-bags' ), 'WordPress' );
				?>
			</a>
			<span class="sep"> | </span>
				<?php
				/* translators: 1: Theme name, 2: Theme author. */
				printf( esc_html__( 'Theme: %1$s by %2$s.', 'apera-bags' ), 'apera-bags', '<a href="https://wonkasoft.com">Wonkasoft</a>' );
				?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
