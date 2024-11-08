<?php

/**
 * Umetric\Utility\Dynamic_Style\Styles\Footer class
 *
 * @package umetric
 */

namespace Umetric\Utility\Dynamic_Style\Styles;

use Umetric\Utility\Dynamic_Style\Component;
use function add_action;

class Footer extends Component
{

	public function __construct()
	{
		add_action('wp_enqueue_scripts', array($this, 'umetric_footer_dynamic_style'), 20);
		add_action('wp_enqueue_scripts',  array($this, 'umetric_footer_copyright'), 20);
		add_action('wp_enqueue_scripts', array($this, 'umetric_footer_top_background_color'), 20);
		add_action('wp_enqueue_scripts', array($this, 'umetric_footer_color'), 20);

	}

	public function is_umetric_footer()
	{
		$is_footer = true;
		$page_id = get_queried_object_id();
		$footer_page_option = get_post_meta($page_id, "display_footer", true);
		$footer_page_option = !empty($footer_page_option) ? $footer_page_option : "default";
		$umetric_option = get_option('umetric_options');

		if ($footer_page_option != 'default') {
			$is_footer = ($footer_page_option == 'no') ? false : true;
		} else if(isset($umetric_option['umetric_footer_display']) && $umetric_option['umetric_footer_display'] == 'no') {
			$is_footer = false;
		}
		if (is_404() && !$umetric_option['footer_on_404']) {
			$is_footer = false;
		}
		return $is_footer;
	}

	public function umetric_footer_color()
	{
		if (!$this->is_umetric_footer()) {
			return;
		}

		//Set Footer Background Color
		$umetric_option = get_option('umetric_options');

		if (isset($umetric_option['footer_option']) && ($umetric_option['footer_option'] == "2") ) {
			$f_color = $umetric_option['footer_color']['rgba'];
			if( $umetric_option['footer_text_link_color'] == "2"){
			$footer_heading_color = $umetric_option['footer_heading_color'];
			$footer_text_color = $umetric_option['footer_text_color'];
			$footer_link_color = $umetric_option['footer_link_color'];
			}
		}
		$footer_color = "";

		if (isset($umetric_option['footer_option']) &&  $umetric_option['footer_option'] == "2") {
			if (!empty($f_color)) {
				$footer_color .= "
					footer {
						background : $f_color !important;
					}";
			}
			if (!empty($footer_heading_color)) {
				$footer_color .= "
				footer .footer-top .footer-title,footer .testimonail-widget-menu .owl-carousel .owl-item .testimonial-info .testimonial-name h5,footer .testimonail-widget-menu .owl-carousel .owl-item .testimonial-info .testimonial-name .sub-title,footer .footer-top .text-white {
					color : $footer_heading_color !important;
				}";
			}
			if (!empty($footer_text_color)) {
				$footer_color .= "
				footer,footer .widget ul li a, footer.footer-one .info-share li a, footer.footer-one ul.iq-contact li i, footer .testimonail-widget-menu .owl-carousel .owl-item .testimonial-info p {
					color : $footer_text_color !important;
				}";
			}
			if (!empty($footer_link_color)) {
				$footer_color .= "
				footer,footer .widget ul li a, footer.footer-one .info-share li a, footer.footer-one ul.iq-contact li i, footer .testimonail-widget-menu .owl-carousel .owl-item .testimonial-info p {
					color : $footer_link_color !important;
				}";
			}

			
		}
		wp_add_inline_style('umetric-global', $footer_color);
	}


	//Set footer Top background Color 
	public function umetric_footer_top_background_color()
	{
		if (!$this->is_umetric_footer()) {
			return;
		}

		$umetric_option = get_option('umetric_options');
		$footer_top_background_color = "";
		
		if (!empty($acf_footer_dark_color)) {
			$footer_top_background_color .= "
				footer .footer-topbar {
					background : $acf_footer_dark_color !important;
				}";
		} elseif (isset($umetric_option['umetric_footer_top_background']) ) {
			if ($umetric_option['umetric_footer_top_background'] == 1) {
				if (!empty($umetric_option['umetric_footer_top_image']['url'])) {

					$bglayout = esc_url($umetric_option['umetric_footer_top_image']['url']);
				}
				if (!empty($bglayout)) {
					$footer_top_background_color .= "
					footer .footer-topbar .container  {
						background:url($bglayout) !important;
					}";
				}
			}
			if ($umetric_option['umetric_footer_top_background'] == 2) {
				$top_footer_color = $umetric_option['umetric_footer_top_color'];
				if (!empty($top_footer_color)) {
					$top_footer_color =  sanitize_hex_color($top_footer_color);
					$footer_top_background_color .= "
					footer .footer-topbar .container {
						background : $top_footer_color !important;
					}";
				}
			}
		}

		wp_add_inline_style('umetric-global', $footer_top_background_color);
	}

	public function umetric_footer_copyright()
	{
		if (!$this->is_umetric_footer()) {
			return;
		}

		//Set Footer Background Color
		$umetric_option = get_option('umetric_options');
		if (isset($umetric_option['footer_copy_color'])) {
			if ($umetric_option['footer_copy_color'] == "2") {
				$footer_copyright_color = $umetric_option['footer_copyright_color'];
			}
			$footer_copyright = "";
			if ($umetric_option['footer_copy_color'] == "2") {
				$footer_copyright .= "
				.copyright-footer .copyright {
					color : $footer_copyright_color !important;
				}";
			}
			wp_add_inline_style('umetric-global', $footer_copyright);
		}
    }

	public function umetric_footer_dynamic_style()
	{
		if (!$this->is_umetric_footer()) {
			return;
		}

		$page_id = get_queried_object_id();
		$umetric_options = get_option('umetric_options');
		$footer_css = '';

		if (function_exists('get_field') && get_field('acf_key_footer_switch', $page_id) != 'default') {
			if (get_field('acf_key_footer_switch') == 'no') {
				$footer_css = 'footer { 
					display : none !important;
				}';
			}
		} else if (isset($umetric_options['footer_top'])) {

			if ($umetric_options['footer_top'] == 'no') {
				$footer_css = '.footer-top { 
					display : none !important;
				}';
			}
		}
		
		if ( function_exists('get_field') && empty($footer_css) && ($umetric_options['footer_option'] == '2')) {

			$f_color = '';

			if(($umetric_options['footer_type']  == '1') && !empty($umetric_options['footer_color']['rgba'])){
				
				$f_color = $umetric_options['footer_color']['rgba'];
			}

			if ( !empty($f_color) ) {
				$footer_css .= ".footer {
						background-color: $f_color !important;
				}";
			}
			if (!empty($umetric_options['footer_image']['url']) && ($umetric_options['footer_type']  == '2') ) {
		
				$footer_bg_image = $umetric_options['footer_image'];
				$footer_css .= ".footer {
						background: url(" . $footer_bg_image['url'] . ") no-repeat !important;
						backgrouns-size: cover !important ;
				}";
			}
		}
		
		if (!empty($footer_css)) {
			wp_add_inline_style('umetric-global', $footer_css);
		}
	}
	
}
