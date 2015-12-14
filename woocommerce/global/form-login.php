<?php
/**
 * Login form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( is_user_logged_in() ) {
	return;
}

?>
<form method="post" class="login" <?php if ( $hidden ) echo 'style="display:none;"'; ?>>

	<?php do_action( 'woocommerce_login_form_start' ); ?>

	<?php if ( $message ) echo wpautop( wptexturize( $message ) ); ?>
		<input type="text" class="input-text" name="username" id="username" placeholder="Email"/>
		<input class="input-text" type="password" name="password" id="password" placeholder="Password"/>

	<?php do_action( 'woocommerce_login_form' ); ?>

		<?php wp_nonce_field( 'woocommerce-login' ); ?>
		<input type="submit" class="button" name="login" value="<?php esc_attr_e( 'Login', 'woocommerce' ); ?>" />
		<input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ) ?>" />
			<input name="rememberme" type="checkbox" id="rememberme" value="forever" checked="checked" style="display:none;"/>
	<div class="clear"></div>
	<?php do_action( 'woocommerce_login_form_end' ); ?>
</form>
