<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

?>
<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">

<?php $current_user = wp_get_current_user();

if ( wc_customer_bought_product( $current_user->user_email, $current_user->ID, $product->id)) { echo '<p class="price"><span class="product-purchased">You already own this product</span></p>';}
else { ?>

	<p class="price"><?php echo $product->get_price_html(); ?></p>

	<meta itemprop="price" content="<?php echo esc_attr( $product->get_price() ); ?>" />
	<meta itemprop="priceCurrency" content="<?php echo esc_attr( get_woocommerce_currency() ); ?>" />
	<link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />

<?php } ?>

</div>
