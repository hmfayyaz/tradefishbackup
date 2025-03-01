<?php

/**
 * Sets up the plugin's hooks.
 *
 * @since 0.1.0
 * @package ethpress
 */

namespace losnappas\Ethpress;

defined('ABSPATH') || die;

use Error;
use losnappas\Ethpress\Upgrade;
use losnappas\Ethpress\Shortcodes\LoginButton;
use losnappas\Ethpress\Shortcodes\LinkButton;
use losnappas\Ethpress\Shortcodes\LoggedAccount;
use losnappas\Ethpress\Logger;
use losnappas\Ethpress\Front;

/**
 * Static functions only.
 *
 * @since 0.1.0
 */
class Plugin
{
	/**
	 * The default Wallet Connect project ID to keep plugin working after update to 2.0.0 version
	 * @since 2.0.0
	 */
	const WALLET_CONNECT_DEFAULT_PROJECT_ID = '8e6b5ffdcbc9794bf9f4a1952578365b';

	/**
	 * Table names. Don't forget to base_prefix. Base_ because it's user related and does not have separate tables for every site.
	 *
	 * @since 0.1.0
	 *
	 * @var array
	 */
	public static $tables = [
		'addresses' => 'ethpress_addresses',
	];

	/**
	 * This contains hook and filter assignments, etc.
	 *
	 * @since 0.1.0
	 */
	public static function attach_hooks()
	{
		//do_action('ethpress_attach_hooks');
		if (\losnappas\Ethpress\ethpress_fs()->can_use_premium_code__premium_only()) {
			\losnappas\Ethpress\UM::attach_hooks();
		}

		add_action('plugins_loaded', [__CLASS__, 'load_plugin_textdomain']);
		// When bbPress does `do_action('login_form')`, scripts aren't loaded without these 2.
		// If bbPress does that, then others will too.
		// Not sure what's going on, but this is an easy fix.
		add_action('login_form', [__CLASS__, 'register_scripts'], 9);
		add_action('login_form', [__CLASS__, 'login_enqueue_scripts']);
		add_action('login_form', [ETHPRESS_NS . '\Front', 'login_form']);

		add_action('register_form', [__CLASS__, 'register_scripts'], 9);
		add_action('register_form', [__CLASS__, 'login_enqueue_scripts']);
		add_action('register_form', [ETHPRESS_NS . '\Front', 'register_form']);

		$defopts = [
			'woocommerce_login_form_show' => '0',
			'woocommerce_register_form_show' => '0',
			'woocommerce_after_checkout_registration_form_show' => '0',
			'woocommerce_account_details_link_button_show' => '0',
		];
		$options = \get_site_option('ethpress', $defopts);
		if (\losnappas\Ethpress\ethpress_fs()->can_use_premium_code__premium_only()) {
			// ... premium only logic ...
			if (isset($options['woocommerce_login_form_show']) && true === boolval($options['woocommerce_login_form_show'])) {
				add_action('woocommerce_login_form', [__CLASS__, 'register_scripts'], 9);
				add_action('woocommerce_login_form', [__CLASS__, 'login_enqueue_scripts_and_styles']);
				add_action('woocommerce_login_form', [ETHPRESS_NS . '\Front', 'login_form']);
			}
			if (get_option('users_can_register') && isset($options['woocommerce_register_form_show']) && true === boolval($options['woocommerce_register_form_show'])) {
				add_action('woocommerce_register_form', [__CLASS__, 'register_scripts'], 9);
				add_action('woocommerce_register_form', [__CLASS__, 'login_enqueue_scripts_and_styles']);
				add_action('woocommerce_register_form', [ETHPRESS_NS . '\Front', 'register_form']);
			}
			if (get_option('users_can_register') && isset($options['woocommerce_after_checkout_registration_form_show']) && true === boolval($options['woocommerce_after_checkout_registration_form_show'])) {
				add_action('woocommerce_after_checkout_registration_form', [__CLASS__, 'register_scripts'], 9);
				add_action('woocommerce_after_checkout_registration_form', [__CLASS__, 'login_enqueue_scripts_and_styles']);
				add_action('woocommerce_after_checkout_registration_form', [ETHPRESS_NS . '\Front', 'register_form']);
			}
			if (isset($options['woocommerce_account_details_link_button_show']) && true === boolval($options['woocommerce_account_details_link_button_show'])) {
				add_action('woocommerce_edit_account_form', [__CLASS__, 'register_scripts'], 9);
				add_action('woocommerce_edit_account_form', [__CLASS__, 'login_enqueue_scripts_and_styles']);
				add_action('woocommerce_edit_account_form', [ETHPRESS_NS . '\Front', 'link_button']);
			}

			add_shortcode(LoggedAccount::$shortcode_name, [ETHPRESS_NS . '\Shortcodes\LoggedAccount', 'add_shortcode']);
		}
		/**
		 * Adding register_scripts to wp_enqueue_scripts for shortcode support.
		 * I think the performance impact of this is next to nothing.
		 *
		 * @since 0.5.0
		 */
		add_action('wp_enqueue_scripts', [__CLASS__, 'register_scripts'], 9);
		add_action('login_enqueue_scripts', [__CLASS__, 'register_scripts'], 9);
		// By default we only enqueue for login screen.
		add_action('login_enqueue_scripts', [__CLASS__, 'login_enqueue_scripts_and_styles']);

		add_action('wp_ajax_nopriv_ethpress_log_in', [ETHPRESS_NS . '\Login', 'verify_login']);
		add_action('wp_ajax_nopriv_ethpress_get_message', [ETHPRESS_NS . '\Login', 'get_message']);
		add_action('wp_ajax_ethpress_log_in', [ETHPRESS_NS . '\Login', 'verify_login']);
		add_action('wp_ajax_ethpress_get_message', [ETHPRESS_NS . '\Login', 'get_message']);
		add_action('deleted_user', [ETHPRESS_NS . '\Login', 'destroy']);

		add_action('ethpress_login', [ETHPRESS_NS . '\Login', 'attach_user_to_blog']);

		add_shortcode(LoginButton::$shortcode_name, [ETHPRESS_NS . '\Shortcodes\LoginButton', 'add_shortcode']);
		add_shortcode(LinkButton::$shortcode_name, [ETHPRESS_NS . '\Shortcodes\LinkButton', 'add_shortcode']);
		add_action(
			'widgets_init',
			[ETHPRESS_NS . '\Widgets\Button', 'widgets_init']
		);

		add_action('show_user_profile', [ETHPRESS_NS . '\Widgets\Button', 'show_user_profile']);
		if (is_admin() || is_network_admin()) {
			self::attach_admin_hooks();
		}
		add_filter('script_loader_tag', [__CLASS__, 'add_type_attribute'], 10, 3);
		add_action('admin_notices', [__CLASS__, 'wallet_connect_project_id_admin_notice_warn']);
	}

	public static function wallet_connect_project_id_admin_notice_warn()
	{
		$options = get_site_option('ethpress');
		if (empty($options['wallet_connect_project_id']) || $options['wallet_connect_project_id'] === self::WALLET_CONNECT_DEFAULT_PROJECT_ID) {
			$settings_link = '<a href="' .
				self::plugin_settings_link()
				. '" target="_blank">';
			$msg = sprintf(
				__('%1$sImportant:%2$s %3$s must be set in the EthPress plugin %6$ssettings%5$s. You can get it from %4$sWalletConnect.com%5$s', 'ethpress'),
				'<strong>',
				'</strong>',
				__("WalletConnect Project ID", 'ethpress'),
				'<a href="https://cloud.walletconnect.com/sign-in" target="_blank">',
				'</a>',
				$settings_link
			);
			echo '<div class="notice notice-warning">
			  <p>' . $msg . '</p>
			  </div>';
		}
	}

	public static function plugin_settings_link()
	{
		$url =
			esc_url(
				add_query_arg(
					'page',
					'ethpress',
					get_admin_url() . 'options-general.php'
				)
			);
		if (is_multisite() && current_user_can('manage_network_options')) {
			$url =
				esc_url(
					add_query_arg(
						'page',
						'ethpress',
						network_admin_url() . 'settings.php'
					)
				);
		}
		return esc_attr($url);
	}

	public static function add_type_attribute($tag, $handle, $src)
	{
		// if not your script, do nothing and return original $tag
		if ('ethpress-login-front' !== $handle) {
			return $tag;
		}

		// change the script tag by adding type="module" and return it.
		//$tag = '<script type="module" src="' . esc_url($src) . '"></script>';
		$tag = str_replace('<script', '<script type="module"', $tag);
		return $tag;
	}

	/**
	 * Attaches admin hooks for options page.
	 *
	 * @since 0.3.0
	 */
	public static function attach_admin_hooks()
	{
		$plugin = plugin_basename(ETHPRESS_FILE);
		add_filter("plugin_action_links_$plugin", [ETHPRESS_NS . '\Admin\Options', 'plugin_action_links']);

		if (is_multisite()) {
			add_action('network_admin_menu', [ETHPRESS_NS . '\Admin\Options', 'admin_menu']);
		} else {
			add_action('admin_menu', [ETHPRESS_NS . '\Admin\Options', 'admin_menu']);
		}
	}

	/**
	 * Registers the scripts so they're available in login_enqueue_scripts and wp_enqueue_scripts.
	 *
	 * @since 0.1.1
	 */
	public static function register_scripts()
	{
		if (wp_script_is('ethpress-login-modal', 'registered')) {
			return;
		}

		$base_url = plugin_dir_url(ETHPRESS_FILE);
		$path  = plugin_dir_path(ETHPRESS_FILE);
		// Styles for just the button. Only shown in login screen since 0.7.0.
		wp_register_style(
			'ethpress-login',
			$base_url . 'public/css/login.css',
			[],
			'1.0.0'
		);
		/**
		 * Version 0.5.0 removed the info popup and thus modified html. This fixes css while keeping 'ethpress-login-front' script functional.
		 */
		wp_register_style(
			'ethpress-login-front',
			$base_url . 'public/css/login-fix.css',
			['ethpress-login'],
			'1.0.0'
		);

		$files = scandir($path . "/public/dist/assets/");
		if (!$files) {
			return;
		}
		foreach ($files as $filename) {
			$pos = strripos($filename, 'index');

			if ($pos === false) {
				continue;
			}
			// Configures Web3Login to work. Provides ethpress.metamask.connect.
			wp_register_script(
				'ethpress-login-modal',
				//$base_url . 'public/dist/main.min.js',
				$base_url . 'public/dist/assets/' . $filename,
				[],
				'3',
				false
			);
			// Adds event listener to buttons.
			wp_register_script(
				'ethpress-login-front',
				//$base_url . 'public/dist/login-front.min.js',
				$base_url . 'public/dist/assets/' . $filename,
				['ethpress-login-modal'],
				'1.4.0',
				true
			);
		}

		$ajax_url        = admin_url('admin-ajax.php');
		$login_nonce     = wp_create_nonce('ethpress_log_in');
		$get_nonce_nonce = wp_create_nonce('ethpress_get_message');
		$options = get_site_option('ethpress');
		$wallet_connect_project_id = empty($options['wallet_connect_project_id']) ? self::WALLET_CONNECT_DEFAULT_PROJECT_ID : esc_attr($options['wallet_connect_project_id']);
		$ethpress_theme_mode = isset($options['theme_mode']) ? $options['theme_mode'] : "light";
		$theme_mode = esc_attr($ethpress_theme_mode);
		$inline_script   = [
			'wallet_connect_project_id'          => $wallet_connect_project_id,
			'theme_mode'       => $theme_mode,
			'ajaxUrl'          => $ajax_url,
			'loginNonce'       => $login_nonce,
			'getNonceNonce'    => $get_nonce_nonce,
			'loginAction'      => 'ethpress_log_in',
			'getMessageAction' => 'ethpress_get_message',
			'l10n'             => [
				'calltoaction'             => esc_html__('Choose your login method', 'ethpress'),
				'nodetect'                 => esc_html__('Error: cannot detect crypto wallet', 'ethpress'),
				'permission'               => esc_html__('Waiting for your permission', 'ethpress'),
				'fetching'                 => esc_html__('Fetching login phrase...', 'ethpress'),
				'awaiting'                 => esc_html__('Waiting for your signature', 'ethpress'),
				'verifying'                => esc_html__('Verifying signature...', 'ethpress'),
				'loggedin'                 => esc_html__('Logged in', 'ethpress'),
				'aborted'                  => esc_html__('Login aborted', 'ethpress'),
				'heading'                  => esc_html__('Log In', 'ethpress'),
				'walletconnectButtonTitle' => esc_html__('Scan a QR code with your wallet, https://walletconnect.org', 'ethpress'),
				'metamaskButtonTitle'      => esc_html__('Browser add-on and mobile app, https://metamask.io', 'ethpress'),
				'missingSignature'      => esc_html__('Missing signature', 'ethpress'),
			],
		];
		/**
		 * Filters variables passed to Web3Login component.
		 *
		 * @since 0.7.0
		 *
		 * @param array $inline_script An associated array, to be json encoded.
		 */
		$inline_script = apply_filters('ethpress_login_inline_script', $inline_script);

		// wp_localize_script is for l10n, but, I mean, same thing.
		wp_add_inline_script(
			'ethpress-login-modal',
			'var ethpressLoginWP = ' . wp_json_encode($inline_script) . ';',
			'before'
		);
	}

	/**
	 * Attached to hook.
	 *
	 * @since 0.1.0
	 */
	public static function login_enqueue_scripts()
	{
		// Only enqueue the -front ones. They'll pull the other ones. This way it's easier to remove them.
		wp_enqueue_script('ethpress-login-front');
	}

	/**
	 * Attached to hook.
	 *
	 * Used in separating styles and scripts, because widget style gets real messy with the css,
	 * since it is mixed with page styles.
	 *
	 * @since 0.7.0
	 */
	public static function login_enqueue_scripts_and_styles()
	{
		self::login_enqueue_scripts();
		wp_enqueue_style('ethpress-login-front');
	}

	/**
	 * Sends an error message if trying to log in with MetaMask while logged in.
	 *
	 * @since 0.1.0
	 * @deprecated
	 */
	public static function logged_in_user_error()
	{
		wp_send_json_error(esc_html__('Log out first', 'ethpress'));
	}

	/**
	 * Load translation files.
	 *
	 * @since 0.1.0
	 */
	public static function load_plugin_textdomain()
	{
		$path  = dirname(plugin_basename(ETHPRESS_FILE));
		$path .= '/languages';
		load_plugin_textdomain('ethpress', false, $path);
	}

	/**
	 * Is called from uninstall.php
	 *
	 * @since 0.1.0
	 * @since 1.1.0 No longer deleting the ethpress table.
	 */
	public static function uninstall()
	{
		defined('WP_UNINSTALL_PLUGIN') || die;

		delete_option('ethpress');
		Logger::log("Plugin::uninstall: delete options");
	}

	/**
	 * Creates database tables on plugin activation.
	 *
	 * @since 0.1.0
	 */
	public static function activate()
	{
		global $wpdb;

		// $table      = $wpdb->base_prefix . self::$tables['addresses'];
		$db_version = '1.1';
		$api_url    = '';
		$woocommerce_login_form_show = false;
		$woocommerce_register_form_show = false;
		$woocommerce_after_checkout_registration_form_show = false;
		$woocommerce_account_details_link_button_show = false;
		$login_button_label = '';
		$link_button_label = '';
		$register_button_label = '';
		$redirect_url    = '';
		if (\losnappas\Ethpress\ethpress_fs()->can_use_premium_code__premium_only()) {
			$woocommerce_login_form_show = true;
			$woocommerce_register_form_show = true;
			$woocommerce_after_checkout_registration_form_show = true;
			$woocommerce_account_details_link_button_show = true;
			$login_button_label = esc_html__('Log In With a Crypto Wallet', 'ethpress');
			$link_button_label = esc_html__('Link Your Crypto Wallets', 'ethpress');
			$register_button_label = esc_html__('Register With a Crypto Wallet', 'ethpress');
		}
		$opts       = [
			'db_version' => $db_version,
			'api_url'    => $api_url,
			'woocommerce_login_form_show' => $woocommerce_login_form_show,
			'woocommerce_register_form_show' => $woocommerce_register_form_show,
			'woocommerce_after_checkout_registration_form_show' => $woocommerce_after_checkout_registration_form_show,
			'woocommerce_account_details_link_button_show' => $woocommerce_account_details_link_button_show,
			'login_button_label' => $login_button_label,
			'link_button_label' => $link_button_label,
			'register_button_label' => $register_button_label,
			'redirect_url'    => $redirect_url,
		];
		/**
		 * Ethpress' settings.
		 *
		 * @since 0.1.0
		 *
		 * Settings: db_version (internal), api_url: see Signature.php.
		 */
		add_site_option('ethpress', $opts);
		Logger::log("Plugin::activate: options = " . print_r($opts, true));

		require_once trailingslashit(ABSPATH) . 'wp-admin/includes/upgrade.php';

		// 		// No multisite stuff here because user table only exists once.
		// 		$charset_collate = '';
		// 		if ( $wpdb->has_cap( 'collation' ) ) {
		// 			$charset_collate = $wpdb->get_charset_collate();
		// 		}
		// 		$sql = "
		// CREATE TABLE {$table} (
		//   id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
		//   name varchar(191) NOT NULL,
		//   user_id BIGINT UNSIGNED NOT NULL,
		//   coin varchar(15) DEFAULT NULL,
		//   date datetime DEFAULT '2000-01-01 00:00:00',
		//   modified datetime DEFAULT '2000-01-01 00:00:00',
		//   PRIMARY KEY  (id),
		//   UNIQUE KEY name (name),
		//   KEY user_id (user_id)
		// ) $charset_collate;";
		// 		\dbDelta( $sql );

		Upgrade::handle_upgrades();
	}
}
