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
		 * Array of post types to add.
		 *
		 * @var array $custom_post_types
		 */
		public $custom_post_types = array();

		/**
		 * Array of post types errors.
		 *
		 * @var array $custom_post_type_errors
		 */
		public $custom_post_type_errors = array();

		/**
		 * Current post type.
		 *
		 * @var string $current_post_type
		 */
		public $current_post_type = '';

		/**
		 * The construtor for the class.
		 *
		 * @params array $params Contains params that are passed in.
		 */
		public function __construct( array $params = array() ) {
			$this->custom_post_types = $params;
			add_action( 'init', array( $this, 'add_post_types' ), 10 );
			add_action( 'admin_notices', array( $this, 'wonkasoft_admin_notice__error' ), 0 );
			add_action( 'quick_edit_custom_box', array( $this, 'wonkasoft_display_custom_quickedit' ), 10, 3 );
			add_action( 'save_post', array( $this, 'save_post_type_meta' ), 10 );
		}

		/**
		 * This places the admin notice for unregisters post types.
		 *
		 * @return void
		 */
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
						$this->current_post_type = $post_type;
						$post_type_args          = $this->{"get_post_type_args_$post_type"}();
						register_post_type( $post_type, $post_type_args );
						add_filter( "manage_edit-{$post_type}_sortable_columns", array( $this, 'manage_edit_post_type_sortable_columns' ), 10 );
						add_filter( "manage_{$post_type}_posts_columns", array( $this, 'manage_post_type_posts_columns' ), 10 );
						// display the column value
						add_action( "manage_{$post_type}_posts_custom_column", array( $this, 'manage_post_type_posts_custom_column' ), 10, 2 );
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
				'featured_image'        => __( 'Testimonial Image', 'aperabags' ),
				'set_featured_image'    => __( 'Set testimonial image', 'aperabags' ),
				'remove_featured_image' => __( 'Remove testimonial image', 'aperabags' ),
				'use_featured_image'    => __( 'Use as testimonial image', 'aperabags' ),
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
				'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields', 'post-formats', 'page-attributes' ),
				'taxonomies'          => array( 'featured' ),
				'show_admin_column'   => true,
				'show_in_quick_edit'  => true,
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
				'capability_type'     => array( 'testimonial', 'testimonials' ),
				'capabilities'        => array(
					'edit_post'          => 'edit_testimonial',
					'read_post'          => 'read_testimonial',
					'delete_post'        => 'delete_testimonial',
					'edit_posts'         => 'edit_testimonials',
					'edit_others_posts'  => 'edit_others_testimonials',
					'publish_posts'      => 'publish_testimonials',
					'read_private_posts' => 'read_private_testimonials',
					'create_posts'       => 'edit_testimonials',
				),
				'map_meta_cap'        => true,
				'rewrite'             => $rewrite,
				'show_in_rest'        => true,
				'rest_base'           => 'testimonials',
			);

			// $term_labels = array(
			// 'name'                       => _x( 'Featured', 'taxonomy general name' ),
			// 'singular_name'              => _x( 'Feature', 'taxonomy singular name' ),
			// 'search_items'               => __( 'Search Featured' ),
			// 'popular_items'              => __( 'Popular Featured' ),
			// 'all_items'                  => __( 'All Featured' ),
			// 'parent_item'                => null,
			// 'parent_item_colon'          => null,
			// 'edit_item'                  => __( 'Edit Feature' ),
			// 'view_item'                  => __( 'View Feature' ),
			// 'update_item'                => __( 'Update Feature' ),
			// 'add_new_item'               => __( 'Add New Feature' ),
			// 'new_item_name'              => __( 'New Feature Name' ),
			// 'separate_items_with_commas' => __( 'Separate featured with commas' ),
			// 'add_or_remove_items'        => __( 'Add or remove featured' ),
			// 'choose_from_most_used'      => __( 'Choose from the most used featured' ),
			// 'not_found'                  => __( 'No featured found.' ),
			// 'no_terms'                   => __( 'No featured' ),
			// 'items_list_navigation'      => __( 'Featured list navigation' ),
			// 'items_list'                 => __( 'Featured list' ),
			// * translators: Tab heading when selecting from the most used terms. */
			// 'most_used'                  => _x( 'Most Used', 'featured' ),
			// 'back_to_items'              => __( '&larr; Back to Featured' ),
			// );

			// $term_args = array(
			// 'labels'             => $term_labels,
			// 'description'        => '',
			// 'public'             => true,
			// 'publicly_queryable' => true,
			// 'hierarchical'       => true,
			// 'show_ui'            => true,
			// 'show_in_menu'       => true,
			// 'show_in_nav_menus'  => true,
			// 'show_in_rest'       => true,
			// 'show_in_rest'       => true,
			// );

			// register_taxonomy( 'featured', 'testimonial', $term_args );

			return $args;
		}

		public function manage_post_type_posts_columns( $columns ) {
			if ( 'testimonial' === $this->current_post_type ) :
				$columns = array_slice( $columns, 0, 2, true ) +
							array(
								'excerpt_col' => 'excerpt',
								'featured'    => '<label>Featured</label><i class="btn fa fa-star"></i>',
							) +
							array_slice( $columns, 2, null, true );
			endif;
			return $columns;
		}

		public function manage_edit_post_type_sortable_columns( $sortable_columns ) {
			if ( 'testimonial' === $this->current_post_type ) :
				$sortable_columns['featured'] = array(
					'featured',
				);
			endif;
			return $sortable_columns;
		}

		public function manage_post_type_posts_custom_column( $column_name, $post_id ) {
			switch ( $column_name ) :
				case 'featured':
					$featured = ( ! empty( get_post_meta( $post_id, 'featured', true ) ) ) ? 'fas' : 'far';
					$data     = ( ! empty( get_post_meta( $post_id, 'featured', true ) ) ) ? get_post_meta( $post_id, 'featured', true ) : 'false';
					$title    = 'checked' === $data ? 'yes' : 'no';
					print_r( '<a href="javascript:void(0);" class="btn" data="' . $data . '" post-id="' . $post_id . '" data-toggle="tooltip" data-placement="bottom" title="' . $title . '"><i class="' . $featured . ' fa-star"></i></a>' );
					break;
				case 'excerpt_col':
					$post = get_post( $post_id );
					print_r( wp_trim_words( $post->post_content, 15, '...' ) );
					break;
			endswitch;
		}

		public function wonkasoft_display_custom_quickedit( $column_name, $post_type, $taxonomy ) {
			switch ( $column_name ) :
				case 'featured':
					wp_nonce_field( "{$post_type}_save_action_nonce", "{$post_type}_edit_nonce", true, true );
					$output = '<fieldset class="inline-edit-col-right"><label for="testimonial_featured"><input type="checkbox" name="testimonial_featured" value="checked" /><span class="checkbox-title">' . ucfirst( $column_name ) . '</span></label></fieldset>';
					echo wp_kses(
						$output,
						array(
							'fieldset' => array(
								'class' => array(),
							),
							'label'    => array(
								'class' => array(),
								'for'   => array(),
							),
							'input'    => array(
								'for'   => array(),
								'class' => array(),
								'name'  => array(),
								'type'  => array(),
								'value' => array(),
							),
							'span'     => array(
								'class' => array(),
							),
						)
					);
					break;
			endswitch;
		}

		public function save_post_type_meta( $post_id ) {
			$post          = get_post( $post_id );
			$cur_post_type = $post->post_type;
			$post_nonce    = "{$cur_post_type}_edit_nonce";
			if ( ! in_array( $_POST['post_type'], $this->custom_post_types ) ) {
				return;
			}

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}

			if ( ! wp_verify_nonce( $_POST[ $post_nonce ], "{$cur_post_type}_save_action_nonce" ) ) {
				return;
			}

			if ( isset( $_REQUEST['testimonial_featured'] ) ) {
				update_post_meta( $post_id, 'featured', $_REQUEST['testimonial_featured'] );
			} else {
				update_post_meta( $post_id, 'featured', '' );
			}
		}
	}
endif;
