<?php

/**
 * Template part for displaying the header navigation menu
 *
 * @package umetric
 */

namespace Umetric\Utility;

$umetric_options = get_option('umetric_options');
?>

<div class="main-header">
    <div class="container">

      <div class="row no-gutters">
        <div class="col-sm-12">
              <nav class="navbar navbar-expand-lg navbar-light menu">
                  <div class="logo_block">
                      <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>"> 
                      <img class="img-fluid logo" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/logo.png" alt="<?php esc_attr_e('umetric', 'umetric'); ?>">    
                      <img class="img-fluid logo-sticky" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/logo.png" alt="<?php esc_attr_e('umetric', 'umetric'); ?>">
                      </a>
                  </div>
                  <?php if (has_nav_menu('top')) : ?>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                    
                          <li class="search-btn">
                            <a href="#" id="btn-search"><i class="fa fa-search" aria-hidden="true"></i></a>
                            <div class="search">
                              <button id="btn-search-close" class="btn btn--search-close" aria-label="Close search form">
                                <i class="far fa-times-circle" aria-hidden="true"></i>
                              </button>
                              <?php get_search_form(); ?>
                            </div>
                          </li>
                    
                    </ul>
                  </div>
                </nav>
        </div>
      </div>
    </div>
</div>