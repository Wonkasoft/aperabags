<?php
/**
 * This file is the main API for GetResponse
 *
 * @category   GetResponse API
 * @package    GetResponse
 * @author     Wonkasoft <Support@Wonkasoft.com>
 * @copyright  2019 Wonkasoft
 * @version    1.0.0
 * @since      1.0.0
 */

defined( 'ABSPATH' ) || exit;


/**
 * This is the class for the GetResponse API.
 */
class Wonkasoft_GetResponse_Api {

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

	/**
	 * Class Init constructor.
	 *
	 * @param array $data array of data for setting instance variables.
	 */
	public function __construct( $data = null ) {

		// whether ip is from share internet
		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		}
		// whether ip is from proxy
		elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		// whether ip is from remote address
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
		$this->campaign_list           = $this->get_a_list_of_campaigns();
		$this->custom_fields_list      = $this->get_a_list_of_custom_fields();
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

		$ch  = curl_init();
		$url = $this->getresponse_url . '/contacts/' . $this->contact_id;
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $this->post_header );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
		curl_setopt( $ch, CURLPROTO_HTTPS, true );

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

		$ch  = curl_init();
		$url = $this->getresponse_url . '/contacts';
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $this->post_header );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
		curl_setopt( $ch, CURLPROTO_HTTPS, true );

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

		$ch  = curl_init();
		$url = $this->getresponse_url . '/contacts/' . $this->contact_id . '/tags';
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $this->post_header );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
		curl_setopt( $ch, CURLPROTO_HTTPS, true );

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

		$ch  = curl_init();
		$url = $this->getresponse_url . '/tags?' . $current_query;
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $this->get_header );
		curl_setopt( $ch, CURLPROTO_HTTPS, true );

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

		$ch  = curl_init();
		$url = $this->getresponse_url . '/contacts?' . $current_query;
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $this->get_header );
		curl_setopt( $ch, CURLPROTO_HTTPS, true );

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
	public function get_a_list_of_campaigns( $passed_query = null ) {

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

		$ch  = curl_init();
		$url = $this->getresponse_url . '/campaigns?' . $current_query;
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $this->get_header );
		curl_setopt( $ch, CURLPROTO_HTTPS, true );

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
	public function get_a_list_of_custom_fields( $passed_query = null ) {

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

		$ch  = curl_init();
		$url = $this->getresponse_url . '/custom-fields?' . $current_query;
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $this->get_header );
		curl_setopt( $ch, CURLPROTO_HTTPS, true );

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

		$ch  = curl_init();
		$url = $this->getresponse_url . '/contacts/' . $this->contact_id . '/custom-fields';
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $this->post_header );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
		curl_setopt( $ch, CURLPROTO_HTTPS, true );

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

	/**
	 * Gets contact by ID
	 *
	 * @param array $passed_query contains passed query.
	 * @return object returns an object of a contacts details.
	 */
	public function get_contact_details_by_contact_id( $passed_id = null ) {

		if ( empty( $passed_id ) ) {
			$msg = 'No contact ID passed in to function.';
			return $msg;
		}

		$ch  = curl_init();
		$url = $this->getresponse_url . '/contacts/' . $passed_id;
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $this->get_header );
		curl_setopt( $ch, CURLPROTO_HTTPS, true );

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
