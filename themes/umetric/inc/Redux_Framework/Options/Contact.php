<?php
/**
 * Umetric\Utility\Redux_Framework\Options\Contact class
 *
 * @package umetric
 */

namespace Umetric\Utility\Redux_Framework\Options;

use Redux;
use Umetric\Utility\Redux_Framework\Component;

class Contact extends Component {

	public function __construct() {
		$this->set_widget_option();
	}

	protected function set_widget_option() {
		Redux::set_section($this->opt_name, array(
			'title' => esc_html__('Contact', 'umetric'),
			'id' => 'contact',
			'icon' => 'el el-map-marker',
			'fields' => array(

				array(
					'id' => 'address',
					'type' => 'textarea',
					'title' => esc_html__('Address', 'umetric'),
					'default' => esc_html__('1234 North Avenue Luke Lane, South Bend, IN 360001', 'umetric'),
				),

				array(
					'id' => 'phone',
					'type' => 'text',
					'title' => esc_html__('Phone', 'umetric'),
					'preg' => array(
						'pattern' => '/[^0-9_ -+()]/s',
						'replacement' => ''
					),
					'default' => esc_html__('+0123456789', 'umetric'),
				),

				array(
					'id' => 'email',
					'type' => 'text',
					'title' => esc_html__('Email', 'umetric'),
					'validate' => 'email',
					'msg' => esc_html__('custom error message', 'umetric'),
					'default' => esc_html__('support@example.com', 'umetric'),
				),
			)
		));
	}
}
