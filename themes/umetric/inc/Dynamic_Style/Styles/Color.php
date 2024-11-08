<?php

/**
 * Umetric\Utility\Dynamic_Style\Styles\Banner class
 *
 * @package umetric
 */

namespace Umetric\Utility\Dynamic_Style\Styles;

use Umetric\Utility\Dynamic_Style\Component;
use function add_action;

class Color extends Component
{

	public function __construct()
	{
		add_action('wp_enqueue_scripts', array($this, 'umetric_color_options'), 20);
	}

	public function umetric_color_options()
	{

		$umetric_option = get_option('umetric_options');
		$color_var = "";
		$color = '';
		
		if (function_exists('get_field') && class_exists('ReduxFramework')) {
			if (isset(get_field('key_color_pallete')['primary_color']) && !empty(get_field('key_color_pallete')['primary_color']) && get_field('key_color_switch') === "yes") {
				$color = get_field('key_color_pallete')['primary_color'];
				if(!empty($color)){ $color_var .= '--primary-color: ' . $color . ' !important;'; }
			} else {
				if ($umetric_option['umetric_color'] == '2' && isset($umetric_option['primary_color']) && !empty($umetric_option['primary_color'])) {
					$color = $umetric_option['primary_color'];
					if(!empty($color)){ $color_var .= '--primary-color: ' . $color . ' !important;'; }
				}
			}
          
			if (isset(get_field('key_color_pallete')['secondary_color']) && !empty(get_field('key_color_pallete')['secondary_color']) && get_field('key_color_switch') === "yes") {
			
				$color = get_field('key_color_pallete')['secondary_color'];
				if(!empty($color)){ $color_var .= '--secondary-color: ' . $color . ' !important;'; }
			} else {
				if ($umetric_option['umetric_color'] == '2' && isset($umetric_option['secondary_color']) && !empty($umetric_option['secondary_color'])) {
					$color = $umetric_option['secondary_color'];
					if(!empty($color)){ $color_var .= '--secondary-color: ' . $color . ' !important;'; }
				}
			}

			if (isset(get_field('key_color_pallete')['title_color']) && !empty(get_field('key_color_pallete')['title_color']) && get_field('key_color_switch') === "yes") {
				$color = get_field('key_color_pallete')['title_color'];
				if(!empty($color)){ $color_var .= '--title-color: ' . $color . ' !important;'; }
			} else {
				if ($umetric_option['umetric_color'] == '2' && isset($umetric_option['theme_title_color']) && !empty($umetric_option['theme_title_color'])) {
					$color = $umetric_option['theme_title_color'];
					if(!empty($color)){ $color_var .= '--title-color: ' . $color . ' !important;'; }
				}
			}

			if (isset(get_field('key_color_pallete')['sub_title_color']) && !empty(get_field('key_color_pallete')['sub_title_color']) && get_field('key_color_switch') === "yes") {
				$color = get_field('key_color_pallete')['sub_title_color'];
				if(!empty($color)){ $color_var .= '--sub-title-color: ' . $color . ' !important;'; }
			} else {
				if ($umetric_option['umetric_color'] == '2' && isset($umetric_option['theme_subtitle_color']) && !empty($umetric_option['theme_subtitle_color'])) {
					$color = $umetric_option['theme_subtitle_color'];
					if(!empty($color)){ $color_var .= '--sub-title-color: ' . $color . ' !important;'; }
				}
			}
			
			if (!empty(get_field('key_color_pallete')['Body_text_color']) && !empty(get_field('key_color_pallete')['sub_title_color']) && get_field('key_color_switch') === "yes") {
				$color = get_field('key_color_pallete')['Body_text_color'];
				if(!empty($color)){ $color_var .= '--body-text: ' . $color . ' !important;'; }
			} else {
				if ($umetric_option['umetric_color'] == '2' && !empty($umetric_option['theme_body_color']) && !empty($umetric_option['theme_body_color'])) {
					$color = $umetric_option['theme_body_color'];
					if(!empty($color)){ $color_var .= '--body-text: ' . $color . ' !important;'; }
				}
			}


			if (!empty($color_var)) {
				$color_attrs = ':root { ' . $color_var . '}';
				wp_add_inline_style('umetric-global', $color_attrs);
			
			}

			
		}
	}
}
