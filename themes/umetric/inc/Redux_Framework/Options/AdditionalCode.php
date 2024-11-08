<?php
/**
 * Umetric\Utility\Jetpack\Component class
 *
 * @package umetric
 */

namespace Umetric\Utility\Redux_Framework\Options;

use Redux;
use Umetric\Utility\Redux_Framework\Component;

class AdditionalCode extends Component {

	public function __construct() {
		$this->set_widget_option();
	}

	protected function set_widget_option() {
		Redux::set_section( $this->opt_name, array(
			'title' => __( 'Additional Code', 'umetric' ),
			'id'    => 'additional-Code',
			'icon'  => 'el el-css',
			'desc'  => esc_html__('This section contains options for header.','umetric'),
			'fields'=> array(

				array(
					'id'       => 'css_code',
					'type'     => 'ace_editor',
					'title'    => esc_html__('CSS Code','umetric'),
					'subtitle' => esc_html__('Paste your css code here.','umetric'),
					'mode'     => 'css',
					'desc'     => esc_html__('Paste your custom CSS code here.','umetric'),
				),

				array(
					'id'       => 'js_code',
					'type'     => 'ace_editor',
					'title'    => esc_html__('JS Code','umetric'),
					'subtitle' => esc_html__('Paste your js code in footer.','umetric'),
					'mode'     => 'javascript',
					'theme'   => 'chrome',
					'desc'     => esc_html__('Paste your custom JS code here.','umetric'),
					'default' => "jQuery(document).ready(function($){\n\n});"
				),
			)
		));
	}
}
