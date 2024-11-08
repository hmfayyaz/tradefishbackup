<?php

/**
 * Umetric\Utility\Dynamic_Style\Styles\AdditionalCode class
 *
 * @package umetric
 */

namespace Umetric\Utility\Dynamic_Style\Styles;

use Umetric\Utility\Dynamic_Style\Component;
use function add_action;

class AdditionalCode extends Component
{

    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'umetric_inline_css'), 20);
        add_action('wp_enqueue_scripts', array($this, 'umetric_inline_js'), 20);
    }

    public function umetric_inline_css()
    {
        $umetric_options = get_option('umetric_options');
        $custom_style = "";

        if (!empty($umetric_options['css_code'])) {
            $umetric_css_code = $umetric_options['css_code'];
            $custom_style = $umetric_css_code;
            wp_add_inline_style('umetric-global', $custom_style);
        }
    }

    public function umetric_inline_js()
    {
        $umetric_option = get_option('umetric_options');
        $custom_js = "";

        if (!empty($umetric_option['js_code'])) {
            $umetric_js_code = $umetric_option['js_code'];

            $custom_js = $umetric_js_code;
            wp_register_script('umetric-custom-js', '', [], '', true);
            wp_enqueue_script('umetric-custom-js');
            wp_add_inline_script('umetric-custom-js', wp_specialchars_decode($custom_js));
        }
    }
}
