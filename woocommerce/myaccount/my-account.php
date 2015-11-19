<?php
/**
 * My Account page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices(); ?>
<div class="sidebar-primary row account-downloads">
<div class="sidebar">
<h2>Account Details <small>
    <?php
    printf( __( '[<a href="%s">Edit</a>]', 'woocommerce' ),
		wc_customer_edit_account_url()
	);
    ?>
</small></h2>
<p class="myaccount_user">
	<?php
	printf(
		__( '<strong>%1$s</strong>', 'woocommerce' ) . ' ',
		$current_user->user_email,
		wc_get_endpoint_url( 'customer-logout', '', wc_get_page_permalink( 'myaccount' ) )
	);
	?>
</p>
<?php wc_get_template( 'myaccount/my-address.php' ); ?>

</div>

<?php wc_get_template( 'myaccount/my-downloads.php' ); ?>

</div>
<?php do_action( 'woocommerce_before_my_account' ); ?>



<?php // wc_get_template( 'myaccount/my-orders.php', array( 'order_count' => $order_count ) ); ?>



<?php do_action( 'woocommerce_after_my_account' ); ?>
