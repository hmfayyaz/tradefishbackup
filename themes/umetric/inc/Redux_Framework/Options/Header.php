<?php

/**
 * Umetric\Utility\Redux_Framework\Options\General class
 *
 * @package umetric
 */

namespace Umetric\Utility\Redux_Framework\Options;

use Redux;
use Umetric\Utility\Redux_Framework\Component;

class Header extends Component
{

	public function __construct()
	{
		$this->set_widget_option();
	}

	protected function set_widget_option()
	{
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Header', 'umetric') ,
			'id' => 'header-editor',
			'icon' => 'eicon-arrow-up',
			'customizer_width' => '500px',
		));
		
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Layout', 'umetric') ,
			'id' => 'header-variation',
			'subsection' => true,
			'desc' => esc_html__('This section contains options for header.', 'umetric') ,
			'fields' => array(
				
		
				array(
					'id' => 'section-general'.rand(10,1000),
					'type' => 'section',
					'indent' => true
				) ,
				array(
					'id' => 'umetric_header_layout',
					'type' => 'button_set',
					'title' => esc_html__('Header Layout', 'umetric'),
					'options' => array(
						'default' => esc_html__('Default', 'umetric'),
						'custom' => esc_html__('Custom', 'umetric'),
					),
					'default' => 'default'
				),
				array(
					'id'        	=> 'umetric_menu_style',
					'type'      	=> 'select',
					'title' 		=> esc_html__('Header Layout', 'umetric'),
					'subtitle' 		=> esc_html__('Select the layout variation that you want to use for header layout.', 'umetric'),
					'options'		=> (function_exists('iqonic_addons_get_list_layouts')) ? iqonic_addons_get_list_layouts(false, 'header') : '',
					'desc'			=> (function_exists('iqonic_addons_get_list_layouts')) ? esc_html__("Create", 'umetric') . " <a target='_blank' href='" . admin_url('edit.php?post_type=iqonic_hf_layout') . "'>" . esc_html__("New Layout", 'umetric') . "</a>" : "",
					'required' 		=> array('umetric_header_layout', '=', 'custom'),
				),
				array(
					'id' => 'header_layout_position',
					'type' => 'button_set',
					'title' => esc_html__('Header Layout Position', 'umetric'),
					'options' => array(
						'default' => esc_html__('Default', 'umetric'),
						'horizontal' 	=> esc_html__('Horizontal', 'umetric'),
						'vertical' 		=> esc_html__('Vertical', 'umetric'),
					),
					'default' => 'Default',
					'required' 	=> array('umetric_header_layout', '=', 'custom'),
				),

				array(
					'id'        =>  'vertical_header_width',
					'type'      =>  'dimensions',
					'units'     =>  array('em', 'px', '%'),
					'height'    =>  false,
					'width'     =>  true,
					'desc'     =>  esc_html__('Vertical header width', 'umetric'),
					'default'   =>  array(
						'width'   => '300px',
					),
					'required' 	=> array('header_layout_position', '=', 'vertical'),
				),

				array(
					'id'      => 'umetric_header_variation',
					'type'    => 'image_select',
					'title'   => esc_html__( 'Menu Style', 'umetric' ),
					'subtitle' => esc_html__( 'Select the design variation that you want to use for site menu.', 'umetric' ),
					'required' 		=> array('umetric_header_layout', '=', 'default'),
					'options' => array(
						'1'      => array(
							'alt' => 'Style1',
							'img' => get_template_directory_uri() . '/assets/images/redux/header-1.jpg',
						),
						'2'      => array(
							'alt' => 'Style2',
							'img' => get_template_directory_uri() . '/assets/images/redux/header-2.jpg',
						),
					),
					'default' => '1'
					
				),

				array(
					'id' => 'header_container',
					'type' => 'button_set',
					'title' => esc_html__('Header container', 'umetric'),
					'options' => array(
						'container-fluid' 	=> esc_html__('Full width', 'umetric'),
						'container' 		=> esc_html__('Container', 'umetric'),
					),
					'required' 	=> array('header_layout', '=', 'default'),
					'default' => 'container-fluid'
				),

				array(
					'id' => 'header_postion',
					'type' => 'button_set',
					'title' => esc_html__('Header Position', 'umetric'),
					'options' => array(
						'default' => esc_html__('Default', 'umetric'),
						'over' => esc_html__('Over', 'umetric'),
					),
					'default' => 'default',
				),

		
				array(
					'id'        => 'umetric_vertical_hedader_collapsed',
					'type'      => 'button_set',
					'title'     => esc_html__( 'Header Expanded / Collapsed','umetric'),
					'subtitle'  => esc_html__( 'Select expanded / collapsed vertical header','umetric'),
					'required'  => array( 'umetric_header_variation', '=', '2' ),
					'options'   => array(
									'expanded' => esc_html__('Expanded','umetric'),
									'collapsed' => esc_html__('Collapsed','umetric'),
								),
					'default'   => esc_html__('expanded','umetric')
				),

				array(
					'id' => 'header_back_opt_switch',
					'type' => 'button_set',
					'title' => esc_html__('Header Background Type', 'umetric') ,
					'required' 		=> array('umetric_header_layout', '=', 'default'),
					'options' => array(
						'0' => esc_html__('none', 'umetric') ,
						'1' => esc_html__('Image', 'umetric') ,
						'2' => esc_html__('Color', 'umetric'),
						'3' => esc_html__('Transparent', 'umetric')
					) ,
					'default' => esc_html__('0', 'umetric')
				) ,
				
		
				array(
					'id' => 'umetric_header_back_img',
					'type' => 'media',
					'url' => true,
					'title' => esc_html__('Header background image', 'umetric') ,
					'read-only' => false,            
					'required' => array(
						'header_back_opt_switch',
						'=',
						'1'
					) ,
				) ,
		
				array(
					'id' => 'umetric_header_back_color',
					'type' => 'color',
					'title' => esc_html__('Set Background Header Color', 'umetric') ,            
					'default' => '#ffffff',
					'mode' => 'background',
					'required' => array(
						'header_back_opt_switch',
						'=',
						'2'
					) ,
					'transparent' => false
				) ,
				
			)
		));
		
		//Top Header Options
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Top Header', 'umetric') ,
			'id' => 'header-variation-top',
			'subsection' => true,
			'desc' => esc_html__('This section contains options for Top header.', 'umetric') ,
			'fields' => array(
				
				array(
					'id'   => 'vertical_header_top_info',
					'type' => 'info',
					'title' =>  esc_html__( 'Opps ! Not Available...','umetric').'</br>'.
								esc_html__( ' This options only available with standard menu type.','umetric').'</br>'.
								esc_html__('We will come back soon with this options in vertical menu.','umetric'),
					'style' => 'critical',
					'required'  => array( 'umetric_header_variation', '=', '2' ),
				),
		
				array(
					'id' => 'info_'.rand(10, 1000) ,
					'type' => 'info',
					'style' => 'custom',
					'required'  => array( 'umetric_header_variation', '!=', '2' ),
					'title' => __('Top Header Setting', 'umetric') ,
				) ,
				array(
					'id' => 'section-general',
					'type' => 'section',
					'indent' => true
				) ,
				array(
					'id' => 'umetric_top_header_switch',
					'title' => esc_html__('Enable Top Header', 'umetric') ,
					'type' => 'switch',
					'required'  => array( 'umetric_header_variation', '!=', '2' ),
					'default' => false
				) ,
		
				array(
					'id' => 'umetric_top_header_var',
					'type' => 'image_select',
		
					'options' => array(
						'1' => array(
							'title' => esc_html__('Default', 'umetric') ,
							'img' => get_template_directory_uri() . '/assets/images/redux/theme-option/header/top-1.jpg',
						) ,
						'2' => array(
							'title' => esc_html__('Style 1', 'umetric') ,
							'img' => get_template_directory_uri() . '/assets/images/redux/theme-option/header/top-2.jpg',
						) ,
						'3' => array(
							'title' => esc_html__('Style 2', 'umetric') ,
							'img' => get_template_directory_uri() . '/assets/images/redux/theme-option/header/top-3.jpg',
						) ,
		
						'4' => array(
							'title' => esc_html__('Style 3', 'umetric') ,
							'img' => get_template_directory_uri() . '/assets/images/redux/theme-option/header/top-4.jpg',
						) ,
						'5' => array(
							'title' => esc_html__('Style 4', 'umetric') ,
							'img' => get_template_directory_uri() . '/assets/images/redux/theme-option/header/top-5.jpg',
						) ,
						'6' => array(
							'title' => esc_html__('Style 5', 'umetric') ,
							'img' => get_template_directory_uri() . '/assets/images/redux/theme-option/header/top-6.jpg',
						) ,
		
					) ,
					'required' => array(
						'umetric_top_header_switch',
						'=',
						true
					) ,
					'default' => esc_html__('1', 'umetric')
				) ,
		
				array(
					'id' => 'sticky_top_header_back_opt_switch',
					'type' => 'button_set',
					'title' => esc_html__('Top Header Background Type', 'umetric') ,
					
					'options' => array(
						'0' => esc_html__('none','umetric'),
						'1' => esc_html__('Image', 'umetric') ,
						'2' => esc_html__('color', 'umetric'),
						'3' => esc_html__('Transparent', 'umetric')
						
					) ,
					'default' => esc_html__('0', 'umetric'),
					'required' => array(
						'umetric_top_header_switch',
						'=',
						true
					) ,
				) ,
		
				array(
					'id' => 'top_header_back_color',
					'type' => 'color',
					'title' => esc_html__('Top Header Background Color', 'umetric') ,
					
					'default' => '#ffffff',
					'mode' => 'background',
					'transparent' => false,
					'required' => array(
						'sticky_top_header_back_opt_switch',
						'=',
						'2'
					) ,
				) ,
		
				array(
					'id' => 'top_header_back_img',
					'type' => 'media',
					'title' => esc_html__('Image', 'umetric') ,
					
					'default' => '#ffffff',
					'url'=>true,
					'required' => array(
						'sticky_top_header_back_opt_switch',
						'=',
						'1'
					) ,
				) ,
		
				array(
					'id' => 'top_header_text_color',
					'type' => 'color',
					'title' => esc_html__('Top Header Text Color', 'umetric') ,            
					'mode' => 'background',
					'transparent' => false,
					'required' => array(
						'umetric_top_header_switch',
						'=',
						true
					) ,
				) ,
		
				array(
					'id' => 'top_header_text_hover_color',
					'type' => 'color',
					'title' => esc_html__('Top Header Text Hover Color', 'umetric') ,           
					'mode' => 'background',
					'transparent' => false,
					'required' => array(
						'umetric_top_header_switch',
						'=',
						true
					) ,
				) ,
		
		
			)
		));
		
		//Sticky Header Options
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Sticky Header', 'umetric') ,
			'id' => 'header-variation-sticky',
			
			'subsection' => true,
			'desc' => esc_html__('This section contains options for Stikcy header.', 'umetric') ,
			'fields' => array(
				
				array(
					'id'   => 'vertical_header_sticky_info',
					'type' => 'info',
					'title' =>  esc_html__( 'Opps ! Not Available...','umetric').'</br>'.
								esc_html__( ' This options only available with standard menu type.','umetric').'</br>'.
								esc_html__('We will come back soon with this options in vertical menu.','umetric'),
					'style' => 'critical',
					'required'  => array( 'umetric_header_variation', '=', '2' ),
				),
		
				array(
					'id' => 'info_' . rand(10, 1000) ,
					'type' => 'info',
					'style' => 'custom',
					'required'  => array( 'umetric_header_variation', '!=', '2' ),
					'title' => __('Sticky Header Settings', 'umetric') ,
				) ,
		
				array(
					'id' => 'section-general'. rand(10, 1000) ,
					'type' => 'section',
					'indent' => true
				) ,
		
				array(
					'id' => 'umetric_sticky_header_switch',
					'title' => esc_html__('Enable Sticky Header', 'umetric') ,
					'required'  => array( 'umetric_header_variation', '!=', '2' ),
					'type' => 'switch',
					'default' => true,
				) ,
		
				array(
					'id' => 'sticky_header_back_opt_switch',
					'type' => 'button_set',
					'title' => esc_html__('Sticky Header Background Type', 'umetric') ,
					
					'options' => array(
						'0' => esc_html__('none', 'umetric') ,
						'1' => esc_html__('Image', 'umetric') ,
						'2' => esc_html__('color', 'umetric'),
						'3' => esc_html__('Transparent', 'umetric')
					) ,
					'default' => esc_html__('0', 'umetric'),
					'required' => array(
						'umetric_header_variation',
						'=',
						2
					) ,
				) ,
				
		
				array(
					'id' => 'umetric_sticky_header_back_img',
					'type' => 'media',
					'url' => true,
					'title' => esc_html__('Sticky Header Background Image', 'umetric') ,
					'read-only' => false,            
					
					'required' => array(
						'sticky_header_back_opt_switch',
						'=',
						'1'
					),
				),
		
				array(
					'id' => 'umetric_sticky_header_back_color',
					'type' => 'color',
					'title' => esc_html__('Sticky Header Background Color', 'umetric') ,            
					'default' => '#ffffff',
					'mode' => 'background',
					'required' => array(
						'sticky_header_back_opt_switch',
						'=',
						'2'
					) ,
					'transparent' => true
				) ,
			)
		));
		
		Redux::set_section($this->opt_name, array(
			'id' => 'default-variation',
			'title'=>'Header Menu Color',
			'desc' => 'This section contains header menu color opions',
			'subsection' => true,
			'fields' => array(
		
				array(
					'id' => 'menu_section_start',
					'type' => 'section',
					'title'=>'Menu Color',
					'indent' => true
				) ,
				array(
					'id' => 'umetric_menu_color',
					'type' => 'color',
					'title' => esc_html__('Set Menu Text Color', 'umetric') , 
					'mode' => 'background',            
					'transparent' => false
				) ,
		
				array(
					'id'            => 'umetric_header_menu_active_color',
					'type'          => 'color',
					'required'  => array( 'umetric_header_variation', '=', '2' ),
					'title'     => esc_html__( 'Active Menu Text Color', 'umetric' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id' => 'umetric_menu_hover_color',
					'type' => 'color',
					'title' => esc_html__('Set Menu Hover Text Color', 'umetric') ,  
					'mode' => 'background',            
					'transparent' => false
				) ,
		
				array(
					'id'            => 'umetric_vertical_header_active_background_color',
					'type'          => 'color',
					'required'  => array( 'umetric_header_variation', '=', '2' ),
					'title'     => esc_html__( 'Active menu background color', 'umetric' ),
					'mode'          => 'background',
					'transparent'   => false
				),
				
				//----vertical menu wave effect color options start----//
				array(
					'id'            => 'umetric_vertical_menu_wave_effect_color',
					'type'          => 'color',
					'title'    => esc_html__( 'Click effect color', 'umetric' ),
					'subtitle'    => esc_html__( 'Choose on click effect color for vertical menu', 'umetric' ),
					'required'  => array(  'umetric_header_variation', '=', '2' ),
					'mode'          => 'background',
					'transparent'   => false
				),
				//----vertical menu wave effect options end----//
		
				array(
					'id' => 'menu_section_end' ,
					'type' => 'section',
					'indent' => false
				) ,
				 
				// sub menu
				array(
					'id' => 'submenu_section_start',
					'type' => 'section',
					'title'=>'Submenu Color',
					'indent' => true
				) ,
				array(
					'id' => 'umetric_submenu_color',
					'type' => 'color',
					'title' => esc_html__('Set Sub Menu Text Color', 'umetric') , 
					'mode' => 'background',            
					'transparent' => false
				) ,
		
				array(
					'id'            => 'umetric_header_submenu_active_color',
					'type'          => 'color',
					'title'     => esc_html__( 'Active Submenu Color', 'umetric' ),
					'required'  => array(  'umetric_header_variation', '=', '2' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id' => 'umetric_submenu_hover_bg_color',
					'type' => 'color',
					'title' => esc_html__('Set Sub Menu Hover Text Background Color', 'umetric') ,
					'required'  => array(  'umetric_header_variation', '!=', '2' ), 
					'mode' => 'background',            
					'transparent' => false
				) ,
		
				 array(
					'id' => 'umetric_submenu_hover_color',
					'type' => 'color',
					'title' => esc_html__('Set Sub Menu Hover Text Color', 'umetric') , 
					'mode' => 'background',            
					'transparent' => false
				) ,
		
				array(
					'id' => 'umetric_sub_menu_back_color',
					'type' => 'color',
					'title' => esc_html__('Set Sub Menu Background Color', 'umetric') ,
					'required'  => array(  'umetric_header_variation', '!=', '2' ), 
					'mode' => 'background',            
					'transparent' => false
				) ,
		
				array(
					'id' => 'submenu_section_end',
					'type' => 'section',
					'indent' => false
				) ,
		
				//responsive menu
				array(
					'id' => 'responsive_menu_section_start',
					'type' => 'section',
					'title' => 'Responsive Menu Color',
					'indent' => true
				) ,
				array(
					'id' => 'umetric_toggle_color',
					'type' => 'color',
					'title' => esc_html__('Set Toggle Menu Text Color', 'umetric') , 
					'mode' => 'background',            
					'transparent' => false
				) ,
		
				  array(
					'id' => 'umetric_toogle_bg_color',
					'type' => 'color',
					'title' => esc_html__('Set Toggle Menu Background Color', 'umetric') , 
					'mode' => 'background',            
					'transparent' => false
				) ,
		
				array(
					'id' => 'responsive_menu_section_end',
					'type' => 'section',
					'indent' => false
				) ,
				
				//Sticky menu start
				array(
					'id' => 'sticky_menu_section_start',
					'title' => 'Sticky Header Menu Color',
					'type' => 'section',
					'indent' => true
				) ,
		
				array(
					'id' => 'umetric_sticky_menu_color',
					'type' => 'color',
					'title' => esc_html__('Set Sticky Menu Color Settings', 'umetric') , 
					'mode' => 'background',
					
					'transparent' => false
				) ,
		
				array(
					'id' => 'umetric_menu_sticky_hover_color',
					'type' => 'color',
					'title' => esc_html__('Set Hover Sticky Menu Color', 'umetric') , 
					'mode' => 'background',            
					'transparent' => false
				) ,
				array(
					'id' => 'umetric_sticky_toggle_color',
					'type' => 'color',
					'title' => esc_html__('Set Sticky Toggle Menu Text Color', 'umetric') , 
					'mode' => 'background',            
					'transparent' => false
				) ,
		
				  array(
					'id' => 'umetric_sticky_toogle_bg_color',
					'type' => 'color',
					'title' => esc_html__('Set Sticky Toggle Menu Background Color', 'umetric') , 
					'mode' => 'background',            
					'transparent' => false
				) ,
			   
				array(
					'id' => 'sticky_menu_section_end',
					'type' => 'section',
					'indent' => false
				) ,
			)
		));   
		
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Header Button', 'umetric') ,
			'id' => 'hader-button-variation',
			
			'subsection' => true,
			'desc' => esc_html__('This section contains options for button in header.', 'umetric') ,
			'fields' => array(
		
			  array(
					'id'        => 'header_display_button',
					'type'      => 'button_set',
					'title'     => esc_html__( 'Login/CTA Button','umetric'),
					'subtitle' => esc_html__( 'Turn on to display the Login and CTA button in top header.','umetric'),
					'options'   => array(
									'yes' => esc_html__('On','umetric'),
									'no' => esc_html__('Off','umetric')
								),
					'default'   => esc_html__('yes','umetric')
				),
		
				array(
					'id'        => 'umetric_download_title',
					'type'      => 'text',
					'title'     => esc_html__( 'Button Title','umetric'),
					'required'  => array( 'header_display_button', '=', 'yes' ),
					'default'   => 'Get Started',
					'desc'   => esc_html__('Change Title (e.g.Download).','umetric'),
				),
				array(
					'id'        => 'umetric_download_link',
					'type'      => 'text',
					'title'     => esc_html__( 'Button Link','umetric'),
					'required'  => array( 'header_display_button', '=', 'yes' ),
					'desc'   => esc_html__('Add button link.','umetric'),
				),
		
				array(
					'id'       => 'he_button_color',
					'type'     => 'button_set',
					'title'    => esc_html__( 'Header Button Colors', 'umetric' ),
					'options'  => array(
						'1' => 'Default',
						'2' => 'Custom'
					),
					'default'  => '1',
					'required'  => array( 'header_display_button', '=', 'yes' ),
				),
		
				array(
					'id'            => 'header_button_color',
					'type'          => 'color',
					'title'         => esc_html__( 'Header Button Color', 'umetric' ),
					'required'  => array( 'he_button_color', '=', '2' ),
					'subtitle'      => esc_html__( 'Choose Header Button Color', 'umetric' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'header_button_hover_color',
					'type'          => 'color',
					'title'         => esc_html__( 'Header Button Hover Color', 'umetric' ),
					'required'  => array( 'he_button_color', '=', '2' ),
					'subtitle'      => esc_html__( 'Choose Header Hover Button Hover Color', 'umetric' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'header_button_text_color',
					'type'          => 'color',
					'title'         => esc_html__( 'Header Button Text Color', 'umetric' ),
					'required'  => array( 'he_button_color', '=', '2' ),
					'subtitle'      => esc_html__( 'Choose Header Button Text Color', 'umetric' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'header_button_hover_text_color',
					'type'          => 'color',
					'title'         => esc_html__( 'Header Button Hover Text Color', 'umetric' ),
					'required'  => array( 'he_button_color', '=', '2' ),
					'subtitle'      => esc_html__( 'Choose Header Button Text Hover Color', 'umetric' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'        => 'header_display_search',
					'type'      => 'button_set',
					'title'     => esc_html__( 'Search Button','umetric'),
					'subtitle' => esc_html__( 'Turn on to display Search Button in header.','umetric'),
					'options'   => array(
									'yes' => esc_html__('Yes','umetric'),
									'no' => esc_html__('No','umetric')
								),
					'default'   => esc_html__('yes','umetric')
				),
				
			)
		));
		
		//-----Side Area Options Start---//
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Side Area', 'umetric') ,
			'id' => 'header-side-area-variation',
		
			'subsection' => true,
			'desc' => esc_html__('This section contains options for side area button in header.', 'umetric') ,
			'fields' => array(
		
			  array(
					'id'        => 'header_display_side_area',
					'type'      => 'button_set',
					'title'     => esc_html__( 'Side Area (Sliding Panel)','umetric'),
					'subtitle' => esc_html__( 'Set option for Sliding right side panel.','umetric'),
					'options'   => array(
									'yes' => esc_html__('On','umetric'),
									'no' => esc_html__('Off','umetric')
								),
					'default'   => esc_html__('yes','umetric')
				),
		
				// --------side area background options start----------//
				array(
					'id'        => 'sidearea_background_type',
					'type'      => 'button_set',
					'required'  => array( 'header_display_side_area', '=', 'yes' ),
					'title'     => esc_html__( 'Background','umetric'),
					'subtitle'  => esc_html__( 'Select the variation for Sidearea background','umetric'),
					'options'   => array(
									'default' => esc_html__('Default','umetric'),
									'color' => esc_html__('Color','umetric'),
									'image' => esc_html__('Image','umetric'),
									'transparent' => esc_html__('Transparent','umetric')
								),
					'default'   => esc_html__('default','umetric')
				),
		
				array(
					'id'            => 'sidearea_background_color',
					'type'          => 'color',
					'desc'     => esc_html__( 'Set Background Color', 'umetric' ),
					'required'  => array( 'sidearea_background_type', '=', 'color' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'       => 'sidearea_background_image',
					'type'     => 'media',
					'url'      => false,
					'desc'     => esc_html__( 'Upload Image', 'umetric' ),
					'required'  => array( 'sidearea_background_type', '=', 'image' ),
					'read-only'=> false,
					'subtitle' => esc_html__( 'Upload background image for sidearea.','umetric'),
				),
				// --------side area Background options end----------//
				array(
					'id' => 'sidearea_width',
					'type' => 'dimensions',
					'height' => false,
					'units'    => array('em','px','%'),
					'title' => __('Adjust sidearea width', 'umetric') ,
					'subtitle' => __('Choose Width, and/or unit.', 'umetric') ,
					'desc' => __('Sidearea Width.', 'umetric') ,
					'required'  => array( 'header_display_side_area', '=', 'yes' ),
				),
		
				// --------side area button color options ----------//
				array(
					'id'        => 'sidearea_btn_color_type',
					'type'      => 'button_set',
					'required'  => array( 'header_display_side_area', '=', 'yes' ),
					'title'     => esc_html__( 'Button color options','umetric'),
					'subtitle'  => esc_html__( 'Select text normal / hover color .','umetric'),
					'options'   => array(
									'default' => esc_html__('Default','umetric'),
									'custom' => esc_html__('Custom','umetric'),
								),
					'default'   => esc_html__('default','umetric')
				),
		
				array(
					'id'            => 'sidearea_btn_open_color',
					'type'          => 'color',
					'title' => __('Open button color', 'umetric') ,
					'subtitle' => __('Select color for normal / hover.', 'umetric') ,
					'desc'     => esc_html__( 'Set open button color', 'umetric' ),
					'required'  => array( 'sidearea_btn_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
				array(
					'id'            => 'sidearea_btn_open_hover',
					'type'          => 'color',
					'desc'     => esc_html__( 'Set open button hover color', 'umetric' ),
					'required'  => array( 'sidearea_btn_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'sidearea_btn_line_color',
					'type'          => 'color',
					'title' => __('Open button line color', 'umetric') ,
					'subtitle' => __('Select normal / hover color of open button lines.', 'umetric') ,
					'desc'     => esc_html__( 'Set open button line color', 'umetric' ),
					'required'  => array( 'sidearea_btn_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
				array(
					'id'            => 'sidearea_btn_line_hover_color',
					'type'          => 'color',
					'desc'     => esc_html__( 'Set open button line hover color', 'umetric' ),
					'required'  => array( 'sidearea_btn_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'sidearea_btn_close_color',
					'type'          => 'color',
					'title' => __('Close button color', 'umetric') ,
					'subtitle' => __('Select normal / hover color of close button inside sidearea.', 'umetric') ,
					'desc'     => esc_html__( 'Set close button color', 'umetric' ),
					'required'  => array( 'sidearea_btn_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
				array(
					'id'            => 'sidearea_btn_close_hover',
					'type'          => 'color',
					'desc'     => esc_html__( 'Set close button hover color', 'umetric' ),
					'required'  => array( 'sidearea_btn_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'sidearea_btn_close_line_color',
					'type'          => 'color',
					'title' => __('Close button line color', 'umetric') ,
					'subtitle' => __('Select normal / hover color of close button lines.', 'umetric') ,
					'desc'     => esc_html__( 'Set open button line color', 'umetric' ),
					'required'  => array( 'sidearea_btn_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
				array(
					'id'            => 'sidearea_btn_close_line_hover_color',
					'type'          => 'color',
					'desc'     => esc_html__( 'Set close button line hover color', 'umetric' ),
					'required'  => array( 'sidearea_btn_color_type', '=', 'custom' ),
					'mode'          => 'background',
					'transparent'   => false
				),
			)
		));
	}
}
