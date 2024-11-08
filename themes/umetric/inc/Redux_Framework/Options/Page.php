<?php
/**
 * Umetric\Utility\Redux_Framework\Options\Page class
 *
 * @package umetric
 */

namespace Umetric\Utility\Redux_Framework\Options;
use Redux;
use Umetric\Utility\Redux_Framework\Component;

class Page extends Component {

	public function __construct() {
		$this->set_widget_option();
	}

	protected function set_widget_option() {
		Redux::set_section( $this->opt_name, array(
			'title' => esc_html__('Page Settings','umetric'),
			'id'    => 'page',
			'icon'  => 'el el-file-edit',
			'fields'=> array(

				array(
					'id'        => 'search_page',
					'type'      => 'image_select',
					'title'     => esc_html__( 'Search page Setting','umetric' ),
					'subtitle'  => wp_kses( __( '<br />Choose among these structures (Right Sidebar, Left Sidebar and 1column) for your Search page.<br />To filling these column sections you should go to appearance > widget.<br />And put every widget that you want in these sections.','umetric' ), array( 'br' => array() ) ),
					'options'   => array(
						'1' => array( 'title' => esc_html__( 'Full Width','umetric' ), 'img' => get_template_directory_uri() . '/assets/images/redux/single-column.jpg' ),
						'4' => array( 'title' => esc_html__( 'Right Sidebar','umetric' ), 'img' => get_template_directory_uri() . '/assets/images/redux/right-side.jpg' ),
						'5' => array( 'title' => esc_html__( 'Left Sidebar','umetric' ), 'img' => get_template_directory_uri() . '/assets/images/redux/left-side.jpg' ),
					),
					'default'   => '1',
				),
			)
		));
	}
}
