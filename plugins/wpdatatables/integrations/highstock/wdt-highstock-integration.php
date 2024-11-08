<?php

namespace WDTHighStockIntegration;

// Full path to the WDT HighStock root directory
define('WDT_HS_ROOT_PATH', WDT_INTEGRATIONS_URL . 'highstock/');
// Path to the assets directory of the HighStock integration
define('WDT_HS_ASSETS_PATH', WDT_HS_ROOT_PATH . 'assets/');

/**
 * Class HighStockIntegration
 *
 * @package WDTHighStockIntegration
 */
class HighStockIntegration
{
    public static function init()
    {
        // Display the Highstock chart picker in the Chart creation wizard
        add_action('wpdatatables_add_chart_picker', array('WDTHighStockIntegration\HighStockIntegration', 'addHighStockChartPicker'));

        // Enqueue scripts
        add_action('wpdatatables_enqueue_chart_wizard_scripts', array('WDTHighStockIntegration\HighStockIntegration', 'enqueueScripts'));
    }

    /**
     * Adds the HighStock chart type picker once "HighStock" is selected as the engine
     */
    public static function addHighStockChartPicker()
    {
        ob_start();
        include 'templates/highstock_chart_picker.inc.php';
        $highStockChartsPicker = ob_get_contents();
        ob_end_clean();
        echo $highStockChartsPicker;

        // Hide the "HighStock not available for basic licences" notification
        wp_enqueue_style('wdt-highstock-css', WDT_HS_ASSETS_PATH . 'css/wdt-highstock.css', array(), WDT_CURRENT_VERSION);

    }

    public static function enqueueScripts()
    {
        $highChartStockSource = get_option('wdtHighChartStableVersion') ? WDT_HS_ASSETS_PATH . 'js/highcharts-stock.js' : '//code.highcharts.com/stock/modules/stock.js';
        wp_enqueue_script('wdt-highstock', $highChartStockSource, array(), WDT_CURRENT_VERSION, true);
        wp_enqueue_script('wdt-wp-highstock', WDT_HS_ASSETS_PATH . 'js/wdt.highstock.js', array(), WDT_CURRENT_VERSION, true);
    }
}

HighStockIntegration::init();