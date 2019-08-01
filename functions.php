<?php
/**
 * Apera Bags functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package aperabags
 */

if ( ! function_exists( 'apera_bags_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function apera_bags_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Apera Bags, use a find and replace
		 * to change 'apera-bags' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'apera-bags', get_template_directory() . '/languages' );

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

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-primary' => esc_html__( 'Primary', 'apera-bags' ),
				'menu-cart' => esc_html__( 'Cart', 'apera-bags' ),
				'menu-shop' => esc_html__( 'Footer Shop', 'apera-bags' ),
				'menu-contact' => esc_html__( 'Footer Contact', 'apera-bags' ),
				'menu-account' => esc_html__( 'Footer My Account', 'apera-bags' ),
				'menu-company' => esc_html__( 'Footer Company', 'apera-bags' ),
				'menu-programs' => esc_html__( 'Footer Programs', 'apera-bags' ),
			)
		);

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
			$form_value = ( get_post_meta( $post->ID, 'ws_variant_name', true ) ) ? get_post_meta( $post->ID, 'ws_variant_name', true ) : '';
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
				return 40;
			}
		);

		/**
		 * This is for custom image sizes for faster image parsing.
		 *
		 * @since 1.0.0
		 */
		add_image_size( 'custom_products_size', 367, 551, false );
	}
endif;
add_action( 'after_setup_theme', 'apera_bags_setup' );

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
require_once get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require_once get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require_once get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require_once get_template_directory() . '/inc/customizer.php';

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require_once get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Load WC_Gateway_CyberSource compatibility file.
 */
if ( class_exists( 'WC_Gateway_CyberSource' ) ) {
	require_once get_template_directory() . '/inc/wc-cybersource-custom.php';
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
 * Enqueue scripts and styles.
 */
function apera_bags_scripts() {

	/**
	 * For enqueues of styles
	 */
	wp_enqueue_style( 'bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css', array(), '4.3.1', 'all' );

	wp_style_add_data( 'bootstrap', array( 'integrity', 'crossorigin' ), array( 'sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T', 'anonymous' ) );

	wp_enqueue_style( 'fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), '4.7.0', 'all' );

	wp_enqueue_style( 'jquery-auto-complete', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.css', array(), '1.0.7' );

	wp_enqueue_style( 'slick-js-style', get_template_directory_uri() . '/assets/slick/slick.css', array(), '1.8.0', 'all' );

	wp_enqueue_style( 'slick-js-theme-style', get_template_directory_uri() . '/assets/slick/slick-theme.css', array(), '1.8.0', 'all' );

	wp_enqueue_style( 'apera-bags-style', get_stylesheet_uri(), array(), time() );

	/**
	 * For enqueues of scripts
	 */
	wp_enqueue_script( 'bootstrapjs', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', array( 'jquery' ), '4.3.1', true );

	wp_script_add_data( 'bootstrapjs', array( 'integrity', 'crossorigin' ), array( 'sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM', 'anonymous' ) );

	wp_enqueue_script( 'apera-bags-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '1.0.0', true );

	wp_enqueue_script( 'apera-bags-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '1.0.0', true );

	wp_enqueue_script( 'slick-js', get_template_directory_uri() . '/assets/slick/slick.min.js', array( 'jquery' ), '1.8.0', true );

	wp_enqueue_script( 'apera-bags-wonkamizer-js', get_template_directory_uri() . '/assets/js/aperabags.min.js', array( 'jquery', 'slick-js' ), time(), true );

	$ga_id = ( ! empty( get_option( 'wonkasoft_ga_id' ) ) ) ? get_option( 'wonkasoft_ga_id' ) : '';
	wp_localize_script(
		'apera-bags-wonkamizer-js',
		'wonkasoft_request',
		array(
			'ajax' => admin_url( 'admin-ajax.php' ),
			'ga_id' => $ga_id,
			'security' => wp_create_nonce( 'ws-request-nonce' ),
		)
	);

	if ( is_page( 'checkout' ) && ! empty( get_option( 'google_api_key' ) ) ) :
			wp_enqueue_script( 'googleapi', 'https://maps.googleapis.com/maps/api/js?key=' . get_option( 'google_api_key' ) . '&libraries=places&callback=initAutocomplete', array( 'apera-bags-wonkamizer-js' ), 'all', true );
	endif;

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) :
		wp_enqueue_script( 'comment-reply' );
	endif;
}
add_action( 'wp_enqueue_scripts', 'apera_bags_scripts', 50 );
