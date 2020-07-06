<?php
/**
 * Apera Bags Theme Customizer
 *
 * @package aperabags
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
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'apera_bags_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'apera_bags_customize_partial_blogdescription',
			)
		);
	}

	/**
	* Theme options panel
	*
	* @since 1.0.0
	*/
	$wp_customize->add_panel(
		'wonkasoft_theme_options',
		array(
			'priority'       => 5,
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'title'          => __( 'Apera Homepage Options', 'aperabags' ),
			'description'    => __( 'Theme Settings', 'aperabags' ),
		)
	);

	/**
	* Top bar message settings Section
	*
	* @since  1.0.0
	*/
	$wp_customize->add_section(
		'topbar_message_section',
		array(
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'priority'       => 10,
			'title'          => __( 'Topbar Message Section', 'aperabags' ),
			'description'    => __( 'Topbar Options version 1.0.0', 'aperabags' ),
			'panel'          => 'wonkasoft_theme_options',
		)
	);

	/**
	* Enable topbar message settings Section
	*
	* @since  1.0.0
	*/
	$wp_customize->add_setting(
		'enable_topbar',
		array(
			'default'   => '',
			'transport' => 'refresh',
		)
	);

	// Enable topbar message Setting Control.
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'enable_topbar_control',
			array(
				'label'       => __( 'Topbar Message Option', 'aperabags' ),
				'section'     => 'topbar_message_section',
				'settings'    => 'enable_topbar',
				'type'        => 'checkbox',
				'description' => 'Enable Topbar',
			)
		)
	);

	 /**
	  * Topbar color settings Section
	  *
	  * @since  1.0.0
	  */
	$wp_customize->add_setting(
		'topbar_color',
		array(
			'default'   => '',
			'transport' => 'refresh',
		)
	);

	// Topbar color Setting Control.
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'topbar_color_control',
			array(
				'label'       => __( 'Topbar Color Option', 'aperabags' ),
				'section'     => 'topbar_message_section',
				'settings'    => 'topbar_color',
				'type'        => 'color',
				'description' => 'Topbar color',
			)
		)
	);

	 /**
	  * Topbar message settings
	  *
	  * @since  1.0.0
	  */
	$wp_customize->add_setting(
		'topbar_message',
		array(
			'default'   => '',
			'transport' => 'refresh',
		)
	);

	// Topbar color Setting Control.
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'topbar_message_control',
			array(
				'label'       => __( 'Topbar Message Option', 'aperabags' ),
				'section'     => 'topbar_message_section',
				'settings'    => 'topbar_message',
				'type'        => 'text',
				'description' => 'Topbar message',
			)
		)
	);

	 /**
	  * Introduction Section settings Section
	  *
	  * @since  1.0.1
	  */
	$wp_customize->add_section(
		'introduction_section',
		array(
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'priority'       => 10,
			'title'          => __( 'Introduction Section Section', 'aperabags' ),
			'description'    => __( 'Introduction Section Options version 1.0.1', 'aperabags' ),
			'panel'          => 'wonkasoft_theme_options',
		)
	);

	for ( $i = 1; $i <= 5; $i++ ) :
		// Slider Setting.
		$wp_customize->add_setting(
			'slider_' . $i,
			array(
				'default'   => '',
				'transport' => 'refresh',
			)
		);

		// Slider Setting Control.
		$wp_customize->add_control(
			new WP_Customize_Media_Control(
				$wp_customize,
				'slider_control_' . $i,
				array(
					'label'       => 'Slider Image ' . $i,
					'section'     => 'introduction_section',
					'settings'    => 'slider_' . $i,
					'type'        => 'media',
					'description' => 'Add image for slider ' . $i,
				)
			)
		);

		// Slider Mobile Setting.
		$wp_customize->add_setting(
			'slider_mobile_' . $i,
			array(
				'default'   => '',
				'transport' => 'refresh',
			)
		);

		// Slider Mobile Setting Control.
		$wp_customize->add_control(
			new WP_Customize_Media_Control(
				$wp_customize,
				'slider_mobile_' . $i . '_control',
				array(
					'label'       => 'Slider Mobile Image ' . $i,
					'section'     => 'introduction_section',
					'settings'    => 'slider_mobile_' . $i,
					'type'        => 'media',
					'description' => 'Add image for slider ' . $i,
				)
			)
		);

		 /**
		  * Slider message position settings Section
		  *
		  * @since  1.0.1
		  */
		$wp_customize->add_setting(
			'slider_text_position_' . $i,
			array(
				'default'   => '',
				'transport' => 'refresh',
			)
		);

		// Slider message position Setting Control.
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'slider_text_position_' . $i . '_control',
				array(
					'label'       => __( 'Slider message position', 'aperabags' ),
					'section'     => 'introduction_section',
					'settings'    => 'slider_text_position_' . $i,
					'description' => 'Text alignment ' . $i,
					'type'        => 'select',
					'choices'     => array(
						'left'   => 'left',
						'center' => 'center',
						'right'  => 'right',
					),
				)
			)
		);

		 /**
		  * Slider header message settings Section
		  *
		  * @since  1.0.1
		  */
		$wp_customize->add_setting(
			'slider_header_' . $i,
			array(
				'default'   => '',
				'transport' => 'refresh',
			)
		);

		// Slider header message Setting Control.
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'slider_header_' . $i . '_control',
				array(
					'label'       => __( 'Slider header message', 'aperabags' ),
					'section'     => 'introduction_section',
					'settings'    => 'slider_header_' . $i,
					'type'        => 'text',
					'description' => 'Add message for slider ' . $i,
				)
			)
		);

		 /**
		  * Slider subheader message settings Section
		  *
		  * @since  1.0.1
		  */
		$wp_customize->add_setting(
			'slider_subheader_' . $i,
			array(
				'default'   => '',
				'transport' => 'refresh',
			)
		);

		// Slider subheader message Setting Control.
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'slider_subheader_' . $i . '_control',
				array(
					'label'       => __( 'Slider subheader', 'aperabags' ),
					'section'     => 'introduction_section',
					'settings'    => 'slider_subheader_' . $i,
					'type'        => 'text',
					'description' => 'Add subheader for slider ' . $i,
				)
			)
		);

		 /**
		  * Slider button text settings Section
		  *
		  * @since  1.0.1
		  */
		$wp_customize->add_setting(
			'slider_btn_text_' . $i,
			array(
				'default'   => '',
				'transport' => 'refresh',
			)
		);

		// Slider button text Setting Control.
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'slider_btn_text_' . $i . '_control',
				array(
					'label'       => __( 'Slider button text', 'aperabags' ),
					'section'     => 'introduction_section',
					'settings'    => 'slider_btn_text_' . $i,
					'type'        => 'text',
					'description' => 'Button text for slider' . $i,
				)
			)
		);

		 /**
		  * Slider link or page settings Section
		  *
		  * @since  1.0.1
		  */
		$wp_customize->add_setting(
			'slider_btn_link_' . $i,
			array(
				'default'   => '',
				'transport' => 'refresh',
			)
		);

		// Slider link or page Setting Control.
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'slider_btn_link_' . $i . '_control',
				array(
					'label'       => __( 'Slider Button Link', 'aperabags' ),
					'section'     => 'introduction_section',
					'settings'    => 'slider_btn_link_' . $i,
					'type'        => 'dropdown-pages',
					'description' => 'Slider button link',
				)
			)
		);

	endfor;

	 /**
	  * Discovery settings Section
	  *
	  * @since  1.0.1
	  */
	$wp_customize->add_section(
		'discovery_section',
		array(
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'priority'       => 10,
			'title'          => __( 'Discovery Section', 'aperabags' ),
			'description'    => __( 'Discovery Options version 1.0.1', 'aperabags' ),
			'panel'          => 'wonkasoft_theme_options',
		)
	);

	// Discovery featured image Setting.
	$wp_customize->add_setting(
		'discovery_featured_image',
		array(
			'default'   => '',
			'transport' => 'refresh',
		)
	);

	// Disvovery featured image Setting Control.
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'discovery_featured_image_control',
			array(
				'label'       => __( 'Discovery Featured image', 'aperabags' ),
				'section'     => 'discovery_section',
				'settings'    => 'discovery_featured_image',
				'type'        => 'media',
				'description' => 'Add image for featured image ',
			)
		)
	);

	// Discovery Title for Section Setting.
	$wp_customize->add_setting(
		'discovery_title',
		array(
			'default'   => '',
			'transport' => 'refresh',
		)
	);

	// Discovery Title for Section Setting Control.
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'discovery_title_control',
			array(
				'label'       => __( 'Discovery Title', 'aperabags' ),
				'section'     => 'discovery_section',
				'settings'    => 'discovery_title',
				'type'        => 'text',
				'description' => 'Discovery Title for Section',
			)
		)
	);

	// Discovery body for Section Setting.
	$wp_customize->add_setting(
		'discovery_body',
		array(
			'default'   => '',
			'transport' => 'refresh',
		)
	);

	// Discovery Body for Section Setting Control.
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'discovery_body_control',
			array(
				'label'       => __( 'Discovery Body', 'aperabags' ),
				'section'     => 'discovery_section',
				'settings'    => 'discovery_body',
				'type'        => 'textarea',
				'description' => 'Discovery Body for Section',
			)
		)
	);

	// Discovery cta text for Section Setting.
	$wp_customize->add_setting(
		'discovery_cta_text',
		array(
			'default'   => '',
			'transport' => 'refresh',
		)
	);

	// Discovery CTA text for Section Setting Control.
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'discovery_cta_text_control',
			array(
				'label'       => __( 'Discovery CTA Text', 'aperabags' ),
				'section'     => 'discovery_section',
				'settings'    => 'discovery_cta_text',
				'type'        => 'text',
				'description' => 'Discovery CTA Text for Section',
			)
		)
	);

	// Discovery cta link for Section Setting.
	$wp_customize->add_setting(
		'discovery_cta_link',
		array(
			'default'   => '',
			'transport' => 'refresh',
		)
	);

	// Discovery CTA link for Section Setting Control.
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'discovery_cta_link_control',
			array(
				'label'       => __( 'Discovery CTA link', 'aperabags' ),
				'section'     => 'discovery_section',
				'settings'    => 'discovery_cta_link',
				'type'        => 'dropdown-pages',
				'description' => 'Discovery CTA Link for Section',
			)
		)
	);

	 /**
	  * Shop settings Section
	  *
	  * @since  1.0.1
	  */
	$wp_customize->add_section(
		'shop_section',
		array(
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'priority'       => 10,
			'title'          => __( 'Shop Section', 'aperabags' ),
			'description'    => __( 'Shop Options version 1.0.1 - featured items are selected from the product options', 'aperabags' ),
			'panel'          => 'wonkasoft_theme_options',
		)
	);

	// Shop Title for Section Setting.
	$wp_customize->add_setting(
		'shop_title',
		array(
			'default'   => '',
			'transport' => 'refresh',
		)
	);

	// Shop Title for Section Setting Control.
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'shop_title_control',
			array(
				'label'       => __( 'Shop Title', 'aperabags' ),
				'section'     => 'shop_section',
				'settings'    => 'shop_title',
				'type'        => 'text',
				'description' => 'Shop Title for Section',
			)
		)
	);

	// Shop Subtitle for Section Setting.
	$wp_customize->add_setting(
		'shop_subtitle',
		array(
			'default'   => '',
			'transport' => 'refresh',
		)
	);

	// Shop Subtitle for Section Setting Control.
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'shop_subtitle_control',
			array(
				'label'       => __( 'Shop Subtitle', 'aperabags' ),
				'section'     => 'shop_section',
				'settings'    => 'shop_subtitle',
				'type'        => 'text',
				'description' => 'Shop Subtitle for Section',
			)
		)
	);

	 /**
	  * Our brand settings Section
	  *
	  * @since  1.0.1
	  */
	$wp_customize->add_section(
		'our_brand_section',
		array(
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'priority'       => 10,
			'title'          => __( 'Our Brand Section', 'aperabags' ),
			'description'    => __( 'Our brand Section Options version 1.0.1', 'aperabags' ),
			'panel'          => 'wonkasoft_theme_options',
		)
	);

	/**
	* Our Brand featured image Setting.
	*
	* @since  1.0.1
	*/
	$wp_customize->add_setting(
		'our_brand_featured_image',
		array(
			'default'   => '',
			'transport' => 'refresh',
		)
	);

	// Our Brand featured image Setting Control.
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'our_brand_featured_image_control',
			array(
				'label'       => __( 'Our Brand Featured image', 'aperabags' ),
				'section'     => 'our_brand_section',
				'settings'    => 'our_brand_featured_image',
				'type'        => 'media',
				'description' => 'Add image for featured image ',
			)
		)
	);

	 /**
	  * Our brand header settings Section
	  *
	  * @since  1.0.1
	  */

		// Our brand header
		$wp_customize->add_setting(
			'our_brand_title',
			array(
				'default'   => '',
				'transport' => 'refresh',
			)
		);

		// Our brand header Setting Control.
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'our_brand_title_control',
				array(
					'label'       => __( 'Our brand Title', 'aperabags' ),
					'section'     => 'our_brand_section',
					'settings'    => 'our_brand_title',
					'type'        => 'text',
					'description' => 'Our brand title.',
				)
			)
		);
		   // Our brand header
		$wp_customize->add_setting(
			'our_brand_body',
			array(
				'default'   => '',
				'transport' => 'refresh',
			)
		);

		   // Our brand header Setting Control.
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'our_brand_body_control',
				array(
					'label'       => __( 'Our brand body', 'aperabags' ),
					'section'     => 'our_brand_section',
					'settings'    => 'our_brand_body',
					'type'        => 'textarea',
					'description' => 'Our brand body',
				)
			)
		);

	// Our brand cta text for Section Setting.
	$wp_customize->add_setting(
		'our_brand_cta_text',
		array(
			'default'   => '',
			'transport' => 'refresh',
		)
	);

	// Our brand CTA text for Section Setting Control.
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'our_brand_cta_text_control',
			array(
				'label'       => __( 'Our Brand CTA Text', 'aperabags' ),
				'section'     => 'our_brand_section',
				'settings'    => 'our_brand_cta_text',
				'type'        => 'text',
				'description' => 'Our Brand CTA Text for Section',
			)
		)
	);

	// Our brand cta link for Section Setting.
	$wp_customize->add_setting(
		'our_brand_cta_link',
		array(
			'default'   => '',
			'transport' => 'refresh',
		)
	);

	// Our brand CTA link for Section Setting Control.
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'our_brand_cta_link_control',
			array(
				'label'       => __( 'Our Brand CTA link', 'aperabags' ),
				'section'     => 'our_brand_section',
				'settings'    => 'our_brand_cta_link',
				'type'        => 'dropdown-pages',
				'description' => 'Our Brand CTA Link for Section',
			)
		)
	);

	/**
	 * About subheader settings Section
	 *
	 * @since  1.0.0
	 */
	$wp_customize->add_setting(
		'about_the_brand_subheader',
		array(
			'default'   => '',
			'transport' => 'refresh',
		)
	);

	// About the brand subheader Setting Control.
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'about_the_brand_subheader_control',
			array(
				'label'       => __( 'About the brand subheader', 'aperabags' ),
				'section'     => 'about_section',
				'settings'    => 'about_the_brand_subheader',
				'type'        => 'text',
				'description' => 'About the brand subheader',
			)
		)
	);

	/**
	 * About the brand message settings Section
	 *
	 * @since  1.0.0
	 */
	$wp_customize->add_setting(
		'about_the_brand_message',
		array(
			'default'   => '',
			'transport' => 'refresh',
		)
	);

	// About the brand message Setting Control.
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'about_the_brand_message_control',
			array(
				'label'       => __( 'About the brand message', 'aperabags' ),
				'section'     => 'about_section',
				'settings'    => 'about_the_brand_message',
				'type'        => 'textarea',
				'description' => 'About the brand message',
			)
		)
	);

	/**
	 * About the brand embeded video placeholder settings Section
	 *
	 * @since  1.0.0
	 */
	$wp_customize->add_setting(
		'about_the_brand_video_placeholder',
		array(
			'default'   => '',
			'transport' => 'refresh',
		)
	);

	// About the brand embeded video placeholder Setting Control.
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'about_the_brand_video_placeholder_contol',
			array(
				'label'       => __( 'About the brand video placeholder', 'aperabags' ),
				'section'     => 'about_section',
				'settings'    => 'about_the_brand_video_placeholder',
				'type'        => 'media',
				'description' => 'Add placeholder image for video',
			)
		)
	);

	/**
	 * About the brand embeded video settings Section
	 *
	 * @since  1.0.0
	 */
	$wp_customize->add_setting(
		'about_the_brand_video',
		array(
			'default'   => '',
			'transport' => 'refresh',
		)
	);

	// About the brand embeded video Setting Control.
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'about_the_brand_video_control',
			array(
				'label'       => __( 'About the brand video', 'aperabags' ),
				'section'     => 'about_section',
				'settings'    => 'about_the_brand_video',
				'type'        => 'text',
				'description' => 'Add only the video id from YouTube: Example lifw9kAbMic',
			)
		)
	);

	/**
	 * About the brand button text settings Section
	 *
	 * @since  1.0.0
	 */
	$wp_customize->add_setting(
		'about_the_brand_btn_text',
		array(
			'default'   => '',
			'transport' => 'refresh',
		)
	);

	// About the brand button text Setting Control.
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'about_the_brand_btn_text_control',
			array(
				'label'       => __( 'About the brand message', 'aperabags' ),
				'section'     => 'about_section',
				'settings'    => 'about_the_brand_btn_text',
				'type'        => 'text',
				'description' => 'About the brand button text',
			)
		)
	);

	/**
	 *About the brand button Link settings Section
	 *
	 * @since  1.0.0
	 */
	$wp_customize->add_setting(
		'about_the_brand_button_link',
		array(
			'default'   => '',
			'transport' => 'refresh',
		)
	);

	// About the brand button Link Setting Control.
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'about_the_brand_button_link_control',
			array(
				'label'       => __( 'About the brand button', 'aperabags' ),
				'section'     => 'about_section',
				'settings'    => 'about_the_brand_button_link',
				'type'        => 'dropdown-pages',
				'description' => 'About the brand button link',
			)
		)
	);

	/**
	 * About the brand second image settings Section
	 *
	 * @since  1.0.0
	 */
	$wp_customize->add_setting(
		'about_the_brand_second_image',
		array(
			'default'   => '',
			'transport' => 'refresh',
		)
	);

	// About the brand second image Setting Control.
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'about_the_brand_second_image_control',
			array(
				'label'       => __( 'About the brand second image', 'aperabags' ),
				'section'     => 'about_section',
				'settings'    => 'about_the_brand_second_image',
				'type'        => 'media',
				'description' => 'About the brand second image',
			)
		)
	);

	/**
	 * Footer settings Section
	 *
	 * @since  1.0.0
	 */
	$wp_customize->add_section(
		'footer_section',
		array(
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'priority'       => 10,
			'title'          => __( 'Footer Section', 'aperabags' ),
			'description'    => __( 'Footer Section Options version 1.0.0', 'aperabags' ),
			'panel'          => 'wonkasoft_theme_options',
		)
	);

	/**
	 * Footer social title settings Section
	 *
	 * @since  1.0.0
	 */
	$wp_customize->add_setting(
		'footer_social_title',
		array(
			'default'   => '',
			'transport' => 'refresh',
		)
	);

	// Footer social Instagram Setting Control.
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'footer_social_title_control',
			array(
				'label'       => __( 'Footer Social Title', 'aperabags' ),
				'section'     => 'footer_section',
				'settings'    => 'footer_social_title',
				'type'        => 'text',
				'description' => 'Footer Social Title',
			)
		)
	);

	/**
	 * Footer social links settings Section
	 *
	 * @since  1.0.0
	 */
	$wp_customize->add_setting(
		'footer_social_instagram',
		array(
			'default'   => '',
			'transport' => 'refresh',
		)
	);

	// Footer social Instagram Setting Control.
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'footer_social_instagram_control',
			array(
				'label'       => __( 'Instagram Icon Link', 'aperabags' ),
				'section'     => 'footer_section',
				'settings'    => 'footer_social_instagram',
				'type'        => 'text',
				'description' => 'Example: https://instagram.com/user',
			)
		)
	);

	// Footer social Twitter link Setting.
	$wp_customize->add_setting(
		'footer_social_twitter',
		array(
			'default'   => '',
			'transport' => 'refresh',
		)
	);

	// Footer social Twitter Setting Control.
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'footer_social_twitter_control',
			array(
				'label'       => __( 'Twitter Icon Link', 'aperabags' ),
				'section'     => 'footer_section',
				'settings'    => 'footer_social_twitter',
				'type'        => 'text',
				'description' => 'Example: https://twitter.com/user',
			)
		)
	);

	// Footer social Facebook link Setting.
	$wp_customize->add_setting(
		'footer_social_facebook',
		array(
			'default'   => '',
			'transport' => 'refresh',
		)
	);

	// Footer social Facebook Setting Control.
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'footer_social_facebook_control',
			array(
				'label'       => __( 'Facebook Icon Link', 'aperabags' ),
				'section'     => 'footer_section',
				'settings'    => 'footer_social_facebook',
				'type'        => 'text',
				'description' => 'Example: https://facebook.com/user',
			)
		)
	);

	// Footer social Pinterest link Setting.
	$wp_customize->add_setting(
		'footer_social_pinterest',
		array(
			'default'   => '',
			'transport' => 'refresh',
		)
	);

	// Footer social Pinterest Setting Control.
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'footer_social_pinterest_control',
			array(
				'label'       => __( 'Pinterest Icon Link', 'aperabags' ),
				'section'     => 'footer_section',
				'settings'    => 'footer_social_pinterest',
				'type'        => 'text',
				'description' => 'Example: https://pinterest.com/user',
			)
		)
	);

	// Footer contact message Setting.
	$wp_customize->add_setting(
		'footer_insta_username',
		array(
			'default'   => '',
			'transport' => 'refresh',
		)
	);

	// Footer contact message Setting Control.
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'footer_insta_username_control',
			array(
				'label'       => __( 'Instagram Username', 'aperabags' ),
				'section'     => 'footer_section',
				'settings'    => 'footer_insta_username',
				'type'        => 'text',
				'description' => 'Example: @MYUSERNAME',
			)
		)
	);

	// Footer support email Setting.
	$wp_customize->add_setting(
		'footer_insta_username_link',
		array(
			'default'   => '',
			'transport' => 'refresh',
		)
	);

	// Footer support email Setting Control.
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'footer_insta_username_link_control',
			array(
				'label'       => __( 'Instagram link', 'aperabags' ),
				'section'     => 'footer_section',
				'settings'    => 'footer_insta_username_link',
				'type'        => 'text',
				'description' => 'Example: https://www.instagram.com/myusername/',
			)
		)
	);

		// Footer contact message Setting.
		$wp_customize->add_setting(
			'footer_insta_hashtags',
			array(
				'default'   => '',
				'transport' => 'refresh',
			)
		);

		// Footer contact message Setting Control.
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'footer_insta_hashtags_control',
				array(
					'label'       => __( 'Instgram Hashtag Page', 'aperabags' ),
					'section'     => 'footer_section',
					'settings'    => 'footer_insta_hashtags',
					'type'        => 'text',
					'description' => 'Example: #MYHASHTAG',
				)
			)
		);

		// Footer support email Setting.
		$wp_customize->add_setting(
			'footer_insta_hashtags_link',
			array(
				'default'   => '',
				'transport' => 'refresh',
			)
		);

		// Footer support email Setting Control.
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'footer_insta_hashtags_link_control',
				array(
					'label'       => __( 'Instagram Hashtag link', 'aperabags' ),
					'section'     => 'footer_section',
					'settings'    => 'footer_insta_hashtags_link',
					'type'        => 'text',
					'description' => 'Example: https://www.instagram.com/explore/tags/hashtaghere/',
				)
			)
		);

	for ( $i = 1; $i <= 5; $i++ ) :
		// Footer menu header Setting.
		$wp_customize->add_setting(
			'footer_menu_header_' . $i,
			array(
				'default'   => '',
				'transport' => 'refresh',
			)
		);

		// Footer menu header Setting Control.
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'footer_menu_header_' . $i . '_control',
				array(
					'label'       => 'Footer Menu Header ' . $i,
					'section'     => 'footer_section',
					'settings'    => 'footer_menu_header_' . $i,
					'type'        => 'text',
					'description' => 'Footer menu header ' . $i,
				)
			)
		);
	endfor;
	/**
	 * Footer logo settings Section
	 *
	 * @since  1.0.0
	 */
	$wp_customize->add_setting(
		'footer_logo',
		array(
			'default'   => '',
			'transport' => 'refresh',
		)
	);

	// Footer form shortcode Setting Control.
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'footer_logo_control',
			array(
				'label'       => __( 'Footer Logo', 'aperabags' ),
				'section'     => 'footer_section',
				'settings'    => 'footer_logo',
				'type'        => 'media',
				'description' => 'Footer Logo',
			)
		)
	);

	/**
	 * Footer form shortcode settings Section
	 *
	 * @since  1.0.0
	 */
	$wp_customize->add_setting(
		'footer_form_shortcode',
		array(
			'default'   => '',
			'transport' => 'refresh',
		)
	);

	// Footer form shortcode Setting Control.
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'footer_form_shortcode_control',
			array(
				'label'       => __( 'Footer Form Shortcode', 'aperabags' ),
				'section'     => 'footer_section',
				'settings'    => 'footer_form_shortcode',
				'type'        => 'text',
				'description' => 'Shortcode Example: [signupform]',
			)
		)
	);
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
	wp_enqueue_script( 'aperabags-customizer', esc_url( get_stylesheet_directory_uri() . '/inc/js/customizer.js' ), array( 'customize-preview' ), '20190819', true );
}
	add_action( 'customize_preview_init', 'apera_bags_customize_preview_js' );
