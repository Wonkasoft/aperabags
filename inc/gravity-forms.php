<?php
/**
 * All Gravity form customizations
 *
 * @author Louis <Support@wonkasoft.com>
 * @package aperabags
 * @since 1.0.3 All Gravity form customizations
 */

defined( 'ABSPATH' ) || exit;

/**
 * Adding bootstrap classes to the form elements
 *
 * Customizing of Gravity forms.
 *
 * @param array $form         contains the form elements to work with.
 * @param array $ajax         ajax callback.
 * @param array $field_values this is an array of the field values.
 */
function add_bootstrap_container_class( $form, $ajax, $field_values ) {
	$inline_forms = array( 'Sign Up', 'Popup', 'Promotion Sign Up' );
	if ( ! empty( $form['cssClass'] ) ) :
		$form['cssClass'] .= ' wonka-gform wonka-gform-' . $form['id'];
	else :
		$form['cssClass'] = 'wonka-gform wonka-gform-' . $form['id'];
	endif;
	if ( in_array( $form['title'], $inline_forms ) ) :
		$form['cssClass'] .= ' form-inline wonka-newsletter-form justify-content-center';
	endif;
	if ( in_array( $form['title'], array( 'Refersion Registration Ambassador', 'Refersion Registration Zip' ) ) ) :
		$form['cssClass'] .= ' inline-form wonka-refersion-form';
	endif;
	if ( in_array( $form['title'], array( 'ZIP Program' ) ) ) :
		$form['cssClass'] .= ' inline-form wonka-zip-form';
	endif;
	if ( in_array( $form['title'], array( 'Ambassador Program' ) ) ) :
		$form['cssClass'] .= ' inline-form wonka-ambassador-form';
	endif;
	if ( in_array( $form['title'], array( 'Apera Perks Registration', 'Get $10 & FREE Shipping Now', 'Get $10 & FREE Shipping Now Popup' ) ) ) :
		$form['cssClass'] .= ' inline-form wonka-perks-form';
	endif;
	if ( in_array( $form['title'], array( 'Apera Customer Engagement Program New Member', 'Apera Customer Engagement Program Update Member' ) ) ) :
		$form['cssClass'] .= ' inline-form wonka-cep-form';
	endif;
	if ( in_array( $form['title'], array( 'Join MSE+' ) ) ) :
		$form['cssClass'] .= ' inline-form wonka-join-mse-form';
	endif;
	if ( in_array( $form['title'], array( 'User Birthday' ) ) ) :
		$form['cssClass'] .= ' inline-form wonka-birthday-form';
	endif;
	if ( in_array( $form['title'], array( 'Add Discount Code' ) ) ) :
		$form['cssClass'] .= ' inline-form wonka-discount-form';
	endif;
	if ( in_array( $form['title'], array( 'Design Fees Capture' ) ) ) :
		$form['cssClass'] .= ' inline-form wonka-design-fees-form';
	endif;
	if ( in_array( $form['title'], array( 'Media Upload' ) ) ) :
		$form['cssClass'] .= ' inline-form wonka-media-upload-form form-zip-logo';
	endif;
	foreach ( $form['fields'] as &$field ) :
		if ( strpos( $field['cssClass'], 'gform_validation_container' ) === false ) :

			if ( ! empty( $field['cssClass'] ) ) :
				$field['cssClass'] .= ' form-group wonka-form-group';
			else :
				$field['cssClass'] = 'form-group wonka-form-group';
			endif;
			if ( ! empty( $field['size'] ) ) :
				$field['size'] .= ' form-control wonka-form-control';
			else :
				$field['size'] = 'form-control wonka-form-control';
			endif;
			if ( 'fileupload' === $field['type'] ) :
				$field['size'] = 'custom-file-input';
			endif;
			if ( empty( $field['placeholder'] ) ) :
				$field['placeholder'] = $field['label'];
			endif;
			if ( 'hidden' === $field['type'] && 'Agree To Fees' === $field['label'] ) :
				$field['cssClass'] = ' hidden-agree-to-fees';
			endif;
		endif;
	endforeach;
	return $form;
}
add_filter( 'gform_pre_render', 'add_bootstrap_container_class', 10, 6 );
add_filter( 'gform_enable_password_field', '__return_true' );

/**
 * This filter is to allow the update user for to show on apera-engagement page.
 *
 * @param  array $form Contains the form array.
 * @return array       Returns the form array.
 */
function wonkasoft_gform_pre_render( $form ) {
	if ( 'Apera Customer Engagement Program Update Member' !== $form['title'] ) :
		return $form;
	endif;

	remove_action( 'gform_get_form_filter_' . $form['id'], array( gf_user_registration(), 'hide_form' ) );

	return $form;
}
add_filter( 'gform_pre_render', 'wonkasoft_gform_pre_render', 100 );

/**
 * Set the update feed for email fetched user id.
 *
 * @param  int   $user_id Contains the current user id.
 * @param  array $entry   Contains array of the current form entries.
 * @param  array $form    Contains array of the current form.
 * @param  array $feed    Contains array of the user registration addon feed.
 * @return int          Returns the user id that is set.
 */
function wonkasoft_gform_user_registration_update_user_id( $user_id, $entry, $form, $feed ) {
	$entry_fields  = array();
	$set_labels    = array(
		'Engage Email',
	);
	$custom_fields = array();
	$pattern       = '/([ \/]{1,5})/';
	foreach ( $form['fields'] as $field ) {
		if ( 'honeypot' !== $field['type'] ) :
			if ( in_array( $field['label'], $set_labels, true ) ) :
				$entry_fields[ strtolower( preg_replace( $pattern, '_', $field['label'] ) ) ] = $entry[ $field['id'] ];
			endif;
			if ( ! empty( $field->inputs ) ) :
				foreach ( $field->inputs as $input ) {
					if ( in_array( $input['label'], $set_labels, true ) ) :
						$entry_fields[ strtolower( preg_replace( $pattern, '_', $input['label'] ) ) ] = $entry[ $input['id'] ];
					endif;
				}
			endif;
		endif;
	}

	$user_id = get_user_by( 'email', $entry_fields['engage_email'] )->ID;
	return $user_id;
}
add_filter( 'gform_user_registration_update_user_id', 'wonkasoft_gform_user_registration_update_user_id', 10, 4 );

/**
 * This cancels email if email is not a perks member.
 *
 * @param [type] $email
 * @param [type] $message_format
 * @param [type] $notification
 * @param [type] $entry
 * @return void
 */
function wonkasoft_gform_pre_send_email( $email, $message_format, $notification, $entry ) {
	$form = GFAPI::get_form( $entry['form_id'] );
	if ( 'Apera Customer Engagement Program Update Member' === $form['title'] ) :
		$entry_fields  = array();
		$set_labels    = array(
			'Engage Email',
		);
		$custom_fields = array();
		$pattern       = '/([ \/]{1,5})/';
		foreach ( $form['fields'] as $field ) {
			if ( 'honeypot' !== $field['type'] ) :
				if ( in_array( $field['label'], $set_labels, true ) ) :
					$entry_fields[ strtolower( preg_replace( $pattern, '_', $field['label'] ) ) ] = $entry[ $field['id'] ];
				endif;
				if ( ! empty( $field->inputs ) ) :
					foreach ( $field->inputs as $input ) {
						if ( in_array( $input['label'], $set_labels, true ) ) :
							$entry_fields[ strtolower( preg_replace( $pattern, '_', $input['label'] ) ) ] = $entry[ $input['id'] ];
						endif;
					}
				endif;
			endif;
		}

		$user = get_user_by( 'email', $entry_fields['engage_email'] );
		if ( false === $user ) :
			// cancel sending emails.
			$email['abort_email'] = true;
			return $email;
		endif;
	endif;

	return $email;
}
add_filter( 'gform_pre_send_email', 'wonkasoft_gform_pre_send_email', 10, 4 );

/**
 * This is to add a prepend element to a specific field.
 *
 * @param  html  $field_content contains the field content in html.
 * @param  array $field         contains the field data.
 * @return html                returns the newly constructed field content.
 */
function wonka_gform_field_modifications( $field_content, $field ) {
	$form        = GFAPI::get_form( $field['formId'] );
	$new_content = '';

	if ( 'Refersion Registration Ambassador' === $form['title'] ) :
		if ( 'Company' === $field['label'] ) :
			$split_content = preg_split( '/([<])/', $field_content, null, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE );
			foreach ( $split_content as $key => $value ) {
				if ( strpos( $value, 'input name' ) !== false ) :
					$new_content .= 'div class="input-group"><div class="input-group-prepend"> <span class="input-group-text">@</span> </div><' . $value . '</div>';
				else :
					$new_content .= $value;
				endif;
			}
			return $new_content;
		endif;
	endif;

	if ( 'Apera Perks Registration' === $form['title'] || 'Get $10 & FREE Shipping Now' === $form['title'] || 'Get $10 & FREE Shipping Now Popup' === $form['title'] || 'Apera Customer Engagement Program New Member' === $form['title'] ) :
		if ( 'Password' === $field['label'] ) :
			$split_content = preg_split( '/([<])/', $field_content, null, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE );
			foreach ( $split_content as $key => $value ) {
				if ( strpos( $value, "input type='password'" ) !== false ) :
					$element_array = explode( ' ', $value );
					foreach ( $element_array as $key => $values ) {
						if ( empty( $values ) ) {
							unset( $element_array[ $key ] );
						}
					}
					array_splice( $element_array, 2, 0, "class='form-control'" );
					$element_string = implode( ' ', $element_array );
					$new_content   .= 'div class="input-group"><' . $element_string . '<div class="input-group-append"><div class="input-group-text"> <i toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></i> </div></div></div>';
				else :
					$new_content .= $value;
				endif;
			}
			return $new_content;
		endif;
		if ( 'Military Date' === $field['label'] || 'Student Grad Date' === $field['label'] ) :
			$split_content = preg_split( '/([<])/', $field_content, null, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE );
			foreach ( $split_content as $key => $value ) {
				if ( strpos( $value, "class='datepicker" ) !== false ) :
					$new_content .= 'div class="input-group"><div class="input-group-prepend"> <span class="input-group-text"></span> </div><' . $value;
					elseif ( strpos( $value, "id='gforms_calendar_icon" ) !== false ) :
						$new_content .= $value . '</div>';
				else :
					$new_content .= $value;
				endif;
			}
			return $new_content;
		endif;
	endif;

	if ( 'Join MSE+' === $form['title'] || 'User Birthday' === $form['title'] ) :
		if ( 'Military Date' === $field['label'] || 'Student Grad Date' === $field['label'] || 'Birthday Date' === $field['label'] ) :
			$split_content = preg_split( '/([<])/', $field_content, null, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE );
			foreach ( $split_content as $key => $value ) {
				if ( strpos( $value, "class='datepicker" ) !== false ) :
					$new_content .= 'div class="input-group"><div class="input-group-prepend"> <span class="input-group-text"></span> </div><' . $value;
					elseif ( strpos( $value, "id='gforms_calendar_icon" ) !== false ) :
						$new_content .= $value . '</div>';
				else :
					$new_content .= $value;
				endif;
			}
			return $new_content;
		endif;
	endif;

	if ( 'fileupload' === $field['type'] ) :
		$split_content = preg_split( '/([<])/', $field_content, null, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE );
		$element       = '';
		foreach ( $split_content as $key => $value ) {
			if ( strpos( $value, 'input name' ) !== false ) :
				$element   .= '<' . $value;
				$attributes = simplexml_load_string( $element );
				$attributes = json_decode( json_encode( $attributes ) );
				foreach ( $attributes->{'@attributes'} as $key => $str ) :
					if ( 'id' === $key ) {
						$for = $str;
					}
					if ( 'aria-describedby' === $key ) {
						$add_id = $str;
					}
				endforeach;
				$new_content .= 'div class="input-group">';
				$new_content .= '<div class="input-group-prepend">';
				$new_content .= '<span class="input-group-text" id="' . $add_id . '">Upload</span>';
				$new_content .= '</div>';
				$new_content .= '<div class="custom-file"><';
				$new_content .= $value;
				$new_content .= '<label class="custom-file-label" for="' . $for . '">Choose file</label>';
				$new_content .= '</div>';
				$new_content .= '</div>';
				else :
					$new_content .= $value;
			endif;
		}
		return $new_content;
	endif;

	return $field_content;
}
add_filter( 'gform_field_content', 'wonka_gform_field_modifications', 10, 2 );

/**
 * Adding classes to gform buttons
 *
 * @param  object $button contains the html of the button.
 * @param  object $form   contains the html of the form.
 * @return string         returns the classes that are set for the button.
 */
function wonka_add_classes_to_button( $button, $form ) {
	$dom = new DOMDocument();
	$dom->loadHTML( $button );
	$input    = $dom->getElementsByTagName( 'input' )->item( 0 );
	$classes  = $input->getAttribute( 'class' );
	$classes .= ' wonka-btn';
	$input->setAttribute( 'class', $classes );
	return $dom->saveHtml( $input );
}
add_filter( 'gform_submit_button', 'wonka_add_classes_to_button', 8, 2 );

/**
 * Newsletter popup entry or form submission.
 *
 * @param  array $entry contains the data from the entry.
 * @param  array $form  array of the form fields.
 * @return blank
 */
function wonkasoft_newsletter_popup_entry( $entry, $form ) {
	$user_id    = get_current_user_id();
	$form_title = str_replace( ' ', '-', strtolower( $form['title'] ) );
	if ( 'popup' === $form_title ) :
		$wonkasoft_popup_cookie = array(
			'user_id'       => get_current_user_id(),
			'show'          => false,
			'time_of_visit' => time(),
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
	if ( 'sign-up' === $form_title ) :
		$wonkasoft_popup_cookie = array(
			'user_id'       => get_current_user_id(),
			'show'          => false,
			'time_of_visit' => time(),
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

/**
 * This function is filtering the states to abbriviations.
 *
 * @param  array $address_types An array of address types.
 * @param  int   $form_id The ID of the form being filtered.
 * @return array $address_types A modified array of address types.
 */
function filter_states_to_abbriviations( $address_types, $form_id ) {
	$address_types['us'] = array(
		'label'       => 'United States',
		'country'     => 'US',
		'zip_label'   => 'Zip Code',
		'state_label' => 'State',
		'states'      => array(
			''   => '',
			'AL' => 'Alabama',
			'AK' => 'Alaska',
			'AZ' => 'Arizona',
			'AR' => 'Arkansas',
			'CA' => 'California',
			'CO' => 'Colorado',
			'CT' => 'Connecticut',
			'DE' => 'Delaware',
			'DC' => 'District of Columbia',
			'FL' => 'Florida',
			'GA' => 'Georgia',
			'GU' => 'Guam',
			'HI' => 'Hawaii',
			'ID' => 'Idaho',
			'IL' => 'Illinois',
			'IN' => 'Indiana',
			'IA' => 'Iowa',
			'KS' => 'Kansas',
			'KY' => 'Kentucky',
			'LA' => 'Louisiana',
			'ME' => 'Maine',
			'MD' => 'Maryland',
			'MA' => 'Massachusetts',
			'MI' => 'Michigan',
			'MN' => 'Minnesota',
			'MS' => 'Mississippi',
			'MO' => 'Missouri',
			'MT' => 'Montana',
			'NE' => 'Nebraska',
			'NV' => 'Nevada',
			'NH' => 'New Hampshire',
			'NJ' => 'New Jersey',
			'NM' => 'New Mexico',
			'NY' => 'New York',
			'NC' => 'North Carolina',
			'ND' => 'North Dakota',
			'OH' => 'Ohio',
			'OK' => 'Oklahoma',
			'OR' => 'Oregon',
			'PA' => 'Pennsylvania',
			'PR' => 'Puerto Rico',
			'RI' => 'Rhode Island',
			'SC' => 'South Carolina',
			'SD' => 'South Dakota',
			'TN' => 'Tennessee',
			'TX' => 'Texas',
			'UT' => 'Utah',
			'VT' => 'Vermont',
			'VA' => 'Virginia',
			'WA' => 'Washington',
			'WV' => 'West Virginia',
			'WI' => 'Wisconsin',
			'WY' => 'Wyoming',
		),
	);
	return $address_types;
}
add_filter( 'gform_address_types', 'filter_states_to_abbriviations', 10, 2 );

/**
 * This function fires after Refersion Registration form is submitted.
 *
 * @param  array $entry contains the data from surrent.
 * @param  array $form  Contains an array of the form.
 */
function wonkasoft_after_form_submission( $entry, $form ) {

	$set_forms = array(
		'Refersion Registration Ambassador',
		'Refersion Registration Zip',
		'Media Upload',
		'Ambassador Program',
		'ZIP Program',
	);

	// Get current user object.
	$current_user = wp_get_current_user();

	// Check to see if form should be processed here.
	if ( ! in_array( $form['title'], $set_forms ) ) :
		return;
	endif;

	update_option( 'registration_passing_args', null );
	// Setting the campaign name.
	if ( 'Refersion Registration Ambassador' === $form['title'] ) :
		$campaign_name = 'ambassador_program_signups';
		$set_tag       = 'ambassadorcompleted';
		$role          = 'apera_ambassador_affiliate';
		$role_display  = 'Apera Ambassador Affiliate';
	endif;
	if ( 'Refersion Registration Zip' === $form['title'] ) :
		$campaign_name = 'zip_program_signups';
		$set_tag       = 'zipcompleted';
		$role          = 'apera_zip_affiliate';
		$role_display  = 'Apera Zip Affiliate';
	endif;

	$role2         = 'customer';
	$role_display2 = 'Customer';

	// Get current user ID.
	$user_id                       = $current_user->ID;
	$entry_fields                  = array();
	$entry_fields['custom_fields'] = array();
	$set_labels                    = array(
		'First',
		'Last',
		'Company',
		'Logo Upload',
		'Email',
		'Paypal Email',
		'Password',
		'Street Address',
		'Address Line 2',
		'City',
		'State / Province',
		'ZIP / Postal Code',
		'Phone',
		'Agree To Fees',
	);
	$custom_fields                 = array();
	$pattern                       = '/([ \/]{1,5})/';
	foreach ( $form['fields'] as $field ) {
		if ( 'honeypot' !== $field['type'] ) :
			if ( in_array( $field['label'], $set_labels ) ) :
				$entry_fields[ strtolower( preg_replace( $pattern, '_', $field['label'] ) ) ] = $entry[ $field['id'] ];
			endif;
			if ( in_array( $field['label'], $custom_fields ) ) :
				$current_label = strtolower( preg_replace( $pattern, $field['label'] ) );
					array_push(
						$entry_fields['custom_fields'],
						array(
							'label' => $current_label,
							'value' => $entry[ $field['id'] ],
						)
					);
			endif;
			if ( ! empty( $field->inputs ) ) :
				foreach ( $field->inputs as $input ) {
					if ( in_array( $input['label'], $set_labels ) ) :
						$entry_fields[ strtolower( preg_replace( $pattern, '_', $input['label'] ) ) ] = $entry[ $input['id'] ];
					endif;
				}
			endif;
		endif;
	}
	if ( 'Media Upload' === $form['title'] ) :
		if ( ! empty( $entry_fields['logo_upload'] ) ) :
			wonkasoft_add_club_gym_logo( $entry_fields['logo_upload'], $user_id );
			return;
		endif;
	endif;
	// Setting getResponse api args.
	$api_args = array(
		'email'         => $entry_fields['email'],
		'tags'          => array(
			$set_tag,
		),
		'campaign_name' => $campaign_name,
	);
	if ( 0 === $user_id ) :
		// Check if email has user account already.
		if ( email_exists( $entry_fields['email'] ) ) {
			$user    = get_user_by( 'email', $entry_fields['email'] );
			$user_id = $user->ID;

			if ( 'Ambassador Program' === $form['title'] ) :
				update_user_meta( $user_id, 'ambassador_affiliate_status', 'Pending', '' );
				return;
			endif;

			if ( 'ZIP Program' === $form['title'] ) :
				update_user_meta( $user_id, 'zip_affiliate_status', 'Pending', '' );
				return;
			endif;

			$user = new WP_User( $user_id );

			if ( ! empty( $role ) && ! in_array( $role, $user->roles ) ) :
				$user->add_role( $role, $role_display );
			endif;

			if ( ! empty( $role2 ) && ! in_array( $role2, $user->roles ) ) :
				$user->add_role( $role2, $role_display2 );
			endif;

			if ( 'Refersion Registration Ambassador' === $form['title'] || 'Refersion Registration Zip' === $form['title'] ) :

				wp_set_password( $entry_fields['password'], $user_id );

				$refersion_api_init = new Wonkasoft_Refersion_Api( $entry_fields );
				$refersion_response = $refersion_api_init->add_new_affiliate();

				if ( 'failed' !== $refersion_response->status ) :
					if ( ! empty( $refersion_response->errors ) ) :
						if ( ! empty( $refersion_api_init->affiliate_code ) ) :
							wonkasoft_new_affiliate_errors( $user_id, $entry_fields, $refersion_api_init, $refersion_response, $api_args );
							return;
						else :
							wonkasoft_affiliate_code_empty( $user_id, $entry_fields, $refersion_api_init, $refersion_response, $api_args );
							return;
						endif;

						else :
							wonkasoft_refersion_affiliate_created_successfully( $user_id, $entry_fields, $refersion_api_init, $refersion_response, $api_args );
							return;
					endif;
						else :
							echo esc_html( $refersion_response->status );
							return;
				endif;
			endif;
		} else {

			$user_id = wonkasoft_make_user_account( $entry_fields, $role );

			if ( 'Ambassador Program' === $form['title'] ) :
				update_user_meta( $user_id, 'ambassador_affiliate_status', 'Pending', '' );
				return;
			endif;

			if ( 'ZIP Program' === $form['title'] ) :
				update_user_meta( $user_id, 'zip_affiliate_status', 'Pending', '' );
				return;
			endif;

			if ( 'Refersion Registration Ambassador' === $form['title'] || 'Refersion Registration Zip' === $form['title'] ) :

				$user = new WP_User( $user_id );

				if ( ! empty( $role ) && ! in_array( $role, $user->roles ) ) :
					$user->add_role( $role, $role_display );
				endif;

				if ( ! empty( $role2 ) && ! in_array( $role2, $user->roles ) ) :
					$user->add_role( $role2, $role_display2 );
				endif;

				$refersion_api_init = new Wonkasoft_Refersion_Api( $entry_fields );
				$refersion_response = $refersion_api_init->add_new_affiliate();

				if ( 'failed' !== $refersion_response->status ) :
					if ( ! empty( $refersion_response->errors ) ) :
						if ( ! empty( $refersion_api_init->affiliate_code ) ) :
							wonkasoft_new_affiliate_errors( $user_id, $entry_fields, $refersion_api_init, $refersion_response, $api_args );
							return;
						else :
							wonkasoft_affiliate_code_empty( $user_id, $entry_fields, $refersion_api_init, $refersion_response, $api_args );
							return;
						endif;
						else :
							wonkasoft_refersion_affiliate_created_successfully( $user_id, $entry_fields, $refersion_api_init, $refersion_response, $api_args );
							return;
					endif;
						else :
							echo esc_html( $refersion_response->status );
							return;
				endif;
			endif;
		}
		else :

			if ( email_exists( $entry_fields['email'] ) ) {
				$user    = get_user_by( 'email', $entry_fields['email'] );
				$user_id = $user->data->ID;
				$user    = new WP_User( $user_id );
			} else {
				$user_id = wonkasoft_make_user_account( $entry_fields, $role );
				$user    = new WP_User( $user_id );
			}

			if ( 'Ambassador Program' === $form['title'] ) :
				update_user_meta( $user_id, 'ambassador_affiliate_status', 'Pending', '' );
				return;
			endif;

			if ( 'ZIP Program' === $form['title'] ) :
				update_user_meta( $user_id, 'zip_affiliate_status', 'Pending', '' );
				return;
			endif;

			if ( ! empty( $role ) && ! in_array( $role, $user->roles ) ) :
				$user->add_role( $role, $role_display );
			endif;

			if ( ! empty( $role2 ) && ! in_array( $role2, $user->roles ) ) :
				$user->add_role( $role2, $role_display2 );

			endif;

			if ( 'Refersion Registration Ambassador' === $form['title'] || 'Refersion Registration Zip' === $form['title'] ) :

				$refersion_api_init = new Wonkasoft_Refersion_Api( $entry_fields );
				$refersion_response = $refersion_api_init->add_new_affiliate();

				if ( 'failed' !== $refersion_response->status ) :
					if ( ! empty( $refersion_response->errors ) ) :
						if ( ! empty( $refersion_api_init->affiliate_code ) ) :
							wonkasoft_new_affiliate_errors( $user_id, $entry_fields, $refersion_api_init, $refersion_response, $api_args );
							return;
						else :
							wonkasoft_affiliate_code_empty( $user_id, $entry_fields, $refersion_api_init, $refersion_response, $api_args );
							return;
						endif;
						else :
							wonkasoft_refersion_affiliate_created_successfully( $user_id, $entry_fields, $refersion_api_init, $refersion_response, $api_args );
							return;
					endif;
						else :
							echo esc_html( $refersion_response->status );
							return;
				endif;
			endif;
	endif;
}
add_action( 'gform_after_submission', 'wonkasoft_after_form_submission', 10, 2 );

/**
 * Runs after discount code creation.
 *
 * @param  array $entry array of entry.
 * @param  array $form  array of the form.
 */
function wonkasoft_after_code_entry( $entry, $form ) {
	if ( 'Add Discount Code' !== $form['title'] ) {
		return;
	}
	$entry_fields                  = array();
	$entry_fields['custom_fields'] = array();
	$set_labels                    = array(
		'Discount Code',
		'Percentage',
		'Email',
		'Tag',
		'First Name',
		'Last Name',
		'Users Discount',
	);
	$custom_fields                 = array();
	$pattern                       = '/([ \/]{1,5})/';
	foreach ( $form['fields'] as $field ) {
		if ( 'honeypot' !== $field['type'] ) :
			if ( in_array( $field['label'], $set_labels, true ) ) :
				$entry_fields[ strtolower( preg_replace( $pattern, '_', $field['label'] ) ) ] = $entry[ $field['id'] ];
			endif;
			if ( in_array( $field['label'], $custom_fields, true ) ) :
				$current_label = strtolower( preg_replace( $pattern, $field['label'] ) );
					array_push(
						$entry_fields['custom_fields'],
						array(
							'label' => $current_label,
							'value' => $entry[ $field['id'] ],
						)
					);
			endif;
			if ( ! empty( $field->inputs ) ) :
				foreach ( $field->inputs as $input ) {
					if ( in_array( $input['label'], $set_labels, true ) ) :
						$entry_fields[ strtolower( preg_replace( $pattern, '_', $input['label'] ) ) ] = $entry[ $input['id'] ];
					endif;
				}
			endif;
		endif;
	}
	$user_id        = get_user_by( 'email', $entry_fields['email'] )->data->ID;
	$refersion_data = wonkasoft_get_refersion_data( $user_id );
	$coupon_code    = wonkasoft_coupon_creation( $entry_fields, $form['title'] );
	if ( false !== $coupon_code ) {
		$entry_fields['affiliate_code'] = $refersion_data->id;
		$entry_fields['type']           = 'COUPON';
		$entry_fields['trigger']        = $entry_fields['discount_code'];
		$refersion_init                 = new Wonkasoft_Refersion_Api( $entry_fields );
		$refersion_added_trigger        = $refersion_init->create_conversion_trigger();
		$refersion_data->trigger_id     = $refersion_added_trigger->trigger_id;
		$refersion_data->trigger        = $refersion_added_trigger->trigger;
		// Setting getResponse api args.
		$api_args = array(
			'email' => $entry_fields['email'],
			'tags'  => array(
				$entry_fields['tag'],
			),
		);
		// Setting affiliate code and link to send to getResponse.
		$api_args['custom_fields']        = array(
			'discount_code',
		);
		$api_args['custom_fields_values'] = array(
			'discount_code' => $entry_fields['discount_code'],
		);
		// Send to getResponse.
		$getresponse = get_response_api_call( $api_args );
		update_user_meta( $user_id, 'users_discount_percentage', $entry_fields['users_discount'] );
		update_user_meta( $user_id, 'refersion_discount_code', $refersion_data );
		update_user_meta( $user_id, 'getResponse_discount_code', $getresponse );
	}
}
add_action( 'gform_after_submission', 'wonkasoft_after_code_entry', 10, 2 );

/**
 * This handles the submission of the perks registration form.
 *
 * @param  array $confirmation  contains the form confirmation response.
 * @param  array $form  contains the form array.
 * @param  array $entry contains the entry fields.
 * @param  bool  $ajax contains ajax.
 */
function wonkasoft_after_perks_registration_entry( $confirmation, $form, $entry, $ajax ) {
	$forms_to_process = array(
		'Apera Perks Registration',
		'User Birthday',
		'Tracking Post',
		'Apera Customer Engagement Program Update Member',
		'Get $10 & FREE Shipping Now',
		'Get $10 & FREE Shipping Now Popup',
	);

	if ( ! in_array( $form['title'], $forms_to_process, true ) ) {
		return $confirmation;
	}

	$entry_fields                  = array();
	$entry_fields['custom_fields'] = array();
	$set_labels                    = array(
		'First',
		'Last',
		'Email',
		'Birthday Email',
		'Engage Email',
		'Birthday Date',
		'Password',
		'MSE Request',
		'MSE Occupation',
		'Military Active',
		'Military Date',
		'Military Branch',
		'Street Address',
		'Address Line 2',
		'State / Province',
		'ZIP / Postal Code',
		'Country',
		'Military Occupational Code',
		'Military Note',
		'Student School Website',
		'Student School Email',
		'Student Grad Date',
		'Student Sports',
		'Student Note',
		'Educator School Website',
		'Educator School Email',
		'Educator Subject',
		'Educator Years',
		'Educator Note',
		'Employer Website',
		'Occupational Email',
		'Occupation',
		'Occupational Years',
		'Occupational Note',
		'Tracking Number',
		'Shipping Vendor',
		'Order Id',
	);
	$custom_fields                 = array();
	$pattern                       = '/([ \/]{1,5})/';
	foreach ( $form['fields'] as $field ) {
		if ( 'honeypot' !== $field['type'] ) :
			if ( in_array( $field['label'], $set_labels, true ) ) :
				$entry_fields[ strtolower( preg_replace( $pattern, '_', $field['label'] ) ) ] = $entry[ $field['id'] ];
			endif;
			if ( in_array( $field['label'], $custom_fields, true ) ) :
				$current_label = strtolower( preg_replace( $pattern, $field['label'] ) );
					array_push(
						$entry_fields['custom_fields'],
						array(
							'label' => esc_html( $current_label ),
							'value' => esc_html( $entry[ $field['id'] ] ),
						)
					);
			endif;
			if ( ! empty( $field->inputs ) ) :
				foreach ( $field->inputs as $input ) {
					if ( in_array( $input['label'], $set_labels, true ) ) :
						$entry_fields[ strtolower( preg_replace( $pattern, '_', $input['label'] ) ) ] = $entry[ $input['id'] ];
					endif;
				}
			endif;
		endif;
	}

	if ( 'Tracking Post' === $form['title'] ) :
		$order        = wc_get_order( $entry_fields['order_id'] );
		$order_number = null;
		if ( ! empty( $order ) ) :
			$order_id = method_exists( $order, 'get_id' ) ? $order->get_id() : $order->id;
		endif;
		$tracking_number = $entry_fields['tracking_number'];
		$shipping_vendor = $entry_fields['shipping_vendor'];

		if ( ! $order_id ) :
			$order_id     = wc_seq_order_number_pro()->find_order_by_order_number( $entry_fields['order_id'] );
			$order_number = $entry_fields['order_id'];
		endif;

		if ( ! empty( $order_id ) && ! empty( $tracking_number ) ) :
			$confirmation = tracking_post_processing( $order_id, $order_number, $tracking_number, $shipping_vendor, true );
		else :
			$confirmation = tracking_post_processing( $entry_fields['order_id'], $order_number, null, $shipping_vendor, false );
		endif;

		return $confirmation;
	endif;

	if ( 'User Birthday' === $form['title'] ) {
		$user = get_user_by( 'email', $entry_fields['birthday_email'] );
		update_user_meta( $user->ID, 'users_birthday', $entry_fields['birthday_date'], '' );
		return $confirmation;
	}

	if ( 'Apera Customer Engagement Program Update Member' === $form['title'] ) :
		$user = get_user_by( 'email', $entry_fields['engage_email'] );
		if ( false === $user ) :
			$confirmation  = '<p>We are sorry, but it looks like ' . $entry_fields['engage_email'] . ' is not yet registered as a Perks Partner.</p>';
			$confirmation .= '<p><a href="https://aperabags.com/apera-engagement/" class="wonka-btn">Please try again</a></p>';
			return $confirmation;
		endif;
		return $confirmation;
	endif;

	if ( email_exists( $entry_fields['email'] ) ) {
		$output       = '';
		$output      .= '<p>' . $entry_fields['email'] . ' is already being used. You can login at the link below</p>';
		$output      .= '<p>Once you are logged in go to your account dashboard and click the following button to receive your $10 AperaCash</p>';
		$output      .= '<p><a class="wonka-btn" disabled>Join Perks and Earn</a></p>';
		$output      .= '<p>Or you can click here to register with another email.</p>';
		$output      .= '<p><a class="wonka-btn" href="' . get_site_url() . '/my-account/?create=1">Back to Registration</a></p>';
		$confirmation = $output;
		return $confirmation;
	} else {
		$role          = 'apera_perks_partner';
		$role_display  = 'Apera Perks Partner';
		$role2         = 'customer';
		$role_display2 = 'Customer';
		$user_id       = wonkasoft_make_user_account( $entry_fields, $role );
		$user          = new WP_User( $user_id );
		if ( ! in_array( $role, $user->roles, true ) ) :
			$user->add_role( $role, $role_display );
		endif;
		if ( ! in_array( $role2, $user->roles, true ) ) :
			$user->add_role( $role2, $role_display2 );
		endif;
		// Setting Apera Perks affiliate link to send to getResponse.
		$api_args['contact_name']         = $entry_fields['first'] . ' ' . $entry_fields['last'];
		$api_args['email']                = $entry_fields['email'];
		$api_args['custom_fields']        = array(
			'affiliate_link',
			'apera_id',
		);
		$api_args['custom_fields_values'] = array(
			'affiliate_link' => get_site_url() . '/?ref=' . $user_id,
			'apera_id'       => $user_id,
		);
		$getresponse_init                 = new Wonkasoft_GetResponse_Api( $api_args );
		$getresponse_mse                  = '';
		if ( empty( $getresponse_init->campaign_id ) ) :
			foreach ( $getresponse_init->campaign_list as $campaign ) :
				if ( 'perks_program_signups' === $campaign->name ) :
					// @codingStandardsIgnoreLine.
					$getresponse_init->campaign_id = $campaign->campaignId; 
				endif;
			endforeach;
		endif;
		if ( ! empty( $getresponse_init->custom_fields ) ) :
			foreach ( $getresponse_init->custom_fields_list as $field ) {
				if ( in_array( $field->name, $getresponse_init->custom_fields ) ) :
					$add_field = array(
						// @codingStandardsIgnoreLine.
						'customFieldId' => $field->customFieldId, 
						'value'         => array(
							$getresponse_init->custom_fields_values[ $field->name ],
						),
					);
					array_push( $getresponse_init->custom_fields_to_update, $add_field );
				endif;
			}
		endif;
		$getresponse_perks = $getresponse_init->create_a_new_contact();
		if ( ! empty( $entry_fields['mse_occupation'] ) ) :
			foreach ( $getresponse_init->campaign_list as $campaign ) :
				if ( 'perks_mse_program_signups' === $campaign->name ) :
					// @codingStandardsIgnoreLine.
					$getresponse_init->campaign_id = $campaign->campaignId;
				endif;
			endforeach;
			$getresponse_mse = $getresponse_init->create_a_new_contact();
		endif;
		$getresponse_perks = json_encode( $getresponse_perks );
		update_user_meta( $user_id, 'getResponse_data_perks', $getresponse_perks );
		if ( ! empty( $getresponse_mse ) ) {
			$getresponse_mse = json_encode( $getresponse_mse );
			update_user_meta( $user_id, 'getResponse_data_mse', $getresponse_mse );
		}
		if ( ! empty( $entry_fields['mse_occupation'] ) ) {
			$entry_fields = json_encode( $entry_fields );
			update_user_meta( $user_id, 'mse_data', $entry_fields );
		}
	}

	return $confirmation;
}
add_filter( 'gform_confirmation', 'wonkasoft_after_perks_registration_entry', 10, 4 );



/**
 * This processes the form from the tracking portal
 *
 * @param  int     $order_id        Contains the order id.
 * @param  string  $order_number    Contains the order number.
 * @param  string  $tracking_number Contains the tracking number.
 * @param  boolean $process         true to process or false to update user.
 * @return string                   returns html confirmation for the form.
 */
function tracking_post_processing( $order_id, $order_number, $tracking_number, $shipping_vendor = 'usps', $process = false ) {
	if ( ! $process ) :
		$output       = '';
		$output      .= '<p>Order Number: ' . $order_id . ' does not seem to be a valid order number. Please recheck the order number and try again by clicking the link below.</p>';
		$output      .= '<p><a class="wonka-btn" href="' . get_site_url() . '/tracking-portal/?have_tracking=true">Reload form</a></p>';
		$confirmation = $output;
	endif;

	if ( $process ) :
		$check_tracking = get_post_meta( $order_id, '_added_tracking_number', true );
		if ( ! empty( $check_tracking ) ) :
			$output = '';
			if ( ! empty( $order_number ) ) :
				$output .= '<p>Order Number: ' . $order_number . ' already has the following tracking number. <br />tracking Number: ' . $check_tracking . '</p>';
			else :
				$output .= '<p>Order Number: ' . $order_id . ' already has the following tracking number. <br />tracking Number: ' . $check_tracking . '</p>';
			endif;
			$output .= '<p><a class="wonka-btn" href="' . get_site_url() . '/tracking-portal/?have_tracking=true">Reload form</a></p>';

			$confirmation = $output;
			else :
				$order = wc_get_order( $order_id );

				// The text for the note.
				$note  = "Tracking added to this order.\n";
				$note .= "Shipping method:\n";
				$note .= $order->get_shipping_method() . "\n";
				$note .= "Tracking number:\n";
				$note .= $tracking_number . "\n";

				// Add the note.
				$order->add_order_note( $note );

				update_post_meta( $order_id, '_added_tracking_number', $tracking_number, '' );
				update_post_meta( $order_id, '_added_shipping_vendor', $shipping_vendor, '' );

				$order->update_status( 'completed' );

				$output = '';
				if ( ! empty( $order_number ) ) :
					$output .= '<p>Order Number: ' . $order_number . ' has been updated. <br />tracking Number: ' . $tracking_number . '</p>';
				else :
					$output .= '<p>Order Number: ' . $order_id . ' has been updated. <br />tracking Number: ' . $tracking_number . '</p>';
				endif;
				$output .= '<p><a class="wonka-btn" href="' . get_site_url() . '/tracking-portal/?have_tracking=true">Reload form</a></p>';

				$confirmation = $output;
		endif;
	endif;

	return $confirmation;
}

/**
 * This either creates new Perks Member or updates current member.
 *
 * @param  object $entry Contains an object of the form entries.
 * @param  object $form  Contains an object of the form.
 * @return         returns success or blank.
 */
function wonkasoft_after_cep_update_entry( $entry, $form ) {
	$forms_to_process = array(
		'Apera Customer Engagement Program New Member',
		'Apera Customer Engagement Program Update Member',
	);

	if ( ! in_array( $form['title'], $forms_to_process, true ) ) {
		return;
	}

	$entry_fields                  = array();
	$entry_fields['custom_fields'] = array();
	$set_labels                    = array(
		'First',
		'Last',
		'Engage Email',
		'Street Address',
		'Address Line 2',
		'City',
		'State / Province',
		'ZIP / Postal Code',
	);
	$custom_fields                 = array();
	$pattern                       = '/([ \/]{1,5})/';
	foreach ( $form['fields'] as $field ) {
		if ( 'honeypot' !== $field['type'] ) :
			if ( in_array( $field['label'], $set_labels, true ) ) :
				$entry_fields[ strtolower( preg_replace( $pattern, '_', $field['label'] ) ) ] = $entry[ $field['id'] ];
			endif;
			if ( in_array( $field['label'], $custom_fields, true ) ) :
				$current_label = strtolower( preg_replace( $pattern, $field['label'] ) );
					array_push(
						$entry_fields['custom_fields'],
						array(
							'label' => esc_html( $current_label ),
							'value' => esc_html( $entry[ $field['id'] ] ),
						)
					);
			endif;
			if ( ! empty( $field->inputs ) ) :
				foreach ( $field->inputs as $input ) {
					if ( in_array( $input['label'], $set_labels, true ) ) :
						$entry_fields[ strtolower( preg_replace( $pattern, '_', $input['label'] ) ) ] = $entry[ $input['id'] ];
					endif;
				}
			endif;
		endif;
	}

	$user = get_user_by( 'email', $entry_fields['engage_email'] );

	if ( false === $user ) :
		return;
	endif;

	$user_id = $user->ID;

	if ( '' !== $entry_fields['street_address'] && '' !== $entry_fields['city'] && '' !== $entry_fields['state_province'] && '' !== $entry_fields['zip_postal_code'] ) :
		$set_tag = 'cep_updated';
		// Setting getResponse api args.
		$api_args = array(
			'email'         => $entry_fields['engage_email'],
			'tags'          => array(
				$set_tag,
			),
			'campaign_name' => 'apera_195932',
		);

		$getresponse = new Wonkasoft_GetResponse_Api( $api_args );
		$response    = array();

		if ( empty( $getresponse->campaign_id ) ) :
			foreach ( $getresponse->campaign_list as $campaign ) :
				if ( $api_args['campaign_name'] === $campaign->name ) :
					$getresponse->campaign_id = $campaign->campaignId;
				endif;
			endforeach;
		endif;

		if ( empty( $getresponse->contact_id ) ) :
			foreach ( $getresponse->contact_list as $contact ) :
				if ( empty( $getresponse->campaign_id ) ) {
					$getresponse->contact_id = $contact->contactId;
				} else {
					if ( $getresponse->campaign_id === $contact->campaign->campaignId ) :
						$getresponse->contact_id = $contact->contactId;
					endif;
				}
			endforeach;
		endif;

		if ( ! empty( $getresponse->custom_fields ) ) :
			$getresponse->custom_fields_list      = $getresponse->get_a_list_of_custom_fields();
			$getresponse->custom_fields_to_update = array();
			foreach ( $getresponse->custom_fields_list as $field ) {
				if ( in_array( $field->name, $getresponse->custom_fields, true ) ) :
					$add_field = array(
						'customFieldId' => $field->customFieldId,
						'value'         => array(
							$getresponse->custom_fields_values[ $field->name ],
						),
					);
					array_push( $getresponse->custom_fields_to_update, $add_field );
				endif;
			}
			$this_response = $getresponse->upsert_the_custom_fields_of_a_contact();
			array_push( $response, $this_response );
		endif;

		if ( ! empty( $getresponse->tags ) ) :
			$getresponse->tags_to_update = array();
			foreach ( $getresponse->tag_list as $tag ) {
				if ( in_array( $tag->name, $getresponse->tags ) ) :
					$tag_id = array(
						'tagId' => $tag->tagId,
					);
					array_push( $getresponse->tags_to_update, $tag_id );
				endif;
			}
			$this_response = $getresponse->upsert_the_tags_of_contact();
			array_push( $response, $this_response );
		endif;

		if ( 0 !== $user_id ) :
			update_user_meta( $user_id, 'getResponse_data', $response );
		endif;

	endif;
}
add_action( 'gform_after_submission', 'wonkasoft_after_cep_update_entry', 10, 2 );

/**
 * Adds the javascript required to view your password.
 *  Turn the the input type into text and back to password.
 *
 * @param   object $form  form object.
 *
 * @author Carlos
 */
function wonka_gform_validation( $form ) {
	$output = "if ( document.querySelectorAll( 'div.input-group-append' ) )
	{
		var password_toggle_btns = document.querySelectorAll( 'div.input-group-append' );
		password_toggle_btns.forEach( function( password_toggle_btn )
		{
			password_toggle_btn.addEventListener( 'click', function( e )
			{
				var parent_input, password_input, password_icon_btn, password_type;
				var target = e.target;
				if ( target.nodeName === 'DIV' ) 
				{
					password_icon_btn = target.firstElementChild;
					parent_input = target.parentElement.parentElement;
					password_input = parent_input.firstElementChild;
					password_type = password_input.getAttribute( 'type' );
				}
				if ( target.nodeName === 'I' ) 
				{
					password_icon_btn = target;
					target = target.parentElement;
					parent_input = target.parentElement.parentElement;
					password_input = parent_input.firstElementChild;
					password_type = password_input.getAttribute( 'type' );
				}
				if( password_type === 'password' )
				{
					password_icon_btn.classList.toggle( 'fa-eye' );
					password_icon_btn.classList.toggle( 'fa-eye-slash' );
					password_input.type = 'text';
				}
				if ( password_type === 'text' ) 
				{
					password_icon_btn.classList.toggle( 'fa-eye' );
					password_icon_btn.classList.toggle( 'fa-eye-slash' );
					password_input.type = 'password';
				}
			});
		});
	}";
	GFFormDisplay::add_init_script( $form['id'], 'myaccount_validation', GFFormDisplay::ON_PAGE_RENDER, $output );
}
add_action( 'gform_register_init_scripts', 'wonka_gform_validation' );

/**
 * This is for setting the name fields for Join MSE+ Form.
 *
 * @param  array $form contains an array of the form.
 */
function wonkasoft_pre_submission( $form ) {

	if ( 'Tracking Post' === $form['title'] ) {
		$customer_email = '';
		$order_input    = '';
		$email_input    = '';

		foreach ( $form['fields'] as &$field ) {
			if ( 'Order Id' === $field['label'] ) {
				$order_input = 'input_' . $field['id'];
			}

			if ( 'Order Number' === $field['label'] ) {
				$order_input = 'input_' . $field['id'];
			}

			if ( 'Email' === $field['label'] ) {
				$email_input = 'input_' . $field['id'];
			}
		}

		$order = wc_get_order( rgpost( $order_input ) );

		if ( empty( $order ) ) :
			$order_id = wc_seq_order_number_pro()->find_order_by_order_number( rgpost( $order_input ) );
			$order    = wc_get_order( $order_id );
		endif;

		if ( empty( $order ) ) :
			return;
		endif;

		$customer_email = $order->get_billing_email();

		$_POST[ $email_input ] = $customer_email;

		return;
	}

	if ( 'Join MSE+' !== $form['title'] ) {
		return;
	}

	$user_email = '';
	$inputs     = array();
	$input_val  = '';
	foreach ( $form['fields'] as &$field ) {
		if ( 'Name' === $field['label'] ) {
			$inputs = $field['inputs'];
		}
		if ( 'Email' === $field['label'] ) {
			$input_val  = 'input_' . $field['id'];
			$user_email = rgpost( $input_val );
		}
	}

	$user = get_user_by( 'email', $user_email );

	if ( false === $user ) :
		return;
	endif;

	$first_name = preg_split( '/[\s]/', $user->data->display_name )[0];
	$last_name  = preg_split( '/[\s]/', $user->data->display_name )[1];
	foreach ( $inputs as $cur_input ) {
		if ( 'First' === $cur_input['label'] ) {
			$input_val           = 'input_' . $cur_input['id'];
			$_POST[ $input_val ] = $first_name;
		}

		if ( 'Last' === $cur_input['label'] ) {
			$input_val           = 'input_' . $cur_input['id'];
			$_POST[ $input_val ] = $last_name;
		}
	}
}
add_action( 'gform_pre_submission', 'wonkasoft_pre_submission' );

/**
 * This is for the custom date to footer of notification emails.
 *
 * @param string $text Contains a merge tag text.
 * @param array  $form Contains an array of the form.
 * @param array  $entry Contains an array of the form entries.
 * @param string $url_encode Contains a string of the url encode.
 * @param string $esc_html Contains a string escaped from html.
 * @param string $nl2br Contains unknown.
 * @param string $format Contains unknown.
 * @return string   returns the copyright year.
 */
function wonkasoft_gform_replace_merge_tags( $text, $form, $entry, $url_encode, $esc_html, $nl2br, $format ) {
	$merge_tag = '{custom_date}';

	if ( strpos( $text, $merge_tag ) === false ) {
		return $text;
	}

	$local_timestamp = GFCommon::get_local_timestamp( time() );
	$local_date      = date_i18n( 'Y', $local_timestamp, true );

	return str_replace( $merge_tag, $url_encode ? rawurlencode( $local_date ) : $local_date, $text );
}
add_filter( 'gform_replace_merge_tags', 'wonkasoft_gform_replace_merge_tags', 10, 7 );

/**
 * This function sets custom merge tags for gravity forms.
 *
 * @param array $merge_tags Contains an array of the current merge tags.
 * @param int   $form_id Contains the form ID.
 * @param array $fields Contains an array of the form fields.
 * @param int   $element_id Contains the current element ID.
 * @return array returns the merge tags that are set.
 */
function wonkasoft_custom_merge_tags( $merge_tags, $form_id, $fields, $element_id ) {
	$merge_tags[] = array(
		'label' => 'Copyright Year',
		'tag'   => '{custom_date}',
	);
	return $merge_tags;
}
add_filter( 'gform_custom_merge_tags', 'wonkasoft_custom_merge_tags', 10, 4 );
/*=====  End of Customizing of Gravity forms  ======*/
