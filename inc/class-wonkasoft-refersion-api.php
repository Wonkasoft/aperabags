<?php
/**
 * Wonkasoft Refersion API
 *
 * @package aperabags
 * @link https://wonkasoft.com
 * @author Wonkasoft support@wonkasoft.com
 */

defined( 'ABSPATH' ) || exit;

/**
 * This is the class for Refersion integration
 */
class Wonkasoft_Refersion_API {

	/**
	 * Will hold passed in args
	 *
	 * @var array
	 */
	protected $data = array();

	/**
	 * Refersion Public Key.
	 *
	 * Your public API key.
	 *
	 * @var string
	 */
	protected $refersion_public_key = null;

	/**
	 * Refersion Secret Key.
	 *
	 * Your private API key.
	 *
	 * @var string
	 */
	private $refersion_secret_key = null;

	/**
	 * Affiliate Offer.
	 *
	 * Specifc Offer ID to opt affiliate into, otherwise your default offer is used.
	 *
	 * @var int
	 */
	protected $offer = 0;

	/**
	 * Affiliate first name.
	 *
	 * @var string
	 */
	protected $first_name = '';

	/**
	 * Affiliate last name.
	 *
	 * @var string
	 */
	protected $last_name = '';

	/**
	 * Affiliate Company.
	 *
	 * @var string
	 */
	protected $company = '';

	/**
	 * Affiliate email.
	 *
	 * Must be a valid email.
	 *
	 * @var string
	 */
	protected $email = '';

	/**
	 * Affiliate paypal email.
	 *
	 * If included, must be a valid email.
	 *
	 * @var string
	 */
	protected $paypal_email = '';

	/**
	 * Affiliate password.
	 *
	 * At least 6 characters.
	 *
	 * @var string
	 */
	protected $password = '';

	/**
	 * Affiliate address 1.
	 *
	 * @var string
	 */
	protected $address1 = '';

	/**
	 * Affiliate address 2.
	 *
	 * @var string
	 */
	protected $address2 = '';

	/**
	 * Affiliate city.
	 *
	 * @var string
	 */
	protected $city = '';

	/**
	 * Affiliate zip code.
	 *
	 * @var string
	 */
	protected $zip = '';

	/**
	 * Affiliate country.
	 *
	 * Country Code (two letter abbreviation) must match one of: US, UK, CA, AU, FR, GR, MX, NO, NL, NZ, ES.
	 *
	 * @var string
	 */
	protected $country = '';

	/**
	 * Affiliate state.
	 *
	 * State abbreviation.
	 *
	 * @var string
	 */
	protected $state = '';

	/**
	 * Affiliate phone.
	 *
	 * @var string
	 */
	protected $phone = '';

	/**
	 * Send welcome email.
	 *
	 * Should Refersion send our welcome email? Options: TRUE / FALSE; Default = FALSE.
	 *
	 * @var boolean
	 */
	protected $send_welcome = false;

	/**
	 * Affiliate code.
	 *
	 * The Refersion affiliate identifier. You would have captured this from the new_affiliate endpoint response.
	 *
	 * @var string
	 */
	protected $affiliate_code = '';

	/**
	 * Affiliate keyword.
	 *
	 * The keyword to search for. Can be the affiliate ID or registered email address. Affiliate ID must be exact and complete, but email can be a partial string.
	 *
	 * @var string
	 */
	protected $keyword = '';

	/**
	 * Search limit.
	 *
	 * Total that should be returned per API call. Maximum of 100 per call.
	 *
	 * @var string
	 */
	protected $limit = '';

	/**
	 * Set page offset.
	 *
	 * Page offset.
	 *
	 * @var string
	 */
	protected $page = '';

	/**
	 * Conversion Trigger Type.
	 *
	 * The type of Conversion Trigger. Accepted values are: COUPON, SKU, EMAIL.
	 *
	 * @var string
	 */
	protected $type = '';

	/**
	 * Trigger.
	 *
	 * The actual conversion trigger that should be set. For example, an email address for email triggers and a coupon code for coupon triggers.
	 *
	 * @var string
	 */
	protected $trigger = '';

	/**
	 * Offer id.
	 *
	 * @var string
	 */
	protected $offer_id = '';

	/**
	 * SKUS in an array of objects.
	 *
	 * Example.
	 * {
	 *  'sku':'TSHIRT-SMALL-RED',
	 *  'product_description':'T-Shirt Red (Small)',
	 *  'commission_type':'FLAT_RATE',
	 *  'commission_amount':'5'
	 * }
	 *
	 * @var array
	 */
	protected $skus = array();

	/**
	 * Array of convertion ids.
	 *
	 * @var array
	 */
	protected $conversion_ids = array();

	/**
	 * For Manual payment method.
	 *
	 * @var string
	 */
	protected $payment_method = 'MANUAL';

	/**
	 * The report ID of the report that you want to generate a download link for.
	 *
	 * @var string
	 */
	protected $report_id = '';

	/**
	 * Class Init constructor.
	 *
	 * @param array $data array of data for setting instance variables.
	 */
	public function __construct( $data = null ) {

		$this->data = ( ! empty( $data ) ) ? $data : null;

		$this->refersion_public_key = ( ! empty( get_option( 'refersion_public_key' ) ) ) ? get_option( 'refersion_public_key' ) : null;

		$this->refersion_secret_key = ( ! empty( get_option( 'refersion_secret_key' ) ) ) ? get_option( 'refersion_secret_key' ) : null;

		$this->offer = ( ! empty( $data['offer'] ) ) ? $data['offer'] : null;

		$this->first_name = ( ! empty( $data['first_name'] ) ) ? $data['first_name'] : null;

		$this->last_name = ( ! empty( $data['last_name'] ) ) ? $data['last_name'] : null;

		$this->company = ( ! empty( $data['company'] ) ) ? $data['company'] : null;

		$this->email = ( ! empty( $data['email'] ) ) ? $data['email'] : null;

		$this->paypal_email = ( ! empty( $data['paypal_email'] ) ) ? $data['paypal_email'] : null;

		$this->password = ( ! empty( $data['password'] ) ) ? $data['password'] : null;

		$this->address1 = ( ! empty( $data['address1'] ) ) ? $data['address1'] : null;

		$this->address2 = ( ! empty( $data['address2'] ) ) ? $data['address2'] : null;

		$this->city = ( ! empty( $data['city'] ) ) ? $data['city'] : null;

		$this->zip = ( ! empty( $data['zip'] ) ) ? $data['zip'] : null;

		$this->country = ( ! empty( $data['country'] ) ) ? $data['country'] : null;

		$this->state = ( ! empty( $data['state'] ) ) ? $data['state'] : null;

		$this->phone = ( ! empty( $data['phone'] ) ) ? $data['phone'] : null;

		$this->send_welcome = ( ! empty( $data['send_welcome'] ) ) ? $data['send_welcome'] : false;

		$this->affiliate_code = ( ! empty( $data['affiliate_code'] ) ) ? $data['affiliate_code'] : null;

		$this->keyword = ( ! empty( $data['keyword'] ) ) ? $data['keyword'] : null;

		$this->limit = ( ! empty( $data['limit'] ) ) ? $data['limit'] : null;

		$this->page = ( ! empty( $data['page'] ) ) ? $data['page'] : null;

		$this->type = ( ! empty( $data['type'] ) ) ? $data['type'] : null;

		$this->trigger = ( ! empty( $data['trigger'] ) ) ? $data['trigger'] : null;

		$this->offer_id = ( ! empty( $data['offer_id'] ) ) ? $data['offer_id'] : null;

		$this->conversion_ids = ( ! empty( $data['conversion_ids'] ) ) ? $data['conversion_ids'] : null;

		$this->report_id = ( ! empty( $data['report_id'] ) ) ? $data['report_id'] : null;
	}

	/**
	 * This Function is for checking the refersion api keys
	 *
	 * @rest_endpoint POST https://www.refersion.com/api/check_account
	 * @return array returns a json response from the api call.
	 */
	public function check_api_keys() {
		$ch = curl_init();
		$data = array(
			'refersion_public_key' => $this->refersion_public_key,
			'refersion_secret_key' => $this->refersion_secret_key,
		);

		$data = json_encode( $data );
		curl_setopt( $ch, CURLOPT_URL, 'https://www.refersion.com/api/check_account' );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: text/html' ) );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
		curl_setopt( $ch, CURLPROTO_HTTPS, true );

		$response = curl_exec( $ch );

		if ( false === $response ) :
			curl_close( $ch );
			return 'cURL Error: ' . curl_error( $ch );
		else :
			curl_close( $ch );
			return $response;
		endif;
	}

	/**
	 * This is for creating a new affiliate.
	 *
	 * @rest_endpoint POST https://www.refersion.com/api/new_affiliate
	 * @return object This will contain the new affiliates id and link.
	 */
	public function add_new_affiliate() {
		$ch = curl_init();
		$data = array(
			'refersion_public_key'  => $this->refersion_public_key,
			'refersion_secret_key'  => $this->refersion_secret_key,
			'offer'                 => $this->offer,
			'first_name'            => $this->first_name,
			'last_name'             => $this->last_name,
			'company'               => $this->company,
			'email'                 => $this->email,
			'paypal_email'          => $this->paypal_email,
			'password'              => $this->password,
			'address1'              => $this->address1,
			'address2'              => $this->address2,
			'city'                  => $this->city,
			'zip'                   => $this->zip,
			'country'               => $this->country,
			'state'                 => $this->state,
			'phone'                 => $this->phone,
			'send_welcome'          => $this->send_welcome,
		);

		$data = json_encode( $data );
		curl_setopt( $ch, CURLOPT_URL, 'https://www.refersion.com/api/new_affiliate' );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: text/html' ) );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
		curl_setopt( $ch, CURLPROTO_HTTPS, true );

		$response = curl_exec( $ch );

		if ( false === $response ) :
			curl_close( $ch );
			return 'cURL Error: ' . curl_error( $ch );
		else :
			curl_close( $ch );
			return $response;
		endif;
	}

	/**
	 * For getting affiliate information by affiliate code.
	 *
	 * The Refersion affiliate identifier. You would have captured this from the new_affiliate endpoint response.
	 *
	 * @rest_endpoint POST https://www.refersion.com/api/get_affiliate
	 * @return object returns an object of the data from the api request.
	 */
	public function get_affiliate() {
		$ch = curl_init();
		$data = array(
			'refersion_public_key' => $this->refersion_public_key,
			'refersion_secret_key' => $this->refersion_secret_key,
			'affiliate_code'       => $this->affiliate_code,
		);

		$data = json_encode( $data );
		curl_setopt( $ch, CURLOPT_URL, 'https://www.refersion.com/api/get_affiliate' );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: text/html' ) );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
		curl_setopt( $ch, CURLPROTO_HTTPS, true );

		$response = curl_exec( $ch );

		if ( false === $response ) :
			curl_close( $ch );
			return 'cURL Error: ' . curl_error( $ch );
		else :
			curl_close( $ch );
			return $response;
		endif;
	}

	/**
	 * This function is for searching for affiliates by keyword.
	 *
	 * The keyword to search for. Can be the affiliate ID or registered email address. Affiliate ID must be exact and complete, but email can be a partial string.
	 *
	 * @rest_endpoint POST https://www.refersion.com/api/search_affiliates
	 * @return object returns an object of the data from the api request.
	 */
	public function search_affiliates() {
		$ch = curl_init();
		$data = array(
			'refersion_public_key' => $this->refersion_public_key,
			'refersion_secret_key' => $this->refersion_secret_key,
			'keyword'              => $this->keyword,
		);

		$data = json_encode( $data );
		curl_setopt( $ch, CURLOPT_URL, 'https://www.refersion.com/api/search_affiliates' );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: text/html' ) );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
		curl_setopt( $ch, CURLPROTO_HTTPS, true );

		$response = curl_exec( $ch );

		if ( false === $response ) :
			curl_close( $ch );
			return 'cURL Error: ' . curl_error( $ch );
		else :
			curl_close( $ch );
			return $response;
		endif;
	}

	/**
	 * This is for fetching a list of affiliates.
	 *
	 * @rest_endpoint POST https://www.refersion.com/api/list_affiliates
	 * @return object returns an object of the data from the api request.
	 */
	public function list_all_affiliates() {
		$ch = curl_init();
		$data = array(
			'refersion_public_key' => $this->refersion_public_key,
			'refersion_secret_key' => $this->refersion_secret_key,
			'limit'                => $this->limit,
			'page'                 => $this->page,
		);

		$data = json_encode( $data );
		curl_setopt( $ch, CURLOPT_URL, 'https://www.refersion.com/api/list_affiliates' );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: text/html' ) );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
		curl_setopt( $ch, CURLPROTO_HTTPS, true );

		$response = curl_exec( $ch );

		if ( false === $response ) :
			curl_close( $ch );
			return 'cURL Error: ' . curl_error( $ch );
		else :
			curl_close( $ch );
			return $response;
		endif;
	}

	/**
	 * Create Conversion Trigger is to create triggers and can be affiliate specific.
	 *
	 * @rest_endpoint POST https://www.refersion.com/api/new_affiliate_trigger
	 * @return object returns an object of the reponse containing trigger_id and trigger.
	 */
	public function create_conversion_trigger() {
		$ch = curl_init();
		$data = array(
			'refersion_public_key' => $this->refersion_public_key,
			'refersion_secret_key' => $this->refersion_secret_key,
			'affiliate_code'       => $this->affiliate_code,
			'type'                 => $this->type,
			'trigger'              => $this->trigger,
		);

		$data = json_encode( $data );
		curl_setopt( $ch, CURLOPT_URL, 'https://www.refersion.com/api/new_affiliate_trigger' );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: text/html' ) );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
		curl_setopt( $ch, CURLPROTO_HTTPS, true );

		$response = curl_exec( $ch );

		if ( false === $response ) :
			curl_close( $ch );
			return 'cURL Error: ' . curl_error( $ch );
		else :
			curl_close( $ch );
			return $response;
		endif;
	}

	/**
	 * Add SKU specific commission rates to a specific offer. Your plan must support SKU/Product Level Commissions.
	 *
	 * @rest_endpoint POST https://www.refersion.com/api/offer/new_sku_commission
	 * @return [type] [description]
	 */
	public function new_sku_level_commission() {
		$ch = curl_init();
		$data = array(
			'refersion_public_key' => $this->refersion_public_key,
			'refersion_secret_key' => $this->refersion_secret_key,
			'offer_id'             => $this->offer_id,
			'skus'                 => $this->skus,
		);

		$data = json_encode( $data );
		curl_setopt( $ch, CURLOPT_URL, 'https://www.refersion.com/api/offer/new_sku_commission' );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: text/html' ) );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
		curl_setopt( $ch, CURLPROTO_HTTPS, true );

		$response = curl_exec( $ch );

		if ( false === $response ) :
			curl_close( $ch );
			return 'cURL Error: ' . curl_error( $ch );
		else :
			curl_close( $ch );
			return $response;
		endif;
	}

	/**
	 * Report a manual payment for specific conversions in Refersion.
	 *
	 * @rest_endpoint POST https://www.refersion.com/api/process_manual_payment
	 * @return boolean true on success.
	 */
	public function process_manual_payment() {
		$ch = curl_init();
		$data = array(
			'refersion_public_key' => $this->refersion_public_key,
			'refersion_secret_key' => $this->refersion_secret_key,
			'conversion_ids'       => $this->conversion_ids,
			'payment_method'       => $this->payment_method,
		);

		$data = json_encode( $data );
		curl_setopt( $ch, CURLOPT_URL, 'https://www.refersion.com/api/process_manual_payment' );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: text/html' ) );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
		curl_setopt( $ch, CURLPROTO_HTTPS, true );

		$response = curl_exec( $ch );

		if ( false === $response ) :
			curl_close( $ch );
			return 'cURL Error: ' . curl_error( $ch );
		else :
			curl_close( $ch );
			return true;
		endif;
	}

	/**
	 * Get a public download link for a report. Links expire in 2 minutes from the time of request for security purposes.
	 *
	 * @rest_endpoint POST https://www.refersion.com/api/reporting/get_link
	 * @return object returns the generated report download_link and expire_time.
	 */
	public function generate_download_link() {
		$ch = curl_init();
		$data = array(
			'refersion_public_key' => $this->refersion_public_key,
			'refersion_secret_key' => $this->refersion_secret_key,
			'report_id'            => $this->report_id,
		);

		$data = json_encode( $data );
		curl_setopt( $ch, CURLOPT_URL, 'https://www.refersion.com/api/reporting/get_link' );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: text/html' ) );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
		curl_setopt( $ch, CURLPROTO_HTTPS, true );

		$response = curl_exec( $ch );

		if ( false === $response ) :
			curl_close( $ch );
			return 'cURL Error: ' . curl_error( $ch );
		else :
			curl_close( $ch );
			return true;
		endif;
	}
}
