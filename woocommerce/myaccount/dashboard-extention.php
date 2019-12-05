<?php
/**
 * This is the markup for the extention of the my account dashboard end point.
 *
 * @package aperabags
 * @author Wonkasoft, LLC <support@wonkasoft.com>
 */

defined( 'ABSPATH' ) || exit;

?>

<section class="dashboard-second">
	<div class="dashboard-second-divider"><span><i class="fa fa-arrow-left"></i> Use this menu to navigate through your account.</span></div>
</section>

<section class="dashboard-third">
	<div class="dashboard-third-col dashboard-third-top">
		<div class="aperacash-overview-text"><span>At A Glance <i class="circle fas fa-circle"></i> AperaCash Overview</span></div>
		<div class="earn-aperacash-link"><span><a href="" class="">Earn more AperaCash >></a></span></div>
	</div>
	<div class="dashboard-third-col dashboard-third-left">
		<div class="dashboard-third-boxes main-box-left">
			<div class="aperacash-box-title"><span>My AperaCash Balance</span></div>
			<div class="box-content"><span><?php echo do_shortcode( '[rs_user_total_points_in_value] ' ); ?></span></div>
		</div>
		<div class="dashboard-third-boxes sidebox-top">
			<div class="aperacash-box-title"><span>Spent</span></div>
			<div><span></span></div>
		</div>
		<div class="dashboard-third-boxes sidebox-bottom">
			<div class="aperacash-box-title"><span>Pending</span></div>
			<div><span></span></div>
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
</section>

<?php

	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );

	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
