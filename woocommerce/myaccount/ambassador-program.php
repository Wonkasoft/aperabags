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

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

global $wpdb;
$table_name = $wpdb->prefix . 'refersion_affiliates_data';

$user         = wp_get_current_user();
$user_id      = $user->ID;
$company_logo = ( ! empty( get_user_meta( $user_id, 'company_logo', true ) ) ) ? get_user_meta( $user_id, 'company_logo', true ) : null;

$output = '';
if ( ! empty( $company_logo ) ) {
	$company_logo = json_decode( $company_logo );
}

$results = $wpdb->get_results( "SELECT * FROM $table_name" );

?>

<section class="ambassador-first">
	<p><strong>Welcome to the Apera Ambassador Program!</strong> Use this dashboard to manage your Ambassador features, upload your gym/club logo and view sales made with your unique Ambassador Code.</p>
</section>

<section class="myaccount-section-divider">
	<div class="myaccount-divider"><span><?php esc_html_e( 'Ambassador Details', 'apera-bags' ); ?></span></div>
</section>

<section class="ambassador-third">
	<?php if ( ! $refersion_data ) : ?>
		<div class="no-data-to-display"><span><?php esc_html_e( 'No data to display as of right now.', 'apera-bags' ); ?></span></div>
	<?php else : ?>
		<div class="table-responsive">
		<table class="table border-collapse table-striped">
			<thead>
				<tr>
					<th class=""><span class="nobr"><?php esc_html_e( 'Date', 'apera-bags' ); ?></span></th>
					<th class=""><span class="nobr"><?php esc_html_e( 'Item Qty', 'apera-bags' ); ?></span></th>
					<th class=""><span class="nobr"><?php esc_html_e( 'Cart Total', 'apera-bags' ); ?></span></th>
					<th class=""><span class="nobr"><?php esc_html_e( 'Commission', 'apera-bags' ); ?></span></th>
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
	<?php endif; ?>

</section>

