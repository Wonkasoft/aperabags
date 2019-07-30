<?php
/**
 * Apera Bags Theme Customizer
 *
 * @package apera-bags
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
				'selector'         => '.site-title a',
				'render_callback'  => 'apera_bags_customize_partial_blogname',
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
		'priority'        => 5,
		'capability'      => 'edit_theme_options',
		'theme_supports'  => '',
		'title'           => __( 'Apera Homepage Options', 'apera-bags' ),
		'description'     => __( 'Theme Settings', 'apera-bags' ),
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
	'title'          => __( 'Topbar Message Section', 'apera-bags' ),
	'description'    => __( 'Topbar Options version 1.0.0', 'apera-bags' ),
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

// Enable topbar message Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'enable_topbar_control', 
  array(
	'label'       => __( 'Topbar Message Option', 'apera-bags' ),
	'section'     => 'topbar_message_section',
	'settings'    => 'enable_topbar',
	'type'        => 'checkbox',
	'description' => 'Enable Topbar',
) ) );

/**
* Topbar color settings Section
* @since  1.0.0
*/
$wp_customize->add_setting( 'topbar_color' , array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// Topbar color Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'topbar_color_control', 
  array(
	'label'       => __( 'Topbar Color Option', 'apera-bags' ),
	'section'     => 'topbar_message_section',
	'settings'    => 'topbar_color',
	'type'        => 'color',
	'description' => 'Topbar color',
) ) );

/**
* Topbar message settings Section
* @since  1.0.0
*/
$wp_customize->add_setting( 'topbar_message' , array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// Topbar color Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'topbar_message_control', 
  array(
	'label'       => __( 'Topbar Message Option', 'apera-bags' ),
	'section'     => 'topbar_message_section',
	'settings'    => 'topbar_message',
	'type'        => 'text',
	'description' => 'Topbar message',
) ) );


/** 
* Slider settings Section
* @since  1.0.0
*/
$wp_customize->add_section( 'slider_section' , array(
  'capability'     => 'edit_theme_options',
  'theme_supports' => '',
  'priority'     => 10,
  'title'      => __( 'Top Slider Section', 'apera-bags' ),
  'description'  => __( 'Slider Options version 1.0.0', 'apera-bags' ),
  'panel'      => 'wonkasoft_theme_options',
) );

for ( $i=1; $i <= 5; $i++ ) : 

// Slider Setting
  $wp_customize->add_setting( 'slider_'.$i, array(
	'default'           => '',
	'transport'         => 'refresh',
) );

// Slider Setting Control
  $wp_customize->add_control( new WP_Customize_Media_Control( 
	$wp_customize, 
	'slider_'.$i.'_control', 
	array(
	  'label'       => __( 'Slider Image '.$i, 'apera-bags' ),
	  'section'     => 'slider_section',
	  'settings'    => 'slider_'.$i,
	  'type'      => 'image',
	  'description' => 'Add image for slider '.$i,
  ) ) );

/** 
* Slider message position settings Section
* @since  1.0.0
*/
$wp_customize->add_setting( 'slider_text_position_'.$i, array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// Slider message position Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'slider_text_position_'.$i.'_control', 
  array(
	'label'       => __( 'Slider message position', 'apera-bags' ),
	'section'     => 'slider_section',
	'settings'    => 'slider_text_position_'.$i,
	'description' => 'Text alignment '.$i,
	'type'      => 'select',
	'choices' => array(
	  'left' => 'left',
	  'center' => 'center',
	  'right' => 'right',
  )
) ) );

/**
* Slider header message settings Section
* @since  1.0.0
*/
$wp_customize->add_setting( 'slider_header_'.$i, array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// Slider header message Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'slider_header_'.$i.'_control', 
  array(
	'label'       => __( 'Slider header message', 'apera-bags' ),
	'section'     => 'slider_section',
	'settings'    => 'slider_header_'.$i,
	'type'        => 'text',
	'description' => 'Add message for slider '.$i,
) ) );

/**
* Slider subheader message settings Section
* @since  1.0.0
*/
$wp_customize->add_setting( 'slider_subheader_'.$i, array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// Slider subheader message Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'slider_subheader_'.$i.'_control', 
  array(
	'label'       => __( 'Slider subheader', 'apera-bags' ),
	'section'     => 'slider_section',
	'settings'    => 'slider_subheader_'.$i,
	'type'        => 'text',
	'description' => 'Add subheader for slider '.$i,
) ) );

/**
* Slider button text settings Section
* @since  1.0.0
*/
$wp_customize->add_setting( 'slider_btn_text_'.$i, array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// Slider button text Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'slider_btn_text_'.$i.'_control', 
  array(
	'label'       => __( 'Slider button text', 'apera-bags' ),
	'section'     => 'slider_section',
	'settings'    => 'slider_btn_text_'.$i,
	'type'        => 'text',
	'description' => 'Button text for slider'.$i,
) ) );

/**
* Slider link or page settings Section
* @since  1.0.0
*/
$wp_customize->add_setting( 'slider_btn_link_' .$i, array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// Slider link or page Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'slider_btn_link_'.$i.'_control', 
  array(
	'label'       => __( 'Slider Button Link', 'apera-bags' ),
	'section'     => 'slider_section',
	'settings'    => 'slider_btn_link_'.$i,
	'type'        => 'dropdown-pages',
	'description' => 'Slider button link',
) ) );

// Slider Mobile Setting
  $wp_customize->add_setting( 'slider_mobile_'.$i, array(
	'default'           => '',
	'transport'         => 'refresh',
) );

// Slider Mobile Setting Control
  $wp_customize->add_control( new WP_Customize_Image_Control( 
	$wp_customize, 
	'slider_mobile_'.$i.'_control', 
	array(
	  'label'       => __( 'Slider Mobile Image '.$i, 'apera-bags' ),
	  'section'     => 'slider_section',
	  'settings'    => 'slider_mobile_'.$i,
	  'type'        => 'image',
	  'description' => 'Add image for slider '.$i,
  ) ) );

endfor;

/**
* Shop settings Section
* @since  1.0.0
*/
$wp_customize->add_section( 'shop_section' , array(
  'capability'     => 'edit_theme_options',
  'theme_supports' => '',
  'priority'     => 10,
  'title'      => __( 'Shop Section', 'apera-bags' ),
  'description'  => __( 'Shop Options version 1.0.0', 'apera-bags' ),
  'panel'      => 'wonkasoft_theme_options',
) );

// Shop Title for Section Setting
$wp_customize->add_setting( 'shop_title', array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// Shop Title for Section Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'shop_title_control', 
  array(
	'label'       => __( 'Shop Title', 'apera-bags' ),
	'section'     => 'shop_section',
	'settings'    => 'shop_title',
	'type'      => 'text',
	'description' => 'Shop Title for Section',
) ) );

// Shop background image Setting
$wp_customize->add_setting( 'shop_background_image', array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// Shop background image Setting Control
$wp_customize->add_control( new WP_Customize_Image_Control( 
  $wp_customize, 
  'shop_background_image_control', 
  array(
	'label'       => __( 'Shop background image', 'apera-bags' ),
	'section'     => 'shop_section',
	'settings'    => 'shop_background_image',
	'type'      => 'image',
	'description' => 'Add image for shop background ',
) ) );

/**
* Enable sale banner settings Section
* @since  1.0.0
*/
$wp_customize->add_setting( 'enable_sale_banner' , array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// Enable sale banner Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'enable_sale_banner_control', 
  array(
	'label'       => __( 'Enable Sale Banner', 'apera-bags' ),
	'section'     => 'shop_section',
	'settings'    => 'enable_sale_banner',
	'type'        => 'checkbox',
	'description' => 'Enable sale banner',
) ) );

/**
* Shop options for product per row settings Section
* @since  1.0.0
*/
$wp_customize->add_setting( 'shop_product_per_row', array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// Shop option Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'shop_product_per_row_control', 
  array(
	'label'       => __( 'Product per row', 'apera-bags' ),
	'section'     => 'shop_section',
	'settings'    => 'shop_product_per_row',
	'description' => 'How many products per row?',
	'type'      => 'select',
	'choices' => array(
	  '2' => '2',
	  '3' => '3',
	  '4' => '4',
	  '5' => '5',
  )
) ) );

/**
* Shop options for number of products settings Section
* @since  1.0.0
*/
$wp_customize->add_setting( 'shop_num_of_products', array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// Shop for number of products option Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'shop_num_of_products_control', 
  array(
	'label'       => __( 'Total products to show', 'apera-bags' ),
	'section'     => 'shop_section',
	'settings'    => 'shop_num_of_products',
	'description' => 'How many products to show?',
	'type'      => 'select',
	'choices' => array(
	  '3' => '3',
	  '4' => '4',
	  '5' => '5',
	  '6' => '6',
	  '7' => '7',
	  '8' => '8',
	  '9' => '9',
  )
) ) );

/**
* Large CTA settings Section
* @since  1.0.0
*/
$wp_customize->add_section( 'lg_cta_section' , array(
  'capability'     => 'edit_theme_options',
  'theme_supports' => '',
  'priority'     => 10,
  'title'      => __( 'Large CTA Section', 'apera-bags' ),
  'description'  => __( 'Large CTA Options version 1.0.0', 'apera-bags' ),
  'panel'      => 'wonkasoft_theme_options',
) );

/**
* Loop for all sliders and options
* @since 1.0.0
*/
for ( $i=1; $i <= 5; $i++ ) : 

// Slider Setting
  $wp_customize->add_setting( 'cta_slider_'.$i , array(
	'default'           => '',
	'transport'         => 'refresh',
) );

// Slider Setting Control
  $wp_customize->add_control( new WP_Customize_Media_Control( 
	$wp_customize, 
	'cta_slider_'.$i.'_control', 
	array(
	  'label'       => __( 'Slider Image '.$i, 'apera-bags' ),
	  'section'     => 'lg_cta_section',
	  'settings'    => 'cta_slider_'.$i,
	  'type'      => 'image',
	  'description' => 'Add image for slider '.$i,
  ) ) );

/** 
* Slider message position settings Section
* @since  1.0.0
*/
$wp_customize->add_setting( 'cta_slider_text_position_'.$i , array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// Slider message position Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'cta_slider_text_position_'.$i.'_control', 
  array(
	'label'       => __( 'Slider message position '.$i, 'apera-bags' ),
	'section'     => 'lg_cta_section',
	'settings'    => 'cta_slider_text_position_'.$i,
	'description' => 'Text alignment '.$i,
	'type'      => 'select',
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
  'default'           => '',
  'transport'         => 'refresh',
) );

// Slider message Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'cta_slider_text_'.$i.'_control', 
  array(
	'label'       => __( 'Slider message '.$i, 'apera-bags' ),
	'section'     => 'lg_cta_section',
	'settings'    => 'cta_slider_text_'.$i,
	'type'        => 'text',
	'description' => 'Add message for slider '.$i,
) ) );

/**
* CTA Slider button text settings Section
* @since  1.0.0
*/
$wp_customize->add_setting( 'cta_slider_btn_text_'.$i , array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// Slider button text Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'cta_slider_btn_text_'.$i.'_control', 
  array(
	'label'       => __( 'CTA Button Text '.$i, 'apera-bags' ),
	'section'     => 'lg_cta_section',
	'settings'    => 'cta_slider_btn_text_'.$i,
	'type'        => 'text',
	'description' => 'CTA Button Text '.$i,
) ) );

/**
* CTA Slider link settings Section
* @since  1.0.0
*/
$wp_customize->add_setting( 'cta_slider_btn_link_'.$i , array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// CTA Slider link Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'cta_slider_btn_link_'.$i.'_control', 
  array(
	'label'       => __( 'CTA Button Link '.$i, 'apera-bags' ),
	'section'     => 'lg_cta_section',
	'settings'    => 'cta_slider_btn_link_'.$i,
	'type'        => 'dropdown-pages',
	'description' => 'CTA Button Link '.$i,
) ) );

// CTA Slider mobile Setting
  $wp_customize->add_setting( 'cta_slider_mobile_'.$i , array(
	'default'           => '',
	'transport'         => 'refresh',
) );

// CTA Slider mobile Setting Control
  $wp_customize->add_control( new WP_Customize_Image_Control( 
	$wp_customize, 
	'cta_slider_mobile_'.$i.'_control', 
	array(
	  'label'       => __( 'CTA Slider Mobile Image '.$i, 'apera-bags' ),
	  'section'     => 'lg_cta_section',
	  'settings'    => 'cta_slider_mobile_'.$i,
	  'type'        => 'image',
	  'description' => 'Add image for mobile slider '.$i,
  ) ) );

endfor;

/**
* Our Cause / About Us settings Section
* @since  1.0.0
*/
$wp_customize->add_section( 'cause_section' , array(
  'capability'     => 'edit_theme_options',
  'theme_supports' => '',
  'priority'     => 10,
  'title'      => __( 'Our Cause Section', 'apera-bags' ),
  'description'  => __( 'Cause Section Options version 1.0.0', 'apera-bags' ),
  'panel'      => 'wonkasoft_theme_options',
) );

/**
* Cause section header settings Section
* @since  1.0.0
*/
$wp_customize->add_setting( 'cause_section_title', array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// Cause section header Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'cause_section_title_control', 
  array(
	'label'       => __( 'Section Title', 'apera-bags' ),
	'section'     => 'cause_section',
	'settings'    => 'cause_section_title',
	'type'      => 'text',
	'description' => 'Add section header for cause',
) ) );

/**
* Cause section background settings Section
* @since  1.0.0
*/
$wp_customize->add_setting( 'cause_section_background', array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// Cause section background Setting Control
$wp_customize->add_control( new WP_Customize_Image_Control( 
  $wp_customize, 
  'cause_section_background_control', 
  array(
	'label'       => __( 'Section background image', 'apera-bags' ),
	'section'     => 'cause_section',
	'settings'    => 'cause_section_background',
	'type'      => 'image',
	'description' => 'Add section background image for cause',
) ) );

// Array for Product links using query
$args = array(
  'post_type' => 'product',
  'post_per_page' => -1,
  'ignore_sticky_posts' => 0,
);
$the_query = new WP_Query( $args );
$products = array();

if ($the_query->have_posts()) 
{
  while ($the_query->have_posts()){
    $the_query->the_post();
    $products[get_the_ID()] = get_the_title();
  }
}
/**
* Loop for all items and options
* @since 1.0.0
*/
for ( $i=1; $i <= 3; $i++ ) : 

// Cause Option Setting
  $wp_customize->add_setting( 'cause_image_'.$i , array(
	'default'           => '',
	'transport'         => 'refresh',
) );

// Cause Option Control
  $wp_customize->add_control( new WP_Customize_Image_Control( 
	$wp_customize, 
	'cause_image_'.$i.'_control', 
	array(
	  'label'       =>'Image for cause '.$i,
	  'section'     => 'cause_section',
	  'settings'    => 'cause_image_'.$i,
	  'type'        => 'image',
	  'description' => 'Add image for cause '.$i,
  ) ) );

/**
* Cause section image link settings Section
* @since  1.0.0
* @author Carlos
*/
$wp_customize->add_setting( 
  'cause_image_link_' . $i, 
  array(
  'default'           => '0',
  'transport'         => 'refresh',
) );

// About the brand button Link Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'cause_image_link_' . $i . '_control', 
  array(
	'label'       => 'Cause image link' . $i,
	'section'     => 'cause_section',
	'settings'    => 'cause_image_link_' . $i,
	'type'        => 'select',
  'description' => 'Image link',
  'choices'     => $products,
) ) );

/** 
* Cause message position settings Section
* @since  1.0.0
*/
$wp_customize->add_setting( 'cause_message_position_'.$i, array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// Cause message position Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'cause_message_position_'.$i.'_control', 
  array(
	'label'       => __( 'Cause message position '.$i, 'apera-bags' ),
	'section'     => 'cause_section',
	'settings'    => 'cause_message_position_'.$i,
	'description' => 'Text alignment '.$i,
	'type'      => 'select',
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
$wp_customize->add_setting( 'cause_header_'.$i, array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// Cause message Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'cause_header_'.$i.'_control', 
  array(
	'label'       => __( 'Cause header '.$i, 'apera-bags' ),
	'section'     => 'cause_section',
	'settings'    => 'cause_header_'.$i,
	'type'        => 'text',
	'description' => 'Add header for cause '.$i,
) ) );

/**
* Cause message settings Section
* @since  1.0.0
*/
$wp_customize->add_setting( 'cause_message_'.$i, array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// Cause message Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'cause_message_'.$i.'_control', 
  array(
	'label'       => __( 'Cause message '.$i, 'apera-bags' ),
	'section'     => 'cause_section',
	'settings'    => 'cause_message_'.$i,
	'type'        => 'textarea',
	'description' => 'Add message for cause '.$i,
) ) );
endfor;

/**
* Cause video modal settings Section
* @since  1.0.0
*/
$wp_customize->add_setting( 'cause_modal_video', array(
  'default'		=> '',
  'transport'   => 'refresh',
) );

// Cause video modal Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'cause_modal_video_control', 
  array(
	'label'       => __( 'Cause modal video', 'apera-bags' ),
	'section'     => 'cause_section',
	'settings'    => 'cause_modal_video',
	'type'        => 'text',
	'description' => 'Add video for cause modal',
) ) );

/**
* About the brand settings Section
* @since  1.0.0
*/
$wp_customize->add_section( 'about_section' , array(
  'capability'     => 'edit_theme_options',
  'theme_supports' => '',
  'priority'     => 10,
  'title'      => __( 'About the Brand Section', 'apera-bags' ),
  'description'  => __( 'About the brand Section Options version 1.0.0', 'apera-bags' ),
  'panel'      => 'wonkasoft_theme_options',
) );

/**
* About the brand header settings Section
* @since  1.0.0
*/
$wp_customize->add_setting( 'about_the_brand_header' , array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// About the brand header Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'about_the_brand_header_control', 
  array(
	'label'       => __( 'About the brand header', 'apera-bags' ),
	'section'     => 'about_section',
	'settings'    => 'about_the_brand_header',
	'type'      => 'text',
	'description' => 'About the brand header',
) ) );

/**
* About subheader settings Section
* @since  1.0.0
*/
$wp_customize->add_setting( 'about_the_brand_subheader', array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// About the brand subheader Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'about_the_brand_subheader_control', 
  array(
	'label'       => __( 'About the brand subheader', 'apera-bags' ),
	'section'     => 'about_section',
	'settings'    => 'about_the_brand_subheader',
	'type'      => 'text',
	'description' => 'About the brand subheader',
) ) );

/**
* About the brand message settings Section
* @since  1.0.0
*/
$wp_customize->add_setting( 'about_the_brand_message', array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// About the brand message Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'about_the_brand_message_control', 
  array(
	'label'       => __( 'About the brand message', 'apera-bags' ),
	'section'     => 'about_section',
	'settings'    => 'about_the_brand_message',
	'type'      => 'textarea',
	'description' => 'About the brand message',
) ) );

	/**
	* About the brand embeded video placeholder settings Section
	* @since  1.0.0
	*/
	$wp_customize->add_setting( 'about_the_brand_video_placeholder', array(
	  'default'           => '',
	  'transport'         => 'refresh',
	) );

	// About the brand embeded video placeholder Setting Control
	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize,
		'about_the_brand_video_placeholder_contol',
		array(
			'label'       => __( 'About the brand video placeholder', 'apera-bags' ),
			'section'     => 'about_section',
			'settings'    => 'about_the_brand_video_placeholder',
			'type'        => 'image',
			'description' => 'Add placeholder image for video'
		)
	) );

/**
* About the brand embeded video settings Section
* @since  1.0.0
*/
$wp_customize->add_setting( 'about_the_brand_video', array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// About the brand embeded video Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'about_the_brand_video_control', 
  array(
	'label'       => __( 'About the brand video', 'apera-bags' ),
	'section'     => 'about_section',
	'settings'    => 'about_the_brand_video',
	'type'      => 'text',
	'description' => 'Add only the video id from YouTube: Example lifw9kAbMic',
) ) );

/**
* About the brand button text settings Section
* @since  1.0.0
*/
$wp_customize->add_setting( 'about_the_brand_btn_text', array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// About the brand button text Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'about_the_brand_btn_text_control', 
  array(
	'label'       => __( 'About the brand message', 'apera-bags' ),
	'section'     => 'about_section',
	'settings'    => 'about_the_brand_btn_text',
	'type'      => 'text',
	'description' => 'About the brand button text',
) ) );

/**
* About the brand button Link settings Section
* @since  1.0.0
*/
$wp_customize->add_setting( 'about_the_brand_button_link', array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// About the brand button Link Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'about_the_brand_button_link_control', 
  array(
	'label'       => __( 'About the brand button', 'apera-bags' ),
	'section'     => 'about_section',
	'settings'    => 'about_the_brand_button_link',
	'type'        => 'dropdown-pages',
	'description' => 'About the brand button link',
) ) );


/**
* About the brand second image settings Section
* @since  1.0.0
*/
$wp_customize->add_setting( 
  'about_the_brand_second_image', 
  array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// About the brand second image Setting Control
$wp_customize->add_control( new WP_Customize_Image_Control( 
  $wp_customize, 
  'about_the_brand_second_image_control', 
  array(
	'label'       => __( 'About the brand second image', 'apera-bags' ),
	'section'     => 'about_section',
	'settings'    => 'about_the_brand_second_image',
	'type'      => 'image',
	'description' => 'About the brand second image',
) ) );

/**
* About the brand second image link settings Section
* @since  1.0.0
* @author Carlos
*/
$wp_customize->add_setting( 
  'about_the_brand_second_image_link', 
  array(
  'default'           => '0',
  'transport'         => 'refresh',
) );

// About the brand button Link Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'about_the_brand_second_image_link_control', 
  array(
	'label'       => __( 'About the brand image link', 'apera-bags' ),
	'section'     => 'about_section',
	'settings'    => 'about_the_brand_second_image_link',
	'type'        => 'select',
  'description' => 'About the brand button link',
  'choices'     => $products,
) ) );

/**
* Social settings Section
* @since  1.0.0
*/
// Adding customizer section for Social settings section
$wp_customize->add_section( 'social_section' , array(
  'capability'     => 'edit_theme_options',
  'theme_supports' => '',
  'priority'     => 10,
  'title'      => __( 'Social Section', 'apera-bags' ),
  'description'  => __( 'Social Section Options version 1.0.0', 'apera-bags' ),
  'panel'      => 'wonkasoft_theme_options',
) );

/**
* Social section header settings Section
* @since  1.0.0
*/
$wp_customize->add_setting( 'social_section_title' , array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// Social section header Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'social_section_title_control', 
  array(
	'label'       => __( 'Social Section Title', 'apera-bags' ),
	'section'     => 'social_section',
	'settings'    => 'social_section_title',
	'type'      => 'text',
	'description' => 'Social Section Title',
) ) );

/**
* Social section message settings Section
* @since  1.0.0
*/
$wp_customize->add_setting( 'social_section_message' , array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// Social section header Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'social_section_message_control', 
  array(
	'label'       => __( 'Social Section Title', 'apera-bags' ),
	'section'     => 'social_section',
	'settings'    => 'social_section_message',
	'type'        => 'textarea',
	'description' => 'Social Section Message',
) ) );

/**
* Social shortcode settings Section
* @since  1.0.0
*/
$wp_customize->add_setting( 'social_shortcode', array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// Social shortcode Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'social_shortcode_control', 
  array(
	'label'       => __( 'Social Shortcode', 'apera-bags' ),
	'section'     => 'social_section',
	'settings'    => 'social_shortcode',
	'type'      => 'text',
	'description' => 'Shortcode Example: [instagram]',
) ) );

/**
* Social button text settings Section
* @since  1.0.0
*/
$wp_customize->add_setting( 'social_btn_text', array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// Social button text Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'social_btn_text_control', 
  array(
	'label'       => __( 'Social Button Text', 'apera-bags' ),
	'section'     => 'social_section',
	'settings'    => 'social_btn_text',
	'type'      => 'text',
	'description' => 'Social Button Text',
) ) );

/**
* Social shop button  settings Section
* @since  1.0.0
*/
$wp_customize->add_setting( 'social_shop_button', array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// Social shop button Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'social_shop_button_control', 
  array(
	'label'       => __( 'Social Shop Button', 'apera-bags' ),
	'section'     => 'social_section',
	'settings'    => 'social_shop_button',
	'type'      => 'dropdown-pages',
	'description' => 'Social Shop Button choose the destination page',
) ) );

/**
* Footer settings Section
* @since  1.0.0
*/
$wp_customize->add_section( 'footer_section', array(
  'capability'     => 'edit_theme_options',
  'theme_supports' => '',
  'priority'     => 10,
  'title'      => __( 'Footer Section', 'apera-bags' ),
  'description'  => __( 'Footer Section Options version 1.0.0', 'apera-bags' ),
  'panel'      => 'wonkasoft_theme_options',
) );

/**
* Footer social title settings Section
* @since  1.0.0
*/
$wp_customize->add_setting( 'footer_social_title' , array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// Footer social Instagram Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'footer_social_title_control', 
  array(
	'label'       => __( 'Footer Social Title', 'apera-bags' ),
	'section'     => 'footer_section',
	'settings'    => 'footer_social_title',
	'type'      => 'text',
	'description' => 'Footer Social Title',
) ) );

/**
* Footer social links settings Section
* @since  1.0.0
*/
$wp_customize->add_setting( 'footer_social_instagram', array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// Footer social Instagram Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'footer_social_instagram_control', 
  array(
	'label'       => __( 'Instagram Icon Link', 'apera-bags' ),
	'section'     => 'footer_section',
	'settings'    => 'footer_social_instagram',
	'type'      => 'text',
	'description' => 'Example: https://instagram.com/user',
) ) );

// Footer social Twitter link Setting
$wp_customize->add_setting( 'footer_social_twitter', array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// Footer social Twitter Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'footer_social_twitter_control', 
  array(
	'label'       => __( 'Twitter Icon Link', 'apera-bags' ),
	'section'     => 'footer_section',
	'settings'    => 'footer_social_twitter',
	'type'      => 'text',
	'description' => 'Example: https://twitter.com/user',
) ) );

// Footer social Facebook link Setting
$wp_customize->add_setting( 'footer_social_facebook', array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// Footer social Facebook Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'footer_social_facebook_control', 
  array(
	'label'       => __( 'Facebook Icon Link', 'apera-bags' ),
	'section'     => 'footer_section',
	'settings'    => 'footer_social_facebook',
	'type'      => 'text',
	'description' => 'Example: https://facebook.com/user',
) ) );

// Footer social Pinterest link Setting
$wp_customize->add_setting( 'footer_social_pinterest', array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// Footer social Pinterest Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'footer_social_pinterest_control', 
  array(
	'label'       => __( 'Pinterest Icon Link', 'apera-bags' ),
	'section'     => 'footer_section',
	'settings'    => 'footer_social_pinterest',
	'type'      => 'text',
	'description' => 'Example: https://pinterest.com/user',
) ) );

// Footer contact message Setting
$wp_customize->add_setting( 'footer_contact_message', array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// Footer contact message Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'footer_contact_message_control', 
  array(
	'label'       => __( 'Contact message', 'apera-bags' ),
	'section'     => 'footer_section',
	'settings'    => 'footer_contact_message',
	'type'      => 'text',
	'description' => 'Example: Contact Customer Service',
) ) );

// Footer support email Setting
$wp_customize->add_setting( 'footer_contact_support_email' , array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// Footer support email Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'footer_contact_support_email_control', 
  array(
	'label'       => __( 'Contact support email', 'apera-bags' ),
	'section'     => 'footer_section',
	'settings'    => 'footer_contact_support_email',
	'type'      => 'text',
	'description' => 'Example: support@domain.com',
) ) );

for ( $i=1; $i <= 5; $i++ ) : 
// Footer menu header Setting
  $wp_customize->add_setting( 'footer_menu_header_'.$i, array(
	'default'           => '',
	'transport'         => 'refresh',
) );

// Footer menu header Setting Control
  $wp_customize->add_control( new WP_Customize_Control( 
	$wp_customize, 
	'footer_menu_header_'.$i.'_control', 
	array(
	  'label'       => __( 'Footer Menu Header '.$i, 'apera-bags' ),
	  'section'     => 'footer_section',
	  'settings'    => 'footer_menu_header_'.$i,
	  'type'      => 'text',
	  'description' => 'Footer menu header '.$i,
  ) ) );
endfor;
/**
* Footer logo settings Section
* @since  1.0.0
*/
$wp_customize->add_setting( 'footer_logo' , array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// Footer form shortcode Setting Control
$wp_customize->add_control( new WP_Customize_Image_Control( 
  $wp_customize, 
  'footer_logo_control', 
  array(
	'label'       => __( 'Footer Logo', 'apera-bags' ),
	'section'     => 'footer_section',
	'settings'    => 'footer_logo',
	'type'      => 'image',
	'description' => 'Footer Logo',
) ) );

/**
* Footer form shortcode settings Section
* @since  1.0.0
*/
$wp_customize->add_setting( 'footer_form_shortcode' , array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// Footer form shortcode Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'footer_form_shortcode_control', 
  array(
	'label'       => __( 'Footer Form Shortcode', 'apera-bags' ),
	'section'     => 'footer_section',
	'settings'    => 'footer_form_shortcode',
	'type'      => 'text',
	'description' => 'Shortcode Example: [signupform]',
) ) );

/**
* Newsletter message settings Section
*
* @since  1.0.0
*/
$wp_customize->add_section(
  'newsletter_popup_section',
  array(
  'capability'     => 'edit_theme_options',
  'theme_supports' => '',
  'priority'       => 20,
  'title'          => __( 'Newsletter Popup Section', 'apera-bags' ),
  'description'    => __( 'Newsletter Popup Options version 1.0.0', 'apera-bags' ),
  'panel'          => 'wonkasoft_theme_options',
)
);

/**
* Enable Newsletter message settings
* 
* @since  1.0.0
*/
$wp_customize->add_setting(
  'enable_newsletter_popup',
  array(
  'default'   => '',
  'transport' => 'refresh',
)
);

// Enable newsletter message Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'enable_newsletter_popup_control', 
  array(
  'label'       => __( 'Newsletter Popup Message Option', 'apera-bags' ),
  'section'     => 'newsletter_popup_section',
  'settings'    => 'enable_newsletter_popup',
  'type'        => 'checkbox',
  'description' => 'Enable Newsletter Popup',
) ) );

/**
* Newsletter text message settings
*
* @since  1.0.0
*/
$wp_customize->add_setting(
  'newsletter_popup_message_text',
  array(
  'default'   => '',
  'transport' => 'refresh',
)
);

// Newsletter text message Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'newsletter_popup_message_control', 
  array(
  'label'       => __( 'Newsletter Popup Message Text', 'apera-bags' ),
  'section'     => 'newsletter_popup_section',
  'settings'    => 'newsletter_popup_message_text',
  'type'        => 'text',
  'description' => 'Text that you want in the newsletter Popup',
) ) );

/**
* Newsletter image settings Section
* 
* @since  1.0.0
*/
$wp_customize->add_setting( 
  'newsletter_background_image', 
  array(
  'default'           => '',
  'transport'         => 'refresh',
) );

// Newsletter image Setting Control
$wp_customize->add_control( new WP_Customize_Image_Control( 
  $wp_customize, 
  'newsletter_background_image_control', 
  array(
  'label'       => __( 'Newsletter Background Image', 'apera-bags' ),
  'section'     => 'newsletter_popup_section',
  'settings'    => 'newsletter_background_image',
  'type'        => 'image',
  'description' => 'Setting for a background image of popup.',
) ) );

/**
* Newsletter image settings Section
* 
* @since  1.0.0
*/
$wp_customize->add_setting( 
  'newsletter_background_color', 
  array(
  'default'           => 'transparent',
  'transport'         => 'refresh',
) );

// Newsletter image Setting Control
$wp_customize->add_control( new WP_Customize_Image_Control( 
  $wp_customize, 
  'newsletter_background_color_control', 
  array(
  'label'       => __( 'Newsletter Background Color', 'apera-bags' ),
  'section'     => 'newsletter_popup_section',
  'settings'    => 'newsletter_background_color',
  'type'        => 'color',
  'description' => 'Setting for a background color if no image is selected.',
) ) );

/*====================================================================================================
=            This is for the integration of gravity forms for the themes newsletter popup            =
====================================================================================================*/
/**
* Newsletter form select settings
*
* @since  1.0.0
*/
$wp_customize->add_setting(
  'newsletter_popup_form_select',
  array(
  'default'   => '0',
  'transport' => 'refresh',
)
);

$forms_list = array( '0' => 'Please Select a Form' );
if ( class_exists( 'GFAPI' ) ) :
  $gforms_forms = GFAPI::get_forms();
  foreach ( $gforms_forms as $form ) {
    $forms_list[$form['id']] = $form['title'];
  }
endif;
// Newsletter form selection Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'newsletter_popup_form_select_control', 
  array(
  'label'       => __( 'Newsletter Popup form selection', 'apera-bags' ),
  'section'     => 'newsletter_popup_section',
  'settings'    => 'newsletter_popup_form_select',
  'type'        => 'select',
  'choices'     => $forms_list,
  'description' => 'Select form that you want to use in the newsletter Popup',
) ) );
/*=====  End of This is for the integration of gravity forms for the themes newsletter popup  ======*/

/**
* Newsletter session length settings
*
* @since  1.0.0
*/
$wp_customize->add_setting(
  'newsletter_popup_message_session_length',
  array(
  'default'   => '24',
  'transport' => 'refresh',
)
);

// Newsletter session length Setting Control
$wp_customize->add_control( new WP_Customize_Control( 
  $wp_customize, 
  'newsletter_popup_message_session_length_control', 
  array(
  'label'       => __( 'Newsletter Popup Session Length', 'apera-bags' ),
  'section'     => 'newsletter_popup_section',
  'settings'    => 'newsletter_popup_message_session_length',
  'type'        => 'number',
  'description' => 'Hours to reset the popup when a user dismisses it. logged in users will not see it unless they are not opted in.',
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
