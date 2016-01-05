<div class="header-top">
     <div class="container">
         <div class="social">
             <?php //if ( function_exists('get_scp_widget') ) {
                  //echo get_scp_widget();
             //} else {
                  dynamic_sidebar('sidebar-top-left');
            //}?>
         </div>
         <div class="offer">
             <?php dynamic_sidebar('sidebar-top'); ?>
         </div>
     </div>
 </div>
 <header class="banner" role="banner">
  <div class="container">
    <a class="brand" href="<?= esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
    <nav role="navigation">
      <?php
      if (has_nav_menu('primary_navigation')) :
        wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav', 'container' => '']);
      endif;
      ?>
    </nav>
  </div>
</header>
