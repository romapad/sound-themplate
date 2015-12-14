<?php
/**
 * Checkout Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

// filter hook for include new pages inside the payment method
$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', WC()->cart->get_checkout_url() ); ?>

	<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<div class="col2-set" id="customer_details">
			<div class="col-1">
<?php global $woocommerce;
      $cart_url = $woocommerce->cart->get_cart_url();
      echo '<a href="'. $cart_url .'" class="gotocart">Back to Shopping Cart</a>';
?>

<?php
if ( !is_user_logged_in()) {
    $info_message = apply_filters( 'woocommerce_checkout_login_message', '<a href="#" class="showlogin">' . __( 'Returning Customer? Login Here', 'woocommerce' ) . '</a>' );
    echo $info_message;
}
?>
<div class="clear"></div>
<?php
	woocommerce_login_form(
		array(
			'redirect' => wc_get_page_permalink( 'checkout' ),
			'hidden'   => true
		)
	);
?>
<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( $get_checkout_url ); ?>" enctype="multipart/form-data">
				<?php do_action( 'woocommerce_checkout_billing' ); ?>
				<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
</form>
			</div>

			<div class="col-2">
            	<h3 id="order_review_heading"><?php _e( 'Your order', 'woocommerce' ); ?></h3>
            	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

            	<div id="order_review" class="woocommerce-checkout-review-order">
            		<?php do_action( 'woocommerce_checkout_order_review' ); ?>
            	</div>

			</div>
		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>



	<?php endif; ?>


<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
