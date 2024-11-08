<?php

/**
 * Umetric\Utility\Dynamic_Style\Styles\Banner class
 *
 * @package umetric
 */

namespace Umetric\Utility\Dynamic_Style\Styles;

use Umetric\Utility\Dynamic_Style\Component;
use function add_action;

class Banner extends Component
{

    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'umetric_banner_dynamic_style'), 20);
        add_action('wp_enqueue_scripts', array($this, 'umetric_featured_hide'), 20);
    }

    public function umetric_banner_dynamic_style()
    {
        $page_id = get_queried_object_id();
        $umetric_options = get_option('umetric_options');
        $dynamic_css = '';

        if( function_exists('get_field') && get_field('field_QnF1') != 'default')  
        {
            $key_body_back = get_field('field_QnF1');
            if($key_body_back == 'no'){
                 $dynamic_css .=
                        '.iq-breadcrumb-one { display: none !important; }
                        .content-area .site-main {padding : 0 !important; }';
            }
        }  else if ($umetric_options['display_banner'] == 'no') {
            $dynamic_css .=
                '.iq-breadcrumb-one { display: none !important; }
                .content-area .site-main {padding : 0 !important; }';
        }

        if (isset($key_body_back) && $key_body_back != 'default') {
           
           
            $key_bg_option = get_field('key_pjros');
            
            if (isset($key_bg_option['display_title']) && $key_bg_option['display_title'] != 'yes') {
                if (  $key_bg_option['display_title'] == 'no') {
                    $dynamic_css .= '.iq-breadcrumb-one .title { display: none !important; }';
                }
                if (  $key_bg_option['display_breadcumb'] == 'no') {
                    $dynamic_css .= '.iq-breadcrumb-one .breadcrumb { display: none !important; }';
                }
				
            }
                $key_background = get_field('key_banner_back');

                if($key_background['banner_background_type'] != 'default'){

                     if ( $key_background['banner_background_type'] == 'color') {
                        
                        if (isset($key_background['banner_background_color']) && !empty($key_background['banner_background_color'])) {
                              
                                $dynamic_css .= '.iq-breadcrumb-one { background-color: ' .$key_background['banner_background_color'] . ' !important; }' ;
                        }
                    
                        
                    } elseif ( $key_background['banner_background_type'] == 'image') {

                        if (isset($key_background['banner_background_image']) && !empty($key_background['banner_background_image'])) {
                            $dynamic_css .= '.iq-breadcrumb-one {background-image : url(' . $key_background['banner_background_image']['url'] . ') !important; }';
                        }

                        if(isset($key_background['banner_background_size']) && !empty($key_background['banner_background_size'])) {
                            $dynamic_css .= '.iq-breadcrumb-one {background-size : ' . $key_background['banner_background_size'].' !important; }';
                        }

                        if(isset($key_background['banner_background_repeat']) && !empty($key_background['banner_background_repeat'])) {
                            $dynamic_css .= '.iq-breadcrumb-one {background-repeat : ' . $key_background['banner_background_repeat'].' !important; }';
                        }
                        
                    }

                }

            }
            
        


        $key = (function_exists('get_field')) ? get_field('field_display_breadcrumb', $page_id) : "";
        if (isset($key['display_title']) && $key['display_title'] != 'default'  && $key['display_title'] == 'no') {
            $dynamic_css .= '.iq-breadcrumb-one .title { display: none !important; }';
        } else if (isset($umetric_options['display_title'])) {

            if ($umetric_options['display_title'] == 'no') {
                $dynamic_css .= '.iq-breadcrumb-one .title { display: none !important; }';
            }
        }

        if (isset($key['display_breadcumb']) && $key['display_breadcumb'] != 'default'  && $key['display_breadcumb'] == 'no') {
            $dynamic_css .= '.iq-breadcrumb-one .breadcrumb { display: none !important; }';
        } else if (isset($umetric_options['display_breadcumb'])) {
            if ($umetric_options['display_breadcumb'] == 'no') {
                $dynamic_css .= '.iq-breadcrumb-one .breadcrumb { display: none !important; }';
            }
        }

        if (isset($umetric_options['breadcrumbs_color'])) {
            $dynamic = $umetric_options['breadcrumbs_color'];
            $dynamic_css .= !empty($dynamic) ? '  .iq-breadcrumb-one ol li a, .iq-breadcrumb-one .breadcrumb-item.active, .iq-breadcrumb-one .breadcrumb-item + .breadcrumb-item::before{ color: ' . $dynamic . ' !important; }' : '';
        }

        if (isset($umetric_options['breadcrumbs_hover_color'])) {

            $dynamic = $umetric_options['breadcrumbs_hover_color'];
            $dynamic_css .= !empty($dynamic) ? '.iq-breadcrumb-one ol li a:hover, .iq-breadcrumb-one .breadcrumb-item.active { color: ' . $dynamic . ' !important; }' : '';

        }

        if (isset($umetric_options['bg_title_color'])) {

            $dynamic = $umetric_options['bg_title_color'];

            $dynamic_css .= !empty($dynamic) ? '.iq-breadcrumb-one h2 { color: ' . $dynamic . ' !important; }' : '';

        }

        if (isset($umetric_options['bg_opacity'])) {
            if ($umetric_options['bg_opacity'] == "3") {
                $bg_opacity = $umetric_options['opacity_color']['rgba'];
            }
            if ($umetric_options['bg_opacity'] == "3") {
                if (!empty($bg_opacity) && $bg_opacity != '#ffffff') {
                    $dynamic_css .= "
                    .breadcrumb-video::before,
                    .breadcrumb-bg::before, 
                    .breadcrumb-ui::before,
                    .iq-breadcrumb-one::before {
                        background : $bg_opacity !important;
                        position: absolute;  
                        left: 0;
                        right: 0; 
                        content: ''; 
                        width: 100%; 
                        height: 100%; 
                        top: 0;
                    }";
                }
            }
        }

        if (isset($umetric_options['bg_type'])) {
            $opt = $umetric_options['bg_type'];
            if ($opt == '1') {
                if (isset($umetric_options['bg_color']) && !empty($umetric_options['bg_color'])) {
                    $dynamic = $umetric_options['bg_color'];
                    $dynamic_css .= !empty($dynamic) ? '.iq-breadcrumb-one { background: ' . $dynamic . ' !important; }' : '';
                    
                }
            }
            if ($opt == '2') {
                if (isset($umetric_options['banner_image']['url'])) {
                    $dynamic = $umetric_options['banner_image']['url'];
                    $dynamic_css .= !empty($dynamic) ? '.iq-breadcrumb-one { background-image: url(' . $dynamic . ') !important; }' : '';
                }
            }
        }
        if (!empty($dynamic_css)) {
            wp_add_inline_style('umetric-global', $dynamic_css);
        }
    }
     /* hide featured image for post formate */
     public function umetric_featured_hide()
     {
         /*
         * Get Post Formate and set featured image display none
         */
         $umetric_options = get_option('umetric_options');
         $featured_hide = '';
         $post_format="";
 
         if(isset($umetric_options['posts_select'])){
 
             $posts_format = $umetric_options['posts_select'];
             $post_format = get_post_format();
 
             if(in_array(get_post_format(),$posts_format)){
                 $featured_hide .= '.format-'.$post_format.' .umetric-blog-box .umetric-blog-image { display: none !important; }';
             }
             wp_add_inline_style('umetric-global', $featured_hide);
 
         }
     }
}
