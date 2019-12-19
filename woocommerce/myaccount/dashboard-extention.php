<?php
/**
 * This is the markup for the extention of the my account dashboard end point.
 *
 * @package aperabags
 * @author Wonkasoft, LLC <support@wonkasoft.com>
 */

defined( 'ABSPATH' ) || exit;

$PointsData          = new RS_Points_Data( get_current_user_id() );
$Points              = $PointsData->total_available_points();
$TotalRedeemedPoints = round_off_type( $PointsData->total_redeemed_points() );
$TotalPendingPoints  = 0;
$args                = array(
	'post_type'     => 'shop_order',
	'numberposts'   => '-1',
	'meta_query'    => array(
		array(
			'key'     => 'reward_points_awarded',
			'compare' => 'NOT EXISTS',
		),
		array(
			'key'     => 'rs_points_for_current_order_as_value',
			'value'   => 0,
			'compare' => '>',
		),
		array(
			'key'     => '_customer_user',
			'value'   => get_current_user_id(),
			'compare' => '=',
		),
	),
	'post_status'   => $Status,
	'fields'        => 'ids',
	'cache_results' => false,
);
$OrderList           = get_posts( $args );
foreach ( $OrderList as $OrderId ) {
	$TotalPendingPoints += (float) get_post_meta( $OrderId, 'rs_points_for_current_order_as_value', true );
}
?>

<section class="myaccount-section-divider">
	<div class="myaccount-divider"><span><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="25px" height="18px" viewBox="0 0 25 18" enable-background="new 0 0 25 18" xml:space="preserve">
<polygon fill="#ffffff" points="25,5 12,5 12,0 -0.075,9.001 12,18 12,13 25,13 "/>
</svg> Use this menu to navigate through your account.</span></div>
</section>

<section class="dashboard-third">
	<div class="dashboard-third-col dashboard-third-top">
		<div class="aperacash-overview-text"><span>At A Glance <i class="circle fas fa-circle"></i> AperaCash Overview</span></div>
		<div class="earn-aperacash-link"><span><a href="" class="">Earn more AperaCash >></a></span></div>
	</div>
	<div class="dashboard-third-col dashboard-third-left">
		<div class="dashboard-third-boxes main-box-left">
			<div class="aperacash-box-title"><span>My AperaCash Balance</span></div>
			<div class="box-content box-content-main"><span><?php echo sprintf( __( '$%s', 'aperabags' ), esc_html( $Points ) ); ?></span></div>
		</div>
		<span class="d-none-md"><i class="circle fas fa-circle"></i> <strong>My AperaCash Balance:</strong> Your current total spendable AperaCash Balance.</span>
		<div class="dashboard-third-boxes sidebox-top">
			<div class="aperacash-box-title"><span>Spent</span></div>
			<div class="box-content box-content-right"><span><?php echo sprintf( __( '$%s', 'aperabags' ), esc_html( $TotalRedeemedPoints ) ); ?></span></div>
		</div>
		<div class="dashboard-third-boxes sidebox-bottom">
			<div class="aperacash-box-title"><span>Pending</span></div>
			<div class="box-content box-content-right"><span><?php echo sprintf( __( '$%s', 'aperabags' ), esc_html( $TotalPendingPoints ) ); ?></span></div>
		</div>
	</div>
	<div class="dashboard-third-col dashboard-third-right">
		<div class="apera-points">
			<ul class="list-of-points">
				<li>
					<span><i class="circle fas fa-circle"></i> <strong>My AperaCash Balance:</strong> Your current total spendable AperaCash Balance.</span>
				</li>
				<li>
					<span><i class="circle fas fa-circle"></i> <strong>Spent:</strong> The total AperaCash you’ve spent towards purchases as an Apera Perks Member.</span>
				</li>
				<li>
					<span><i class="circle fas fa-circle"></i> <strong>Pending:</strong> Total AperaCash balance pending from purchases made within the last 30 days.</span>
				</li>
			</ul>
		</div>
	</div>
</section>

<section class="dashboard-fourth">
	<header class="history-title">
		<h3 class="history-title-text">My AperaCash History</h3>
	</header>
	<div class="aperacash-history-wrap">
				<label><?php esc_html_e( 'Page Size:', SRP_LOCALE ); ?></label>
				<select id="change-page-sizesss">
					<option value="5">5</option>
					<option value="10">10</option>
					<option value="50">50</option>
					<option value="100">100</option>
				</select>
			<table class = "list_of_orders demo shop_table my_account_orders table-striped" data-page-size="5" data-page-previous-text = "prev" data-filter-text-only = "true" data-page-next-text = "next">
				<thead>
					<tr>
						<th data-type="Numeric"><?php esc_html_e( 'Date', 'aperabags' ); ?></th> 
						<th data-type="Numeric"><?php esc_html_e( 'Action', 'aperabags' ); ?></th>
						<th data-type="Numeric"><?php esc_html_e( 'Purchases', 'aperabags' ); ?></th>
						<th data-type="Numeric"><?php esc_html_e( 'Earned', 'aperabags' ); ?></th>
						<th data-type="Numeric"><?php esc_html_e( 'Spent', 'aperabags' ); ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr class="dark-headers">
						<th class="second-header-totals"><?php esc_html_e( 'Totals', 'aperabags' ); ?></th> 
						<th class="second-header-blank"></th>
						<th class="second-header-purchases"></th>
						<th class="second-header-earned"></th>
						<th class="second-header-spent"></th>
						<th class="second-header-blank"></th>
					</tr>
				</tbody>
				<tbody>
					<?php
					$WCOrderStatus   = array_keys( wc_get_order_statuses() );
					$i               = 1;
					$SUMOOrderStatus = get_option( 'rs_order_status_control' );
					$SUMOOrderStatus = ( srp_check_is_array( $SUMOOrderStatus ) ) ? $SUMOOrderStatus : array();
					$Status          = array();
					foreach ( $WCOrderStatus as $WCStatus ) {

						$WCStatus = str_replace( 'wc-', '', $WCStatus );

						if ( ! in_array( $WCStatus, $SUMOOrderStatus ) ) {
							$Status[] = 'wc-' . $WCStatus;
						}
					}

					$args      = array(
						'post_type'     => 'shop_order',
						'numberposts'   => '-1',
						'meta_query'    => array(
							array(
								'key'     => 'reward_points_awarded',
								'compare' => 'NOT EXISTS',
							),
							array(
								'key'     => 'rs_points_for_current_order_as_value',
								'value'   => 0,
								'compare' => '>',
							),
							array(
								'key'     => '_customer_user',
								'value'   => get_current_user_id(),
								'compare' => '=',
							),
						),
						'post_status'   => $Status,
						'fields'        => 'ids',
						'cache_results' => false,
					);
					$OrderList = get_posts( $args );
					foreach ( $OrderList as $order_id ) {
						$OrderObj    = new WC_Order( $order_id );
						$OrderObj    = srp_order_obj( $OrderObj );
						$OrderStatus = $OrderObj['order_status'];
						$Firstname   = $OrderObj['first_name'];
						$Points      = (float) get_post_meta( $order_id, 'rs_points_for_current_order_as_value', true );
						if ( $Points > 0 ) {
							echo wonkasoft_order_status_settings( $order_id, $OrderObj, $OrderStatus, $Firstname, $i, $Points, $SUMOOrderStatus );
							$i ++;
						}
					}
					?>
				</tbody>
				<tfoot>
					<tr style = "clear:both;">
						<td colspan = "4">
							<div class = "pagination pagination-centered"></div>
						</td>
					</tr>
				</tfoot>
			</table>
			<script type="text/javascript">
				jQuery( document ).ready( function () {
					jQuery( '.list_of_orders' ).footable() ;
					jQuery( '#change-page-sizesss' ).change( function ( e ) {
						e.preventDefault() ;
						var pageSize = jQuery( this ).val() ;
						jQuery( '.footable' ).data( 'page-size' , pageSize ) ;
						jQuery( '.footable' ).trigger( 'footable_initialized' ) ;
					} ) ;

				} ) ;
			</script>
		</div>

</section>

<?php
