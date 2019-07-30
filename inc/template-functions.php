<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package aperabags
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function apera_bags_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'apera_bags_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function apera_bags_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'apera_bags_pingback_header' );

/**
 * This will return an object of the section mods
 *
 * @param  string $section pass in the section for the mods desired
 * @return object          returns an object of the mods for the passed section
 */
function get_section_mods( $section ) {
	return the_mods_for_section( $section );
}
/**
 * This grabs all slides that are set in the customizer for the section that is passed in.
 *
 * @param  string $section should be a section reference example: top, cta, cause
 * @return bool/object    returns false if no slides are set in customizer
 */
function the_mods_for_section( $section ) {
	$mods_class = new stdClass();
	$count = 0;
	if ( $section == 'top' ) :
		$mods_class->slides                                             = new stdClass();
		for ( $i = 1; $i <= 5; $i++ ) {
			if ( ! empty( get_theme_mod( 'slider_' . $i ) ) ) :
				$count++;
				$slide                                                              = new stdClass();
				$slide->slide_img                                           = get_theme_mod( 'slider_' . $i );
				$slide->slide_text_position                     = get_theme_mod( 'slider_text_position_' . $i );
				$slide->slide_header_message                    = get_theme_mod( 'slider_header_' . $i );
				$slide->slide_subheader                             = get_theme_mod( 'slider_subheader_' . $i );
				$slide->slide_link_btn                              = get_theme_mod( 'slider_btn_text_' . $i );
				$slide->slide_link                                      = get_theme_mod( 'slider_btn_link_' . $i );
				// Mobile theme mod
				$slide->slide_mobile_img                            = get_theme_mod( 'slider_mobile_' . $i );

				$mods_class->slides->{"slide_{$i}"}     = $slide;
			endif;
		}

		$mods_class->slides->count = $count;

		return $mods_class;
	endif;

	if ( $section == 'shop' ) :

		if ( ! empty( get_theme_mod( 'shop_title' ) ) ) :
			$count++;
			$shop                                                                   = new stdClass();
			$shop->shop_title                                               = get_theme_mod( 'shop_title' );
			$shop->shop_background_image                        = get_theme_mod( 'shop_background_image' );
			$shop->enable_sale_banner                               = get_theme_mod( 'enable_sale_banner' );
			$shop->shop_product_per_row                         = get_theme_mod( 'shop_product_per_row' );
			$shop->shop_num_of_products                         = get_theme_mod( 'shop_num_of_products' );

			$mods_class->{'shop_mods'} = $shop;
			$mods_class->{'shop_mods'}->count           = $count;
		endif;

		return $mods_class;
	endif;

	if ( $section == 'cta' ) :
		$mods_class->slides = new stdClass();
		for ( $i = 1; $i <= 5; $i++ ) {
			if ( ! empty( get_theme_mod( 'cta_slider_' . $i ) ) ) :
				$count++;
				$slide                                                              = new stdClass();
				$slide->slide_img                                           = get_theme_mod( 'cta_slider_' . $i );
				$slide->slide_text_position                     = get_theme_mod( 'cta_slider_text_position_' . $i );
				$slide->slide_text_message                      = get_theme_mod( 'cta_slider_text_' . $i );
				$slide->slide_link_btn                              = get_theme_mod( 'cta_slider_btn_text_' . $i );
				$slide->slide_link                                      = get_theme_mod( 'cta_slider_btn_link_' . $i );
				// Mobile Theme mod
				$slide->slide_mobile_img                            = get_theme_mod( 'cta_slider_mobile_' . $i );

				$mods_class->slides->{"slide_{$i}"}     = $slide;
			endif;
		}

		$mods_class->slides->count = $count;

		return $mods_class;
	endif;

	if ( $section == 'cause' ) :

		if ( ! empty( get_theme_mod( 'cause_section_title' ) ) ) :

			$count++;
			$cause                                                                  = new stdClass();
			$cause->cause_section_title                         = get_theme_mod( 'cause_section_title' );
			$cause->cause_section_background                = get_theme_mod( 'cause_section_background' );

			$mods_class->{'cause_mods'} = $cause;
			$mods_class->{'cause_mods'}->count          = $count;
		endif;

		$count = 0;
		$mods_class->causes                                             = new stdClass();
		for ( $i = 1; $i <= 3; $i++ ) {
			if ( ! empty( get_theme_mod( 'cause_image_' . $i ) ) ) :
				$count++;
				${"cause_$i"}                                               = new stdClass();
				${"cause_$i"}->img                                      = get_theme_mod( 'cause_image_' . $i );
				${"cause_$i"}->position                             = get_theme_mod( 'cause_message_position_' . $i );
				${"cause_$i"}->header                                   = get_theme_mod( 'cause_header_' . $i );
				${"cause_$i"}->message                              = get_theme_mod( 'cause_message_' . $i );

				$mods_class->causes->{"cause_$i"}       = ${"cause_$i"};

			endif;
		}

		$mods_class->causes->count = $count;

		return $mods_class;
	endif;

	if ( $section == 'about' ) :
		if ( ! empty( get_theme_mod( 'about_the_brand_header' ) ) ) :
			$count++;
			$about                                                                  = new stdClass();
			$about->about_header                                        = get_theme_mod( 'about_the_brand_header' );
			$about->about_subheader                                 = get_theme_mod( 'about_the_brand_subheader' );
			$about->about_message                                   = get_theme_mod( 'about_the_brand_message' );
			$about->about_the_brand_btn_text                = get_theme_mod( 'about_the_brand_btn_text' );
			$about->about_the_brand_button_link         = get_permalink( get_theme_mod( 'about_the_brand_button_link' ) );
			$about->about_the_brand_second_image        = get_theme_mod( 'about_the_brand_second_image' );

			$mods_class->{'about_the_brand'}                = $about;
			$mods_class->{'about_the_brand'}->count = $count;
		endif;

		return $mods_class;
	endif;

	if ( $section == 'social' ) :
		if ( ! empty( get_theme_mod( 'social_section_title' ) ) ) :
			$count++;
			$social                                                                 = new stdClass();
			$social->social_title                                       = get_theme_mod( 'social_section_title' );
			$social->social_message                                 = get_theme_mod( 'social_section_message' );
			$social->social_shortcode                               = get_theme_mod( 'social_shortcode' );
			$social->social_btn_text                                = get_theme_mod( 'social_btn_text' );
			$social->social_shop_button                         = get_permalink( get_theme_mod( 'social_shop_button' ) );

			$mods_class->{'social_mods'}                        = $social;
		endif;

		$mods_class->count                                              = $count;

		return $mods_class;
	endif;

	if ( $section == 'footer' ) :
		if ( ! empty( get_theme_mod( 'footer_social_instagram' ) ) ) :
			$count++;
			$footer                                                                 = new stdClass();
			$footer->footer_social_title                        = get_theme_mod( 'footer_social_title' );
			$footer->footer_social_instagram                = get_theme_mod( 'footer_social_instagram' );
			$footer->footer_social_twitter                  = get_theme_mod( 'footer_social_twitter' );
			$footer->footer_social_facebook                 = get_theme_mod( 'footer_social_facebook' );
			$footer->footer_social_pinterest                = get_theme_mod( 'footer_social_pinterest' );
			$footer->footer_contact_message                 = get_theme_mod( 'footer_contact_message' );
			$footer->footer_contact_support_email       = get_theme_mod( 'footer_contact_support_email' );
			$footer->footer_logo                                        = get_theme_mod( 'footer_logo' );
			$footer->footer_form_shortcode                  = get_theme_mod( 'footer_form_shortcode' );

			$mods_class->{'footer_mods'}                        = $footer;
			$mods_class->{'footer_mods'}->count         = $count;
		endif;

		$count = 0;
		$mods_class->footer_titles = new stdClass();
		for ( $i = 1; $i <= 5; $i++ ) {
			if ( ! empty( get_theme_mod( 'footer_menu_header_' . $i ) ) ) :
				$count++;
				$mods_class->footer_titles->{"footer_title_$i"} = get_theme_mod( 'footer_menu_header_' . $i );
			endif;
		}

		$mods_class->footer_titles->count               = $count;

		return $mods_class;
	endif;

	if ( $section === 'newsletter' ) :
		if ( ! empty( get_theme_mod( 'enable_newsletter_popup' ) ) ) :
			$count++;
			$newsletter                                                         = new stdClass();
			$newsletter->enable_popup                               = get_theme_mod( 'enable_newsletter_popup' );
			$newsletter->message_text                               = get_theme_mod( 'newsletter_popup_message_text' );
			$newsletter->background_image                       = get_theme_mod( 'newsletter_background_image' );
			$newsletter->background_color                       = ( ! empty( get_theme_mod( 'newsletter_background_color' ) ) ) ? get_theme_mod( 'newsletter_background_color' ) : '#ffffff';
			$newsletter->popup_form_select                  = get_theme_mod( 'newsletter_popup_form_select' );
			$newsletter->session_length                         = ( ! empty( get_theme_mod( 'newsletter_popup_message_session_length' ) ) ) ? get_theme_mod( 'newsletter_popup_message_session_length' ) : 24;

			$mods_class->{'newsletter_mods'}                = $newsletter;
		endif;

		$mods_class->count                                              = $count;

		return $mods_class;
	endif;

	return false;
}
add_action( 'get_mods_before_section', 'the_mods_for_section', 10, 1 );

/*
====================================================
=            Customizing of Gravity forms            =
====================================================*/
/**
 * adding bootstrap classes to the form elements
 *
 * @param array $form         contains the form elements to work with
 * @param array $ajax
 * @param array $field_values this is an array of the field values
 */
function add_bootstrap_container_class( $form, $ajax, $field_values ) {
	$inline_forms = array( 'Sign Up', 'Popup' );
	if ( ! empty( $form['cssClass'] ) ) :
		$form['cssClass'] .= ' wonka-gform wonka-gform-' . $form['id'];
	else :
		$form['cssClass'] = 'wonka-gform wonka-gform-' . $form['id'];
	endif;

	if ( in_array( $form['title'], $inline_forms ) ) :
		$form['cssClass'] .= ' form-inline wonka-newsletter-form';
	endif;

	foreach ( $form['fields'] as $field ) :
		$field['cssClass'] = 'form-group wonka-form-group';
		$field['size'] = 'form-control wonka-form-control';

		if ( empty( $field['placeholder'] ) ) :
			$field['placeholder'] = $field['label'];
		endif;
	endforeach;

	return $form;
}
add_filter( 'gform_pre_render', 'add_bootstrap_container_class', 10, 6 );

/**
 * adding classes to gform buttons
 *
 * @param  object $button contains the html of the button
 * @param  object $form   contains the html of the form
 * @return string         returns the classes that are set for the button
 */
function wonka_add_classes_to_button( $button, $form ) {
	$dom = new DOMDocument();
	$dom->loadHTML( $button );
	$input = $dom->getElementsByTagName( 'input' )->item( 0 );
	$classes = $input->getAttribute( 'class' );
	$classes .= ' wonka-btn';
	$input->setAttribute( 'class', $classes );

	return $dom->saveHtml( $input );
}

add_filter( 'gform_submit_button', 'wonka_add_classes_to_button', 8, 2 );
/*=====  End of Customizing of Gravity forms  ======*/

/**
 * This will check is screen is an admin screen
 */
if ( ! function_exists( 'is_admin_page' ) ) {

	function is_admin_page() {
		if ( function_exists( 'check_admin_referer' ) ) {
			return true;
		} else {
			return false;
		}
	}
}

function aperabags_add_theme_options() {
	add_options_page(
		'Aperabags Theme Options',
		'Theme Options',
		'manage_options',
		'aperabags-theme-options',
		'aperabags_theme_options_page'
	);

	$google_api_key_args = array(
		'type'              => 'string',
		'description'       => 'holds google api key for this site.',
		'sanitize_callback' => 'aperabags_options_sanitize',
		'show_in_rest'      => false,
	);

	$facebook_api_key_args = array(
		'type'              => 'string',
		'description'       => 'holds facebook api key for this site.',
		'sanitize_callback' => 'aperabags_options_sanitize',
		'show_in_rest'      => false,
	);

	$twitter_api_key_args = array(
		'type'              => 'string',
		'description'       => 'holds twitter api key for this site.',
		'sanitize_callback' => 'aperabags_options_sanitize',
		'show_in_rest'      => false,
	);

	$wonkasoft_ga_id = array(
		'type'              => 'string',
		'description'       => 'holds google analytics id.',
		'sanitize_callback' => 'aperabags_options_sanitize',
		'show_in_rest'      => false,
	);

	register_setting( 'aperabags-theme-options-group', 'google_api_key', $google_api_key_args );
	register_setting( 'aperabags-theme-options-group', 'facebook_api_key', $facebook_api_key_args );
	register_setting( 'aperabags-theme-options-group', 'twitter_api_key', $twitter_api_key_args );
	register_setting( 'aperabags-theme-options-group', 'wonkasoft_ga_id', $wonkasoft_ga_id );
}

add_action( 'admin_menu', 'aperabags_add_theme_options' );

function aperabags_options_sanitize( $option ) {
	$option = esc_html( $option );
	return $option;
}

function aperabags_theme_options_page() {
	?>
		<div class="container">
			<div class="row">
				<div class="col-12 title-column">
					<h3 class="title-header"><?php echo get_admin_page_title(); ?></h3>
				</div>
			</div>
			<div class="row">
				<div class="col-12 options column">
					<div class="card w-100">
						<div class="card-body">
					<form method="post" action="options.php">

					  <?php settings_fields( 'aperabags-theme-options-group' ); ?>

					  <?php do_settings_sections( 'aperabags-theme-options-group' ); ?>

							<?php
								$current_google_api_key = ( ! empty( get_option( 'google_api_key' ) ) ) ? get_option( 'google_api_key' ) : '';
								wonkasoft_theme_option_parse(
									array(
										'id'                => 'google_api_key',
										'label'             => __( 'Google API Key', 'apera-bags' ),
										'value'             => $current_google_api_key,
										'desc_tip'          => true,
										'description'       => __( 'Place Google API Key here.', 'apera-bags' ),
										'wrapper_class'     => 'form-row form-row-full form-group',
										'class'             => 'form-control',
										'api'               => 'google',
									)
								);

								$current_facebook_api_key = ( ! empty( get_option( 'facebook_api_key' ) ) ) ? get_option( 'facebook_api_key' ) : '';
								wonkasoft_theme_option_parse(
									array(
										'id'                => 'facebook_api_key',
										'label'             => __( 'Facebook API Key', 'apera-bags' ),
										'value'             => $current_facebook_api_key,
										'desc_tip'          => true,
										'description'       => __( 'Place Facebook API Key here.', 'apera-bags' ),
										'wrapper_class'     => 'form-row form-row-full form-group',
										'class'             => 'form-control',
										'api'               => 'facebook',
									)
								);

								$current_twitter_api_key = ( ! empty( get_option( 'twitter_api_key' ) ) ) ? get_option( 'twitter_api_key' ) : '';
								wonkasoft_theme_option_parse(
									array(
										'id'                => 'twitter_api_key',
										'label'             => __( 'Twitter API Key', 'apera-bags' ),
										'value'             => $current_twitter_api_key,
										'desc_tip'          => true,
										'description'       => __( 'Place Twitter API Key here.', 'apera-bags' ),
										'wrapper_class'     => 'form-row form-row-full form-group',
										'class'             => 'form-control',
										'api'               => 'twitter',
									)
								);

								$current_wonkasoft_ga_id = ( ! empty( get_option( 'wonkasoft_ga_id' ) ) ) ? get_option( 'wonkasoft_ga_id' ) : '';
								wonkasoft_theme_option_parse(
									array(
										'id'                => 'wonkasoft_ga_id',
										'label'             => __( 'Google Analytics ID', 'apera-bags' ),
										'value'             => $current_wonkasoft_ga_id,
										'desc_tip'          => true,
										'description'       => __( 'Place Google Analytics ID here.', 'apera-bags' ),
										'wrapper_class'     => 'form-row form-row-full form-group',
										'class'             => 'form-control',
										'api'               => 'ga',
									)
								);
							?>
				<div class="submitter">

								  <?php submit_button( 'Save Settings' ); ?>

				</div>
				</form>
						  </div>
					</div><!-- card w-100 -->
				</div>
			</div>
		</div>
	<?php
}

function wonkasoft_theme_option_parse( $field ) {

	$field['class']         = isset( $field['class'] ) ? $field['class'] : 'select short';
	$field['style']         = isset( $field['style'] ) ? $field['style'] : '';
	$field['wrapper_class'] = isset( $field['wrapper_class'] ) ? $field['wrapper_class'] : '';
	$field['value']         = isset( $field['value'] ) ? $field['value'] : '';
	$field['name']          = isset( $field['name'] ) ? $field['name'] : $field['id'];
	$field['desc_tip']      = isset( $field['desc_tip'] ) ? $field['desc_tip'] : false;
	$styles_set = ( ! empty( $field['style'] ) ) ? ' style="' . esc_attr( $field['style'] ) . '" ' : '';

	// Custom attribute handling
	$custom_attributes = array();
	$output = '';

	if ( ! empty( $field['custom_attributes'] ) && is_array( $field['custom_attributes'] ) ) {

		foreach ( $field['custom_attributes'] as $attribute => $value ) {
			$custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $value ) . '"';
		}
	}

	$output .= '<p class="form-field ' . esc_attr( $field['id'] ) . '_field ' . esc_attr( $field['wrapper_class'] ) . '">
		<label for="' . esc_attr( $field['id'] ) . '">' . wp_kses_post( $field['label'] ) . '</label>';

	if ( ! empty( $field['description'] ) && false !== $field['desc_tip'] ) {
		$output .= wc_help_tip( $field['description'] );
	}

	if ( $field['api'] === 'ga' ) :
		$place_holder = ' placeholder="UA-XXXXXX-X"';
	else :
		$place_holder = ' placeholder="Paste api key..."';
	endif;
	$output .= '<input type="password" id="' . esc_attr( $field['id'] ) . '" name="' . esc_attr( $field['name'] ) . '" class="' . esc_attr( $field['class'] ) . '" ' . $styles_set . implode( ' ', $custom_attributes ) . ' value="' . esc_attr( $field['value'] ) . '"' . $place_holder . ' /> ';

	if ( ! empty( $field['description'] ) && false !== $field['desc_tip'] ) {
		$output .= '<span class="description">' . wp_kses_post( $field['description'] ) . '</span>';
	}

	$output .= '</p>';

	_e( $output );
}

function wonkasoft_get_meta_boxes( $post_type, $post ) {
	add_meta_box(
		'authorshowdiv',
		'Author Display',
		'author_display_meta_box',
		'post',
		'side',
		'high',
		array(
			'label' => 'Author Display Off',
			'option_name' => 'author_no_display',
		)
	);
}

add_action( 'add_meta_boxes', 'wonkasoft_get_meta_boxes', 10, 2 );

function author_display_meta_box( $post, $option ) {
	wp_nonce_field( 'author_display_option', 'author_display_wpnonce', true, true );
	$checked = ( get_post_meta( $post->ID, $option['args']['option_name'], false ) ) ? ' checked="true"' : '';
	$output = '';

	$output .= '<div class="form-check">';
	$output .= '<input type="checkbox" name="' . esc_attr( $option['args']['option_name'] ) . '" id="' . esc_attr( $option['args']['option_name'] ) . '" class="form-check-input"' . $checked . ' />';
	$output .= '<label class="option-title form-check-label">' . __( $option['args']['label'], 'apera-bags' ) . '</label>';
	$output .= '</div>';

	_e( $output );
}

function wonkasoft_save_author_display( $post_id, $post ) {
	// Add nonce for security and authentication.
	$nonce_name   = isset( $_POST['author_display_wpnonce'] ) ? $_POST['author_display_wpnonce'] : '';
	$nonce_action = 'author_display_option';

	// Check if nonce is valid.
	if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
		return;
	}

	// Check if user has permissions to save data.
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// Check if not an autosave.
	if ( wp_is_post_autosave( $post_id ) ) {
		return;
	}

	// Check if not a revision.
	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}
}

add_action( 'save_post', 'wonkasoft_save_author_display', 10, 2 );

/*
======================================================================
=            This is the ajax call for the newsletter popup            =
======================================================================*/
function wonkasoft_dismiss_popup() {

	check_ajax_referer( 'ws-request-nonce', 'security' );

	$wonkasoft_popup_cookie = array(
		'user_id'                           => get_current_user_id(),
		'show'                              => false,
		'time_of_visit'             => time(),
	);

	$wonkasoft_popup_cookie = json_encode( $wonkasoft_popup_cookie );

	if ( isset( $_COOKIE['wonkasoft_newsletter_popup'] ) ) :
		unset( $_COOKIE['wonkasoft_newsletter_popup'] );
		setcookie( 'wonkasoft_newsletter_popup', $wonkasoft_popup_cookie, time() + 60 * 60 * get_theme_mod( 'newsletter_popup_message_session_length' ), '/' );
	endif;

	if ( ! isset( $_COOKIE['wonkasoft_newsletter_popup'] ) ) :
		setcookie( 'wonkasoft_newsletter_popup', $wonkasoft_popup_cookie, time() + 60 * 60 * get_theme_mod( 'newsletter_popup_message_session_length' ), '/' );
	endif;

	wp_send_json_success( $wonkasoft_popup_cookie );
}

add_action( 'wp_ajax_wonkasoft_dismiss_popup', 'wonkasoft_dismiss_popup', 10 );
add_action( 'wp_ajax_nopriv_wonkasoft_dismiss_popup', 'wonkasoft_dismiss_popup', 10 );

function wonkasoft_theme_popup_cookie() {

	if ( ! empty( get_theme_mod( 'enable_newsletter_popup' ) ) ) :

		$wonkasoft_popup_cookie = array(
			'user_id'                           => get_current_user_id(),
			'show'                              => true,
			'time_of_visit'             => time(),
		);

		$wonkasoft_popup_cookie = json_encode( $wonkasoft_popup_cookie );

		if ( ! isset( $_COOKIE['wonkasoft_newsletter_popup'] ) ) :
			setcookie( 'wonkasoft_newsletter_popup', $wonkasoft_popup_cookie, time() + 60 * 60 * get_theme_mod( 'newsletter_popup_message_session_length' ), '/' );
		endif;
	endif;

}

add_action( 'init', 'wonkasoft_theme_popup_cookie', 10 );

function wonkasoft_newsletter_popup_entry( $entry, $form ) {

	$user_id = get_current_user_id();
	$form_title = str_replace( ' ', '-', strtolower( $form['title'] ) );

	if ( $form_title === 'popup' ) :

		$wonkasoft_popup_cookie = array(
			'user_id'                           => get_current_user_id(),
			'show'                              => false,
			'time_of_visit'             => time(),
		);

		$wonkasoft_popup_cookie = json_encode( $wonkasoft_popup_cookie );

		if ( isset( $_COOKIE['wonkasoft_newsletter_popup'] ) ) :
			unset( $_COOKIE['wonkasoft_newsletter_popup'] );
			setcookie( 'wonkasoft_newsletter_popup', $wonkasoft_popup_cookie, time() + 60 * 60 * 24 * 365, '/' );
		endif;

		if ( ! isset( $_COOKIE['wonkasoft_newsletter_popup'] ) ) :
			setcookie( 'wonkasoft_newsletter_popup', $wonkasoft_popup_cookie, time() + 60 * 60 * 24 * 365, '/' );
		endif;
	endif;

	if ( $form_title === 'sign-up' ) :

		$wonkasoft_popup_cookie = array(
			'user_id'                           => get_current_user_id(),
			'show'                              => false,
			'time_of_visit'             => time(),
		);

		$wonkasoft_popup_cookie = json_encode( $wonkasoft_popup_cookie );

		if ( isset( $_COOKIE['wonkasoft_newsletter_popup'] ) ) :
			unset( $_COOKIE['wonkasoft_newsletter_popup'] );
			setcookie( 'wonkasoft_newsletter_popup', $wonkasoft_popup_cookie, time() + 60 * 60 * 24 * 365, '/' );
		endif;

		if ( ! isset( $_COOKIE['wonkasoft_newsletter_popup'] ) ) :
			setcookie( 'wonkasoft_newsletter_popup', $wonkasoft_popup_cookie, time() + 60 * 60 * 24 * 365, '/' );
		endif;
	endif;

	return;
}

add_action( 'gform_after_submission', 'wonkasoft_newsletter_popup_entry', 10, 2 );
/*=====  End of This is the ajax call for the newsletter popup  ======*/

/**
 * Allow to remove method for an hook when, it's a class method used and class don't have global for instanciation !
 */
function ws_remove_filters_with_method_name( $hook_name = '', $method_name = '', $priority = 0 ) {
	global $wp_filter;
	// Take only filters on right hook name and priority
	if ( ! isset( $wp_filter[ $hook_name ][ $priority ] ) || ! is_array( $wp_filter[ $hook_name ][ $priority ] ) ) {
		return false;
	}
	// Loop on filters registered
	foreach ( (array) $wp_filter[ $hook_name ][ $priority ] as $unique_id => $filter_array ) {
		// Test if filter is an array ! (always for class/method)
		if ( isset( $filter_array['function'] ) && is_array( $filter_array['function'] ) ) {
			// Test if object is a class and method is equal to param !
			if ( is_object( $filter_array['function'][0] ) && get_class( $filter_array['function'][0] ) && $filter_array['function'][1] == $method_name ) {
				// Test for WordPress >= 4.7 WP_Hook class (https://make.wordpress.org/core/2016/09/08/wp_hook-next-generation-actions-and-filters/)
				if ( is_a( $wp_filter[ $hook_name ], 'WP_Hook' ) ) {
					unset( $wp_filter[ $hook_name ]->callbacks[ $priority ][ $unique_id ] );
				} else {
					unset( $wp_filter[ $hook_name ][ $priority ][ $unique_id ] );
				}
			}
		}
	}
	return false;
}
/**
 * Allow to remove method for an hook when, it's a class method used and class don't have variable, but you know the class name :)
 */
function ws_remove_filters_for_anonymous_class( $hook_name = '', $class_name = '', $method_name = '', $priority = 0 ) {
	global $wp_filter;
	// Take only filters on right hook name and priority
	if ( ! isset( $wp_filter[ $hook_name ][ $priority ] ) || ! is_array( $wp_filter[ $hook_name ][ $priority ] ) ) {
		return false;
	}
	// Loop on filters registered
	foreach ( (array) $wp_filter[ $hook_name ][ $priority ] as $unique_id => $filter_array ) {
		// Test if filter is an array ! (always for class/method)
		if ( isset( $filter_array['function'] ) && is_array( $filter_array['function'] ) ) {
			// Test if object is a class, class and method is equal to param !
			if ( is_object( $filter_array['function'][0] ) && get_class( $filter_array['function'][0] ) && get_class( $filter_array['function'][0] ) == $class_name && $filter_array['function'][1] == $method_name ) {
				// Test for WordPress >= 4.7 WP_Hook class (https://make.wordpress.org/core/2016/09/08/wp_hook-next-generation-actions-and-filters/)
				if ( is_a( $wp_filter[ $hook_name ], 'WP_Hook' ) ) {
					unset( $wp_filter[ $hook_name ]->callbacks[ $priority ][ $unique_id ] );
				} else {
					unset( $wp_filter[ $hook_name ][ $priority ][ $unique_id ] );
				}
			}
		}
	}
	return false;
}
