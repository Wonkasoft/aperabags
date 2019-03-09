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
				$slide->slider_name  								=	"slide_{$i}";
				$slide->slide_img									=	get_theme_mod( 'slider_'.$i );
				$slide->slide_text_position 						=	get_theme_mod( 'slider_text_position_'.$i );
				$slide->slide_header_message						=	get_theme_mod( 'slider_header_'.$i );
				$slide->slide_subheader								=	get_theme_mod( 'slider_subheader_'.$i );

				$mods_class->slides->{$slide->slider_name} = $slide;
			endif;
		}

		$mods_class->count = $count;

		return $mods_class;
	endif;

	if ( $section == 'cta' ) :
		$mods_class->slides = new stdClass();
		for ($i=1; $i <= 5; $i++) 
		{ 
			if ( !empty( get_theme_mod( 'cta_slider_'.$i ) ) ) :
				$count++;
				$slide 												=	new stdClass();
				$slide->slider_name  								=	"slide_{$i}";
				$slide->slide_img									=	get_theme_mod( 'cta_slider_'.$i );
				$slide->slide_text_position 						=	get_theme_mod( 'cta_slider_text_position_'.$i );
				$slide->slide_text_message							=	get_theme_mod( 'cta_slider_text_'.$i );
				$slide->slide_link_btn								=	get_theme_mod( 'btn_slider_text_'.$i  );
				$slide->slide_link									=	get_theme_mod( 'btn_slider_link_'.$i );

				$mods_class->slides->{$slide->slider_name} = $slide;
			endif;
		}
		
		$mods_class->count = $count;
		
		return $mods_class;
	endif;

	if ( $section == 'cause' ) :
		$mods_class->causes = new stdClass();
		for ($i=1; $i <= 3; $i++) 
		{ 
			if ( !empty( get_theme_mod( 'cause_option_'.$i ) ) ) :
				$count++;
				$cause 											=	new stdClass();
				$cause->cause_name  							=	"cause_option_{$i}";
				$cause->cause_img								=	get_theme_mod( 'cause_option_'.$i );
				$cause->cause_message_position 					=	get_theme_mod( 'cause_message_position_'.$i );
				$cause->cause_header							=	get_theme_mod( 'cause_header_'.$i );
				$cause->cause_message							=	get_theme_mod( 'cause_message_'.$i );

				$mods_class->causes->{$cause->cause_name} = $cause;
			endif;
		}

		$mods_class->count = $count;

		return $mods_class;
	endif;

	if ( $section == 'about' ) :
		if ( !empty( get_theme_mod( 'about_the_brand_header' ) ) ) :
			$count++;
			$about 											=	new stdClass();
			$about->about_name  							=	"about_the_brand";
			$about->about_header							=	get_theme_mod( 'about_the_brand_header' );
			$about->about_subheader							=	get_theme_mod( 'about_the_brand_subheader' );
			$about->about_message 							=	get_theme_mod( 'about_the_brand_message' );
			$about->about_brand_btn							=	get_theme_mod( 'about_the_brand_button' );
			$about->about_brand_btn_text					=	get_theme_mod( 'about_the_brand_button' );

			$mods_class->{$about->about_name} = $about;
		endif;

		$mods_class->count = $count;

		return $mods_class;
	endif;

	return false;
}
add_action( 'get_mods_before_section', 'the_mods_for_section', 10, 1 );