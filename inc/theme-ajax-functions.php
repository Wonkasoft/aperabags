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

/**
 * This function is for the upgrade button on the my account page.
 */
function wonkasoft_upgrade_account_perks() {
	$nonce = ( isset( $_POST['security'] ) ) ? wp_kses_post( wp_unslash( $_POST['security'] ) ) : '';
	( wp_verify_nonce( $nonce, 'ws-request-nonce' ) ) || die( 'die' );

	if ( isset( $_POST ) ) {
		$user_id = wp_get_current_user()->ID;
		$user    = new WP_User( $user_id );

		$role         = 'apera_perks_partner';
		$role_display = 'Apera Perks Partner';

		$role2         = 'customer';
		$role_display2 = 'Customer';

		$output = array();
		if ( $_POST['user_id'] == $user_id ) {
			if ( ! in_array( $role, $user->roles ) ) :
				$user->add_role( $role, $role_display );
				$output['msg'] = 'role added';
				RSActionRewardModule::award_points_for_account_signup( $user_id );
			endif;

			if ( ! in_array( $role2, $user->roles ) ) :
				$user->add_role( $role2, $role_display2 );
				$output['msg'] = 'roles added';
			endif;
		}
		$output['user_id']    = $user->ID;
		$output['user_roles'] = $user->roles;

		wp_send_json_success( $output );
	}
}
add_action( 'wp_ajax_wonkasoft_upgrade_account_perks', 'wonkasoft_upgrade_account_perks' );
add_action( 'wp_ajax_nopriv_wonkasoft_upgrade_account_perks', 'wonkasoft_upgrade_account_perks' );

/**
 * This ajax request handles account logo parsing and logo conversion fees.
 *
 * @return [type] [description]
 */
function wonkasoft_parse_account_logo_or_process_fees() {
	$nonce = ( isset( $_GET['security'] ) ) ? wp_kses_post( wp_unslash( $_GET['security'] ) ) : '';
	( wp_verify_nonce( $nonce, 'ws-request-nonce' ) ) || die( 'die' );

	$form_id                = ( isset( $_GET['form_id'] ) ) ? wp_kses_post( wp_unslash( $_GET['form_id'] ) ) : null;
	$form                   = GFAPI::get_form( $form_id );
	$output                 = array();
	$output['form_title']   = $form['title'];
	$output['msg']          = '';
	$output['content']      = '';
	$output['consent_text'] = '';

	if ( 'Design Fees Capture' === $form['title'] ) {
		$output['msg'] = 'Confirmation Successful';
		foreach ( $form['fields'] as $key => $field ) {
			if ( 'consent' === $field['type'] ) {
				$output['consent_text'] = $field['description'];
			}
		}

		wp_send_json_success( $output );
	}

	if ( 'Media Upload' === $form['title'] ) {
		$user         = wp_get_current_user();
		$user_id      = $user->ID;
		$company_logo = ( ! empty( get_user_meta( $user_id, 'company_logo', true ) ) ) ? get_user_meta( $user_id, 'company_logo', true ) : null;

		if ( ! empty( $company_logo ) ) {
			$company_logo = json_decode( $company_logo );
		}

		if ( in_array( 'apera_zip_affiliate', $user->roles ) || in_array( 'administrator', $user->roles ) ) {

			if ( ! empty( $company_logo->url ) ) {

				$output['content'] .= '<img src="' . esc_attr( wp_get_attachment_image_src( $company_logo->id, 'thumbnail', false ) ) . '" srcset="' . esc_attr( wp_get_attachment_image_srcset( $company_logo->id, 'thumbnail', null ) ) . '" data-attachment-id="' . $company_logo->id . '" class="current-logo" />';

			} else {

				$output['content'] .= '<div class="no-logo">You have no logo on file. If you just tried to update your logo there must have been a problem with the upload. Try again or contact us for further help.</div>';

			}

			wp_send_json_success( $output );

		}
	}

	wp_send_json_success( $output );
}
add_action( 'wp_ajax_wonkasoft_parse_account_logo_or_process_fees', 'wonkasoft_parse_account_logo_or_process_fees' );
add_action( 'wp_ajax_nopriv_wonkasoft_parse_account_logo_or_process_fees', 'wonkasoft_parse_account_logo_or_process_fees' );
