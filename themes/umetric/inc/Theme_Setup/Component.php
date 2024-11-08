<?php

/**
 * Umetric\Utility\Theme_Setup\Component class
 *
 * @package umetric
 */

namespace Umetric\Utility\Theme_Setup;

use Umetric\Utility\Component_Interface;
use Merlin;

use function add_action;

/**
 * Class for integrating with setup wizard.
 *
 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/
 */
class Component implements Component_Interface
{

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug(): string
	{
		return 'theme_setup';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize()
	{
		$this->umetric_setup_wizard_config();
	}

	/**
	 * Define Setup wizard default values
	 *
	 *
	 * This function init merlin class and set default values
	 */
	function umetric_setup_wizard_config()
	{
		$theme_detail = wp_get_theme();
		$wizard = new Merlin(

			$config = array(
				'directory'            => 'Merlin', // Location / directory where Merlin WP is placed in your theme.
				'merlin_url'           => 'umetric-setup', // The wp-admin page slug where Merlin WP loads.
				'parent_slug'          => 'themes.php', // The wp-admin parent page slug for the admin menu item.
				'capability'           => 'manage_options', // The capability required for this menu to be displayed to the user.
				'child_action_btn_url' => 'https://developer.wordpress.org/themes/advanced-topics/child-themes/', // URL for the 'child-action-link'.
				'dev_mode'             => true, // Enable development mode for testing.
				'license_step'         => false, // EDD license activation step.
				'license_required'     => false, // Require the license activation step.
				'license_help_url'     => '', // URL for the 'license-tooltip'.
				'edd_remote_api_url'   => '', // EDD_Theme_Updater_Admin remote_api_url.
				'edd_item_name'        => '', // EDD_Theme_Updater_Admin item_name.
				'edd_theme_slug'       => '', // EDD_Theme_Updater_Admin item_slug.
				'ready_big_button_url' => home_url('/'), // Link for the big button on the ready step.
			),
			$strings = array(
				'admin-menu'               => esc_html__('Theme Setup', 'umetric'),

				/* translators: 1: Title Tag 2: Theme Name 3: Closing Title Tag */
				'title%s%s%s%s'            => esc_html__('%1$s%2$s Themes &lsaquo; Theme Setup: %3$s%4$s', 'umetric'),
				'return-to-dashboard'      => esc_html__('Return to the dashboard', 'umetric'),
				'ignore'                   => esc_html__('Disable this wizard', 'umetric'),

				'btn-skip'                 => esc_html__('Skip', 'umetric'),
				'btn-next'                 => esc_html__('Next', 'umetric'),
				'btn-start'                => esc_html__('Start', 'umetric'),
				'btn-no'                   => esc_html__('Cancel', 'umetric'),
				'btn-plugins-install'      => esc_html__('Install', 'umetric'),
				'btn-child-install'        => esc_html__('Install', 'umetric'),
				'btn-content-install'      => esc_html__('Install', 'umetric'),
				'btn-import'               => esc_html__('Import', 'umetric'),
				'btn-license-activate'     => esc_html__('Activate', 'umetric'),
				'btn-license-skip'         => esc_html__('Later', 'umetric'),

				/* translators: Theme Name */
				'license-header%s'         => esc_html__('Activate %s', 'umetric'),
				/* translators: Theme Name */
				'license-header-success%s' => esc_html__('%s is Activated', 'umetric'),
				/* translators: Theme Name */
				'license%s'                => esc_html__('Enter your license key to enable remote updates and theme support.', 'umetric'),
				'license-label'            => esc_html__('License key', 'umetric'),
				'license-success%s'        => esc_html__('The theme is already registered, so you can go to the next step!', 'umetric'),
				'license-json-success%s'   => esc_html__('Your theme is activated! Remote updates and theme support are enabled.', 'umetric'),
				'license-tooltip'          => esc_html__('Need help?', 'umetric'),

				/* translators: Theme Name */
				'welcome-header%s'         => esc_html__('Welcome to %s', 'umetric'),
				'welcome-header-success%s' => esc_html__('Hi. Welcome back', 'umetric'),
				'welcome%s'                => esc_html($theme_detail['Description']),
				'welcome-success%s'        => esc_html($theme_detail['Description']),

				'child-header'             => esc_html__('Install Child Theme', 'umetric'),
				'child-header-success'     => esc_html__('You\'re good to go!', 'umetric'),
				'child'                    => esc_html__('Let\'s build & activate a child theme so you may easily make theme changes.', 'umetric'),
				'child-success%s'          => esc_html__('Your child theme has already been installed and ready activated, if it wasn\'t already.', 'umetric'),
				'child-action-link'        => esc_html__('Learn more about child themes', 'umetric'),
				'child-json-success%s'     => esc_html__('Awesome. Your child theme has already been installed and ready to activated.', 'umetric'),
				'child-json-already%s'     => esc_html__('Awesome. Your child theme has been created and ready to activated.', 'umetric'),

				'plugins-header'           => esc_html__('Install Plugins', 'umetric'),
				'plugins-header-success'   => esc_html__('You\'re up to speed!', 'umetric'),
				'plugins'                  => esc_html__('Let\'s install some essential WordPress plugins to get your site up to speed.', 'umetric'),
				'plugins-success%s'        => esc_html__('The required WordPress plugins are all installed and up to date. Press "Next" to continue the setup wizard.', 'umetric'),
				'plugins-action-link'      => esc_html__('Advanced', 'umetric'),

				'import-header'            => esc_html__('Import Content', 'umetric'),
				'import'                   => esc_html__('Let\'s import content to your website, to help you get familiar with the theme.', 'umetric'),
				'import-action-link'       => esc_html__('Advanced', 'umetric'),

				'ready-header'             => esc_html__('All done. Have fun!', 'umetric'),

				/* translators: Theme Author */
				'ready%s'                  => esc_html__('Your theme has been all set up. Enjoy your new theme by %s.', 'umetric'),
				'ready-action-link'        => esc_html__('Extras', 'umetric'),
				'ready-big-button'         => esc_html__('View your website', 'umetric'),
				'ready-link-1'             => sprintf('<a href="%1$s" class="merlin__button merlin__button--knockout merlin__button--no-chevron merlin__button--external" target="_blank">%2$s</a>', 'https://wordpress.org/support/', esc_html__('Explore WordPress', 'umetric')),
				'ready-link-2'             => sprintf('<a href="%1$s" class="merlin__button merlin__button--knockout merlin__button--no-chevron merlin__button--external" target="_blank">%2$s</a>', 'https://iqonic.desky.support/', esc_html__('Get Theme Support', 'umetric')),
				'ready-link-3'             => sprintf('<a href="%1$s" class="merlin__button merlin__button--knockout merlin__button--no-chevron merlin__button--external">%2$s</a>', admin_url('admin.php?page=_umetric_options&tab=1'), esc_html__('Start Customizing', 'umetric')),
			)
		);
	}
}
