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

?>

</div><!-- #content .container-fluid -->
	<?php
	if ( ! empty( $page_mods ) ) {
		$footer_section = $page_mods->footer_section;
	} else {
		$footer_section = apply_filters( 'wonkasoft_filter_mods_before_footer_section', get_section_mods( 'footer_section' ), );
		$footer_section = $footer_section->footer_section;
	}
	?>
	<?php do_action( 'wonkasoft_action_mods_before_footer_section', 'footer_section', $footer_section ); ?>
	<div id="get-10-sidebar"><a href="<?php _e( get_permalink( get_page_by_path( 'perks' ) ) ); ?>">Get $10</a></div>
	<div id="give-feedback"><a href="javascript:void(zE('webWidget', 'open'))">Questions</a></div>
	<div id="footer-spacer"></div>
	<footer id="colophon" class="site-footer">
		<div class="container-fluid">
			<div class="row upper-footer wonka-row-footer justify-content-around">
				<?php
				foreach ( $footer_section->footer_titles as $title_number => $title ) {
					if ( 'count' !== $title_number ) :
						$new_menu = 'menu-' . preg_replace( '/ /', '-', strtolower( $title ) );
						$col_set  = (int) 2;
						?>
						<div class="col col-6 col-sm-<?php echo $col_set; ?> col-lg-<?php echo $col_set; ?>">
							<div class="row wonka-menu-footer">
									<div class="col">
									<h3 class="<?php echo esc_attr( preg_replace( '/ /', '-', strtolower( $title ) ) ); ?>-title"><?php echo esc_html( $title ); ?></h3>
										<?php
											wp_nav_menu(
												array(
													'theme_location' => $new_menu,
													'menu_class' => 'wonka-footer-menu wonka-footer-menu-' . preg_replace( '/ /', '-', strtolower( $title ) ),
												)
											);
										?>
									</div><!-- .col -->

							</div><!-- .row -->
						</div><!-- .col-3 -->
						<?php
				endif;
				}
				?>
				<?php if ( ! empty( $footer_section->footer_mods->footer_form_shortcode ) ) : ?>
				<div class="col col-6 col-lg-5">
					<div class="row align-items-center text-center justify-content-center">
						<div class="col-11 wonka-email-form">
								<?php
									echo wp_kses(
										'<p class="footer-title pb-2">Save $10 and get free shipping on your first order.</p>',
										array(
											'p' => array(
												'class' => array(),
											),
										)
									);
								?>

								<?php
									_e( do_shortcode( $footer_section->footer_mods->footer_form_shortcode ) );
								?>
							</div> <!-- .col -->
						</div> <!-- .row -->
					</div>
					<?php endif; ?>
				<div class="col col-6">
					<div class="row align-items-end text-center justify-content-center have-a-question">
						<div class="col-12">
							<div class="footer-question footer-title">
								<h4 class="footer-title menu-title-shop pb-2">Have Questions?</h4>
							</div> <!-- .footer-title -->
							<div class="question-body">
								Click the link below to find answers for frequently asked questions, contact Customer Care, and more!
							</div> <!-- .question-body -->
							<div class="question-link-text">
								<a href="javascript:void(zE('webWidget', 'open'))"><i class="fas fa-comment-dots"></i><span>Ask Us Anything</span></a>
							</div> <!-- .question-link-text -->
						</div> <!-- .col -->
					</div> <!-- /.row -->
				</div><!-- .col -->
				<div class="col col-6 align-self-center">
					<div class="footer-insta footer-title">
						<?php // echo '<a href="' . esc_url( $footer_section->footer_mods->footer_insta_username_link ) . '" target="_blank">' . esc_html( $footer_section->footer_mods->footer_insta_username ) . '</a>'; ?>
						<?php // echo '<a href="' . esc_url( $footer_section->footer_mods->footer_insta_hashtag_link ) . '" target="_blank">' . esc_html( $footer_section->footer_mods->footer_insta_hashtag ) . '</a>'; ?>
					</div> <!-- .footer-insta -->
					<div class="social-icons-btns">

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
		</div> <!-- .row -->

		<div class="site-info row align-items-center">
			<!-- This column is still parsed in order to hold spacing for formating -->
			<div class="col col-5 footer-logo">
				<?php if ( ! empty( $footer_section->footer_mods->footer_logo ) ) : ?>
					<?php
					echo wp_kses(
						sprintf( __( '<img src="%1$s" srcset="%2$s" alt="Apera logo" />', 'aperabags' ), wp_get_attachment_image_src( $footer_section->footer_mods->footer_logo, 'small', false )[0], wp_get_attachment_image_srcset( $footer_section->footer_mods->footer_logo, 'small' ) ),
						array(
							'img' => array(
								'class'  => array(),
								'src'    => array(),
								'srcset' => array(),
								'alt'    => array(),
							),
						)
					);
					?>
				<?php endif; ?>
			</div> <!-- .col -->
			<!-- End logo spacing column -->
			<div class="col col-7 text-right">
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
