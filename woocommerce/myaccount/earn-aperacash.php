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
			<div class="legend-color legend-color-green"></div><div class="legend-color-text">Green items are always there to earn with.</div>
		</li>
		<li>
			<div class="legend-color legend-color-blue"></div><div class="legend-color-text">Blue items can only be used once.</div>
		</li>
		<li>
			<div class="legend-color legend-color-grey"></div><div class="legend-color-text">Grey items are already applied to your account.</div>
		</li>
	</ul>
</section>
<section class="earn-aperacash-second">
	
</section>
