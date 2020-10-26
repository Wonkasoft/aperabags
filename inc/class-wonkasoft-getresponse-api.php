<?php
/**
 * This file is the main API for GetResponse
 *
 * @category   GetResponse API
 * @package    GetResponse
 * @author     Wonkasoft <Support@Wonkasoft.com>
 * @copyright  2020 Wonkasoft
 * @version    1.1.0
 * @since      1.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * This is the class for the GetResponse API.
 */
class Wonkasoft_GetResponse_Api {

	/**
	 * [$data description]
	 *
	 * @var null
	 */
	protected $data = null; // Will be set to the data that is passed into the class.

	protected $post_header = array(); // POST header array for api calls.

	protected $get_header = array(); // GET header array for api calls.

	private $getresponse_api = null; // Will be set with api key.

	protected $getresponse_url = null; // Will be set with api url.

	public $email = null; // Contacts email address.

	public $tag_list = array();  // The tag list to be fetched.

	public $contact_list = array();  // The contact list to be fetched.

	public $contact_name = null; // For the name of the contact.

	public $tags = array();  // Array of tag names passed in.

	public $tags_to_update = array();  // The tag to be updated on contact.

	public $campaign_name = null; // For the name of the campaign.

	public $campaign_list = array(); // Campaign list.

	public $campaign_id = null; // Set to correct campaign id.

	public $custom_fields_list = array(); // Custom fields list.

	public $custom_fields = array(); // Custom field names to find ids for.

	public $custom_fields_values = array(); // Custom field values.

	public $custom_fields_to_update = array(); // Custom fields to be updated.

	public $contact_id = null;  // Will be set to current contact.

	public $tag_id = null; // Will be set to the current tags id.

	public $day_of_cycle = null; // Will be set to the days of cycle.

	public $scoring = null; // Will be set to the scoring.

	public $ip_address = null; // Will be set to user ip.

	public $note = null; // Will be set to the note.

	public $shop_carts = array(); // Will be list of shop's carts.

	public $cart_id = null; // Will be set to the getResponse cart ID.

	public $new_cart = null; // Will be set to the new getResponse cart.

	public $order_list = null; // Will be list of orders.

	public $order_id = null; // Will be set to the getResponse order ID.

	public $new_order = null; // Will be set to the new getResponse order.

	public $shop_id = null; // Will be set to the getResponse shop ID.

	public $shop_list = array(); // Will be list of shops.

	public $product_list = array(); // Will be list of products.

	public $product_id = null; // Will be getResponse product ID.

	public $product_variant_list = array(); // Will be list of variant products.

	public $variant_id = null; // Will be getResponse variant product ID.

	public $tax_id = null; // Will be getResponse tax ID.

	/**
	 * Class Init constructor.
	 *
	 * @param array $data array of data for setting instance variables.
	 */
	public function __construct( $data = null ) {

		// whether ip is from share internet.
		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		}
		// whether ip is from proxy.
		elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		// whether ip is from remote address.
		else {
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}
		$this->data                    = ( ! empty( $data ) ) ? $data : null;
		$this->getresponse_api         = ( ! empty( get_option( 'getresponse_api_key' ) ) ) ? get_option( 'getresponse_api_key' ) : null;
		$this->getresponse_url         = ( ! empty( get_option( 'getresponse_api_url' ) ) ) ? get_option( 'getresponse_api_url' ) : null;
		$this->post_header             = array(
			'X-Auth-Token: api-key ' . $this->getresponse_api,
			'Content-Type: application/json',
		);
		$this->get_header              = array(
			'X-Auth-Token: api-key ' . $this->getresponse_api,
			'Content-Type: application/x-www-form-urlencoded',
		);
		$this->email                   = ( ! empty( $data['email'] ) ) ? $data['email'] : null;
		$this->tags                    = ( ! empty( $data['tags'] ) ) ? $data['tags'] : null;
		$this->tags_to_update          = ( ! empty( $data['tags_to_update'] ) ) ? $data['tags_to_update'] : array();
		$this->campaign_name           = ( ! empty( $data['campaign_name'] ) ) ? $data['campaign_name'] : null;
		$this->campaign_list           = ( ! empty( $data['campaign_list'] ) ) ? $data['campaign_list'] : null;
		$this->campaign_id             = ( ! empty( $data['campaign_id'] ) ) ? $data['campaign_id'] : null;
		$this->custom_fields           = ( ! empty( $data['custom_fields'] ) ) ? $data['custom_fields'] : null;
		$this->custom_fields_values    = ( ! empty( $data['custom_fields_values'] ) ) ? $data['custom_fields_values'] : array();
		$this->custom_fields_list      = ( ! empty( $data['custom_fields_list'] ) ) ? $data['custom_fields_list'] : null;
		$this->custom_fields_to_update = ( ! empty( $data['custom_fields_to_update'] ) ) ? $data['custom_fields_to_update'] : array();
		$this->contact_id              = ( ! empty( $data['contact_id'] ) ) ? $data['contact_id'] : null;
		$this->contact_name            = ( ! empty( $data['contact_name'] ) ) ? $data['contact_name'] : null;
		$this->tag_id                  = ( ! empty( $data['tag_id'] ) ) ? $data['tag_id'] : null;
		$this->day_of_cycle            = ( ! empty( $data['day_of_cycle'] ) ) ? $data['day_of_cycle'] : 0;
		$this->ip_address              = ( ! empty( $data['ip_address'] ) ) ? $data['ip_address'] : $ip_address;
		$this->note                    = ( ! empty( $data['note'] ) ) ? $data['note'] : null;
		$this->scoring                 = ( ! empty( $data['scoring'] ) ) ? $data['scoring'] : null;
		$this->contact_list            = $this->get_contact_list();
		$this->tag_list                = $this->get_the_list_of_tags();
		$this->campaign_list           = $this->get_list_of_campaigns();
		$this->custom_fields_list      = $this->get_list_of_custom_fields();
	}

	/**
	 * This public function will update the current contacts details.
	 *
	 * @rest_endpoint POST /contacts/{contactId}
	 * @return object             contains the response data from getResponse.
	 */
	public function update_contact_details() {

		$payload = array(
			'name'              => $this->contact_name,
			'campaign'          => array(
				'campaignId' => $this->campaign_id,
			),
			'email'             => $this->email,
			'dayOfCycle'        => $this->day_of_cycle,
			'scoring'           => $this->scoring,
			'ipAddress'         => $this->ip_address,
			'note'              => $this->note,
			'tags'              => $this->tags_to_update,
			'customFieldValues' => $this->custom_fields_to_update,
		);

		$payload = json_encode( $payload );
		$url     = $this->getresponse_url . '/contacts/' . $this->contact_id;

		return $this->wonkasoft_gr_make_call( $url, 'POST', $payload );
	}

	/**
	 * Delete a contact by contact ID.
	 *
	 * @rest_endpoint DELETE /contacts/{contactId}
	 * @return object             contains the response data from getResponse.
	 */
	public function delete_contact_by_contact_ID( $passed_query = null ) {

		if ( empty( $this->contact_id ) ) {
			return array(
				'error'      => 'Variables must be before this function is run.',
				'contact_id' => ( empty( $this->contact_id ) ? 'instance variable needs to be set.' : $this->contact_id ),
			);
		}

		if ( ! empty( $passed_query ) ) {
			$current_query = $passed_query;
		} else {
			$current_query = array(
				'messageId' => null,
				'ipAddress' => null,
			);
		}

		$contact_id    = $this->contact_id;
		$current_query = json_decode( json_encode( $current_query ) );
		$current_query = http_build_query( $current_query );
		$url           = $this->getresponse_url . "/contacts/$contact_id?$current_query";

		return $this->wonkasoft_gr_make_call( $url, 'DELETE' );
	}

	/**
	 * This public function will create a new contact.
	 *
	 * @rest_endpoint POST /contacts/
	 * @return object             contains the response data from getResponse.
	 */
	public function create_a_new_contact() {

		$payload = array(
			'name'              => $this->contact_name,
			'campaign'          => array(
				'campaignId' => $this->campaign_id,
			),
			'email'             => $this->email,
			'dayOfCycle'        => $this->day_of_cycle,
			'scoring'           => $this->scoring,
			'ipAddress'         => $this->ip_address,
			'tags'              => $this->tags_to_update,
			'customFieldValues' => $this->custom_fields_to_update,
		);

		$payload = json_encode( $payload );
		$url     = $this->getresponse_url . '/contacts';

		return $this->wonkasoft_gr_make_call( $url, 'POST', $payload );
	}

	/**
	 * This public function adds updates the tags for a contact.
	 *
	 * @rest_endpoint POST /contacts/{contactId}/tags
	 * @return boolean             Will return an error or true on success.
	 */
	public function upsert_the_tags_of_contact() {

		if ( ! empty( $this->tag_id ) ) :
			$payload = array(
				'tags' => array(
					array(
						'tagId' => $this->tag_id,
					),
				),
			);
		else :
			$payload = array(
				'tags' => $this->tags_to_update,
			);
		endif;

		$payload = json_encode( $payload );
		$url     = $this->getresponse_url . '/contacts/' . $this->contact_id . '/tags';

		return $this->wonkasoft_gr_make_call( $url, 'POST', $payload );
	}

	/**
	 * This returns the object of the tag query that is send in.
	 *
	 * @rest_endpoint GET /tags
	 * @param array $passed_query contains passed query.
	 * @return object            contains the object found from query.
	 */
	public function get_the_list_of_tags( $passed_query = null ) {

		if ( ! empty( $passed_query ) ) {
			$current_query = $passed_query;
		} else {
			$current_query = array(
				'query'   => array(
					'name'      => $this->tags,
					'createdAt' => array(
						'from' => null,
						'to'   => null,
					),
				),
				'sort'    => array(
					'createdAt' => null,
				),
				'fields'  => null,
				'perPage' => null,
				'page'    => null,
			);
		}

		$current_query = json_decode( json_encode( $current_query ) );
		$current_query = http_build_query( $current_query );
		$url           = $this->getresponse_url . '/tags?' . $current_query;

		return $this->wonkasoft_gr_make_call( $url );
	}

	/**
	 * This functions gets a list of the contacts from passed query.
	 *
	 * $current_query = array(
	 *      'query'           => array(
	 *          'email'      => $this->email,
	 *          'name'       => null,
	 *          'campaignId' => null,
	 *          'origin'     => null,
	 *          'createdOn'  => array(
	 *              'from' => null,
	 *              'to'   => null,
	 *          ),
	 *          'changedOn'  => array(
	 *              'from' => null,
	 *              'to'   => null,
	 *          ),
	 *      ),
	 *      'sort'            => array(
	 *          'createdOn'  => null,
	 *          'changedOn'  => null,
	 *          'campaignId' => null,
	 *      ),
	 *      'additionalFlags' => null,
	 *      'fields'          => null,
	 *      'perPage'         => null,
	 *      'page'            => null,
	 *  );
	 *
	 * @rest_endpoint GET /contacts
	 * @param array $passed_query contains passed query.
	 * @return object        return an object of a list of contacts.
	 */
	public function get_contact_list( $passed_query = null ) {

		if ( ! empty( $passed_query ) ) {
			$current_query = $passed_query;
		} else {
			$current_query = array(
				'query'           => array(
					'email'      => $this->email,
					'name'       => null,
					'campaignId' => null,
					'origin'     => null,
					'createdOn'  => array(
						'from' => null,
						'to'   => null,
					),
					'changedOn'  => array(
						'from' => null,
						'to'   => null,
					),
				),
				'sort'            => array(
					'createdOn'  => null,
					'changedOn'  => null,
					'campaignId' => null,
				),
				'additionalFlags' => null,
				'fields'          => null,
				'perPage'         => null,
				'page'            => null,
			);
		}

		$current_query = json_decode( json_encode( $current_query ) );
		$current_query = http_build_query( $current_query );
		$url           = $this->getresponse_url . '/contacts?' . $current_query;

		return $this->wonkasoft_gr_make_call( $url );
	}

	/**
	 * This public function will get a list of campaigns.
	 *
	 * $current_query = array(
	 *      'query'   => array(
	 *          'name'      => $this->campaign_name,
	 *          'isDefault' => null,
	 *      ),
	 *      'sort'    => array(
	 *          'name'      => null,
	 *          'createdOn' => null,
	 *      ),
	 *      'fields'  => null,
	 *      'perPage' => null,
	 *      'page'    => null,
	 *  );
	 *
	 * @rest_endpoint GET /campaigns
	 * @param array $passed_query contains passed query.
	 * @return object                returns object of campaigns.
	 */
	public function get_list_of_campaigns( $passed_query = null ) {

		if ( ! empty( $passed_query ) ) {
			$current_query = $passed_query;
		} else {
			$current_query = array(
				'query'   => array(
					'name'      => $this->campaign_name,
					'isDefault' => null,
				),
				'sort'    => array(
					'name'      => null,
					'createdOn' => null,
				),
				'fields'  => null,
				'perPage' => null,
				'page'    => null,
			);
		}

		$current_query = json_decode( json_encode( $current_query ) );
		$current_query = http_build_query( $current_query );
		$url           = $this->getresponse_url . '/campaigns?' . $current_query;

		return $this->wonkasoft_gr_make_call( $url );
	}

	/**
	 * You can filter the resource using criteria specified as "query[*]". You can provide multiple criteria, to use AND logic. You can sort the resource using parameters specified as "sort[*]". You can specify multiple fields to sort by.
	 *
	 * $current_query = array(
	 *      'query'   => array(
	 *          'name' => null,
	 *      ),
	 *      'sort'    => array(
	 *          'name' => null,
	 *      ),
	 *      'fields'  => null,
	 *      'perPage' => null,
	 *      'page'    => null,
	 *  );
	 *
	 * @param array $passed_query contains passed query.
	 * @return object returns an object of a list of custom fields.
	 */
	public function get_list_of_custom_fields( $passed_query = null ) {

		if ( ! empty( $passed_query ) ) {
			$current_query = $passed_query;
		} else {
			$current_query = array(
				'query'   => array(
					'name' => null,
				),
				'sort'    => array(
					'name' => null,
				),
				'fields'  => null,
				'perPage' => null,
				'page'    => null,
			);
		}

		$current_query = json_decode( json_encode( $current_query ) );
		$current_query = http_build_query( $current_query );
		$url           = $this->getresponse_url . '/custom-fields?' . $current_query;

		return $this->wonkasoft_gr_make_call( $url );
	}

	/**
	 * Upsert (add or update) the custom fields of a contact. This method doesn't remove (unassign) custom fields.
	 *
	 * @rest_endpoint POST /contacts/{contactId}/custom-fields
	 * @return boolean             returns errors or true on success.
	 */
	public function upsert_the_custom_fields_of_a_contact() {

		$payload = array(
			'customFieldValues' => $this->custom_fields_to_update,
		);

		$payload = json_encode( $payload );
		$url     = $this->getresponse_url . '/contacts/' . $this->contact_id . '/custom-fields';

		return $this->wonkasoft_gr_make_call( $url, 'POST', $payload );
	}

	/**
	 * Gets contact by ID
	 *
	 * @param array $passed_query contains passed query.
	 * @return object returns an object of a contacts details.
	 */
	public function get_contact_details_by_contact_id( $passed_id = null ) {

		if ( empty( $passed_id ) ) {
			return 'No contact ID passed in to function.';
		}

		$url = $this->getresponse_url . "/contacts/$passed_id";
		return $this->wonkasoft_gr_make_call( $url );
	}

	/**
	 *
	 * Ecommerce
	 */

	/**
	 *
	 * Carts
	 */

	/**
	 * Get shop carts
	 *
	 * $current_query = array(
	 *      'query'   => array(
	 *          'createdOn' => array(
	 *              'from' => null,
	 *          ),
	 *      ),
	 *      'query'   => array(
	 *          'createdOn' => array(
	 *              'to' => null,
	 *          ),
	 *      ),
	 *      'query'    => array(
	 *          'externalId' => null,
	 *      ),
	 *      'sort'    => array(
	 *          'createdOn' => 'ASC',
	 *      ),
	 *      'fields'  => null,
	 *      'perPage' => null,
	 *      'page'    => null,
	 *  );
	 *
	 * @param  array $passed_query Contains array of
	 * @return object               returns object of response
	 */
	public function get_shop_carts( $passed_query = null ) {

		if ( ! empty( $passed_query ) ) {
			$current_query = $passed_query;
		} else {
			$current_query = array(
				'query'   => array(
					'createdOn'  => array(
						'from' => null,
						'to'   => null,
					),
					'externalId' => null,
				),
				'sort'    => array(
					'createdOn' => 'ASC',
				),
				'fields'  => null,
				'perPage' => null,
				'page'    => null,
			);
		}

			$shop_id       = $this->shop_id;
			$current_query = json_decode( json_encode( $current_query ) );
			$current_query = http_build_query( $current_query );
			$url           = $this->getresponse_url . "/shops/$shop_id/carts?$current_query";

			return $this->wonkasoft_gr_make_call( $url );
	}

	/**
	 * Create cart
	 *
	 * @param  array $passed_query Contains array of passed params.
	 * @return object              returns response object.
	 */
	public function create_cart( $passed_query = null ) {

		if ( empty( $passed_query ) ) {
			return array( 'error' => 'An array query must be passed into this function.' );
		}

		$payload = array(
			'contactId'        => ( ! empty( $passed_query['contact_id'] ) ? $passed_query['contact_id'] : null ),
			'totalPrice'       => ( ! empty( $passed_query['total_price'] ) ? $passed_query['total_price'] : null ),
			'totalTaxPrice'    => ( ! empty( $passed_query['total_tax_price'] ) ? $passed_query['total_tax_price'] : null ),
			'currency'         => ( ! empty( $passed_query['currency'] ) ? $passed_query['currency'] : null ),
			'selectedVariants' => ( ! empty( $passed_query['selected_variants'] ) ? $passed_query['selected_variants'] : null ),
			'externalId'       => ( ! empty( $passed_query['external_id'] ) ? $passed_query['external_id'] : null ),
			'cartUrl'          => ( ! empty( $passed_query['cart_url'] ) ? $passed_query['cart_url'] : null ),
		);
		$shop_id = $this->shop_id;
		$payload = json_encode( $payload );
		$url     = $this->getresponse_url . "/shops/$shop_id/carts";

		return $this->wonkasoft_gr_make_call( $url, 'POST', $payload );
	}

	/**
	 * Get cart by ID
	 *
	 * @param  array $passed_query Contains passed in params.
	 * @return object               returns response object.
	 */
	public function get_cart_by_ID( $passed_query = null ) {
		if ( ! empty( $passed_query ) ) {
			$current_query = $passed_query;
		} else {
			$current_query = array(
				'fields' => ( ( ! empty( $padded_query['fields'] ) ) ? $padded_query['fields'] : null ),
			);
		}

		$shop_id       = $this->shop_id;
		$cart_id       = $this->cart_id;
		$current_query = json_decode( json_encode( $current_query ) );
		$current_query = http_build_query( $current_query );
		$url           = $this->getresponse_url . "/shops/$shop_id/carts/$cart_id?$current_query";

		return $this->wonkasoft_gr_make_call( $url );
	}

	/**
	 * Update cart
	 *
	 * @param  array $passed_query Contains passed in params.
	 * @return object              returns response object.
	 */
	public function update_cart( $passed_query = null ) {
		if ( empty( $passed_query ) ) {
			return array( 'error' => 'An array query must be passed into this function.' );
		}

		$payload = array(
			'contactId'        => ( ! empty( $passed_query['contact_id'] ) ? $passed_query['contact_id'] : null ),
			'totalPrice'       => ( ! empty( $passed_query['total_price'] ) ? $passed_query['total_price'] : null ),
			'totalTaxPrice'    => ( ! empty( $passed_query['total_tax_price'] ) ? $passed_query['total_tax_price'] : null ),
			'currency'         => ( ! empty( $passed_query['currency'] ) ? $passed_query['currency'] : null ),
			'selectedVariants' => array(
				'variantId' => ( ! empty( $passed_query['variant_id'] ) ? $passed_query['variant_id'] : null ),
				'quantity'  => ( ! empty( $passed_query['quantity'] ) ? $passed_query['quantity'] : null ),
				'price'     => ( ! empty( $passed_query['price'] ) ? $passed_query['price'] : null ),
				'priceTax'  => ( ! empty( $passed_query['priceTax'] ) ? $passed_query['priceTax'] : null ),
			),
			'externalId'       => ( ! empty( $passed_query['external_id'] ) ? $passed_query['external_id'] : null ),
			'cartUrl'          => ( ! empty( $passed_query['cart_url'] ) ? $passed_query['cart_url'] : null ),
		);
		$shop_id = $this->shop_id;
		$cart_id = $this->cart_id;
		$payload = json_encode( $payload );
		$url     = $this->getresponse_url . "/shops/$shop_id/carts/$cart_id";

		return $this->wonkasoft_gr_make_call( $url, 'POST', $payload );
	}

	/**
	 * Delete cart
	 *
	 * @param  array $passed_query Contains passed in params.
	 * @return object              returns response object.
	 */
	public function delete_cart( $passed_query = null ) {
		if ( empty( $this->shop_id ) || empty( $this->cart_id ) ) {
			return array(
				'error'   => 'Variables must be before this function is run.',
				'shop_id' => ( empty( $this->shop_id ) ? 'instance variable needs to be set.' : $this->shop_id ),
				'cart_id' => ( empty( $this->cart_id ) ? 'instance variable needs to be set.' : $this->cart_id ),
			);
		}

		$shop_id = $this->shop_id;
		$cart_id = $this->cart_id;
		$url     = $this->getresponse_url . "/shops/$shop_id/carts/$cart_id";

		return $this->wonkasoft_gr_make_call( $url, 'DELETE' );
	}

	/**
	 *
	 * Orders
	 */

	/**
	 * Get the list of orders
	 *
	 * @param  array $passed_query Contains passed in params.
	 * @return object              returns response object.
	 */
	public function get_order_list( $passed_query = null ) {
		if ( ! empty( $passed_query ) ) {
			$current_query = $passed_query;
		} else {
			$current_query = array(
				'query'   => array(
					'description' => ( ( ! empty( $passed_query['query']['description'] ) ) ? $passed_query['query']['description'] : null ),
					'status'      => ( ( ! empty( $passed_query['query']['status'] ) ) ? $passed_query['query']['status'] : null ),
					'category'    => ( ( ! empty( $passed_query['query']['category'] ) ) ? $passed_query['query']['category'] : null ),
					'externalId'  => ( ( ! empty( $passed_query['query']['external_id'] ) ) ? $passed_query['query']['external_id'] : null ),
					'processedAt' => array(
						'from' => ( ( ! empty( $passed_query['query']['processed_at']['from'] ) ) ? $passed_query['query']['processed_at']['from'] : null ),
						'to'   => ( ( ! empty( $passed_query['query']['processed_at']['to'] ) ) ? $passed_query['query']['processed_at']['to'] : null ),
					),
				),
				'sort'    => array(
					'createdOn' => ( ( ! empty( $passed_query['sort']['created_on'] ) ) ? $passed_query['sort']['created_on'] : 'ASC' ),
				),
				'fields'  => ( ( ! empty( $passed_query['fields'] ) ) ? $passed_query['fields'] : null ),
				'perPage' => ( ( ! empty( $passed_query['perPage'] ) ) ? $passed_query['perPage'] : null ),
				'page'    => ( ( ! empty( $passed_query['page'] ) ) ? $passed_query['page'] : null ),
			);
		}

		$shop_id       = $this->shop_id;
		$current_query = json_decode( json_encode( $current_query ) );
		$current_query = http_build_query( $current_query );
		$url           = $this->getresponse_url . "/shops/$shop_id/orders?$current_query";

		return $this->wonkasoft_gr_make_call( $url );
	}

	/**
	 * Create order
	 * $payload = array(
	 *   'additionalFlags'   => string, ex. 'skipAutomation'
	 *   'selectedVariants'   => array(
	 *      'variantId' => string,
	 *      'price' => number,
	 *      'priceTax' => number,
	 *      'quantity' => int,
	 *      'taxes' => array(
	 *          'name' => string,
	 *          'rate' => number,
	 *      ),
	 *   ),
	 *   'contactId'   => string,
	 *   'orderUrl'   => string,
	 *   'externalId'   => string,
	 *   'totalPrice'   => number,
	 *   'totalPriceTax'   => number,
	 *   'currency'   => string,
	 *   'status'   => string,
	 *   'cartId'   => string,
	 *   'description'   => string,
	 *   'shippingPrice'   => number,
	 *   'shippingAddress'   => array(
	 *      'countryCode'   => string,
	 *      'name'   => string,
	 *      'firstName'   => string,
	 *      'lastName'   => string,
	 *      'address1'   => string,
	 *      'address2'   => string,
	 *      'city'   => string,
	 *      'zip'   => string,
	 *      'province'   => string,
	 *      'provinceCode'   => string,
	 *      'phone'   => string,
	 *      'company'   => string,
	 *   ),
	 *   'billingStatus'   => string,
	 *   'billingAddress'   => array(
	 *      'countryCode'   => string,
	 *      'name'   => string,
	 *      'firstName'   => string,
	 *      'lastName'   => string,
	 *      'address1'   => string,
	 *      'address2'   => string,
	 *      'city'   => string,
	 *      'zip'   => string,
	 *      'province'   => string,
	 *      'provinceCode'   => string,
	 *      'phone'   => string,
	 *      'company'   => string,
	 *   ),
	 *   'processedAt'   => string,
	 *   'metaFields'   => array(
	 *      array(
	 *          'name'   => string,
	 *          'value'   => string,
	 *          'valueType'   => "string" or "integer",
	 *          'description'   => string,
	 *      ),
	 *    ),
	 * );
	 *
	 * @param  array $passed_query Contains passed in params.
	 * @return object              returns response object.
	 */
	public function create_order( $passed_query = null ) {
		if ( empty( $passed_query ) ) {
			return array( 'error' => 'An array query must be passed into this function.' );
		}

		$current_query = array(
			'additionalFlags' => ( ( ! empty( $passed_query['additional_flags'] ) ) ? $passed_query['additional_flags'] : null ),
		);

		$payload = array(
			'selectedVariants' => ( ( ! empty( $passed_query['selected_variants'] ) ) ? $passed_query['selected_variants'] : null ),
			'contactId'        => ( ( ! empty( $passed_query['contact_id'] ) ) ? $passed_query['contact_id'] : null ),
			'orderUrl'         => ( ( ! empty( $passed_query['order_url'] ) ) ? $passed_query['order_url'] : null ),
			'externalId'       => ( ( ! empty( $passed_query['external_id'] ) ) ? $passed_query['external_id'] : null ),
			'totalPrice'       => ( ( ! empty( $passed_query['total_price'] ) ) ? $passed_query['total_price'] : null ),
			'totalPriceTax'    => ( ( ! empty( $passed_query['total_price_tax'] ) ) ? $passed_query['total_price_tax'] : null ),
			'currency'         => ( ( ! empty( $passed_query['currency'] ) ) ? $passed_query['currency'] : null ),
			'status'           => ( ( ! empty( $passed_query['status'] ) ) ? $passed_query['status'] : null ),
			'cartId'           => ( ( ! empty( $passed_query['cart_id'] ) ) ? $passed_query['cart_id'] : null ),
			'description'      => ( ( ! empty( $passed_query['description'] ) ) ? $passed_query['description'] : null ),
			'shippingPrice'    => ( ( ! empty( $passed_query['shipping_price'] ) ) ? $passed_query['shipping_price'] : null ),
			'shippingAddress'  => ( ( ! empty( $passed_query['shipping_address'] ) ) ? $passed_query['shipping_address'] : null ),
			'billingStatus'    => ( ( ! empty( $passed_query['billing_status'] ) ) ? $passed_query['billing_status'] : null ),
			'billingAddress'   => ( ( ! empty( $passed_query['billing_address'] ) ) ? $passed_query['billing_address'] : null ),
			'processedAt'      => ( ( ! empty( $passed_query['processed_at'] ) ) ? $passed_query['processed_at'] : null ),
			'metaFields'       => ( ( ! empty( $passed_query['meta_fields'] ) ) ? $passed_query['meta_fields'] : null ),
		);

		$shop_id       = $this->shop_id;
		$current_query = json_decode( json_encode( $current_query ) );
		$current_query = http_build_query( $current_query );
		$payload       = json_encode( $payload );
		$url           = $this->getresponse_url . "/shops/$shop_id/products?$current_query";

		return $this->wonkasoft_gr_make_call( $url, 'POST', $payload );
	}

	/**
	 *
	 * Products
	 */

	/**
	 * Get a product list
	 *
	 * @param  array $passed_query Contains passed in params.
	 * @return object              returns response object.
	 */
	public function get_product_list( $passed_query = null ) {
		if ( ! empty( $passed_query ) ) {
			$current_query = $passed_query;
		} else {
			$current_query = array(
				'query'   => array(
					'name'            => ( ( ! empty( $passed_query['query']['name'] ) ) ? $passed_query['query']['name'] : null ),
					'vendor'          => ( ( ! empty( $passed_query['query']['vendor'] ) ) ? $passed_query['query']['vendor'] : null ),
					'category'        => ( ( ! empty( $passed_query['query']['category'] ) ) ? $passed_query['query']['category'] : null ),
					'categoryId'      => ( ( ! empty( $passed_query['query']['category_id'] ) ) ? $passed_query['query']['category_id'] : null ),
					'externalId'      => ( ( ! empty( $passed_query['query']['external_id'] ) ) ? $passed_query['query']['external_id'] : null ),
					'variantName'     => ( ( ! empty( $passed_query['query']['variant_name'] ) ) ? $passed_query['query']['variant_name'] : null ),
					'metaFieldNames'  => ( ( ! empty( $passed_query['query']['meta_field_names'] ) ) ? $passed_query['query']['meta_field_names'] : null ),
					'metaFieldValues' => ( ( ! empty( $passed_query['query']['meta_field_values'] ) ) ? $passed_query['query']['meta_field_values'] : null ),
					'createdOn'       => array(
						'from' => ( ( ! empty( $passed_query['query']['created_on']['from'] ) ) ? $passed_query['query']['created_on']['from'] : null ),
						'to'   => ( ( ! empty( $passed_query['query']['created_on']['to'] ) ) ? $passed_query['query']['created_on']['to'] : null ),
					),
				),
				'sort'    => array(
					'name'      => ( ( ! empty( $passed_query['sort']['name'] ) ) ? $passed_query['sort']['name'] : null ),
					'createdOn' => ( ( ! empty( $passed_query['sort']['created_on'] ) ) ? $passed_query['sort']['created_on'] : null ),
				),
				'fields'  => ( ( ! empty( $passed_query['fields'] ) ) ? $passed_query['fields'] : null ),
				'perPage' => ( ( ! empty( $passed_query['perPage'] ) ) ? $passed_query['perPage'] : null ),
				'page'    => ( ( ! empty( $passed_query['page'] ) ) ? $passed_query['page'] : null ),
			);
		}

		$shop_id       = $this->shop_id;
		$current_query = json_decode( json_encode( $current_query ) );
		$current_query = http_build_query( $current_query );
		$url           = $this->getresponse_url . "/shops/$shop_id/products?$current_query";

		return $this->wonkasoft_gr_make_call( $url );
	}

	/**
	 * Create product
	 * $payload = array(
	 *   'name'   => string,
	 *   'type'   => string,
	 *   'url'   => string,
	 *   'vendor'   => string,
	 *   'externalId'   => string,
	 *   'categories'   => array(
	 *          array(
	 *              'name'   => string,
	 *              'parentId'   => string,
	 *              'isDefault'   => boolean,
	 *              'url'   => string,
	 *              'externalId'   => string,
	 *           ),
	 *      ),
	 *   'variants'   => array(
	 *      array(
	 *          'name'   => string,
	 *          'url'   => string,
	 *          'sku'   => string,
	 *          'price'   => number,
	 *          'priceTax'   => number,
	 *          'previousPrice'   => number,
	 *          'previousPriceTax'   => number,
	 *          'quantity'   => integer,
	 *          'position'   => integer,
	 *          'barcode'   => string,
	 *          'externalId'   => string,
	 *          'description'   => string,
	 *          'images'   => array(
	 *              array(
	 *                  'src'   => string,
	 *                  'position'   => integer,
	 *              ),
	 *          ),
	 *          'metaFields'   => array(
	 *              array(
	 *                  'name'   => string,
	 *                  'value'   => string,
	 *                  'valueType'   => "string" or "integer",
	 *                  'description'   => string,
	 *              ),
	 *          ),
	 *          'taxes'   => array(
	 *              array(
	 *                  'name'   => string,
	 *                  'rate'   => string,
	 *              ),
	 *          ),
	 *      ),
	 *   ),
	 *   'metaFields'   => array(
	 *      array(
	 *          'name'   => string,
	 *          'value'   => string,
	 *          'valueType'   => "string" or "integer",
	 *          'description'   => string,
	 *      ),
	 *    ),
	 * );
	 *
	 * @param  array $passed_query Contains passed in params.
	 * @return object              returns response object.
	 */
	public function create_product( $passed_query = null ) {
		if ( empty( $passed_query ) ) {
			return array( 'error' => 'An array query must be passed into this function.' );
		}

		$payload = array(
			'name'       => ( ! empty( $passed_query['name'] ) ? $passed_query['name'] : null ),
			'type'       => ( ! empty( $passed_query['type'] ) ? $passed_query['type'] : null ),
			'url'        => ( ! empty( $passed_query['url'] ) ? $passed_query['url'] : null ),
			'vendor'     => ( ! empty( $passed_query['vendor'] ) ? $passed_query['vendor'] : null ),
			'externalId' => ( ! empty( $passed_query['external_id'] ) ? $passed_query['external_id'] : null ),
			'categories' => ( ! empty( $passed_query['categories'] ) ? $passed_query['categories'] : null ),
			'variants'   => ( ! empty( $passed_query['variants'] ) ? $passed_query['variants'] : null ),
			'metaFields' => ( ! empty( $passed_query['metaFields'] ) ? $passed_query['metaFields'] : null ),
		);
		$shop_id = $this->shop_id;
		$payload = json_encode( $payload );
		$url     = $this->getresponse_url . "/shops/$shop_id/products";

		return $this->wonkasoft_gr_make_call( $url, 'POST', $payload );
	}

	/**
	 * Get single product by ID
	 *
	 * @param  array $passed_query Contains passed in params.
	 * @return object              returns response object.
	 */
	public function get_single_product_by_ID( $passed_query = null ) {
		if ( ! empty( $passed_query ) ) {
			$current_query = $passed_query;
		} else {
			$current_query = array(
				'fields' => '',
			);
		}

		$shop_id       = $this->shop_id;
		$product_id    = $this->product_id;
		$current_query = json_decode( json_encode( $current_query ) );
		$current_query = http_build_query( $current_query );
		$url           = $this->getresponse_url . "/shops/$shop_id/products/$product_id";

		return $this->wonkasoft_gr_make_call( $url );
	}

	/**
	 * Update product
	 * $payload = array(
	 *   'name'   => string,
	 *   'type'   => string,
	 *   'url'   => string,
	 *   'vendor'   => string,
	 *   'externalId'   => string,
	 *   'categories'   => array(
	 *          array(
	 *              'name'   => string,
	 *              'parentId'   => string,
	 *              'isDefault'   => boolean,
	 *              'url'   => string,
	 *              'externalId'   => string,
	 *           ),
	 *      ),
	 *   'variants'   => array(
	 *      array(
	 *          'name'   => string,
	 *          'url'   => string,
	 *          'sku'   => string,
	 *          'price'   => number,
	 *          'priceTax'   => number,
	 *          'previousPrice'   => number,
	 *          'previousPriceTax'   => number,
	 *          'quantity'   => integer,
	 *          'position'   => integer,
	 *          'barcode'   => string,
	 *          'externalId'   => string,
	 *          'description'   => string,
	 *          'images'   => array(
	 *              array(
	 *                  'src'   => string,
	 *                  'position'   => integer,
	 *              ),
	 *          ),
	 *          'metaFields'   => array(
	 *              array(
	 *                  'name'   => string,
	 *                  'value'   => string,
	 *                  'valueType'   => "string" or "integer",
	 *                  'description'   => string,
	 *              ),
	 *          ),
	 *          'taxes'   => array(
	 *              array(
	 *                  'name'   => string,
	 *                  'rate'   => string,
	 *              ),
	 *          ),
	 *      ),
	 *   ),
	 *   'metaFields'   => array(
	 *      array(
	 *          'name'   => string,
	 *          'value'   => string,
	 *          'valueType'   => "string" or "integer",
	 *          'description'   => string,
	 *      ),
	 *    ),
	 * );
	 *
	 * @param  array $passed_query Contains passed in params.
	 * @return object              returns response object.
	 */
	public function update_product( $passed_query = null ) {
		if ( empty( $passed_query ) ) {
			return array( 'error' => 'An array query must be passed into this function.' );
		}

		$payload    = array(
			'name'       => ( ! empty( $passed_query['name'] ) ? $passed_query['name'] : null ),
			'type'       => ( ! empty( $passed_query['type'] ) ? $passed_query['type'] : null ),
			'url'        => ( ! empty( $passed_query['url'] ) ? $passed_query['url'] : null ),
			'vendor'     => ( ! empty( $passed_query['vendor'] ) ? $passed_query['vendor'] : null ),
			'externalId' => ( ! empty( $passed_query['external_id'] ) ? $passed_query['external_id'] : null ),
			'categories' => ( ! empty( $passed_query['categories'] ) ? $passed_query['categories'] : null ),
			'variants'   => ( ! empty( $passed_query['variants'] ) ? $passed_query['variants'] : null ),
			'metaFields' => ( ! empty( $passed_query['metaFields'] ) ? $passed_query['metaFields'] : null ),
		);
		$shop_id    = $this->shop_id;
		$product_id = $passed_query['product_id'];
		$payload    = json_encode( $payload );
		$url        = $this->getresponse_url . "/shops/$shop_id/products/$product_id";

		return $this->wonkasoft_gr_make_call( $url, 'POST', $payload );
	}

	/**
	 * Delete product
	 *
	 * @param  array $passed_query Contains passed in params.
	 * @return object              returns response object.
	 */
	public function delete_product() {
		if ( empty( $this->shop_id ) || empty( $this->product_id ) ) {
			return array(
				'error'      => 'Variables must be before this function is run.',
				'shop_id'    => ( empty( $this->shop_id ) ? 'instance variable needs to be set.' : $this->shop_id ),
				'product_id' => ( empty( $this->product_id ) ? 'instance variable needs to be set.' : $this->product_id ),
			);
		}

		$shop_id    = $this->shop_id;
		$product_id = $this->product_id;
		$url        = $this->getresponse_url . "/shops/$shop_id/products/$product_id";

		return $this->wonkasoft_gr_make_call( $url, 'DELETE' );
	}

	/**
	 * Upsert product categories
	 * $payload = array(
	 *   'categories'   => array(
	 *          array(
	 *              'categoryId'   => string,
	 *              'isDefault'   => boolean,
	 *          ),
	 *      ),
	 * );
	 *
	 * @param  array $passed_query Contains passed in params.
	 * @return object              returns response object.
	 */
	public function upsert_product_categories( $passed_query = null ) {
		if ( empty( $passed_query ) ) {
			return array( 'error' => 'An array query must be passed into this function.' );
		}

		$payload    = array(
			'categories' => ( ! empty( $passed_query['categories'] ) ? $passed_query['categories'] : null ),
		);
		$shop_id    = $this->shop_id;
		$product_id = $passed_query['product_id'];
		$payload    = json_encode( $payload );
		$url        = $this->getresponse_url . "/shops/$shop_id/products/$product_id/categories";

		return $this->wonkasoft_gr_make_call( $url, 'POST', $payload );
	}

	/**
	 * Upsert product meta fields
	 * $payload = array(
	 *   'metaFields'   => array(
	 *      array(
	 *          'metaFieldId'   => string,
	 *      ),
	 *    ),
	 * );
	 *
	 * @param  array $passed_query Contains passed in params.
	 * @return object              returns response object.
	 */
	public function upsert_product_meta_fields( $passed_query = null ) {
		if ( empty( $passed_query ) ) {
			return array( 'error' => 'An array query must be passed into this function.' );
		}

		$payload    = array(
			'metaFields' => ( ! empty( $passed_query['metaFields'] ) ? $passed_query['metaFields'] : null ),
		);
		$shop_id    = $this->shop_id;
		$product_id = $passed_query['product_id'];
		$payload    = json_encode( $payload );
		$url        = $this->getresponse_url . "/shops/$shop_id/products/$product_id/meta-fields";

		return $this->wonkasoft_gr_make_call( $url, 'POST', $payload );
	}

	/**
	 *
	 * Product Variants
	 */

	/**
	 * Get a list of product variants
	 *
	 * @param  array $passed_query Contains passed in params.
	 * @return object              returns response object.
	 */
	public function get_list_of_product_variants( $passed_query = null ) {
		if ( ! empty( $passed_query ) ) {
			$current_query = $passed_query;
		} else {
			$current_query = array(
				'query'   => array(
					'name'        => ( ( ! empty( $passed_query['query']['name'] ) ) ? $passed_query['query']['name'] : null ),
					'sku'         => ( ( ! empty( $passed_query['query']['sku'] ) ) ? $passed_query['query']['sku'] : null ),
					'description' => ( ( ! empty( $passed_query['query']['description'] ) ) ? $passed_query['query']['description'] : null ),
					'externalId'  => ( ( ! empty( $passed_query['query']['external_id'] ) ) ? $passed_query['query']['external_id'] : null ),
					'createdAt'   => array(
						'from' => ( ( ! empty( $passed_query['query']['created_at']['from'] ) ) ? $passed_query['query']['created_at']['from'] : null ),
						'to'   => ( ( ! empty( $passed_query['query']['created_at']['to'] ) ) ? $passed_query['query']['created_at']['to'] : null ),
					),
				),
				'sort'    => array(
					'createdOn' => ( ( ! empty( $passed_query['sort']['created_on'] ) ) ? $passed_query['sort']['created_on'] : null ),
				),
				'fields'  => ( ( ! empty( $passed_query['fields'] ) ) ? $passed_query['fields'] : null ),
				'perPage' => ( ( ! empty( $passed_query['perPage'] ) ) ? $passed_query['perPage'] : null ),
				'page'    => ( ( ! empty( $passed_query['page'] ) ) ? $passed_query['page'] : null ),
			);
		}

		$shop_id       = $this->shop_id;
		$product_id    = $this->product_id;
		$current_query = json_decode( json_encode( $current_query ) );
		$current_query = http_build_query( $current_query );
		$url           = $this->getresponse_url . "/shops/$shop_id/products/$product_id/variants?$current_query";

		return $this->wonkasoft_gr_make_call( $url );
	}

	/**
	 * Create product variant
	 * $payload = array(
	 *   'name'   => string,
	 *   'url'   => string,
	 *   'sku'   => string,
	 *   'price'   => number,
	 *   'priceTax'   => number,
	 *   'previousPrice'   => number,
	 *   'previousPriceTax'   => number,
	 *   'quantity'   => integer,
	 *   'position'   => integer,
	 *   'barcode'   => string,
	 *   'externalId'   => string,
	 *   'description'   => string,
	 *   'images'   => array(
	 *      array(
	 *          'src'   => string,
	 *          'position'   => integer,
	 *      ),
	 *    ),
	 *    'metaFields'   => array(
	 *      array(
	 *          'name'   => string,
	 *          'value'   => string,
	 *          'valueType'   => "string" or "integer",
	 *          'description'   => string,
	 *        ),
	 *    ),
	 *    'taxes'   => array(
	 *      array(
	 *          'name'   => string,
	 *          'rate'   => string,
	 *        ),
	 *    ),
	 * );
	 *
	 * @param  array $passed_query Contains passed in params.
	 * @return object              returns response object.
	 */
	public function create_product_variant( $passed_query = null ) {
		if ( empty( $passed_query ) ) {
			return array( 'error' => 'An array query must be passed into this function.' );
		}

		$payload    = array(
			'name'             => ( ! empty( $passed_query['name'] ) ? $passed_query['name'] : null ),
			'url'              => ( ! empty( $passed_query['url'] ) ? $passed_query['url'] : null ),
			'sku'              => ( ! empty( $passed_query['sku'] ) ? $passed_query['sku'] : null ),
			'price'            => ( ! empty( $passed_query['price'] ) ? $passed_query['price'] : null ),
			'priceTax'         => ( ! empty( $passed_query['price_tax'] ) ? $passed_query['price_tax'] : null ),
			'previousPrice'    => ( ! empty( $passed_query['previous_price'] ) ? $passed_query['previous_price'] : null ),
			'previousPriceTax' => ( ! empty( $passed_query['previous_price_tax'] ) ? $passed_query['previous_price_tax'] : null ),
			'quantity'         => ( ! empty( $passed_query['quantity'] ) ? $passed_query['quantity'] : null ),
			'position'         => ( ! empty( $passed_query['position'] ) ? $passed_query['position'] : null ),
			'barcode'          => ( ! empty( $passed_query['barcode'] ) ? $passed_query['barcode'] : null ),
			'externalId'       => ( ! empty( $passed_query['external_id'] ) ? $passed_query['external_id'] : null ),
			'description'      => ( ! empty( $passed_query['description'] ) ? $passed_query['description'] : null ),
			'images'           => ( ! empty( $passed_query['images'] ) ? $passed_query['images'] : null ),
			'metaFields'       => ( ! empty( $passed_query['metaFields'] ) ? $passed_query['metaFields'] : null ),
			'taxes'            => ( ! empty( $passed_query['taxes'] ) ? $passed_query['taxes'] : null ),
		);
		$shop_id    = $this->shop_id;
		$product_id = $this->product_id;
		$payload    = json_encode( $payload );
		$url        = $this->getresponse_url . "/shops/$shop_id/products/$product_id/variants";

		return $this->wonkasoft_gr_make_call( $url, 'POST', $payload );
	}

	/**
	 * Get a single product variant by ID
	 *
	 * @param  array $passed_query Contains passed in params.
	 * @return object              returns response object.
	 */
	public function get_single_product_variant_by_ID( $passed_query = null ) {
		if ( ! empty( $passed_query ) ) {
			$current_query = $passed_query;
		} else {
			$current_query = array(
				'fields' => ( ( ! empty( $passed_query['fields'] ) ) ? $passed_query['fields'] : null ),
			);
		}

		$shop_id       = $this->shop_id;
		$product_id    = $this->product_id;
		$variant_id    = $this->variant_id;
		$current_query = json_decode( json_encode( $current_query ) );
		$current_query = http_build_query( $current_query );
		$url           = $this->getresponse_url . "/shops/$shop_id/products/$product_id/variants/$variant_id?$current_query";

		return $this->wonkasoft_gr_make_call( $url );
	}

	/**
	 * Update product variant
	 * $payload = array(
	 *   'name'   => string,
	 *   'url'   => string,
	 *   'sku'   => string,
	 *   'price'   => number,
	 *   'priceTax'   => number,
	 *   'previousPrice'   => number,
	 *   'previousPriceTax'   => number,
	 *   'quantity'   => integer,
	 *   'position'   => integer,
	 *   'barcode'   => string,
	 *   'externalId'   => string,
	 *   'description'   => string,
	 *   'images'   => array(
	 *      array(
	 *          'src'   => string,
	 *          'position'   => integer,
	 *      ),
	 *   ),
	 *   'metaFields'   => array(
	 *      array(
	 *          'name'   => string,
	 *          'value'   => string,
	 *          'valueType'   => "string" or "integer",
	 *          'description'   => string,
	 *        ),
	 *   ),
	 *   'taxes'   => array(
	 *      array(
	 *          'name'   => string,
	 *          'rate'   => string,
	 *        ),
	 *   ),
	 * );
	 *
	 * @param  array $passed_query Contains passed in params.
	 * @return object              returns response object.
	 */
	public function update_product_variant( $passed_query = null ) {
		if ( empty( $passed_query ) ) {
			return array( 'error' => 'An array query must be passed into this function.' );
		}

		$payload    = array(
			'name'             => ( ! empty( $passed_query['name'] ) ? $passed_query['name'] : null ),
			'url'              => ( ! empty( $passed_query['url'] ) ? $passed_query['url'] : null ),
			'sku'              => ( ! empty( $passed_query['sku'] ) ? $passed_query['sku'] : null ),
			'price'            => ( ! empty( $passed_query['price'] ) ? $passed_query['price'] : null ),
			'priceTax'         => ( ! empty( $passed_query['price_tax'] ) ? $passed_query['price_tax'] : null ),
			'previousPrice'    => ( ! empty( $passed_query['previous_price'] ) ? $passed_query['previous_price'] : null ),
			'previousPriceTax' => ( ! empty( $passed_query['previous_price_tax'] ) ? $passed_query['previous_price_tax'] : null ),
			'quantity'         => ( ! empty( $passed_query['quantity'] ) ? $passed_query['quantity'] : null ),
			'position'         => ( ! empty( $passed_query['position'] ) ? $passed_query['position'] : null ),
			'barcode'          => ( ! empty( $passed_query['barcode'] ) ? $passed_query['barcode'] : null ),
			'externalId'       => ( ! empty( $passed_query['external_id'] ) ? $passed_query['external_id'] : null ),
			'description'      => ( ! empty( $passed_query['description'] ) ? $passed_query['description'] : null ),
			'images'           => ( ! empty( $passed_query['images'] ) ? $passed_query['images'] : null ),
			'metaFields'       => ( ! empty( $passed_query['metaFields'] ) ? $passed_query['metaFields'] : null ),
			'taxes'            => ( ! empty( $passed_query['taxes'] ) ? $passed_query['taxes'] : null ),
		);
		$shop_id    = $this->shop_id;
		$product_id = $this->product_id;
		$variant_id = $this->variant_id;
		$payload    = json_encode( $payload );
		$url        = $this->getresponse_url . "/shops/$shop_id/products/$product_id/variants/$variant_id";

		return $this->wonkasoft_gr_make_call( $url, 'POST', $payload );
	}

	/**
	 * Delete product variant
	 *
	 * @param  array $passed_query Contains passed in params.
	 * @return object              returns response object.
	 */
	public function delete_product_variant( $passed_query = null ) {
		if ( empty( $this->shop_id ) || empty( $this->product_id ) || empty( $this->variant_id ) ) {
			return array(
				'error'      => 'Variables must be before this function is run.',
				'shop_id'    => ( empty( $this->shop_id ) ? 'instance variable needs to be set.' : $this->shop_id ),
				'product_id' => ( empty( $this->product_id ) ? 'instance variable needs to be set.' : $this->product_id ),
				'variant_id' => ( empty( $this->variant_id ) ? 'instance variable needs to be set.' : $this->variant_id ),
			);
		}

		$shop_id    = $this->shop_id;
		$product_id = $this->product_id;
		$variant_id = $this->variant_id;
		$url        = $this->getresponse_url . "/shops/$shop_id/products/$product_id/variants/$variant_id";

		return $this->wonkasoft_gr_make_call( $url, 'DELETE' );
	}

	/**
	 *
	 * Shops
	 */

	/**
	 * Get a single shop by ID
	 *
	 * @param  array $passed_query Contains passed in params.
	 * @return object              returns response object.
	 */
	public function get_single_shop_by_ID( $passed_query = null ) {
		if ( ! empty( $passed_query ) ) {
			$current_query = $passed_query;
		} else {
			$current_query = array(
				'fields' => null,
			);
		}

		$shop_id       = $this->shop_id;
		$current_query = json_decode( json_encode( $current_query ) );
		$current_query = http_build_query( $current_query );
		$url           = $this->getresponse_url . "/shops/$shop_id?$current_query";

		return $this->wonkasoft_gr_make_call( $url );
	}

	/**
	 * Update shop
	 *
	 * @param  array $passed_query Contains passed in params.
	 * @return object              returns response object.
	 */
	public function update_shop( $passed_query = null ) {
		if ( empty( $passed_query ) ) {
			return array( 'error' => 'An array query must be passed into this function.' );
		}

		$payload = array(
			'name'     => ( ! empty( $passed_query['name'] ) ? $passed_query['name'] : null ),
			'locale'   => ( ! empty( $passed_query['locale'] ) ? $passed_query['locale'] : null ),
			'currency' => ( ! empty( $passed_query['currency'] ) ? $passed_query['currency'] : null ),
		);
		$shop_id = $this->shop_id;
		$payload = json_encode( $payload );
		$url     = $this->getresponse_url . "/shops/$shop_id";

		return $this->wonkasoft_gr_make_call( $url, 'POST', $payload );
	}

	/**
	 * Delete shop
	 *
	 * @param  array $passed_query Contains passed in params.
	 * @return object              returns response object.
	 */
	public function delete_shop( $passed_query = null ) {
		if ( empty( $this->shop_id ) ) {
			return array(
				'error'   => 'Variables must be before this function is run.',
				'shop_id' => ( empty( $this->shop_id ) ? 'instance variable needs to be set.' : $this->shop_id ),
			);
		}

		$shop_id = $this->shop_id;
		$url     = $this->getresponse_url . "/shops/$shop_id";

		return $this->wonkasoft_gr_make_call( $url, 'DELETE' );
	}

	/**
	 * Get a list of shops
	 *
	 * @param  array $passed_query Contains passed in params.
	 * @return object              returns response object.
	 */
	public function get_list_of_shops( $passed_query = null ) {
		if ( ! empty( $passed_query ) ) {
			$current_query = $passed_query;
		} else {
			$current_query = array(
				'query'   => array(
					'name' => ( ! empty( $passed_query['query']['name'] ) ? $passed_query['query']['name'] : null ),
				),
				'sort'    => array(
					'name'      => ( ! empty( $passed_query['sort']['name'] ) ? $passed_query['sort']['name'] : 'ASC' ),
					'createdOn' => ( ! empty( $passed_query['sort']['createdOn'] ) ? $passed_query['sort']['createdOn'] : 'ASC' ),
				),
				'fields'  => ( ! empty( $passed_query['fields'] ) ? $passed_query['fields'] : null ),
				'perPage' => ( ! empty( $passed_query['perPage'] ) ? $passed_query['perPage'] : null ),
				'page'    => ( ! empty( $passed_query['page'] ) ? $passed_query['page'] : null ),
			);
		}

		$current_query = json_decode( json_encode( $current_query ) );
		$current_query = http_build_query( $current_query );
		$url           = $this->getresponse_url . "/shops?$current_query";

		return $this->wonkasoft_gr_make_call( $url );
	}

	/**
	 * Create shop
	 *
	 * @param  array $passed_query Contains passed in params.
	 * @return object              returns response object.
	 */
	public function create_shop( $passed_query = null ) {
		if ( empty( $passed_query ) ) {
			return array( 'error' => 'An array query must be passed into this function.' );
		}

		$payload = array(
			'name'     => ( ! empty( $passed_query['name'] ) ? $passed_query['name'] : null ),
			'locale'   => ( ! empty( $passed_query['locale'] ) ? $passed_query['locale'] : null ),
			'currency' => ( ! empty( $passed_query['currency'] ) ? $passed_query['currency'] : null ),
		);

		$payload = json_encode( $payload );
		$url     = $this->getresponse_url . '/shops';

		return $this->wonkasoft_gr_make_call( $url, 'POST', $payload );
	}

	/**
	 *
	 * Taxes
	 */

	/**
	 * Get a list of taxes
	 *
	 * @param  array $passed_query Contains passed in params.
	 * @return object              returns response object.
	 */
	public function get_list_of_taxes( $passed_query = null ) {
		if ( ! empty( $passed_query ) ) {
			$current_query = $passed_query;
		} else {
			$current_query = array(
				'query'   => array(
					'name'      => ( ! empty( $passed_query['query']['name'] ) ? $passed_query['query']['name'] : null ),
					'createdOn' => array(
						'from' => ( ! empty( $passed_query['query']['createdOn']['from'] ) ? $passed_query['query']['createdOn']['from'] : null ),
						'to'   => ( ! empty( $passed_query['query']['createdOn']['to'] ) ? $passed_query['query']['createdOn']['to'] : null ),
					),
				),
				'sort'    => array(
					'createdOn' => ( ! empty( $passed_query['sort']['createdOn'] ) ? $passed_query['sort']['createdOn'] : 'ASC' ),
				),
				'fields'  => ( ! empty( $passed_query['fields'] ) ? $passed_query['fields'] : null ),
				'perPage' => ( ! empty( $passed_query['perPage'] ) ? $passed_query['perPage'] : null ),
				'page'    => ( ! empty( $passed_query['page'] ) ? $passed_query['page'] : null ),
			);
		}

		$shop_id       = $this->shop_id;
		$current_query = json_decode( json_encode( $current_query ) );
		$current_query = http_build_query( $current_query );
		$url           = $this->getresponse_url . "/shops/$shop_id/taxes?$current_query";

		return $this->wonkasoft_gr_make_call( $url );
	}

	/**
	 * Create tax
	 *
	 * @param  array $passed_query Contains passed in params.
	 * @return object              returns response object.
	 */
	public function create_tax( $passed_query = null ) {
		if ( empty( $passed_query ) ) {
			return array( 'error' => 'An array query must be passed into this function.' );
		}

		$payload = array(
			'name' => ( ! empty( $passed_query['name'] ) ? $passed_query['name'] : null ),
			'rate' => ( ! empty( $passed_query['rate'] ) ? $passed_query['rate'] : null ),
		);

		$shop_id = $this->shop_id;
		$payload = json_encode( $payload );
		$url     = $this->getresponse_url . "/shops/$shop_id/taxes";

		return $this->wonkasoft_gr_make_call( $url, 'POST', $payload );
	}

	/**
	 * Get a single tax by ID
	 *
	 * @param  array $passed_query Contains passed in params.
	 * @return object              returns response object.
	 */
	public function get_single_tax_by_ID( $passed_query = null ) {
		if ( ! empty( $passed_query ) ) {
			$current_query = $passed_query;
		} else {
			$current_query = array(
				'fields' => ( ! empty( $passed_query['fields'] ) ? $passed_query['fields'] : null ),
			);
		}

		$shop_id       = $this->shop_id;
		$tax_id        = $this->tax_id;
		$current_query = json_decode( json_encode( $current_query ) );
		$current_query = http_build_query( $current_query );
		$url           = $this->getresponse_url . "/shops/$shop_id/taxes/$tax_id?$current_query";

		return $this->wonkasoft_gr_make_call( $url );
	}

	/**
	 * Update tax
	 *
	 * @param  array $passed_query Contains passed in params.
	 * @return object              returns response object.
	 */
	public function update_tax( $passed_query = null ) {
		if ( empty( $passed_query ) ) {
			return array( 'error' => 'An array query must be passed into this function.' );
		}

		$payload = array(
			'name' => ( ! empty( $passed_query['name'] ) ? $passed_query['name'] : null ),
			'rate' => ( ! empty( $passed_query['rate'] ) ? $passed_query['rate'] : null ),
		);

		$shop_id = $this->shop_id;
		$tax_id  = $passed_query['tax_id'];
		$payload = json_encode( $payload );
		$url     = $this->getresponse_url . "/shops/$shop_id/taxes/$tax_id";

		return $this->wonkasoft_gr_make_call( $url, 'POST', $payload );
	}

	/**
	 * Delete tax by ID
	 *
	 * @param  array $passed_query Contains passed in params.
	 * @return object              returns response object.
	 */
	public function delete_tax_by_ID( $passed_query = null ) {
		if ( empty( $this->shop_id ) || empty( $this->tax_id ) ) {
			return array(
				'error'   => 'Variables must be before this function is run.',
				'shop_id' => ( empty( $this->shop_id ) ? 'instance variable needs to be set.' : $this->shop_id ),
				'tax_id'  => ( empty( $this->tax_id ) ? 'instance variable needs to be set.' : $this->tax_id ),
			);
		}

		$shop_id = $this->shop_id;
		$tax_id  = $this->tax_id;
		$url     = $this->getresponse_url . "/shops/$shop_id/taxes/$tax_id";

		return $this->wonkasoft_gr_make_call( $url, 'DELETE' );
	}

	private function wonkasoft_gr_make_call( $url, $type = 'GET', $payload = null ) {

		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $this->post_header );
		curl_setopt( $ch, CURLPROTO_HTTPS, true );
		switch ( $type ) :
			case 'DELETE':
				curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'DELETE' );
				break;
			case 'POST':
				curl_setopt( $ch, CURLOPT_POST, true );
				curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );

		endswitch;

		$response = curl_exec( $ch );

		if ( false === $response ) :
			$error_obj = array(
				'error'  => curl_error( $ch ),
				'status' => 'failed',
			);

			curl_close( $ch );

			$error_obj = json_decode( json_encode( $error_obj ) );

			return $error_obj;
		else :
			curl_close( $ch );
			$response = json_decode( $response );

			return $response;
		endif;

	}
}
