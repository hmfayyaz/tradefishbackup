<?php

/**
 * Umetric\Utility\Redux_Framework\Options\General class
 *
 * @package umetric
 */

namespace Umetric\Utility\Redux_Framework\Options;

use Redux;
use Umetric\Utility\Redux_Framework\Component;

class General extends Component
{

	public function __construct()
	{
		$this->set_widget_option();
	}

	protected function set_widget_option()
	{
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('General', 'umetric'),
			'id' => 'general',
			'icon' => 'el el-dashboard',
			'customizer_width' => '500px',
		));

		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Body Layout', 'umetric') ,
			'id' => 'site-global',
			
			'subsection' => true,
			'fields' => array(
				array(
					'id' => 'info_general',
					'type' => 'info',
					'style' => 'custom',            
					'title' => __('Layout Options', 'umetric') ,
					'desc' => __('This Section Contain Option For Your Site Layout.','umetric'),
				) ,
		
				array(
					'id' => 'section-general',
					'type' => 'section',            
					'indent' => true
				) ,
		
				array(
					'id' => 'umetric_site_layout_genaral',
					'type' => 'image_select',
					'default' => 2,
					'desc' => __('<p>Choose From Above Suitable Option For Your Site.</p>','umetric'),
					'options' => array(
						'1' => array(
							'title' => esc_html__('Boxed', 'umetric') ,
							'img' => get_template_directory_uri() . '/assets/images/redux/boxed.png',
						) ,
						'2' => array(
							'title' => esc_html__('Full Width', 'umetric') ,
							'img' => get_template_directory_uri() . '/assets/images/redux/full-width.png',
						) ,
		
					) ,
				   
		
				) ,
				array(
					'id' => 'info_general' . rand(0, 1000) ,
					'type' => 'info',
					'style' => 'custom',
					'desc' => __('This Section Contain Option For Your Grid Container Width.','umetric'),
					'title' => __('Grid Container Width', 'umetric') ,
				) ,

				array(
					'id' => 'opt-slider-label',
					'type' => 'slider',
					'desc' => __('<p>Adjust Your Site Container Width Wtih Help Of Above Opiton.</p>','umetric'),            
					'min' => 960,
					'step' => 1,
					'max' => 1920,
					'display_value' => 'select',
					'default' => 1200
				),
				
				array(
					'id' => 'info_general_background',
					'type' => 'info',
					'style' => 'custom',
					'desc' => __('<p>This Section Contain Optin For Your Page Body Background.</p>','umetric'),
					'title' => __('Body Background', 'umetric') ,
				) ,
		
				array(
					'id' => 'section-general-background',
					'type' => 'section',
					'indent' => true
				) ,
		
				array(
					'id' => 'umetric_background_genaral',
					'type' => 'button_set',                        
					'desc' => __('Select Your Page Background Style', 'umetric') ,            
					'options' => array(
						'1' => 'Image',
						'2' => 'Color',
						'3' => 'none'
					) ,
					'default' => '3'
				) ,
		
				array(
					'id' => 'umetric_background_image',
					'type' => 'media',
					'url' => true,
					'title' => esc_html__('upload image', 'umetric') ,
					'read-only' => true,
					'required' => array(
						'umetric_background_genaral',
						'=',
						'1'
					) ,
					
				) ,
		
				array(
					'id' => 'umetric_background_color',
					'type' => 'color',
					'title' => esc_html__('Set Background Color', 'umetric') ,
					
					'default' => '#ffffff',
					'mode' => 'background',
					'required' => array(
						'umetric_background_genaral',
						'=',
						'2'
					) ,
					'transparent' => false
				) ,
		
			   
		
				
		
			)
		));
		//Favicon Option
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Favicon', 'umetric') ,
			'id' => 'site-favicon',
			
			'subsection' => true,
			'fields' => array(
				array(
					'id' => 'info_general_favicon',
					'type' => 'info',
					'style' => 'custom',
					'title' => __('Favicon', 'umetric') ,
					'desc' => __('Upload .ico File For Favicon Icon', 'umetric')
				) ,
				array(
					'id' => 'section-general-favicon',
					'type' => 'section',
					'indent' => true
				) ,
		
				array(
					'id' => 'umetric_background_favicon',
					'type' => 'media',            
					'url' => true,
					'read-only' => false,
					
		
				) ,
			)
		));
		
		// Back To Top Options
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Back To Top', 'umetric') ,
			'id' => 'site-back-to-top',
			
			'subsection' => true,
			'fields' => array(
				array(
					'id' => 'info_'. rand(10,100),
					'type' => 'info',
					'style' => 'custom',
					'title' => __('Back To Top Options', 'umetric') ,
				) ,
				array(
					'id' => 'section-sticky-header-logo',
					'type' => 'section',
					'indent' => true
				) ,
		
				array(
					'id'       => 'umetric_back_to_top',
					'type'     => 'button_set',
					'options'  => array(
						'yes' => 'Yes',
						'no' => 'No'
					),
					'default'  => 'yes'
				),
		
			   
			)
		));
		
		
		
	}
}
