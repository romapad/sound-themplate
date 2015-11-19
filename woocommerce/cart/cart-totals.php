<?php
/**
 * Cart totals
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="cart_totals <?php if ( WC()->customer->has_calculated_shipping() ) echo 'calculated_shipping'; ?>">

	<?php do_action( 'woocommerce_before_cart_totals' ); ?>

	<div class="wc-proceed-to-checkout">

		<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>

	</div>

	<table cellspacing="0">

		<tr class="cart-subtotal">
			<td>
			    <?php _e( 'Subtotal', 'woocommerce' ); ?>
            </td>
			<td>
                <?php wc_cart_totals_subtotal_html(); ?>
			    <p class="wc-cart-shipping-notice">Excluding Tax</p>
			</td>
		</tr>

	</table>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>
</div>
