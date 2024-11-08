<?php

/**
 * Umetric\Utility\Dynamic_Style\Styles\General class
 *
 * @package umetric
 */

namespace Umetric\Utility\Dynamic_Style\Styles;

use Umetric\Utility\Dynamic_Style\Component;
use function add_action;

class General extends Component
{
	public function __construct()
	{

		add_action('wp_enqueue_scripts', array($this, 'umetric_create_general_style'), 20);
		add_action('wp_enqueue_scripts',array($this, 'umetric_umetric_loader_color') , 20);
		add_action('wp_enqueue_scripts', array($this, 'umetric_page_404'), 20);
	}
	//Set loader background Color 
	public function umetric_umetric_loader_color()
	{

		$umetric_option = get_option('umetric_options');
		if (isset($umetric_option['umetric_loader_back_color'])) {
			$umetric_loader_back_color = sanitize_hex_color($umetric_option['umetric_loader_back_color']);
			$body_loader_color = "";

			if (!empty($umetric_loader_back_color)) {
				$body_loader_color .= "
				#loading {
					background:$umetric_loader_back_color !important;
				}";
			}
			wp_add_inline_style('umetric-global', $body_loader_color);
		}
	}

	public function umetric_create_general_style()
	{

		$umetric_option = get_option('umetric_options');
		$general_var = '';

		if (isset($umetric_option['opt-slider-label']) && !empty($umetric_option['opt-slider-label'])) {
			$general = (int)$umetric_option['opt-slider-label'] / 16;
			$general_var .= ':root {  --content-width: ' . $general . 'em !important; }';
		}

		if ($umetric_option['umetric_back_to_top'] == 'no') {
			if (isset($umetric_option['umetric_back_to_top']) && !empty($umetric_option['umetric_back_to_top'])) {
				$general_var .= '#back-to-top { display: none !important; }';
			}
		}

		/* background */

		$key_body_back = '';
		if(function_exists('get_field')){
		    $key_body_back = get_field('key_body');
		}

		if (isset($key_body_back['body_variation']) && $key_body_back['body_variation'] != 'default') {
                $general_var = '';
					if (isset($key_body_back['acf_body_color']) && !empty($key_body_back['acf_body_color'])) {
					     $general_var = 'body { background-color: ' . $key_body_back['acf_body_color'] . ' !important; }';	
					}
					if (isset($key_body_back['acf_body_image']) && !empty($key_body_back['acf_body_image'])) {
						$general_var = 'body {background-image : url(' . $key_body_back['acf_body_image']['url'] . ') !important; }';
					}

		} else {


			if (isset($umetric_option['umetric_background_genaral']) && $umetric_option['umetric_background_genaral'] == 2) {
				if (isset($umetric_option['umetric_background_color'])  && !empty($umetric_option['umetric_background_color'])) {
					$general = $umetric_option['umetric_background_color'];
					$general_var .= 'body { background : ' . $general . ' !important; }';
				}
			}

			if (isset($umetric_option['umetric_background_genaral']) && $umetric_option['umetric_background_genaral'] == 1) {
				if (isset($umetric_option['umetric_background_image']['url']) && !empty($umetric_option['umetric_background_image']['url'])) {
					$general = $umetric_option['umetric_background_image']['url'];
					$general_var .= 'body { background-image: url(' . $general . ') !important; }';
				}
			}
		}

		
		
		if (!empty($general_var)) {
			wp_add_inline_style('umetric-global', $general_var);
		}
	}
		/* 404 Page Options */
		public function umetric_page_404()
		{
		
			if (is_404()) {
			
				$umetric_option = get_option('umetric_options');
			
				$header_footer_css = '';
	
				if (!$umetric_option['header_on_404']) {
					$header_footer_css .= 'header.default-header{ 
					display : none;
				}';
				}
				if (!$umetric_option['footer_on_404']) {
					$header_footer_css .= 'footer { 
					display : none;
				}';
				}
				if (!empty($header_footer_css)) {
					wp_add_inline_style('umetric-global', $header_footer_css);
				}
			}
		}
}





