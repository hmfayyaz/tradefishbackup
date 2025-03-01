<?php
/**
 * Umetric\Utility\Custom_Logo\Component class
 *
 * @package umetric
 */

namespace Umetric\Utility\Custom_Logo;

use Umetric\Utility\Component_Interface;
use function add_action;
use function add_theme_support;
use function apply_filters;

/**
 * Class for adding custom logo support.
 *
 * @link https://codex.wordpress.org/Theme_Logo
 */
class Component implements Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() : string {
		return 'custom_logo';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		add_action( 'after_setup_theme', array( $this, 'action_add_custom_logo_support' ) );
	}

	/**
	 * Adds support for the Custom Logo feature.
	 */
	public function action_add_custom_logo_support() {
		add_theme_support( 'custom-logo' );
		add_theme_support(
			'custom-logo',
			apply_filters(
				'umetric_custom_logo_args',
				array(
					'height'      => 250,
					'width'       => 250,
					'flex-width'  => false,
					'flex-height' => false,
				)
			)
		);
	}
}
