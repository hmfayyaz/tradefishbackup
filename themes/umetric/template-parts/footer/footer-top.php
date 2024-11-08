<?php

/**
 * Template part for displaying the top footer
 *
 * @package umetric
 */

namespace Umetric\Utility;
$topfooter = false;

if(function_exists('get_field') || class_exists('ReduxFramework')) {

    $id = get_queried_object_id();
    $acf_display_top_footer = !empty($id) ? get_post_meta($id, 'display_top_footer', true) : '';
  
    $umetric_options = get_option('umetric_options');

    if ($acf_display_top_footer != 'default') {
      
	   $topfooter = ($acf_display_top_footer == 'yes') ? true : false;
    } elseif (isset($umetric_options['umetric_footer_layout']) && $umetric_options['umetric_footer_layout'] == 'default' ) {
      
        if (isset($umetric_options['umetric_footer_top_display']) && $umetric_options['umetric_footer_top_display'] == 'yes') {
            $topfooter = true;
        }
    }    
}


if($topfooter)	{

    if( is_active_sidebar('footer_top_area') ) { ?>
        <div class="footer-topbar">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 ">
                        <?php dynamic_sidebar( 'footer_top_area' ); ?>
                    </div>
                </div>
            </div>
        </div> <?php
    }
}
?>
