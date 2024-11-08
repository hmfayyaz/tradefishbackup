<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package umetric
 */

namespace Umetric\Utility;

use Elementor\Plugin;

?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <link rel="profile" href="<?php echo is_ssl() ? 'https:' : 'http:' ?>//gmpg.org/xfn/11">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <?php 
  $umetric_option = get_option('umetric_options');

  if (!function_exists('has_site_icon') || !wp_site_icon()) {
    if (!empty($umetric_option['umetric_background_favicon']['url'])) { ?>
      <link rel="shortcut icon" href="<?php echo esc_url($umetric_option['umetric_background_favicon']['url']); ?>" />
    <?php
    } else {
    ?>
      <link rel="shortcut icon" href="<?php echo esc_url(get_template_directory_uri() . '/assets/images/redux/favicon.png'); ?>" />
       <?php
    }
  }
    ?>
  <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
	 
	<?php if ( is_user_logged_in() ) { ?>
	<?php }
	else { ?>
	<div class="login_popup">
		<img src="/wp-content/uploads/2024/01/Tradefish-white-text.png.svg" width="240">
		<?php echo do_shortcode('[ethpress_login_button]'); ?>
		 
	</div>
	<?php } ?>
  <?php wp_body_open(); ?>

  <!-- loading -->
  <?php
  $bgurl = '';
  $site_classes = '';
  $has_sticky = '';
  $default_header_container = '';
  $header_class = '';
  $header_position_class ='';
  $header_style = '';
  
  if (class_exists('ReduxFramework')) {
    //theme site class
    $site_classes .= 'umetric ';
    //loader
    if (isset($umetric_option['display_loader']) && $umetric_option['display_loader'] === 'yes') {
      if (!empty($umetric_option['loader_gif']['url'])) {
        $bgurl = $umetric_option['loader_gif']['url'];
      }
    }
    //sticky header
    if (isset($umetric_option['umetric_sticky_header_switch']) && $umetric_option['umetric_sticky_header_switch'] == 1) {
      $has_sticky = ' has-sticky';
    }
    // container
    if (isset($umetric_option['header_layout']) && $umetric_option['header_layout'] == 'default') {
      $default_header_container = ($umetric_option['header_container'] == 'container') ? 'container' : 'container-fluid';
    }
  } else {
    //default
    $bgurl = get_template_directory_uri() . '/assets/images/redux/loader.gif';
    $has_sticky = ' has-sticky';
    $default_header_container = 'container-fluid';
  }
  ?>

<!-- start side area -->
<?php if (isset($umetric_option['header_display_side_area']) && $umetric_option['header_display_side_area'] == 'yes'){?>
    <div id="has-side-bar" class="iq-menu-side-bar">
        <div class="iq-sidearea-btn-container btn-container-close" id="menu-btn-side-close">
            <span class="menu-btn d-inline-block is-active">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </span>
        </div>
        <div id="sidebar-scrollbar">
            <div class="iq-sidebar-container">
                <div class="iq-sidebar-content">
                      <?php 
                    if( is_active_sidebar( 'iq_side_area' ) ) {
                      dynamic_sidebar( 'iq_side_area' );
                    }
                      ?>	
                </div>	 
            </div>
        </div>
    </div>
<?php } ?>
<!-- end side area -->
    <?php
  
  if ( class_exists('ReduxFramework') ) { 
    
    $options = '';
    if (isset($umetric_option['umetric_loader_switch'])) {
      $options = $umetric_option['umetric_loader_switch'];
    }

    if($options != 0){      
          ?>
      <div id="loading">
          <div id="loading-center">
              <?php
              if ($options == 1) {
                if (!empty($umetric_option['umetric_background_loader']['url'])) {
                    $bgurl = $umetric_option['umetric_background_loader']['url'];
                      ?>
                  <div class="load-img">
                    <img src="<?php echo esc_url($bgurl); ?>" alt="<?php esc_attr_e('loader', 'umetric'); ?>">
                  </div>
                <?php
                }
              } else if ($options == 2) {
                if (isset($umetric_option['umetric_loader_tag'])) {
                  $tag = $umetric_option['umetric_loader_tag'];
                } else {
                  $tag = "2";
                }
                if (isset($umetric_option['umetric_loader_back_color_text'])) {
                  $style = "color:" . $umetric_option['umetric_loader_back_color_text'] . "";
                } else {
                  $style = '';
                }

                echo '<' . esc_attr($tag) . ' style=' . esc_attr($style) . '>' . esc_html__($umetric_option['umetric_loader_text'], 'umetric') . '</' . esc_attr($tag) . '>';
              }
                ?>
          </div>
      </div>
          <?php 
    }

  } else {

      $bgurl = get_template_directory_uri() . '/assets/images/redux/loader.gif';
        ?>
      <div id="loading">
        <div id="loading-center">
          <div class="load-img">
            <img src="<?php echo esc_url($bgurl); ?>" alt="<?php esc_attr_e('loader', 'umetric'); ?>">
          </div>
        </div>
      </div>
        <?php
  } ?>

  <!-- loading End -->
  <?php

  $is_default_header = true;
  $header_response = '';
  if (function_exists('get_field') && class_exists('ReduxFramework')) {

    $id = (get_queried_object_id()) ? get_queried_object_id() : '';
   
      $page_id = get_queried_object_id();
      $key = get_field('key_header_variation', $page_id);
      
      if(isset($key['header_layout_type']) && $key['header_layout_type'] == "default"){

        if($key['header_menu_variation'] != "default"){

         
          if($key['header_menu_variation'] == '1'){
            $header_class .= 'header-one default-header';
          } elseif($key['header_menu_variation'] == '2'){
              $header_class .= 'style-vertical default-header';
              $site_classes .= 'vertical-site-content';
          } else {
              $header_class = 'header-default';
          }

        } else {

          if($umetric_option['umetric_header_layout'] == 'default'){
          
              if($umetric_option['umetric_header_variation'] == '1'){
                  $header_class .= 'header-one default-header';
              } elseif($umetric_option['umetric_header_variation'] == '2'){
                  $header_class .= 'style-vertical default-header';
                  $site_classes .= 'vertical-site-content';
              } else {
                  $header_class = 'header-default';
              }

          } else {
              $header_style .= 'header-default';
          }

        }


      } else {

          $header_style .= 'header-default';
     
      }

  } else {
      $header_class .= 'header-one default-header';
  }


  $is_default_header = true;
  $header_response = '';
  if (function_exists('get_field') && class_exists('ReduxFramework')) {

    $id = (get_queried_object_id()) ? get_queried_object_id() : '';
    // ------------header
    if (class_exists("Elementor\Plugin")) {

      $header_display = !empty($id) ? get_post_meta($id, '_header_layout_display_header', true) : '';
      $umetric_header_layout = !empty($id) ? get_post_meta($id, 'header_layout_style_header_layout_type', true) : '';
      $header_name = !empty($id) ? get_post_meta($id, 'header_layout_style_header_layout_name', true) : '';
      $header_position = !empty($id) ? get_post_meta($id, 'header_layout_style_header_layout_position', true) : '';
      
      if ($umetric_header_layout === 'custom' && !empty($header_name)) {
      
        $is_default_header = false;
        $header = $header_name;
        $has_sticky = '';
        $my_layout = get_page_by_path($header, '', 'iqonic_hf_layout');
        if ($my_layout) {
          $header_response =  Plugin::instance()->frontend->get_builder_content_for_display($my_layout->ID);

        }

        if($header_position === "vertical"){
            $header_position_class .= ' vertical-header';
        }
    
      } else if (isset($umetric_option['umetric_header_layout']) && $umetric_option['umetric_header_layout'] == 'custom') {
     
        if (!empty($umetric_option['umetric_menu_style'])) {
          $is_default_header = false;
          $header = $umetric_option['umetric_menu_style'];
          $has_sticky = '';
          $my_layout = get_page_by_path($header, '', 'iqonic_hf_layout');
          if ($my_layout) {
            $header_response =  Plugin::instance()->frontend->get_builder_content_for_display($my_layout->ID);
           
          }
        }

        $h_layout_position = !empty($id) ? get_post_meta($id, 'header_layout_style_header_layout_position', true) : '';

        if ($umetric_header_layout === 'custom' && !empty($header_name) && $h_layout_position === 'vertical') {
          $header_position_class .= ' vertical-header';
        } else {
          if (isset($umetric_option['header_layout_position']) && $umetric_option['header_layout_position'] == 'vertical') {
            $header_position_class .= ' vertical-header';
          }
        }

        if (!strpos($header_position_class, 'vertical-header')) {
            $h_position = !empty($id) ? get_post_meta($id, 'header_layout_style_header_position', true) : '';
            $header_position_class = '';
            if ($h_position === 'over') {
                $header_position_class .= ' header-over';
            } else {
                if (isset($umetric_option['header_postion']) && $umetric_option['header_postion'] == 'over') {
                  $header_position_class .= ' header-over';
                }
            }
        }

      }
    }
    // ---------------header end
       
  }

  ?>
  <div id="page" class="site <?php echo esc_attr(trim($site_classes)); ?> <?php echo esc_attr(trim($header_position_class)); ?>">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'umetric'); ?></a>
     
    <header class="<?php echo esc_attr($header_class); ?> <?php echo esc_attr($header_style); ?> <?php echo esc_attr($has_sticky); ?>">
      <?php
     
      if (!$is_default_header && !empty($header_response)) {

        if (function_exists('get_field') && class_exists('ReduxFramework')) {
          $page_id = get_queried_object_id();
          $key = get_field('key_header_variation', $page_id);

          if($key['header_layout_type'] == "default"){
            if($key['header_menu_variation'] != "default"){

              if ($key['header_menu_variation'] == "1") {  
                get_template_part('template-parts/header/navigation', 'one'); 
              } elseif ($key['header_menu_variation'] == "2") {
                get_template_part('template-parts/header/navigation', 'vertical');
              } 
  
            } elseif($umetric_option['umetric_header_layout'] == 'custom'){
                echo function_exists('iqonic_return_elementor_res') ? iqonic_return_elementor_res($header_response) : $header_response;
            }
          } else {
            echo function_exists('iqonic_return_elementor_res') ? iqonic_return_elementor_res($header_response) : $header_response;
          }
          
        }

      } else {
        $is_default_header = true;
      }

      if ($is_default_header) {
      
          if (function_exists('get_field') && class_exists('ReduxFramework')) {
              $page_id = get_queried_object_id();
              $key = get_field('key_header_variation', $page_id);
        
              if (isset($key['header_menu_variation']) && $key['header_menu_variation'] != "default") {

                  if ($key['header_menu_variation'] == "1") {  
                    get_template_part('template-parts/header/navigation', 'one'); 
                  }elseif ($key['header_menu_variation'] == "2") {
                    get_template_part('template-parts/header/navigation', 'vertical');
                  } else { 
                    get_template_part('template-parts/header/navigation');
                  } 
                
              } else {
                  if($umetric_option['umetric_header_variation'] == '1'){ 
                      get_template_part('template-parts/header/navigation', 'one'); 
                  } elseif($umetric_option['umetric_header_variation'] == '2') { 
                      get_template_part('template-parts/header/navigation', 'vertical'); 
                  } 
              }

          } else { 
              get_template_part('template-parts/header/navigation');
          } 

      }
         ?>
    </header><!-- #masthead -->

     <?php
      if (function_exists('get_field') && class_exists('ReduxFramework')) 
      {
          $page_id = get_queried_object_id();
          $key = get_field('key_header_variation', $page_id);

          if($key['header_menu_variation'] == '2') {
            if(isset($key['header_menu_collapsed']) && $key['header_menu_collapsed'] == "acf_ver_collapsed") {
                get_template_part('template-parts/header/navigation', 'collapsed');
            }
          } elseif($umetric_option['umetric_header_variation'] == '2') {
            if(isset($umetric_option['umetric_vertical_hedader_collapsed']) && $umetric_option['umetric_vertical_hedader_collapsed'] == "collapsed"){
                get_template_part('template-parts/header/navigation', 'collapsed');
            }
          }

      }

    if ($is_default_header) : ?>
        <div class="umetric-mobile-menu menu-style-one">
            <?php get_template_part('template-parts/header/navigation', 'mobile'); ?>
        </div>
    <?php endif; ?>
    <?php get_template_part('template-parts/breadcrumb/breadcrumb'); ?>