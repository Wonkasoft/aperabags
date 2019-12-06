<?php
/**
 * Ambassador Program
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/ambassador-program.php.
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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$user             = wp_get_current_user();
	$user_id      = $user->ID;
	$company_logo = ( ! empty( get_user_meta( $user_id, 'company_logo', true ) ) ) ? get_user_meta( $user_id, 'company_logo', true ) : null;

	$output = '';
if ( ! empty( $company_logo ) ) {
	$company_logo = json_decode( $company_logo );
}

?>

<section class="ambassador-first">
	<p><strong>Welcome to the Apera Ambassador Program!</strong> Use this dashboard to manage your Ambassador features, upload your gym/club logo and view sales made with your unique Ambassador Code.</p>
</section>

<section class="ambassador-second">
	<div class="ambassador-second-divider"><span>Gym/Club Details</span></div>
</section>

<section class="zip-third">
	<div class="table-responsive">
	<table class="">
		<thead>
			<tr>
				<th class=""><span class="nobr">Date</span></th>
				<th class=""><span class="nobr">Item Qty.</span></th>
				<th class=""><span class="nobr">Cart Total</span></th>
				<th class=""><span class="nobr">Commission</span></th>
			</tr>
		</thead>

		<tbody>

				<tr class="">
						<td class="" data-title="">

						</td>
				</tr>
		</tbody>
	</table>
	</div>
</section>

