<?php
/**
 * Loop Price
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
?>

<?php if ( $price_html = $product->get_price_html() ) : ?>

<?php $current_user = wp_get_current_user();
if ( wc_customer_bought_product( $current_user->user_email, $current_user->ID, $product->id)) { echo '<span class="price product-purchased">PURCHASED</span>';}
else { ?>

	<span class="price"><?php echo $price_html; ?></span>

<?php } ?>

<?php endif; ?>
