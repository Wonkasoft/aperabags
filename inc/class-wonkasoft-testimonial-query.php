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
class Wonkasoft_Testimonial_Query {

	/**
	 * Args that are passed into the class.
	 *
	 * @var array
	 */
	protected $args = array();

	/**
	 * Results from the query.
	 *
	 * @var array
	 */
	public $results = array();

	/**
	 * Default args that are passed into the class.
	 *
	 * @var array
	 */
	protected $default_args = array(
		'post_type'     => 'testimonial',
		'status'        => 'published',
		'post_per_page' => -1,
		'meta_query'    => array(
			array(
				'key'     => '',
				'value'   => '',
				'compare' => 'LIKE',
			),
		),
	);

	/**
	 * Class constructor.
	 */
	public function __construct( array $params = array() ) {
		$this->args = array_merge( $this->default_args, $params );

		try {
			$this->get_testimonials();
		} catch ( \Throwable $th ) {
			print_r( $th );
		}
	}

	/**
	 * Get testimonials matching the current query vars.
	 *
	 * @return array|object of Wonkasoft_Testimonial objects
	 */
	public function get_testimonials() {
		$args          = apply_filters( 'wonkasoft_testimonial_object_query_args', $this->args );
		$this->results = new WP_Query( $args );
		return apply_filters( 'wonkasoft_testimonial_object_query', $this->results, $args );
	}
}
