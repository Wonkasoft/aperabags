<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Apera_Bags
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
 * @param  string $section pass in the section for the mods desired
 * @return object          returns an object of the mods for the passed section
 */
function get_section_mods( $section ) {
	return the_mods_for_section( $section );
}
/**
 * This grabs all slides that are set in the customizer for the section that is passed in. 
 * @param  string $section should be a section reference example: top, cta, cause
 * @return bool/object    returns false if no slides are set in customizer
 */
function the_mods_for_section( $section ) {
	$mods_class = new stdClass();
	$count = 0;
	if ( $section == 'top' ) :
		$mods_class->slides = new stdClass();
		for ($i=1; $i <= 5; $i++) 
		{
			if ( !empty( get_theme_mod( 'slider_'.$i ) ) ) : 
				$count++;
				$slide 												=	new stdClass();
				$slide->slide_img									=	get_theme_mod( 'slider_'.$i );
				$slide->slide_text_position 						=	get_theme_mod( 'slider_text_position_'.$i );
				$slide->slide_header_message						=	get_theme_mod( 'slider_header_'.$i );
				$slide->slide_subheader								=	get_theme_mod( 'slider_subheader_'.$i );
				$slide->slider_btn_text								=	get_theme_mod( 'slider_btn_text_'.$i );
				$slide->slider_btn_link								=	get_theme_mod( 'slider_btn_link_'.$i );
				// Mobile theme mod
				$slide->slide_mobile_img							=	get_theme_mod( 'slider_mobile_'.$i );

				$mods_class->slides->{"slide_{$i}"} = $slide;
			endif;
		}

		$mods_class->slides->count = $count;

		return $mods_class;
	endif;

	if ( $section == 'shop' ) :

		if ( !empty( get_theme_mod( 'shop_title' ) ) ) : 
			$count++;
			$shop 												=	new stdClass();
			$shop->shop_title									=	get_theme_mod( 'shop_title' );
			$shop->shop_background_image 						=	get_theme_mod( 'shop_background_image' );
			$shop->enable_sale_banner							=	get_theme_mod( 'enable_sale_banner' );
			$shop->shop_product_per_row							=	get_theme_mod( 'shop_product_per_row');
			$shop->shop_num_of_products							=	get_theme_mod( 'shop_num_of_products');

			$mods_class->{"shop_mods"} = $shop;
			$mods_class->{"shop_mods"}->count = $count;
		endif;

		return $mods_class;
	endif;

	if ( $section == 'cta' ) :
		$mods_class->slides = new stdClass();
		for ($i=1; $i <= 5; $i++) 
		{ 
			if ( !empty( get_theme_mod( 'cta_slider_'.$i ) ) ) :
				$count++;
				$slide 												=	new stdClass();
				$slide->slide_img									=	get_theme_mod( 'cta_slider_'.$i );
				$slide->slide_text_position 						=	get_theme_mod( 'cta_slider_text_position_'.$i );
				$slide->slide_text_message							=	get_theme_mod( 'cta_slider_text_'.$i );
				$slide->slide_link_btn								=	get_theme_mod( 'btn_slider_text_'.$i  );
				$slide->slide_link									=	get_theme_mod( 'btn_slider_link_'.$i );
				// Mobile Theme mod
				$slide->slide_mobile_img							=	get_theme_mod( 'cta_slider_mobile_'.$i );

				$mods_class->slides->{"slide_{$i}"} = $slide;
			endif;
		}
		
		$mods_class->slides->count = $count;
		
		return $mods_class;
	endif;

	if ( $section == 'cause' ) :
		
		if ( !empty( get_theme_mod( 'cause_section_title' ) ) ) :

			$count++;
			$cause 									=	new stdClass();
			$cause->cause_section_title				=	get_theme_mod( 'cause_section_title');
			$cause->cause_section_background		=	get_theme_mod( 'cause_section_background');

			$mods_class->{"cause_mods"} = $cause;
			$mods_class->{"cause_mods"}->count = $count;
		endif;

		$count = 0;
		$mods_class->causes = new stdClass();
		for ($i=1; $i <= 3; $i++) 
		{ 
			if ( !empty( get_theme_mod( 'cause_image_'.$i ) ) ) :
				$count++;
				${"cause_$i"} = new stdClass();
				${"cause_$i"}->img			=	get_theme_mod( 'cause_image_'.$i );
				${"cause_$i"}->position		=	get_theme_mod( 'cause_message_position_'.$i );
				${"cause_$i"}->header		=	get_theme_mod( 'cause_header_'.$i );
				${"cause_$i"}->message		=	get_theme_mod( 'cause_message_'.$i );

				$mods_class->causes->{"cause_$i"} = ${"cause_$i"};

			endif;
		}

		$mods_class->causes->count = $count;

		return $mods_class;
	endif;

	if ( $section == 'about' ) :
		if ( !empty( get_theme_mod( 'about_the_brand_header' ) ) ) :
			$count++;
			$about 										=	new stdClass();
			$about->about_header						=	get_theme_mod( 'about_the_brand_header' );
			$about->about_subheader						=	get_theme_mod( 'about_the_brand_subheader' );
			$about->about_message 						=	get_theme_mod( 'about_the_brand_message' );
			$about->about_the_brand_btn_text			=	get_theme_mod( 'about_the_brand_btn_text' );
			$about->about_the_brand_button_link			=	get_permalink( get_theme_mod( 'about_the_brand_button_link' ) );
			$about->about_the_brand_second_image		=	get_theme_mod( 'about_the_brand_second_image' );

			$mods_class->{"about_the_brand"} = $about;
			$mods_class->{"about_the_brand"}->count = $count;
		endif;


		return $mods_class;
	endif;

	if ( $section == 'social' ) :
		if ( !empty( get_theme_mod( 'social_section_title' ) ) ) :
			$count++;
			$social 									=	new stdClass();
			$social->social_title						=	get_theme_mod( 'social_section_title' );
			$social->social_message						=	get_theme_mod( 'social_section_message' );
			$social->social_shortcode					=	get_theme_mod( 'social_shortcode' );
			$social->social_btn_text 					=	get_theme_mod( 'social_btn_text' );
			$social->social_shop_button					=	get_permalink( get_theme_mod( 'social_shop_button' ) );

			$mods_class->{"social_mods"} = $social;
		endif;

		$mods_class->count = $count;

		return $mods_class;
	endif;

	if ( $section == 'footer' ) :
		if ( !empty( get_theme_mod( 'footer_social_instagram' ) ) ) :
			$count++;
			$footer 									=	new stdClass();
			$footer->footer_social_title				=	get_theme_mod( 'footer_social_title' );
			$footer->footer_social_instagram			=	get_theme_mod( 'footer_social_instagram' );
			$footer->footer_social_twitter				=	get_theme_mod( 'footer_social_twitter' );
			$footer->footer_social_facebook 			=	get_theme_mod( 'footer_social_facebook' );
			$footer->footer_social_pinterest			=	get_theme_mod( 'footer_social_pinterest' );
			$footer->footer_contact_message				=	get_theme_mod( 'footer_contact_message' );
			$footer->footer_contact_support_email		=	get_theme_mod( 'footer_contact_support_email' );
			$footer->footer_logo						=	get_theme_mod( 'footer_logo' );
			$footer->footer_form_shortcode				=	get_theme_mod( 'footer_form_shortcode' );

			$mods_class->{"footer_mods"} = $footer;
			$mods_class->{"footer_mods"}->count = $count;
		endif;
		
		$count = 0;
		$mods_class->footer_titles = new stdClass();
		for ($i=1; $i <= 5; $i++) 
		{	
			if ( !empty( get_theme_mod( 'footer_menu_header_'.$i ) ) ) :
				$count++;
				$mods_class->footer_titles->{"footer_title_$i"} = get_theme_mod( 'footer_menu_header_'.$i );
			endif;
		}

		$mods_class->footer_titles->count = $count;

		return $mods_class;
	endif;

	return false;
}
add_action( 'get_mods_before_section', 'the_mods_for_section', 10, 1 );

/*====================================================
=            Customizing of Gravity forms            =
====================================================*/
/**
 * customize gravity forms
 */
function add_bootstrap_container_class( $form, $ajax, $field_values ) {
	$inline_forms = array( 2 );
	if ( !empty( $form['cssClass'] ) ) :
		$form['cssClass'] .= ' wonka-gform wonka-gform-' . $form['id'];
	else:
		$form['cssClass'] = 'wonka-gform wonka-gform-' . $form['id'];
	endif;

	if ( in_array( $form['id'], $inline_forms ) ) :
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

function wonka_add_classes_to_button( $button, $form ) {
	$dom = new DOMDocument();
    $dom->loadHTML( $button );
    $input = $dom->getElementsByTagName( 'input' )->item(0);
    $classes = $input->getAttribute( 'class' );
    $classes .= " wonka-btn";
    $input->setAttribute( 'class', $classes );

    return $dom->saveHtml( $input );
}

add_filter( 'gform_submit_button', 'wonka_add_classes_to_button', 8, 2 );
/*=====  End of Customizing of Gravity forms  ======*/
