<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://iqonic.design/
 * @since             1.7.0
 * @package           Marvy_Pro_Animation_Addons
 *
 * @wordpress-plugin
 * Plugin Name:       Marvy - Ultimate Elementor Animation addons Pro
 * Plugin URI:        https://iqonicthemes.com
 * Description:       Marvy Pro is the best solution for users who need beautiful animations for creative and professional projects.
 * Version:           1.7.1
 * Author:            Iqonic Design
 * Author URI:        https://iqonic.design/
 * Text Domain:       marvy-animation-addons
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.7.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'MARVY_PRO_ANIMATION_ADDONS_VERSION', '1.7.1' );
define( 'MARVY_PRO_ANIMATION_ADDONS_PLUGIN_PATH', plugin_dir_path(__FILE__));
define( 'MARVY_PRO_ANIMATION_ADDONS_PLUGIN_URL', plugins_url('/', __FILE__));
define( 'MARVY_PRO_ANIMATION_ADDONS_BASE_PATH', plugin_basename(__FILE__));


// Require once the Composer Autoload
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
    require_once dirname( __FILE__ ) . '/vendor/autoload.php';
} else {
    die( 'Something went wrong' );
}

$GLOBALS['marvy_pro_config'] = require_once MARVY_PRO_ANIMATION_ADDONS_PLUGIN_PATH . 'config.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-marvy-pro-animation-addons-activator.php
 */
function marvy_pro_animation_addons_activate() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-marvy-pro-animation-addons-activator.php';
    Marvy_Pro_Animation_Addons_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-marvy-pro-animation-addons-deactivator.php
 */
function marvy_pro_animation_addons_deactivate() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-marvy-pro-animation-addons-deactivator.php';
    Marvy_Pro_Animation_Addons_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'marvy_pro_animation_addons_activate' );
register_deactivation_hook( __FILE__, 'marvy_pro_animation_addons_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-marvy-pro-animation-addons.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.7.0
 */
function marvy_pro_animation_addons_run() {

    $plugin = new Marvy_Pro_Animation_Addons();
    $plugin->run();

}
marvy_pro_animation_addons_run();

/**
 * Admin Notices
 *
 */
add_action('admin_notices', function () {
    marvy_if_failed_load();
});
