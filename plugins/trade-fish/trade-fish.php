<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://abc.com
 * @since             1.0.0
 * @package           Trade_Fish
 *
 * @wordpress-plugin
 * Plugin Name:       Trade Fish
 * Plugin URI:        https://xyz.com
 * Description:       This is a description of the plugin.
 * Version:           1.0.0
 * Author:            Hztech
 * Author URI:        https://abc.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       trade-fish
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'TRADE_FISH_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-trade-fish-activator.php
 */
function activate_trade_fish() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-trade-fish-activator.php';
	Trade_Fish_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-trade-fish-deactivator.php
 */
function deactivate_trade_fish() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-trade-fish-deactivator.php';
	Trade_Fish_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_trade_fish' );
register_deactivation_hook( __FILE__, 'deactivate_trade_fish' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-trade-fish.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_trade_fish() {

	$plugin = new Trade_Fish();
	$plugin->run();

}
run_trade_fish();
