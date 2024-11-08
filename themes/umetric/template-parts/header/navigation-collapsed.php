<?php

/**
 * Template part for displaying the header navigation menu
 *
 * @package umetric
 */

namespace Umetric\Utility;

$umetric_options = get_option('umetric_options');

?>

<div class="responsive-vertical-logo-btn" id="responsive-logo-btn">
  <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-6">
        <!-- vertical menu btn container start-->
        <div class="iq-vertical-btn-container btn-vertical-open" id="vertical-menu-btn-open">
          <span class="vertical-menu-btn d-inline-block iq-round">
            <div id="iq-arrow-effect">
              <span class="iq-arrow iq-right-one next "><i class="fas fa-chevron-right"></i></span>
              <span class="iq-arrow  iq-right-two next "><i class="fas fa-chevron-right"></i></span>
            </div>
          </span>
        </div>
        <!-- vertical menu btn container end-->
        <a class="vertical-navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
          <?php
          if (function_exists('get_field') && class_exists('ReduxFramework')) {
            do_action('umetric_logo_dispaly');
          } else { ?>
              <img class="img-fluid logo" src="<?php  echo esc_url(get_template_directory_uri());?>/assets/images/logo.png" alt="<?php esc_attr_e('umetric', 'umetric'); ?>"> <?php
          }
          ?>
        </a>
      </div>

      <div class="col-6 text-right">
        <!-- action btn & sidebar btn start-->
        <div class="sub-main" id="vertical-menu-sub-main">

          <nav aria-label="breadcrumb">
            <!-- search option start-->
            <?php
            if (isset($umetric_options['header_display_search'])) {
              $options = $umetric_options['header_display_search'];
              if ($options == "yes") {
            ?>
                <div class="vertical-search">
                  <?php get_search_form(); ?>
                </div>
            <?php
              }
            }
            ?>
            <!-- search option end -->
            <?php
            if (isset($umetric_options['header_display_button'])) {
              $options = $umetric_options['header_display_button'];
              if ($options == "yes") {
                if ((!empty($umetric_options['umetric_download_link'])) && (!empty($umetric_options['umetric_download_title']))) {
                  $dlink = $umetric_options['umetric_download_link'];
                  $dtitle = $umetric_options['umetric_download_title'];
            ?>
                <div class="blue-btn button">
                  <a href="<?php echo esc_url($dlink); ?>">
                      <?php echo esc_html($dtitle); ?>
                  </a>
                </div>
            <?php }
              }
            } 
             if ($umetric_options['header_display_side_area'] == 'yes'){?>
            <!-- side area btn container start-->
            <div class="iq-sidearea-btn-container" id="menu-btn-side-open">
              <span class="menu-btn d-inline-block">
                <span class="line one"></span>
                <span class="line two"></span>
                <span class="line three"></span>
              </span>
            </div>
            <!-- side area btn container end-->
            <?php } ?>
          </nav>

        </div>
        <!-- action btn & sidebar btn start-->
      </div>
    </div>
  </div>
</div>