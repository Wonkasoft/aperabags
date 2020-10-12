<?php
/**
 * Apera Bags functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package aperabags
 */

define( 'REFERSION_AFFILIATES_DATABASE_VERSION', '1.0.0' );

if ( ! function_exists( 'apera_bags_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function apera_bags_setup() {
		add_filter( 'woocommerce_get_cart_url', 'wonkasoft_woocommerce_get_cart_url' );

		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Apera Bags, use a find and replace
		 * to change 'apera-bags' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'apera-bags', get_stylesheet_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		$footer_section = get_section_mods( 'footer_section' );
		$footer_section = $footer_section->footer_section;

		$menus_array = array(
			'menu-primary' => esc_html__( 'Primary', 'aperabags' ),
			'menu-cart'    => esc_html__( 'Cart', 'aperabags' ),
		);

		foreach ( $footer_section->footer_titles as $title_number => $title ) {
			if ( 'count' !== $title_number ) :
				$new_menu                 = 'menu-' . preg_replace( '/ /', '-', strtolower( $title ) );
				$menus_array[ $new_menu ] = esc_html( 'Footer ' . ucfirst( strtolower( $title ) ), 'aperabags' );
			endif;
		}
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( $menus_array );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'apera_bags_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		/**
		 * Add Varient to media uploader
		 *
		 * @param array  $form_fields array, fields to include in attachment form.
		 * @param object $post attachment record in database.
		 * @return $form_fields modified form fields.
		 */
		function ws_attachment_field_variant( $form_fields, $post ) {
			$form_value                  = ( get_post_meta( $post->ID, 'ws_variant_name', true ) ) ? get_post_meta( $post->ID, 'ws_variant_name', true ) : '';
			$form_fields['variant-name'] = array(
				'label' => 'Variant',
				'input' => 'text',
				'value' => $form_value,
				'helps' => 'Input variant name',
			);

			return $form_fields;
		}

		add_filter( 'attachment_fields_to_edit', 'ws_attachment_field_variant', 10, 2 );

		/**
		 * Save values of Varient to media uploader
		 *
		 * @param array $post the post data for database.
		 * @param array $attachment attachment fields from $_POST form.
		 * @return array $post modified post data.
		 */
		function ws_attachment_field_variant_save( $post, $attachment ) {
			if ( isset( $attachment['variant-name'] ) ) {
				update_post_meta( $post['ID'], 'ws_variant_name', $attachment['variant-name'] );
			}

			return $post;
		}

		add_filter( 'attachment_fields_to_save', 'ws_attachment_field_variant_save', 10, 2 );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		/**
		 * This is for jpeg quality adjustment for faster image parsing.
		 *
		 * @since 1.0.0
		 */
		add_filter(
			'jpeg_quality',
			function ( $arg ) {
				return 60;
			}
		);

		/**
		 * This is for custom image sizes for faster image parsing.
		 *
		 * @since 1.0.0
		 */
		add_image_size( 'custom_products_size', 370, 550, false );
		add_image_size( 'cart_products_size', 75, 115, false );

		/**
		 * This class can be used to load custom post types.
		 */
		if ( class_exists( 'Wonkasoft_Custom_Post_Types' ) ) :
			$add_post_types = array(
				'testimonial',
			);
			new Wonkasoft_Custom_Post_Types( $add_post_types );
		endif;
	}
	add_action( 'after_setup_theme', 'apera_bags_setup' );
endif;

/**
 * This check to see if a session has started.
 */
function wonkasoft_register_session() {
  if( !session_id() )
  {
    session_start();
    session_write_close(); 
  }
}

add_action('init', 'wonkasoft_register_session');

add_filter('action_scheduler_run_queue', function($arg) { return 86400; });

/**
 * Adding SVG support.
 *
 * @param array $file_types contains the supported file types.
 * @return  array the array of new file types.
 */
function add_file_types_to_uploads( $file_types ) {
	$new_filetypes        = array();
	$new_filetypes['svg'] = 'image/svg+xml';
	$new_filetypes['eps'] = 'application/postscript';
	$new_filetypes['ai']  = 'application/postscript';
	$file_types           = array_merge( $file_types, $new_filetypes );

	return $file_types;
}
add_action( 'upload_mimes', 'add_file_types_to_uploads' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function apera_bags_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
    // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'apera_bags_content_width', 640 );
}
add_action( 'after_setup_theme', 'apera_bags_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function apera_bags_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'apera-bags' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'apera-bags' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'apera_bags_widgets_init' );

/**
 * Implement the Custom Header feature.
 */
require_once get_stylesheet_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require_once get_stylesheet_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require_once get_stylesheet_directory() . '/inc/template-functions.php';

/**
 * Functions which enhance the theme by ajax requests.
 */
require_once get_stylesheet_directory() . '/inc/theme-ajax-functions.php';

/**
 * Customizer additions.
 */
require_once get_stylesheet_directory() . '/inc/customizer.php';

/**
 * Gravity forms additions.
 */
require_once get_stylesheet_directory() . '/inc/gravity-forms.php';

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require_once get_stylesheet_directory() . '/inc/woocommerce.php';

	require_once get_stylesheet_directory() . '/inc/checkout-login.php';
}

/**
 * Load RewardSystem compatibility file.
 */
if ( class_exists( 'FPRewardSystem' ) ) {
	require_once get_stylesheet_directory() . '/inc/custom-rewardsystems-plugin.php';
}

/**
 * This filters the woocommerce data stores.
 *
 * @param  array $stores Contains data stores.
 * @return array         returns data stores.
 */
function wonkasoft_woocommerce_data_stores( $stores ) {
	return $stores;
}
add_filter( 'woocommerce_data_stores', 'wonkasoft_woocommerce_data_stores' );

/**
 * Load Wonkasoft_Refersion_Api class file.
 */
if ( ! class_exists( 'Wonkasoft_Refersion_Api' ) ) {
	require_once get_stylesheet_directory() . '/inc/class-wonkasoft-refersion-api.php';
}

/**
 * Load Wonkasoft_GetResponse_Api class file.
 */
if ( ! class_exists( 'Wonkasoft_GetResponse_Api' ) ) {
	require_once get_stylesheet_directory() . '/inc/class-wonkasoft-getresponse-api.php';
}

/**
 * Load Wonkasoft_Custom_Post_Types class file.
 */
if ( ! class_exists( 'Wonkasoft_Custom_Post_Types' ) ) {
	require_once get_stylesheet_directory() . '/inc/class-wonkasoft-custom-post-types.php';
}

/**
 * Load Wonkasoft Testimonial compatibility file.
 */
if ( ! class_exists( 'Wonkasoft_Testimonial_Query' ) ) {
	require_once get_stylesheet_directory() . '/inc/class-wonkasoft-testimonial-query.php';
}

/**
 * Load Wonkasoft Testimonial compatibility file.
 */
if ( class_exists( 'GFForms' ) ) {
	require_once get_stylesheet_directory() . '/inc/class-wonkasoft-gf-order-select.php';
}

/**
 * Search for only products
 *
 * @since  1.0.0
 *
 * @param object $query contains the query to filter.
 */
function ws_apera_search_woocommerce_only( $query ) {
	if ( ! is_admin() && is_search() && $query->is_main_query() ) {
		$query->set( 'post_type', 'product' );
	}
}
add_action( 'pre_get_posts', 'ws_apera_search_woocommerce_only' );

/**
 * Hooks into Apera main menu to add Apera logo to
 * my account link. Adds Svg inline to the menu title
 *
 * @param   [object] $items  grabs the menu items for that menu.
 * @param   [array]  $args   Menus.
 *
 * @return  [object] returns the whole menu items object
 * with added icons
 * @author Carlos
 */
function wonka_get_nav_menu_object( $items, $args ) {

	if ( 'Apera' === $args->name ) {

		foreach ( (object) $items as $key => $item ) {

			if ( in_array( 'account-menu-icon', $item->classes, true ) ) {
				$apera_icon  = '<i><svg xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:cc="http://creativecommons.org/ns#" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 500" height="20" width="20" xml:space="preserve" id="svg2" version="1.1"><metadata id="metadata8"><rdf:RDF><cc:Work rdf:about=""><dc:format>image/svg+xml</dc:format><dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage" /><dc:title></dc:title></cc:Work></rdf:RDF></metadata><defs id="defs6" /><g transform="matrix(1.3333333,0,0,-1.3333333,-1.7231138e-4,499.99957)" id="g10"><g transform="matrix(0.18889578,0,0,0.18889578,9.2463299,33.587505)" id="g12"><path id="path14" style="fill:#ffffff;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:1.02272987" d="m 1472.7964,269.43961 c 0,0 221.5336,-107.34265 419.3909,-261.9102764 13.1318,-10.215312 22.4693,1.5980153 14.85,12.9998264 -7.5784,11.353938 -857.6408,1428.84614 -959.24082,1599.75454 -4.64627,7.7318 -15.40947,7.425 -19.93199,0 C 845.1236,1481.3152 272.04308,510.34465 -19.526687,20.52916 -28.211903,6.1510517 -15.703437,-0.62853237 -6.2751566,6.5585482 398.54964,314.08484 694.543,398.16448 943.15021,398.16448 c 177.33629,0 280.49899,-22.09301 379.69359,-51.6724 3.4568,-1.08205 4.3364,1.23034 1.1966,3.48751 C 1137.5149,483.5297 834.12517,565.93206 600.59504,563.15126 L 938.19202,1122.0404 1472.7964,269.43961" /></g></g></svg></i>';
				$item->title = $apera_icon;
			}
		}
	}
	return $items;
}
add_filter( 'wp_get_nav_menu_items', 'wonka_get_nav_menu_object', 10, 2 );


/**
 * Enqueue scripts and styles.
 */
function apera_bags_scripts() {

	/**
	 * For enqueues of styles
	 */
	global $wp_styles;
	$slick_css_load      = true;
	$slick_themecss_load = true;
	foreach ( $wp_styles->queue as $style ) {
		if ( strpos( $style, 'slick-js-style' ) ) :
			$slick_css_load = false;
		endif;
		if ( strpos( $style, 'slick-js-theme-style' ) ) :
			$slick_themecss_load = false;
		endif;
	}
	wp_enqueue_style( 'bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css', array(), '4.5.0', 'all' );
	wp_style_add_data( 'bootstrap', array( 'integrity', 'crossorigin' ), array( 'sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk', 'anonymous' ) );

	wp_enqueue_style( 'jquery-auto-complete', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.css', array(), '1.0.7' );

	if ( $slick_css_load ) :
		wp_enqueue_style( 'slick-js-style', str_replace( array( 'http:', 'https:' ), '', get_stylesheet_directory_uri() . '/assets/slick/slick.css' ), array(), '1.8.0', 'all' );
	endif;

	if ( $slick_themecss_load ) :
		wp_enqueue_style( 'slick-js-theme-style', str_replace( array( 'http:', 'https:' ), '', get_stylesheet_directory_uri() . '/assets/slick/slick-theme.css' ), array(), '1.8.0', 'all' );
	endif;

	wp_enqueue_style( 'apera-bags-style', str_replace( array( 'http:', 'https:' ), '', get_stylesheet_uri() ), array(), wp_get_theme()->get( 'Version' ), 'all' );

	/**
	 * For enqueues of scripts
	 */
	global $wp_scripts;
	$slick_js_load = true;

	foreach ( $wp_scripts->queue as $script ) {
		if ( strpos( $script, 'slick-js' ) ) :
			$slick_script  = $script;
			$slick_js_load = false;

		endif;
	}

	wp_enqueue_script( 'popperjs', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js', array( 'jquery' ), '1.16.0', true );
	wp_script_add_data( 'popperjs', array( 'integrity', 'crossorigin' ), array( 'sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo', 'anonymous' ) );

	wp_enqueue_script( 'bootstrapjs', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js', array( 'jquery', 'popperjs' ), '4.5.0', true );
	wp_script_add_data( 'bootstrapjs', array( 'integrity', 'crossorigin' ), array( 'sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI', 'anonymous' ) );
	
	if ( $slick_js_load ) :
		wp_enqueue_script( 'slick-js', get_stylesheet_directory_uri() . '/assets/slick/slick.min.js', array( 'jquery' ), '1.8.0', true );
	endif;

	if ( $slick_js_load ) :
		wp_enqueue_script( 'apera-bags-wonkamizer-js', get_stylesheet_directory_uri() . '/assets/js/aperabags.min.js', array( 'jquery', 'slick-js' ), wp_get_theme()->get( 'Version' ), true );
	else :
		wp_enqueue_script( 'apera-bags-wonkamizer-js', get_stylesheet_directory_uri() . '/assets/js/aperabags.min.js', array( 'jquery', $slick_script ), wp_get_theme()->get( 'Version' ), true );
	endif;

	if ( is_page( 'checkout' ) && ! empty( get_option( 'google_api_key' ) ) ) :
			wp_enqueue_script( 'googleapi', 'https://maps.googleapis.com/maps/api/js?key=' . get_option( 'google_api_key' ) . '&libraries=places&callback=initAutocomplete', array( 'apera-bags-wonkamizer-js' ), 'all', true );

			wp_enqueue_script( 'jquery-inputmask', get_stylesheet_directory_uri() . '/assets/js/jquery.inputmask.min.js', array( 'jquery' ), 'all', true );
	endif;
	
	if ( is_plugin_active( 'woocommerce-gateway-stripe' ) ) :
		wp_localize_script( 'apera-bags-wonkamizer-js', 'wc_stripe_payment_request_params', apply_filters( 'wc_stripe_payment_request_params', $stripe_params ) );
	endif;

	$ga_id = ( ! empty( get_option( 'google_analytics_id' ) ) ) ? get_option( 'google_analytics_id' ) : '';
	wp_localize_script(
		'apera-bags-wonkamizer-js',
		'wonkasoft_request',
		array(
			'ajax'     => admin_url( 'admin-ajax.php' ),
			'ga_id'    => $ga_id,
			'security' => wp_create_nonce( 'ws-request-nonce' ),
			'api_url' => array(
				'getResponse' => get_site_url() . '/api/wonkasoft/v1/getresponse-api/',
			),
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) :
		wp_enqueue_script( 'comment-reply' );
	endif;
}
add_action( 'wp_enqueue_scripts', 'apera_bags_scripts', 100 );

/**
 * This filters the localized script for woocommerce gateway stripe plugin.
 *
 * @param  array $stripe_params Contains array of stripe params.
 * @return array                Returns the array of the stripe params.
 */
function wonkasoft_wc_stripe_payment_request_params( $stripe_params ) {
	$stripe_params['is_checkout_page'] = is_checkout();

	return $stripe_params;
}
add_filter( 'wc_stripe_payment_request_params', 'wonkasoft_wc_stripe_payment_request_params', 10 );

/**
 * This loads the theme styles on the admin side.
 */
function admin_styles( $hook ) {
	wp_enqueue_style( 'bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css', array(), '4.5.0', 'all' );
	wp_style_add_data( 'bootstrap', array( 'integrity', 'crossorigin' ), array( 'sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk', 'anonymous' ) );

	wp_enqueue_style( 'apera-bags-admin-styles', get_stylesheet_directory_uri() . '/assets/css/admin-styles.css', array(), wp_get_theme()->get( 'Version' ), 'all' );

	wp_enqueue_script( 'popperjs', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js', array( 'jquery' ), '1.16.0', true );
	wp_script_add_data( 'popperjs', array( 'integrity', 'crossorigin' ), array( 'sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo', 'anonymous' ) );

	wp_enqueue_script( 'bootstrapjs', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js', array( 'jquery', 'popperjs' ), '4.5.0', true );
	wp_script_add_data( 'bootstrapjs', array( 'integrity', 'crossorigin' ), array( 'sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI', 'anonymous' ) );

	if ( ( 'edit.php' === $hook && isset( $_GET['post_type'] ) && 'testimonial' === $_GET['post_type'] ) || ( 'post.php' === $hook && isset( $_GET['action'] ) && 'edit' === $_GET['action'] ) ) {
		wp_enqueue_script( 'aperabags-admin-js', get_stylesheet_directory_uri() . '/assets/js/admin-aperabags.min.js', array( 'jquery' ), wp_get_theme()->get( 'Version' ), true );
	}
}
add_action( 'admin_enqueue_scripts', 'admin_styles', 100 );

/**
 * This is preventing reCAPTCHA from sending verification link.
 *
 * @param  boolean $requireCAPTCHA contains boolean.
 * @return boolean                 returns false to prevent verification links.
 */
function wonkasoft_wordfence_ls_require_captcha( $requireCAPTCHA ) {
	return false;
}
add_filter( 'wordfence_ls_require_captcha', 'wonkasoft_wordfence_ls_require_captcha' );


function wonkasoft_add_defer_attribute( $tag, $handle ) {

	if ( 'googleapi' !== $handle ) {
		return $tag;
	}

	return str_replace( ' src', ' defer src', $tag );
}
add_filter( 'script_loader_tag', 'wonkasoft_add_defer_attribute', 10, 2 );


/**
 * Auto login after registration.
 *
 * @author Louis L <llister@wonkasoft.com>
 * @since 1.0.2 Adding auto login after check account creation
 */
function ws_gravity_registration_autologin( $user_id, $user_config, $entry, $password ) {
	$user          = get_userdata( $user_id );
	$user_login    = $user->user_login;
	$user_password = $password;

	$role          = 'apera_perks_partner';
	$role_display  = 'Apera Perks Partner';
	$role2         = 'customer';
	$role2_display = 'Customer';

	if ( ! in_array( $role, $user->roles ) ) :
		$user->add_role( $role, $role_display );
	endif;

	if ( ! in_array( $role2, $user->roles ) ) :
		$user->add_role( $role2, $role2_display );
	endif;

	wp_signon(
		array(
			'user_login'    => $user_login,
			'user_password' => $user_password,
			'remember'      => false,

		)
	);
}
add_action( 'gform_user_registered', 'ws_gravity_registration_autologin', 10, 4 );
