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
						$instagram_link = ( get_theme_mod( 'footer_social_instagram' ) ) ? get_theme_mod( 'footer_social_instagram' ) : '';
						if ( ! $instagram_link == '' ) {
							echo '<a href="' . $instagram_link . '" target="_blank"><i class="fa fa-instagram"></i></a>';
						}

						$twitter_link = ( get_theme_mod( 'footer_social_twitter' ) ) ? get_theme_mod( 'footer_social_twitter' ) : '';
						if ( ! $twitter_link == '' ) {
							echo '<a href="' . $twitter_link . '" target="_blank"><i class="fa fa-twitter-square"></i></a>';
						}
						$facebook_link = ( get_theme_mod( 'footer_social_facebook' ) ) ? get_theme_mod( 'footer_social_facebook' ) : '';
						if ( ! $facebook_link == '' ) {
							echo '<a href="' . $facebook_link . '" target="_blank"><i class="fa fa-facebook-square"></i></a>';
						}
						$pinterest_link = ( get_theme_mod( 'footer_social_pinterest' ) ) ? get_theme_mod( 'footer_social_pinterest' ) : '';
						if ( ! $pinterest_link == '' ) {
							echo '<a href="' . $pinterest_link . '" target="_blank"><i class="fa fa-pinterest-square"></i></a>';
						}
					?>
				</div> <!-- .col -->
				<div class="col">
					<?php
						wp_nav_menu( array(
						    'theme_location'   => 'menu2'
						) );
					?>
				</div> <!-- .col -->
				<div class="col">
					<?php
						wp_nav_menu( array(
						    'theme_location'   => 'menu2'
						) );
					?>
				</div> <!-- .col -->
				<div class="col">
					<?php
						wp_nav_menu( array(
						    'theme_location'   => 'menu3'
						) );
					?>
				</div> <!-- .col -->
				<div class="col">
					<?php
						wp_nav_menu( array(
						    'theme_location'   => 'menu4'
						) );
					?>
				</div> <!-- .col -->
				<div class="col">
					<?php
						wp_nav_menu( array(
						    'theme_location'   => 'menu5'
						) );
					?>
				</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row">
			<div class="col">
				<?php echo get_theme_mod( 'footer_contact_message' ); ?>
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row">
			<div class="col">
				<?php echo get_theme_mod( 'footer_contact_support_email' ); ?>
			</div> <!-- .col -->
		</div> <!-- .row -->

		<div class="row">
			<div class="col">
				<?php 
				$signupform = ( get_theme_mod( 'footer_form_shortcode' ) ) ? get_theme_mod( 'footer_form_shortcode' ) : ''; 
				if ( ! $signupform == '' ) {
					echo "<small>Sign up to get the latest on sales, new releases and more...</small><br />";
					echo do_shortcode( $signupform, $ignore_html = false );
				}

				?>
			</div> <!-- .col -->
		</div> <!-- .row -->

		<div class="site-info row">
			<div class="col">
				<?php
					$footerlogo = ( get_theme_mod( 'footer_logo' ) ) ? get_theme_mod( 'footer_logo' ) : ''; 
					if ( ! $footerlogo == '' ) {
						echo "<img src='$footerlogo' alt='Apera logo' />";
					}
				?>
			</div> <!-- .col -->
			<div class="col">
				<?php
					echo date('Y') . " &copy; Apera LLC, All Rights Reserved";
				?>
			<span class="sep"> | </span>
				<?php
				/* translators: 1: Theme name, 2: Theme author. */
				printf( esc_html__( 'Designed: by %1$s.', 'apera-bags' ), '<a href="https://wonkasoft.com">Wonkasoft</a>' );
				?>
			</div> <!-- .col -->
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
