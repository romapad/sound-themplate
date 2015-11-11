<?php
/**
 * Template Name: Home
 */


// slider
// WP_Query arguments
$args = array (
	'post_type'              => array( 'slider' ),
	'pagination'             => false,
);

// The Query
$query = new WP_Query( $args );

// The Loop
if ( $query->have_posts() ) { ?>
       <div class="slider">
        <ul class="rslides">
	<?php while ( $query->have_posts() ) {
		$query->the_post();
	    if ( has_post_thumbnail() ) {
		$feat_image_url = wp_get_attachment_url( get_post_thumbnail_id() ); ?>
            <li><?php if($post->post_excerpt) {
                $excerpt = strip_tags(get_the_excerpt()); ?>
                    <a href="<?php echo $excerpt; ?>"><img src="<?php echo $feat_image_url; ?>" alt="<?php the_title(); ?>"></a>
                <?php } else { ?>
                    <img src="<?php echo $feat_image_url; ?>" alt="<?php the_title(); ?>">
                <?php } ?>
            </li>
           <?php }

        } ?>
        </ul>
       </div>
<?php } else {
	// no posts found
}
// Restore original Post Data
wp_reset_postdata();


//tabs
?>
        </main><!-- /.main -->
      </div><!-- /.content -->
    </div><!-- /.wrap -->
<div class="tabs">
<ul>
    <li><h2>New Release</h2></li>
    <li><h2>Best-Sellers</h2></li>
    <li><h2>Specials</h2></li>
</ul>
<div class="tabs-content wrap container">
    <div class="tab-content"><?php echo do_shortcode('[recent_products per_page="8" columns="4"]'); ?></div>
    <div class="tab-content"><?php echo do_shortcode('[best_selling_products per_page="8" columns="4"]'); ?></div>
    <div class="tab-content"><?php echo do_shortcode('[featured_products per_page="8" columns="4"]'); ?></div>
</div>
</div>
<?php $cc = get_the_content();
if($cc != '') { ?>
<h2 class="h2brown"><?php the_title(); ?></h2>
<div class="brown sidebar-primary">
    <div class="wrap container" role="document">
      <div class="content row">
        <aside class="sidebar" role="complementary">
            <?php dynamic_sidebar('sidebar-home'); ?>
        </aside>
        <main class="main" role="main">
<?php
// endorsements
?>
<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/content', 'page'); ?>
<?php endwhile; ?>
        </main><!-- /.main -->
      </div><!-- /.content -->
    </div><!-- /.wrap -->
</div>
<?php } ?>
