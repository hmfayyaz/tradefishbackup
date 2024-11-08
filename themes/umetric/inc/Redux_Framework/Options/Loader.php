<?php
/**
 * Umetric\Utility\Redux_Framework\Options\Loader class
 *
 * @package umetric
 */

namespace Umetric\Utility\Redux_Framework\Options;
use Redux;
use Umetric\Utility\Redux_Framework\Component;

class Loader extends Component {

	public function __construct() {
		$this->set_widget_option();
	}

	protected function set_widget_option() {
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Loader', 'umetric'),
			'id' => 'loader',
			'icon' => 'el el-refresh',
			'fields' => array(

				array(
					'id' => 'info_general_favicon'.rand(10,1000),
					'type' => 'info',
					'style' => 'custom',
					'title' => __('Loader Options', 'umetric') ,
				) ,
				array(
					'id' => 'section-general-favicon'.rand(10,1000),
					'type' => 'section',
					'indent' => true
				) ,
		
				array(
					'id' => 'umetric_loader_switch',
					'type' => 'button_set',
					'title' => __('', 'umetric') ,
					'subtitle' => __('', 'umetric') ,
					'desc' => __('', 'umetric') ,
					'options' => array(
						'0' => esc_html__('none','umetric'),
						'1' => esc_html__('Image','umetric'),
						'2' => esc_html__('text', 'umetric'),
						
					) ,
					'default' => esc_html__('1','umetric')
					
				) ,
		
		
				array(
					'id' => 'umetric_background_loader',
					'type' => 'media',
					'title'    => __('Upload Loader Image', 'umetric'),               
					'default' => array('url' => get_template_directory_uri() . '/assets/images/redux/loader.gif'),
					'desc' => 'upload gif image here',
					'url' => false,
					'read-only' => false,
					'required' => array(
						'umetric_loader_switch',
						'=',
						'1'
					) ,
				) ,   

					array(
					'id' => 'loader-dimensions',
					'type' => 'dimensions',
					'units' => array(
						'em',
						'px',
						'%'
					) , // You can specify a unit value. Possible: px, em, %
					'units_extended' => 'true', // Allow users to select any type of unit
					'title' => esc_html__('Loader (Width/Height) Option', 'umetric') ,
					'subtitle' => esc_html__('Allow your users to choose width, height, and/or unit.', 'umetric') ,
					'desc' => esc_html__('You can enable or disable any piece of this field. Width, Height, or Units.', 'umetric') ,
					'required' => array(
						'umetric_loader_switch',
						'=',
						'1'
					) ,
		
				) ,     
				array(
					'id'        => 'umetric_loader_text',
					'type'      => 'text',   
					'title'    => __('Enter Loader Text', 'umetric'),                      
					'default'   => esc_html__( 'Loading....','umetric' ),
					'desc' => esc_html__('Enter Text', 'umetric') ,
					'required' => array(
						'umetric_loader_switch',
						'=',
						'2'
					) ,
				),
				array(
					'id'       => 'umetric_loader_tag',
					'type'     => 'select',
					'title'    => __('Select Html Tag', 'umetric'),             
					'desc'     => __('Select Tag For Loader Text.', 'umetric'),
					'options'  => array(
						'h1' => esc_html__('h1', 'umetric'),
						'h2' => esc_html__('h2', 'umetric'),
						'h3' => esc_html__('h3', 'umetric'),
						'h4' => esc_html__('h4', 'umetric'),
						'h5' => esc_html__('h5', 'umetric'),
						'h6' => esc_html__('h6', 'umetric'),
						
					),
					'required' => array(
						'umetric_loader_switch',
						'=',
						'2'
					) ,
					'default' => esc_html__('h2', 'umetric'),
				),
				array(
					'id' => 'umetric_loader_back_color_text',
					'type' => 'color', 
					'title'    => __('Choose Color Loader Text', 'umetric'),                                 
					'desc' => esc_html__('Choose Color For Loader Text .', 'umetric') ,
					'default' => '#ffffff',
					'mode' => 'background',            
					'transparent' => false,
					'required' => array(
						'umetric_loader_switch',
						'=',
						'2'
					) ,
				) ,
				array(
					'id' => 'umetric_loader_back_color',
					'type' => 'color',   
					'title'    => __('Background Color', 'umetric'),                        
					'desc' => esc_html__('Choose Background Color For  Loader.', 'umetric') ,
					'default' => '#ffffff',
					'mode' => 'background-color',            
					'transparent' => false,
					'required' => array(
						'umetric_loader_switch',
						'!=',
						'0'
					) ,	
					
					
				) ,
			)
		));
	}
}
