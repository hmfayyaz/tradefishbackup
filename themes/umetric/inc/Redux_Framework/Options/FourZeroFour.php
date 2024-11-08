<?php

/**
 * Umetric\Utility\Redux_Framework\Options\FourZeroFour class
 *
 * @package umetric
 */

namespace Umetric\Utility\Redux_Framework\Options;

use Redux;
use Umetric\Utility\Redux_Framework\Component;

class FourZeroFour extends Component
{

	public function __construct()
	{
		$this->set_widget_option();
	}

	protected function set_widget_option()
	{
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('404', 'umetric'),
			'id'    => 'fourzerofour',
			'icon'  => 'el-icon-error',
			'desc'  => esc_html__('This section contains options for 404.', 'umetric'),
			'fields' => array(

				array(
					'id' 		=> 'four_zero_four_layout',
					'type' 		=> 'button_set',
					'title' 	=> esc_html__('Page Layout', 'umetric'),
					'options' 	=> array(
						'default' 	=> esc_html__('Default', 'umetric'),
						'custom' 	=> esc_html__('Custom', 'umetric'),
					),
					'default'	=> 'default'
				),

				array(
					'id'        => '404_layout',
					'type'      => 'select',
					'title' 	=> esc_html__('404 Layout', 'umetric'),
					'subtitle' 	=> esc_html__('Select the layout variation that you want to use for 404 page.', 'umetric'),
					'options'	=> (function_exists('iqonic_addons_get_list_layouts')) ? iqonic_addons_get_list_layouts(false, 'four_zero_four') : '',
					'description'	=> (function_exists('iqonic_addons_get_list_layouts')) ? esc_html__("Create", 'umetric') . " <a target='_blank' href='" . admin_url('edit.php?post_type=iqonic_hf_layout') . "'>" . esc_html__("New Layout", 'umetric') . "</a>" : "",
					'required' 	=> array('four_zero_four_layout', '=', 'custom'),
				),
				

				array(
					'id'       	=> '404_banner_image',
					'type'     	=> 'media',
					'url'      	=> true,
					'title'    	=> esc_html__('404 Page Default Banner Image', 'umetric'),
					'read-only' => false,
					'default'  	=> array('url' => get_template_directory_uri() . '/assets/images/redux/404.png'),
					'subtitle' 	=> esc_html__('Upload banner image for your Website. Otherwise blank field will be displayed in place of this section.', 'umetric'),
					'required' 	=> array('four_zero_four_layout', '=', 'default'),
				),

				array(
					'id'        => '404_title',
					'type'      => 'text',
					'title'     => esc_html__('404 Page Title', 'umetric'),
					'default'   => esc_html__('Oops! This Page is Not Found.', 'umetric'),
					'required' 	=> array('four_zero_four_layout', '=', 'default'),
				),

				array(
					'id'        => '404_description',
					'type'      => 'textarea',
					'title'     => esc_html__('404 Page Description', 'umetric'),
					'default'   => esc_html__('The requested page does not exist.', 'umetric'),
					'required' 	=> array('four_zero_four_layout', '=', 'default'),
				),

				array(
					'id'        => '404_backtohome_title',
					'type'      => 'text',
					'title'     => esc_html__('404 Page Button', 'umetric'),
					'default'   => esc_html__('Back to Home', 'umetric'),
					'required' 	=> array('four_zero_four_layout', '=', 'default'),
				),
				array(
					'id'       	=> 'header_on_404',
					'type'     	=> 'switch',
					'on'		=> __('Enable', 'umetric'),
					'off'		=> __('Disable', 'umetric'),
					'title'    	=> __('Header', 'umetric'),
					'subtitle' 	=> __('Enable / disable header on 404 page', 'umetric'),
					'default'  	=> true,
				),

				array(
					'id'       	=> 'footer_on_404',
					'type'     	=> 'switch',
					'on'		=> __('Enable', 'umetric'),
					'off'		=> __('Disable', 'umetric'),
					'title'    	=> __('Footer', 'umetric'),
					'subtitle' 	=> __('Enable / disable footer on 404 page', 'umetric'),
					'default'  	=> true,
				)
			)
		));
	}
}
