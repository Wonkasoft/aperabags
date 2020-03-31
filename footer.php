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

if ( ! empty( $page_mods ) ) {
	$footer_section = $page_mods->footer_area;
} else {
	$footer_section = get_section_mods( 'footer_area' );
}
do_action( 'get_mods_before_section', 'footer_area', $footer_section );
?>

	</div><!-- #content .container-fluid -->

	<div id="get-10-sidebar"><a href="<?php get_the_permalink( get_page_by_path( 'perks' ) ); ?>">Get $10</div>
	<div id="footer-spacer"></div>
	<footer id="colophon" class="site-footer">
		<div class="container-fluid">
			<div class="row upper-footer wonka-row-footer">
				<div class="col col-12 col-lg-3 offset-lg-1 col-sm-6">
					<div class="row wonka-menu-footer">
						<?php if ( ! empty( $footer_section->footer_titles->footer_title_1 ) ) : ?>
							<div class="col-12 col-lg">
								<?php
									wp_nav_menu(
										array(
											'theme_location' => 'menu-footer',
											'menu_class' => 'wonka-footer-menu wonka-footer-menu-' . strtolower( $footer_section->footer_titles->footer_title_1 ),
										)
									);
								?>
							</div><!-- .col -->
						<?php endif; ?>

					</div><!-- .row -->
				</div><!-- .col-4 -->

				<div class="col col-12 col-lg-4 col-sm-6 order-lg-3 order-2">
					<div class="row social-components-wrap">
						<div class="col-12 col-lg">
							<div class="footer-insta footer-title">
								<?php echo '<a href="' . esc_url( $footer_section->footer_mods->footer_insta_username_link ) . '" target="_blank">' . esc_html( $footer_section->footer_mods->footer_insta_username ) . '</a>'; ?>
								<?php echo '<a href="' . esc_url( $footer_section->footer_mods->footer_insta_hashtag_link ) . '" target="_blank">' . esc_html( $footer_section->footer_mods->footer_insta_hashtag ) . '</a>'; ?>
							</div> <!-- .col -->
							<div class="social-icons-btns text-center">

								<?php
								if ( ! empty( $footer_section->footer_mods->footer_social_instagram ) ) {
									echo '<a href="' . esc_url( $footer_section->footer_mods->footer_social_instagram ) . '" target="_blank"><i class="fa fa-instagram"></i></a>';
								}

								if ( ! empty( $footer_section->footer_mods->footer_social_facebook ) ) {
									echo '<a href="' . esc_url( $footer_section->footer_mods->footer_social_facebook ) . '" target="_blank"><i class="fa fa-facebook"></i></a>';
								}

								if ( ! empty( $footer_section->footer_mods->footer_social_pinterest ) ) {
									echo '<a href="' . esc_url( $footer_section->footer_mods->footer_social_pinterest ) . '" target="_blank"><i class="fa fa-pinterest"></i></a>';
								}

								if ( ! empty( $footer_section->footer_mods->footer_social_twitter ) ) {
									echo '<a href="' . esc_url( $footer_section->footer_mods->footer_social_twitter ) . '" target="_blank"><i class="fa fa-twitter"></i></a>';
								}

								?>
							</div><!-- .social-icons-btns -->
							<?php if ( ! empty( $footer_section->footer_mods->footer_insta_username ) ) : ?>

							<?php endif; ?>
						</div>
					</div><!-- .social-components-wrap -->
				</div><!-- .col -->
				<div class="col col-12 col-lg-4 order-3 order-sm-2">
					<div class="row align-items-end text-center justify-content-center wonka-email-form">
						<?php if ( ! empty( $footer_section->footer_mods->footer_form_shortcode ) ) : ?>
							<div class="col col-10 col-lg-12">
								<?php
									echo wp_kses(
										'<h4 class="footer-title menu-title-shop pb-2">KEEP IN TOUCH!</h4>',
										array(
											'h4' => array(
												'class' => array(),
											),
										)
									);
								?>

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
if ( ! empty( $page_mods ) ) {
	$newsletter_section = $page_mods->newsletter;
} else {
	$newsletter_section = get_section_mods( 'newsletter' );
}
$user_id = get_current_user_id();

if ( isset( $_COOKIE['wonkasoft_newsletter_popup'] ) ) :
	$user_cookie = $_COOKIE['wonkasoft_newsletter_popup'];
	$user_cookie = str_replace( '\\', '', $user_cookie );
	$user_cookie = json_decode( $user_cookie );
else :
	$user_cookie       = new stdclass();
	$user_cookie->show = true;
endif;
if ( ! empty( $newsletter_section ) && $newsletter_section->newsletter_mods->enable_popup && $user_cookie->show && ! is_account_page() && ! is_cart() && ! Is_checkout() ) :
	$bg_img   = ( ! empty( $newsletter_section->newsletter_mods->background_image ) ) ? $newsletter_section->newsletter_mods->background_image : '';
	$bg_color = ( ! empty( $newsletter_section->newsletter_mods->background_color ) ) ? $newsletter_section->newsletter_mods->background_color : '';
	if ( ! empty( $newsletter_section->newsletter_mods->background_color ) ) :
		$wrap_styles = ' style="background: ' . $newsletter_section->newsletter_mods->background_color . ';"';
	elseif ( ! empty( $newsletter_section->newsletter_mods->background_image ) ) :
		$wrap_styles = ' style="background: url(' . $newsletter_section->newsletter_mods->background_image . ');"';
	else :
		$wrap_styles = '';
	endif;
	?>
	<div class="wonka-newsletter-wrap"<?php echo $wrap_styles; ?> time-to-pop="<?php echo $newsletter_section->newsletter_mods->time_to_pop; ?>">
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
				<div class="popup-btn-wrap">
					<a href="<?php echo get_site_url() . '/perks'; ?>" class="wonka-btn img-cta-link text-center"><span>YES!</span></a> <a href="#" class="wonka-btn img-cta-link text-center wonka-newsletter-close-btn"><span class="newsletter-close-btn">MAYBE LATER</span></a>
				</div>
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
	<?php
	get_search_form(
		array(
			'aria_label' => 'main_site_search',
		)
	);
	?>
  </div>
</div>
<?php wp_footer(); ?>
</body>
</html>
