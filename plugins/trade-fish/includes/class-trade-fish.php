<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://abc.com
 * @since      1.0.0
 *
 * @package    Trade_Fish
 * @subpackage Trade_Fish/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Trade_Fish
 * @subpackage Trade_Fish/includes
 * @author     Hztech <obaidullah@hztech.biz>
 */
class Trade_Fish
{

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Trade_Fish_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct()
	{
		if (defined('TRADE_FISH_VERSION')) {
			$this->version = TRADE_FISH_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'trade-fish';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Trade_Fish_Loader. Orchestrates the hooks of the plugin.
	 * - Trade_Fish_i18n. Defines internationalization functionality.
	 * - Trade_Fish_Admin. Defines all hooks for the admin area.
	 * - Trade_Fish_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies()
	{

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-trade-fish-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-trade-fish-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-trade-fish-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-trade-fish-public.php';

		$this->loader = new Trade_Fish_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Trade_Fish_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale()
	{

		$plugin_i18n = new Trade_Fish_i18n();

		$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks()
	{

		$plugin_admin = new Trade_Fish_Admin($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
		$this->loader->add_action('init', $plugin_admin, 'signals_post_type');
		$this->loader->add_action('edit_form_after_title', $plugin_admin, 'add_signals_title_field');
		$this->loader->add_action('add_meta_boxes', $plugin_admin, 'add_signal_details_meta_box');
		$this->loader->add_action('save_post', $plugin_admin, 'update_post_meta',10,3);
        $this->loader->add_action('wp_ajax_get_signals_data', $plugin_admin, 'get_signals_data');
		$this->loader->add_action('wp_ajax_nopriv_get_signals_data', $plugin_admin, 'get_signals_data');
		$this->loader->add_filter('manage_signals_posts_columns', $plugin_admin, 'custom_column_header');
		$this->loader->add_action('manage_signals_posts_custom_column', $plugin_admin, 'custom_columns_content',10,2);
		$this->loader->add_action('wp_ajax_save_signal_result', $plugin_admin, 'save_signal_result');
		$this->loader->add_action('wp_ajax_nopriv_save_signal_result', $plugin_admin, 'save_signal_result');
        $this->loader->add_action('rest_api_init', $plugin_admin, 'custom_rest_api_history');
        $this->loader->add_action('restrict_manage_posts', $plugin_admin, 'custom_post_type_filter');
        $this->loader->add_action('pre_get_posts', $plugin_admin, 'custom_signals_query');
//        $this->loader->add_action('posts_results', $plugin_admin, 'custom_signals_posts');


        $this->loader->add_action('wp_ajax_update_ticker', $plugin_admin, 'update_ticker');
        $this->loader->add_action('wp_ajax_nopriv_update_ticker', $plugin_admin, 'update_ticker');


        $this->loader->add_action('admin_footer', $plugin_admin,'custom_admin_script');



    }

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks()
	{

		$plugin_public = new Trade_Fish_Public($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
        $this->loader->add_action('rest_api_init', $plugin_public, 'custom_rest_api_history');

    }

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run()
	{
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name()
	{
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Trade_Fish_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader()
	{
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version()
	{
		return $this->version;
	}
}
