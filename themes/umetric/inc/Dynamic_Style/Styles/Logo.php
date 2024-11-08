<?php

/**
 * Umetric\Utility\Dynamic_Style\Styles\Logo class
 *
 * @package umetric
 */

namespace Umetric\Utility\Dynamic_Style\Styles;

use Umetric\Utility\Dynamic_Style\Component;
use function add_action;

class Logo extends Component
{

    public function __construct(){
        add_action('wp_enqueue_scripts', array($this, 'umetric_logo_options'), 20);
    }

    public function umetric_logo_options(){

        $umetric_options = get_option('umetric_options');
        $logo_var = "";
        
        if ($umetric_options['umetric_logo_type'] == 1) {
            if (!empty($umetric_options['header_color'])) {
                $logo = $umetric_options['header_color'];
                $logo_var = ".navbar-light .navbar-brand {
                    color : $logo !important;
                }";
            }
        }

        if (!empty($umetric_options["logo-dimensions"]["width"]) && $umetric_options["logo-dimensions"]["width"] != "px") {
            $logo_width = $umetric_options["logo-dimensions"]["width"];
            $logo_var .= 'header.site-header a.navbar-brand img, .vertical-navbar-brand img { width: ' . $logo_width . ' !important; }';
        }

        if (!empty($umetric_options["logo-dimensions"]["height"]) && $umetric_options["logo-dimensions"]["height"] != "px") {
            $logo_height = $umetric_options["logo-dimensions"]["height"];
            $logo_var .= 'header.site-header a.navbar-brand img, .vertical-navbar-brand img { height: ' . $logo_height . ' !important; }';
        }
        if (!empty($logo_var)) {
            wp_add_inline_style('umetric-global', $logo_var);
        }
    }

    // ACF Normal Logo
    function iq_get_acf_logo($logo = ''){

        $page_id = get_queried_object_id();
        $key = get_field('header_layout');
        $iq_logo_img = $key['header_as_logo']['url'];
        $iq_logo_text = $key['logo_as_text'];
        $iq_logo_tag = $key['logo_text_tag'];
        $iq_logo_color = $key['logo_color_text'];
    
        if($logo == '1'){ ?>

            <img class="img-fluid logo" src="<?php echo esc_url($iq_logo_img); ?>" alt="<?php  esc_attr_e( 'umetric', 'umetric' ); ?>"> <?php

        } elseif($logo == '2'){
            $style = '';
            if(!empty($iq_logo_color)) {
                $style = 'style=color:'.sanitize_hex_color($iq_logo_color).'';
            }
            if(!empty($iq_logo_text)) {
                echo '<'.esc_attr($iq_logo_tag).' class="logo" '.esc_attr($style).'>'.esc_html($iq_logo_text).'</'.esc_attr($iq_logo_tag).'>'; 
            }			
        }

    }

    // ACF Normal Logo for vertical menu
    function iq_get_acf_ver_logo($logo = ''){

        $page_id = get_queried_object_id();
        $key = get_field('header_layout');
        $key_text = get_field('key_ver_header_text');

        $iq_ver_logo_img = $key['header_ver_as_logo']['url'];
        $iq_ver_logo_text = $key_text['ver_logo_as_text'];
        $iq_ver_logo_tag = $key_text['ver_logo_text_tag'];
        $iq_ver_logo_color = $key_text['ver_logo_color_text'];
    
        if($logo == '1'){ ?>

            <img class="img-fluid logo" src="<?php echo esc_url($iq_ver_logo_img); ?>" alt="<?php  esc_attr_e( 'umetric', 'umetric' ); ?>"> <?php

        } elseif($logo == '2'){
            $style = '';
            if(!empty($iq_ver_logo_color)) {
                $style = 'style=color:'.sanitize_hex_color($iq_ver_logo_color).'';
            }
            if(!empty($iq_ver_logo_text)) {
                echo '<'.esc_attr($iq_ver_logo_tag).' class="logo" '.esc_attr($style).'>'.esc_html($iq_ver_logo_text).'</'.esc_attr($iq_ver_logo_tag).'>'; 
            }			
        }

    }

    // ACF Sticky Logo
    function iq_get_acf_stick_logo($logo = ''){

        $page_id = get_queried_object_id();
        $key = get_field('header_stick_layout');
        $iq_logo_img = $key['header_stick_as_logo']['url'];
        $iq_logo_tag = $key['logo_stick_text_tag'];
        $iq_logo_text = $key['logo_stick_as_text'];
        $iq_logo_color = $key['logo_stick_color_text'];

        if($logo == '1') { ?>

            <img class="img-fluid logo-sticky" src="<?php echo esc_url($iq_logo_img); ?>" alt="<?php  esc_attr_e( 'umetric', 'umetric' ); ?>"> <?php

        } elseif($logo == '2') {

            if(!empty($iq_logo_color)){
                $style = 'style=color:'.sanitize_hex_color($iq_logo_color).'';
            }
            if(!empty($iq_logo_text)) {
                echo '<'.esc_attr($iq_logo_tag).' class="logo-sticky" '.esc_attr($style).'>'.esc_html($iq_logo_text).'</'.esc_attr($iq_logo_tag).'>'; 
            }
            
        }
    }

}
