<?php
/**
 * This file contains custom functions that modify the rewardsystem plugin.
 *
 * @author Wonkasoft <support@wonkasoft.com>
 */

defined( 'ABSPATH' ) or exit;

/**
 * This overrides the points in checkout
 */
function wonkasoft_total_points_in_checkout() {
	if ( ! is_user_logged_in() ) {
		return;
	}

	if ( get_option( 'rs_product_purchase_activated' ) != 'yes' && get_option( 'rs_buyingpoints_activated' ) != 'yes' ) {
		return;
	}

	if ( get_option( 'rs_show_hide_total_points_checkout_field' ) == 2 ) {
		return;
	}

	if ( get_option( 'rs_product_purchase_activated' ) == 'yes' ) {
		if ( get_option( 'rs_enable_product_category_level_for_product_purchase' ) == 'no' && get_option( 'rs_award_points_for_cart_or_product_total' ) == '2' ) {
			$Points = get_reward_points_based_on_cart_total( WC()->cart->total );
			$Points = RSMemberFunction::earn_points_percentage( get_current_user_id(), (float) $Points ) + apply_filters( 'srp_buying_points_in_cart', 0 );
		} else {
			$Points = WC()->session->get( 'rewardpoints' ) + apply_filters( 'srp_buying_points_in_cart', 0 );
		}
		if ( get_option( 'rs_enable_first_purchase_reward_points' ) == 'yes' ) {
			$OrderCount          = get_posts(
				array(
					'numberposts' => -1,
					'meta_key'    => '_customer_user',
					'meta_value'  => get_current_user_id(),
					'post_type'   => wc_get_order_types(),
					'post_status' => array( 'wc-processing', 'wc-on-hold', 'wc-completed' ),
				)
			);
			$FirstPurchasePoints = RSMemberFunction::earn_points_percentage( get_current_user_id(), (float) get_option( 'rs_reward_points_for_first_purchase_in_fixed' ) );
			$Points              = ( count( $OrderCount ) == 0 ) ? ( $Points + $FirstPurchasePoints ) : $Points;
		}
	} elseif ( get_option( 'rs_buyingpoints_activated' ) == 'yes' ) {
		$Points = apply_filters( 'srp_buying_points_in_cart', 0 );
	}
	if ( empty( $Points ) ) {
		return;
	}

	$ConvertedValue = redeem_point_conversion( $Points, get_current_user_id(), 'price' );
	$CurrencyValue  = srp_formatted_price( round_off_type_for_currency( $ConvertedValue ) );
	$BoolVal        = empty( WC()->cart->discount_cart ) ? true : ( get_option( 'rs_enable_redeem_for_order' ) == 'no' && get_option( 'rs_disable_point_if_coupon' ) == 'no' );
	if ( ! $BoolVal ) {
		return;
	}
	?>
	<tr class="tax-total">
		<th colspan="2"><?php echo get_option( 'rs_total_earned_point_caption_checkout' ); ?></th>
		<td align="right">
			<?php
			echo wonkasoft_custom_message_in_thankyou_page( $Points, $CurrencyValue, 'rs_show_hide_equivalent_price_for_points', 'rs_show_hide_custom_msg_for_points_checkout', 'rs_custom_message_for_points_checkout', 0 );
			?>
		</td>
	</tr>
	<?php
}

/**
 * This is an override for the perks program custom message in cart, checkout, and thank you page.
 *
 * @param  str $Points            Contains the users points.
 * @param  str $CurrencyValue     Contains the users currency value of points.
 * @param  str $ShowCurrencyValue Contains option of show or hide currency value.
 * @param  str $ShowCustomMsg     Contains option of show or hide custom msg.
 * @param  str $CustomMsg         Contains custom message.
 * @param  str $PaymentPlanPoints Contains the users payment plan points.
 */
function wonkasoft_custom_message_in_thankyou_page( $Points, $CurrencyValue, $ShowCurrencyValue, $ShowCustomMsg, $CustomMsg, $PaymentPlanPoints ) {

	$Msg = '';

	$PointsToDisplay = (float) $Points - (float) $PaymentPlanPoints;
	$PointsToDisplay = round_off_type( $PointsToDisplay );

	if ( get_option( "$ShowCustomMsg" ) == '1' ) {
		$Msg .= ' ' . get_option( "$CustomMsg" );
	}

	if ( get_option( "$ShowCurrencyValue" ) == '1' ) {
		$Msg .= '&nbsp;' . $CurrencyValue;
	}

	// echo $PointsToDisplay . $Msg;
	echo $Msg;
}

if ( get_option( 'rs_select_type_for_checkout', '2' ) == '2' ) {
	remove_action( 'woocommerce_review_order_after_order_total', array( 'RSFrontendAssets', 'total_points_in_checkout' ) );
	add_action( 'woocommerce_review_order_after_order_total', 'wonkasoft_total_points_in_checkout' );
} else {
	remove_action( 'woocommerce_review_order_before_order_total', array( 'RSFrontendAssets', 'total_points_in_checkout' ) );
	add_action( 'woocommerce_review_order_before_order_total', 'wonkasoft_total_points_in_checkout' );
}

function wonkasoft_rewardsystem_coupons_change() {
	$Directory = new RecursiveDirectoryIterator( plugin_dir_path( dirname( dirname( __DIR__ ) ) ) . 'plugins/rewardsystem', RecursiveDirectoryIterator::FOLLOW_SYMLINKS );
	$Iterator  = new RecursiveIteratorIterator( $Directory );
	$files     = array();
	foreach ( $Iterator as $file ) :
		if ( strpos( $file->getPathname(), '.php' ) ) :
			$path_to_file          = $file->getPathname();
			$file_contents         = file_get_contents( $path_to_file );
			$patterns              = "/'sumo_'|'auto_redeem_'|'auto_aperacash_'/";
			$updated_file_contents = preg_replace( $patterns, "'aperacash_'", $file_contents, -1, $count );

			if ( 0 < $count ) :
				file_put_contents( $path_to_file, $updated_file_contents );
			endif;
		endif;
	endforeach;
}
add_action( 'after_setup_theme', 'wonkasoft_rewardsystem_coupons_change' );
