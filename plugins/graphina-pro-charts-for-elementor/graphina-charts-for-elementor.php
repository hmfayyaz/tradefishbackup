<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin line. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://iqonic.design
 * @since             1.2.4
 * @package           Graphina_Pro_Charts_For_Elementor
 *
 * @wordpress-plugin
 * Plugin Name:       GraphinaPro – Elementor Dynamic Charts & Datatable
 * Plugin URI:        https://iqonicthemes.com
 * Description:       Your ultimate charts and graphs solution to enhance visual effects. Create versatile, advanced and interactive charts on your website.
 * Version:           1.4.3
 * Author:            Iqonic Design
 * Author URI:        https://iqonic.design/
 * Text Domain:       graphina-pro-charts-for-elementor
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
if (!defined('GRAPHINA_PRO_ROOT'))
    define('GRAPHINA_PRO_ROOT', plugin_dir_path(__FILE__));

if (!defined('GRAPHINA_PRO_URL'))
    define('GRAPHINA_PRO_URL', plugins_url('', __FILE__));

if (!defined('GRAPHINA_PRO_BASE_PATH'))
    define('GRAPHINA_PRO_BASE_PATH', plugin_basename(__FILE__));

if (!defined('GRAPHINA_LITE_CURRENT_VERSION'))
    define('GRAPHINA_LITE_CURRENT_VERSION', '1.8.7');

if (!defined('GRAPHINA_PRO_DATABASE_TABLES')){

    global $wpdb;
    // Get the columns of all tables in the WordPress database
    $columns = $wpdb->get_results( "SELECT COLUMN_NAME, TABLE_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '{$wpdb->dbname}'" );

    $table_column = [];
    // Loop through the columns
    foreach ( $columns as $column ) {
        // Output the column name and table name
        $table_column[$column->TABLE_NAME][$column->COLUMN_NAME] =  $column->COLUMN_NAME ;
    }

    define('GRAPHINA_PRO_DATABASE_TABLES', $table_column );

}

if (!defined('GRAPHINA_PRO_EXTERNAL_DATABASE_TABLES')){
    $externalDatabase = get_option('graphina_mysql_database_setting',true);
    $externalDatabase = !empty($externalDatabase) && is_array($externalDatabase) && count($externalDatabase) > 0 ? $externalDatabase : [];
    $table_column = [];
    foreach ($externalDatabase as $ex){
        $new_wpdb = new wpdb( $ex['user_name'],$ex['pass'],$ex['db_name'],$ex['host']);
        $columns = $new_wpdb->get_results( "SELECT COLUMN_NAME, TABLE_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '{$new_wpdb->dbname}'" );
        // Loop through the columns
        foreach ( $columns as $column ) {
            // Output the column name and table name
            $table_column[$ex['con_name']][$column->TABLE_NAME][$column->COLUMN_NAME] =  $column->COLUMN_NAME ;
        }
        $new_wpdb->close();
    }

    define('GRAPHINA_PRO_EXTERNAL_DATABASE_TABLES', $table_column);
}
/**
 * Currently plugin version.
 * Start at version 1.2.4 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('GRAPHINA_PRO_CHARTS_FOR_ELEMENTOR_VERSION', '1.4.3');

// Require once the Composer Autoload
if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
} else {
    die('Something went wrong');
}
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-graphina-pro-charts-for-elementor-activator.php
 */
function Graphina_Pro_Charts_For_Elementor_activate()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-graphina-pro-charts-for-elementor-activator.php';
    Graphina_Pro_Charts_For_Elementor_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-graphina-pro-charts-for-elementor-deactivator.php
 */
function Graphina_Pro_Charts_For_Elementor_deactivate()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-graphina-pro-charts-for-elementor-deactivator.php';
    Graphina_Pro_Charts_For_Elementor_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'Graphina_Pro_Charts_For_Elementor_activate');
register_deactivation_hook(__FILE__, 'Graphina_Pro_Charts_For_Elementor_deactivate');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-graphina-pro-charts-for-elementor.php';
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.2.4
 */
function Graphina_Pro_Charts_For_Elementor_run()
{
    $plugin = new Graphina_Pro_Charts_For_Elementor();
    $plugin->run();
}
Graphina_Pro_Charts_For_Elementor_run();

/**
 * Notice
 */

add_action('admin_notices', function () {
    if (function_exists('graphina_pro_if_failed_load')) {
        graphina_pro_if_failed_load();
    }
});

add_action('init',function(){
    if (!function_exists('get_plugins')) {
        include_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
    $status = false ;
    $plugins = get_plugins();
    $basename = '';
    foreach ($plugins as $key => $value) {
        if($value['TextDomain'] === 'graphina-charts-for-elementor') {
            $basename = $key;
            if(is_plugin_active($key)) {
                $status  = true ;
            }
        }
    }
    if(!$status){
        deactivate_plugins(  GRAPHINA_PRO_BASE_PATH);
    }
    if (!defined('GRAPHINA_LITE_URL'))
        define('GRAPHINA_LITE_URL', plugin_dir_url($basename));
});

