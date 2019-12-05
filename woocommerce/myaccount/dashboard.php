<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$user = wp_get_current_user();

if ( ! in_array( 'apera_perks_partner', $user->roles ) ) { ?>
	<div id="upgrade-btn-wrapper">
	<?php
	echo sprintf(
		__( '<a href="#" data-user="%s" id="perks-upgrade-btn" class="wonka-btn">Join Perks and Earn</a>.', 'woocommerce' ),
		esc_attr( $user->ID )
	);
	?>
	</div>
	<?php
}
?>

<section class="dashboard-first">
	<div class="dashboard-first-col dashboard-first-left">
		
<p>
<?php
	/* translators: 1: user display name 2: logout url */
	printf(
		__( 'Hello %1$s (not %1$s? <a href="%2$s">Log out</a>)', 'woocommerce' ),
		'<strong>' . esc_html( $current_user->display_name ) . '</strong>',
		esc_url( wc_logout_url( wc_get_page_permalink( 'myaccount' ) ) )
	);
	?>
	</p>

<p>
<?php
	printf(
		__( 'From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">shipping and billing addresses</a>, and <a href="%3$s">edit your password and account details</a>.', 'woocommerce' ),
		esc_url( wc_get_endpoint_url( 'orders' ) ),
		esc_url( wc_get_endpoint_url( 'edit-address' ) ),
		esc_url( wc_get_endpoint_url( 'edit-account' ) )
	);
	?>
	</p>
	</div>

	<div class="dashboard-first-col dashboard-first-right">
<?php
/** Only to be used on the live site.
 *  $attachment_id = 12593;
 *  <img srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( $attachment_id, 'thumbnail', false ) ); ?>" />
 */
?>
<img src="https://aperabags.com/wp-content/uploads/2019/12/earn-more-cta.jpg" />
</div>
</section>



<?php
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );

