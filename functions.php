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
