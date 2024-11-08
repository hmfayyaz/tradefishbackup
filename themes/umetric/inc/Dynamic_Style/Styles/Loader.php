<?php

/**
 * Umetric\Utility\Dynamic_Style\Styles\Loader class
 *
 * @package umetric
 */

namespace Umetric\Utility\Dynamic_Style\Styles;

use Umetric\Utility\Dynamic_Style\Component;
use function add_action;

class Loader extends Component
{

    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'umetric_loader_options'), 20);
    }

    public function umetric_loader_options()
    {
        $umetric_options = get_option('umetric_options');
        $loader_var = "";
        $loader_css="";
        if (isset($umetric_options['loader_bg_color'])) {
            $loader_var = $umetric_options['loader_bg_color'];
            if (!empty($loader_var)) {
                $loader_css = "
                    #loading {
                        background : $loader_var !important;
                    }";
            }
        }
        if (!empty($umetric_options["loader-dimensions"]["width"]) && $umetric_options["loader-dimensions"]["width"] != "px") {
            $loader_width = $umetric_options["loader-dimensions"]["width"];
            $loader_css .= '#loading img { width: ' . $loader_width . ' !important; }';
        }

        if (!empty($umetric_options["loader-dimensions"]["height"]) && $umetric_options["loader-dimensions"]["height"] != "px") {
            $loader_height = $umetric_options["loader-dimensions"]["height"];
            $loader_css .= '#loading img { height: ' . $loader_height . ' !important; }';
        }
        if (!empty($loader_css)) {
            wp_add_inline_style('umetric-global', $loader_css);
        }
    }
}
