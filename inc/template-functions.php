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
	$count      = 0;
	if ( 'top' === $section ) :
		$mods_class->slides = new stdClass();
		for ( $i = 1; $i <= 5; $i++ ) {
			if ( ! empty( get_theme_mod( 'slider_' . $i ) ) ) :
				$count++;
				$slide                       = new stdClass();
				$slide->slide_img            = get_theme_mod( 'slider_' . $i );
				$slide->slide_text_position  = get_theme_mod( 'slider_text_position_' . $i );
				$slide->slide_header_message = get_theme_mod( 'slider_header_' . $i );
				$slide->slide_subheader      = get_theme_mod( 'slider_subheader_' . $i );
				$slide->slide_link_btn       = get_theme_mod( 'slider_btn_text_' . $i );
				$slide->slide_link           = get_theme_mod( 'slider_btn_link_' . $i );
				// Mobile theme mod.
				$slide->slide_mobile_img = get_theme_mod( 'slider_mobile_' . $i );

				$mods_class->slides->{"slide_{$i}"} = $slide;
			endif;
		}

		$mods_class->slides->count = $count;

		return $mods_class;
	endif;

	if ( 'shop' === $section ) :
		if ( ! empty( get_theme_mod( 'shop_title' ) ) ) :
			$count++;
			$shop                        = new stdClass();
			$shop->shop_title            = get_theme_mod( 'shop_title' );
			$shop->shop_background_image = get_theme_mod( 'shop_background_image' );
			$shop->enable_sale_banner    = get_theme_mod( 'enable_sale_banner' );
			$shop->shop_product_per_row  = get_theme_mod( 'shop_product_per_row' );
			$shop->shop_num_of_products  = get_theme_mod( 'shop_num_of_products' );

			$mods_class->{'shop_mods'}        = $shop;
			$mods_class->{'shop_mods'}->count = $count;
		endif;

		return $mods_class;
	endif;

	if ( 'cta' === $section ) :
		$mods_class->slides = new stdClass();
		for ( $i = 1; $i <= 5; $i++ ) {
			if ( ! empty( get_theme_mod( 'cta_slider_' . $i ) ) ) :
				$count++;
				$slide                      = new stdClass();
				$slide->slide_img           = get_theme_mod( 'cta_slider_' . $i );
				$slide->slide_text_position = get_theme_mod( 'cta_slider_text_position_' . $i );
				$slide->slide_text_message  = get_theme_mod( 'cta_slider_text_' . $i );
				$slide->slide_link_btn      = get_theme_mod( 'cta_slider_btn_text_' . $i );
				$slide->slide_link          = get_theme_mod( 'cta_slider_btn_link_' . $i );
				// Mobile Theme mod.
				$slide->slide_mobile_img = get_theme_mod( 'cta_slider_mobile_' . $i );

				$mods_class->slides->{"slide_{$i}"} = $slide;
			endif;
		}

		$mods_class->slides->count = $count;

		return $mods_class;
	endif;

	if ( 'cause' === $section ) :
		if ( ! empty( get_theme_mod( 'cause_section_title' ) ) ) :
			$count++;
			$cause                           = new stdClass();
			$cause->cause_section_title      = get_theme_mod( 'cause_section_title' );
			$cause->cause_section_background = get_theme_mod( 'cause_section_background' );

			$mods_class->{'cause_mods'}        = $cause;
			$mods_class->{'cause_mods'}->count = $count;
		endif;

		$count              = 0;
		$mods_class->causes = new stdClass();
		for ( $i = 1; $i <= 3; $i++ ) {
			if ( ! empty( get_theme_mod( 'cause_image_' . $i ) ) ) :
				$count++;
				${"cause_$i"}              = new stdClass();
				${"cause_$i"}->img         = get_theme_mod( 'cause_image_' . $i );
				${"cause_$i"}->img_link    = get_theme_mod( 'cause_image_link_' . $i );
				${"cause_$i"}->img_src     = wp_get_attachment_image_src( get_theme_mod( 'cause_image_' . $i ), 'custom_products_size', false );
				${"cause_$i"}->img_srcset  = wp_get_attachment_image_srcset( get_theme_mod( 'cause_image_' . $i ), 'custom_products_size', null );
				${"cause_$i"}->position    = get_theme_mod( 'cause_message_position_' . $i );
				${"cause_$i"}->header      = get_theme_mod( 'cause_header_' . $i );
				${"cause_$i"}->header_link = get_theme_mod( 'cause' . $i . '_header_link' );
				${"cause_$i"}->message     = get_theme_mod( 'cause_message_' . $i );

				$mods_class->causes->{"cause_$i"} = ${"cause_$i"};
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
			$about->about_the_brand_second_image_src    = wp_get_attachment_image_src( get_theme_mod( 'about_the_brand_second_image' ), 'custom_products_size', false );
			$about->about_the_brand_second_image_srcset = wp_get_attachment_image_srcset( get_theme_mod( 'about_the_brand_second_image' ), 'custom_products_size', null );
			$about->about_the_brand_image_link          = get_permalink( get_theme_mod( 'about_the_brand_second_image_link', '#' ) );
			$about->about_videoplaceholder_src          = wp_get_attachment_image_src( get_theme_mod( 'about_the_brand_video_placeholder' ), 'custom_products_size', false );
			$about->about_videoplaceholder_srcset       = wp_get_attachment_image_srcset( get_theme_mod( 'about_the_brand_video_placeholder' ), 'custom_products_size', null );

			$mods_class->{'about_the_brand'}        = $about;
			$mods_class->{'about_the_brand'}->count = $count;
		endif;

		return $mods_class;
	endif;

	if ( 'perks' === $section ) :
		if ( ! empty( get_theme_mod( 'perks_checkbox' ) ) ) :
			$count++;
			$perks                     = new stdClass();
			$perks->perks_checkbox     = get_theme_mod( 'perks_checkbox' );
			$perks->perks_message      = get_theme_mod( 'perks_section_message' );
			$perks->perks_image_src    = wp_get_attachment_image_src( get_theme_mod( 'perks_section_image' ), 'custom_products_size', false );
			$perks->perks_image_srcset = wp_get_attachment_image_srcset( get_theme_mod( 'perks_section_image' ), 'custom_products_size', null );

			$mods_class->{'apera_perks'}        = $perks;
			$mods_class->{'apera_perks'}->count = $count;
		endif;

		return $mods_class;
	endif;

	if ( 'social' === $section ) :
		if ( ! empty( get_theme_mod( 'social_section_title' ) ) ) :
			$count++;
			$social                     = new stdClass();
			$social->social_title       = get_theme_mod( 'social_section_title' );
			$social->social_message     = get_theme_mod( 'social_section_message' );
			$social->social_shortcode   = get_theme_mod( 'social_shortcode' );
			$social->social_btn_text    = get_theme_mod( 'social_btn_text' );
			$social->social_shop_button = get_permalink( get_theme_mod( 'social_shop_button' ) );

			$mods_class->{'social_mods'} = $social;
		endif;

		$mods_class->count = $count;

		return $mods_class;
	endif;

	if ( 'footer' === $section ) :
		if ( ! empty( get_theme_mod( 'footer_social_instagram' ) ) ) :
			$count++;
			$footer                               = new stdClass();
			$footer->footer_social_title          = get_theme_mod( 'footer_social_title' );
			$footer->footer_social_instagram      = get_theme_mod( 'footer_social_instagram' );
			$footer->footer_social_twitter        = get_theme_mod( 'footer_social_twitter' );
			$footer->footer_social_facebook       = get_theme_mod( 'footer_social_facebook' );
			$footer->footer_social_pinterest      = get_theme_mod( 'footer_social_pinterest' );
			$footer->footer_contact_message       = get_theme_mod( 'footer_contact_message' );
			$footer->footer_contact_support_email = get_theme_mod( 'footer_contact_support_email' );

			$footer->footer_insta_username      = get_theme_mod( 'footer_insta_username' );
			$footer->footer_insta_username_link = get_theme_mod( 'footer_insta_username_link' );
			$footer->footer_insta_hashtag       = get_theme_mod( 'footer_insta_hashtags' );
			$footer->footer_insta_hashtag_link  = get_theme_mod( 'footer_insta_hashtags_link' );

			$footer->footer_logo           = get_theme_mod( 'footer_logo' );
			$footer->footer_form_shortcode = get_theme_mod( 'footer_form_shortcode' );

			$mods_class->{'footer_mods'}        = $footer;
			$mods_class->{'footer_mods'}->count = $count;
		endif;

		$count                     = 0;
		$mods_class->footer_titles = new stdClass();
		for ( $i = 1; $i <= 5; $i++ ) {
			if ( ! empty( get_theme_mod( 'footer_menu_header_' . $i ) ) ) :
				$count++;
				$mods_class->footer_titles->{"footer_title_$i"} = get_theme_mod( 'footer_menu_header_' . $i );
			endif;
		}

		$mods_class->footer_titles->count = $count;

		return $mods_class;
	endif;

	if ( 'newsletter' === $section ) :
		if ( ! empty( get_theme_mod( 'enable_newsletter_popup' ) ) ) :
			$count++;
			$newsletter                    = new stdClass();
			$newsletter->enable_popup      = get_theme_mod( 'enable_newsletter_popup' );
			$newsletter->message_text      = get_theme_mod( 'newsletter_popup_message_text' );
			$newsletter->background_image  = get_theme_mod( 'newsletter_background_image' );
			$newsletter->background_color  = ( ! empty( get_theme_mod( 'newsletter_background_color' ) ) ) ? get_theme_mod( 'newsletter_background_color' ) : '#ffffff';
			$newsletter->popup_form_select = get_theme_mod( 'newsletter_popup_form_select' );
			$newsletter->session_length    = ( ! empty( get_theme_mod( 'newsletter_popup_message_session_length' ) ) ) ? get_theme_mod( 'newsletter_popup_message_session_length' ) : 24;
			$newsletter->time_to_pop       = ( ! empty( get_theme_mod( 'newsletter_popup_time_to_pop' ) ) ) ? get_theme_mod( 'newsletter_popup_time_to_pop' ) : 20;

			$mods_class->{'newsletter_mods'} = $newsletter;
		endif;

		$mods_class->count = $count;

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

	if ( in_array( $form['title'], array( 'ZIP Program' ) ) ) :
		$form['cssClass'] .= ' inline-form wonka-zip-form';
	endif;

	if ( in_array( $form['title'], array( 'Ambassador Program' ) ) ) :
		$form['cssClass'] .= ' inline-form wonka-ambassador-form';
	endif;

	if ( in_array( $form['title'], array( 'Apera Perks Registration' ) ) ) :
		$form['cssClass'] .= ' inline-form wonka-perks-form';
	endif;

	if ( in_array( $form['title'], array( 'Add Discount Code' ) ) ) :
		$form['cssClass'] .= ' inline-form wonka-discount-form';
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
		endif;
	endforeach;

	return $form;
}
add_filter( 'gform_pre_render', 'add_bootstrap_container_class', 10, 6 );

add_filter( 'gform_enable_password_field', '__return_true' );

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

			$slit_content = preg_split( '/([<])/', $field_content, null, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE );
			foreach ( $slit_content as $key => $value ) {
				if ( strpos( $value, 'input name' ) !== false ) :
					$new_content .= 'div class="input-group"><div class="input-group-prepend"> <span class="input-group-text">@</span> </div><' . $value . '</div>';

				else :
					$new_content .= $value;
				endif;
			}

			return $new_content;

		endif;

	endif;

	if ( 'fileupload' === $field['type'] ) :

		$slit_content = preg_split( '/([<])/', $field_content, null, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE );
		$element      = '';
		foreach ( $slit_content as $key => $value ) {
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

	if ( ! empty( $registered_options ) ) {

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
											'id'          => $register_option['id'],
											'label'       => $register_option['label'],
											'value'       => $current_option,
											'desc_tip'    => true,
											'description' => $register_option['description'],
											'wrapper_class' => 'form-row form-row-full form-group',
											'class'       => 'form-control',
											'api'         => $register_option['api'],
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
	$styles_set             = ( ! empty( $field['style'] ) ) ? ' style="' . esc_attr( $field['style'] ) . '" ' : '';

	// Custom attribute handling.
	$custom_attributes = array();
	$output            = '';

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
			'label'  => array(
				'for' => array(),
			),
			'input'  => array(
				'class'       => array(),
				'name'        => array(),
				'id'          => array(),
				'type'        => array(),
				'value'       => array(),
				'placeholder' => array(),
			),
			'span'   => array(
				'class' => array(),
			),
			'div'    => array(
				'class' => array(),
			),
			'button' => array(
				'class' => array(),
				'type'  => array(),
				'id'    => array(),
			),
			'i'      => array(
				'class' => array(),
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
			'label'       => 'Author Display Off',
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
	$output  = '';

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
 * For the theme popup cookie.
 */
function wonkasoft_theme_popup_cookie() {
	if ( ! empty( get_theme_mod( 'enable_newsletter_popup' ) ) ) :
		$wonkasoft_popup_cookie = array(
			'user_id'       => get_current_user_id(),
			'show'          => true,
			'time_of_visit' => time(),
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
	);

	update_option( 'registration_passing_args', null );

	// Check to see if form should be processed here.
	if ( ! in_array( $form['title'], $set_forms ) ) :
		return;
	endif;

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

	// Get current user object.
	$current_user = wp_get_current_user();

	// Get current user ID.
	$user_id = $current_user->ID;

	$entry_fields                  = array();
	$entry_fields['custom_fields'] = array();
	$set_labels                    = array(
		'First',
		'Last',
		'Company',
		'Logo Upload',
		'Email',
		'Password',
		'Street Address',
		'Address Line 2',
		'City',
		'State / Province',
		'ZIP / Postal Code',
		'Phone',
	);
	$custom_fields                 = array();

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

	if ( 'Media Upload' === $form['title'] ) :

		if ( ! empty( $entry_fields['logo_upload'] ) ) :

			wonkasoft_add_club_gym_logo( $entry_fields['logo_upload'], $user_id );

			header( 'Refresh:0' );

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
			$user_id = $user->data->ID;
			$user    = new WP_User( $user_id );
			if ( ! in_array( $role, $user->roles ) ) :
				$user->add_role( $role, $role_display );
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

						echo $refersion_response->status;

						return;

			endif;

		} else {

			$user_id = wonkasoft_make_user_account( $entry_fields, $role );

			$user = new WP_User( $user_id );

			if ( ! in_array( $role, $user->roles ) ) :
				$user->add_role( $role, $role_display );
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

						echo $refersion_response->status;

						return;

			endif;

		}

		else :

			$refersion_api_init = new Wonkasoft_Refersion_Api( $entry_fields );

			$refersion_response = $refersion_api_init->add_new_affiliate();

			if ( email_exists( $entry_fields['email'] ) ) {
				$user    = get_user_by( 'email', $entry_fields['email'] );
				$user_id = $user->data->ID;
				$user    = new WP_User( $user_id );
			} else {
				$user_id = wonkasoft_make_user_account( $entry_fields, $role );
				$user    = new WP_User( $user_id );
			}

			if ( ! in_array( $role, $user->roles ) ) :
				$user->add_role( $role, $role_display );
			endif;

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

						echo $refersion_response->status;

						return;

			endif;

	endif;

}
add_action( 'gform_after_submission', 'wonkasoft_after_form_submission', 10, 2 );

/**
 * This function creates new user accounts.
 *
 * @param  array  $entry_fields contains the form fields.
 * @param  string $role         the role set to give new user.
 * @return number               returns the new user id.
 */
function wonkasoft_make_user_account( $entry_fields, $role ) {

	// Setting time stamp.
	$ts   = time();
	$date = new DateTime( "@$ts" );
	$date->setTimezone( new DateTimeZone( get_option( 'timezone_string' ) ) );

	// Setting new user args.
	$userdata = array(
		'user_pass'            => $entry_fields['password'],   // (string) The plain-text user password.
		'user_login'           => $entry_fields['email'],   // (string) The user's login username.
		'user_nicename'        => $entry_fields['first'],   // (string) The URL-friendly user name.
		'user_email'           => $entry_fields['email'],   // (string) The user email address.
		'display_name'         => $entry_fields['first'] . ' ' . $entry_fields['last'],   // (string) The user's display name. Default is the user's username.
		'first_name'           => $entry_fields['first'],   // (string) The user's first name. For new users, will be used to build the first part of the user's display name if $display_name is not specified.
		'last_name'            => $entry_fields['last'],   // (string) The user's last name. For new users, will be used to build the second part of the user's display name if $display_name is not specified.
		'use_ssl'              => true,   // (bool) Whether the user should always access the admin over https. Default false.
		'user_registered'      => $date->format( 'Y-m-d H:i:s' ),   // (string) Date the user registered. Format is 'Y-m-d H:i:s'.
		'show_admin_bar_front' => false,   // (string|bool) Whether to display the Admin Bar for the user on the site's front end. Default true.
		'role'                 => $role,   // (string) User's role.
	);

	// Inserting new user and getting user id.
	$user_id = wp_insert_user( $userdata );

	return $user_id;

}

/**
 * Function is called if refersion successfully created affiliate.
 *
 * @param  string $user_id          current user ID.
 * @param  array  $entry_fields          entry form fields.
 * @param  object $refersion_api_init refersion api init.
 * @param  object $refersion_response    refersion affiliate created response.
 * @param  array  $api_args          api args for getresponse.
 */
function wonkasoft_refersion_affiliate_created_successfully( $user_id, $entry_fields, $refersion_api_init, $refersion_response, $api_args ) {

	// Setting affiliate code and link to send to getResponse.
	$api_args['custom_fields']        = array(
		'affiliate_code',
		'affiliate_link',
	);
	$api_args['custom_fields_values'] = array(
		'affiliate_code' => ( ! empty( $refersion_response->id ) ) ? $refersion_response->id : '',
		'affiliate_link' => ( ! empty( $refersion_response->link ) ) ? $refersion_response->link : '',
	);
	// Send to getResponse.
	$getresponse = get_response_api_call( $api_args );

	update_user_meta( $user_id, 'refersion_data', $refersion_response );
	update_user_meta( $user_id, 'getResponse_data', $getresponse );
	if ( ! empty( $entry_fields['logo_upload'] ) ) :

		wonkasoft_add_club_gym_logo( $entry_fields['logo_upload'], $user_id, $entry_fields['company'] );

	endif;

}

/**
 * Function is called if refersion new affiliate successful and affiliate code is empty.
 *
 * @param  string $user_id          current user ID.
 * @param  array  $entry_fields          entry form fields.
 * @param  object $refersion_api_init refersion api init.
 * @param  object $refersion_response    refersion affiliate created response.
 * @param  array  $api_args          api args for getresponse.
 */
function wonkasoft_affiliate_code_empty( $user_id, $entry_fields, $refersion_api_init, $refersion_response, $api_args ) {

	$refersion_response = $refersion_api_init->get_affiliate();

	// Setting affiliate code and link to send to getResponse.
	$api_args['custom_fields']        = array(
		'affiliate_code',
		'affiliate_link',
	);
	$api_args['custom_fields_values'] = array(
		'affiliate_code' => ( ! empty( $refersion_response->id ) ) ? $refersion_response->id : '',
		'affiliate_link' => ( ! empty( $refersion_response->link ) ) ? $refersion_response->link : '',
	);

	// Send to getResponse.
	$getresponse = get_response_api_call( $api_args );

	update_user_meta( $user_id, 'refersion_data', $refersion_response );
	update_user_meta( $user_id, 'getResponse_data', $getresponse );
	if ( ! empty( $entry_fields['logo_upload'] ) ) :

		wonkasoft_add_club_gym_logo( $entry_fields['logo_upload'], $user_id, $entry_fields['company'] );

	endif;

}

/**
 * Function is called if refersion new affiliate successful and affiliate code is not empty.
 *
 * @param  string $user_id          current user ID.
 * @param  array  $entry_fields          entry form fields.
 * @param  object $refersion_api_init refersion api init.
 * @param  object $refersion_response    refersion affiliate created response.
 * @param  array  $api_args          api args for getresponse.
 */
function wonkasoft_new_affiliate_errors( $user_id, $entry_fields, $refersion_api_init, $refersion_response, $api_args ) {

	// Setting affiliate code and link to send to getResponse.
	$api_args['custom_fields']        = array(
		'affiliate_error_code',
	);
	$api_args['custom_fields_values'] = array(
		'affiliate_error_code' => ( ! empty( $refersion_response->errors ) ) ? $refersion_response->errors[0] : '',
	);
	// Send to getResponse.
	$getresponse = get_response_api_call( $api_args );

	update_user_meta( $user_id, 'refersion_error', $refersion_response->errors );
	update_user_meta( $user_id, 'getResponse_data', $getresponse );
	if ( ! empty( $entry_fields['logo_upload'] ) ) :

		wonkasoft_add_club_gym_logo( $entry_fields['logo_upload'], $user_id, $entry_fields['company'] );

	endif;

}

/**
 * This adds a company logo.
 */
function wonkasoft_add_club_gym_logo( $url, $user_id, $company_name = null ) {

	$current_logo = ( ! empty( get_user_meta( $user_id, 'company_logo', true ) ) ) ? get_user_meta( $user_id, 'company_logo', true ) : null;

	if ( ! empty( $current_logo ) ) {

		$current_logo = json_decode( $current_logo );

	}

	$image = array();
	require_once ABSPATH . 'wp-admin/includes/image.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';

	$attachment_id = media_sideload_image( $url, $user_id, ' ' . $user_id, 'id' );

	if ( is_wp_error( $attachment_id ) ) {

		$error = $attachment_id->get_error_messages();

		update_user_meta( $user_id, 'company_logo', $error );

	} else {

		$image['id']  = $attachment_id;
		$image['url'] = wp_get_attachment_url( $attachment_id );
		if ( ! empty( $company_name ) ) {
			$image['company_name'] = $company_name;
		} elseif ( ! empty( $current_logo->company_name ) ) {
			$image['company_name'] = $current_logo->company_name;
		}

		$image = json_encode( $image );

		if ( ! empty( $current_logo ) ) {

			wp_delete_post( $current_logo->id, true );

		}

		update_user_meta( $user_id, 'company_logo', $image );

	}
}

/**
 * This adds the my account menu link for the logo.
 *
 * @param  array $menu_links contains the current my account links.
 * @return [type]             [description]
 */
function wonkasoft_my_account_club_gym_logo( $menu_links ) {

	$user = wp_get_current_user();

	if ( in_array( 'apera_zip_affiliate', $user->roles ) ) :

		$menu_links = array_slice( $menu_links, 0, 5, true )
		+ array( 'club-gym-logo' => 'Club/Gym Logo' )
		+ array_slice( $menu_links, 5, null, true );

	endif;

	return $menu_links;

}
add_filter( 'woocommerce_account_menu_items', 'wonkasoft_my_account_club_gym_logo', 50 );

/**
 * This is for the adding of the endpoint for my account page logo link.
 */
function wonkasoft_add_endpoint_my_account() {

	add_rewrite_endpoint( 'club-gym-logo', EP_PAGES );

}
add_action( 'init', 'wonkasoft_add_endpoint_my_account' );

/**
 * This is the content that is parsed at the logo end point.
 */
function wonkasoft_my_account_logo_link_endpoint_content() {

	$user         = wp_get_current_user();
	$user_id      = $user->ID;
	$company_logo = ( ! empty( get_user_meta( $user_id, 'company_logo', true ) ) ) ? get_user_meta( $user_id, 'company_logo', true ) : null;

	$output = '';
	if ( ! empty( $company_logo ) ) {
		$company_logo = json_decode( $company_logo );
	}

	if ( in_array( 'apera_zip_affiliate', $user->roles ) ) {

		$output .= '<div class="my-account-logo-content-wrap">';
		$output .= '<h2>Club/Gym Logo</h2>';

		if ( ! empty( $company_logo->company_name ) ) {
			$output .= '<span>' . $company_logo->coupon_code . '</span>';
		} else {
			$output .= '<span>need a coupon code</span>';
		}

		if ( ! empty( $company_logo->url ) ) {

			$output .= '<div class="current-logo-wrap">';
			$output .= '<img src="' . wp_get_attachment_image_src( $company_logo->id, 'thumbnail', false ) . '" srcset="' . wp_get_attachment_image_srcset( $company_logo->id, 'thumbnail', null ) . '" class="current-logo" />';
			$output .= '</div>';
			$output .= '<p>To update/change your logo, simply upload a new one below.</p>';
			$output .= '<div class="form-wrap">';
			$output .= '<div class="form-container">';
			$output .= gravity_form( 'Media Upload', false, false, false, null, true, 0, false );
			$output .= '</div>';
			$output .= '</div>';

		} else {

			$output .= '<div class="current-logo-wrap">';
			$output .= '<div class="no-logo">You have no logo on file.</div>';
			$output .= '</div>';
			$output .= '<p>To update/change your logo, simply upload a new one below.</p>';
			$output .= '<div class="form-wrap">';
			$output .= '<div class="form-container">';
			$output .= gravity_form( 'Media Upload', false, false, false, null, true, 0, false );
			$output .= '</div>';
			$output .= '</div>';

		}

		$output .= '</div>';

		echo $output;

	}

}
add_action( 'woocommerce_account_club-gym-logo_endpoint', 'wonkasoft_my_account_logo_link_endpoint_content' );


function wonkasoft_parse_account_logo() {

	$user         = wp_get_current_user();
	$user_id      = $user->ID;
	$company_logo = ( ! empty( get_user_meta( $user_id, 'company_logo', true ) ) ) ? get_user_meta( $user_id, 'company_logo', true ) : null;

	$output = '';

	if ( ! empty( $company_logo ) ) {
		$company_logo = json_decode( $company_logo );
	}

	if ( in_array( 'apera_zip_affiliate', $user->roles ) ) {

		if ( ! empty( $company_logo->url ) ) {

			$output .= '<img src="' . esc_attr( wp_get_attachment_image_src( $company_logo->id, 'thumbnail', false ) ) . '" srcset="' . esc_attr( wp_get_attachment_image_srcset( $company_logo->id, 'thumbnail', null ) ) . '" data-attachment-id="' . $company_logo->id . '" class="current-logo" />';

		} else {

			$output .= '<div class="no-logo">You have no logo on file. If you just tried to update your logo there must have been a problem with the upload. Try again or contact us for further help.</div>';

		}

		wp_send_json_success( $output );

	}
}
add_action( 'wp_ajax_wonkasoft_parse_account_logo', 'wonkasoft_parse_account_logo' );
add_action( 'wp_ajax_nopriv_wonkasoft_parse_account_logo', 'wonkasoft_parse_account_logo' );

/**
 * This will check for coupons and create one if needed.
 *
 * @param  array  $entry_fields contains the entry fields from submitted form.
 * @param  string $form_title   contains the form title.
 * @return  string returns null or a string that is the created coupon code.
 */
function wonkasoft_coupon_creation( $entry_fields, $form_title ) {

	$coupon_code = null;

	$args = array(
		'post_type'      => 'shop_coupon',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
	);

	$coupons    = new WP_Query( $args );
	$found_code = false;
	$percentage = $entry_fields['percentage'];

	foreach ( $coupons->posts as $coupon ) :
		if ( $entry_fields['discount_code'] === $coupon->post_name ) :
			$found_code = true;
		endif;
	endforeach;

	if ( 'Add Discount Code' === $form_title && ! $found_code ) :

		/**
		 * Create a coupon programatically
		 */
		$coupon_code = $entry_fields['discount_code']; // Code.

		$discount_type = 'percent'; // Type: fixed_cart, percent, fixed_product, percent_product.

		$coupon = array(
			'post_title'   => $coupon_code,
			'post_content' => '',
			'post_status'  => 'publish',
			'post_author'  => 1,
			'post_type'    => 'shop_coupon',
			'post_excerpt' => 'This coupon gives ' . $percentage . '% off',
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

		return $coupon_code;

	endif;

	return false;

}

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

	$affiliate_apera_id = get_user_by( 'email', $entry_fields['email'] )->data->ID;

	$refersion_data = wonkasoft_get_refersion_data( $affiliate_apera_id );

	$coupon_code = wonkasoft_coupon_creation( $entry_fields, $form['title'] );

	if ( false !== $coupon_code ) {

		$entry_fields['affiliate_code'] = $refersion_data->id;
		$entry_fields['type']           = 'COUPON';
		$entry_fields['trigger']        = $entry_fields['discount_code'];

		$refersion_init          = new Wonkasoft_Refersion_Api( $entry_fields );
		$refersion_added_trigger = $refersion_init->create_conversion_trigger();

		$refersion_data->trigger_id = $refersion_added_trigger->trigger_id;
		$refersion_data->trigger    = $refersion_added_trigger->trigger;

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

		update_user_meta( $user_id, 'refersion_data', $refersion_data );
		update_user_meta( $user_id, 'getResponse_data', $getresponse );
	}

}
add_action( 'gform_after_submission', 'wonkasoft_after_code_entry', 10, 2 );

/**
 * This handles the submission of the perks registration form.
 *
 * @param  array $entry contains the entry fields.
 * @param  array $form  contains the form array.
 */
function wonkasoft_after_perks_registration_entry( $entry, $form ) {

	if ( 'Apera Perks Registration' !== $form['title'] ) {
		return;
	}

	$entry_fields                  = array();
	$entry_fields['custom_fields'] = array();
	$set_labels                    = array(
		'First Name',
		'Last Name',
		'Email',
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
							'label' => esc_html( $current_label ),
							'value' => esc_html( $entry[ $field['id'] ] ),
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

	echo "<pre>\n";
	print_r( $entry_fields );
	echo "</pre>\n";

}
add_action( 'gform_after_submission', 'wonkasoft_after_perks_registration_entry', 10, 2 );

/**
 * This function handles the api request to send data to getResponse.
 *
 * @param  array $api_args an array of args for the api call.
 * @return object           returns error or response from the api call.
 */
function get_response_api_call( $api_args ) {

	$response    = array();
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
			if ( in_array( $field->name, $getresponse->custom_fields ) ) :
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

	return $response;
}

/**
 * This function registers the custom api route.
 *
 * {site_url}/api/wonkasoft/v1/getresponse-api/
 */
function wonkasoft_register_custom_api() {
	register_rest_route(
		'wonkasoft/v1',
		'/getresponse-api/',
		array(
			'methods'  => 'GET',
			'callback' => 'wonkasoft_getresponse_endpoint',
		),
		false
	);
}
add_action( 'rest_api_init', 'wonkasoft_register_custom_api' );

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
 * This function handles the rest api endpoint for getResponse.
 *
 * @param  array $data contains params send in the url.
 * @return json    returns the response data.
 */
function wonkasoft_getresponse_endpoint( $data ) {

	if ( ! isset( $_GET['email'] ) && ! isset( $_GET['tag'] ) && ! isset( $_GET['campaign_name'] ) ) :
		return 'Invalid request, contact support for more information.';
	endif;

	$email         = wp_kses_post( wp_unslash( $_GET['email'] ) );
	$passed_tag    = wp_kses_post( wp_unslash( $_GET['tag'] ) );
	$campaign_name = wp_kses_post( wp_unslash( $_GET['campaign_name'] ) );

	$prep_data = array(
		'email'         => $email,
		'tags'          => array(
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
			'email'      => $email,
			'tag'        => $passed_tag,
			'contact_id' => $getresponse->contact_id,
		);

		$data_send = json_decode( json_encode( $data_send ) );
		$data_send = http_build_query( $data_send );
		$url       = 'https://aperabags.com/response-page/?' . $data_send;
		header( 'Content-Type: application/x-www-form-urlencoded' );
		header( 'Location: ' . $url );
	endif;

	return $getresponse;
}

/**
 * This function adds Affiliate and Contact data to user profile.
 *
 * @param  object $user contains an object of the user.
 */
function wonkasoft_api_responses_user_data( $user ) {
	if ( in_array( $role, $user->roles ) ) :
		$user_id         = $user->ID;
		$refersion       = ( ! empty( get_user_meta( $user_id, 'refersion_data', true ) ) ) ? get_user_meta( $user_id, 'refersion_data', true ) : '';
		$refersion_error = ( ! empty( get_user_meta( $user_id, 'refersion_error', true ) ) ) ? get_user_meta( $user_id, 'refersion_error', true ) : '';
		$getresponse     = ( ! empty( get_user_meta( $user_id, 'getResponse_data', true ) ) ) ? get_user_meta( $user_id, 'getResponse_data', true ) : '';
		$company_logo    = ( ! empty( get_user_meta( $user_id, 'company_logo', true ) ) ) ? get_user_meta( $user_id, 'company_logo', true ) : '';
		if ( ! empty( $company_logo ) ) {
			$company_logo = json_decode( $company_logo );
		}

		?>
	<hr />
		<div class="header-container"><h3 class="h3 header-text"><?php esc_html_e( 'Apera Affiliate and Contact Info', 'aperabags' ); ?></h3></div>
		<table class="form-table">
			<tbody>
					<?php
					if ( ! empty( $company_logo ) ) :
						?>
					<tr>
						<th>
							<label for="club-gym-logo">Club/Gym Logo</label>
						</th>
						<td>
							<img src="<?php echo esc_attr( wp_get_attachment_image_src( $company_logo->id, 'thumbnail', false ) ); ?>" srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( $company_logo->id, 'thumbnail', null ) ); ?>" id="club-gym-logo" class="company-logo" />
						</td>
					</tr>
					<?php endif; ?>
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

/**
 * This returns the refersion data that is set for the user.
 *
 * @param  string $user_id the users ID.
 * @return object          returns an object of the users refersion data.
 */
function wonkasoft_get_refersion_data( $user_id ) {

	$refersion = ( ! empty( get_user_meta( $user_id, 'refersion_data', true ) ) ) ? get_user_meta( $user_id, 'refersion_data', true ) : '';
	return $refersion;

}

