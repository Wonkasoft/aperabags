<?php
/**
 * Earn AperaCash
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/earn-aperacash.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  Wonkasoft
 * @package WooCommerce/Templates
 * @version 1.0.1
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

$customer_id = get_current_user_id();

?>
<section class="earn-aperacash-first">
	<header class="earn-aperacash-header">
		<h6 class="earn-aperacash-title-text">Earn AperaCash</h6>
	</header>
	<p>
		Stack up AperaCash for your next Apera purchase. Explore your earning opportunities below!
	</p>

	<ul>
		<li>
			<div class="legend-color legend-color-green"></div><div class="legend-color-text"><span>Green items are always there to earn with.</span></div>
		</li>
		<li>
			<div class="legend-color legend-color-blue"></div><div class="legend-color-text"><span>Blue items can only be used once.</span></div>
		</li>
		<li>
			<div class="legend-color legend-color-grey"></div><div class="legend-color-text"><span>Grey items are already applied to your account.</span></div>
		</li>
	</ul>
</section>
<section class="earn-aperacash-second">
	<a id="birthday-button" href="#" class="aperacash-boxes-achor" data-toggle="modal" data-target="#earn-aperacash-modal">
	<div class="aperacash-boxes aperacash-boxes-birthday unlimited">
		<i class="arrow-right">
			<svg version="1.1" id="Arrow" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="15px" height="15px" viewBox="0 0 15 15" enable-background="new 0 0 15 15" xml:space="preserve">
				<g>
					<path fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M2.038,14.849l10.03-10.03l0.043,7.63l2.683-2.682L14.74,0.229
						L5.201,0.176L2.52,2.859l7.63,0.042L0.12,12.932L2.038,14.849z"/>
				</g>
			</svg>
		</i>
		<div class="box-content-wrap">
			<div class="box-content-icon">
				<svg version="1.1" id="Icons" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
		 width="75px" height="75px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
				<rect y="-0.29" display="none" fill-rule="evenodd" clip-rule="evenodd" fill="#444444" width="100" height="100"/>
				<g id="Birthday">
					<path display="inline" fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M50.158,99.06
						c-1.843-6.87-3.688-13.739-5.527-20.609c-2.41-9-4.822-18-7.21-27.006c-0.204-0.769-0.38-1.088-1.355-0.962
						c-5.897,0.762-10.698-1.507-14.637-5.731c-3.403-3.651-5.311-8.051-5.856-13.003c-0.737-6.68,0.771-12.703,5.624-17.574
						c3.274-3.287,7.325-4.637,12.097-4.24c-2.691,6.543-2.979,13.153-0.521,19.751c2.494,6.694,6.983,11.464,14.049,13.691
						c-1.928,3.043-4.555,5.105-7.918,6.447c3.642,13.625,7.274,27.218,10.907,40.811c0.047-0.005,0.095-0.009,0.142-0.014
						c0-16.39,0-32.78,0-49.18c-1.065-0.211-2.152-0.312-3.163-0.646c-5.572-1.838-9.207-5.767-11.407-11.047
						c-2.492-5.981-2.624-12.099-0.112-18.089c2.134-5.088,5.622-9.013,11.105-10.632C51.887-0.6,56.825,0.812,61.025,4.566
						c8.884,7.938,9.156,21.523,3.192,29.824c-2.174,3.025-4.946,5.284-8.545,6.396c-0.9,0.278-1.86,0.395-2.802,0.496
						c-0.665,0.071-0.97,0.256-0.969,1.008c0.019,15.947,0.013,31.896,0.014,47.842c0,0.217,0.031,0.433,0.196,0.67
						c3.636-13.6,7.271-27.2,10.946-40.948c-3.232-1.288-5.833-3.391-7.866-6.369c0.733-0.242,1.359-0.417,1.963-0.653
						c6.237-2.447,10.095-7.118,12.17-13.326c2.102-6.284,1.724-12.518-0.799-18.632c-0.075-0.183-0.16-0.361-0.232-0.545
						c-0.022-0.057-0.016-0.125-0.044-0.386c1.275,0,2.549-0.119,3.793,0.02c8.294,0.92,13.599,8.598,14.369,16.18
						c0.595,5.854-0.604,11.262-3.911,16.128c-2.902,4.271-6.788,7.245-11.98,8.139c-1.53,0.263-3.145,0.176-4.706,0.058
						c-0.752-0.058-1.021,0.029-1.217,0.771c-2.886,10.885-5.802,21.762-8.709,32.641c-1.302,4.867-2.602,9.734-3.897,14.604
						c-0.049,0.184-0.037,0.385-0.054,0.577C51.345,99.06,50.751,99.06,50.158,99.06z M43.68,23.358
						c-1.496,1.434-3.221,3.088-5.099,4.889c1.84,1.655,3.619,3.256,5.468,4.919c1.526-1.458,3.252-3.107,5.099-4.873
						C47.303,26.629,45.527,25.025,43.68,23.358z M70.173,34.066c0.934,1.149,1.794,2.208,2.693,3.315
						c1.152-0.942,2.207-1.804,3.316-2.711c-0.935-1.151-1.793-2.209-2.695-3.319C72.339,32.293,71.282,33.158,70.173,34.066z
						 M57.327,10.832c0-1.21,0-2.347,0-3.582c-1.203,0-2.363,0-3.564,0c0,1.207,0,2.367,0,3.582
						C54.958,10.832,56.067,10.832,57.327,10.832z M26.833,34.043c0-1.209,0-2.369,0-3.588c-1.206,0-2.343,0-3.562,0
						c0,1.208,0,2.366,0,3.588C24.457,34.043,25.569,34.043,26.833,34.043z M61.65,25.542c-0.072,0.763-0.136,1.425-0.204,2.143
						c0.759,0.071,1.396,0.132,2.098,0.198c0.078-0.771,0.143-1.406,0.214-2.117C63.018,25.688,62.381,25.62,61.65,25.542z
						 M32.103,41.637c-0.448,0.428-0.816,0.779-1.23,1.174c0.426,0.451,0.775,0.821,1.089,1.154c0.499-0.4,0.897-0.72,1.335-1.071
						C32.859,42.433,32.526,42.082,32.103,41.637z"/>
					<path display="inline" fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M71.686,84.905
						c-0.496-1.856-0.966-3.612-1.46-5.46c1.841-0.494,3.57-0.958,5.433-1.458c0.492,1.824,0.965,3.58,1.469,5.448
						C75.319,83.924,73.59,84.392,71.686,84.905z"/>
					<path display="inline" fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M27.671,70.215c1.486,0,2.824,0,4.232,0
						c0,1.4,0,2.762,0,4.265c-1.266,0-2.535,0.017-3.803-0.024c-0.148-0.004-0.404-0.327-0.41-0.509
						C27.654,72.738,27.671,71.529,27.671,70.215z"/>
					<path display="inline" fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M42.104,88.675
						c-1.104,0.904-2.16,1.768-3.264,2.672c-0.905-1.112-1.75-2.149-2.655-3.264c1.092-0.894,2.127-1.741,3.264-2.671
						C40.326,86.491,41.186,87.547,42.104,88.675z"/>
					<path display="inline" fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M79.115,57.281
						c1.344,0.573,2.574,1.099,3.875,1.653c-0.561,1.318-1.082,2.545-1.646,3.869c-1.322-0.564-2.552-1.089-3.873-1.653
						C78.021,59.857,78.543,58.628,79.115,57.281z"/>
					<path display="inline" fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M44.965,63.568
						c0.152-1.087,0.286-2.049,0.439-3.139c1.054,0.136,2.042,0.262,3.166,0.406c-0.144,1.056-0.279,2.041-0.433,3.167
						C47.101,63.86,46.115,63.726,44.965,63.568z"/>
					<path display="inline" fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M73.159,61.999
						c0.844,0.489,1.577,0.915,2.426,1.406c-0.463,0.806-0.896,1.56-1.387,2.413c-0.809-0.46-1.563-0.889-2.425-1.378
						C72.238,63.622,72.667,62.867,73.159,61.999z"/>
					<path display="inline" fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M15.229,56.207
						c-0.582-0.573-1.14-1.122-1.788-1.761c0.667-0.579,1.297-1.126,1.953-1.696c0.508,0.495,1.109,1.082,1.716,1.674
						C16.467,55.033,15.878,55.592,15.229,56.207z"/>
					<path display="inline" fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M78.99,71.628
						c0.277,0.689,0.506,1.255,0.772,1.914c-0.628,0.265-1.213,0.512-1.898,0.801c-0.272-0.643-0.521-1.227-0.803-1.891
						C77.693,72.183,78.281,71.931,78.99,71.628z"/>
					<path display="inline" fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M29.371,81.862
						c-0.652-0.077-1.251-0.148-1.941-0.231c0.074-0.694,0.137-1.292,0.198-1.871C29.657,79.48,29.923,79.792,29.371,81.862z"/>
					<path display="inline" fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M34.322,72.516
						c0.403,0.531,0.752,0.992,1.172,1.545c-0.496,0.391-0.966,0.761-1.532,1.206c-0.386-0.495-0.74-0.947-1.183-1.516
						C33.283,73.348,33.765,72.961,34.322,72.516z"/>
				</g>
				</svg>
			</div>
			<div class="box-content-title"><span>My Birthday</span></div>
			<div class="box-content-text"><span>$10 AperaCash is automatically added to your balance on your birthday!</span></div>
			<div id="birthday-for-modal">
				<?php gravity_form( 'User Birthday', false, false, false, null, true, 1, true ); ?>
			</div>
		</div>
	</div>
	</a>
	<a id="refer-button" href="#" class="aperacash-boxes-achor" data-toggle="modal" data-target="#earn-aperacash-modal">
	<div class="aperacash-boxes aperacash-boxes-refer-friend unlimited">
		<i class="arrow-right">
			<svg version="1.1" id="Arrow" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="15px" height="15px" viewBox="0 0 15 15" enable-background="new 0 0 15 15" xml:space="preserve">
				<g>
					<path fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M2.038,14.849l10.03-10.03l0.043,7.63l2.683-2.682L14.74,0.229
						L5.201,0.176L2.52,2.859l7.63,0.042L0.12,12.932L2.038,14.849z"/>
				</g>
			</svg>
		</i>
		<div class="box-content-wrap">
			<div class="box-content-icon">
				<svg version="1.1" id="Icons" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
		 width="75px" height="75px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
				<rect y="-0.29" display="none" fill-rule="evenodd" clip-rule="evenodd" fill="#444444" width="100" height="100"/>
				<g id="Share">
					<path display="inline" fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M78.989,12.455
						c0.152,0.048,0.302,0.128,0.456,0.138c5.763,0.373,10.165,2.972,13.091,7.988c1.391,2.386,2.753,4.789,4.158,7.166
						c3.48,5.883,2.465,13.423-1.866,18.256c-1.082,1.208-2.292,2.233-3.69,3.04c-5.728,3.306-11.456,6.608-17.185,9.911
						c-5.892,3.398-13.49,2.431-18.57-2.26c-0.1-0.091-0.181-0.203-0.319-0.361c0.186-0.148,0.344-0.311,0.532-0.419
						c2.153-1.247,4.318-2.474,6.463-3.735c0.458-0.27,0.807-0.258,1.314-0.068c2.317,0.86,4.596,0.772,6.781-0.489
						c5.462-3.154,10.938-6.289,16.394-9.454c3.842-2.229,5.047-6.643,2.87-10.503c-1.306-2.315-2.663-4.602-4.001-6.899
						c-2.172-3.729-6.573-5.05-10.336-2.941c-5.62,3.15-11.184,6.402-16.75,9.648c-1.884,1.1-3.102,2.765-3.531,4.918
						c-0.156,0.783-0.541,1.229-1.213,1.602c-2.028,1.122-4.026,2.301-6.038,3.454c-0.231,0.133-0.477,0.24-0.788,0.396
						c-0.652-2.547-0.673-5.03-0.057-7.505c1.113-4.462,3.703-7.856,7.65-10.17c5.469-3.206,10.973-6.351,16.476-9.497
						c2.035-1.164,4.236-1.841,6.581-2.03c0.188-0.015,0.37-0.121,0.554-0.185C78.308,12.455,78.648,12.455,78.989,12.455z"/>
					<path display="inline" fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M53.125,57.344
						c0.493,1.555,0.668,3.071,0.6,4.589c-0.177,3.985-1.522,7.534-4.336,10.41c-0.989,1.011-2.125,1.941-3.342,2.658
						c-5.726,3.373-11.506,6.653-17.261,9.977c-5.947,3.434-13.785,2.284-18.5-2.417c-1.215-1.212-2.247-2.644-3.182-4.092
						c-1.275-1.974-2.373-4.061-3.553-6.096c-1.553-2.681-2.418-5.548-2.334-8.664c0.104-3.854,1.391-7.257,3.934-10.171
						c1.291-1.479,2.82-2.657,4.52-3.634c5.262-3.021,10.517-6.054,15.771-9.089c6.102-3.524,13.234-2.927,18.68,1.575
						c0.71,0.587,0.712,0.627-0.093,1.094c-2.154,1.246-4.315,2.48-6.467,3.73c-0.373,0.217-0.678,0.271-1.132,0.111
						c-2.425-0.854-4.738-0.539-6.96,0.752c-5.307,3.081-10.639,6.119-15.944,9.204c-2.623,1.525-4.021,3.814-4.006,6.885
						c0.007,1.281,0.343,2.49,0.995,3.607c1.375,2.355,2.709,4.735,4.115,7.073c2.281,3.793,6.691,4.911,10.542,2.699
						c5.321-3.058,10.622-6.151,15.958-9.182c2.351-1.336,3.811-3.229,4.233-5.921c0.051-0.324,0.265-0.738,0.53-0.896
						C48.258,60.135,50.654,58.771,53.125,57.344z"/>
					<path display="inline" fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M68.91,41.577
						c-0.036,1.989-0.802,3.122-2.194,3.921c-6.74,3.867-13.468,7.755-20.201,11.636c-2.599,1.497-5.235,2.935-7.786,4.511
						c-2.023,1.25-4.763,0.559-5.861-1.601c-0.292-0.576-0.699-1.108-0.903-1.712c-0.676-1.998,0.012-3.803,1.87-4.892
						c3.116-1.824,6.257-3.607,9.386-5.411c6.167-3.555,12.34-7.104,18.498-10.676c1.502-0.87,2.984-1.078,4.528-0.157
						c0.059,0.035,0.135,0.048,0.182,0.093C67.77,38.567,68.683,40.072,68.91,41.577z"/>
				</g>
				</svg>
			</div>
			<div class="box-content-title"><span>Refer Friends</span></div>
			<div class="box-content-text"><span>Earn $5 AperaCash per friend who signs up with the Apera Perks Program!</span></div>
			<div id="refer-for-modal">
				<?php
				/**
				 * Deprecated woocommerce_before_my_account action.
				 *
				 * @deprecated 2.6.0
				 */
					do_action( 'woocommerce_before_my_account' );
				?>
			</div>
		</div>
	</div>
	</a>
	<a id="shop-button" href="<?php echo esc_url( get_site_url() . '/shop/' ); ?>" class="aperacash-boxes-achor">
	<div class="aperacash-boxes aperacash-boxes-shop unlimited">
		<i class="arrow-right">
			<svg version="1.1" id="Arrow" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="15px" height="15px" viewBox="0 0 15 15" enable-background="new 0 0 15 15" xml:space="preserve">
				<g>
					<path fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M2.038,14.849l10.03-10.03l0.043,7.63l2.683-2.682L14.74,0.229
						L5.201,0.176L2.52,2.859l7.63,0.042L0.12,12.932L2.038,14.849z"/>
				</g>
			</svg>
		</i>
		<div class="box-content-wrap">
			<div class="box-content-icon">
				<svg version="1.1" id="Icons" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
		 width="75px" height="75px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
				<rect y="-0.29" display="none" fill-rule="evenodd" clip-rule="evenodd" fill="#444444" width="100" height="100"/>
				<g id="shop">
					<path display="inline" fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M55.082,38.66c0,4.575,0,9.151,0,13.856
						c-3.786-0.827-7.157-2.367-10.352-4.55c-1.646,2.908-3.251,5.743-4.89,8.639c4.562,3.361,9.652,5.154,15.254,5.858
						c0,1.599,0,3.141,0,4.746c2.183,0,4.261,0,6.438,0c0-1.522,0-3.004,0-4.576c5.916-0.622,11.056-2.682,14.379-7.793
						c3.33-5.12,2.994-10.59,0.965-16.164c6.352,0,12.665,0,19.129,0c-0.17,0.326-0.296,0.597-0.446,0.853
						C88.936,50.757,82.307,61.98,75.697,73.217c-0.332,0.564-0.693,0.774-1.353,0.773c-12.278-0.02-24.558-0.021-36.836,0.002
						c-0.726,0.001-1.043-0.197-1.25-0.92c-3.185-11.146-6.401-22.284-9.608-33.425c-0.085-0.298-0.152-0.601-0.245-0.978
						c0.378-0.021,0.658-0.053,0.938-0.053c9.002-0.002,18.005-0.002,27.007,0.002c0.251,0,0.503,0.045,0.754,0.068L55.082,38.66z"/>
					<path display="inline" fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M55.105,38.688
						c0.178-0.885-0.217-1.294-1.022-1.712c-1.94-1.008-3.863-2.086-5.654-3.335c-4.205-2.933-5.771-7.145-5.665-12.149
						c0.185-8.729,6.168-14.313,14.27-15.699c0.343-0.06,0.685-0.121,1.121-0.199c0-1.636,0-3.246,0-4.938c2.174,0,4.246,0,6.439,0
						c0,1.397,0.037,2.758-0.014,4.115c-0.028,0.731,0.203,0.971,0.947,1.035c4.679,0.404,8.851,2.224,12.753,4.732
						c0.206,0.133,0.423,0.604,0.34,0.776c-1.273,2.666-2.596,5.307-3.944,8.03c-3.224-1.633-6.416-3.164-10.007-3.759
						c-0.03,0.295-0.071,0.512-0.071,0.729c-0.004,4.168,0.008,8.336-0.016,12.503c-0.003,0.58,0.232,0.807,0.728,1.039
						c2.097,0.981,4.224,1.92,6.229,3.066c2.223,1.271,3.806,3.215,5.113,5.659c-0.494,0-0.825,0-1.157,0
						c-6.427,0-12.854-0.002-19.28,0.003c-0.378,0-0.756,0.049-1.134,0.075C55.082,38.66,55.105,38.688,55.105,38.688z M58.116,26.379
						c0-3.514,0-6.954,0-10.405c-2.262,0.485-3.631,2.124-3.891,4.595C53.99,22.815,55.644,25.317,58.116,26.379z"/>
					<path display="inline" fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M93.032,79.562c0,1.377,0,2.61,0,3.986
						c-21.133,0-42.232,0-63.485,0c-0.227-0.771-0.507-1.701-0.772-2.636c-4.008-14.122-8.022-28.241-12-42.372
						c-0.226-0.803-0.569-1.018-1.363-1.008c-3.403,0.043-6.808,0.019-10.211,0.019c-0.38,0-0.759,0-1.206,0c0-1.503,0-2.944,0-4.431
						c5.233,0,10.431,0,15.456,0c1.154,4.093,2.275,8.091,3.409,12.085c3.149,11.094,6.317,22.183,9.428,33.287
						c0.252,0.901,0.632,1.088,1.49,1.087c19.309-0.023,38.617-0.018,57.926-0.018C92.111,79.562,92.521,79.562,93.032,79.562z"/>
					<path display="inline" fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M38.518,92.205
						c-0.011,3.669-2.957,6.582-6.633,6.561c-3.656-0.022-6.576-2.989-6.55-6.656c0.026-3.572,3.041-6.509,6.646-6.474
						C35.622,85.672,38.528,88.592,38.518,92.205z"/>
					<path display="inline" fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M86.417,92.131
						c0.021,3.67-2.89,6.611-6.564,6.634c-3.614,0.023-6.594-2.89-6.635-6.486c-0.041-3.623,2.956-6.649,6.583-6.646
						C83.433,85.635,86.396,88.546,86.417,92.131z"/>
					<path display="inline" fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M61.893,40.246
						c1.205,1.002,2.521,1.899,3.59,3.03c1.521,1.61,1.656,3.604,0.851,5.603c-0.832,2.068-2.595,2.997-4.716,3.565
						c0-4.058,0-8.008,0-11.959C61.709,40.406,61.801,40.326,61.893,40.246z"/>
				</g>
				</svg>
			</div>
			<div class="box-content-title"><span>Shop</span></div>
			<div class="box-content-text"><span>Earn $1 of AperaCash for every $10 spent Apply it to future purchases for a deal!</span></div>
		</div>
	</div>
	</a>
	<a id="follow-button" href="#" class="aperacash-boxes-achor" data-toggle="modal" data-target="#earn-aperacash-modal">
	<div class="aperacash-boxes aperacash-boxes-follow-like one-time">
		<i class="arrow-right">
			<svg version="1.1" id="Arrow" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="15px" height="15px" viewBox="0 0 15 15" enable-background="new 0 0 15 15" xml:space="preserve">
				<g>
					<path fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M2.038,14.849l10.03-10.03l0.043,7.63l2.683-2.682L14.74,0.229
						L5.201,0.176L2.52,2.859l7.63,0.042L0.12,12.932L2.038,14.849z"/>
				</g>
			</svg>
		</i>
		<div class="box-content-wrap">
			<div class="box-content-icon">
				<svg version="1.1" id="Icons" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
		 width="75px" height="75px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
				<rect y="-0.29" display="none" fill-rule="evenodd" clip-rule="evenodd" fill="#444444" width="100" height="100"/>
				<g id="Like__x26__Follow">
					<path display="inline" fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M1.077,31.493
						c0.114-7.374,2.088-14.087,6.888-19.788c4.4-5.228,9.98-8.451,16.832-9.099c7.521-0.71,13.842,1.93,19.02,7.377
						c2.408,2.533,4.231,5.461,5.713,8.612c0.072,0.153,0.119,0.322,0.212,0.461c0.083,0.124,0.212,0.216,0.321,0.322
						c0.078-0.104,0.174-0.198,0.231-0.312c0.396-0.788,0.758-1.594,1.178-2.368c2.444-4.503,5.654-8.339,10.217-10.78
						c8.76-4.688,17.346-3.97,25.478,1.492c6.521,4.38,10.138,10.749,11.318,18.446c1.671,10.898-1.487,20.437-8.459,28.834
						c-3.629,4.372-7.829,8.18-11.882,12.137c-7.548,7.37-15.154,14.688-22.22,22.53c-1.854,2.06-3.459,4.345-5.169,6.533
						c-0.255,0.326-0.462,0.689-0.691,1.036c-0.212-0.342-0.388-0.714-0.644-1.02c-1.413-1.688-2.725-3.483-4.295-5.014
						c-4.056-3.953-8.228-7.786-12.354-11.667c-0.099-0.093-0.209-0.175-0.3-0.274c-0.153-0.169-0.293-0.349-0.439-0.523
						c0.246-0.047,0.49-0.115,0.739-0.137c3.003-0.255,6.022-0.391,9.008-0.786c2.578-0.341,4.168-2.153,5.25-4.367
						c0.389-0.796,0.525-1.749,0.612-2.646c0.081-0.836,0.256-1.564,0.758-2.263c1.232-1.711,1.86-3.611,1.493-5.748
						c-0.068-0.396-0.137-0.823-0.336-1.157c-0.422-0.708-0.343-1.353,0.061-2.009c0.231-0.375,0.468-0.747,0.709-1.116
						c0.796-1.222,0.832-2.485,0.175-3.765c-0.294-0.571-0.624-1.131-0.988-1.659c-0.644-0.934-0.821-1.896-0.425-2.984
						c0.171-0.47,0.263-0.988,0.287-1.489c0.126-2.683-0.997-4.595-3.47-5.661c-2.438-1.05-5.011-1.379-7.654-1.044
						c-1.177,0.149-2.349,0.342-3.526,0.481c-0.286,0.034-0.587-0.067-0.882-0.105c0.08-0.312,0.093-0.666,0.255-0.927
						c0.302-0.486,0.669-0.938,1.048-1.37c2.007-2.281,3.407-4.89,4.207-7.813c0.818-2.989,0.092-5.786-1.233-8.454
						c-0.617-1.242-1.838-1.739-3.156-1.679c-1.214,0.057-2.184,0.695-2.662,1.892c-0.352,0.881-0.656,1.781-1.02,2.656
						c-0.584,1.405-1.139,2.828-1.818,4.188c-0.95,1.905-2.223,3.539-4.095,4.683c-1.036,0.633-1.92,1.509-2.923,2.203
						c-2.351,1.629-4.073,3.868-5.879,6.017c-1.286,1.53-2.436,3.175-3.658,4.76c-0.989,1.284-2.174,2.303-3.713,2.915
						c-0.536,0.214-1.062,0.626-1.414,1.085c-0.399,0.521-0.505,0.318-0.74-0.072c-2.793-4.646-4.728-9.607-5.453-14.997
						C1.339,35.214,1.243,33.35,1.077,31.493z"/>
				</g>
				</svg>
			</div>
			<div class="box-content-title"><span>Follow & Like Us</span></div>
			<div class="box-content-text"><span>Earn $5 AperaCash just for following Apera Bags on Social Media!</span></div>
			<div id="follow-for-modal">
				<div id="fb-root"></div>
				<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v5.0&appId=487253148485930&autoLogAppEvents=1"></script>
				<div class="fb-like" data-href="https://www.facebook.com/aperabags/" data-width="" data-layout="button_count" data-action="like" data-size="large" data-share="true"></div>
			</div>
		</div>
	</div>
	</a>
	<a id="review-button" href="#" class="aperacash-boxes-achor" data-toggle="modal" data-target="#earn-aperacash-modal">
	<div class="aperacash-boxes aperacash-boxes-review one-time">
		<div class="box-content-wrap">
			<div class="box-content-icon">
				<svg version="1.1" id="Icons" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
		 width="75px" height="75px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
				<rect y="-0.29" display="none" fill-rule="evenodd" clip-rule="evenodd" fill="#444444" width="100" height="100"/>
				<g id="review">
					<path display="inline" fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M94.283,69.582c0,2.071,0,4.054,0,6.143
						c-29.535,0-59.04,0-88.633,0c0-2.013,0-4.023,0-6.143C35.137,69.582,64.643,69.582,94.283,69.582z"/>
					<path display="inline" fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M5.629,87.277c0-2.042,0-4.014,0-6.089
						c29.517,0,59.021,0,88.611,0c0,1.999,0,4.002,0,6.089C64.706,87.277,35.202,87.277,5.629,87.277z"/>
					<path display="inline" fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M5.628,98.771c0-2.061,0-4.035,0-6.114
						c29.511,0,59.024,0,88.617,0c0,2.002,0,4.008,0,6.114C64.739,98.771,35.262,98.771,5.628,98.771z"/>
					<path display="inline" fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M25.311,27.286
						c1.049-3.541,1.997-6.74,2.985-10.074c-2.686-2.056-5.363-4.105-8.47-6.484c3.819,0,7.168,0,10.571,0
						c1.223-3.419,2.369-6.623,3.605-10.079c1.228,3.44,2.363,6.621,3.576,10.02c3.377,0,6.745,0,10.676,0
						c-3.151,2.411-5.823,4.455-8.546,6.54c0.977,3.304,1.932,6.538,2.977,10.073c-3.047-2.085-5.834-3.992-8.684-5.941
						C31.189,23.264,28.397,25.174,25.311,27.286z"/>
					<path display="inline" fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M57.246,27.279
						c1.042-3.528,1.996-6.757,2.975-10.068c-2.692-2.062-5.366-4.11-8.507-6.515c3.891,0,7.223,0,10.622,0
						c1.199-3.355,2.332-6.525,3.59-10.045c1.245,3.484,2.376,6.651,3.571,9.995c3.365,0,6.709,0,10.71,0
						c-3.172,2.428-5.831,4.463-8.573,6.562c0.958,3.243,1.914,6.478,2.975,10.069c-3.072-2.101-5.848-3.998-8.683-5.937
						C63.103,23.272,60.312,25.182,57.246,27.279z"/>
					<path display="inline" fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M82.44,44.087
						c-2.792,1.91-5.55,3.798-8.679,5.939c1.056-3.578,2-6.778,2.973-10.071c-2.673-2.045-5.326-4.076-8.444-6.462
						c3.849,0,7.197,0,10.546,0c1.228-3.442,2.362-6.622,3.603-10.099c1.241,3.471,2.381,6.658,3.593,10.049c3.357,0,6.69,0,10.622,0
						c-3.128,2.395-5.763,4.411-8.502,6.509c0.962,3.264,1.924,6.527,2.97,10.075C88.078,47.945,85.286,46.035,82.44,44.087z"/>
					<path display="inline" fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M41.823,50.036
						c1.065-3.595,2.015-6.798,2.987-10.078c-2.676-2.049-5.333-4.082-8.424-6.448c3.814,0,7.166,0,10.515,0
						c1.221-3.417,2.353-6.583,3.613-10.11c1.262,3.531,2.396,6.703,3.597,10.062c3.36,0,6.696,0,10.596,0
						c-3.103,2.373-5.743,4.394-8.484,6.49c0.948,3.215,1.901,6.442,2.972,10.073c-3.097-2.118-5.846-4-8.681-5.938
						C47.701,46.012,44.915,47.92,41.823,50.036z"/>
					<path display="inline" fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M21.084,33.458c3.361,0,6.694,0,10.598,0
						c-3.111,2.381-5.749,4.4-8.488,6.496c0.954,3.227,1.909,6.46,2.979,10.077c-3.038-2.079-5.799-3.97-8.683-5.943
						c-2.767,1.893-5.549,3.795-8.68,5.935c1.054-3.571,1.994-6.758,2.971-10.065c-2.664-2.039-5.337-4.086-8.434-6.457
						c3.807,0,7.13,0,10.528,0c1.2-3.359,2.335-6.533,3.609-10.1C18.742,26.915,19.878,30.09,21.084,33.458z"/>
					<path display="inline" fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M18.744,63.046c0-1.148,0-2.212,0-3.36
						c20.838,0,41.612,0,62.462,0c0,1.14,0,2.198,0,3.36C60.402,63.046,39.632,63.046,18.744,63.046z"/>
				</g>
				</svg>
			</div>
			<div class="box-content-title"><span>Leave a Review</span></div>
			<div class="box-content-text"><span>Earn $5 AperaCash when you leave a review for AperaBags.com!</span></div>
			<div id="review-for-modal">
				<span><?php esc_html_e( 'This award option will be available soon.', 'apera-bags' ); ?></span>
			</div>
		</div>
	</div>
	</a>
	<a id="signup-button" href="#" class="aperacash-boxes-achor" data-toggle="modal" data-target="#earn-aperacash-modal">
	<div class="aperacash-boxes aperacash-boxes-signup already-done">
		<div class="box-content-wrap">
			<div class="box-content-icon">
					<svg version="1.1" id="Icons" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
		 width="75px" height="75px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
					<rect y="-0.29" display="none" fill-rule="evenodd" clip-rule="evenodd" fill="#444444" width="100" height="100"/>
					<g id="Signup">
						<path fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M28.474,98.941c0.004-0.769,0.012-1.537,0.012-2.305
							c0-12.01,0-24.019,0-36.028c0-0.318,0-0.637,0-0.923c-0.051-0.057-0.07-0.083-0.094-0.104c-0.022-0.02-0.049-0.044-0.076-0.048
							c-0.095-0.012-0.191-0.023-0.286-0.023c-7.398-0.003-14.795-0.005-22.193-0.007c-0.031,0-0.064-0.003-0.093-0.013
							c-0.029-0.011-0.055-0.032-0.128-0.077c0.121-0.607,0.613-1.002,0.957-1.466c1.725-2.332,3.483-4.638,5.232-6.951
							c2.058-2.721,4.12-5.438,6.177-8.16c2.401-3.18,4.798-6.362,7.197-9.543c2.111-2.801,4.224-5.599,6.332-8.4
							c2.856-3.795,5.704-7.595,8.563-11.387c2.841-3.768,5.69-7.528,8.537-11.291c0.436-0.576,0.875-1.149,1.323-1.737
							c0.151,0.106,0.245,0.144,0.297,0.213c14.65,19.414,29.299,38.83,43.944,58.248c0.092,0.121,0.149,0.269,0.209,0.379
							c-0.028,0.068-0.033,0.102-0.052,0.122c-0.021,0.023-0.052,0.047-0.08,0.05c-0.096,0.012-0.191,0.019-0.286,0.019
							c-7.397,0.004-14.795,0.007-22.192,0.01c-0.031,0-0.065,0.005-0.095,0.016c-0.027,0.01-0.052,0.03-0.17,0.105
							c0,0.155,0,0.37,0,0.585c0,12.777,0,25.556,0,38.333c0,0.128,0.009,0.256,0.013,0.384C57.172,98.941,42.823,98.941,28.474,98.941z
							 M60.057,38.839c0.785-1.575,1.521-3.055,2.267-4.552c-0.612-0.642-1.412-0.912-2.148-1.267c-0.771-0.371-1.569-0.698-2.38-0.975
							c-0.777-0.264-1.579-0.462-2.382-0.643c-0.819-0.184-1.653-0.311-2.514-0.469c0-0.622,0.018-1.164-0.005-1.705
							c-0.022-0.528,0.102-1.072-0.1-1.61c-0.612,0-1.189-0.018-1.764,0.005c-0.592,0.024-1.198-0.108-1.814,0.113
							c0,1.055,0,2.073,0,3.119c-0.239,0.079-0.443,0.188-0.655,0.209c-1.741,0.168-3.349,0.747-4.837,1.633
							c-2.098,1.248-3.656,2.98-4.394,5.345c-0.558,1.787-0.639,3.61-0.314,5.469c0.376,2.155,1.453,3.825,3.186,5.137
							c1.482,1.122,3.053,2.073,4.772,2.78c0.289,0.118,0.562,0.273,0.777,0.38c0.051,0.116,0.076,0.146,0.076,0.175
							c0.007,3.841,0.015,7.682,0.012,11.522c0,0.141-0.1,0.28-0.171,0.469c-2.976-0.361-5.56-1.574-8.01-3.259
							c-0.912,1.593-1.806,3.155-2.729,4.767c1.641,1.174,3.393,2.001,5.21,2.688c1.809,0.685,3.71,1.013,5.7,1.261
							c0,1.084,0,2.095,0,3.146c1.229,0,2.367,0,3.582,0c0.205-1.053-0.01-2.109,0.135-3.123c0.578-0.099,1.106-0.187,1.635-0.277
							c2.88-0.496,5.259-1.879,7.125-4.114c0.608-0.729,1.086-1.553,1.441-2.458c0.805-2.049,0.896-4.132,0.564-6.283
							c-0.317-2.066-1.271-3.789-2.688-5.27c-1.375-1.436-3.152-2.245-4.928-3.051c-0.597-0.27-1.281-0.361-1.759-0.783
							c0-3.607,0-7.149,0-10.739c0.331,0.015,0.621-0.012,0.894,0.047C55.993,36.988,58.019,37.808,60.057,38.839z"/>
						<path fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M51.615,53.338c0.383,0.195,0.747,0.361,1.092,0.562
							c0.885,0.515,1.743,1.074,2.394,1.879c1.852,2.288,1.104,5.713-1.122,7.018c-0.741,0.435-1.481,0.834-2.341,0.97
							C51.475,63.034,51.45,54.429,51.615,53.338z"/>
						<path fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M49.21,36.459c0,3.138,0,6.13,0,9.219
							c-1.492-0.724-2.811-1.571-3.601-3.009c-0.905-1.646-0.49-3.887,1.248-5.187c0.253-0.189,0.529-0.361,0.819-0.482
							C48.141,36.807,48.625,36.662,49.21,36.459z"/>
					</g>
					</svg>
			</div>
			<div class="box-content-title"><span>Sign Up</span></div>
			<div class="box-content-text"><span>You earned $10 AperaCash just for signing up with the Apera Perks Program!</span></div>
			<div id="signup-for-modal"><?php esc_html_e( 'You have already received your reward', 'apera-bags' ); ?></div>
		</div>
	</div>
	</a>
</section>
<section class="earn-aperacash-third">
	<?php

		/**
		 * Deprecated woocommerce_after_my_account action.
		 *
		 * @deprecated 2.6.0
		 */
		do_action( 'woocommerce_after_my_account' );

	/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
	?>
</section>

<!-- The Modal -->
<div class="modal fade" id="earn-aperacash-modal">
  <div class="modal-dialog modal-dialog-centered">
	<div class="modal-content">

	  <!-- Modal Header -->
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
	  </div>

	  <!-- Modal body -->
	  <div class="modal-body">

	  </div>

	  <!-- Modal footer -->
	  <div class="modal-footer">
	  </div>

	</div>
  </div>
</div>
