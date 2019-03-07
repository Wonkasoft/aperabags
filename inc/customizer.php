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
	 * Theme options panel
	 * @since 1.0.0
	 */
	$wp_customize->add_panel( 'ft_theme_options', array(
		'priority'		 =>	5,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => __('Apera Theme Options', 'apera'),
		'description'    => __('Theme Settings', 'apera'),
	) );

		/**	
		 * Slider settings Section
		 * @since  1.0.0
		 */
		$wp_customize->add_section( 'slider_section' , array(
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'priority'		 => 10,
			'title'			 => __( 'Top Slider Section', 'apera' ),
			'description'	 => __( 'Slider Options version 1.0.0', 'apera' ),
			'panel'  		 => 'ft_theme_options',
		) );

		for ( $i=1; $i < 6; $i++ ) { 

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
			 * Slider message position settings Section
			 * @since  1.0.0
			 */
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
			 * Slider message settings Section
			 * @since  1.0.0
			 */
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
		 * Shop settings Section
		 * @since  1.0.0
		 */
		$wp_customize->add_section( 'shop_section' , array(
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'priority'		 => 10,
			'title'			 => __( 'Shop Section', 'apera' ),
			'description'	 => __( 'Shop Options version 1.0.0', 'apera' ),
			'panel'  		 => 'ft_theme_options',
		) );

		/**
		 * Shop options for product per row settings Section
		 * @since  1.0.0
		 */
		$wp_customize->add_setting( 'shop_product_per_row', array(
			'default'   				=> '',
			'transport' 				=> 'refresh',
		) );

		// Shop option Setting Control
		$wp_customize->add_control( new WP_Customize_Control( 
			$wp_customize, 
			'shop_product_per_row', 
			array(
			'label'      	=> __( 'Product per row', 'apera' ),
			'section'    	=> 'shop_section',
			'setting'   	=> 'shop_product_per_row',
			'description'	=> 'How many products per row?',
			'type'			=> 'select',
			'choices' => array(
			        '2' => 2,
			        '3' => 3,
			        '4' => 4,
			        '5' => 5,
			    )
		) ) );

		/**
		 * Shop options for number of products settings Section
		 * @since  1.0.0
		 */
		$wp_customize->add_setting( 'shop_num_of_products', array(
			'default'   				=> '',
			'transport' 				=> 'refresh',
		) );

		// Shop for number of products option Setting Control
		$wp_customize->add_control( new WP_Customize_Control( 
			$wp_customize, 
			'shop_num_of_products', 
			array(
			'label'      	=> __( 'Total products to show', 'apera' ),
			'section'    	=> 'shop_section',
			'setting'   	=> 'shop_num_of_products',
			'description'	=> 'How many products to show?',
			'type'			=> 'select',
			'choices' => array(
			        '3' => 3,
			        '4' => 4,
			        '5' => 5,
			        '6' => 6,
			        '7' => 7,
			        '8' => 8,
			        '9' => 9,
			    )
		) ) );

		/**
		 * Large CTA settings Section
		 * @since  1.0.0
		 */
		$wp_customize->add_section( 'lg_cta_section' , array(
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'priority'		 => 10,
			'title'			 => __( 'Large CTA Section', 'apera' ),
			'description'	 => __( 'Large CTA Options version 1.0.0', 'apera' ),
			'panel'  		 => 'ft_theme_options',
		) );

		/**
		 * Loop for all sliders and options
		 * @since 1.0.0
		 */
		for ( $i=1; $i < 6; $i++ ) { 

			// Slider Setting
			$wp_customize->add_setting( 'cta_slider_'.$i , array(
				'default'   				=> '',
				'transport' 				=> 'refresh',
			) );

			// Slider Setting Control
			$wp_customize->add_control( new WP_Customize_Media_Control( 
				$wp_customize, 
				'cta_slider_'.$i, 
				array(
				'label'      	=> __( 'Slider Image '.$i, 'apera' ),
				'section'    	=> 'lg_cta_section',
				'setting'   	=> 'cta_slider_'.$i,
				'type'			=> 'image',
				'description'	=> 'Add image for slider '.$i,
			) ) );

			/** 
			 * Slider message position settings Section
			 * @since  1.0.0
			 */
			$wp_customize->add_setting( 'cta_slider_text_position_'.$i , array(
				'default'   				=> '',
				'transport' 				=> 'refresh',
			) );

			// Slider message position Setting Control
			$wp_customize->add_control( new WP_Customize_Control( 
				$wp_customize, 
				'cta_slider_text_position_'.$i, 
				array(
				'label'      	=> __( 'Slider message position '.$i, 'apera' ),
				'section'    	=> 'lg_cta_section',
				'setting'   	=> 'cta_slider_text_position_'.$i,
				'description'	=> 'Text alignment '.$i,
				'type'			=> 'select',
				'choices' => array(
				        'left' => 'left',
				        'center' => 'center',
				        'right' => 'right',
				    )
			) ) );
			
			/**
			 * Slider message settings Section
			 * @since  1.0.0
			 */
			$wp_customize->add_setting( 'cta_slider_text_'.$i , array(
				'default'   				=> '',
				'transport' 				=> 'refresh',
			) );

			// Slider message Setting Control
			$wp_customize->add_control( new WP_Customize_Control( 
				$wp_customize, 
				'cta_slider_text_'.$i, 
				array(
				'label'      	=> __( 'Slider message '.$i, 'apera' ),
				'section'    	=> 'lg_cta_section',
				'setting'   	=> 'cta_slider_text_'.$i,
				'type'			=> 'text',
				'description'	=> 'Add message for slider '.$i,
			) ) );

			/**
			 * Slider message settings Section
			 * @since  1.0.0
			 */
			$wp_customize->add_setting( 'btn_slider_link_'.$i , array(
				'default'   				=> '',
				'transport' 				=> 'refresh',
			) );

			// Slider message Setting Control
			$wp_customize->add_control( new WP_Customize_Control( 
				$wp_customize, 
				'btn_slider_link_'.$i, 
				array(
				'label'      	=> __( 'Button Link '.$i, 'apera' ),
				'section'    	=> 'lg_cta_section',
				'setting'   	=> 'btn_slider_link_'.$i,
				'type'			=> 'text',
				'description'	=> 'Button Link '.$i,
			) ) );
		}

		/**
		 * Our Cause / About Us settings Section
		 * @since  1.0.0
		 */
		$wp_customize->add_section( 'cause_section' , array(
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'priority'		 => 10,
			'title'			 => __( 'Our Cause Section', 'apera' ),
			'description'	 => __( 'Cause Section Options version 1.0.0', 'apera' ),
			'panel'  		 => 'ft_theme_options',
		) );

		/**
		 * Loop for all items and options
		 * @since 1.0.0
		 */
		for ( $i=1; $i < 4; $i++ ) { 

			// Slider Setting
			$wp_customize->add_setting( 'cause_option_'.$i , array(
				'default'   				=> '',
				'transport' 				=> 'refresh',
			) );

			// Slider Setting Control
			$wp_customize->add_control( new WP_Customize_Media_Control( 
				$wp_customize, 
				'cause_option_'.$i, 
				array(
				'label'      	=> __( 'Image for cause '.$i, 'apera' ),
				'section'    	=> 'cause_section',
				'setting'   	=> 'cause_option_'.$i,
				'type'			=> 'image',
				'description'	=> 'Add image for cause '.$i,
			) ) );

			/** 
			 * Cause message position settings Section
			 * @since  1.0.0
			 */
			$wp_customize->add_setting( 'cause_message_position_'.$i , array(
				'default'   				=> '',
				'transport' 				=> 'refresh',
			) );

			// Cause message position Setting Control
			$wp_customize->add_control( new WP_Customize_Control( 
				$wp_customize, 
				'cause_message_position_'.$i, 
				array(
				'label'      	=> __( 'Cause message position '.$i, 'apera' ),
				'section'    	=> 'cause_section',
				'setting'   	=> 'cause_message_position_'.$i,
				'description'	=> 'Text alignment '.$i,
				'type'			=> 'select',
				'choices' => array(
				        'left' => 'left',
				        'center' => 'center',
				        'right' => 'right',
				    )
			) ) );

			/**
			 * Cause header settings Section
			 * @since  1.0.0
			 */
			$wp_customize->add_setting( 'cause_header_'.$i , array(
				'default'   				=> '',
				'transport' 				=> 'refresh',
			) );

			// Cause message Setting Control
			$wp_customize->add_control( new WP_Customize_Control( 
				$wp_customize, 
				'cause_header_'.$i, 
				array(
				'label'      	=> __( 'Cause header '.$i, 'apera' ),
				'section'    	=> 'cause_section',
				'setting'   	=> 'cause_header_'.$i,
				'type'			=> 'text',
				'description'	=> 'Add header for cause '.$i,
			) ) );
			
			/**
			 * Cause message settings Section
			 * @since  1.0.0
			 */
			$wp_customize->add_setting( 'cause_message_'.$i , array(
				'default'   				=> '',
				'transport' 				=> 'refresh',
			) );

			// Cause message Setting Control
			$wp_customize->add_control( new WP_Customize_Control( 
				$wp_customize, 
				'cause_message_'.$i, 
				array(
				'label'      	=> __( 'Cause message '.$i, 'apera' ),
				'section'    	=> 'cause_section',
				'setting'   	=> 'cause_message_'.$i,
				'type'			=> 'textarea',
				'description'	=> 'Add message for cause '.$i,
			) ) );
		}

		/**
		 * About the brand settings Section
		 * @since  1.0.0
		 */
		$wp_customize->add_section( 'about_section' , array(
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'priority'		 => 10,
			'title'			 => __( 'About the Brand Section', 'apera' ),
			'description'	 => __( 'About the brand Section Options version 1.0.0', 'apera' ),
			'panel'  		 => 'ft_theme_options',
		) );

		/**
		 * About the brand header settings Section
		 * @since  1.0.0
		 */
		$wp_customize->add_setting( 'about_the_brand_header' , array(
			'default'   				=> '',
			'transport' 				=> 'refresh',
		) );

		// About the brand header Setting Control
		$wp_customize->add_control( new WP_Customize_Control( 
			$wp_customize, 
			'about_the_brand_header', 
			array(
			'label'      	=> __( 'About the brand header', 'apera' ),
			'section'    	=> 'about_section',
			'setting'   	=> 'about_the_brand_header',
			'type'			=> 'text',
			'description'	=> 'About the brand header',
		) ) );

		/**
		 * About subheader settings Section
		 * @since  1.0.0
		 */
		$wp_customize->add_setting( 'about_the_brand_subheader' , array(
			'default'   				=> '',
			'transport' 				=> 'refresh',
		) );

		// About the brand subheader Setting Control
		$wp_customize->add_control( new WP_Customize_Control( 
			$wp_customize, 
			'about_the_brand_subheader', 
			array(
			'label'      	=> __( 'About the brand subheader', 'apera' ),
			'section'    	=> 'about_section',
			'setting'   	=> 'about_the_brand_subheader',
			'type'			=> 'text',
			'description'	=> 'About the brand subheader',
		) ) );

		/**
		 * About the brand message settings Section
		 * @since  1.0.0
		 */
		$wp_customize->add_setting( 'about_the_brand_message' , array(
			'default'   				=> '',
			'transport' 				=> 'refresh',
		) );

		// About the brand message Setting Control
		$wp_customize->add_control( new WP_Customize_Control( 
			$wp_customize, 
			'about_the_brand_message', 
			array(
			'label'      	=> __( 'About the brand message', 'apera' ),
			'section'    	=> 'about_section',
			'setting'   	=> 'about_the_brand_message',
			'type'			=> 'textarea',
			'description'	=> 'About the brand message',
		) ) );

		/**
		 * About the brand button settings Section
		 * @since  1.0.0
		 */
		$wp_customize->add_setting( 'about_the_brand_button' , array(
			'default'   				=> '',
			'transport' 				=> 'refresh',
		) );

		// About the brand button Setting Control
		$wp_customize->add_control( new WP_Customize_Control( 
			$wp_customize, 
			'about_the_brand_button', 
			array(
			'label'      	=> __( 'About the brand button', 'apera' ),
			'section'    	=> 'about_section',
			'setting'   	=> 'about_the_brand_button',
			'type'			=> 'dropdown-pages',
			'description'	=> 'About the brand button',
		) ) );

		/**
		 * Social settings Section
		 * @since  1.0.0
		 */
		// Adding customizer section for Social settings section
		$wp_customize->add_section( 'social_section' , array(
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'priority'		 => 10,
			'title'			 => __( 'Social Section', 'apera' ),
			'description'	 => __( 'Social Section Options version 1.0.0', 'apera' ),
			'panel'  		 => 'ft_theme_options',
		) );

		/**
		 * Social shortcode settings Section
		 * @since  1.0.0
		 */
		$wp_customize->add_setting( 'social_shortcode' , array(
			'default'   				=> '',
			'transport' 				=> 'refresh',
		) );

		// Social shortcode Setting Control
		$wp_customize->add_control( new WP_Customize_Control( 
			$wp_customize, 
			'social_shortcode', 
			array(
			'label'      	=> __( 'Social Shortcode', 'apera' ),
			'section'    	=> 'social_section',
			'setting'   	=> 'social_shortcode',
			'type'			=> 'text',
			'description'	=> 'Shortcode Example: [instagram]',
		) ) );

		/**
		 * Social shop button  settings Section
		 * @since  1.0.0
		 */
		$wp_customize->add_setting( 'social_shop_button' , array(
			'default'   				=> '',
			'transport' 				=> 'refresh',
		) );

		// Social shop button Setting Control
		$wp_customize->add_control( new WP_Customize_Control( 
			$wp_customize, 
			'social_shop_button', 
			array(
			'label'      	=> __( 'Social Shop Button', 'apera' ),
			'section'    	=> 'social_section',
			'setting'   	=> 'social_shop_button',
			'type'			=> 'dropdown-pages',
			'description'	=> 'Social Shop Button choose the destination page',
		) ) );

		/**
		 * Footer settings Section
		 * @since  1.0.0
		 */
		$wp_customize->add_section( 'footer_section' , array(
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'priority'		 => 10,
			'title'			 => __( 'Footer Section', 'apera' ),
			'description'	 => __( 'Footer Section Options version 1.0.0', 'apera' ),
			'panel'  		 => 'ft_theme_options',
		) );

		/**
		 * Footer social links settings Section
		 * @since  1.0.0
		 */
		$wp_customize->add_setting( 'footer_social_ig' , array(
			'default'   				=> '',
			'transport' 				=> 'refresh',
		) );

		// Footer social Instagram Setting Control
		$wp_customize->add_control( new WP_Customize_Control( 
			$wp_customize, 
			'footer_social_ig', 
			array(
			'label'      	=> __( 'Instagram Icon Link', 'apera' ),
			'section'    	=> 'footer_section',
			'setting'   	=> 'footer_social_ig',
			'type'			=> 'text',
			'description'	=> 'Example: https://instagram.com/user',
		) ) );

		// Footer social Twitter link Setting
		$wp_customize->add_setting( 'footer_social_twitter' , array(
			'default'   				=> '',
			'transport' 				=> 'refresh',
		) );

		// Footer social Twitter Setting Control
		$wp_customize->add_control( new WP_Customize_Control( 
			$wp_customize, 
			'footer_social_twitter', 
			array(
			'label'      	=> __( 'Twitter Icon Link', 'apera' ),
			'section'    	=> 'footer_section',
			'setting'   	=> 'footer_social_twitter',
			'type'			=> 'text',
			'description'	=> 'Example: https://twitter.com/user',
		) ) );

		// Footer social Facebook link Setting
		$wp_customize->add_setting( 'footer_social_facebook' , array(
			'default'   				=> '',
			'transport' 				=> 'refresh',
		) );

		// Footer social Facebook Setting Control
		$wp_customize->add_control( new WP_Customize_Control( 
			$wp_customize, 
			'footer_social_facebook', 
			array(
			'label'      	=> __( 'Facebook Icon Link', 'apera' ),
			'section'    	=> 'footer_section',
			'setting'   	=> 'footer_social_facebook',
			'type'			=> 'text',
			'description'	=> 'Example: https://facebook.com/user',
		) ) );

		// Footer social Pinterest link Setting
		$wp_customize->add_setting( 'footer_social_pinterest' , array(
			'default'   				=> '',
			'transport' 				=> 'refresh',
		) );

		// Footer social Pinterest Setting Control
		$wp_customize->add_control( new WP_Customize_Control( 
			$wp_customize, 
			'footer_social_pinterest', 
			array(
			'label'      	=> __( 'Pinterest Icon Link', 'apera' ),
			'section'    	=> 'footer_section',
			'setting'   	=> 'footer_social_pinterest',
			'type'			=> 'text',
			'description'	=> 'Example: https://pinterest.com/user',
		) ) );

		// Footer contact message Setting
		$wp_customize->add_setting( 'footer_contact_message' , array(
			'default'   				=> '',
			'transport' 				=> 'refresh',
		) );

		// Footer contact message Setting Control
		$wp_customize->add_control( new WP_Customize_Control( 
			$wp_customize, 
			'footer_contact_message', 
			array(
			'label'      	=> __( 'Contact message', 'apera' ),
			'section'    	=> 'footer_section',
			'setting'   	=> 'footer_contact_message',
			'type'			=> 'text',
			'description'	=> 'Example: Contact Customer Service',
		) ) );

		// Footer support email Setting
		$wp_customize->add_setting( 'footer_contact_support_email' , array(
			'default'   				=> '',
			'transport' 				=> 'refresh',
		) );

		// Footer support email Setting Control
		$wp_customize->add_control( new WP_Customize_Control( 
			$wp_customize, 
			'footer_contact_support_email', 
			array(
			'label'      	=> __( 'Contact support email', 'apera' ),
			'section'    	=> 'footer_section',
			'setting'   	=> 'footer_contact_support_email',
			'type'			=> 'text',
			'description'	=> 'Example: support@domain.com',
		) ) );

		/**
		 * Footer form shortcode settings Section
		 * @since  1.0.0
		 */
		$wp_customize->add_setting( 'footer_form_shortcode' , array(
			'default'   				=> '',
			'transport' 				=> 'refresh',
		) );

		// Footer form shortcode Setting Control
		$wp_customize->add_control( new WP_Customize_Control( 
			$wp_customize, 
			'footer_form_shortcode', 
			array(
			'label'      	=> __( 'Footer Form Shortcode', 'apera' ),
			'section'    	=> 'footer_section',
			'setting'   	=> 'footer_form_shortcode',
			'type'			=> 'text',
			'description'	=> 'Shortcode Example: [signupform]',
		) ) );
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
