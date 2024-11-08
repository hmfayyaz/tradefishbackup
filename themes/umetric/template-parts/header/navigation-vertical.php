<?php

/**
 * Template part for displaying the header navigation menu
 *
 * @package umetric
 */

namespace Umetric\Utility;

$umetric_options = get_option('umetric_options');
?>

<nav class="navbar navbar-expand-lg navbar-light">
    <div class="iq-vertical-header-logo">
      <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
      <?php
          if (function_exists('get_field') && class_exists('ReduxFramework')) {
              do_action('umetric_logo_dispaly');
          } else { ?>
              <img class="img-fluid logo" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/logo.png" alt="<?php esc_attr_e('umetric', 'umetric'); ?>"> <?php
          }
            ?>
      </a>
      <!-- vertical menu btn container start-->
      <div class="iq-vertical-btn-container btn-vertical-close" id="vertical-menu-btn-close">
        <span class="vertical-menu-btn iq-round-two">
          <div id="iq-arrow-effect">
            <span class="iq-arrow iq-right-one next-left"><i class="fas fa-chevron-left"></i></span>
            <span class="iq-arrow  iq-left-two next-left"><i class="fas fa-chevron-left"></i></span>
          </div>
        </span>
      </div>
      <!-- vertical menu btn container end-->
    </div>
    <div class="vertical" id="menu-sidebar-scrollbar">
      <?php if (has_nav_menu('vertical')) : ?>
        <?php wp_nav_menu(array(
          'theme_location' => 'vertical',
          'menu_class'     => 'navbar-nav ml-auto',
          'menu_id'        => 'vertical-menu',
          'container_id'   => 'iq-menu-container',
        )); ?>
      <?php endif; ?>
    </div>
  </nav>