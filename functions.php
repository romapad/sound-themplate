<?php
/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
$sage_includes = [
  'lib/utils.php',                 // Utility functions
  'lib/init.php',                  // Initial theme setup and constants
  'lib/wrapper.php',               // Theme wrapper class
  'lib/config.php',                // Configuration
  'lib/assets.php',                // Scripts and stylesheets
  'lib/titles.php',                // Page titles
  'lib/extras.php',                // Custom functions
];

foreach ($sage_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);


// remove add to cart button from category page
function remove_loop_button(){
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
}
add_action('init','remove_loop_button');

// Register Slider Post Type
function slider_post_type() {

	$labels = array(
		'name'                => _x( 'Slides', 'Post Type General Name', 'sage' ),
		'singular_name'       => _x( 'Slide', 'Post Type Singular Name', 'sage' ),
		'menu_name'           => __( 'Slider', 'sage' ),
		'name_admin_bar'      => __( 'Slider', 'sage' ),
		'parent_item_colon'   => __( '', 'sage' ),
		'all_items'           => __( 'Slides', 'sage' ),
		'add_new_item'        => __( 'Add New Item', 'sage' ),
		'add_new'             => __( 'Add New', 'sage' ),
		'new_item'            => __( 'New Item', 'sage' ),
		'edit_item'           => __( 'Edit Item', 'sage' ),
		'update_item'         => __( 'Update Item', 'sage' ),
		'view_item'           => __( 'View Item', 'sage' ),
		'search_items'        => __( 'Search Item', 'sage' ),
		'not_found'           => __( 'Not found', 'sage' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'sage' ),
	);
	$args = array(
		'label'               => __( 'Slide', 'sage' ),
		'description'         => __( 'Slider for Homepage', 'sage' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'excerpt', 'thumbnail', ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 20,
		'menu_icon'           => 'dashicons-images-alt',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'rewrite'             => false,
		'capability_type'     => 'post',
	);
	register_post_type( 'slider', $args );

}
add_action( 'init', 'slider_post_type', 0 );

// responcive youtube videos
add_filter( 'embed_oembed_html', 'custom_oembed_filter', 10, 4 ) ;

function custom_oembed_filter($html, $url, $attr, $post_ID) {
    $return = '<div class="video-container">'.$html.'</div>';
    return $return;
}

// Change number or products per row to 3
add_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {
	function loop_columns() {
		return 3; // 3 products per row
	}
}


/**
 * Add new register fields for WooCommerce registration.
 *
 * @return string Register fields HTML.
 */
function wooc_extra_register_fields() {
	?>

	<p class="form-row">
	<label for="reg_billing_first_name"><?php _e( 'First Name', 'woocommerce' ); ?></label>
	<input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
	</p>

	<p class="form-row">
	<label for="reg_billing_last_name"><?php _e( 'Last Name', 'woocommerce' ); ?></label>
	<input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
	</p>
	<?php
}

add_action( 'woocommerce_register_form_start', 'wooc_extra_register_fields' );

/**
 * Validate the extra register fields.
 *
 * @param  string $username          Current username.
 * @param  string $email             Current email.
 * @param  object $validation_errors WP_Error object.
 *
 * @return void
 */
function wooc_validate_extra_register_fields( $username, $email, $validation_errors ) {
	if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
		$validation_errors->add( 'billing_first_name_error', __( '<strong>Error</strong>: First name is required!', 'woocommerce' ) );
	}

	if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
		$validation_errors->add( 'billing_last_name_error', __( '<strong>Error</strong>: Last name is required!.', 'woocommerce' ) );
	}

}

add_action( 'woocommerce_register_post', 'wooc_validate_extra_register_fields', 10, 3 );

/**
 * Save the extra register fields.
 *
 * @param  int  $customer_id Current customer ID.
 *
 * @return void
 */
function wooc_save_extra_register_fields( $customer_id ) {
	if ( isset( $_POST['billing_first_name'] ) ) {
		// WordPress default first name field.
		update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name'] ) );

		// WooCommerce billing first name.
		update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
	}

	if ( isset( $_POST['billing_last_name'] ) ) {
		// WordPress default last name field.
		update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['billing_last_name'] ) );

		// WooCommerce billing last name.
		update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
	}
}

add_action( 'woocommerce_created_customer', 'wooc_save_extra_register_fields' );


remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);

/** Remove Showing results functionality site-wide */
function woocommerce_result_count() {
        return;
}

// Lets create the function to house our form
//remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

function woocommerce_catalog_page_ordering() {
?>
<?php echo '<div class="itemsorder"><h3>Sort:</h3>' ?>
    <form action="" method="POST" name="results" class="woocommerce-ordering">
    <select name="woocommerce-sort-by-columns" id="woocommerce-sort-by-columns" class="sortby" onchange="this.form.submit()">
<?php

//Get products on page reload
if  (isset($_POST['woocommerce-sort-by-columns']) && (($_COOKIE['shop_pageResults'] <> $_POST['woocommerce-sort-by-columns']))) {
        $numberOfProductsPerPage = $_POST['woocommerce-sort-by-columns'];
          } else {
        $numberOfProductsPerPage = $_COOKIE['shop_pageResults'];
          }

//  This is where you can change the amounts per page that the user will use  feel free to change the numbers and text as you want, in my case we had 4 products per row so I chose to have multiples of four for the user to select.
			$shopCatalog_orderby = apply_filters('woocommerce_sortby_page', array(
			//Add as many of these as you like, -1 shows all products per page
			  //  ''       => __('Results per page', 'woocommerce'),
				'12' 		=> __('12', 'woocommerce'),
				'24' 		=> __('24', 'woocommerce'),
				'32' 		=> __('32', 'woocommerce'),
				'-1' 		=> __('All', 'woocommerce'),
			));

		foreach ( $shopCatalog_orderby as $sort_id => $sort_name )
			echo '<option value="' . $sort_id . '" ' . selected( $numberOfProductsPerPage, $sort_id, true ) . ' >' . $sort_name . '</option>';
?>
</select>
</form>

<?php echo ' <h3>Products / Page:</h3></div>' ?>
<?php
}

// now we set our cookie if we need to
function dl_sort_by_page($count) {
  if (isset($_COOKIE['shop_pageResults'])) { // if normal page load with cookie
     $count = $_COOKIE['shop_pageResults'];
  }
  if (isset($_POST['woocommerce-sort-by-columns'])) { //if form submitted
    setcookie('shop_pageResults', $_POST['woocommerce-sort-by-columns'], time()+1209600, '/', 'www.your-domain-goes-here.com', false); //this will fail if any part of page has been output- hope this works!
    $count = $_POST['woocommerce-sort-by-columns'];
  }
  // else normal page load and no cookie
  return $count;
}

add_filter('loop_shop_per_page','dl_sort_by_page');
add_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_page_ordering', 40 );


// change pagination .prev & .next labels
add_filter( 'woocommerce_pagination_args' , 'custom_override_pagination_args' );

function custom_override_pagination_args( $args ) {
	$args['prev_text'] = __( 'Previous Page' );
	$args['next_text'] = __( 'Next Page' );
	return $args;
}


// change place for "my contributions"
if (wc_product_reviews_pro()){
remove_action( 'woocommerce_before_my_account', array( wc_product_reviews_pro()->frontend, 'render_my_account_contributions' ), 11 );
add_action( 'woocommerce_after_my_account', array( wc_product_reviews_pro()->frontend, 'render_my_account_contributions' ), 5 );
}

// change place for wichlists
add_filter('woocommerce_wishlists_account_location', 'change_woocommerce_wishlists_account_location', 10, 1);
function change_woocommerce_wishlists_account_location($location) {
return 'before';
}
/**
 * @desc Remove quantity in all product type
 */
function wc_remove_all_quantity_fields( $return, $product ) {
    if( is_product() ) {
        return true;
    }
}
add_filter( 'woocommerce_is_sold_individually', 'wc_remove_all_quantity_fields', 10, 2 );

// change place for price
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10, 2);
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25, 2);
// change place for product_meta
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40, 2);
//add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 10, 2);
// change place for rating
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10, 2);
//tabs
add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );
function woo_rename_tabs( $tabs ) {
	$tabs['reviews']['title'] = __( 'Reviews' );
	return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
function woo_remove_product_tabs( $tabs ) {
    unset( $tabs['additional_information'] );
    return $tabs;
}
// change my orders title
add_filter( 'woocommerce_my_account_my_orders_title',              'override_my_account_my_orders_title', 10, 1 );
function override_my_account_my_orders_title( $message ) {
    return __( 'Order History', 'woocommerce' );
}

// add go to shop link on cart page
add_action('woocommerce_before_cart', 'woo_go_to_shop_link', 10);
function woo_go_to_shop_link() {
    $shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );
    echo '<a href="'. $shop_page_url .'" class="gotoshop">Continue Shopping</a>';
}

// login-logout links in menu
add_filter( 'wp_nav_menu_items', 'add_loginout_link', 10, 2 );
function add_loginout_link( $items, $args ) {
    if (is_user_logged_in() && $args->  theme_location == 'primary_navigation') {
        $memberlink = '<a href="/account/">My Account</a>';
        $items .= '<li class="marg"><a href="'. wp_logout_url( home_url() ) .'">Logout</a></li> <li class="span"><span>|</span></li> <li>'. $memberlink .'</li>';
    }
    elseif (!is_user_logged_in() && $args->theme_location == 'primary_navigation') {
        $items .= '<li class="marg"><a href="'. site_url('/account/') .'">Login</a></li> <li class="span"><span>|</span></li> <li><a href="'. site_url('/account/') .'">Signup</a></li>';
    }
    return $items;
}
// change add to cart text
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_archive_custom_cart_button_text' );    // 2.1 +

function woo_archive_custom_cart_button_text() {
        return __( 'Add to Cart', 'woocommerce' );
}

// change catalog ordering function
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

if ( ! function_exists( 'woocommerce_new_catalog_ordering' ) ) {

	/**
	 * Output the product sorting options.
	 *
	 * @subpackage	Loop
	 */
	function woocommerce_new_catalog_ordering() {
		global $wp_query;

		if ( ! woocommerce_products_will_display() ) {
			return;
		}

		$orderby                 = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
		$show_default_orderby    = 'menu_order' === apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
		$catalog_orderby_options = apply_filters( 'woocommerce_catalog_orderby', array(
			'menu_order' => __( 'Default sorting', 'woocommerce' ),
			'popularity' => __( 'Sort by popularity', 'woocommerce' ),
			'rating'     => __( 'Sort by average rating', 'woocommerce' ),
			'date'       => __( 'Sort by newness', 'woocommerce' ),
			'price'      => __( 'Sort by price: low to high', 'woocommerce' ),
			'price-desc' => __( 'Sort by price: high to low', 'woocommerce' )
		) );

		if ( ! $show_default_orderby ) {
			unset( $catalog_orderby_options['menu_order'] );
		}

		if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' ) {
			unset( $catalog_orderby_options['rating'] );
		}

		wc_get_template( 'loop/orderby.php', array( 'catalog_orderby_options' => $catalog_orderby_options, 'orderby' => $orderby, 'show_default_orderby' => $show_default_orderby ) );
	}
}

add_action( 'woocommerce_before_shop_loop', 'woocommerce_new_catalog_ordering', 30 );
