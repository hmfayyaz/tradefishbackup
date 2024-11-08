<?php


$umetric_options = get_option('umetric_options');
$sticky = '';
$header_class = '';
if (isset($umetric_options['umetric_sticky_header_switch'])) {
  $sticky =  $umetric_options['umetric_sticky_header_switch'];
}


if ($sticky) {
  $header_class .= ' has-sticky';
}


if (isset($umetric_options['header_back_opt_switch']) && $umetric_options['header_back_opt_switch'] == 3) {
  $header_class .= ' header_transperent';
}

?>


  <?php
  if (isset($umetric_options['umetric_top_header_switch']) && $umetric_options['umetric_top_header_switch']) { ?>
    <div class="sub-header">
      <div class="container">
        <?php
        get_template_part('template-parts/header/navigation', 'top');
        ?>

      </div>
    </div>
  <?php  }

  ?>

  <div class="main-header <?php echo esc_attr($header_class);  ?>">
    <div class="container">

      <div class="row no-gutters">
        <div class="col-sm-12">

            <nav class="navbar navbar-expand-lg navbar-light menu">
                  <div class="logo_block">
                    <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>"> <?php
                        if (function_exists('get_field') && class_exists('ReduxFramework')) {
                            do_action('umetric_logo_dispaly');
                        } else { ?>
                            <img class="img-fluid logo" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/logo.png" alt="<?php esc_attr_e('umetric', 'umetric'); ?>"> 
                            <img class="img-fluid logo-sticky" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/logo.png" alt="<?php esc_attr_e('umetric', 'umetric'); ?>"> 
                        <?php } ?>
                    </a>
                  </div>
                  <?php if (has_nav_menu('top')) : ?>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
                    </button>
                  <?php endif; ?>
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <?php if (has_nav_menu('top')) : ?>
                      <?php wp_nav_menu(array(
                        'theme_location' => 'top',
                        'menu_class'     => 'navbar-nav',
                        'menu_id'        => 'top-menu',
                        'container_id'   => 'iq-menu-container',
                      )); ?>
                    <?php endif; ?>
                  </div>
                  <div class="sub-main">
                    <ul class="shop_list">
                      <?php
                      if (isset($umetric_options['header_display_search'])) {
                        $options = $umetric_options['header_display_search'];
                        if ($options == "yes") {
                      ?>
                          <li class="search-btn">
                            <a href="#" id="btn-search"><i class="fa fa-search" aria-hidden="true"></i></a>
                            <div class="search">
                              <button id="btn-search-close" class="btn btn--search-close" aria-label="Close search form">
                                <i class="far fa-times-circle" aria-hidden="true"></i>
                              </button>
                              <?php get_search_form(); ?>
                            </div>
                          </li>
                      <?php
                        }
                      }
                      ?>
                      <?php
                      if (isset($umetric_options['header_display_button'])) {
                        $options = $umetric_options['header_display_button'];
                        if ($options == "yes") {
                      ?>
                          <?php if ((!empty($umetric_options['umetric_download_link'])) && (!empty($umetric_options['umetric_download_title']))) {
                            $dlink = $umetric_options['umetric_download_link'];
                            $dtitle = $umetric_options['umetric_download_title'];
                          ?>
                            <li class="button-btn">
                              <nav aria-label="breadcrumb">
                                <div class="blue-btn button">
                                  <a href="<?php echo esc_url($dlink, 'umetric'); ?>"><?php echo esc_html($dtitle, 'umetric'); ?>
                                  </a>
                                </div>
                              </nav>
                            </li>
                          <?php } ?>
                      <?php
                        }
                      }
                      ?>
                      <?php 
                      if (isset($umetric_options['header_display_side_area'])) {
                        if ($umetric_options['header_display_side_area'] == 'yes') { ?>
                          <li>
                            <!-- side area btn container start-->
                            <div class="iq-sidearea-btn-container" id="menu-btn-side-open">
                              <span class="menu-btn d-inline-block">
                                <span class="line one"></span>
                                <span class="line two"></span>
                                <span class="line three"></span>
                              </span>
                            </div>
                            <!-- side area btn container end-->
                          </li>
                      <?php }
                      }
                      ?>
                    </ul>
                  </div>
            </nav>
           </div>
       </div>
    </div>
  </div>
                   