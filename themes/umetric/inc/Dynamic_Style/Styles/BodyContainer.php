<?php

/**
 * Umetric\Utility\Dynamic_Style\Styles\BodyContainer class
 *
 * @package umetric
 */

namespace Umetric\Utility\Dynamic_Style\Styles;

use Umetric\Utility\Dynamic_Style\Component;
use function add_action;

class BodyContainer extends Component
{

	public function __construct()
	{
		if (class_exists('ReduxFramework')) {
			add_action('wp_enqueue_scripts', array($this, 'umetric_container_width'), 21);
		}
	}

	public function umetric_container_width()
	{
		$umetric_options = get_option('umetric_options');

		if (isset($umetric_options['opt-slider-label']) && !empty($umetric_options['opt-slider-label'])) {
			$container_width = $umetric_options['opt-slider-label'];
			$box_container_width = "body.iq-container-width .container,
        							body.iq-container-width .elementor-section.elementor-section-boxed>
        							.elementor-container { max-width: " . $container_width . "px; } ";
			wp_add_inline_style('umetric-style', $box_container_width);
		}
	}
}
