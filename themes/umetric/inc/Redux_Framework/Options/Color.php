<?php
/**
 * Umetric\Utility\Redux_Framework\Options\Color class
 *
 * @package umetric
 */

namespace Umetric\Utility\Redux_Framework\Options;

use Redux;
use Umetric\Utility\Redux_Framework\Component;

class Color extends Component {

	public function __construct() {
		$this->set_widget_option();
	}

	protected function set_widget_option() {
		Redux::set_section( $this->opt_name, array(
			'title' => esc_html__( 'Color Attribute','umetric' ),
			'id'    => 'color',
			'icon'  => 'el el-brush',
			'desc'  => esc_html__('Change the default colors of your site.','umetric'),
			'fields'=> array(

				array(
					'id' => 'info_' . rand(10, 1000) ,
					'type' => 'info',
					'style' => 'custom',
					'title' => __('Color Scheme Options', 'umetric') ,
				) ,
				array(
					'id' => 'section-general'. rand(10, 1000) ,
					'type' => 'section',
					'indent' => true
				) ,
		
				array(
					'id'       => 'umetric_color',
					'type'     => 'button_set',
					'title'    => esc_html__( 'Color Scheme Settings', 'umetric' ),
					'options'  => array(
						'1' => 'Default',
						'2' => 'Custom'
					),
					'default'  => '1'
				),
		
				array(
					'id'            => 'primary_color',
					'type'          => 'color',
					'title'         => esc_html__( 'Set Primary Singal Color', 'umetric' ),
					'required'  => array( 'umetric_color', '=', '2' ),
					'subtitle'      => esc_html__( 'Select primary accent color.', 'umetric' ),
					'default'       =>'#a37cfc',
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'secondary_color',
					'type'          => 'color',
					'title'         => esc_html__( 'Set Secondary Color', 'umetric' ),
					'required'  => array( 'umetric_color', '=', '2' ),
					'subtitle'      => esc_html__( 'Select secondary complementing color.', 'umetric' ),
					'default'       =>'#1e1e1e',
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'theme_title_color',
					'type'          => 'color',
					'title'         => esc_html__( 'Title Color', 'umetric' ),
					'required'  => array( 'umetric_color', '=', '2' ),
					'subtitle'      => esc_html__( 'Select default Title(Headings) color.', 'umetric' ),
					'default'       =>'#1e1e1e',
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'theme_subtitle_color',
					'type'          => 'color',
					'title'         => esc_html__( 'Sub Title Color', 'umetric' ),
					'required'  => array( 'umetric_color', '=', '2' ),
					'subtitle'      => esc_html__( 'Select default Sub Title color.', 'umetric' ),
					'default'       =>'#1e1e1e',
					'mode'          => 'background',
					'transparent'   => false
				),
		
				array(
					'id'            => 'theme_body_color',
					'type'          => 'color',
					'title'         => esc_html__( 'Body Text Color', 'umetric' ),
					'required'  => array( 'umetric_color', '=', '2' ),
					'subtitle'      => esc_html__( 'Select default body text color.', 'umetric' ),
					'default'       =>'#1e1e1e',
					'mode'          => 'background',
					'transparent'   => false
				),

			)
		));
	}
}
