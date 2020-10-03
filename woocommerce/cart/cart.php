<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

defined( 'ABSPATH' ) || exit;

$count = WC()->cart->cart_contents_count;

if ( 0 < $count ) :
    header( "Location:" . esc_url( wc_get_checkout_url() ) );
endif; 

do_action( 'woocommerce_before_cart' );

?>

<div class="row wonka-cart-row">
    <div class="col col-12 col-md-8">
        <form class="woocommerce-cart-form form-inline" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
            
    <?php do_action('woocommerce_before_cart_table'); ?>

    <?php do_action('woocommerce_before_cart_contents'); ?>

    <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents table table-hover" cellspacing="0">
        <thead>
            <tr>
                <th colspan="6"><?php echo sprintf( esc_html__('Your Cart ( %d )', 'woocommerce'), $count ); ?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="col" class="product-name" colspan="3"><?php esc_html_e('Product', 'woocommerce'); ?></th>
                <th scope="col" class="product-price"><?php esc_html_e('Price', 'woocommerce'); ?></th>
                <th scope="col" class="product-quantity"><?php esc_html_e('Quantity', 'woocommerce'); ?></th>
                <th scope="col" class="product-subtotal"><?php esc_html_e('Total', 'woocommerce'); ?></th>
            </tr>

            <?php
            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                    $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                    ?>
                    <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

                        <td class="product-remove">
                            <?php
								
								echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped.
                                    'woocommerce_cart_item_remove_link', sprintf(
                                    '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                                    esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                    esc_html__( 'Remove this item', 'woocommerce' ),
                                    esc_attr( $product_id ),
                                    esc_attr( $_product->get_sku() )
                                ), $cart_item_key );
                            ?>
                        </td>

                        <td class="product-thumbnail">
                        <?php
                        $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

                        if ( ! $product_permalink ) {
                            echo $thumbnail; // PHPCS: XSS ok.
                        } else {
                            printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail); // PHPCS: XSS ok.
                        }
                        ?>
                        </td>

                        <td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
                        <?php
                        if ( ! $product_permalink ) {
                            echo wp_kses(
                                        sprintf( '<a href="%s" class="product-link">%s</a>', esc_url( $product_permalink ), apply_filters( 'cart_and_review_woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ),
                                        array(
                                            'a' => array(
                                                'class' => array(),
                                                'href'  => array(),
                                            ),
                                        )
                                    );
                        } else {
                            echo wp_kses(
                                        sprintf( '<a href="%s" class="product-link">%s</a>', esc_url( $product_permalink ), apply_filters( 'cart_and_review_woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ),
                                        array(
                                            'a' => array(
                                                'class' => array(),
                                                'href'  => array(),
                                            ),
                                        )
                                    );
                        }

                        do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

                        // Meta data.
                        echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

                        // Backorder notification.
                        if ($_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                            echo wp_kses_post( apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id ) );
                        }
                        ?>
                        </td>

                        <td class="product-price" data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
                            <?php
                                echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                            ?>
                        </td>

                        <td class="product-quantity" data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
                        <?php
                        if ($_product->is_sold_individually()) {
                            $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" class="form-control" />', $cart_item_key);
                        } else {
                            $product_quantity = woocommerce_quantity_input(array(
                                'input_name'   => "cart[{$cart_item_key}][qty]",
                                'input_value'  => $cart_item['quantity'],
                                'max_value'    => $_product->get_max_purchase_quantity(),
                                'min_value'    => '0',
                                'product_name' => $_product->get_name(),
                                'class' => 'form-control',
                            ), $_product, false);
                        }

                        echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // PHPCS: XSS ok.
                        ?>
                        </td>

                        <td class="product-subtotal" data-title="<?php esc_attr_e('Total', 'woocommerce'); ?>">
                            <?php
                                echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                            ?>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>

            <?php do_action('woocommerce_cart_contents'); ?>

            <tr>
                <td colspan="6" class="actions">

                    <button type="submit" class="button wonka-btn" name="update_cart" value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>"><?php esc_html_e('Update cart', 'woocommerce'); ?></button>

                    <?php do_action('woocommerce_cart_actions'); ?>

                    <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
                </td>
            </tr>

            <?php do_action('woocommerce_after_cart_contents'); ?>
        </tbody>
    </table>
    <?php do_action('woocommerce_after_cart_table'); ?>
</form>
</div>
<div class="col col-12 col-md-4">
<div class="cart-collaterals">
    <?php

        // Remove Cross Sells From Default Position
        // moving to after cart in woocommerce.php file
        remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
        /**
         * Cart collaterals hook.
         *
         * @hooked woocommerce_cross_sell_display
         * @hooked woocommerce_cart_totals - 10
         */
        do_action('woocommerce_cart_collaterals');
    ?>
</div><!-- .cart-collaterals -->
</div><!-- .col -->
</div><!-- .row -->

<?php do_action('woocommerce_after_cart'); ?>
