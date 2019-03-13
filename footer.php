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

do_action( 'get_mods_before_section', 'footer' );
$footer_section = get_section_mods( 'footer' );
?>

	</div><!-- #content .container-fluid -->

	<footer id="colophon" class="site-footer">
		<div class="container-fluid">
			<div class="row upper-footer">
				<div class="col col-12 col-md-3">
					<div class="social-components-wrap">
						<h4 class="footer-title"><?php echo $footer_section->footer_mods->footer_social_title; ?></h4>
						<div class="social-icons-btns">
							<?php 
								if ( !empty( $footer_section->footer_mods->footer_social_instagram ) ) {
									echo '<a href="' . $footer_section->footer_mods->footer_social_instagram . '" target="_blank"><i class="fa fa-instagram"></i></a>';
								}

								if ( !empty( $footer_section->footer_mods->footer_social_twitter ) ) {
									echo '<a href="' . $footer_section->footer_mods->footer_social_twitter . '" target="_blank"><i class="fa fa-twitter"></i></a>';
								}

								if ( !empty( $footer_section->footer_mods->footer_social_facebook ) ) {
									echo '<a href="' . $footer_section->footer_mods->footer_social_facebook . '" target="_blank"><i class="fa fa-facebook"></i></a>';
								}

								if ( !empty( $footer_section->footer_mods->footer_social_pinterest ) ) {
									echo '<a href="' . $footer_section->footer_mods->footer_social_pinterest . '" target="_blank"><i class="fa fa-pinterest"></i></a>';
								}
							?>
						</div><!-- .social-icons-btns -->
						<?php if ( !empty( $footer_section->footer_mods->footer_contact_message ) ) : ?>
							<div class="footer-contact-message">
								<?php echo $footer_section->footer_mods->footer_contact_message; ?>
							</div> <!-- .col -->
						<?php endif; ?>
						<?php if ( !empty( $footer_section->footer_mods->footer_contact_support_email ) ) : ?>
							<div class="footer-contact-email">
								<?php echo $footer_section->footer_mods->footer_contact_support_email; ?>
							</div> <!-- .col -->
						<?php endif; ?>
					</div><!-- .social-components-wrap -->
				</div><!-- .col -->
				<div class="col col-12 col-md-9">
					<div class="row">
						<?php if ( !empty( $footer_section->footer_titles->footer_title_1 ) ) : ?>
							<div class="col">
								<h5 class="footer-title menu-title-shop"><?php echo $footer_section->footer_titles->footer_title_1; ?></h5>
								<?php
									wp_nav_menu( array(
									    'theme_location'   => 'menu-shop',
									    'menu_class'		=> 'wonka-footer-menu wonka-footer-menu-' . strtolower( $footer_section->footer_titles->footer_title_1 ),
									) );
								?>
							</div><!-- .col -->
						<?php endif; ?>
						<?php if ( !empty( $footer_section->footer_titles->footer_title_2 ) ) : ?>
							<div class="col">
								<h5 class="footer-title menu-title-contact-us"><?php echo $footer_section->footer_titles->footer_title_2; ?></h5>
								<?php
									wp_nav_menu( array(
									    'theme_location'   => 'menu-contact',
									    'menu_class'		=> 'wonka-footer-menu wonka-footer-menu-' . strtolower( $footer_section->footer_titles->footer_title_2 ),
									) );
								?>
							</div><!-- .col -->
						<?php endif; ?>
						<?php if ( !empty( $footer_section->footer_titles->footer_title_3 ) ) : ?>
							<div class="col">
								<h5 class="footer-title menu-title-account"><?php echo $footer_section->footer_titles->footer_title_3; ?></h5>
								<?php
									wp_nav_menu( array(
									    'theme_location'   => 'menu-account',
									    'menu_class'		=> 'wonka-footer-menu wonka-footer-menu-' . strtolower( $footer_section->footer_titles->footer_title_3 ),
									) );
								?>
							</div><!-- .col -->
						<?php endif; ?>
						<?php if ( !empty( $footer_section->footer_titles->footer_title_4 ) ) : ?>
						<div class="col">
							<h5 class="footer-title menu-title-company"><?php echo $footer_section->footer_titles->footer_title_4; ?></h5>
							<?php
								wp_nav_menu( array(
								    'theme_location'   => 'menu-company',
								    'menu_class'		=> 'wonka-footer-menu wonka-footer-menu-' . strtolower( $footer_section->footer_titles->footer_title_4 ),
								) );
							?>
						</div><!-- .col -->
						<?php endif; ?>
						<?php if ( !empty( $footer_section->footer_titles->footer_title_5 ) ) : ?>
						<div class="col">
							<h5 class="footer-title menu-title-programs"><?php echo $footer_section->footer_titles->footer_title_5; ?></h5>
							<?php
								wp_nav_menu( array(
								    'theme_location'   => 'menu-programs',
								    'menu_class'		=> 'wonka-footer-menu wonka-footer-menu-' . strtolower( $footer_section->footer_titles->footer_title_5 ),
								) );
							?>
						</div><!-- .col -->
						<?php endif; ?>
					</div><!-- .row -->
					<div class="row align-items-center justify-content-end email-form">
						<?php if ( !empty( $footer_section->footer_mods->footer_form_shortcode ) ) : ?>
							<div class="col col-12 col-md-8">
								<?php
									_e( "<small>Sign up to get the latest on sales, new releases and more...</small><br />" );
									_e( do_shortcode( $footer_section->footer_mods->footer_form_shortcode ) );
								?>
							</div> <!-- .col -->
						<?php endif; ?>
					</div> <!-- .row -->
				</div><!-- .col-9 -->
		</div> <!-- .row -->

		<div class="site-info row align-items-center">
			<!-- This column is still parsed in order to hold spacing for formating -->
			<div class="col col-12 col-md-2 offset-md-1 footer-logo">
				<?php if ( !empty( $footer_section->footer_mods->footer_logo ) ) : ?>
				<?php echo sprintf( __( '<img src="%1$s" alt="Apera logo" />', 'apera-bags' ), $footer_section->footer_mods->footer_logo ); ?>
				<?php endif; ?>
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
<!-- Return to Top -->
<a href="javascript:" id="return-to-top"><i class="fa fa-angle-up"></i></a>
<?php wp_footer(); ?>
</body>
</html>
