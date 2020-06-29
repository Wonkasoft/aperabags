<?php
/**
 * Class for parameter-based Testimonial querying
 *
 * @package  Wonkasoft/Classes
 * @since    1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Testimonial query class.
 */
class Wonkasoft_Testimonial_Query extends WC_Object_Query {

	/**
	 * Valid query vars for testimonials.
	 *
	 * @return array
	 */
	protected function get_default_query_vars() {
		return array_merge(
			parent::get_default_query_vars(),
			array(
				'status'        => array( 'draft', 'pending', 'private', 'publish' ),
				'limit'         => get_option( 'posts_per_page' ),
				'include'       => array(),
				'date_created'  => '',
				'date_modified' => '',
				'featured'      => '',
				'visibility'    => '',
			)
		);
	}

	/**
	 * Get testimonials matching the current query vars.
	 *
	 * @return array|object of Wonkasoft_Testimonial objects
	 */
	public function get_testimonials() {
		$args    = apply_filters( 'wonkasoft_testimonial_object_query_args', $this->get_query_vars() );
		$results = get_terms( 'testimonial', $args );
		return apply_filters( 'wonkasoft_testimonial_object_query', $results, $args );
	}
}
