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
	$section_mods = array();
	if ( 'top_slider' === $section || 'all' === $section ) :
		$top_slider_count     = 0;
		$top_slider           = array();
		$top_slider['slides'] = array();
		for ( $i = 1; $i <= 5; $i++ ) {
			if ( ! empty( get_theme_mod( 'slider_' . $i ) ) ) :
				$top_slider_count++;
				$slide                              = array(
					'slide_img_id'         => get_theme_mod( 'slider_' . $i ),
					'slide_mobile_img_id'  => get_theme_mod( 'slider_mobile_' . $i ),
					'slide_text_position'  => get_theme_mod( 'slider_text_position_' . $i ),
					'slide_header_message' => get_theme_mod( 'slider_header_' . $i ),
					'slide_subheader'      => get_theme_mod( 'slider_subheader_' . $i ),
					'slide_link_btn'       => get_theme_mod( 'slider_btn_text_' . $i ),
					'slide_link'           => get_theme_mod( 'slider_btn_link_' . $i ),
				);
				$top_slider['slides'][ "slide_$i" ] = $slide;
			endif;
		}
		$top_slider['slides']['count'] = $top_slider_count;
		if ( 'top_slider' === $section ) {
			$section_mods['top_slider'] = $top_slider;
			return json_decode( json_encode( $section_mods ) );
		} else {
			$section_mods['top_slider'] = $top_slider;
		}
	endif;
	if ( 'discovery_section' === $section || 'all' === $section ) :
		$discovery_section = array();
		$discovery         = array(
			'image'    => ! empty( get_theme_mod( 'discovery_featured_image' ) ) ? get_theme_mod( 'discovery_featured_image' ) : null,
			'title'    => ! empty( get_theme_mod( 'discovery_title' ) ) ? get_theme_mod( 'discovery_title' ) : null,
			'body'     => ! empty( get_theme_mod( 'discovery_body' ) ) ? get_theme_mod( 'discovery_body' ) : null,
			'cta_text' => ! empty( get_theme_mod( 'discovery_cta_text' ) ) ? get_theme_mod( 'discovery_cta_text' ) : null,
			'cta_link' => ! empty( get_theme_mod( 'discovery_cta_link' ) ) ? get_permalink( get_theme_mod( 'discovery_cta_link' ) ) : null,
		);

		if ( 'discovery_section' === $section ) {
			$section_mods['discovery_section'] = $discovery;
			return json_decode( json_encode( $section_mods ) );
		} else {
			$section_mods['discovery_section'] = $discovery;
		}
	endif;
	if ( 'our_brand_section' === $section || 'all' === $section ) :
		$our_brand_section = array();
		$our_brand         = array(
			'image'    => ! empty( get_theme_mod( 'our_brand_featured_image' ) ) ? get_theme_mod( 'our_brand_featured_image' ) : null,
			'title'    => ! empty( get_theme_mod( 'our_brand_title' ) ) ? get_theme_mod( 'our_brand_title' ) : null,
			'body'     => ! empty( get_theme_mod( 'our_brand_body' ) ) ? get_theme_mod( 'our_brand_body' ) : null,
			'cta_text' => ! empty( get_theme_mod( 'our_brand_cta_text' ) ) ? get_theme_mod( 'our_brand_cta_text' ) : null,
			'cta_link' => ! empty( get_theme_mod( 'our_brand_cta_link' ) ) ? get_permalink( get_theme_mod( 'our_brand_cta_link' ) ) : null,
		);
		if ( 'our_brand_section' === $section ) {
			$section_mods['our_brand_section'] = $our_brand;
			return json_decode( json_encode( $section_mods ) );
		} else {
			$section_mods['our_brand_section'] = $our_brand;
		}
	endif;
	if ( 'footer_section' === $section ) :
		$footer_section       = array();
		$footer_section_count = 0;
		if ( ! empty( get_theme_mod( 'footer_social_instagram' ) ) ) :
			$footer_section_count++;
			$footer                                 = array(
				'footer_social_title'          => get_theme_mod( 'footer_social_title' ),
				'footer_social_instagram'      => get_theme_mod( 'footer_social_instagram' ),
				'footer_social_twitter'        => get_theme_mod( 'footer_social_twitter' ),
				'footer_social_facebook'       => get_theme_mod( 'footer_social_facebook' ),
				'footer_social_pinterest'      => get_theme_mod( 'footer_social_pinterest' ),
				'footer_contact_message'       => get_theme_mod( 'footer_contact_message' ),
				'footer_contact_support_email' => get_theme_mod( 'footer_contact_support_email' ),
				'footer_insta_username'        => get_theme_mod( 'footer_insta_username' ),
				'footer_insta_username_link'   => get_theme_mod( 'footer_insta_username_link' ),
				'footer_insta_hashtag'         => get_theme_mod( 'footer_insta_hashtags' ),
				'footer_insta_hashtag_link'    => get_theme_mod( 'footer_insta_hashtags_link' ),
				'footer_logo'                  => get_theme_mod( 'footer_logo' ),
				'footer_form_shortcode'        => get_theme_mod( 'footer_form_shortcode' ),
			);
			$footer_section['footer_mods']          = $footer;
			$footer_section['footer_mods']['count'] = $footer_section_count;
		endif;
		$footer_section_count2           = 0;
		$footer_section['footer_titles'] = array();
		for ( $i = 1; $i <= 5; $i++ ) {
			if ( ! empty( get_theme_mod( 'footer_menu_header_' . $i ) ) ) :
				$footer_section_count2++;
				$footer_section['footer_titles'][ "footer_title_$i" ] = get_theme_mod( 'footer_menu_header_' . $i );
			endif;
		}
		$footer_section['footer_titles']['count'] = $footer_section_count2;
		if ( 'footer_section' === $section ) {
			$section_mods['footer_section'] = $footer_section;
			return json_decode( json_encode( $section_mods ) );
		} else {
			$section_mods['footer_section'] = $footer_section;
		}
	endif;
	if ( 'newsletter_area' === $section ) :
		$newsletter_area       = array();
		$newsletter_area_count = 0;
		if ( ! empty( get_theme_mod( 'enable_newsletter_popup' ) ) ) :
			$newsletter_area_count++;
			$background_color                   = ( ! empty( get_theme_mod( 'newsletter_background_color' ) ) ) ? get_theme_mod( 'newsletter_background_color' ) : '#ffffff';
			$session_length                     = ( ! empty( get_theme_mod( 'newsletter_popup_message_session_length' ) ) ) ? get_theme_mod( 'newsletter_popup_message_session_length' ) : 24;
			$time_to_pop                        = ( ! empty( get_theme_mod( 'newsletter_popup_time_to_pop' ) ) ) ? get_theme_mod( 'newsletter_popup_time_to_pop' ) : 20;
			$newsletter                         = array(
				'enable_popup'      => get_theme_mod( 'enable_newsletter_popup' ),
				'message_text'      => get_theme_mod( 'newsletter_popup_message_text' ),
				'background_image'  => get_theme_mod( 'newsletter_background_image' ),
				'background_color'  => $background_color,
				'popup_form_select' => get_theme_mod( 'newsletter_popup_form_select' ),
				'session_length'    => $session_length,
				'time_to_pop'       => $time_to_pop,
			);
			$newsletter_area['newsletter_mods'] = $newsletter;
		endif;
		$newsletter_area['count'] = $newsletter_area_count;
		if ( 'newsletter_area' === $section ) {
			$section_mods['newsletter_area'] = $newsletter_area;
			return json_decode( json_encode( $section_mods ) );
		} else {
			$section_mods['newsletter_area'] = $newsletter_area;
		}
	endif;
	if ( 'all' === $section ) {
		return json_decode( json_encode( $section_mods ) );
	}
	return false;
}
add_action( 'get_mods_before_section', 'the_mods_for_section', 10, 1 );

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
function aperabags_theme_options_page() {
	?>
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
 * This function creates new user accounts.
 *
 * @param  array  $entry_fields contains the form fields.
 * @param  string $role         the role set to give new user.
 * @return integer               returns the new user id.
 */
function wonkasoft_make_user_account( $entry_fields, $role = 'apera_perks_partner' ) {
	// Setting time stamp.
	$ts   = time();
	$date = new DateTime( "@$ts" );
	$date->setTimezone( new DateTimeZone( get_option( 'timezone_string' ) ) );
	$user_pass = ( ! empty( $entry_fields['password'] ) ) ? $entry_fields['password'] : wp_generate_password( 19, true, false );
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

	if ( 'ambassador_program_signups' === $api_args['campaign_name'] ) {
		update_user_meta( $user_id, 'ambassador_affiliate_status', 'Pending' );
	}

	if ( 'zip_program_signups' === $api_args['campaign_name'] ) {
		update_user_meta( $user_id, 'zip_affiliate_status', 'Pending' );
	}

	update_user_meta( $user_id, 'refersion_data', $refersion_response );
	update_user_meta( $user_id, 'getResponse_data', $getresponse );

	if ( ! empty( $entry_fields['company'] ) ) :
		update_user_meta( $user_id, 'company_name', $entry_fields['company'] );
	endif;

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

	if ( 'ambassador_program_signups' === $api_args['campaign_name'] ) {
		update_user_meta( $user_id, 'ambassador_affiliate_status', 'Pending' );
	}

	if ( 'zip_program_signups' === $api_args['campaign_name'] ) {
		update_user_meta( $user_id, 'zip_affiliate_status', 'Pending' );
	}

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

	if ( 'ambassador_program_signups' === $api_args['campaign_name'] ) {
		update_user_meta( $user_id, 'ambassador_affiliate_status', 'Pending' );
	}

	if ( 'zip_program_signups' === $api_args['campaign_name'] ) {
		update_user_meta( $user_id, 'zip_affiliate_status', 'Pending' );
	}

	update_user_meta( $user_id, 'refersion_error', $refersion_response->errors );
	update_user_meta( $user_id, 'getResponse_data', $getresponse );
	if ( ! empty( $entry_fields['logo_upload'] ) ) :
		wonkasoft_add_club_gym_logo( $entry_fields['logo_upload'], $user_id, $entry_fields['company'] );
	endif;
}

/**
 * This adds a company logo.
 *
 * @param string  $url contains the logo url.
 * @param integer $user_id contains the user id.
 * @param string  $company_name contains the users company.
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
	$attachment_id = wonkasoft_media_sideload_image( $url, $user_id, ' ' . $user_id, 'id' );

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
 * A modified version of the core function
 *
 * @param  string  $file    contains file url.
 * @param  integer $post_id contains the parent post ID.
 * @param  string  $desc    contains passed description.
 * @param  string  $return  contains desired return of html, src, or id.
 * @return            returns error or desired return.
 */
function wonkasoft_media_sideload_image( $file, $post_id = 0, $desc = null, $return = 'html' ) {
	if ( ! empty( $file ) ) {

		// Set variables for storage, fix file filename for query strings.
		preg_match( '/[^\?]+\.(jpe?g|jpg|gif|png|svg|ai|eps)\b/i', $file, $matches );

		if ( ! $matches ) {
			return new WP_Error( 'image_sideload_failed', __( 'Invalid image URL' ) );
		}

		$file_array         = array();
		$file_array['name'] = wp_basename( $matches[0] );

		// Download file to temp location.
		$file_array['tmp_name'] = download_url( $file );

		// If error storing temporarily, return the error.
		if ( is_wp_error( $file_array['tmp_name'] ) ) {
			return $file_array['tmp_name'];
		}

		// Do the validation and storage stuff.
		$id = media_handle_sideload( $file_array, $post_id, $desc );

		// If error storing permanently, unlink.
		if ( is_wp_error( $id ) ) {
			@unlink( $file_array['tmp_name'] );
			return $id;
			// If attachment id was requested, return it early.
		} elseif ( 'id' === $return ) {
			return $id;
		}

		$src = wp_get_attachment_url( $id );
	}

	// Finally, check to make sure the file has been saved, then return the HTML.
	if ( ! empty( $src ) ) {
		if ( 'src' === $return ) {
			return $src;
		}

		$alt  = isset( $desc ) ? esc_attr( $desc ) : '';
		$html = "<img src='" . esc_url( wp_get_attachment_image_src( $id, 'thumbnail', false )[0] ) . "' srcset='" . esc_attr( wp_get_attachment_image_srcset( $id, 'thumbnail', null ) ) . "' alt='$alt' />";

		return $html;
	} else {
		return new WP_Error( 'image_sideload_failed' );
	}
}

/**
 * This will check for coupons and create one if needed.
 *
 * @param  array  $entry_fields contains the entry fields from submitted form.
 * @param  string $form_title   contains the form title.
 * @return  string returns null or a string that is the created coupon code.
 */
function wonkasoft_coupon_creation( $entry_fields, $form_title ) {
	$coupon_code = null;
	$args        = array(
		'post_type'      => 'shop_coupon',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
	);
	$coupons     = new WP_Query( $args );
	$found_code  = false;
	$percentage  = $entry_fields['percentage'];
	foreach ( $coupons->posts as $coupon ) :
		if ( $entry_fields['discount_code'] === $coupon->post_name ) :
			$found_code = true;
		endif;
	endforeach;
	if ( 'Add Discount Code' === $form_title && ! $found_code ) :
		/**
		 * Create a coupon programatically
		 */
		$coupon_code   = $entry_fields['discount_code']; // Code.
		$discount_type = 'percent'; // Type: fixed_cart, percent, fixed_product, percent_product.
		$coupon        = array(
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
	$prep_data     = array(
		'email'         => $email,
		'tags'          => array(
			$passed_tag,
		),
		'campaign_name' => $campaign_name,
	);

	if ( 'ambassador_program_signups' === $campaign_name || 'zip_program_signups' === $campaign_name || 'perks_mse_program_signups' === $campaign_name ) {
		$user    = get_user_by( 'email', $email );
		$user_id = $user->ID;

		if ( 'ambassador_program_signups' === $campaign_name ) {

			if ( 'approved' === $passed_tag ) {
				update_user_meta( $user_id, 'ambassador_affiliate_status', 'Approved', 'Pending' );
			}

			if ( 'denial' === $passed_tag ) {
				update_user_meta( $user_id, 'ambassador_affiliate_status', 'Denied', 'Pending' );
			}
		}

		if ( 'zip_program_signups' === $campaign_name ) {

			if ( 'zipapproved' === $passed_tag ) {
				update_user_meta( $user_id, 'zip_affiliate_status', 'Approved', 'Pending' );
			}

			if ( 'zipdenial' === $passed_tag ) {
				update_user_meta( $user_id, 'zip_affiliate_status', 'Denied', 'Pending' );
			}
		}

		if ( 'perks_mse_program_signups' === $campaign_name ) {
			$role         = 'apera_mse_partner';
			$role_display = 'Apera Mse Partner';

			$user = new WP_User( $user_id );
			if ( ! in_array( $role, $user->roles ) ) :
				$user->add_role( $role, $role_display );
			endif;
		}
	}

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
	if ( 'apera_195932' === $campaign_name && empty( $getresponse->contact_id ) ) {
		foreach ( $getresponse->contact_list as $contact ) :
			if ( $email === $contact->email ) :
				$getresponse->contact_id = $contact->contactId;
			endif;
		endforeach;
	}
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
		if ( 'apera_195932' === $campaign_name ) {
			$response = $getresponse->update_contact_details();
		} else {
			$response = $getresponse->upsert_the_tags_of_contact();
		}
		$data_send = array(
			'email'      => $email,
			'tag'        => $passed_tag,
			'contact_id' => $getresponse->contact_id,
		);
		$data_send = json_decode( json_encode( $data_send ) );
		$data_send = http_build_query( $data_send );
		if ( 'apera_195932' === $campaign_name ) {
			$url = 'https://aperabags.com/iff-thankyou/?' . $data_send;
		} else {
			$url = 'https://aperabags.com/response-page/?' . $data_send;
		}
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
	if ( in_array( 'apera_ambassador_affiliate', $user->roles ) || in_array( 'apera_zip_affiliate', $user->roles ) || in_array( 'apera_perks_partner', $user->roles ) ) :
		$user_id         = $user->ID;
		$refersion       = ( ! empty( get_user_meta( $user_id, 'refersion_data', true ) ) ) ? get_user_meta( $user_id, 'refersion_data', true ) : '';
		$refersion_error = ( ! empty( get_user_meta( $user_id, 'refersion_error', true ) ) ) ? get_user_meta( $user_id, 'refersion_error', true ) : '';
		$getresponse     = ( ! empty( get_user_meta( $user_id, 'getResponse_data', true ) ) ) ? get_user_meta( $user_id, 'getResponse_data', true ) : '';
		$company_logo    = ( ! empty( get_user_meta( $user_id, 'company_logo', true ) ) ) ? get_user_meta( $user_id, 'company_logo', true ) : '';
		$user_birthday   = ( ! empty( get_user_meta( $user_id, 'users_birthday', true ) ) ) ? get_user_meta( $user_id, 'users_birthday', true ) : '';

		if ( ! empty( $company_logo ) ) {
			$company_logo = json_decode( $company_logo );
		}
		?>
	<hr />
		<div class="header-container"><h3 class="h3 header-text"><?php esc_html_e( 'Apera Affiliate and Contact Info', 'aperabags' ); ?></h3>

		</div>

		<?php
		if ( ! empty( $user_birthday ) ) :
			?>
			<table class="form-table birthday-table">
				<tbody>
					<tr>
						<th>
							<label for="user-birthday">Your Birthday</label>
						</th>
						<td colspan="2">
							<span><?php echo esc_html( $user_birthday ); ?></span>
						</td>
					</tr>
				</tbody>
			</table>
		<?php endif; ?>
		<?php
		if ( ! empty( $company_logo ) ) :
			?>
			<table class="form-table logo-table">
				<tbody>
					<tr>
						<th>
							<label for="club-gym-logo">Club/Gym Logo</label>
						</th>
						<td colspan="2">
							<img image-id="<?php echo esc_attr( $company_logo->id ); ?>" src="<?php echo esc_url( $company_logo->url ); ?>" id="club-gym-logo" class="company-logo" />
						</td>
					</tr>
				</tbody>
			</table>
		<?php endif; ?>
		<?php
		if ( ! empty( $refersion_error ) || ! empty( $refersion ) ) :
			?>
			<table class="form-table refersion-table">
				<tbody>
			<?php
			if ( ! empty( $refersion_error ) ) :
				?>
					<tr>
						<th>
							<label for="affiliate-error">Refersion Error</label>
						</th>
						<td colspan="2">
							<p id="affiliate-error"><?php echo wp_kses_post( $refersion_error[0] ); ?></p>
						</td>
					</tr>
				<?php endif; ?>
			<?php
			if ( ! empty( $refersion ) && empty( $refersion_error ) ) :
				?>
					<tr>
						<th>
							<label for="affiliate-id">Affiliate Code</label>
						</th>
						<td colspan="2">
							<p id="affiliate-id"><?php echo wp_kses_post( $refersion->id ); ?></p>
						</td>
					</tr>
					<tr>
						<th>
							<label for="affiliate-link">Affiliate Link</label>
						</th>
						<td colspan="2">
							<p id="affiliate-link"><?php echo wp_kses_post( $refersion->link ); ?></p>
						</td>
					</tr>
			<?php endif; ?>
				</tbody>
			</table>
		<?php endif; ?>
		<?php
		if ( ! empty( $getresponse ) ) :
			?>
			<table class="form-table getresponse-table">
				<tbody>
				<tr>
					<th colspan="2">
						<label for="getresponse-data">GetResponse Data</label>
					</th>
				</tr>
				<tr>
					<th style="text-align: center;" colspan="2">
						<label>Custom Fields</label>
					</th>
				</tr>
				<tr>
					<th><label>Field ID</label></th>
					<th><label>Value</label></th>
				</tr>
			<?php
			foreach ( $getresponse[0]->customFieldValues as $field ) :
				?>
				<tr>
					<td>
						<span><?php print_r( $field->customFieldId ); ?></span>
					</td>
					<td>
					<?php
					foreach ( $field->values as $value ) :
						?>
						<span><?php print_r( $value ); ?></span>
						<?php
						endforeach;
					?>
					</td>
				</tr>
				<?php
		endforeach;
			?>
				<tr>
					<th style="text-align: center;" colspan="2"><label>Tags</label></th>
				</tr>
				<tr>
					<th><label>Tag ID</label></th>
					<th><label>Tag Name</label></th>
				</tr>
			<?php
			foreach ( $getresponse[1]->tags as $tag ) :
				?>
				<tr>
					<td>
						<span><?php print_r( $tag->tagId ); ?></span>
					</td>
					<td>
						<span><?php print_r( $tag->name ); ?></span>
					</td>
				</tr>
				<?php
		endforeach;
			?>
		<?php endif; ?>
			</tbody>
		</table>
		<hr />
		<?php
		endif;
}
add_action( 'show_user_profile', 'wonkasoft_api_responses_user_data', 2 );
add_action( 'edit_user_profile', 'wonkasoft_api_responses_user_data', 2 );
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

/**
 * Allowing tags in the editor.
 *
 * @param  [type] $mceInit [description]
 * @return [type]            [description]
 */
function override_mce_options( $mceInit ) {
	$opts                               = '*[*]';
	$mceInit['valid_elements']          = $opts;
	$mceInit['extended_valid_elements'] = $opts;
	return $mceInit;
}
add_filter( 'tiny_mce_before_init', 'override_mce_options' );


/**
 * This is replacing the re-order btns on the site.
 *
 * @param  object $order contains the current order.
 */
function wonkasoft_btn_fix_for_re_order( $actions, $order ) {
	$status = $order->status;
	unset( $actions['view'] );
	if ( 'completed' !== $status ) {
		$wp_nonce_url      = wp_nonce_url(
			add_query_arg(
				array(
					'cancel_order' => 'true',
					'order'        => $order->get_order_key(),
					'order_id'     => $order->get_id(),
					'redirect'     => $redirect,
				),
				$order->get_cancel_endpoint()
			),
			'woocommerce-cancel_order'
		);
		$actions['cancel'] = array(
			'url'  => $wp_nonce_url,
			'name' => 'Cancel',
		);
	}
	return $actions;
}
add_filter( 'woocommerce_my_account_my_orders_actions', 'wonkasoft_btn_fix_for_re_order', 10, 2 );
/**
 * This function is an override of Sumo for my account page.
 *
 * @param  integer $order_id     contains current orders ID.
 * @param  array   $order_obj    contains current order.
 * @param  string  $order_status contains current orders status.
 * @param  string  $first_name   contains current users first name.
 * @param  integer $i           contains line integer.
 * @param  integer $points      contains points for current user.
 * @param  array   $order_list   contains the list of orders for user.
 */
function wonkasoft_order_status_settings( $order_id, $order_obj, $order_status, $first_name, $i, $points, $order_list ) {
	$my_acc_link           = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
	$order_link            = esc_url_raw( add_query_arg( 'view-order', $order_id, $my_acc_link ) );
	$order_link            = '<a href="' . $order_link . '">#' . $order_id . '</a>';
	$order_status_to_reach = ucfirst( implode( ',', $order_list ) );
	$message               = __( 'Currently, the order status is in [status]. Once the order status reached to the [order_status_to_reach], [points] points for purchasing the product(s) in this order([order_id]) will be added to your account', 'aperabags' );
	$replace_msg           = str_replace( '[points]', $points, str_replace( '[order_id]', $order_link, str_replace( '[status]', ucfirst( $order_status ), $message ) ) );
	$replace_msg           = str_replace( '[order_status_to_reach]', $order_status_to_reach, $replace_msg );
	$date                  = ( ! empty( $order ) ) ? esc_html( $order->get_date_created()->date( 'm/d/Y' ) ) : '-';
	?>
	<tr>
		<td data-value="<?php echo esc_attr( $i ); ?>"><?php echo esc_html( $date ); ?></td>  
		<td><?php echo esc_html( $first_name ); ?></td> 
		<td><?php echo esc_html( ucfirst( $order_status ) ); ?></td>
		<td><?php echo esc_html( $replace_msg ); ?></td> 	
		<td><?php echo esc_html( $replace_msg ); ?></td> 	
		<td></td> 	
	</tr>
	<?php
}

/**
 * Cron executed function.
 */
function refersion_cron_exec() {

	$entry_fields = array( 'report_id' => 141082 );
	// Init API Class.
	$refersion_api_init = new Wonkasoft_Refersion_Api( $entry_fields );
	// Generate download link.
	$refersion_response = $refersion_api_init->generate_download_link();
	// Data Declaration as String.
	$data = '';
	// CSV data link from refersion.
	$download_link = $refersion_response->download_link;

	$csvdata = array();

	$file = fopen( $download_link, 'r' );

	while ( ( $data = fgetcsv( $file ) ) !== false ) {
		array_push( $csvdata, $data );
	}
	fclose( $file );

	$finaldata  = array();
	$csvheaders = array_slice( $csvdata, 0, 1 );
	foreach ( $csvheaders[0] as $key => $header ) {
		$csvheaders[0][ $key ] = str_replace( ' ', '_', preg_replace( '/[\(\)]/', '', strtolower( $header ) ) );
	}

	$data = array_slice( $csvdata, 1 );

	if ( empty( $data ) ) {
		return false;
	}

	foreach ( $data as $key => $value ) {
		array_push( $finaldata, array_combine( $csvheaders[0], $value ) );
	}

	global $wpdb;
	$table_name = $wpdb->prefix . 'refersion_affiliates_data';

	$format = array(
		'%d',
		'%s',
		'%s',
		'%s',
		'%d',
		'%s',
		'%s',
		'%d',
		'%d',
		'%s',
		'%s',
		'%s',
		'%s',
	);

	$where_format = array(
		'%d',
	);

	foreach ( $finaldata as $key => $value ) {

		$query = $wpdb->query( $wpdb->prepare( "SELECT affiliate_id FROM $table_name WHERE affiliate_id = %d", $value['affiliate_id'] ) );

		if ( $query ) {
			$wpdb->update( $table_name, $value, array( 'affiliate_id' => $value['affiliate_id'] ), $format, $where_format );
		} else {
			$wpdb->insert( $table_name, $value, $format );
		}
	}
}
// add_action( 'refersion_cron_hook', 'refersion_cron_exec' );

	/**
	 * Schedule Cron Job Event
	 */
function REFERSION_CronJob() {

	if ( ! wp_next_scheduled( 'refersion_cron_hook' ) ) {
		wp_schedule_event( time(), 'daily', 'refersion_cron_hook' );
	}

}
// add_action( 'after_setup_theme', 'REFERSION_CronJob' );

/**
 * This creates the table for Refersion Data to be stored.
 */
function create_custom_database_tables() {
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name      = $wpdb->prefix . 'refersion_affiliates_data';
	if ( $wpdb->get_var( "SHOW TABLES LIKE '%s'", $table_name ) !== $table_name ) :
		$sql = "CREATE TABLE $table_name (
      id INT(11) NOT NULL AUTO_INCREMENT,
	  	affiliate_id INT(11) NOT NULL,
      affiliate_name VARCHAR(150) NOT NULL,
      affiliate_email VARCHAR(150) NOT NULL,
      company_name VARCHAR(150) NOT NULL,
      subid INT(15) NOT NULL,
      offer_id VARCHAR(16) NOT NULL,
      offer_name VARCHAR(150) NOT NULL,
      visits INT(15) NOT NULL,
      conversions INT(15) NOT NULL,
      revenue_usd VARCHAR(150) NOT NULL,
      commission_usd VARCHAR(150) NOT NULL,
      conversion_rate VARCHAR(150) NOT NULL,
      eepc_usd VARCHAR(150) NOT NULL,
      updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (id) 
      )$charset_collate;";
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
		update_option( 'refersion_affiliates_database_version', REFERSION_AFFILIATES_DATABASE_VERSION );
	  else :
		  $sql = "CREATE TABLE $table_name (
        id INT(11) NOT NULL AUTO_INCREMENT,
				affiliate_id INT(11) NOT NULL,
        affiliate_name VARCHAR(150) NOT NULL,
        affiliate_email VARCHAR(150) NOT NULL,
        company_name VARCHAR(150) NOT NULL,
        subid INT(15) NOT NULL,
        offer_id VARCHAR(16) NOT NULL,
        offer_name VARCHAR(150) NOT NULL,
        visits INT(15) NOT NULL,
        conversions INT(15) NOT NULL,
        revenue_usd VARCHAR(150) NOT NULL,
        commission_usd VARCHAR(150) NOT NULL,
        conversion_rate VARCHAR(150) NOT NULL,
        eepc_usd VARCHAR(150) NOT NULL,
        updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id) 
        )$charset_collate;";
			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
			dbDelta( $sql );
			update_option( 'refersion_affiliates_database_version', REFERSION_AFFILIATES_DATABASE_VERSION );
	  endif;

}
add_action( 'after_setup_theme', 'create_custom_database_tables' );

/**
 * This is supposed to set basic roles for users.
 *
 * @param  [type] $user_id [description]
 */
function wonkasoft_apera_basic_roles( $user_id ) {
	$role          = 'apera_perks_partner';
	$role_display  = 'Apera Perks Partner';
	$role2         = 'customer';
	$role2_display = 'Customer';

	$user = new WP_User( $user_id );
	if ( ! in_array( $role, $user->roles ) ) :
		$user->add_role( $role, $role_display );
	endif;

	if ( ! in_array( $role2, $user->roles ) ) :
		$user->add_role( $role2, $role2_display );
	endif;
}
add_action( 'user_register', 'wonkasoft_apera_basic_roles' );

/**
 * This fixes the login screen logo url.
 *
 * @return  string returns the logo url.
 */
function wonkasoft_logo_url() {
	return 'https://wonkasoft.com';
}
add_filter( 'login_headerurl', 'wonkasoft_logo_url' );

/**
 * Title to identify the current site.
 *
 * @return string returns title info.
 */
function wonkasoft_logo_url_title( $login_header_text ) {
	$output = '<img src="https://wonkasoft.com/wp-content/uploads/2018/03/wonkasoft-teal-dark-logo-192.png" class="login-logo" /><p>Aperabags.com built by Wonkasoft</p>';
	return $output;
}
add_filter( 'login_headertext', 'wonkasoft_logo_url_title' );

/**
 * This will place Wonkasoft Logo over the login form.
 */
function wonkasoft_login_logo() {
	?>
	<style type="text/css">
		#login h1 a, .login h1 a {
			background-image: unset;
			height: 94px;
			width: 100%;
			text-indent: 0;
			margin: 0 auto;
		}
	</style>
	<?php
}
add_action( 'login_enqueue_scripts', 'wonkasoft_login_logo' );

/**
 * This is for debugging.
 *
 * @param  array $tag contains all hooks on page.
 */
function get_hooks( $tag ) {
	global $wp_current_filter;
	global $debug_tags;
	if ( in_array( $tag, $debug_tags ) ) {
		return;
	}
	if ( substr( $tag, 0, 1 ) === '<' ) :
		return;
		endif;
	print_r( '<pre class="found-hook">' . $tag . '</pre>' );
	$debug_tags[] = $tag;
}
	// add_action( 'all', 'get_hooks', 999 );
