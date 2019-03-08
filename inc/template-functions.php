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

function get_these_slides() {
	global $slides_class;
	if ( !empty( $slides_class ) ) :
		return $slides_class;
	endif;
	return false;
}
/**
 * This grabs all slides that are set in the customizer for the section that is passed in. 
 * @param  string $slider should be a section reference example: top, cta
 * @return bool/object    returns false if no slides are set in customizer
 */
function get_slides_for_slider( $slider ) {
	global $slides_class;
	$slides_class = new stdClass();
	$slides_class->slides = new stdClass();
	if ( $slider == 'top' ) :
		for ($i=1; $i <= 5; $i++) { 
			$slide 												=	new stdClass();
			$slide->slider_name  								=	"slide_{$i}";
			$slide->slide_img									=	get_theme_mod( 'slider_'.$i );
			$slide->slide_text_position 						=	get_theme_mod( 'slider_text_position_'.$i );
			$slide->slide_header_message						=	get_theme_mod( 'slider_header_'.$i );
			$slide->slide_subheader								=	get_theme_mod( 'slider_subheader_'.$i );

			$slides_class->slides->{$slide->slider_name} = $slide;
		}
		
		return $slides_class;
	endif;

	if ( $slider == 'cta' ) :
		for ($i=1; $i <= 5; $i++) { 
			$slide 												=	new stdClass();
			$slide->slider_name  								=	"slide_{$i}";
			$slide->slide_img									=	get_theme_mod( 'cta_slider_'.$i );
			$slide->slide_text_position 						=	get_theme_mod( 'cta_slider_text_position_'.$i );
			$slide->slide_text_message							=	get_theme_mod( 'cta_slider_text_'.$i );
			$slide->slide_link									=	get_theme_mod( 'btn_slider_link_'.$i );

			$slides_class->slides->{$slide->slider_name} = $slide;
		}
		
		return $slides_class;
	endif;

	return false;
}
add_action( 'get_slides_before_slider', 'get_slides_for_slider', 10, 1 );