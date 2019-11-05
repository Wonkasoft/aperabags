<?php
/**
 * Functions which enhance the theme by ajax requests.
 *
 * @package aperabags
 */

/**
 * Handles the theme options ajax requests.
 */
function theme_options_ajax_post() {
	$nonce = ( isset( $_REQUEST['security'] ) ) ? wp_kses_post( wp_unslash( $_REQUEST['security'] ) ) : null;
	// Check if nonce is valid.
	if ( ! wp_verify_nonce( $nonce, 'theme_options_ajax_post' ) ) {
		die( esc_html__( 'nonce failed', 'aperabags' ) );
	}

	$data = ( isset( $_POST['data'] ) ) ? wp_kses_post( wp_unslash( $_POST['data'] ) ) : null;
	if ( empty( $data ) ) :
		return false;
	endif;

	// Pattern for option name sanitize.
	$pattern = '/([ -])/';

	// Checking for passed in data.
	$data = json_decode( $data );
	unset( $data->action );
	$current_options = ( ! empty( get_option( 'custom_options_added' ) ) ) ? get_option( 'custom_options_added' ) : array();
	if ( $data->remove ) :
		foreach ( $current_options as $key => $current_option ) :
			if ( $data->option_id === $current_option['id'] ) :
				unset( $current_options[ $key ] );
			endif;
		endforeach;
		delete_option( $data->option_id );
		unregister_setting( 'aperabags-theme-options-group', $data->option_id );
		$data->current_options = $current_options;
		update_option( 'custom_options_added', $current_options );
		$data->msg = $data->option_id . ' option was deleted, unregistered as a setting, and the database has been updated.';
		wp_send_json_success( $data );
		else :
			$data->option_label = $data->option_name;
			$data->option_name  = preg_replace( $pattern, '_', strtolower( $data->option_name ) );

			if ( ! in_array( $data->option_name, $current_options ) ) :
				array_push(
					$current_options,
					array(
						'id'          => $data->option_name,
						'label'       => $data->option_label,
						'description' => $data->option_description,
						'api'         => $data->option_api,
					)
				);
				$set_args = array(
					'type'              => 'string',
					'description'       => $data->option_description,
					'sanitize_callback' => 'aperabags_options_sanitize',
					'show_in_rest'      => false,
				);
				register_setting( 'aperabags-theme-options-group', $data->option_name, $set_args );
				update_option( 'custom_options_added', $current_options );
				$data->current_options = $current_options;

				ob_start();
				wonkasoft_theme_option_parse(
					array(
						'id'            => $data->option_name,
						'label'         => $data->option_label,
						'value'         => '',
						'desc_tip'      => true,
						'description'   => $data->option_description,
						'wrapper_class' => 'form-row form-row-full form-group',
						'class'         => 'form-control',
						'api'           => $data->option_api,
					)
				);

				$data->new_elements = ob_get_clean();

				$data->msg = 'Current options have been updated';
				wp_send_json_success( $data );
			else :
				$data->current_options = $current_options;
				$data->msg             = $data->option_name . ' is already a current option.';
				wp_send_json_success( $data );
			endif;
	endif;

}
add_action( 'wp_ajax_theme_options_ajax_post', 'theme_options_ajax_post', 10 );
add_action( 'wp_ajax_nopriv_theme_options_ajax_post', 'theme_options_ajax_post', 10 );

/**
 * This is the ajax call for the newsletter popup.
 */
function wonkasoft_dismiss_popup() {
	check_ajax_referer( 'ws-request-nonce', 'security' );

	$wonkasoft_popup_cookie = array(
		'user_id'       => get_current_user_id(),
		'show'          => false,
		'time_of_visit' => time(),
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

/**
 * This is the ajax call for the YouTube Video Src links for iframe on the home page.
 */
function wonkasoft_add_youtube_source() {

	check_ajax_referer( 'ws-request-nonce', 'security' );

	$source  = array();
	$section = ( isset( $_GET['section'] ) ) ? esc_html( $_GET['section'] ) : '';

	if ( 'cause' === $section ) {

		$cause_video = ( get_theme_mod( 'cause_modal_video' ) ) ? get_theme_mod( 'cause_modal_video' ) : '';

		$source['src'] = '<iframe width="780" height="442" src="https://www.youtube.com/embed/' . wp_kses_data( $cause_video ) . '?mode=opaque&amp;rel=0&amp;autohide=1&amp;showinfo=0&amp;wmode=transparent" frameborder="0" allow="accelerometer; autoplay; gyroscope;" allowfullscreen></iframe>';

	}

	if ( 'about' === $section ) {

		$videocode = ( get_theme_mod( 'about_the_brand_video' ) ) ? get_theme_mod( 'about_the_brand_video' ) : '';

		$source['src'] = '<iframe width="780" height="442" src="https://www.youtube.com/embed/' . wp_kses_data( $videocode ) . '?mode=opaque&amp;rel=0&amp;autohide=1&amp;showinfo=0&amp;wmode=transparent" frameborder="0" allow="accelerometer; autoplay; gyroscope;" allowfullscreen></iframe>';
	}

	wp_send_json_success( $source );
}
add_action( 'wp_ajax_wonkasoft_add_youtube_source', 'wonkasoft_add_youtube_source', 10 );
add_action( 'wp_ajax_nopriv_wonkasoft_add_youtube_source', 'wonkasoft_add_youtube_source', 10 );
