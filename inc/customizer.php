<?php
/**
 * Apera Bags Theme Customizer
 *
 * @package Apera_Bags
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function apera_bags_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'apera_bags_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'apera_bags_customize_partial_blogdescription',
		) );
	}

	/**
	 * { item_description }
	 */
	$wp_customize->add_panel( 'ft_theme_options', array(
		'priority'		 =>	5,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => __('Apera Theme Options', 'apera'),
		'description'    => __('Theme Settings', 'apera'),
	) );

	/**
		 * 
		 * Slider settings Section
		 * @since  1.0.0
		 * 
		 */
		// Adding customizer section for Slider settings section
		$wp_customize->add_section( 'slider_section' , array(
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'priority'		 => 10,
			'title'			 => __( 'Slider Section', 'apera' ),
			'description'	 => __( 'Slider Options version 1.0.0', 'apera' ),
			'panel'  		 => 'ft_theme_options',
		) );
		for ($i=1; $i < 6; $i++) { 
			// Slider Setting
			$wp_customize->add_setting( 'slider_'.$i , array(
				'default'   				=> '',
				'transport' 				=> 'refresh',
			) );
			// Slider Setting Control
			$wp_customize->add_control( new WP_Customize_Media_Control( 
				$wp_customize, 
				'slider_'.$i, 
				array(
				'label'      	=> __( 'Slider Image '.$i, 'apera' ),
				'section'    	=> 'slider_section',
				'setting'   	=> 'slider_'.$i,
				'type'			=> 'image',
				'description'	=> 'Add image for slider '.$i,
			) ) );
			/**
			 * 
			 * Slider message position settings Section
			 * @since  1.0.0
			 * 
			 */
			// Slider message position Setting
			$wp_customize->add_setting( 'slider_text_position_'.$i , array(
				'default'   				=> '',
				'transport' 				=> 'refresh',
			) );
			// Slider message position Setting Control
			$wp_customize->add_control( new WP_Customize_Control( 
				$wp_customize, 
				'slider_text_position_'.$i, 
				array(
				'label'      	=> __( 'Slider message position '.$i, 'apera' ),
				'section'    	=> 'slider_section',
				'setting'   	=> 'slider_text_position_'.$i,
				'description'	=> 'Text alignment '.$i,
				'type'			=> 'select',
				'choices' => array(
				        'left' => 'left',
				        'center' => 'center',
				        'right' => 'right',
				    )
			) ) );
			/**
			 * 
			 * Slider message settings Section
			 * @since  1.0.0
			 * 
			 */
			// Slider message Setting
			$wp_customize->add_setting( 'slider_text_'.$i , array(
				'default'   				=> '',
				'transport' 				=> 'refresh',
			) );
			// Slider message Setting Control
			$wp_customize->add_control( new WP_Customize_Control( 
				$wp_customize, 
				'slider_text_'.$i, 
				array(
				'label'      	=> __( 'Slider message '.$i, 'apera' ),
				'section'    	=> 'slider_section',
				'setting'   	=> 'slider_text_'.$i,
				'type'			=> 'text',
				'description'	=> 'Add message for slider '.$i,
			) ) );
		}

		/**
		 * 
		 * Slider options settings Section
		 * @since  1.0.0
		 * 
		 */
		// Slider option Setting
		$wp_customize->add_setting( 'slider_text_'.$i , array(
			'default'   				=> '',
			'transport' 				=> 'refresh',
		) );
		// Slider option Setting Control
		$wp_customize->add_control( new WP_Customize_Image_Control( 
			$wp_customize, 
			'slider_text_'.$i, 
			array(
			'label'      	=> __( 'Slider message '.$i, 'apera' ),
			'section'    	=> 'slider_section',
			'setting'   	=> 'slider_text_'.$i,
			'type'			=> 'text',
			'description'	=> 'Add message for slider '.$i,
		) ) );
		/**
		 * 
		 * Shop settings Section
		 * @since  1.0.0
		 * 
		 */
		// Adding customizer section for Shop settings section
		$wp_customize->add_section( 'slider_section' , array(
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'priority'		 => 10,
			'title'			 => __( 'Slider Section', 'apera' ),
			'description'	 => __( 'Slider Options version 1.0.0', 'apera' ),
			'panel'  		 => 'ft_theme_options',
		) );


}
add_action( 'customize_register', 'apera_bags_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function apera_bags_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function apera_bags_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function apera_bags_customize_preview_js() {
	wp_enqueue_script( 'apera-bags-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'apera_bags_customize_preview_js' );
