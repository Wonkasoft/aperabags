<?php
/**
 * This file contains custom functions that modify the rewardsystem plugin.
 *
 * @author Wonkasoft <support@wonkasoft.com>
 */

defined( 'ABSPATH' ) or exit;

if ( class_exists( 'RSFunctionForReferralSystem' ) ) {

	/**
	 * Display the list of generated link
	 *
	 * @param  [type] $referralperson [description]
	 * @return [type]                 [description]
	 */
	function static_url_table( $referralperson ) {
			wp_enqueue_script( 'fp_referral_frontend', SRP_PLUGIN_DIR_URL . 'includes/frontend/js/modules/fp-referral-frontend.js', array( 'jquery' ), SRP_VERSION );
			$LocalizedScript = array(
				'ajaxurl'        => SRP_ADMIN_AJAX_URL,
				'buttonlanguage' => get_option( 'rs_language_selection_for_button' ),
				'wplanguage'     => get_option( 'WPLANG' ),
				'fbappid'        => get_option( 'rs_facebook_application_id' ),
			);
			wp_localize_script( 'fp_referral_frontend', 'fp_referral_frontend_params', $LocalizedScript );
			$referralperson = ( '' !== $referralperson ) ? $referralperson : wp_get_current_user()->data->ID;
			$query          = ( get_option( 'rs_restrict_referral_points_for_same_ip' ) == 'yes' ) ? array(
				'ref' => $referralperson,
				'ip'  => base64_encode( get_referrer_ip_address() ),
			) : array( 'ref' => $referralperson );
			$refurl         = add_query_arg( $query, get_option( 'rs_static_generate_link' ) );
			?>
			<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
			<h3 class="rs_my_referral_link_title" style="margin: 15px auto;"><?php echo get_option( 'rs_my_referral_link_button_label' ); ?></h3>
			<table class="shop_table my_account_referral_link_static" id="my_account_referral_link_static">
				<thead>
					<tr>                       
						<th class="referral-link_static"><span class="nobr"><?php echo get_option( 'rs_generate_link_referrallink_label' ); ?></span></th>
						<th class="referral-social_static"><span class="nobr"><?php echo get_option( 'rs_generate_link_social_label' ); ?></span></th>
					</tr>
				</thead>
				<tbody>
					<tr class="referrals_static">
						<td class="copy_clip_icon">
							<?php echo $refurl; ?>
							<?php if ( get_option( 'rs_enable_copy_to_clipboard' ) == 'yes' ) { ?>
								<i data-referralurl="<?php echo $refurl; ?>" title="<?php _e( 'Click to copy the link', SRP_LOCALE ); ?>" alt="<?php _e( 'Click to copy the link', SRP_LOCALE ); ?>" id="rs_copy_clipboard_image" class="rs_copy_clipboard_image fa fa-copy float-right"></i>
								<div style="display:none;"class="rs_alert_div_for_copy">
									<div class="rs_alert_div_for_copy_content">
										<p><?php _e( 'Referral Link Copied', SRP_LOCALE ); ?></p>
									</div>
								</div>
							<?php } ?>
						</td>
						<td>
							<div style="display: grid; align-items: center; justify-content: start; grid-auto-flow: column; grid-gap: 8px;">
							<?php if ( get_option( 'rs_account_show_hide_facebook_share_button' ) == '1' ) { ?>
								<div class="share_wrapper_static_url" id="share_wrapper_static_url" href="<?php echo $refurl; ?>" data-image="<?php echo get_option( 'rs_fbshare_image_url_upload' ); ?>" data-title="<?php echo get_option( 'rs_facebook_title' ); ?>" data-description="<?php echo get_option( 'rs_facebook_description' ); ?>" style="display: grid; align-items: center; justify-content: space-evenly; grid-auto-flow: column; grid-gap: 4px; margin: 0; height: 20px; padding: 0 8px;">
									<i class='fa fa-facebook'></i> <span class="label" style="font-weight: normal;"><?php echo get_option( 'rs_fbshare_button_label' ); ?> </span>
								</div>
							<?php } ?>
							<?php if ( get_option( 'rs_account_show_hide_twitter_tweet_button' ) == '1' ) { ?>
								<a href="https://twitter.com/share" class="twitter-share-button" data-count="none" style="display: inline-block;" data-url="<?php echo $refurl; ?>">Tweet</a>
							<?php } ?>
						</div>
						</td>
					</tr>                    
				</tbody>
			</table>
			<?php
	}
	remove_action( 'woocommerce_before_my_account', array( 'RSFunctionForReferralSystem', 'static_referral_link_in_my_account' ) );
	add_action( 'woocommerce_before_my_account', 'static_url_table' );
}

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
