<?php

/**
 * Umetric\Utility\Dynamic_Style\Styles\HeaderSticky class
 *
 * @package umetric
 */

namespace Umetric\Utility\Dynamic_Style\Styles;

use Umetric\Utility\Dynamic_Style\Component;
use function add_action;

class HeaderSticky extends Component
{
	public function __construct()
	{
		add_action('wp_enqueue_scripts', array($this, 'umetric_header_sticky_background_style'), 20);
		add_action('wp_enqueue_scripts', array($this, 'umetric_sticky_sub_menu_color_options'), 20);
		add_action('wp_enqueue_scripts', array($this, 'umetric_sticky_menu_color_options'), 20);
	}

	public function umetric_header_sticky_background_style()
	{
		$umetric_option = get_option('umetric_options');
		$inline_css = '';
		$id = get_queried_object_id();
		if (function_exists('get_field') && get_field('display_header', $id) !== 'default' && get_field('header_sitcky_color_type', $id) !== 'default') {
			if (!empty(get_field('header_sticky_bg', $id))) {
				$inline_css .= '.has-sticky.header-up,.has-sticky.header-down{
						background : ' . get_field('header_sticky_bg', $id) . '!important;
					}';
			}
		} else if (isset($umetric_option['display_sticky_header']) && $umetric_option['display_sticky_header'] === 'yes') {
			if (isset($umetric_option['sticky_header_bg']) && $umetric_option['sticky_header_bg'] != 'default') {
				$type = $umetric_option['sticky_header_bg'];
				if ($type == 'color') {
					if (!empty($umetric_option['sticky_header_bg_color'])) {
						$inline_css .= '.has-sticky.header-up,.has-sticky.header-down{
							background : ' . $umetric_option['sticky_header_bg_color'] . '!important;
						}';
					}
				}
				if ($type == 'image') {
					if (!empty($umetric_option['sticky_header_bg_img']['url'])) {
						$inline_css .= '.has-sticky.header-up,.has-sticky.header-down{
							background : url(' . $umetric_option['sticky_header_bg_img']['url'] . ') !important;
						}';
					}
				}
				if ($type == 'transparent') {
					$inline_css .= '.has-sticky.header-up,.has-sticky.header-down{
						background : transparent !important;
					}';
				}
			}
		}
		if (!empty($inline_css)) {
			wp_add_inline_style('umetric-global', $inline_css);
		}
	}

	public function umetric_sticky_menu_color_options()
	{
		$umetric_option = get_option('umetric_options');
		$inline_css = '';
		if (isset($umetric_option['sticky_menu_color_type']) && $umetric_option['sticky_menu_color_type'] == 'custom') {
			if (isset($umetric_option['sticky_menu_color']) && !empty($umetric_option['sticky_menu_color'])) {
				$inline_css .= '.has-sticky.header-down .sf-menu > li > a, .has-sticky.header-up .sf-menu > li > a{
						color : ' . $umetric_option['sticky_menu_color'] . '!important;
					}';
			}

			if (isset($umetric_option['sticky_menu_hover_color']) && !empty($umetric_option['sticky_menu_hover_color'])) {
				$inline_css .= '.has-sticky.header-down .sf-menu li:hover > a,.has-sticky.header-down .sf-menu li.current-menu-ancestor > a,.has-sticky.header-down .sf-menu  li.current-menu-item > a, .has-sticky.header-up .sf-menu li:hover > a,.has-sticky.header-up .sf-menu li.current-menu-ancestor > a,.has-sticky.header-up .sf-menu  li.current-menu-item > a{
						color : ' . $umetric_option['sticky_menu_hover_color'] . '!important;
					}';
			}
		}
		if (!empty($inline_css)) {
			wp_add_inline_style('umetric-global', $inline_css);
		}
	}

	public function umetric_sticky_sub_menu_color_options()
	{
		$umetric_option = get_option('umetric_options');
		$inline_css = '';

		if (isset($umetric_option['sticky_header_submenu_color_type']) && $umetric_option['sticky_header_submenu_color_type'] == 'custom') {
			if (isset($umetric_option['sticky_umetric_header_submenu_color']) && !empty($umetric_option['sticky_umetric_header_submenu_color'])) {
				$inline_css .= '.has-sticky.header-down .sf-menu ul.sub-menu a, .has-sticky.header-up .sf-menu ul.sub-menu a{
                color : ' . $umetric_option['sticky_umetric_header_submenu_color'] . ' !important;
            }';
			}

			if (isset($umetric_option['sticky_umetric_header_submenu_hover_color']) && !empty($umetric_option['sticky_umetric_header_submenu_hover_color'])) {
				$inline_css .= '.has-sticky.header-down .sf-menu li.sfHover>a,.has-sticky.header-down .sf-menu li:hover>a,.has-sticky.header-down .sf-menu li.current-menu-ancestor>a,.has-sticky.header-down .sf-menu li.current-menu-item>a,.has-sticky.header-down .sf-menu ul>li.menu-item.current-menu-parent>a,.has-sticky.header-down .sf-menu ul li.current-menu-parent>a,.has-sticky.header-down .sf-menu ul li .sub-menu li.current-menu-item>a,
				.has-sticky.header-up .sf-menu li.sfHover>a,.has-sticky.header-up .sf-menu li:hover>a,.has-sticky.header-up .sf-menu li.current-menu-ancestor>a,.has-sticky.header-up .sf-menu li.current-menu-item>a,.has-sticky.header-up .sf-menu ul>li.menu-item.current-menu-parent>a,.has-sticky.header-up .sf-menu ul li.current-menu-parent>a,.has-sticky.header-up .sf-menu ul li .sub-menu li.current-menu-item>a{
                color : ' . $umetric_option['sticky_umetric_header_submenu_hover_color'] . ' !important;
            }';
			}

			if (isset($umetric_option['sticky_umetric_header_submenu_background_color']) && !empty($umetric_option['sticky_umetric_header_submenu_background_color'])) {
				$inline_css .= '.has-sticky.header-up .sf-menu ul.sub-menu li, .has-sticky.header-down .sf-menu ul.sub-menu li {
                background : ' . $umetric_option['sticky_umetric_header_submenu_background_color'] . ' !important;
            }';
			}

			if (isset($umetric_option['sticky_header_submenu_background_hover_color']) && !empty($umetric_option['sticky_header_submenu_background_hover_color'])) {
				$inline_css .= '.has-sticky.header-up .sf-menu ul.sub-menu li:hover,.has-sticky.header-up .sf-menu ul.sub-menu li.current-menu-item ,.has-sticky.header-up .sf-menu ul.sub-menu li:hover,.has-sticky.header-up .sf-menu ul.sub-menu li.current-menu-item,
				.has-sticky.header-down .sf-menu ul.sub-menu li:hover,.has-sticky.header-down .sf-menu ul.sub-menu li.current-menu-item ,.has-sticky.header-down .sf-menu ul.sub-menu li:hover,.has-sticky.header-down .sf-menu ul.sub-menu li.current-menu-item{
                background : ' . $umetric_option['sticky_header_submenu_background_hover_color'] . ' !important;
            }';
			}
		}
		if (!empty($inline_css)) {
			wp_add_inline_style('umetric-global', $inline_css);
		}
	}
}
