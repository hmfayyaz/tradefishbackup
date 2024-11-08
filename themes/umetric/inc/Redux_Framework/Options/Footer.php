<?php

/**
 * Umetric\Utility\Redux_Framework\Options\Footer class
 *
 * @package umetric
 */

namespace Umetric\Utility\Redux_Framework\Options;

use Redux;
use Umetric\Utility\Redux_Framework\Component;

class Footer extends Component
{

	public function __construct()
	{
		$this->set_widget_option();
	}

	protected function set_widget_option()
	{
		Redux::set_section( $this->opt_name, array(
			'title' => esc_html__( 'Footer', 'umetric' ),
			'id'    => 'footer-editor',
			'icon'  => 'el el-arrow-down',
			'customizer_width' => '500px',
		) );
		
		Redux::set_section( $this->opt_name, array(
			'title' => esc_html__('Footer','umetric'),
			'id'    => 'footer-logo',
			'subsection' => true,
			'desc'  => esc_html__('This section contains options for footer.','umetric'),
			'fields'=> array(
				array(
					'id' => 'umetric_footer_layout',
					'type' => 'button_set',
					'title' => esc_html__('Footer Layout', 'umetric'),
					'options' => array(
						'default' => esc_html__('Default', 'umetric'),
						'custom' => esc_html__('Custom', 'umetric'),
					),
					'default' => 'default'
				),
				array(
					'id'        	=> 'umetric_footer_style',
					'type'      	=> 'select',
					'title' 		=> esc_html__('Footer Layout', 'umetric'),
					'subtitle' 		=> esc_html__('Select the layout variation that you want to use for header layout.', 'umetric'),
					'options'		=> (function_exists('iqonic_addons_get_list_layouts')) ? iqonic_addons_get_list_layouts(false, 'footer') : '',
					'desc'			=> (function_exists('iqonic_addons_get_list_layouts')) ? esc_html__("Create", 'umetric') . " <a target='_blank' href='" . admin_url('edit.php?post_type=iqonic_hf_layout') . "'>" . esc_html__("New Layout", 'umetric') . "</a>" : "",
					'required' 		=> array('umetric_footer_layout', '=', 'custom'),
				),
		
				array(
					'id'       => 'logo_footer',         
					'type'     => 'media',
					'url'      => false,
					'title'    => esc_html__( 'Footer Logo','umetric'),            
					'read-only'=> false,
					'subtitle' => esc_html__( 'Upload Footer Logo for your Website.','umetric'),
					'default'  => array('url' => get_template_directory_uri() . '/assets/images/logo.png'),
					'required' 		=> array('umetric_footer_layout', '=', 'default'),
				),
				
				array(
					'id'       => 'footer_option',
					'type'     => 'button_set',
					'title'    => esc_html__( 'Footer Background', 'umetric' ),
					'required' 		=> array('umetric_footer_layout', '=', 'default'),
					'options'  => array(
						'1' => 'Default',
						'2' => 'Custom'
					),
					'default'  => '1'
				),

				array(
					'id'       => 'footer_text_link_color',
					'type'     => 'button_set',
					'title'    => esc_html__( 'Footer Text Color', 'umetric' ),
					'required'  => array( 'footer_option', '=', '2' ),
					'subtitle' => esc_html__( 'Select this option for Footer Text Color.', 'umetric' ),
					'options'  => array(
						'1' => 'Default',
						'2' => 'Custom'
					),
					'default'  => '1'
				),
		
				array(
					'id'            => 'footer_heading_color',
					'type'          => 'color',
					'title'         => esc_html__( 'Footer Heading Color', 'umetric' ),
					'required'  => array( 'footer_text_link_color', '=', '2' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'footer_text_color',
					'type'          => 'color',
					'title'         => esc_html__( 'Footer Text Color', 'umetric' ),
					'required'  => array( 'footer_text_link_color', '=', '2' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'footer_link_color',
					'type'          => 'color',
					'title'         => esc_html__( 'Footer Link Color', 'umetric' ),
					'required'  => array( 'footer_text_link_color', '=', '2' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'       => 'footer_type',
					'type'     => 'button_set',
					'title'    => esc_html__( 'Footer Set Option', 'umetric' ),
					'required'  => array( 'footer_option', '=', '2' ),
					'subtitle' => esc_html__( 'Select this option for Background Type color and image.', 'umetric' ),
					'options'  => array(
						'1' => 'Color',
						'2' => 'Image',
					),
					'default'  => '1'
				),
				
				array(
					'id'       => 'footer_image',         
					'type'     => 'media',
					'url'      => false,
					'title'    => esc_html__( 'Footer Background Image','umetric'),
					'required'  => array( 'footer_type', '=', '2' ),
					'read-only'=> false,
					'subtitle' => esc_html__( 'Upload Footer image for your Website. Otherwise site title will be displayed in place of Logo.','umetric'),
					'default'  => array( 'url' => get_template_directory_uri() .'/assets/images/redux/theme-option/style/07.png' ),
				), 
		
				array(
					'id'       => 'footer_opacity',
					'type'     => 'button_set',
					'title'    => esc_html__( 'Opacity Color', 'umetric' ),
					'required' => array( 
						array('footer_type','!=','1') 
					),
					'subtitle' => esc_html__( 'Select this option for Opacity Color.', 'umetric' ),
					'options'  => array(
						'1' => 'None',
						'2' => 'Custom'
					),
					'default'  => '1'
				),
		
				array(
					'id'            => 'footer_opacity_color',
					'type'          => 'color_rgba',
					'title'         => esc_html__( 'Background Gradient Color', 'umetric' ),
					'required'  => array( 'footer_opacity', '=', '2' ),
					'subtitle'      => esc_html__( 'Choose body Gradient background color', 'umetric' ),
					'default'   => array(
						'color'     => '#eff1fe',
						'alpha'     => 0.9
					),
					'transparent'   => false
				),
		
				array(
					'id'            => 'footer_color',
					'type'          => 'color_rgba',
					'title'         => esc_html__( 'Footer Background Color', 'umetric' ),
					'subtitle'      => esc_html__( 'Choose Footer Background Color', 'umetric' ),
					'required'  => array( 'footer_type', '=', '1' ),
					'default'   => array(
						'color'     => '#eff1fe',
						'alpha'     => 0.9
					),
					'mode'          => 'background',
					'transparent'   => false
				),
		
			)
		));  
		
		Redux::set_section( $this->opt_name, array(
			'title' => esc_html__('Footer Option','umetric'),
			'id'    => 'footer-section',
			'subsection' => true,    
			'desc'  => esc_html__('This section contains options for footer.','umetric'),
			'fields'=> array(
				array(
					'id'        => 'umetric_footer_display',
					'type'      => 'button_set',
					'title'     => esc_html__( 'Display Footer','umetric'),
					'subtitle' => esc_html__( 'Display Footer On All Pages', 'umetric' ),
					'required' 		=> array('umetric_footer_layout', '=', 'default'),
					'options'   => array(
						'yes' => esc_html__('Yes','umetric'),
						'no' => esc_html__('No','umetric')
					),
					'default'   => esc_html__('yes','umetric')
				),
		
				array(
					'id' => 'umetric_footer_width',
					'type' => 'image_select',
					'title' => esc_html__('Footer Layout Type', 'umetric'),
					'required'  => array( 'umetric_footer_display', '=', 'yes' ),
					'subtitle' => wp_kses(__('<br />Choose among these structures (1column, 2column and 3column) for your footer section.<br />To fill these column sections you should go to appearance > widget.<br />And add widgets as per your needs.', 'umetric'), array('br' => array())),
					'options' => array(
						'1' => array('title' => esc_html__('Footer Layout 1', 'umetric'), 'img' => get_template_directory_uri() . '/assets/images/redux/footer_first.png'),
						'2' => array('title' => esc_html__('Footer Layout 2', 'umetric'), 'img' => get_template_directory_uri() . '/assets/images/redux/footer_second.png'),
						'3' => array('title' => esc_html__('Footer Layout 3', 'umetric'), 'img' => get_template_directory_uri() . '/assets/images/redux/footer_third.png'),
						'4' => array('title' => esc_html__('Footer Layout 4', 'umetric'), 'img' => get_template_directory_uri() . '/assets/images/redux/footer_four.png'),
					),
					'default' => '3',
				),
		
				
		
			)
		));
		
		Redux::set_section( $this->opt_name, array(
			'title'      => esc_html__( 'Footer Copyright', 'umetric' ),
			'id'         => 'footer-copyright',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'        => 'display_copyright',
					'type'      => 'button_set',
					'title'     => esc_html__( 'Display Footer Copyright','umetric'),
					'subtitle' => esc_html__( 'Display Footer Copyright On All page', 'umetric' ),
					'required' 		=> array('umetric_footer_layout', '=', 'default'),
					'options'   => array(
									'yes' => esc_html__('Yes','umetric'),
									'no' => esc_html__('No','umetric')
								),
					'default'   => esc_html__('yes','umetric')
				),
		
				array(
					'id'        => 'footer_copyright',
					'type'      => 'textarea',
					'required'  => array( 'display_copyright', '=', 'yes' ),
					'title'     => esc_html__( 'Copyright Text','umetric'),
					'default'   => esc_html__( 'Copyright {{year}} umetric All Rights Reserved.','umetric'),
				),
		
				array(
					'id'       => 'footer_copy_color',
					'type'     => 'button_set',
					'required'  => array( 'display_copyright', '=', 'yes' ),
					'title'    => esc_html__( 'Change Footer Copyright Color', 'umetric' ),
					'options'  => array(
						'1' => 'Default',
						'2' => 'Custom'
					),
					'default'  => '1'
				),
		
				array(
					'id'            => 'footer_copyright_color',
					'type'          => 'color',
					'title'         => esc_html__( 'Footer Link Color', 'umetric' ),
					'required'  => array( 'footer_copy_color', '=', '2' ),
					'mode'          => 'background',
					'transparent'   => false
				),
		
			)) 
		);
		
		Redux::set_section( $this->opt_name, array(
			'title' => esc_html__('Top Footer Option','umetric'),
			'id'    => 'umetric-footer-top-section',
			'subsection' => true,    
			'desc'  => esc_html__('This section contains options for footer.','umetric'),
			'fields'=> array(
		
				array(
					'id'        => 'umetric_footer_top_display',
					'type'      => 'button_set',
					'title'     => esc_html__( 'Display Top Footer','umetric'),
					'subtitle' => esc_html__( 'Display Top Footer On All Pages', 'umetric' ),
					'required' 		=> array('umetric_footer_layout', '=', 'default'),

					'options'   => array(
									'yes' => esc_html__('Yes','umetric'),
									'no' => esc_html__('No','umetric')
								),
					'default'   => esc_html__('yes','umetric')
				),
		
				array(
					'id' => 'umetric_footer_top_background',
					'type' => 'button_set',                        
					'desc' => __('Select Footer Background Style', 'umetric') ,            
					'options' => array(
						'1' => 'Image',
						'2' => 'Color',
						'3' => 'Default'
					) ,
					'default' => '3',
		
					'required' => array(
						'umetric_footer_top_display',
						'=',
						'yes'
					) ,
				) ,
		
				array(
					'id' => 'umetric_footer_top_image',
					'type' => 'media',
					'url' => true,
					'title' => esc_html__('upload image', 'umetric') ,
					'read-only' => true,
					'default' => array (
						'url' =>  get_template_directory_uri() . '/assets/images/redux/theme-option/style/07.png',
					),
					'required' => array(
						'umetric_footer_top_background',
						'=',
						'1'
					) ,
					
				) ,
		
				array(
					'id' => 'umetric_footer_top_color',
					'type' => 'color',
					'title' => esc_html__('Set Background Color', 'umetric') ,
					
					'default' => '#ffffff',
					'mode' => 'background',
					'required' => array(
						'umetric_footer_top_background',
						'=',
						'2'
					) ,
					'transparent' => false
				) ,
			)
		));
		
	}
}
