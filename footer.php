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
			<div class="row upper-footer">
				<div class="col col-12 col-md-3">
					<div class="social-components-wrap">
						<h4 class="footer-title">Follow</h4>
						<div class="social-icons-btns">
							<?php 
								$instagram_link = ( get_theme_mod( 'footer_social_instagram' ) ) ? get_theme_mod( 'footer_social_instagram' ) : '';
								if ( ! $instagram_link == '' ) {
									echo '<a href="' . $instagram_link . '" target="_blank"><i class="fa fa-instagram"></i></a>';
								}

								$twitter_link = ( get_theme_mod( 'footer_social_twitter' ) ) ? get_theme_mod( 'footer_social_twitter' ) : '';
								if ( ! $twitter_link == '' ) {
									echo '<a href="' . $twitter_link . '" target="_blank"><i class="fa fa-twitter"></i></a>';
								}

								$facebook_link = ( get_theme_mod( 'footer_social_facebook' ) ) ? get_theme_mod( 'footer_social_facebook' ) : '';
								if ( ! $facebook_link == '' ) {
									echo '<a href="' . $facebook_link . '" target="_blank"><i class="fa fa-facebook"></i></a>';
								}

								$pinterest_link = ( get_theme_mod( 'footer_social_pinterest' ) ) ? get_theme_mod( 'footer_social_pinterest' ) : '';
								if ( ! $pinterest_link == '' ) {
									echo '<a href="' . $pinterest_link . '" target="_blank"><i class="fa fa-pinterest"></i></a>';
								}
							?>
						</div><!-- .social-icons-btns -->
					</div><!-- .social-components-wrap -->
				</div><!-- .col -->
				<div class="col col-12 col-md-9">
					<div class="row">
						<div class="col">
							<h5 class="footer-title menu-title-shop">Shop</h5>
							<?php
								wp_nav_menu( array(
								    'theme_location'   => 'menu-shop'
								) );
							?>
						</div><!-- .col -->
						<div class="col">
							<h5 class="footer-title menu-title-contact-us">Contact Us</h5>
							<?php
								wp_nav_menu( array(
								    'theme_location'   => 'menu-contact'
								) );
							?>
						</div><!-- .col -->
						<div class="col">
							<h5 class="footer-title menu-title-account">My Account</h5>
							<?php
								wp_nav_menu( array(
								    'theme_location'   => 'menu-account'
								) );
							?>
						</div><!-- .col -->
						<div class="col">
							<h5 class="footer-title menu-title-company">Company</h5>
							<?php
								wp_nav_menu( array(
								    'theme_location'   => 'menu-company'
								) );
							?>
						</div><!-- .col -->
						<div class="col">
							<h5 class="footer-title menu-title-programs">Apera Programs</h5>
							<?php
								wp_nav_menu( array(
								    'theme_location'   => 'menu-programs'
								) );
							?>
						</div><!-- .col -->
					</div><!-- .row -->
				</div><!-- .col-9 -->
		</div> <!-- .row -->
		<div class="row align-items-center">
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

		<div class="site-info row align-items-center">
			<!-- This column is still parsed in order to hold spacing for formating -->
			<div class="col col-12 col-md-2 offset-md-1 footer-logo">
				<?php
					$footerlogo = ( get_theme_mod( 'footer_logo' ) ) ? get_theme_mod( 'footer_logo' ) : ''; 
					if ( ! $footerlogo == '' ) {
						echo sprintf( esc_html__( '%1$s', 'apera-bags' ), "<img src='$footerlogo' alt='Apera logo' />" );
					}
				?>
			</div> <!-- .col -->
			<!-- End logo spacing column -->
			<div class="col col-12 col-md-8 text-right">
				<?php
					/* Printing copyright date */
					echo sprintf( esc_html__( "%s %s Apera LLC, All Rights Reserved", 'apera-bags' ), date('Y'), '&copy;' );
				?>
			<span class="sep"> | </span>
				<?php
					/* translators: 1: Theme name, 2: Theme author. */
					echo sprintf( esc_html__( 'Designed by %1$s.', 'apera-bags' ), '<a href="https://wonkasoft.com">Wonkasoft</a>' );
				?>
			</div><!-- .col -->
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>
