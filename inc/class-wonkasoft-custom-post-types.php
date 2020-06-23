<?php
/**
 * This file contains custom post types added into the theme.
 *
 * @author Wonkasoft <support@wonkasoft.com>
 * @package aperabags
 * @since 1.5.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Wonkasoft_Custom_Post_Types' ) ) :
	/**
	 * Class Wonkasoft_Add_Custom_Post_Types
	 */
	class Wonkasoft_Custom_Post_Types {

		/**
		 * array of post types to add.
		 */
		public $custom_post_types = array();

		/**
		 * array of post types errors.
		 */
		public $custom_post_type_errors = array();

		/**
		 * The construtor for the class.
		 */
		public function __construct( array $params ) {
			$this->custom_post_types = $params;
			add_action( 'init', array( $this, 'add_post_types' ), 10 );
			add_action( 'admin_notices', array( $this, 'wonkasoft_admin_notice__error' ), 0 );
		}

		public function wonkasoft_admin_notice__error() {
			if ( ! empty( $this->custom_post_type_errors ) ) :
				foreach ( $this->custom_post_type_errors as $post_type ) {
					$class   = 'notice notice-error';
					$message = sprintf( __( 'However, args are not set for post type %s', 'aperabags' ), $post_type );

					printf( '<div class="%1$s"><p><div style="display: inline-block; margin-right: 8px;" class="icon-wrap"><i style="font-size: 2.6rem;" class="fa fa-info-circle"></i></div><div style="display: inline-block;" class="message-wrap"><b>Warning!</b> %2$s%3$s%4$s<br />%5$s</div></p></div>', esc_attr( $class ), esc_html( 'You have passed ' ), $post_type, esc_html( ' to add as a post type.' ), esc_html( $message ) );
				}
			endif;
		}

		/**
		 * Loads all the added post types.
		 */
		public function add_post_types() {
			foreach ( $this->custom_post_types as $post_type ) {
				/**
				 * Check for empty post type in the array.
				 */
				if ( ! empty( $post_type ) ) :
					/**
					 * Checks if the get_post_type_args are set for current post type.
					 */
					if ( ! method_exists( $this, "get_post_type_args_$post_type" ) ) :
						array_push( $this->custom_post_type_errors, $post_type );
					else :
						$post_type_args = $this->{"get_post_type_args_$post_type"}();
						register_post_type( $post_type, $post_type_args );
					endif;
				endif;
			}
		}

		/**
		 * This returns the args for the testimonial post type.
		 *
		 * @return array returns the args for testimonial post type.
		 */
		public function get_post_type_args_testimonial() {
			$labels  = array(
				'name'                  => _x( 'Testimonials', 'Post Type General Name', 'aperabags' ),
				'singular_name'         => _x( 'testimonial', 'Post Type Singular Name', 'aperabags' ),
				'menu_name'             => __( 'Testimonials', 'aperabags' ),
				'name_admin_bar'        => __( 'Testimonials', 'aperabags' ),
				'archives'              => __( 'Testimonial Archives', 'aperabags' ),
				'attributes'            => __( 'Testimonial Attributes', 'aperabags' ),
				'parent_item_colon'     => __( 'Parent Testimonial:', 'aperabags' ),
				'all_items'             => __( 'All Testimonials', 'aperabags' ),
				'add_new_item'          => __( 'Add New Testimonial', 'aperabags' ),
				'add_new'               => __( 'Add Testimonial', 'aperabags' ),
				'new_item'              => __( 'New Testimonial', 'aperabags' ),
				'edit_item'             => __( 'Edit Testimonial', 'aperabags' ),
				'update_item'           => __( 'Update Testimonial', 'aperabags' ),
				'view_item'             => __( 'View Testimonial', 'aperabags' ),
				'view_items'            => __( 'View Testimonial', 'aperabags' ),
				'search_items'          => __( 'Search Testimonial', 'aperabags' ),
				'not_found'             => __( 'Not found', 'aperabags' ),
				'not_found_in_trash'    => __( 'Not found in Trash', 'aperabags' ),
				'featured_image'        => __( 'Featured Image', 'aperabags' ),
				'set_featured_image'    => __( 'Set featured image', 'aperabags' ),
				'remove_featured_image' => __( 'Remove featured image', 'aperabags' ),
				'use_featured_image'    => __( 'Use as featured image', 'aperabags' ),
				'insert_into_item'      => __( 'Insert into item', 'aperabags' ),
				'uploaded_to_this_item' => __( 'Uploaded to this item', 'aperabags' ),
				'items_list'            => __( 'testimonials list', 'aperabags' ),
				'items_list_navigation' => __( 'Items list navigation', 'aperabags' ),
				'filter_items_list'     => __( 'Filter items list', 'aperabags' ),
			);
			$rewrite = array(
				'slug'       => 'testimonials',
				'with_front' => true,
				'pages'      => false,
				'feeds'      => true,
			);
			$args    = array(
				'label'               => __( 'testimonial', 'aperabags' ),
				'description'         => __( 'Customer Testimonials', 'aperabags' ),
				'labels'              => $labels,
				'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields', 'post-formats' ),
				'taxonomies'          => array( 'testimonials' ),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 5,
				'menu_icon'           => 'dashicons-format-quote',
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => true,
				'publicly_queryable'  => true,
				'rewrite'             => $rewrite,
				'capability_type'     => 'page',
				'show_in_rest'        => true,
				'rest_base'           => 'testimonials',
			);

			return $args;
		}
	}
endif;
