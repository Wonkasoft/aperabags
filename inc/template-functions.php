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
 * @param  string $section pass in the section for the mods desired.
 * @return object          returns an object of the mods for the passed section.
 */
function get_section_mods( $section ) {
	return the_mods_for_section( $section );
}
/**
 * This grabs all slides that are set in the customizer for the section that is passed in.
 *
 * @param  string $section should be a section reference example: top, cta, cause.
 * @return bool/object    returns false if no slides are set in customizer.
 */
function the_mods_for_section( $section ) {
	$mods_class = new stdClass();
	$count = 0;
	if ( 'top' === $section ) :
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
				// Mobile theme mod.
				$slide->slide_mobile_img                            = get_theme_mod( 'slider_mobile_' . $i );

				$mods_class->slides->{"slide_{$i}"}     = $slide;
			endif;
		}

		$mods_class->slides->count = $count;

		return $mods_class;
	endif;

	if ( 'shop' === $section ) :
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

	if ( 'cta' === $section ) :
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
				// Mobile Theme mod.
				$slide->slide_mobile_img                            = get_theme_mod( 'cta_slider_mobile_' . $i );

				$mods_class->slides->{"slide_{$i}"}     = $slide;
			endif;
		}

		$mods_class->slides->count = $count;

		return $mods_class;
	endif;

	if ( 'cause' === $section ) :
		if ( ! empty( get_theme_mod( 'cause_section_title' ) ) ) :
			$count++;
			$cause                                      = new stdClass();
			$cause->cause_section_title                 = get_theme_mod( 'cause_section_title' );
			$cause->cause_section_background            = get_theme_mod( 'cause_section_background' );

			$mods_class->{'cause_mods'} = $cause;
			$mods_class->{'cause_mods'}->count          = $count;
		endif;

		$count = 0;
		$mods_class->causes                             = new stdClass();
		for ( $i = 1; $i <= 3; $i++ ) {
			if ( ! empty( get_theme_mod( 'cause_image_' . $i ) ) ) :
				$count++;
				${"cause_$i"}                           = new stdClass();
				${"cause_$i"}->img                      = get_theme_mod( 'cause_image_' . $i );
				${"cause_$i"}->img_link                 = get_permalink( get_theme_mod( 'cause_image_link_' . $i ) );
				${"cause_$i"}->position                 = get_theme_mod( 'cause_message_position_' . $i );
				${"cause_$i"}->header                   = get_theme_mod( 'cause_header_' . $i );
				${"cause_$i"}->message                  = get_theme_mod( 'cause_message_' . $i );

				$mods_class->causes->{"cause_$i"}       = ${"cause_$i"};
			endif;
		}

		$mods_class->causes->count = $count;

		return $mods_class;
	endif;

	if ( 'about' === $section ) :
		if ( ! empty( get_theme_mod( 'about_the_brand_header' ) ) ) :
			$count++;
			$about                                      = new stdClass();
			$about->about_header                        = get_theme_mod( 'about_the_brand_header' );
			$about->about_subheader                     = get_theme_mod( 'about_the_brand_subheader' );
			$about->about_message                       = get_theme_mod( 'about_the_brand_message' );
			$about->about_the_brand_btn_text            = get_theme_mod( 'about_the_brand_btn_text' );
			$about->about_the_brand_button_link         = get_permalink( get_theme_mod( 'about_the_brand_button_link' ) );
			$about->about_the_brand_second_image        = get_theme_mod( 'about_the_brand_second_image' );
			$about->about_the_brand_image_link          = get_permalink( get_theme_mod( 'about_the_brand_second_image_link', '#' ) );

			$mods_class->{'about_the_brand'}            = $about;
			$mods_class->{'about_the_brand'}->count     = $count;
		endif;

		return $mods_class;
	endif;

	if ( 'social' === $section ) :
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

	if ( 'footer' === $section ) :
		if ( ! empty( get_theme_mod( 'footer_social_instagram' ) ) ) :
			$count++;
			$footer                                     = new stdClass();
			$footer->footer_social_title                = get_theme_mod( 'footer_social_title' );
			$footer->footer_social_instagram            = get_theme_mod( 'footer_social_instagram' );
			$footer->footer_social_twitter              = get_theme_mod( 'footer_social_twitter' );
			$footer->footer_social_facebook             = get_theme_mod( 'footer_social_facebook' );
			$footer->footer_social_pinterest            = get_theme_mod( 'footer_social_pinterest' );
			$footer->footer_contact_message             = get_theme_mod( 'footer_contact_message' );
			$footer->footer_contact_support_email       = get_theme_mod( 'footer_contact_support_email' );
			$footer->footer_logo                        = get_theme_mod( 'footer_logo' );
			$footer->footer_form_shortcode              = get_theme_mod( 'footer_form_shortcode' );

			$mods_class->{'footer_mods'}                = $footer;
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

	if ( 'newsletter' === $section ) :
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
		$form['cssClass'] .= ' form-inline wonka-newsletter-form';
	endif;

	if ( in_array( $form['title'], array( 'Refersion Registration Ambassador', 'Refersion Registration Zip' ) ) ) :
		$form['cssClass'] .= ' inline-form wonka-refersion-form';
	endif;

	if ( in_array( $form['title'], array( 'Refersion Registration Zip' ) ) ) :
		echo "<pre>\n";
		print_r( $form['fields'] );
		echo "</pre>\n";
	endif;

	if ( in_array( $form['title'], array( 'ZIP Program' ) ) ) :
		$form['cssClass'] .= ' inline-form wonka-zip-form';
	endif;

	if ( in_array( $form['title'], array( 'Ambassador Program' ) ) ) :
		$form['cssClass'] .= ' inline-form wonka-ambassador-form';
	endif;
	foreach ( $form['fields'] as $field ) :
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

			if ( empty( $field['placeholder'] ) ) :
				$field['placeholder'] = $field['label'];
			endif;
		endif;
	endforeach;

	return $form;
}
add_filter( 'gform_pre_render', 'add_bootstrap_container_class', 10, 6 );

add_filter( 'gform_enable_password_field', '__return_true' );

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

	/**
	 * This is an admin referer check.
	 *
	 * @return boolean [description]
	 */
	function is_admin_page() {
		if ( function_exists( 'check_admin_referer' ) ) {
			return true;
		} else {
			return false;
		}
	}
}

/**
 * Addition of apera-bags theme options.
 */
function aperabags_add_theme_options() {
	add_options_page(
		'Aperabags Theme Options',
		'Theme Options',
		'manage_options',
		'aperabags-theme-options',
		'aperabags_theme_options_page'
	);

	$registered_options = ( ! empty( get_option( 'custom_options_added' ) ) ) ? get_option( 'custom_options_added' ) : '';

	foreach ( $registered_options as $register_option ) {
		$set_args = array(
			'type'              => 'string',
			'description'       => $register_option['description'],
			'sanitize_callback' => 'aperabags_options_sanitize',
			'show_in_rest'      => false,
		);

		register_setting( 'aperabags-theme-options-group', $register_option['id'], $set_args );
	}
}

add_action( 'admin_menu', 'aperabags_add_theme_options' );

/**
 * Used to sanitize the options
 *
 * @param  string $option contains the value within the option.
 * @return string         returns the sanitized option value.
 */
function aperabags_options_sanitize( $option ) {
	$option = esc_html( $option );
	return $option;
}

/**
 * This builds the display of the options page.
 */
function aperabags_theme_options_page() {   ?>
		<div class="container">
			<div class="row">
				<div class="col-12 title-column">
					<?php
					$title_text = get_admin_page_title();
					?>
					<h3 class="title-header"><?php echo wp_kses_post( $title_text ); ?></h3>
				</div>
			</div>
			<div class="row">
				<div class="col-12 options column">
					<div class="card w-100">
						<div class="card-title">
							<h3><?php esc_html_e( 'Add an option', 'aperabags' ); ?></h3>
							<button type="button" id="theme_option_add" class="wonka-btn" data-toggle="modal" data-target="#add_option_modal">OPTION <i class="fa fa-plus"></i></button>
						</div>
						<div class="card-body">
					<form id="custom-options-form" method="post" action="options.php">

					  <?php settings_fields( 'aperabags-theme-options-group' ); ?>

					  <?php do_settings_sections( 'aperabags-theme-options-group' ); ?>

							<?php
								$registered_options = ( ! empty( get_option( 'custom_options_added' ) ) ) ? get_option( 'custom_options_added' ) : '';

							if ( ! empty( $registered_options ) ) :
								foreach ( $registered_options as $register_option ) {
									$current_option = ( ! empty( get_option( $register_option['id'] ) ) ) ? get_option( $register_option['id'] ) : '';

									wonkasoft_theme_option_parse(
										array(
											'id'                => $register_option['id'],
											'label'             => $register_option['label'],
											'value'             => $current_option,
											'desc_tip'          => true,
											'description'       => $register_option['description'],
											'wrapper_class'     => 'form-row form-row-full form-group',
											'class'             => 'form-control',
											'api'               => $register_option['api'],
										)
									);
								}
							endif;
							?>
				<div class="submitter">

								  <?php submit_button( 'Save Settings' ); ?>

				</div>
				</form>
						  </div>
					</div><!-- card w-100 -->
				</div>
				<!-- Modal -->
				<div id="add_option_modal" class="modal fade" role="dialog">
				  <div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
					  <div class="modal-header">
						<h4 class="modal-title">Add Option</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					  </div>
					  <div class="modal-body">
							<div class="input-group mb-3">
								<input class="form-control" type="text" id="new_option_name" name="new_option_name" placeholder="enter option name..." value="" />
							</div>
							<div class="input-group mb-3">
								<input class="form-control" type="text" id="new_option_description" name="new_option_description" placeholder="enter option description..." value="" />
							</div>
							<div class="input-group mb-3">
								<input class="form-control" type="text" id="new_option_api" name="new_option_api" placeholder="whos api..." value="" />
							</div>
							<?php
							wp_nonce_field(
								'theme_options_ajax_post',
								'new_option_nonce',
								true,
								true
							);
							?>
					  </div>
					  <div class="modal-footer">
							<button type="button" class="btn wonka-btn btn-success" data-dismiss="modal" id="add_option_name">Add option <i class="fa fa-plus"></i></button>
					  </div>
					</div>

				  </div>
				</div>
			</div>
		</div>
	<?php
}

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
			$data->option_name = preg_replace( $pattern, '_', strtolower( $data->option_name ) );

			if ( ! in_array( $data->option_name, $current_options ) ) :
				array_push(
					$current_options,
					array(
						'id' => $data->option_name,
						'label' => $data->option_label,
						'description' => $data->option_description,
						'api' => $data->option_api,
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
						'id'                => $data->option_name,
						'label'             => $data->option_label,
						'value'             => '',
						'desc_tip'          => true,
						'description'       => $data->option_description,
						'wrapper_class'     => 'form-row form-row-full form-group',
						'class'             => 'form-control',
						'api'               => $data->option_api,
					)
				);

				$data->new_elements = ob_get_clean();

				$data->msg = 'Current options have been updated';
				wp_send_json_success( $data );
			else :
				$data->current_options = $current_options;
				$data->msg = $data->option_name . ' is already a current option.';
				wp_send_json_success( $data );
			endif;
	endif;

}
add_action( 'wp_ajax_theme_options_ajax_post', 'theme_options_ajax_post', 10 );
add_action( 'wp_ajax_nopriv_theme_options_ajax_post', 'theme_options_ajax_post', 10 );

/**
 * For the parsing of option fields.
 *
 * @param  array $field array of the fields.
 */
function wonkasoft_theme_option_parse( $field ) {

	$field['class']         = isset( $field['class'] ) ? $field['class'] : 'select short';
	$field['style']         = isset( $field['style'] ) ? $field['style'] : '';
	$field['wrapper_class'] = isset( $field['wrapper_class'] ) ? $field['wrapper_class'] : '';
	$field['value']         = isset( $field['value'] ) ? $field['value'] : '';
	$field['name']          = isset( $field['name'] ) ? $field['name'] : $field['id'];
	$field['desc_tip']      = isset( $field['desc_tip'] ) ? $field['desc_tip'] : false;
	$styles_set = ( ! empty( $field['style'] ) ) ? ' style="' . esc_attr( $field['style'] ) . '" ' : '';

	// Custom attribute handling.
	$custom_attributes = array();
	$output = '';

	if ( ! empty( $field['custom_attributes'] ) && is_array( $field['custom_attributes'] ) ) {
		foreach ( $field['custom_attributes'] as $attribute => $value ) {
			$custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $value ) . '"';
		}
	}

	$output .= '<div class="' . esc_attr( $field['id'] ) . '_field ' . esc_attr( $field['wrapper_class'] ) . '">
		<label for="' . esc_attr( $field['id'] ) . '">' . wp_kses_post( $field['label'] ) . '</label>';

	if ( ! empty( $field['description'] ) && false !== $field['desc_tip'] ) {
		$output .= '<span class="woocommerce-help-tip" data-toggle="tooltip" data-placement="top" title="' . esc_attr( $field['description'] ) . '"></span>';
	}

	if ( 'ga' === $field['api'] ) :
		$place_holder = ' placeholder="UA-XXXXXX-X"';
	else :
		$place_holder = ' placeholder="Paste api key..."';
	endif;
	$output .= '<div class="input-group">';
	$output .= '<input type="password" id="' . esc_attr( $field['id'] ) . '" name="' . esc_attr( $field['name'] ) . '" class="' . esc_attr( $field['class'] ) . '" ' . $styles_set . implode( ' ', $custom_attributes ) . ' value="' . esc_attr( $field['value'] ) . '"' . $place_holder . ' /> ';
	$output .= '<div class="input-group-append">';
	$output .= '<button class="btn wonka-btn btn-danger" type="button" id="remove-' . esc_attr( $field['id'] ) . '"><i class="fa fa-minus"></i></button>';
	$output .= '</div>';
	$output .= '</div>';
	if ( ! empty( $field['description'] ) && false !== $field['desc_tip'] ) {
		$output .= '<span class="description">' . wp_kses_post( $field['description'] ) . '</span>';
	}

	$output .= '</div>';

	echo wp_kses(
		$output,
		array(
			'label'         => array(
				'for'           => array(),
			),
			'input'         => array(
				'class'                     => array(),
				'name'                      => array(),
				'id'                        => array(),
				'type'                      => array(),
				'value'                     => array(),
				'placeholder'               => array(),
			),
			'span'          => array(
				'class'         => array(),
			),
			'div'          => array(
				'class'         => array(),
			),
			'button'          => array(
				'class'         => array(),
				'type'          => array(),
				'id'            => array(),
			),
			'i'          => array(
				'class'         => array(),
			),
		)
	);
}

/**
 * This is for enqueuing the script for the theme options page only.
 *
 * @param  string $page contains the page name.
 */
function theme_options_js( $page ) {

	if ( 'settings_page_aperabags-theme-options' === $page ) :
		wp_enqueue_style( 'bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css', array(), '4.3.1', 'all' );

		wp_style_add_data( 'bootstrap', array( 'integrity', 'crossorigin' ), array( 'sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T', 'anonymous' ) );

		wp_enqueue_script( 'bootstrapjs', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', array( 'jquery' ), '4.3.1', true );

		wp_script_add_data( 'bootstrapjs', array( 'integrity', 'crossorigin' ), array( 'sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM', 'anonymous' ) );

		wp_enqueue_script( 'theme-options-js', str_replace( array( 'http:', 'https:' ), '', get_stylesheet_directory_uri() . '/inc/js/theme-options-js.js' ), array( 'jquery' ), '20190819', true );
	endif;
}
add_action( 'admin_enqueue_scripts', 'theme_options_js', 10, 1 );

/**
 * The adding of meta boxes
 *
 * @param  string|array $post_type contains the post_types for option to display on.
 * @param  object       $post      contains the current post.
 */
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

/**
 * Display of the author in the meta box.
 *
 * @param  object $post   contains the current post.
 * @param  string $option contains the current option value.
 */
function author_display_meta_box( $post, $option ) {
	wp_nonce_field( 'author_display_option', 'author_display_wpnonce', true, true );
	$checked = ( get_post_meta( $post->ID, $option['args']['option_name'], false ) ) ? ' checked="true"' : '';
	$output = '';

	$output .= '<input type="checkbox" name="' . esc_attr( $option['args']['option_name'] ) . '" id="' . esc_attr( $option['args']['option_name'] ) . '" class="form-check-input"' . $checked . ' />';
	$output .= '<label class="option-title form-check-label">' . $option['args']['label'] . '</label>';

	echo '<div class="form-check">' . wp_kses_post( $output ) . '</div>';
}

			/**
			 * For saving the author display
			 *
			 * @param  integer $post_id contains the post ID.
			 * @param  object  $post    contains the current post.
			 */
function wonkasoft_save_author_display( $post_id, $post ) {
	$nonce_action = 'author_display_option';

	// Check if nonce is valid.
	if ( ! wp_verify_nonce( isset( $_POST['author_display_wpnonce'] ), $nonce_action ) ) {
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

/**
 * This is the ajax call for the newsletter popup.
 */
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

/**
 * For the theme popup cookie.
 */
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

/**
 * Newsletter popup entry or form submission.
 *
 * @param  array $entry contains the data from the entry.
 * @param  array $form  array of the form fields.
 * @return blank
 */
function wonkasoft_newsletter_popup_entry( $entry, $form ) {

	$user_id = get_current_user_id();
	$form_title = str_replace( ' ', '-', strtolower( $form['title'] ) );

	if ( 'popup' === $form_title ) :
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

	if ( 'sign-up' === $form_title ) :
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
 *
 * @param string  $hook_name hook name that is passed in.
 * @param string  $method_name method or callback name that is passed in.
 * @param integer $priority contains the priority of when to run.
 */
function ws_remove_filters_with_method_name( $hook_name = '', $method_name = '', $priority = 0 ) {
	global $wp_filter;
	// Take only filters on right hook name and priority.
	if ( ! isset( $wp_filter[ $hook_name ][ $priority ] ) || ! is_array( $wp_filter[ $hook_name ][ $priority ] ) ) {
		return false;
	}
	// Loop on filters registered.
	foreach ( (array) $wp_filter[ $hook_name ][ $priority ] as $unique_id => $filter_array ) {
		// Test if filter is an array ! (always for class/method).
		if ( isset( $filter_array['function'] ) && is_array( $filter_array['function'] ) ) {
			// Test if object is a class and method is equal to param.
			if ( is_object( $filter_array['function'][0] ) && get_class( $filter_array['function'][0] ) && $filter_array['function'][1] == $method_name ) {
				// Test for WordPress >= 4.7 WP_Hook class (https://make.wordpress.org/core/2016/09/08/wp_hook-next-generation-actions-and-filters/).
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
 *
 * @param string  $hook_name hook name that is passed in.
 * @param string  $class_name class name of where to find the method that is passed in.
 * @param string  $method_name method or callback name that is passed in.
 * @param integer $priority contains the priority of when to run.
 */
function ws_remove_filters_for_anonymous_class( $hook_name = '', $class_name = '', $method_name = '', $priority = 0 ) {
	global $wp_filter;
	// Take only filters on right hook name and priority.
	if ( ! isset( $wp_filter[ $hook_name ][ $priority ] ) || ! is_array( $wp_filter[ $hook_name ][ $priority ] ) ) {
		return false;
	}
	// Loop on filters registered.
	foreach ( (array) $wp_filter[ $hook_name ][ $priority ] as $unique_id => $filter_array ) {
		// Test if filter is an array ! (always for class/method).
		if ( isset( $filter_array['function'] ) && is_array( $filter_array['function'] ) ) {
			// Test if object is a class, class and method is equal to param !
			if ( is_object( $filter_array['function'][0] ) && get_class( $filter_array['function'][0] ) && get_class( $filter_array['function'][0] ) == $class_name && $filter_array['function'][1] == $method_name ) {
				// Test for WordPress >= 4.7 WP_Hook class (https://make.wordpress.org/core/2016/09/08/wp_hook-next-generation-actions-and-filters/).
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
 * This function is filtering the states to abbriviations.
 *
 * @param  array $address_types An array of address types.
 * @param  int   $form_id The ID of the form being filtered.
 * @return array $address_types A modified array of address types.
 */
function filter_states_to_abbriviations( $address_types, $form_id ) {
	$address_types['us'] = array(
		'label' => 'United States',
		'country' => 'US',
		'zip_label' => 'Zip Code',
		'state_label' => 'State',
		'states' => array(
			'' => '',
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
 * This function fires after Refersion Registration form is ssubmitted.
 *
 * @param  array $entry contains the data from surrent.
 * @param  array $form  Contains an array of the form.
 */
function make_refersion_api_calls( $entry, $form ) {
	$set_forms = array(
		'Refersion Registration Ambassador',
		'Refersion Registration Zip',
	);

	update_option( 'registration_passing_args', null );

	// Check to see if form should be processed here.
	if ( ! in_array( $form['title'], $set_forms ) ) :
		return;
	endif;

	// Setting the campaign name.
	if ( 'Refersion Registration Ambassador' === $form['title'] ) :
		$campaign_name = 'ambassador_program_signups';
		$set_tag = 'ambassadorcompleted';
	endif;

	if ( 'Refersion Registration Zip' === $form['title'] ) :
		$campaign_name = 'zip_program_signups';
		$set_tag = 'zipcompleted';
	endif;

	// Get current user object.
	$current_user = wp_get_current_user();
	// Get current user ID.
	$user_id = $current_user->ID;

	$entry_fields = array();
	$entry_fields['custom_fields'] = array();
	$set_labels = array(
		'First',
		'Last',
		'Company',
		'Email',
		'Paypal Email',
		'Password',
		'Street Address',
		'Address Line 2',
		'City',
		'State / Province',
		'ZIP / Postal Code',
		'Phone',
	);
	$custom_fields = array();

	$pattern = '/([ \/]{1,5})/';

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

	// Setting getResponse api args.
	$api_args = array(
		'email'               => $entry_fields['email'],
		'tags'                 => array(
			$set_tag,
		),
		'campaign_name'       => $campaign_name,
	);

	if ( 0 === $user_id ) :

		// Check if email has user account already.
		if ( email_exists( $entry_fields['email'] ) ) {
			$user = get_user_by( 'email', $entry_fields['email'] );

			if ( ! in_array( 'apera_affiliate', $user->roles ) ) :
				wp_update_user(
					array(
						'ID' => $user_id,
						'role' => 'apera_affiliate',
					)
				);
			endif;

			$new_affiliate_created = new Wonkasoft_Refersion_Api( $entry_fields );

			$refersion_response = $new_affiliate_created->add_new_affiliate();

			if ( 'failed' !== $refersion_response->status ) :

				if ( ! empty( $refersion_response->errors ) ) :

					if ( ! empty( $new_affiliate_created->affiliate_code ) ) :

						$refersion_response = $new_affiliate_created->get_affiliate();

						$args = array(
							'post_type' => 'shop_coupon',
							'post_status' => 'publish',
							'posts_per_page' => -1,
						);

						$coupons = new WP_Query( $args );
						$foundzip = false;
						$foundambassador = false;
						$percentage = '10';
						foreach ( $coupons->posts as $coupon ) :
							if ( $entry_fields['company'] === $coupon->post_name ) :
								$foundzip = true;
							endif;

							if ( substr( $entry_fields['first'], 0, 1 ) . $entry_fields['last'] . $percentage === $coupon->post_name ) :
								$foundambassador = true;
							endif;
						endforeach;
						if ( 'Refersion Registration Zip' === $form['title'] && $foundzip ) :
							/**
							 * Create a coupon programatically
							 */
							$coupon_code = $entry_fields['company']; // Code.
							$discount_type = 'percent'; // Type: fixed_cart, percent, fixed_product, percent_product.

							$coupon = array(
								'post_title' => $coupon_code,
								'post_content' => '',
								'post_status' => 'publish',
								'post_author' => 1,
								'post_type'     => 'shop_coupon',
							);

							$new_coupon_id = wp_insert_post( $coupon );

							// Add meta.
							update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
							update_post_meta( $new_coupon_id, 'coupon_amount', $percentage );
							update_post_meta( $new_coupon_id, 'individual_use', 'no' );
							update_post_meta( $new_coupon_id, 'product_ids', '' );
							update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
							update_post_meta( $new_coupon_id, 'usage_limit', '' );
							update_post_meta( $new_coupon_id, 'expiry_date', '' );
							update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
							update_post_meta( $new_coupon_id, 'free_shipping', 'no' );
						endif;

						if ( 'Refersion Registration Ambassador' === $form['title'] && $foundambassador ) :
							/**
							 * Create a coupon programatically
							 */
							$coupon_code = substr( $entry_fields['first'], 0, 1 ) . $entry_fields['last'] . $percentage; // Code.
							$discount_type = 'percent'; // Type: fixed_cart, percent, fixed_product, percent_product.

							$coupon = array(
								'post_title' => $coupon_code,
								'post_content' => '',
								'post_status' => 'publish',
								'post_author' => 1,
								'post_type'     => 'shop_coupon',
							);

							$new_coupon_id = wp_insert_post( $coupon );

							// Add meta.
							update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
							update_post_meta( $new_coupon_id, 'coupon_amount', $percentage );
							update_post_meta( $new_coupon_id, 'individual_use', 'no' );
							update_post_meta( $new_coupon_id, 'product_ids', '' );
							update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
							update_post_meta( $new_coupon_id, 'usage_limit', '' );
							update_post_meta( $new_coupon_id, 'expiry_date', '' );
							update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
							update_post_meta( $new_coupon_id, 'free_shipping', 'no' );
						endif;

						// Setting affiliate code and link to send to getResponse.
						$api_args['custom_fields'] = array(
							'affiliate_code',
							'affiliate_link',
							'discount_code',
						);
						$api_args['custom_fields_values'] = array(
							'affiliate_code'    => ( ! empty( $refersion_response->id ) ) ? $refersion_response->id : '',
							'affiliate_link'    => ( ! empty( $refersion_response->link ) ) ? $refersion_response->link : '',
							'discount_code'         => $coupon_code,
						);

						// Send to getResponse.
						$getresponse = get_response_api_call( $api_args );

						update_user_meta( $user_id, 'refersion_data', $refersion_response );
						update_user_meta( $user_id, 'getResponse_data', $getresponse );

						else :

							// Setting affiliate code and link to send to getResponse.
							$api_args['custom_fields'] = array(
								'affiliate_error_code',
							);
							$api_args['custom_fields_values'] = array(
								'affiliate_error_code'  => ( ! empty( $refersion_response->errors ) ) ? $refersion_response->errors[0] : '',
							);
							// Send to getResponse.
							$getresponse = get_response_api_call( $api_args );

							update_user_meta( $user_id, 'refersion_error', $refersion_response->errors );
							update_user_meta( $user_id, 'getResponse_data', $getresponse );

					endif;
						else :

							$args = array(
								'post_type' => 'shop_coupon',
								'post_status' => 'publish',
								'posts_per_page' => -1,
							);

							$coupons = new WP_Query( $args );
							$foundzip = false;
							$foundambassador = false;
							$percentage = '10';
							foreach ( $coupons->posts as $coupon ) :
								if ( $entry_fields['company'] === $coupon->post_name ) :
									$foundzip = true;
								endif;

								if ( substr( $entry_fields['first'], 0, 1 ) . $entry_fields['last'] . $percentage === $coupon->post_name ) :
									$foundambassador = true;
								endif;
							endforeach;
							if ( 'Refersion Registration Zip' === $form['title'] && $foundzip ) :
								/**
								 * Create a coupon programatically
								 */
								$coupon_code = $entry_fields['company']; // Code.
								$discount_type = 'percent'; // Type: fixed_cart, percent, fixed_product, percent_product.

								$coupon = array(
									'post_title' => $coupon_code,
									'post_content' => '',
									'post_status' => 'publish',
									'post_author' => 1,
									'post_type'     => 'shop_coupon',
								);

								$new_coupon_id = wp_insert_post( $coupon );

								// Add meta.
								update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
								update_post_meta( $new_coupon_id, 'coupon_amount', $percentage );
								update_post_meta( $new_coupon_id, 'individual_use', 'no' );
								update_post_meta( $new_coupon_id, 'product_ids', '' );
								update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
								update_post_meta( $new_coupon_id, 'usage_limit', '' );
								update_post_meta( $new_coupon_id, 'expiry_date', '' );
								update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
								update_post_meta( $new_coupon_id, 'free_shipping', 'no' );
							endif;

							if ( 'Refersion Registration Ambassador' === $form['title'] && $foundambassador ) :
								/**
								 * Create a coupon programatically
								 */
								$coupon_code = substr( $entry_fields['first'], 0, 1 ) . $entry_fields['last'] . $percentage; // Code.
								$discount_type = 'percent'; // Type: fixed_cart, percent, fixed_product, percent_product.

								$coupon = array(
									'post_title' => $coupon_code,
									'post_content' => '',
									'post_status' => 'publish',
									'post_author' => 1,
									'post_type'     => 'shop_coupon',
								);

								$new_coupon_id = wp_insert_post( $coupon );

								// Add meta.
								update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
								update_post_meta( $new_coupon_id, 'coupon_amount', $percentage );
								update_post_meta( $new_coupon_id, 'individual_use', 'no' );
								update_post_meta( $new_coupon_id, 'product_ids', '' );
								update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
								update_post_meta( $new_coupon_id, 'usage_limit', '' );
								update_post_meta( $new_coupon_id, 'expiry_date', '' );
								update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
								update_post_meta( $new_coupon_id, 'free_shipping', 'no' );
							endif;

							// Setting affiliate code and link to send to getResponse.
							$api_args['custom_fields'] = array(
								'affiliate_code',
								'affiliate_link',
								'discount_code',
							);
							$api_args['custom_fields_values'] = array(
								'affiliate_code'    => ( ! empty( $refersion_response->id ) ) ? $refersion_response->id : '',
								'affiliate_link'    => ( ! empty( $refersion_response->link ) ) ? $refersion_response->link : '',
								'discount_code'         => $coupon_code,
							);
							// Send to getResponse.
							$getresponse = get_response_api_call( $api_args );

							update_user_meta( $user_id, 'refersion_data', $refersion_response );
							update_user_meta( $user_id, 'getResponse_data', $getresponse );
				endif;
			endif;

		} else {

			// Setting time stamp.
			$ts = time();
			$date = new DateTime( "@$ts" );
			$date->setTimezone( new DateTimeZone( get_option( 'timezone_string' ) ) );

			// Setting new user args.
			$userdata = array(
				'user_pass'             => $entry_fields['password'],   // (string) The plain-text user password.
				'user_login'            => $entry_fields['email'],   // (string) The user's login username.
				'user_nicename'         => $entry_fields['first'],   // (string) The URL-friendly user name.
				'user_email'            => $entry_fields['email'],   // (string) The user email address.
				'display_name'          => $entry_fields['first'] . ' ' . $entry_fields['last'],   // (string) The user's display name. Default is the user's username.
				'first_name'            => $entry_fields['first'],   // (string) The user's first name. For new users, will be used to build the first part of the user's display name if $display_name is not specified.
				'last_name'             => $entry_fields['last'],   // (string) The user's last name. For new users, will be used to build the second part of the user's display name if $display_name is not specified.
				'use_ssl'               => true,   // (bool) Whether the user should always access the admin over https. Default false.
				'user_registered'       => $date->format( 'Y-m-d H:i:s' ),   // (string) Date the user registered. Format is 'Y-m-d H:i:s'.
				'show_admin_bar_front'  => false,   // (string|bool) Whether to display the Admin Bar for the user on the site's front end. Default true.
				'role'                  => 'apera_affiliate',   // (string) User's role.
			);

			// Inserting new user and getting user id.
			$user_id = wp_insert_user( $userdata );
			$user = new WP_User( $user_id );
			if ( ! in_array( 'apera_affiliate', $user->roles ) ) :
				wp_update_user(
					array(
						'ID' => $user_id,
						'role' => 'apera_affiliate',
					)
				);
			endif;

			$new_affiliate_created = new Wonkasoft_Refersion_Api( $entry_fields );

			$refersion_response = $new_affiliate_created->add_new_affiliate();

			if ( 'failed' !== $refersion_response->status ) :

				if ( ! empty( $refersion_response->errors ) ) :

					if ( ! empty( $new_affiliate_created->affiliate_code ) ) :

						$refersion_response = $new_affiliate_created->get_affiliate();

						$args = array(
							'post_type' => 'shop_coupon',
							'post_status' => 'publish',
							'posts_per_page' => -1,
						);

						$coupons = new WP_Query( $args );
						$foundzip = false;
						$foundambassador = false;
						$percentage = '10';
						foreach ( $coupons->posts as $coupon ) :
							if ( $entry_fields['company'] === $coupon->post_name ) :
								$foundzip = true;
							endif;

							if ( substr( $entry_fields['first'], 0, 1 ) . $entry_fields['last'] . $percentage === $coupon->post_name ) :
								$foundambassador = true;
							endif;
						endforeach;
						if ( 'Refersion Registration Zip' === $form['title'] && $foundzip ) :
							/**
							 * Create a coupon programatically
							 */
							$coupon_code = $entry_fields['company']; // Code.
							$discount_type = 'percent'; // Type: fixed_cart, percent, fixed_product, percent_product.

							$coupon = array(
								'post_title' => $coupon_code,
								'post_content' => '',
								'post_status' => 'publish',
								'post_author' => 1,
								'post_type'     => 'shop_coupon',
							);

							$new_coupon_id = wp_insert_post( $coupon );

							// Add meta.
							update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
							update_post_meta( $new_coupon_id, 'coupon_amount', $percentage );
							update_post_meta( $new_coupon_id, 'individual_use', 'no' );
							update_post_meta( $new_coupon_id, 'product_ids', '' );
							update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
							update_post_meta( $new_coupon_id, 'usage_limit', '' );
							update_post_meta( $new_coupon_id, 'expiry_date', '' );
							update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
							update_post_meta( $new_coupon_id, 'free_shipping', 'no' );
						endif;

						if ( 'Refersion Registration Ambassador' === $form['title'] && $foundambassador ) :
							/**
							 * Create a coupon programatically
							 */
							$coupon_code = substr( $entry_fields['first'], 0, 1 ) . $entry_fields['last'] . $percentage; // Code.
							$discount_type = 'percent'; // Type: fixed_cart, percent, fixed_product, percent_product.

							$coupon = array(
								'post_title' => $coupon_code,
								'post_content' => '',
								'post_status' => 'publish',
								'post_author' => 1,
								'post_type'     => 'shop_coupon',
							);

							$new_coupon_id = wp_insert_post( $coupon );

							// Add meta.
							update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
							update_post_meta( $new_coupon_id, 'coupon_amount', $percentage );
							update_post_meta( $new_coupon_id, 'individual_use', 'no' );
							update_post_meta( $new_coupon_id, 'product_ids', '' );
							update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
							update_post_meta( $new_coupon_id, 'usage_limit', '' );
							update_post_meta( $new_coupon_id, 'expiry_date', '' );
							update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
							update_post_meta( $new_coupon_id, 'free_shipping', 'no' );
						endif;

						// Setting affiliate code and link to send to getResponse.
						$api_args['custom_fields'] = array(
							'affiliate_code',
							'affiliate_link',
							'discount_code',
						);
						$api_args['custom_fields_values'] = array(
							'affiliate_code'    => ( ! empty( $refersion_response->id ) ) ? $refersion_response->id : '',
							'affiliate_link'    => ( ! empty( $refersion_response->link ) ) ? $refersion_response->link : '',
							'discount_code'         => $coupon_code,
						);

						// Send to getResponse.
						$getresponse = get_response_api_call( $api_args );

						update_user_meta( $user_id, 'refersion_data', $refersion_response );
						update_user_meta( $user_id, 'getResponse_data', $getresponse );

						else :

							// Setting affiliate code and link to send to getResponse.
							$api_args['custom_fields'] = array(
								'affiliate_error_code',
							);
							$api_args['custom_fields_values'] = array(
								'affiliate_error_code'  => ( ! empty( $refersion_response->errors ) ) ? $refersion_response->errors[0] : '',
							);
							// Send to getResponse.
							$getresponse = get_response_api_call( $api_args );

							update_user_meta( $user_id, 'refersion_error', $refersion_response->errors );
							update_user_meta( $user_id, 'getResponse_data', $getresponse );

					endif;
						else :

							$args = array(
								'post_type' => 'shop_coupon',
								'post_status' => 'publish',
								'posts_per_page' => -1,
							);

							$coupons = new WP_Query( $args );
							$foundzip = false;
							$foundambassador = false;
							$percentage = '10';
							foreach ( $coupons->posts as $coupon ) :
								if ( $entry_fields['company'] === $coupon->post_name ) :
									$foundzip = true;
								endif;

								if ( substr( $entry_fields['first'], 0, 1 ) . $entry_fields['last'] . $percentage === $coupon->post_name ) :
									$foundambassador = true;
								endif;
							endforeach;
							if ( 'Refersion Registration Zip' === $form['title'] && $foundzip ) :
								/**
								 * Create a coupon programatically
								 */
								$coupon_code = $entry_fields['company']; // Code.
								$discount_type = 'percent'; // Type: fixed_cart, percent, fixed_product, percent_product.

								$coupon = array(
									'post_title' => $coupon_code,
									'post_content' => '',
									'post_status' => 'publish',
									'post_author' => 1,
									'post_type'     => 'shop_coupon',
								);

								$new_coupon_id = wp_insert_post( $coupon );

								// Add meta.
								update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
								update_post_meta( $new_coupon_id, 'coupon_amount', $percentage );
								update_post_meta( $new_coupon_id, 'individual_use', 'no' );
								update_post_meta( $new_coupon_id, 'product_ids', '' );
								update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
								update_post_meta( $new_coupon_id, 'usage_limit', '' );
								update_post_meta( $new_coupon_id, 'expiry_date', '' );
								update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
								update_post_meta( $new_coupon_id, 'free_shipping', 'no' );
							endif;

							if ( 'Refersion Registration Ambassador' === $form['title'] && $foundambassador ) :
								/**
								 * Create a coupon programatically
								 */
								$coupon_code = substr( $entry_fields['first'], 0, 1 ) . $entry_fields['last'] . $percentage; // Code.
								$discount_type = 'percent'; // Type: fixed_cart, percent, fixed_product, percent_product.

								$coupon = array(
									'post_title' => $coupon_code,
									'post_content' => '',
									'post_status' => 'publish',
									'post_author' => 1,
									'post_type'     => 'shop_coupon',
								);

								$new_coupon_id = wp_insert_post( $coupon );

								// Add meta.
								update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
								update_post_meta( $new_coupon_id, 'coupon_amount', $percentage );
								update_post_meta( $new_coupon_id, 'individual_use', 'no' );
								update_post_meta( $new_coupon_id, 'product_ids', '' );
								update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
								update_post_meta( $new_coupon_id, 'usage_limit', '' );
								update_post_meta( $new_coupon_id, 'expiry_date', '' );
								update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
								update_post_meta( $new_coupon_id, 'free_shipping', 'no' );
							endif;

							// Setting affiliate code and link to send to getResponse.
							$api_args['custom_fields'] = array(
								'affiliate_code',
								'affiliate_link',
								'discount_code',
							);
							$api_args['custom_fields_values'] = array(
								'affiliate_code'    => ( ! empty( $refersion_response->id ) ) ? $refersion_response->id : '',
								'affiliate_link'    => ( ! empty( $refersion_response->link ) ) ? $refersion_response->link : '',
								'discount_code'         => $coupon_code,
							);

							// Send to getResponse.
							$getresponse = get_response_api_call( $api_args );

							update_user_meta( $user_id, 'refersion_data', $refersion_response );
							update_user_meta( $user_id, 'getResponse_data', $getresponse );
				endif;
			endif;

		}

		else :

			$new_affiliate_created = new Wonkasoft_Refersion_Api( $entry_fields );

			$refersion_response = $new_affiliate_created->add_new_affiliate();

			$user = get_user_by( 'email', $entry_fields['email'] );

			if ( ! in_array( 'apera_affiliate', $user->roles ) ) :
				wp_update_user(
					array(
						'ID' => $user->ID,
						'role' => 'apera_affiliate',
					)
				);
			endif;

			if ( 'failed' !== $refersion_response->status ) :

				if ( ! empty( $refersion_response->errors ) ) :

					if ( ! empty( $new_affiliate_created->affiliate_code ) ) :

						$refersion_response = $new_affiliate_created->get_affiliate();

						$args = array(
							'post_type' => 'shop_coupon',
							'post_status' => 'publish',
							'posts_per_page' => -1,
						);

						$coupons = new WP_Query( $args );
						$foundzip = false;
						$foundambassador = false;
						$percentage = '10';
						foreach ( $coupons->posts as $coupon ) :
							if ( $entry_fields['company'] === $coupon->post_name ) :
								$foundzip = true;
							endif;

							if ( substr( $entry_fields['first'], 0, 1 ) . $entry_fields['last'] . $percentage === $coupon->post_name ) :
								$foundambassador = true;
							endif;
						endforeach;
						if ( 'Refersion Registration Zip' === $form['title'] && $foundzip ) :
							/**
							 * Create a coupon programatically
							 */
							$coupon_code = $entry_fields['company']; // Code.
							$discount_type = 'percent'; // Type: fixed_cart, percent, fixed_product, percent_product.

							$coupon = array(
								'post_title' => $coupon_code,
								'post_content' => '',
								'post_status' => 'publish',
								'post_author' => 1,
								'post_type'     => 'shop_coupon',
							);

							$new_coupon_id = wp_insert_post( $coupon );

							// Add meta.
							update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
							update_post_meta( $new_coupon_id, 'coupon_amount', $percentage );
							update_post_meta( $new_coupon_id, 'individual_use', 'no' );
							update_post_meta( $new_coupon_id, 'product_ids', '' );
							update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
							update_post_meta( $new_coupon_id, 'usage_limit', '' );
							update_post_meta( $new_coupon_id, 'expiry_date', '' );
							update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
							update_post_meta( $new_coupon_id, 'free_shipping', 'no' );
						endif;

						if ( 'Refersion Registration Ambassador' === $form['title'] && $foundambassador ) :
							/**
							 * Create a coupon programatically
							 */
							$coupon_code = substr( $entry_fields['first'], 0, 1 ) . $entry_fields['last'] . $percentage; // Code.
							$discount_type = 'percent'; // Type: fixed_cart, percent, fixed_product, percent_product.

							$coupon = array(
								'post_title' => $coupon_code,
								'post_content' => '',
								'post_status' => 'publish',
								'post_author' => 1,
								'post_type'     => 'shop_coupon',
							);

							$new_coupon_id = wp_insert_post( $coupon );

							// Add meta.
							update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
							update_post_meta( $new_coupon_id, 'coupon_amount', $percentage );
							update_post_meta( $new_coupon_id, 'individual_use', 'no' );
							update_post_meta( $new_coupon_id, 'product_ids', '' );
							update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
							update_post_meta( $new_coupon_id, 'usage_limit', '' );
							update_post_meta( $new_coupon_id, 'expiry_date', '' );
							update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
							update_post_meta( $new_coupon_id, 'free_shipping', 'no' );
						endif;

						// Setting affiliate code and link to send to getResponse.
						$api_args['custom_fields'] = array(
							'affiliate_code',
							'affiliate_link',
							'discount_code',
						);
						$api_args['custom_fields_values'] = array(
							'affiliate_code'    => ( ! empty( $refersion_response->id ) ) ? $refersion_response->id : '',
							'affiliate_link'    => ( ! empty( $refersion_response->link ) ) ? $refersion_response->link : '',
							'discount_code'         => $coupon_code,
						);

						// Send to getResponse.
						$getresponse = get_response_api_call( $api_args );

						update_user_meta( $user_id, 'refersion_data', $refersion_response );
						update_user_meta( $user_id, 'getResponse_data', $getresponse );

						else :

							// Setting affiliate code and link to send to getResponse.
							$api_args['custom_fields'] = array(
								'affiliate_error_code',
							);
							$api_args['custom_fields_values'] = array(
								'affiliate_error_code'  => ( ! empty( $refersion_response->errors ) ) ? $refersion_response->errors[0] : '',
							);

							// Send to getResponse.
							$getresponse = get_response_api_call( $api_args );

							update_user_meta( $user_id, 'refersion_error', $refersion_response->errors );
							update_user_meta( $user_id, 'getResponse_data', $getresponse );

					endif;
						else :

							$args = array(
								'post_type' => 'shop_coupon',
								'post_status' => 'publish',
								'posts_per_page' => -1,
							);

							$coupons = new WP_Query( $args );
							$foundzip = false;
							$foundambassador = false;
							$percentage = '10';
							foreach ( $coupons->posts as $coupon ) :
								if ( $entry_fields['company'] === $coupon->post_name ) :
									$foundzip = true;
								endif;

								if ( substr( $entry_fields['first'], 0, 1 ) . $entry_fields['last'] . $percentage === $coupon->post_name ) :
									$foundambassador = true;
								endif;
							endforeach;
							if ( 'Refersion Registration Zip' === $form['title'] && $foundzip ) :
								/**
								 * Create a coupon programatically
								 */
								$coupon_code = $entry_fields['company']; // Code.
								$discount_type = 'percent'; // Type: fixed_cart, percent, fixed_product, percent_product.

								$coupon = array(
									'post_title' => $coupon_code,
									'post_content' => '',
									'post_status' => 'publish',
									'post_author' => 1,
									'post_type'     => 'shop_coupon',
								);

								$new_coupon_id = wp_insert_post( $coupon );

								// Add meta.
								update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
								update_post_meta( $new_coupon_id, 'coupon_amount', $percentage );
								update_post_meta( $new_coupon_id, 'individual_use', 'no' );
								update_post_meta( $new_coupon_id, 'product_ids', '' );
								update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
								update_post_meta( $new_coupon_id, 'usage_limit', '' );
								update_post_meta( $new_coupon_id, 'expiry_date', '' );
								update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
								update_post_meta( $new_coupon_id, 'free_shipping', 'no' );
							endif;

							if ( 'Refersion Registration Ambassador' === $form['title'] && $foundambassador ) :
								/**
								 * Create a coupon programatically
								 */
								$coupon_code = substr( $entry_fields['first'], 0, 1 ) . $entry_fields['last'] . $percentage; // Code.
								$discount_type = 'percent'; // Type: fixed_cart, percent, fixed_product, percent_product.

								$coupon = array(
									'post_title' => $coupon_code,
									'post_content' => '',
									'post_status' => 'publish',
									'post_author' => 1,
									'post_type'     => 'shop_coupon',
								);

								$new_coupon_id = wp_insert_post( $coupon );

								// Add meta.
								update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
								update_post_meta( $new_coupon_id, 'coupon_amount', $percentage );
								update_post_meta( $new_coupon_id, 'individual_use', 'no' );
								update_post_meta( $new_coupon_id, 'product_ids', '' );
								update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
								update_post_meta( $new_coupon_id, 'usage_limit', '' );
								update_post_meta( $new_coupon_id, 'expiry_date', '' );
								update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
								update_post_meta( $new_coupon_id, 'free_shipping', 'no' );
							endif;

							// Setting affiliate code and link to send to getResponse.
							$api_args['custom_fields'] = array(
								'affiliate_code',
								'affiliate_link',
								'discount_code',
							);
							$api_args['custom_fields_values'] = array(
								'affiliate_code'    => ( ! empty( $refersion_response->id ) ) ? $refersion_response->id : '',
								'affiliate_link'    => ( ! empty( $refersion_response->link ) ) ? $refersion_response->link : '',
								'discount_code'         => $coupon_code,
							);

							// Send to getResponse.
							$getresponse = get_response_api_call( $api_args );

							update_user_meta( $user_id, 'refersion_data', $refersion_response );
							update_user_meta( $user_id, 'getResponse_data', $getresponse );
				endif;
			endif;

		endif;

}
add_action( 'gform_after_submission', 'make_refersion_api_calls', 10, 2 );

/**
 * This function handles the api request to send data to getResponse.
 *
 * @param  array $api_args an array of args for the api call.
 * @return object           returns error or response from the api call.
 */
function get_response_api_call( $api_args ) {

	$response = array();
	$getresponse = new Wonkasoft_GetResponse_Api( $api_args );

	if ( empty( $getresponse->campaign_id ) ) :
		foreach ( $getresponse->campaign_list as $campaign ) :
			if ( $api_args['campaign_name'] === $campaign->name ) :
				$getresponse->campaign_id = $campaign->campaignId;
			endif;
		endforeach;
	endif;

	if ( empty( $getresponse->contact_id ) ) :
		foreach ( $getresponse->contact_list as $contact ) :
			if ( $getresponse->campaign_id === $contact->campaign->campaignId ) :
				$getresponse->contact_id = $contact->contactId;
			endif;
		endforeach;
	endif;

	if ( ! empty( $getresponse->custom_fields ) ) :
		$getresponse->custom_fields_list = $getresponse->get_a_list_of_custom_fields();
		$getresponse->custom_fields_to_update = array();
		foreach ( $getresponse->custom_fields_list as $field ) {
			if ( in_array( $field->name, $getresponse->custom_fields ) ) :
				$add_field = array(
					'customFieldId' => $field->customFieldId,
					'value' => array(
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

	return $response;
}

/**
 * This function registers the custom api route.
 */
function wonkasoft_register_custom_api() {
	register_rest_route(
		'wonkasoft/v1',
		'/getresponse-api/',
		array(
			'methods'   => 'GET',
			'callback'  => 'wonkasoft_getresponse_endpoint',
		),
		false
	);
}
add_action( 'rest_api_init', 'wonkasoft_register_custom_api' );

/**
 * This function handles the rest api endpoint for getResponse.
 *
 * @param  array $data contains params send in the url.
 * @return json    returns the response data.
 */
function wonkasoft_getresponse_endpoint( $data ) {
	if ( ! isset( $_GET['email'] ) && ! isset( $_GET['tag'] ) && ! isset( $_GET['campaign_name'] ) ) :
		return 'Invalid request, contact support for more information.';
	endif;

	$email = wp_kses_post( wp_unslash( $_GET['email'] ) );
	$passed_tag = wp_kses_post( wp_unslash( $_GET['tag'] ) );
	$campaign_name = wp_kses_post( wp_unslash( $_GET['campaign_name'] ) );

	$prep_data = array(
		'email' => $email,
		'tags'   => array(
			$passed_tag,
		),
		'campaign_name' => $campaign_name,
	);

	$getresponse = new Wonkasoft_GetResponse_Api( $prep_data );

	if ( empty( $getresponse->campaign_id ) ) :
		foreach ( $getresponse->campaign_list as $campaign ) :
			if ( $campaign_name === $campaign->name ) :
				$getresponse->campaign_id = $campaign->campaignId;
			endif;
		endforeach;
	endif;

	if ( empty( $getresponse->contact_id ) ) :
		foreach ( $getresponse->contact_list as $contact ) :
			if ( $getresponse->campaign_id === $contact->campaign->campaignId ) :
				$getresponse->contact_id = $contact->contactId;
			endif;
		endforeach;
	endif;

	if ( ! empty( $getresponse->tags ) && ! empty( $getresponse->contact_id ) ) :
		$getresponse->tags_to_update = array();
		foreach ( $getresponse->tag_list as $tag ) {
			if ( in_array( $tag->name, $getresponse->tags ) ) :
				$tag_id = array(
					'tagId' => $tag->tagId,
				);
				array_push( $getresponse->tags_to_update, $tag_id );
			endif;
		}
		$response = $getresponse->upsert_the_tags_of_contact();

		$data_send = array(
			'email' => $email,
			'tag' => $passed_tag,
			'contact_id'    => $getresponse->contact_id,
		);

		$data_send = json_decode( json_encode( $data_send ) );
		$data_send = http_build_query( $data_send );
		$url = 'https://aperabags.com/response-page/?' . $data_send;
		header( 'Content-Type: application/x-www-form-urlencoded' );
		header( 'Location: ' . $url );
	endif;

	return $getresponse;
}

/**
 * This function resets the wp-json rest api.
 *
 * @param  string $api current base route.
 * @return string      returns rest api base.
 */
function wonka_rest_api( $api ) {
	return 'api';
}
add_filter( 'rest_url_prefix', 'wonka_rest_api' );


/**
 * This function adds Affiliate and Contact data to user profile.
 *
 * @param  object $user contains an object of the user.
 */
function wonkasoft_api_responses_user_data( $user ) {
	if ( in_array( 'apera_affiliate', $user->roles ) ) :
		$user_id = $user->ID;
		$refersion = ( ! empty( get_user_meta( $user->ID, 'refersion_data', true ) ) ) ? get_user_meta( $user->ID, 'refersion_data', true ) : '';
		$refersion_error = ( ! empty( get_user_meta( $user->ID, 'refersion_error', true ) ) ) ? get_user_meta( $user->ID, 'refersion_error', true ) : '';
		$getresponse = ( ! empty( get_user_meta( $user->ID, 'getResponse_data', true ) ) ) ? get_user_meta( $user->ID, 'getResponse_data', true ) : '';

		?>
	<hr />
		<div class="header-container"><h3 class="h3 header-text"><?php esc_html_e( 'Apera Affiliate and Contact Info', 'aperabags' ); ?></h3></div>
		<table class="form-table">
			<tbody>
					<?php
					if ( ! empty( $refersion_error ) ) :
						?>
					<tr>
						<th>
							<label for="affiliate-error">Refersion Error</label>
						</th>
						<td>
							<p id="affiliate-error"><?php echo wp_kses_post( $refersion_error ); ?></p>
						</td>
					</tr>
					<?php endif; ?>
					<?php
					if ( ! empty( $refersion ) ) :
						?>
							<tr>
								<th>
									<label for="affiliate-id">Affiliate Code</label>
								</th>
								<td>
									<p id="affiliate-id"><?php echo wp_kses_post( $refersion->id ); ?></p>
								</td>
							</tr>
							<tr>
								<th>
									<label for="affiliate-link">Affiliate Link</label>
								</th>
								<td>
									<p id="affiliate-link"><?php echo wp_kses_post( $refersion->link ); ?></p>
								</td>
							</tr>
					<?php endif; ?>
					<?php
					if ( ! empty( $getresponse ) ) :
						?>
				<tr>
					<th>
						<label for="getresponse-data">GetResponse Data</label>
					</th>
						<?php
						foreach ( $getresponse as $value ) :
							echo "<td style='background: #333; color: #fff;'>";
							echo "<pre>\n";
							print_r( json_encode( $value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES ) );
							echo "</pre>\n";
							echo '</td>';
						endforeach;
						?>
				</tr>
					<?php endif; ?>
			</tbody>
		</table>
		<hr />
		<?php
		endif;
}
	add_action( 'show_user_profile', 'wonkasoft_api_responses_user_data', 1 );
	add_action( 'edit_user_profile', 'wonkasoft_api_responses_user_data', 1 );
