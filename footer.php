<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package aperabags
 */

do_action( 'get_mods_before_section', 'footer' );
$footer_section = get_section_mods( 'footer' );
?>

	</div><!-- #content .container-fluid -->
	<div id="footer-spacer"></div>
	<footer id="colophon" class="site-footer">
		<div class="container-fluid">
			<div class="row upper-footer wonka-row-footer">
				<div class="col col-12 col-lg-4 col-sm-6">
					<div class="row wonka-row-footer">
						<?php if ( ! empty( $footer_section->footer_titles->footer_title_1 ) ) : ?>
							<div class="col-12 col-lg">
								<?php
									wp_nav_menu(
										array(
											'theme_location'   => 'menu-footer',
											'menu_class'        => 'wonka-footer-menu wonka-footer-menu-' . strtolower( $footer_section->footer_titles->footer_title_1 ),
										)
									);
								?>
							</div><!-- .col -->
						<?php endif; ?>

					</div><!-- .row -->
				</div><!-- .col-4 -->

				<div class="col col-12 col-lg-4 col-sm-6 order-lg-3 order-2">
					<div class="social-components-wrap">
						<h4 class="footer-title"><?php echo $footer_section->footer_mods->footer_social_title; ?></h4>
						<div class="social-icons-btns">
							<?php
							if ( ! empty( $footer_section->footer_mods->footer_social_instagram ) ) {
								echo '<a href="' . $footer_section->footer_mods->footer_social_instagram . '" target="_blank"><i class="fa fa-instagram"></i></a>';
							}

							if ( ! empty( $footer_section->footer_mods->footer_social_twitter ) ) {
								echo '<a href="' . $footer_section->footer_mods->footer_social_twitter . '" target="_blank"><i class="fa fa-twitter"></i></a>';
							}

							if ( ! empty( $footer_section->footer_mods->footer_social_facebook ) ) {
								echo '<a href="' . $footer_section->footer_mods->footer_social_facebook . '" target="_blank"><i class="fa fa-facebook"></i></a>';
							}

							if ( ! empty( $footer_section->footer_mods->footer_social_pinterest ) ) {
								echo '<a href="' . $footer_section->footer_mods->footer_social_pinterest . '" target="_blank"><i class="fa fa-pinterest"></i></a>';
							}
							?>
						</div><!-- .social-icons-btns -->
						<?php if ( ! empty( $footer_section->footer_mods->footer_contact_message ) ) : ?>
							<div class="footer-contact-message">
								<?php echo $footer_section->footer_mods->footer_contact_message; ?>
							</div> <!-- .col -->
						<?php endif; ?>
						<?php if ( ! empty( $footer_section->footer_mods->footer_contact_support_email ) ) : ?>
							<div class="footer-contact-email">
								<?php echo "<a href='mailto:" . $footer_section->footer_mods->footer_contact_support_email . "'>" . $footer_section->footer_mods->footer_contact_support_email . '</a>'; ?>
							</div> <!-- .col -->
						<?php endif; ?>
					</div><!-- .social-components-wrap -->
				</div><!-- .col -->
				<div class="col col-12 col-lg-4 order-3 order-sm-2">
					<div class="row align-items-end justify-content-center wonka-email-form">
					<?php _e('<h5 class="footer-title menu-title-shop pb-2">KEEP IN TOUCH!</h5>') ?>
						<?php if ( ! empty( $footer_section->footer_mods->footer_form_shortcode ) ) : ?>
							<div class="col col-12">
								<?php
									_e( do_shortcode( $footer_section->footer_mods->footer_form_shortcode ) );

								?>
							</div> <!-- .col -->
						<?php endif; ?>
					</div> <!-- .row -->
				</div>
		</div> <!-- .row -->

		<div class="site-info row align-items-center">
			<!-- This column is still parsed in order to hold spacing for formating -->
			<div class="col col-12 col-md-2 offset-md-1 footer-logo">
				<?php if ( ! empty( $footer_section->footer_mods->footer_logo ) ) : ?>
					<?php echo sprintf( __( '<img src="%1$s" alt="Apera logo" />', 'apera-bags' ), $footer_section->footer_mods->footer_logo ); ?>
				<?php endif; ?>
			</div> <!-- .col -->
			<!-- End logo spacing column -->
			<div class="col col-12 col-md-8 text-right">
				<?php
					/* Printing copyright date */
					echo sprintf( esc_html__( '%1$s %2$s Apera LLC, All Rights Reserved', 'apera-bags' ), date( 'Y' ), '&copy;' );
				?>
			<span class="sep"> | </span>
				<?php
					/* translators: 1: Theme name, 2: Theme author. */
					echo sprintf( esc_html__( 'Designed by %1$s.', 'apera-bags' ), '<a href="https://wonkasoft.com" target="_blank">Wonkasoft</a>' );
				?>
			</div><!-- .col -->
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
<?php
$newsletter_section = get_section_mods( 'newsletter' );
$user_id = get_current_user_id();

if ( isset( $_COOKIE['wonkasoft_newsletter_popup'] ) ) :
	$user_cookie = $_COOKIE['wonkasoft_newsletter_popup'];
	$user_cookie = str_replace( '\\', '', $user_cookie );
	$user_cookie = json_decode( $user_cookie );
else :
	$user_cookie = new stdclass();
	$user_cookie->show = true;
endif;
if ( ! empty( $newsletter_section ) && $newsletter_section->newsletter_mods->enable_popup && $user_cookie->show ) :
	$bg_img = ( ! empty( $newsletter_section->newsletter_mods->background_image ) ) ? $newsletter_section->newsletter_mods->background_image : '';
	$bg_color = ( ! empty( $newsletter_section->newsletter_mods->background_color ) ) ? $newsletter_section->newsletter_mods->background_color : '';
	if ( ! empty( $newsletter_section->newsletter_mods->background_color ) ) :
		$wrap_styles = ' style="background: ' . $newsletter_section->newsletter_mods->background_color . ';"';
	elseif ( ! empty( $newsletter_section->newsletter_mods->background_image ) ) :
		$wrap_styles = ' style="background: url(' . $newsletter_section->newsletter_mods->background_image . ');"';
	else :
		$wrap_styles = '';
	endif;
	?>
	<div class="wonka-newsletter-wrap"<?php echo $wrap_styles; ?>>
		<div class="wonka-newsletter-content">
			<div class="wonka-newsletter-close-btn-wrap">
				<a href="#" class="wonka-newsletter-close-btn">
					<span class="newsletter-close-btn">X</span>
				</a>
			</div>
			<header class="wonka-newsletter-header">
				<h5 class="popup-header-text"><?php echo $newsletter_section->newsletter_mods->message_text; ?></h5>
			</header>
			<main class="wonka-newsletter-body">
				<?php if ( ! empty( $newsletter_section->newsletter_mods->popup_form_select ) ) : ?>
					<div class="wonka-newsletter-form-wrap">
						<?php echo do_shortcode( '[gravityform id="' . $newsletter_section->newsletter_mods->popup_form_select . '" title="false" description="false" ajax="true"]' ); ?>
					</div>
				<?php endif; ?>
			</main>
			<footer class="wonka-newsletter-footer">
			</footer>
		</div>
	</div>
	<?php
endif;
?>
</div><!-- #page -->
<!-- Return to Top -->
<a href="javascript:" id="return-to-top"><i class="fa fa-angle-up"></i></a>
<div id="search_overlay" class="overlay">
  <span class="closebtn" title="Close Overlay">x</span>
  <div class="overlay-content">
	<?php get_search_form(); ?>
  </div>
</div>
<?php wp_footer(); ?>
</body>
</html>
