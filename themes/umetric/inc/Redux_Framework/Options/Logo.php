<?php
/**
 * Umetric\Utility\Redux_Framework\Options\Logo class
 *
 * @package umetric
 */

namespace Umetric\Utility\Redux_Framework\Options;
use Redux;
use Umetric\Utility\Redux_Framework\Component;

class Logo extends Component {

	public function __construct() {
		$this->set_widget_option();
	}

	protected function set_widget_option() {
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Logo', 'umetric'),
			'id'    => 'header-logo',
			'icon'  => 'el el-flag',
			'fields' => array(

				array(
					'id' => 'umetric_logo_type',
					'type' => 'button_set',
					'title' => __('Header Logo Type', 'umetric') ,            
					'desc' => __('', 'umetric') ,
					'options' => array(
						'1' => esc_html__('Image','umetric'),
						'2' => esc_html__('text', 'umetric'),
						
					) ,
					'default' => esc_html__('1','umetric')
					
				) ,
		
				array(
					'id' => 'umetric_logo',
					'type' => 'media',
					'url' => true,
					'title' => esc_html__('Image', 'umetric') ,
					'read-only' => false,
					'indent' => true,
					'default'  => array('url' => get_template_directory_uri() . '/assets/images/logo.png'),
					'required' => array(
						'umetric_logo_type',
						'=',
						'1'
					) ,
					
				) ,
				array(
					'id' => 'logo-dimensions',
					'type' => 'dimensions',
					'units' => array(
						'em',
						'px',
						'%'
					) , // You can specify a unit value. Possible: px, em, %
					'units_extended' => 'true', // Allow users to select any type of unit
					'title' => esc_html__('Header Logo (Width/Height) Option', 'umetric') ,
					'subtitle' => esc_html__('Allow your users to choose width, height, and/or unit.', 'umetric') ,
					'desc' => esc_html__('You can enable or disable any piece of this field. Width, Height, or Units.', 'umetric') ,
					'required' => array(
						'umetric_logo_type',
						'=',
						'1'
					) ,
		
				) ,
		
				array(
					'id' => 'umetric_header_logo_text',
					'type' => 'text',
					'title' => esc_html__('Header Logo Text', 'umetric') ,
					'required' => array(
						'umetric_logo_type',
						'=',
						'2'
					) ,
		
				) ,
				 array(
					'id'       => 'umetric_header_logo_tag',
					'type'     => 'select',
					'title'    => __('Select Html Tag', 'umetric'),             
					'desc'     => __('Select Tag For Text.', 'umetric'),
					'options'  => array(
						'h1' => esc_html__('h1', 'umetric'),
						'h2' => esc_html__('h2', 'umetric'),
						'h3' => esc_html__('h3', 'umetric'),
						'h4' => esc_html__('h4', 'umetric'),
						'h5' => esc_html__('h5', 'umetric'),
						'h6' => esc_html__('h6', 'umetric'),
						
					),
					'required' => array(
						'umetric_logo_type',
						'=',
						'2'
					) ,
					'default' => esc_html__('2', 'umetric'),
				),
		
			   
		
				array(
					'id' => 'header_logo_color',
					'type' => 'color',
					'title' => esc_html__('Set Header Logo Color', 'umetric') ,
					'subtitle' => esc_html__('Choose Header Logo Color', 'umetric') ,
					'default' => '#ffffff',
					'mode' => 'background',
					'transparent' => false,
					'required' => array(
						'umetric_logo_type',
						'=',
						'2'
					) ,
				) ,
			  
		
				
			   //stricle Logo
			   array(
				'id'   => 'vertical_header_sticky_logo_info',
				'type' => 'info',
				'title' =>  esc_html__( 'Opps ! Not Available...','umetric').'</br>'.
							esc_html__( ' This options only available with standard menu type.','umetric').'</br>'.
							esc_html__('We will come back soon with this options in vertical menu.','umetric'),
				'style' => 'critical',
				'required'  => array( 'umetric_header_variation', '=', '2' ),
			),
	
		
	
			array(
				'id' => 'umetric_logo_sticky_type',
				'type' => 'button_set',
				'required'  => array( 'umetric_header_variation', '!=', '2' ),
				'title' => __('Stikcy Header Logo Type', 'umetric') ,
				'options' => array(
					'1' => esc_html__('Image','umetric'),
					'2' => esc_html__('text', 'umetric'),
					
				) ,
				'default' => esc_html__('1','umetric')
				
			) ,
	
			array(
				'id' => 'umetric_header_logo_sticky',
				'type' => 'media',
				'url' => false,
				'title' => esc_html__('Image', 'umetric') ,
				'read-only' => false,
				'required' => array(
					'umetric_logo_sticky_type',
					'=',
					'1'
				) ,
				'default'  => array('url' => get_template_directory_uri() . '/assets/images/logo.png'),
				'subtitle' => esc_html__('', 'umetric') ,
			) ,
			array(
				'id' => 'sticky-logo-dimensions',
				'type' => 'dimensions',
				'units' => array(
					'em',
					'px',
					'%'
				) , // You can specify a unit value. Possible: px, em, %
				'units_extended' => 'true', // Allow users to select any type of unit
				'title' => esc_html__('Stikcy Header Logo (Width/Height) Option', 'umetric') ,
				'subtitle' => esc_html__('Allow your users to choose width, height, and/or unit.', 'umetric') ,
				'desc' => esc_html__('You can enable or disable any piece of this field. Width, Height, or Units.', 'umetric') ,
				'required' => array(
					'umetric_logo_sticky_type',
					'=',
					'1'
				) ,
	
			) ,
	
			array(
				'id' => 'umetric_header_logo_sticky_text',
				'type' => 'text',
				'title' => esc_html__('Stikcy Header Logo Text', 'umetric') ,
				'required' => array(
					'umetric_logo_sticky_type',
					'=',
					'2'
				) ,
	
			) ,
	
			 array(
				'id'       => 'umetric_header_logo_sticky_tag',
				'type'     => 'select',
				'title'    => __('Select Html Tag', 'umetric'),             
				'desc'     => __('Select Tag For Text.', 'umetric'),
				'options'  => array(
					'h1' => esc_html__('h1', 'umetric'),
					'h2' => esc_html__('h2', 'umetric'),
					'h3' => esc_html__('h3', 'umetric'),
					'h4' => esc_html__('h4', 'umetric'),
					'h5' => esc_html__('h5', 'umetric'),
					'h6' => esc_html__('h6', 'umetric'),
					
				),
				'required' => array(
					'umetric_logo_sticky_type',
					'=',
					'2'
				) ,
				'default' => esc_html__('2', 'umetric'),
			),
	
		   
	
			array(
				'id' => 'header_logo_sticky_color',
				'type' => 'color',
				'title' => esc_html__('Set Stikcy Header Logo Color', 'umetric') ,
				'subtitle' => esc_html__('Choose Stikcy Header Logo Color', 'umetric') ,
				'default' => '#ffffff',
				'mode' => 'background',
				'transparent' => false,
				'required' => array(
					'umetric_logo_sticky_type',
					'=',
					'2'
				) ,
			) ,
				//---logo options for vertical menu start---//
				array(
					'id'        => 'has_vertical_header_logo',
					'type'      => 'button_set',
					'title'     => esc_html__( 'Use different logo for vertical menu ?','umetric'),
					'subtitle'  => esc_html__( 'Select option for set different logo for vertical menu','umetric'),
					'required'  => array( 'umetric_header_variation', '=', '2' ),
					'options'   => array(
									'yes' => esc_html__('Yes','umetric'),
									'no' => esc_html__('No','umetric'),
								),
					'default'   => esc_html__('no','umetric')
				),
		
				array(
					'id'       => 'vertical_header_radio',
					'type'     => 'button_set',
					'title'    => esc_html__( 'Select Logo Type', 'umetric' ),
					'subtitle' => esc_html__( 'Select either Text or image for your Logo.', 'umetric' ),
					'required'  => array( 'has_vertical_header_logo', '=', 'yes' ),
					'options'  => array(
						'1' => 'Image',
						'2' => 'Text',
					),
					'default'  => '1'
				),
		
				array(
					'id'       => 'umetric_vertical_logo',
					'type'     => 'media',
					'url'      => false,
					'title'    => esc_html__( 'Logo','umetric'),
					'required'  => array( 'vertical_header_radio', '=', '1' ),
					'read-only'=> false,
					'default'  => array( 'url' => get_template_directory_uri() .'/assets/images/logo.png' ),
					'subtitle' => esc_html__( 'Upload Logo image for your website vertical menu. Otherwise site title will be displayed in place of Logo.','umetric'),
				),
		
				array(
					'id'             => 'vertical-logo-dimensions',
					'type'           => 'dimensions',
					'units'          => array( 'em', 'px', '%' ),    // You can specify a unit value. Possible: px, em, %
					'units_extended' => 'true',  // Allow users to select any type of unit
					'title'          => esc_html__( 'Logo (Width/Height) Option', 'umetric' ),
					'required'  => array( 'vertical_header_radio', '=', '1' ),
					'subtitle'       => esc_html__( 'Allows you to choose width, height, and/or unit.', 'umetric' ),
					'desc'           => esc_html__( 'You can enable or disable any piece of this field. Width, Height, or Units.', 'umetric' ),
		
				),
		
				array(
					'id'       => 'vertical_header_logo_text',
					'type'     => 'text',
					'title'    => esc_html__( 'Logo Text', 'umetric' ),
					'desc'     => esc_html__( 'Enter the text to be used instead of the logo image', 'umetric' ),
					'required'  => array( 'vertical_header_radio', '=', '2' ),
					'msg'      => esc_html__('custom error message','umetric' ),
					'default'  => esc_html__('umetric','umetric' ),
				),
				array(
					'id'       => 'umetric_ver_header_logo_tag',
					'type'     => 'select',
					'title'    => __('Select Html Tag', 'umetric'),             
					'desc'     => __('Select Tag For Text.', 'umetric'),
					'options'  => array(
						'h1' => esc_html__('h1', 'umetric'),
						'h2' => esc_html__('h2', 'umetric'),
						'h3' => esc_html__('h3', 'umetric'),
						'h4' => esc_html__('h4', 'umetric'),
						'h5' => esc_html__('h5', 'umetric'),
						'h6' => esc_html__('h6', 'umetric'),
						
					),
					'required' => array(
						'vertical_header_radio',
						'=',
						'2'
					) ,
					'default' => esc_html__('2', 'umetric'),
				),
		
			   
		
				array(
					'id' => 'ver_header_logo_color',
					'type' => 'color',
					'title' => esc_html__('Set Header Logo Color', 'umetric') ,
					'subtitle' => esc_html__('Choose Header Logo Color', 'umetric') ,
					'default' => '#ffffff',
					'mode' => 'background',
					'transparent' => false,
					'required' => array(
						'vertical_header_radio',
						'=',
						'2'
					) ,
				) ,

			

			)
		));
		
	}
}
