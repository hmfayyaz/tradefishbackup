<?php
/**
 * Plugin Name: 		Coinpress
 * Plugin URI:          https://coinpress.blocksera.com
 * Description: 		Coinmarketcap Prices & Marketcap
 * Author: 				Blocksera
 * Author URI:			https://blocksera.com
 * Version: 			2.3.3
 * Requires at least:   4.3.0
 * Requires PHP:        5.6
 * License: 			GPL v3
 * Text Domain:			coinpress
 * Domain Path: 		/languages
 *
 * Coinpress
 * Copyright (C) 2020  Blocksera Technologies
**/

if (!defined('ABSPATH')) { exit; }

define('COINMC_VERSION', '2.3.3');
define('COINMC_PATH', plugin_dir_path(__FILE__));
define('COINMC_URL', plugin_dir_url(__FILE__));

require_once COINMC_PATH . 'includes/all.php';

if (!class_exists('Coinmarketcap_Prices')) {

    class Coinmarketcap_Prices {
        public $data;
        public $options;
        public $providers;
        public $dynamic_columns;
        public $updater;
        public $wpdb;
        public $tablename;
        public $dtablename;
        public $pages;
        public $watchlist;
        public $extensions;

        public function __construct() {
            global $wpdb;

            $this->data = new CoinpressData();

            $this->options = $this->data->options;
            $this->providers = $this->data->providers;
            $this->dynamic_columns = apply_filters('mcw_dynamic_columns', $this->data->dynamic_columns);
            $this->options['config'] = apply_filters('coinmc_get_config', array_merge($this->data->config, get_option('coinmc_config', array())));
            $this->updater = new Blocksera_Updater(__FILE__, 'coinpress', 'ChhBRVEmEqCNm0oq2Td3', $this->options['config']['license_key']);
            $this->updater->checker->addResultFilter(array($this, 'refreshLicenseFromPluginInfo'));
            
            $this->wpdb = $wpdb;
            $this->tablename = $this->wpdb->base_prefix . "mcw_coins";
            $this->dtablename = $this->wpdb->base_prefix . "coinmc_details";

            $this->init();
            $this->includes();

            $this->pages = new Pages($this->options['config']);
            $this->watchlist = new Watchlist($this->options['config']);

            register_activation_hook(__FILE__, array($this, 'activate'));
            register_deactivation_hook(__FILE__, array($this, 'deactivate'));
        }

        public function create_tables() {
            global $wpdb;
            $charset_collate = $wpdb->get_charset_collate();

            $coinstable = "CREATE TABLE IF NOT EXISTS `{$this->tablename}` (
                `id` mediumint(9) NOT NULL AUTO_INCREMENT,
                `name` varchar(100) NOT NULL,
                `symbol` varchar(10) NOT NULL,
                `slug` varchar(100) NOT NULL,
                `img` varchar(200) NOT NULL,
                `rank` int(5) NOT NULL,
                `price_usd` decimal(24,14) NOT NULL,
                `price_btc` decimal(10,8) NOT NULL,
                `volume_usd_24h` decimal(22,2) NOT NULL,
                `market_cap_usd` decimal(22,2) NOT NULL,
                `high_24h` decimal(20,10) NOT NULL,
                `low_24h` decimal(20,10) NOT NULL,
                `available_supply` decimal(22,2) NOT NULL,
                `total_supply` decimal(22,2) NOT NULL,
                `ath` decimal(20,10) NOT NULL,
                `ath_date` int(11) UNSIGNED NOT NULL,
                `price_change_24h` decimal(20,10) NOT NULL,
                `percent_change_1h` decimal(7,2) NOT NULL,
                `percent_change_24h` decimal(7,2) NOT NULL,
                `percent_change_7d` decimal(7,2) NOT NULL,
                `percent_change_30d` decimal(7,2) NOT NULL,
                `weekly` longtext NOT NULL,
                `weekly_expire` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `keywords` varchar(255) NOT NULL,
                `custom` text NULL,
                UNIQUE KEY `id` (`id`),
                UNIQUE (`slug`)
            ) {$charset_collate};";
            
            $coindetailstable = "CREATE TABLE IF NOT EXISTS `{$this->dtablename}` (
                `id` mediumint(9) NOT NULL AUTO_INCREMENT,
                `slug` varchar(100) NOT NULL,
                `symbol` varchar(10) NOT NULL,
                `description` TEXT NOT NULL,
                `meta_description` TEXT NOT NULL,
                `website` varchar(255) NOT NULL,
                `explorer` varchar(255) NOT NULL,
                `facebook` varchar(100) NOT NULL,
                `twitter` varchar(100) NOT NULL,
                `reddit` varchar(100) NOT NULL,
                `youtube` varchar(100) NOT NULL,
                `source` varchar(255) NOT NULL,
                `whitepaper` varchar(255) NOT NULL,
                UNIQUE KEY `id` (`id`),
                UNIQUE (`slug`)
            ) {$charset_collate};";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($coinstable);
            dbDelta($coindetailstable);
        }

        public function activate() {
            
            $this->create_tables();
            $this->save_metadata();

            $post = [
                'post_title' => __('Cryptocurrency Prices & Marketcap', 'coinpress'),
                'post_type' => 'page',
                'post_status' => 'publish',
                'post_author' => get_current_user_id(),
                'post_content' => file_get_contents(COINMC_PATH . '/includes/postcontent.txt')
            ];

            if ($this->options['config']['page'] == 0) {
                $postid = wp_insert_post($post);
                $this->options['config']['page'] = $postid;
            }
            
            update_option('coinmc_config', $this->options['config']);
            update_option('coinmc_permalinks_flushed', 0);
        }

        public function deactivate() {
            delete_transient('mcw-datatime');
            delete_transient('coinmc-global');
            delete_transient('coinmc-currencies');
            flush_rewrite_rules();
        }

        public function fetch_coins($config) {

            $cache = get_transient('mcw-datatime');
            
            $api_interval = ($config['api'] == 'coingecko') ? 900 : $config['api_interval'];

            if ($cache === false || $cache < (time() - $api_interval)) {
                
                switch ($config['api']) {

                    case 'coingecko':
    
                        $request = wp_remote_get('https://api.blocksera.com/v1/tickers');
    
                        if (is_wp_error($request) || wp_remote_retrieve_response_code($request) != 200) {
                            $this->wpdb->get_results("SELECT `slug` FROM `{$this->tablename}`");

                            if ($this->wpdb->num_rows > 0) {
                                set_transient('mcw-datatime', time(), 60);
                            }
                            return false;
                        }

                        $body = wp_remote_retrieve_body($request);
                        $data = json_decode($body);
    
                        if (!empty($data)) {
                
                                $this->wpdb->query("TRUNCATE `{$this->tablename}`");
                
                                $btc_price = $data[0]->current_price;

                                $values = [];
                
                                foreach ($data as $coin) {
                                    if (!($coin->market_cap === null || $coin->market_cap_rank === null)) {
                                        $coin->price_btc = $coin->current_price / $btc_price;
                                        $coin->image = strpos($coin->image, 'coingecko.com') ? strtok($coin->image, '?') : COINMC_URL . 'assets/public/img/missing.png';
                                        $values[] = array($coin->name, strtoupper($coin->symbol), $coin->id, $coin->image, $coin->market_cap_rank, floatval($coin->current_price), floatval($coin->price_btc), floatval($coin->total_volume), floatval($coin->market_cap), floatval($coin->high_24h), floatval($coin->low_24h), floatval($coin->circulating_supply), floatval($coin->total_supply), floatval($coin->ath), strtotime($coin->ath_date), floatval($coin->price_change_24h), floatval($coin->price_change_percentage_1h), floatval($coin->price_change_percentage_24h), floatval($coin->price_change_percentage_7d), floatval($coin->price_change_percentage_30d), gmdate("Y-m-d H:i:s"));
                                    }
                                }
                
                                $values = array_chunk($values, 100, true);
                
                                foreach ($values as $chunk) {
                                    $placeholder = "(%s, %s, %s, %s, %d, %0.14f, %0.8f, %0.2f, %0.2f, %0.10f, %0.10f, %0.2f, %0.2f, %0.10f, %d, %0.10f, %0.2f, %0.2f, %0.2f, %0.2f, %s)";
                                    $query = "INSERT IGNORE INTO `{$this->tablename}` (`name`, `symbol`, `slug`, `img`, `rank`, `price_usd`, `price_btc`, `volume_usd_24h`, `market_cap_usd`, `high_24h`, `low_24h`, `available_supply`, `total_supply`, `ath`, `ath_date`, `price_change_24h`, `percent_change_1h`, `percent_change_24h`, `percent_change_7d`, `percent_change_30d`, `weekly_expire`) VALUES ";
                                    $query .= implode(", ", array_fill(0, count($chunk), $placeholder));
                                    $this->wpdb->query($this->wpdb->prepare($query, call_user_func_array('array_merge', $chunk)));
                                }
                                set_transient('mcw-datatime', time());
                        }
    
                        break;
    
                    case 'coinmarketcap':
                        $limit = apply_filters('cmc_coin_limit', 5000);
                        $headers = array('headers' => array('X-CMC_PRO_API_KEY' => $config['api_key']));
                        $request = wp_remote_get('https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest?limit='.$limit.'', $headers);

                        if (is_wp_error($request) || wp_remote_retrieve_response_code($request) != 200) {
                            $this->wpdb->get_results("SELECT `slug` FROM `{$this->tablename}`");

                            if ($this->wpdb->num_rows > 0) {
                                set_transient('mcw-datatime', time(), 60);
                            }
                            return false;
                        }

                        $body = wp_remote_retrieve_body($request);
                        $data = json_decode($body);
    
                        if (!empty($data)) {
            
                            if ($data->status->error_code == 0) {
            
                                $this->wpdb->query("TRUNCATE `{$this->tablename}`");
            
                                $btc_price = $data->data[0]->quote->USD->price;

                                $values = [];
            
                                foreach($data->data as $coin) {
                                    if ($coin->cmc_rank !== null) {
                                        $coin->price_btc = $coin->quote->USD->price / $btc_price;
                                        $coin->image = 'https://s2.coinmarketcap.com/static/img/coins/64x64/' . $coin->id . '.png';
                                        $values[] = array($coin->name, strtoupper($coin->symbol), $coin->slug, $coin->image, $coin->cmc_rank, floatval($coin->quote->USD->price), floatval($coin->price_btc), floatval($coin->quote->USD->volume_24h), floatval($coin->quote->USD->market_cap), 0.00, 0.00, floatval($coin->circulating_supply), floatval($coin->max_supply), 0.00, strtotime('now'), 0.00, floatval($coin->quote->USD->percent_change_1h), floatval($coin->quote->USD->percent_change_24h), floatval($coin->quote->USD->percent_change_7d), null, gmdate("Y-m-d H:i:s"));
                                    }
                                }
            
                                $values = array_chunk($values, 100, true);
            
                                foreach ($values as $chunk) {
                                    $placeholder = "(%s, %s, %s, %s, %d, %0.14f, %0.8f, %0.2f, %0.2f, %0.10f, %0.10f, %0.2f, %0.2f, %0.10f, %d, %0.10f, %0.2f, %0.2f, %0.2f, %0.2f, %s)";
                                    $query = "INSERT IGNORE INTO `{$this->tablename}` (`name`, `symbol`, `slug`, `img`, `rank`, `price_usd`, `price_btc`, `volume_usd_24h`, `market_cap_usd`, `high_24h`, `low_24h`, `available_supply`, `total_supply`, `ath`, `ath_date`, `price_change_24h`, `percent_change_1h`, `percent_change_24h`, `percent_change_7d`, `percent_change_30d`, `weekly_expire`) VALUES ";
                                    $query .= implode(", ", array_fill(0, count($chunk), $placeholder));
                                    $this->wpdb->query($this->wpdb->prepare($query, call_user_func_array('array_merge', $chunk)));
                                }
                                set_transient('mcw-datatime', time());
                            }
        
                        }
    
                        break;
                }

            }

        }

        public function after_fetch_coins() {

            $cdata = get_transient('mcw-custom-data');

            if ($cdata !== false && sizeof($cdata) > 0) {
                
                $chunks = array_chunk($cdata, 100, true);

                foreach ($chunks as $chunk) {
                    
                    $slugs = array();
                    $sets = array();
                    $cases = array();

                    foreach ($chunk as $coin) {
                        $slugs[] = $coin['slug'];

                        foreach ($coin as $field => $value) {
                            if (in_array($field, $this->dynamic_columns) && $field !== 'slug') {
                                $cases[$field][] = "WHEN `slug` = '" . $coin['slug'] . "' THEN '" . esc_sql($value) . "'";
                            }
                        }

                    }

                    foreach ($cases as $field => $value) {
                        $sets[] = "`" . $field . "` = (CASE " . implode(" ", $value) . " END)";
                    }

                    $this->wpdb->query("UPDATE `{$this->tablename}` SET " . implode(", ", $sets) . " WHERE `slug` IN ('" . implode("', '", $slugs) . "')");
                }

            }

        }

        public function coinsyms() {

            do_action('mcw_fetch_coins', $this->options['config']);

            $data = $this->wpdb->get_results("SELECT `name`, `symbol`, `slug` FROM `{$this->tablename}` ORDER BY `rank` ASC");

            $coinsyms = array();
            
            foreach($data as $coin) {
                $coinsyms[$coin->slug] = array('name' => $coin->name, 'symbol' => $coin->symbol, 'slug' => $coin->slug);
            }
            return $coinsyms;

        }
        
        public function get_currencies() {
            $exrates = get_transient('coinmc-currencies');

            if ($exrates === false) {
                $request = wp_remote_get('https://api.blocksera.com/v1/exrates');

                if (is_wp_error($request) || wp_remote_retrieve_response_code($request) != 200) {
                    return false;
                }

                $body = wp_remote_retrieve_body($request);
                $exrates = json_decode($body);

                if (!empty($exrates)) {
                    set_transient('coinmc-currencies', $exrates, DAY_IN_SECONDS);
                }
            }

            return apply_filters('mcw_get_currencies', $exrates);
        }

        public function getexrate($currency) {
            switch ($currency) {
                case 'USD':
                    return 1;
                case 'BTC':
                    $coinprice = $this->wpdb->get_var("SELECT `price_usd` FROM `$this->tablename` WHERE `symbol` = '$currency'");
                    return floatval($coinprice);
                default:
                    $currencies = $this->get_currencies();
                    return $currencies->{$currency};
            }
        }
        
        public function get_global($global) {

            $global = get_transient('coinmc-global');
            
            if ($global === false) {

                switch ($this->options['config']['api']) {

                    case 'coingecko':

                        $request = wp_remote_get('https://api.coingecko.com/api/v3/global');
                        $body = wp_remote_retrieve_body($request);
                        $data = json_decode($body, true);

                        if ($data) {
                            $global = array(
                                'active_cryptocurrencies' => $data['data']['active_cryptocurrencies'],
                                'markets' => $data['data']['markets'],
                                'marketcap' => $data['data']['total_market_cap']['usd'],
                                'marketcap_change' => $data['data']['market_cap_change_percentage_24h_usd'],
                                '24hvol' => $data['data']['total_volume']['usd'],
                                'btcdominance' => $data['data']['market_cap_percentage']['btc']
                            );
                            set_transient('coinmc-global', $global, DAY_IN_SECONDS);
                        }

                        break;
                    
                    case 'coinmarketcap':
                    
                        $request = wp_remote_get('https://pro-api.coinmarketcap.com/v1/global-metrics/quotes/latest', array('timeout' => 5, 'headers' => array('X-CMC_PRO_API_KEY' => $this->options['config']['api_key'])));
                        $body = wp_remote_retrieve_body($request);
                        $data = json_decode($body, true);

                        if ($data) {
                            $global = array(
                                'active_cryptocurrencies' => $data['data']['active_cryptocurrencies'],
                                'markets' => $data['data']['active_exchanges'],
                                'marketcap' => $data['data']['quote']['USD']['total_market_cap'],
                                '24hvol' => $data['data']['quote']['USD']['total_volume_24h'],
                                'btcdominance' => $data['data']['btc_dominance']
                            );
                            set_transient('coinmc-global', $global, DAY_IN_SECONDS);
                        }

                        break;
                }

            }
            
            return $global;
        }

        public function includes() {
            add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));
            add_action('wp_enqueue_scripts', array($this, 'frontend_scripts'), 99999);
        }

        public function init() {

            require_once COINMC_PATH . 'includes/upgrade.php';

            $shortcode = new Coinmarketcap_Shortcodes();
            $shortcode->config = $this->options['config'];

            $this->check_extensions();

            add_shortcode('coinmc', array($this, 'shortcode'));
            add_shortcode('coinmc-tabs', array($shortcode, 'single_tabs'));
            add_shortcode('coinmc-tab', array($shortcode, 'single_tab'));
            add_action('init', array($this, 'create_post_type'));
            add_action('save_post', array($this, 'save_widget'));
            add_action('admin_init', array($this, 'display_notices'));
            add_action('admin_menu', array($this, 'register_menu'), 12);
            add_action('add_meta_boxes', array($this, 'add_post_editor'));
            add_action('plugins_loaded', array($this, 'translations'));
            add_action('wp_footer', array($this, 'ticker_sticky'));
            add_action('wp_ajax_coinmc_table', array($this, 'ajax_tables'));
            add_action('wp_ajax_coinmc_clear_cache', array($this, 'clear_cache'));
            add_action('wp_ajax_nopriv_coinmc_table', array($this, 'ajax_tables'));
            add_action('wp_ajax_reddit', array($this, 'ajax_reddit'));
            add_action('wp_ajax_nopriv_reddit', array($this, 'ajax_reddit'));
            add_action('wp_ajax_coinpress_sitemap', array($this, 'generate_sitemap'));
            add_action('wp_ajax_coinpress_reload', array($this, 'reload_content'));
            add_action('admin_post_coinmc_save_settings', array($this, 'save_settings'));
            add_action('admin_post_save_details', array($this, 'save_details'));
            add_filter('manage_coinmc_posts_columns', array($this, 'columns_content'));
            add_action('manage_coinmc_posts_custom_column', array($this, 'custom_column'), 10, 2);
            add_action('mcw_fetch_coins', array($this, 'fetch_coins'), 10, 1);
            add_action('mcw_fetch_coins', array($this, 'after_fetch_coins'), 20, 0);
            add_action('mcw_save_custom_data', array($this, 'save_custom_data'), 10, 0);
            add_filter('block_get_coinlinks', array($this, 'get_coinlinks'), 10, 2);
            add_filter('coinmc_chart_color', array($this, 'change_chart_color'), 10, 3);
            add_filter('coinmc_global', array($this, 'get_global'), 10);
            add_filter('plugin_row_meta', array($this, 'insert_plugin_row_meta'), 10, 2);
            add_filter('coinmc_virtual_asset', array($this, 'get_asset_match'), 10, 1);
            add_filter('icl_ls_languages', array($this, 'wpml_dropDown_for_coinPage'), 10, 1);

            // ajax to validate RSS feeds            
            add_action('wp_ajax_validate_rss',        array($this,'validate_rss'));
            add_action('wp_ajax_nopriv_validate_rss', array($this,'validate_rss'));
        }

        public function validate_rss(){
            $response = [];
            $response['status'] = 'sucess';
            if(isset($_POST['rss_feeds'])){
                $feeds = explode("\n", $_POST['rss_feeds']);
                if(count($feeds) > 0){
                    foreach($feeds as $index => $feed){
                        $rss = fetch_feed($feed);
                        if (is_wp_error($rss)) {
                            $response['invalid'][] = $feed;
                        }
                    }
                    $response['status']  = (isset($response['invalid']) ? 'invalid' : 'sucess');
                }
            }
            wp_send_json($response);
        }
        
        public function get_asset_match($asset) {
            global $wp;
            
            $current_url = add_query_arg(array(), $wp->request);
            if (!empty($this->options['config']['link'])) {
                $link = str_replace(site_url(), '', $this->options['config']['link']);
                $link = str_replace('/', '\/', ltrim($link, '/'));
                $regex = '/^' . str_replace('[symbol]', '([a-zA-Z0-9-\.=\^\$]+)', $link) . '?$/';
                preg_match($regex, $current_url, $matches);
                if (isset($matches[1])) {
                    return $matches[1];
                }
            }
            
            return $asset;
        }

        public function is_coinpage(){
            global $wpdb, $post, $wp, $sitepress;
            if(!$post) return;

            if($sitepress){
                $default_language = $sitepress->get_default_language();
                $id = icl_object_id($post->ID, 'page', false, $default_language);
                return $id == $this->options['config']['page'] || $post->ID == $this->options['config']['page'] && $this->options['config']['page'] != 0;
            }
            return $post->ID == $this->options['config']['page'] && $this->options['config']['page'] != 0;
        }

        public function wpml_dropDown_for_coinPage($array) {
            global $post, $wp, $sitepress;

            if(!is_admin() && $sitepress){
                $default_language = $sitepress->get_default_language();
                $id = icl_object_id($post->ID, 'page', false, $default_language);
                $current_language = $sitepress->get_current_language();


                $current_url = add_query_arg(array(), $wp->request);

                if($this->pages->is_coinpage()){
                    foreach($array as $lan => $data){

                        $sitepress->switch_lang( $data['code'] );

                        $translated_url = get_permalink( $id );
                        $slug = get_post_field( 'post_name', $id);
                        $translated_url = str_replace($slug, $current_url, $translated_url);
                        $array[$lan]['url'] = $translated_url;

                        $sitepress->switch_lang( $current_language );
                    }
                }
            }

            return $array;
        }

        public function insert_plugin_row_meta($links, $file) {
            if (plugin_basename(__FILE__) == $file) {
                // docs
                $links[] = sprintf('<a href="https://docs.blocksera.com/coinpress?utm_source=wp&utm_medium=admin" target="_blank">' . __('Docs', 'coinpress') . '</a>');
            }

            return $links;
        }

        public function check_extensions() {

            $this->extensions = get_transient('mcw_extensions');

            if ($this->extensions === false) {
                $request = wp_remote_get('https://api.blocksera.com/products?category=wordpress');

                if (is_wp_error($request) || wp_remote_retrieve_response_code($request) != 200) {
                    return false;
                }

                $body = wp_remote_retrieve_body($request);
                $data = json_decode($body);

                if ($data) {
                    $this->extensions = $data->products;
                    set_transient('mcw_extensions', $this->extensions, DAY_IN_SECONDS);
                }
            }

        }

        public function save_custom_data() {

            $coins = $this->wpdb->get_results("SELECT `slug`, `" . implode("`, `", $this->dynamic_columns) . "` FROM `{$this->tablename}`", ARRAY_A);

            $coins_with_data = array_filter($coins, function($coin) {
                $count = array_filter($coin, function($field) { return !empty($field); });
                return (count($count) == 1) ? false : true;
            });

            set_transient('mcw-custom-data', $coins_with_data);
        }

        public function display_notices() {

            if (is_plugin_active('cryptocurrency-widgets-pack/cryptocurrency-widgets-pack.php')) {

                $plugin = 'cryptocurrency-widgets-pack/cryptocurrency-widgets-pack.php';
                $action = 'deactivate';

                if (strpos($plugin,'/') ) {
                    $plugin = str_replace( '\/', '%2F', $plugin );
                }

                $deactivate_url = sprintf(admin_url('plugins.php?action=' . $action . '&plugin=%s&plugin_status=all&paged=1&s'), $plugin);
                $_REQUEST['plugin'] = $plugin;
                $deactivate_url = wp_nonce_url($deactivate_url, $action . '-plugin_' . $plugin);
                
                new Admin_Notice_Display(sprintf(__('<strong>%s</strong>: Please <a href="%s">deactivate</a> Cryptocurrency Widgets Pack plugin as it may not work properly with PRO version', 'coinpress'), __('Coinpress', 'coinpress'), $deactivate_url), array('notice-warning is-dismissible'));
            }


            $update = array('license_action' => '');

            switch ($this->options['config']['license_action']) {

                case 'activate':

                    $queryargs = array(
                        'code' => $this->options['config']['license_key']
                    );

                    $response = $this->updater->request_info($queryargs);

                    if ($response->license_error == 'limit_exceeded') {
                        new Admin_Notice_Display(sprintf(__('<strong>%s</strong>: You have already used this purchase code on another site. Please deactivate license from the site or buy another license.', 'coinpress'), __('Coinpress', 'coinpress')), array('notice-error', 'is-dismissible'));
                    } else if ($response->license == 'false') {
                        new Admin_Notice_Display(sprintf(__('<strong>%s</strong>: Your purchase code is not valid. Please try again.', 'coinpress'), __('Coinpress', 'coinpress')), array('notice-error', 'is-dismissible'));
                    } else {
                        new Admin_Notice_Display(sprintf(__('<strong>%s</strong>: Congratulations! Your copy has been activated.', 'coinpress'), __('Coinpress', 'coinpress')), array('notice-success', 'is-dismissible'));
                    }

                    $update['license'] = $response->license;

                    $this->options['config'] = array_merge($this->options['config'], $update);

                    update_option('coinmc_config', $this->options['config']);

                    break;

                case 'deactivate':

                    $queryargs = array(
                        'code' => $this->options['config']['license_key'],
                        'remove' => 'true'
                    );

                    $response = $this->updater->request_info($queryargs);

                    if ($response->license_error == 'site_removed') {

                        new Admin_Notice_Display(sprintf(__('<strong>%s</strong>: Your license has been removed from this site. It can now be used again.', 'coinpress'), __('Coinpress', 'coinpress')), array('notice-info', 'is-dismissible'));

                        $update['license'] = 'false';
                        $update['license_key'] = '';

                    } else {
                        new Admin_Notice_Display(sprintf(__('<strong>%s</strong>: Your purchase code is not valid. Please try again.', 'coinpress'), __('Coinpress', 'coinpress')), array('notice-error', 'is-dismissible'));
                    }

                    $this->options['config'] = array_merge($this->options['config'], $update);

                    update_option('coinmc_config', $this->options['config']);

                    break;
            }

            if ((!isset($_REQUEST['page']) || $_REQUEST['page'] !== 'coinmc-settings') && ($this->options['config']['license'] != 'regular' && $this->options['config']['license'] != 'extended')) {
                new Admin_Notice_Display(sprintf(__('<strong>%s</strong>: Howdy! Please <a href="%s">activate</a> your copy to receive automatic future updates and support', 'coinpress'), __('Coinpress', 'coinpress'), admin_url('edit.php?post_type=coinmc&page=coinmc-settings')), array('notice-error', 'is-dismissible'));
            }
        }

        public function translations() {
            load_plugin_textdomain('coinpress', false, basename(dirname(__FILE__)) . '/languages/');
        }

        public function reload_content() {
            if (get_post_status($this->options['config']['page']) !== 'publish') {

                $post = [
                    'post_title' => __('Cryptocurrency Prices & Marketcap', 'coinpress'),
                    'post_type' => 'page',
                    'post_status' => 'publish',
                    'post_author' => get_current_user_id(),
                    'post_content' => file_get_contents(COINMC_PATH . '/includes/postcontent.txt')
                ];
        
                $postid = wp_insert_post($post);
                $this->options['config']['page'] = $postid;
                
                update_option('coinmc_config', $this->options['config']);
        
                $this->pages->rewrite_rules();
                flush_rewrite_rules();
                
                wp_redirect(admin_url('edit.php?post_type=coinmc&page=coinmc-settings&success=1'));
                die();

            } else {

                $post = array(
                    'ID'           => $this->options['config']['page'],
                    'post_content' => file_get_contents(COINMC_PATH . '/includes/postcontent.txt')
                );
                wp_update_post($post);
        
                wp_redirect(admin_url('edit.php?post_type=coinmc&page=coinmc-settings&success=1'));
                die();

            }
        }

        public function clear_cache() {
            $this->wpdb->query("DROP TABLE IF EXISTS `{$this->tablename}`");
            delete_transient('mcw-datatime');
            delete_transient('coinmc-global');
            delete_transient('coinmc-currencies');
            $this->create_tables();
            wp_redirect(admin_url('edit.php?post_type=coinmc&page=coinmc-settings&success=true'));
            exit();
        }

        public function generate_sitemap() {

            do_action('mcw_fetch_coins', $this->options['config']);

            $xml = '<?xml version="1.0" encoding="utf-8"?>';
            $xml .= '<?xml-stylesheet type="text/xsl" href="'. COINMC_URL . '/sitemap/style.xsl' .'"?>';
            $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

            $coins = $this->wpdb->get_results("SELECT `slug` FROM `{$this->tablename}`");
            foreach ($coins as $coin) {
                $xml .= '<url>';
                
                $coinlink = esc_url(str_replace('[symbol]', strtolower($coin->slug), $this->options['config']['link']));
                $coinlink = (parse_url($coinlink, PHP_URL_SCHEME) != '') ? $coinlink : get_site_url(null, $coinlink);

                $xml .= '<loc>'. user_trailingslashit($coinlink) .'</loc>';

                $xml .= '<lastmod>'. date('c') .'</lastmod>';
                $xml .= '<changefreq>daily</changefreq>';
                $xml .= '<priority>0.8</priority>';
                $xml .= '</url>';
            }
            $xml .= '</urlset>';

            $upload_dir = trailingslashit(wp_upload_dir()['basedir']) . 'coinpress';
            wp_mkdir_p($upload_dir);
            $file = fopen($upload_dir . "/sitemap.xml", 'w');
            fwrite($file, $xml);
            fclose($file);

            $this->options['config']['sitemap_update'] = time();
            
            update_option('coinmc_config', $this->options['config']);

            wp_redirect(admin_url('edit.php?post_type=coinmc&page=coinmc-settings&success=1'));
            die();
        }

        public function ticker_sticky() {
            $posts = get_posts(array('post_type' => 'coinmc', 'posts_per_page' => 1, 'meta_query' => array(array('key' => 'type', 'value' => 'global'), array('key' => 'global_position', 'value' => array('header', 'footer'), 'compare' => 'IN'))));
            
            if (sizeof($posts) > 0) {
                echo do_shortcode('[coinmc id="' . $posts[0]->ID . '"]');
            }
        }

        public function save_metadata() {
            $body = file_get_contents(COINMC_PATH . 'includes/metadata.json');
            $metadata = json_decode($body);

            $values = [];

            foreach ($metadata as $slug => $meta) {
                $values[] = array($slug, $meta->symbol, addslashes(wp_kses_post($meta->description)), addslashes(wp_kses_post($meta->description)), $meta->website, $meta->explorer, $meta->facebook, $meta->twitter, $meta->reddit, $meta->youtube, $meta->source, $meta->whitepaper);
            }

            $values = array_chunk($values, 100, true);

            foreach ($values as $chunk) {
                $placeholder = "(%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)";
                $sqlquery = "INSERT INTO `{$this->dtablename}` (`slug`, `symbol`, `description`, `meta_description`, `website`, `explorer`, `facebook`, `twitter`, `reddit`, `youtube`, `source`, `whitepaper`) VALUES ";
                $sqlquery .=  implode(", ", array_fill(0, count($chunk), $placeholder)) . ' ON DUPLICATE KEY UPDATE `symbol` = VALUES(`symbol`)';
                $this->wpdb->query($this->wpdb->prepare($sqlquery, call_user_func_array('array_merge', $chunk)));
            }
        }

        public function admin_scripts() {

            $screen = get_current_screen();

            if ($screen->post_type === 'coinmc') {
                wp_enqueue_code_editor( array('type' => 'text/css'));
                wp_enqueue_style('coinmca-crypto', COINMC_URL . 'assets/admin/css/style.css', array(), COINMC_VERSION);
                wp_enqueue_style('coinmca-selectize', COINMC_URL . 'assets/admin/css/selectize.custom.css', array(), COINMC_VERSION);
                wp_enqueue_script('coinmca-vendor', COINMC_URL . 'assets/admin/js/vendor.min.js', array('jquery', 'jquery-ui-sortable'), COINMC_VERSION, true);
                wp_enqueue_script('coinmca-common', COINMC_URL . 'assets/admin/js/common.js', array('jquery', 'coinmca-vendor'), COINMC_VERSION, true);
                add_action('admin_enqueue_scripts', array($this, 'frontend_scripts'), 99999);
            }
        }

        public function frontend_scripts() {
            wp_enqueue_style('coinmc-fontawesome', COINMC_URL . 'assets/public/css/fontawesome.min.css', array(), '5.3.1');
            wp_enqueue_style('coinmc-flatpickr', COINMC_URL . 'assets/public/css/flatpickr.min.css', array(), COINMC_VERSION);
            wp_enqueue_style('coinmc-grid', COINMC_URL . 'assets/public/css/flexboxgrid.css', array(), COINMC_VERSION);
            wp_enqueue_script('coinmc-vendor', COINMC_URL . 'assets/public/js/vendor.min.js', array('jquery'), COINMC_VERSION, true);
            wp_enqueue_script('coinmc-common', COINMC_URL . 'assets/public/js/common.min.js', array('jquery', 'coinmc-vendor'), COINMC_VERSION, true);
            wp_enqueue_style('mcw-crypto-datatable', COINMC_URL . 'assets/public/css/jquery.dataTables.min.css', array(), '1.10.18');
            wp_enqueue_style('coinmc-crypto-table', COINMC_URL . 'assets/public/css/table.css', array(), COINMC_VERSION);
            wp_enqueue_style('coinmc-tippy', COINMC_URL . 'assets/public/css/tippy.min.css', array(), '3.0.6');
            wp_enqueue_style('coinmc-crypto', COINMC_URL . 'assets/public/css/style.css', array(), COINMC_VERSION);

            $currencyformats = array_column($this->options['config']['currency_format'], null, 'iso');

            $atts = array(
                'url' => COINMC_URL,
                'ajax_url' => admin_url('admin-ajax.php'),
                'currency_format' => $currencyformats,
                'default_currency_format' => $this->options['config']['default_currency_format'],
                'text' => array(
                    'addtowatchlist' => __('Add to Watchlist', 'coinpress'),
                    'removefromwatchlist' => __('Remove from Watchlist', 'coinpress'),
                    'buynow' => __('Buy Now', 'coinpress'),
                    'sellnow' => __('Sell Now', 'coinpress'),
                    'emptytable' => __('No Results Found', 'coinpress'),
                    'pageinfo' => __('Showing %s - %s of %s coins', 'coinpress'),
                    'lengthmenu' => __('Rows per page:', 'coinpress'),
                    'nextbtn' => __('Next', 'coinpress'),
                    'prevbtn' => __('Prev', 'coinpress'),
                    'periods' => array(
                        'hour' => __('Hour', 'coinpress'),
                        'day' => __('Day', 'coinpress'),
                        'week' => __('Week', 'coinpress'),
                        'month' => __('Month', 'coinpress'),
                        'year' => __('Year', 'coinpress'),
                        'all' => __('All', 'coinpress'),
                    ),
                    'price' => __('Price', 'coinpress'),
                    'volume' => __('Volume', 'coinpress'),
                    'months' => array(__('Jan', 'coinpress'), __('Feb', 'coinpress'), __('Mar', 'coinpress'), __('Apr', 'coinpress'), __('May', 'coinpress'), __('Jun', 'coinpress'), __('Jul', 'coinpress'), __('Aug', 'coinpress'), __('Sep', 'coinpress'), __('Oct', 'coinpress'), __('Nov', 'coinpress'), __('Dec', 'coinpress')),
                    'tooltip' => array(__('Price', 'coinpress'), __('High', 'coinpress'), __('Low', 'coinpress'), __('Open', 'coinpress'), __('Close', 'coinpress'), __('Volume', 'coinpress')),
                    'date'  => apply_filters('coinmc_chart_date', 'dd mm yy')
                ),
                'watchlistConfig' => array(
                    'user' => is_user_logged_in(),
                    'user_based' => apply_filters('watchlist_user_control', true),
                    'coins' => get_user_meta(get_current_user_id(), 'cmc_watchlist', true)
                )
            );

            if ($this->pages->is_coinpage() && strpos($this->options['config']['title'], 'type="price"')) {
                $currencies = $this->get_currencies();
                $atts = array_merge($atts, array('coin' => apply_filters('coinmc_virtual_asset', ''), 'title' => do_shortcode(str_replace('[coinmc type="price"]', '{price}', $this->options['config']['title'])), 'fiatprefix' => $currencyformats[$this->options['config']['currency']]['symbol'], 'exrate' => $this->getexrate($this->options['config']['currency']) ));
            }

            wp_localize_script('coinmc-common', 'coinmc', $atts);

            $css = $this->options['config']['css'];

            if ($this->options['config']['font'] !== 'inherit') {
                wp_enqueue_style('coinmc-google-fonts', 'https://fonts.googleapis.com/css?family=' . $this->options['config']['font']);

                $css .= '.coinpage, .coinpage .entry-content, .cryptoboxes, .tippy-content { font-family: ' . str_replace('+', ' ', $this->options['config']['font']) . '; }';
            }

            wp_add_inline_style("coinmc-crypto", $css);
        }

        public function columns_content($columns) {
            $ncolumns = array();
            foreach($columns as $key => $title) {
                if ($key=='date') {
                    $ncolumns['shortcode'] = __('Shortcode', 'coinpress');
                    $ncolumns['type'] = __('Widget Type', 'coinpress');
                }
                $ncolumns[$key] = $title;
            }
            return $ncolumns;
        }
        
        public function custom_column($column, $post_id) {
            switch ($column) {
                case 'type':
                    $post = json_decode(get_post_field('post_content', $post_id), true);
                    _e(ucfirst($post['type']), 'coinpress');
                    break;
                case 'shortcode':
                    echo '[coinmc id="' . $post_id . '"]';
                    break;
            }
        }

        public function add_post_editor() {
            add_meta_box('coinmc-editor', __('Widget Settings', 'coinpress'), array($this, 'editor_content'), 'coinmc', 'advanced', 'high');
            add_meta_box('coinmc-shortcode', __('Shortcode', 'coinpress'), array( $this, 'editor_shortcode' ), 'coinmc', 'side', 'high');
        }
        
        public function editor_content($post) {
            wp_nonce_field(plugin_basename(__FILE__), 'coinmc_editor_nonce');
            $options = (get_post_status($post->ID) === 'auto-draft') ? $this->options : array_merge($this->options, json_decode($post->post_content, true));
            $options = apply_filters('coinmc_get_options', $options);
            require_once(COINMC_PATH . 'includes/editor.php');
        }

        public function editor_shortcode($post) {
            echo '<span class="shortcode-hint">'. __('Copied', 'coinpress') . '!</span>'. __('Paste this shortcode anywhere like page, post or widgets', 'coinpress' ) . '<br><br>';
            echo '<input type="text" id="coinmcshortcode" data-clipboard-target="#coinmcshortcode" readonly="readonly" class="selectize-input" value="' . esc_attr('[coinmc id="' . $post->ID . '"]') . '" />';
        }

        public function settings_page() {
            $config = $this->options['config'];
            include_once(COINMC_PATH . '/includes/settings.php');
        }

        public function save_settings() {
            
            $update = array(
                'link' => sanitize_text_field($_POST['link']),                
                'linkto' => sanitize_text_field($_POST['linkto']),
                'currency' => sanitize_text_field($_POST['currency']),
                'font' => sanitize_text_field($_POST['font']),
                'changelly' => esc_attr($_POST['changelly']),
                'css' => sanitize_textarea_field($_POST['css']),
                'title' => wp_kses_post(stripslashes($_POST['title'])),
                'description' => wp_kses_post(stripslashes($_POST['description'])),
                'meta_description' => wp_kses_post(stripslashes($_POST['meta_description'])),
                'theme_color' => sanitize_hex_color($_POST['theme_color']),
                'news_feeds' => sanitize_textarea_field($_POST['news_feeds']),
                'api' => sanitize_text_field($_POST['api']),
                'api_key' => sanitize_text_field($_POST['api_key']),
                'api_interval' => intval($_POST['api_interval']),
                'license' => sanitize_text_field($_POST['license']),
                'license_key' => sanitize_text_field($_POST['license_key']),
                'license_action' => sanitize_text_field($_POST['license_action']),
                'default_currency_format' => isset($_POST['default_currency_format']) ? esc_sql($_POST['default_currency_format']) : array(),
                'currency_format' => isset($_POST['currency_format']) ? esc_sql($_POST['currency_format']) : array()
            );
    
            $config = array_merge($this->options['config'], $update);
            update_option('coinmc_config', $config);
            wp_redirect(admin_url('edit.php?post_type=coinmc&page=coinmc-settings&success=true'));
    
        }
        
        public function details_page() {

            $slug = isset($_GET['coin']) ? $_GET['coin'] : 'bitcoin';
            $coins = $this->coinsyms();
            $coin = $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM `{$this->tablename}` WHERE `slug` = %s", $slug));
            $details = $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM `{$this->dtablename}` WHERE `slug` = %s", $slug));

            include_once(COINMC_PATH . '/includes/details.php');
        }
        
        public function save_details() {

            $coin = sanitize_key($_POST['coin']);

            $content = array(
                'coin' => $coin,
                'description' => addslashes(wp_kses_post($_POST['desc'])),
                'meta_description' => addslashes(wp_kses_post($_POST['meta_desc'])),
                'website' => esc_url_raw($_POST['website']),
                'explorer' => esc_url_raw($_POST['explorer']),
                'facebook' => esc_url_raw($_POST['facebook']),
                'twitter' => esc_url_raw($_POST['twitter']),
                'reddit' => esc_url_raw($_POST['reddit']),
                'youtube' => esc_url_raw($_POST['youtube']),
                'source' => esc_url_raw($_POST['source']),
                'whitepaper' => esc_url_raw($_POST['whitepaper'])
            );

            $query = "INSERT INTO `{$this->dtablename}` (`slug`, `description`, `meta_description`, `website`, `explorer`, `facebook`, `twitter`, `reddit`, `youtube`, `source`, `whitepaper`) VALUES ";
            $query .= "('" . implode("', '", $content) . "')";
            $query .= " ON DUPLICATE KEY UPDATE `description` = VALUES(`description`), `meta_description` = VALUES(`meta_description`), `website` = VALUES(`website`), `explorer` = VALUES(`explorer`), `facebook` = VALUES(`facebook`), `twitter` = VALUES(`twitter`), `reddit` = VALUES(`reddit`), `youtube` = VALUES(`youtube`), `source` = VALUES(`source`), `whitepaper` = VALUES(`whitepaper`)";
            $this->wpdb->query($query);

            $keywords = isset($_POST['keywords']) ? implode(',', array_map('sanitize_text_field', $_POST['keywords'])) : '';
            $this->wpdb->query("UPDATE `{$this->tablename}` SET `keywords` = '{$keywords}' WHERE `slug` = '{$coin}'");

            do_action('mcw_save_custom_data');

            $url = admin_url('edit.php?post_type=coinmc&page=coinmc-cryptocurrencies&coin='. $content['coin'] .'&success=1');
            wp_redirect($url);

        }

        public function register_menu() {

            $read = get_transient('mcw_read_extensions');
            $read = $read ? $read : [];
            $extensions_text = __('Extensions', 'coinpress');

            if (!isset($_GET['page']) || $_GET['page'] != 'coinmc-extensions') {
                $extensions_text .= ($this->extensions && (count($this->extensions) > count($read))) ? '<span style="position: relative;right: -6px;display: inline-block;width: 8px;height: 8px;border-radius: 50%;background-color: #06a076;"></span>' : '';
            }

            add_submenu_page('edit.php?post_type=coinmc', __('Cryptocurrencies', 'coinpress'), __('Cryptocurrencies', 'coinpress'), 'manage_options', 'coinmc-cryptocurrencies', array($this, 'details_page'));
            add_submenu_page('edit.php?post_type=coinmc', __('Settings', 'coinpress'), __('Settings', 'coinpress'), 'manage_options', 'coinmc-settings', array($this, 'settings_page'));
            add_submenu_page('edit.php?post_type=coinmc', __('Extensions', 'coinpress'), $extensions_text, 'manage_options', 'coinmc-extensions', array($this, 'extensions_page'));
        }

        public function extensions_page() {

            $read = get_transient('mcw_read_extensions');
            $read = $read ? $read : [];

            $read_slugs = array_map(function($e) { return $e->slug; }, $read);

            if (count($this->extensions) > count($read)) {
                set_transient('mcw_read_extensions', $this->extensions);
            }
            
            include_once(COINMC_PATH . '/includes/extensions.php');
            
        }

        public function rewrite_tag() {
            add_rewrite_tag('%coin%', '([^&]+)');
        }
        
        public function save_widget($post_id) {
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }

            if (!isset($_POST['coinmc_editor_nonce'])) {
                return;
            }

            if (!wp_verify_nonce($_POST['coinmc_editor_nonce'], plugin_basename( __FILE__ ))) {
                return;
            }

            if (!current_user_can('edit_page', $post_id)) {
                return;
            }
            
            $postcontent = [
                'type' => sanitize_key($_POST['type']),
                'coins' => isset($_POST['coins']) ? $_POST['coins'] : array(),
                'numcoins' => intval($_POST['numcoins']),
                'global_position' => sanitize_key($_POST['global_position']),
                'global_color' => sanitize_key($_POST['global_color']),
                'table_type' => sanitize_key($_POST['table_type']),
                'table_style' => sanitize_key($_POST['table_style']),
                'table_length' => intval($_POST['table_length']),
                'table_restype' => sanitize_key($_POST['table_restype']),
                'table_columns' => isset($_POST['table_columns']) ? $_POST['table_columns'] : $this->options['table_columns'],
                'table_order' => sanitize_key($_POST['table_order']),
                'table_order_dir' => sanitize_key($_POST['table_order_dir']),
                'settings' => isset($_POST['settings']) ? $_POST['settings'] : array(),
                'currency' => strtoupper(sanitize_key($_POST['currency'])),
                'chart_color' => sanitize_hex_color($_POST['chart_color']),
                'text_color' => $_POST['text_color'],
                'background_color' => $_POST['background_color'],
                'price_format' => intval($_POST['price_format']),
                'settings' => isset($_POST['settings']) ? $_POST['settings'] : array()
            ];

            remove_action('save_post', array($this, 'save_widget'));

            $post = array(
                'ID' => $post_id,
                'post_content' => wp_json_encode($postcontent),
                'post_mime_type' => 'application/json',
            );

            update_post_meta($post_id, 'type', $postcontent['type']);
            update_post_meta($post_id, 'global_position', $postcontent['global_position']);
            wp_update_post($post);
            add_action('save_post', array($this, 'save_widget'));
        }

        public function create_post_type() {
            $labels = array(
                'name'                  => _x('Coinpress Widgets', 'Post Type General Name', 'coinpress'),
                'singular_name'         => _x('Coinpress', 'Post Type Singular Name', 'coinpress'),
                'menu_name'             => __('Coinpress', 'coinpress'),
                'name_admin_bar'        => __('Post Type', 'coinpress'),
                'archives'              => __('Widget Archives', 'coinpress'),
                'attributes'            => __('Widget Attributes', 'coinpress'),
                'parent_item_colon'     => __('Parent Widget:', 'coinpress'),
                'all_items'             => __('All Widgets', 'coinpress'),
                'add_new_item'          => __('Add New Coinmarketcap Widget', 'coinpress'),
                'add_new'               => __('Add New Widget', 'coinpress'),
                'new_item'              => __('New Widget', 'coinpress'),
                'edit_item'             => __('Edit Coinmarketcap Widget', 'coinpress'),
                'view_item'             => __('View Widget', 'coinpress'),
                'view_items'            => __('View Widgets', 'coinpress'),
                'search_items'          => __('Search Widget', 'coinpress'),
                'not_found'             => __('Not found', 'coinpress'),
                'not_found_in_trash'    => __('Not found in trash', 'coinpress'),
                'featured_image'        => __('Featured Image', 'coinpress'),
                'set_featured_image'    => __('Set featured image', 'coinpress'),
                'remove_featured_image' => __('Remove featured image', 'coinpress'),
                'use_featured_image'    => __('Use as featured image', 'coinpress'),
                'insert_into_item'      => __('Insert into widget', 'coinpress'),
                'uploaded_to_this_item' => __('Uploaded to this widget', 'coinpress'),
                'items_list'            => __('Widgets list', 'coinpress'),
                'items_list_navigation' => __('Widgets list navigation', 'coinpress'),
                'filter_items_list'     => __('Filter widgets list', 'coinpress'),
            );
            $args = array(
                'label'                 => __('Coinpress', 'coinpress'),
                'description'           => __('Post Type Description', 'coinpress'),
                'labels'                => $labels,
                'supports'              => array('title'),
                'taxonomies'            => array(''),
                'hierarchical'          => false,
                'public' 				=> false,
                'show_ui'               => true,
                'show_in_nav_menus' 	=> false,
                'menu_position'         => 5,
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => true,
                'can_export'            => true,
                'has_archive' 			=> false,
                'rewrite' 				=> false,
                'exclude_from_search'   => true,
                'publicly_queryable'    => false,
                'query_var'				=> false,
                'menu_icon'           	=> 'data:image/svg+xml;base64,'.base64_encode('<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="41px" height="41px" viewBox="99 0 41 41" enable-background="new 99 0 41 41" xml:space="preserve"><g><path fill="#82878c" d="M134.428,24.5c-0.715,0.452-1.558,0.508-2.197,0.146c-0.813-0.459-1.26-1.533-1.26-3.028v-4.473 c0-2.16-0.854-3.697-2.283-4.112c-2.42-0.705-4.239,2.256-4.924,3.368l-4.268,6.919v-8.458c-0.048-1.946-0.68-3.11-1.88-3.461 c-0.794-0.232-1.982-0.139-3.136,1.627l-9.562,15.354c-1.28-2.43-1.948-5.137-1.944-7.883c0-9.249,7.412-16.773,16.522-16.773 c9.11,0,16.521,7.524,16.521,16.773c0,0.016,0.004,0.03,0.005,0.045c0,0.016-0.003,0.03-0.003,0.046 C136.106,22.382,135.526,23.807,134.428,24.5L134.428,24.5z M139.688,20.501L139.688,20.501v-0.047v-0.046 C139.637,9.144,130.6,0,119.495,0c-11.133,0-20.192,9.196-20.192,20.5c0,11.303,9.059,20.5,20.193,20.5 c5.109,0,9.985-1.941,13.729-5.467c0.744-0.7,0.787-1.879,0.098-2.633c-0.674-0.744-1.823-0.8-2.566-0.126 c-0.01,0.009-0.019,0.017-0.027,0.025c-3.034,2.873-7.054,4.474-11.232,4.474c-4.878,0-9.267-2.16-12.294-5.584l8.623-13.845v6.382 c0,3.066,1.189,4.058,2.186,4.348c0.998,0.289,2.523,0.092,4.124-2.508l4.744-7.689c0.151-0.248,0.291-0.462,0.42-0.647v3.888 c0,2.866,1.147,5.157,3.148,6.286c1.805,1.019,4.072,0.927,5.92-0.239C138.607,26.25,139.814,23.643,139.688,20.501z"/></g></svg>'),
                'capability_type'       => 'page',
            );
            register_post_type('coinmc', $args);
            remove_post_type_support('coinmc', 'title');
        }

        public function shortcode($atts, $content) {

            // Deprecate type parameter
            if (isset($atts['type'])) {
                $atts['info'] = $atts['type'];
            }
            $asset = isset($atts['coin']) ? $atts['coin'] : '';
            $atts = shortcode_atts(array(
                'id' => '',
                'info' => 'widget',
                'coin' => apply_filters('coinmc_virtual_asset', $asset, $asset),
                'watchlist' => false,
                'currency' => $this->options['config']['currency'],
                'format' => 'number',
                'realtime' => 'on',
                'shorten' => false,
            ), $atts, 'coinmc');

            wp_register_style('coinmc-custom', false);
            wp_enqueue_style('coinmc-custom');

            return ($atts['info'] === 'widget') ? $this->widget_shortcode($atts) : $this->single_shortcode($atts, $content);
        }

        public function single_shortcode($atts, $content) {
            global $post;
            do_action('mcw_fetch_coins', $this->options['config']);

            $shortcode = new Coinmarketcap_Shortcodes();
            $shortcode->config = apply_filters('coinmc_get_config', $this->options['config']);
            $shortcode->config['currency'] = strtoupper($atts['currency']);

            $options = array();
            $options['currency'] = strtoupper($atts['currency']);
            $options['exrate'] = $this->getexrate($options['currency']);
            $options['data'] = apply_filters('coinmc_global', array());

            switch ($atts['info']) {
                case 'cryptocurrencies':
                    return $shortcode->number_format($options['data']['active_cryptocurrencies'], $options['currency'], $atts['shorten'], 0);
                case 'total_markets':
                    return $shortcode->number_format($options['data']['markets'], $options['currency'], $atts['shorten'], 0);
                case 'total_marketcap':
                    return $shortcode->price_format($options['data']['marketcap'], $options['exrate'], $options['currency'], $atts['shorten'], 0);
                case 'total_volume':
                    return $shortcode->price_format($options['data']['24hvol'], $options['exrate'], $options['currency'], $atts['shorten'], 0);
                case 'btc_dominance':
                    return $shortcode->number_format($options['data']['btcdominance'], $options['currency'], $atts['shorten'], 2) . '%';
            }

            $coin = $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM `{$this->tablename}` WHERE `slug` = %s OR `symbol` = %s", $atts['coin'], $atts['coin']));

            if ($coin == false) {
                return;
            }

            $meta = $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM `{$this->dtablename}` WHERE `slug` = %s", $coin->slug));

            $class = ($this->pages->is_coinpage()) ? 'coinpage coingrid': '';
            $output = '<div class="cryptoboxes '.$class.'" data-realtime="on">';

            switch ($atts['info']) {
                case 'name':
                    return $coin->name;
                    break;
                case 'symbol':
                    return $coin->symbol;
                    break;
                case 'rank':
                    return $coin->rank;
                    break;
                case 'price':
                    if ($atts['realtime'] === 'off') {
                        return $shortcode->price_format($coin->price_usd, $options['exrate'], $options['currency']);
                    } else {
                        return '<span class="cryptoboxes" data-realtime="on"><span data-price="'. $coin->price_usd .'" data-live-price="'. $shortcode->slugify($coin->name) .'" data-rate="'. $options['exrate'] .'" data-currency="'. $options['currency'] .'">'. $shortcode->price_format($coin->price_usd, $options['exrate'], $options['currency']) .'</span></span>';
                    }
                    break;
                case 'pricebtc':
                    return 'Ƀ ' . $coin->price_btc;
                    break;
                case 'marketcap':
                    $short = (strtolower($atts['format']) == 'abbr') ? true : false;
                    return $shortcode->price_format($coin->market_cap_usd, $options['exrate'], $options['currency'], $short, 0);
                    break;
                case 'change':
                    return '<span class="coinmc-' . (($coin->percent_change_24h >= 0) ? 'up' : 'down') . '">' . $coin->percent_change_24h . '%' . '</span>';
                    break;
                case 'change1h':
                    return '<span class="coinmc-' . (($coin->percent_change_1h >= 0) ? 'up' : 'down') . '">' . $coin->percent_change_1h . '%' . '</span>';
                    break;
                case 'change7d':
                    return '<span class="coinmc-' . (($coin->percent_change_7d >= 0) ? 'up' : 'down') . '">' . $coin->percent_change_7d . '%' . '</span>';
                    break;
                case 'change30d':
                    return '<span class="coinmc-' . (($coin->percent_change_30d >= 0) ? 'up' : 'down') . '">' . $coin->percent_change_30d . '%' . '</span>';
                    break;
                case 'changetext':
                    return ($coin->percent_change_24h > 0) ? __('increased', 'coinpress') : __('decreased', 'coinpress');
                    break;
                case 'changetext1h':
                    return ($coin->percent_change_1h > 0) ? __('increased', 'coinpress') : __('decreased', 'coinpress');
                    break;
                case 'changetext7d':
                    return ($coin->percent_change_7d > 0) ? __('increased', 'coinpress') : __('decreased', 'coinpress');
                    break;
                case 'changetext30d':
                    return ($coin->percent_change_30d > 0) ? __('increased', 'coinpress') : __('decreased', 'coinpress');
                    break;
                case 'volume':
                    return $shortcode->price_format($coin->volume_usd_24h, $options['exrate'], $options['currency'], false, 0);
                    break;
                case 'supply':
                    return $shortcode->number_format($coin->available_supply, $options['currency'], false, 0) . ' ' . $coin->symbol;
                    break;
                case 'totalsupply':
                    return $shortcode->number_format($coin->total_supply, $options['currency'], false, 0) . ' ' . $coin->symbol;
                    break;
                case 'ath':
                    return $shortcode->price_format($coin->ath, $options['exrate'], $options['currency']);
                    break;
                case 'changeath':
                    $percentage = (($coin->price_usd - $coin->ath) / $coin->ath ) * 100;

                    return '<span class="coinmc-' . (($percentage >= 0) ? 'up' : 'down') . '">' . $shortcode->number_format($percentage, $options['currency'], false, 2) . '%' . '</span>';
                    break;
                case 'athdate':
                    return date('F j, Y', $coin->ath_date);
                    break;
                case 'dayssinceath':
                    $datediff = time() - $coin->ath_date;
                    return round($datediff / (60 * 60 *24));
                    break;
                // Advanced shortcodes for coin page
                case 'logoname':
                    $output .= $shortcode->single_logoname($coin);
                    break;
                case 'desc':
                    $output .= $shortcode->single_desc($coin, $meta);
                    break;
                case 'prices':
                    $output .= $shortcode->single_prices($coin, $options);
                    break;
                case 'buttons':
                    $output .= $shortcode->single_buttons($coin);
                    break;
                case 'watchlist_button':
                    $output .= $shortcode->watchlist_button($coin);
                    break;
                case 'links':
                    $output .= $shortcode->single_links($coin, $meta);
                    break;
                case 'calc':
                    $options['currencies'] = $this->get_currencies();
                    $coins = $this->wpdb->get_results("SELECT `symbol`, `slug`, `price_usd` FROM `{$this->tablename}`");
                    $output .= $shortcode->single_calculator($coin, $coins, $options);
                    break;
                case 'chart':
                    $output .= $shortcode->single_chart($coin, $options);
                    break;
                case 'historical':
                    $output .= $shortcode->single_historical($coin, $options);
                    break;
                case 'markets':
                    $output .= $shortcode->single_markets($coin, $options);
                    break;
                case 'social':
                    $output .= $shortcode->single_social($coin, $meta);
                    break;
                case 'news':
                    $output .= $shortcode->single_news($coin);
                    break;
                case 'comments':
                    $output .= $shortcode->single_comments($coin);
                    break;
            }

            $output .= '</div>';

            $output = apply_filters('coinmc_text_shortcode', $output, $atts, $options);

            return $output;
        }

        public function widget_shortcode($atts) {

            $shortcode = new Coinmarketcap_Shortcodes();
            $shortcode->config = $this->options['config'];

            $post = get_post($atts['id']);

            if (($post->post_status != 'publish') && (!is_admin())) {
                return;
            }

            $options = ($post->post_status === 'auto-draft' || $post->post_type !== 'coinmc') ? $this->options : array_merge($this->options, json_decode($post->post_content, true));
            $options = apply_filters('coinmc_get_options', $options);

            $options['exrate'] = $this->getexrate($options['currency']);
            $options['watchlist'] = $atts['watchlist'];
            
            if ($atts['id'] === '') {

                return 'No id';

            } else if ($options['type'] == 'table' && sizeof($options['coins']) == 0 && intval($options['numcoins']) == 0) {

                return 'No coins selected';

            }

            do_action('mcw_fetch_coins', $this->options['config']);
            
            if (count($options['coins']) > 0) {
                $wquery = "WHERE `slug` IN ('" . implode("', '", $options['coins']) . "') ORDER BY `rank` ASC";
            } else {
                $wquery = "ORDER BY `rank` LIMIT " . intval($options['numcoins']);
            }
            
            switch ($options['type']) {

                case 'global':

                    $options['data'] = apply_filters('coinmc_global', array());
                    return $shortcode->global_shortcode($atts['id'], $options);
                    break;

                case 'table':

                    if ($options['numcoins'] > 2000) {
                        $coins = $this->coinsyms();
                        $options['numcoins'] = sizeof($coins);
                    }

                    $options['page'] = max(1, intval(isset($_REQUEST['coins']) ? $_REQUEST['coins'] : 1));
                    $skip = ($options['page'] - 1) * $options['table_length'];

                    return $shortcode->table_shortcode($atts['id'], $options, $post->post_title);
                    break;
            }

        }

        public function get_weekly($coins, $numcoins = 0) {

            $wquery = (count($coins) > 0) ? "WHERE `slug` IN ('" . implode("', '", $coins) . "')" : "ORDER BY `rank` LIMIT " . $numcoins;

            $query = "SELECT `slug`, `symbol`, `weekly`, `weekly_expire` FROM `{$this->tablename}` " . $wquery;
            $results = $this->wpdb->get_results($query);
            
            $output = []; $expiredcoins = [];
            foreach($results as $res) {
                $output[$res->slug] = explode(',', $res->weekly);
                
                //create list of coins to request and update to sql
                $dateFromDatabase = strtotime($res->weekly_expire);
                $dateTwelveHoursAgo = strtotime("-1 hours");
                
                if (($dateFromDatabase < $dateTwelveHoursAgo) || ($res->weekly == '')){
                    array_push($expiredcoins,$res->slug);
                }
            }

            if (count($expiredcoins) > 0) {

                $request = wp_remote_get('https://api.blocksera.com/v1/tickers/weekly?coins='.strtolower(implode(',',$expiredcoins)).'&limit=168');

                if (is_wp_error($request) || wp_remote_retrieve_response_code($request) != 200) {
                    foreach ($expiredcoins as $coin) {
                        $weekquery = "UPDATE `{$this->tablename}` SET `weekly_expire` = '" . gmdate("Y-m-d H:i:s", strtotime("-55 minutes")) . "' WHERE `slug` = '{$coin}'";
                        $weekresult = $this->wpdb->query($weekquery);
                    }
                }

                $body = wp_remote_retrieve_body($request);
                $data = json_decode($body);
            
                if (!empty($data)) {
                    foreach($data as $key => $value) {
                        $weekquery  = "UPDATE `{$this->tablename}` SET `weekly` = '" . implode(', ', $value) . "', `weekly_expire` = '" . gmdate("Y-m-d H:i:s") . "' WHERE `slug` = '{$key}'";
                        $weekresult = $this->wpdb->query($weekquery);
                        $output[$key] = $value;
                    }
                }
            }
            
            return $output;
        }

        public function get_coinlinks($links, $options) {

            if (!in_array('linkto', $options['settings'])) {
                return $links;
            }

            switch($this->options['config']['linkto']) {
                case 'custom':

                    $coin_posts = get_posts(array('posts_per_page' => -1, 'post_type' => 'any', 'meta_key' => 'mcw-coin'));

                    foreach($coin_posts as $coin_post) {
                        $meta_value = get_post_meta($coin_post->ID, 'mcw-coin', true);
                        $links[$meta_value] = get_permalink($coin_post->ID);
                    }
                    break;

                case 'coinpress':

                    if(!empty($this->options['config']['link'])){
                        foreach($options['data'] as $coin) {
                            $link = str_replace('[symbol]', strtolower($coin->slug), $this->options['config']['link']);
                            $links[$coin->symbol] = $links[$coin->slug] = (parse_url($link, PHP_URL_SCHEME) != '') ? $link : apply_filters('wpml_permalink', get_site_url(null, $link));
                        }
                    }

                    break;
            }

            return $links;
        }
        
        public function ajax_tables() {

            $shortcode = new Coinmarketcap_Shortcodes();
            $shortcode->config = $this->options['config']; 

            do_action('mcw_fetch_coins', $this->options['config']);

            $post = get_post(intval($_GET['id']));

            $options = ($post->post_status === 'auto-draft') ? $this->options : array_merge($this->options, json_decode($post->post_content, true));
            $options = apply_filters('coinmc_get_options', $options);

            $numcoins = (sizeof($options['coins']) > 0) ? sizeof($options['coins']) : $options['numcoins'];

            if ($numcoins > 2000) {
                $coins = $this->coinsyms();
                $numcoins = sizeof($coins);
            }

            $table = [];

            $table['order'] = array(
                'column' => isset($_GET['order'][0]['column']) ? sanitize_text_field($_GET['columns'][intval($_GET['order'][0]['column'])]['name']) : $options['table_order'],
                'dir' => isset($_GET['order'][0]['dir']) ? sanitize_text_field($_GET['order'][0]['dir']) : strtoupper($options['table_order_dir'])
            );

            $table['order']['column'] = in_array($table['order']['column'], array(
                'name',
                'symbol',
                'slug',
                'rank',
                'price_usd',
                'price_btc',
                'volume_usd_24h',
                'market_cap_usd',
                'high_24h',
                'low_24h',
                'available_supply',
                'total_supply',
                'ath',
                'ath_date',
                'price_change_24h',
                'percent_change_1h',
                'percent_change_24h',
                'percent_change_7d',
                'percent_change_30d'
            )) ? $table['order']['column'] : 'rank';

            $table['order']['dir'] = 'DESC' === strtoupper($table['order']['dir']) ? 'DESC' : 'ASC';

            $table['start'] = intval($_GET['start']);
            $table['length'] = intval($_GET['length']);

            $table['search'] = sanitize_text_field($_GET['search']['value']);
            $table['currency'] = isset($_GET['currency']) ? sanitize_text_field($_GET['currency']) : $options['currency'];

            $dbcolumns = array_diff($options['table_columns'], array('no', 'last24h', 'weekly', 'actions'));
            if(in_array('last24h', $options['table_columns']) || in_array('weekly', $options['table_columns'])){
                array_push($dbcolumns, 'percent_change_24h');
            }

            $watchlistCoins = empty(get_user_meta(get_current_user_id(), 'cmc_watchlist', true)) ? [] : array_filter(get_user_meta(get_current_user_id(), 'cmc_watchlist', true));
            $watchlist_state = filter_var($_GET['restrict'], FILTER_VALIDATE_BOOLEAN); // returns watchlist is user based or not

            if ($_GET['watchlist'] === 'true') {
                $datacoins = ($watchlist_state && !empty($watchlistCoins)) ? $watchlistCoins : array_map(function($coin) { return esc_sql($coin); }, $_GET['coins']);
                $order = sanitize_sql_orderby("`{$table['order']['column']}` {$table['order']['dir']}");
                $options['data'] = $this->wpdb->get_results("SELECT `img`, `slug`, `symbol`, `" . implode("`, `", $dbcolumns) . "` FROM `{$this->tablename}` WHERE `slug` IN ('" . implode("', '", $datacoins) . "') ORDER BY {$order}");
                $numcoins = sizeof($options['data']);
            } else if ($table['search'] !== '') {
                $table['search'] = '%' . $this->wpdb->esc_like($table['search']) . '%';
                $totalcoins = $this->wpdb->get_results($this->wpdb->prepare("SELECT `slug` FROM `{$this->tablename}` WHERE CONCAT_WS(' ', `name`, `symbol`, `keywords`) LIKE %s", $table['search']));
                $numcoins = sizeof($totalcoins);
                $order = sanitize_sql_orderby("`{$table['order']['column']}` {$table['order']['dir']}");
                $options['data'] = $this->wpdb->get_results($this->wpdb->prepare("SELECT `img`, `slug`, `symbol`, `" . implode("`, `", $dbcolumns) . "` FROM `{$this->tablename}` WHERE CONCAT_WS(' ', `name`, `symbol`, `keywords`) LIKE %s ORDER BY {$order} LIMIT %d, %d", [$table['search'], $table['start'], $table['length']]));
            } else if (sizeof($options['coins']) > 0) {
                $coins = array_slice($options['coins'], intval($_GET['start']), intval($_GET['length']));
                $order = ($table['order']['column'] && $table['order']['column'] !== 'slug') ? sanitize_sql_orderby("`{$table['order']['column']}` {$table['order']['dir']}") : "FIELD(`slug`, '" . implode("', '", $coins) . "')";
                $options['data'] = $this->wpdb->get_results("SELECT `img`, `slug`, `symbol`, `" . implode("`, `", $dbcolumns) . "` FROM `{$this->tablename}` WHERE `slug` IN ('" . implode("', '", $coins) . "') ORDER BY {$order}");
            } else {
                $order = sanitize_sql_orderby("`{$table['order']['column']}` {$table['order']['dir']}");
                $options['data'] = $this->wpdb->get_results($this->wpdb->prepare("SELECT `img`, `slug`, `symbol`, `" . implode("`, `", $dbcolumns) . "` FROM `{$this->tablename}` WHERE `rank` <= {$options['numcoins']} ORDER BY {$order} LIMIT %d, %d", [$table['start'], $table['length']]));
            }

            $weeklycoins = [];

            if (in_array('weekly', $options['table_columns']) || in_array('last24h', $options['table_columns'])) {
                $options['coins'] = [];

                foreach($options['data'] as $coin) {
                    array_push($weeklycoins, $coin->slug);
                }

                $options['weekly'] = $this->get_weekly($weeklycoins);
            }
            
            $options['links'] = apply_filters('block_get_coinlinks', array(), $options);

            $data = [];
            $shortprice = ($options['price_format'] == 1) ? true : false;
            $options['exrate'] = $this->getexrate($table['currency']);
            
            $count = 0;
            foreach($options['data'] as $coin) {

                $temp = [];

                foreach ($options['table_columns'] as $column) {
                    
                    switch ($column) {
                        case 'no':
                            $temp['no'] = '<td class="text-left">' . ($count + 1) . '</td>';
                            break;

                        case 'rank':
                            $temp['rank'] = '<td class="text-left">' . $coin->rank . '</td>';
                            break;

                        case 'name':
                            $html = '<td class="text-left"><div class="coin"><div class="coin-image"><img src="' . str_replace('large', 'small', $coin->img) . '" height="35" alt="'. $coin->slug .'"></div>';
                            if (isset($options['links'][$coin->slug])) {
                                $html .= '<a href="' . $options['links'][$coin->slug] . '" class="coin-title"><div class="coin-name">' . $coin->name . '</div><div class="coin-symbol">' . $coin->symbol . '</div></a>';
                            } else if (isset($options['links'][$coin->symbol])) {
                                $html .= '<a href="' . $options['links'][$coin->symbol] . '" class="coin-title"><div class="coin-name">' . $coin->name . '</div><div class="coin-symbol">' . $coin->symbol . '</div></a>';
                            } else {
                                $html .= '<div class="coin-title"><div class="coin-name">' . $coin->name . '</div><div class="coin-symbol">' . $coin->symbol . '</div></div>';
                            }
                            $html .= '</div></td>';
                            $temp['name'] = $html;
                            break;

                        case 'symbol':
                            $temp['symbol'] = '<td>' . $coin->symbol . '</td>';
                            break;

                        case 'price_usd':
                            $temp['price_usd'] = '<td><span data-price="' . $coin->price_usd . '" data-rate="' . $options['exrate'] . '" data-currency="' . $table['currency'] . '" data-live-price="' . $shortcode->slugify($coin->name) . '">' . $shortcode->price_format($coin->price_usd, $options['exrate'], $table['currency']) . '</span></td>';
                            break;

                        case 'price_btc':
                            $temp['price_btc'] = '<td>Ƀ ' . $coin->price_btc . '</td>';
                            break;

                        case 'market_cap_usd':
                            $temp['market_cap_usd'] = '<td>' . $shortcode->price_format($coin->market_cap_usd, $options['exrate'], $table['currency'], $shortprice, 0) . '</td>';
                            break;

                        case 'volume_usd_24h':
                            $temp['volume_usd_24h'] = '<td>' . $shortcode->price_format($coin->volume_usd_24h, $options['exrate'], $table['currency'], $shortprice, 0) . '</td>';
                            break;

                        case 'available_supply':
                            $temp['available_supply'] = '<td>' . $shortcode->number_format($coin->available_supply, $table['currency'], $shortprice, 0) . ' '  . $coin->symbol . '</td>';
                            break;

                        case 'total_supply':
                            $temp['total_supply'] = '<td>' . ($coin->total_supply == '0' ? __('∞', 'coinpress') : $shortcode->number_format($coin->total_supply, $table['currency'], $shortprice, 0) . ' ' . $coin->symbol) . '</td>';
                            break;

                        case 'percent_change_1h':
                            $html = '<td>';
                            $html .= '<span data-table-change="' . $coin->symbol . '" class="' . (($coin->percent_change_1h >= 0) ? 'up' : 'down') . '">' . $shortcode->number_format($coin->percent_change_1h, $table['currency'], false, 2) . '%</span>';
                            $html .= '</td>';
                            $temp['percent_change_1h'] = $html;
                            break;

                        case 'percent_change_24h':
                            $html = '<td>';
                            $html .= '<span data-table-change="' . $coin->symbol . '" class="' . (($coin->percent_change_24h >= 0) ? 'up' : 'down') . '">' . $shortcode->number_format($coin->percent_change_24h, $table['currency'], false, 2) . '%</span>';
                            $html .= '</td>';
                            $temp['percent_change_24h'] = $html;
                            break;

                        case 'percent_change_7d':
                            $html = '<td>';
                            $html .= '<span data-table-change="' . $coin->symbol . '" class="' . (($coin->percent_change_7d >= 0) ? 'up' : 'down') . '">' . $shortcode->number_format($coin->percent_change_7d, $table['currency'], false, 2) . '%</span>';
                            $html .= '</td>';
                            $temp['percent_change_7d'] = $html;
                            break;

                        case 'percent_change_30d':
                            $html = '<td>';
                            $html .= '<span data-table-change="' . $coin->symbol . '" class="' . (($coin->percent_change_30d >= 0) ? 'up' : 'down') . '">' . $shortcode->number_format($coin->percent_change_30d, $table['currency'], false, 2) . '%</span>';
                            $html .= '</td>';
                            $temp['percent_change_30d'] = $html;
                            break;

                        case 'last24h':
                            $chartdata = array_slice($options['weekly'][$coin->slug], -24);
                            $temp['last24h'] = '<td><canvas width="135" height="40" data-rate="' . $options['exrate'] . '" data-currency="'. $table['currency'] .'" data-color="' . apply_filters('coinmc_chart_color', $options['chart_color'], $options, $coin) . '" data-gradient="50" data-border="2" data-points="' . implode(',', $chartdata) . '"></canvas></td>';
                            break;

                        case 'weekly':
                            $chartdata = [];
                            for ($counter = 0; $counter <= 167; $counter++ ) {
                                if ($counter % 6 == 0) {
                                    $chartdata[] = isset($options['weekly'][$coin->slug][$counter]) ? $options['weekly'][$coin->slug][$counter] : 0;
                                }
                            }
                            $temp['weekly'] = '<td><canvas width="135" height="40" data-rate="' . $options['exrate'] . '" data-currency="' . $table['currency'] .'" data-color="' . apply_filters('coinmc_chart_color', $options['chart_color'], $options, $coin) . '" data-gradient="50" data-border="2" data-points="' . implode(',', $chartdata) . '"></canvas></td>';
                            break;

                        case 'actions':
                            $actionText = (!empty($watchlistCoins) && in_array($coin->slug, $watchlistCoins)) ? 'Remove from Watchlist' : 'Add to Watchlist';
                            $html = '<td>';
                            $html .= '<div class="coinmc-dropdown" data-position="bottom-end" data-theme="' . $options['table_style'] . '">';
                            $html .= '<span class="coinmc-control coinmc-button"><i class="fas fa-ellipsis-h"></i></span>';
                            $html .= '<ul class="cryptoboxes coinpage coinmc-dropdown__list">';
                            $html .= '<li class="coinmc-dropdown__item"><a href="javascript:void(0);" data-action="watchlist" data-value="' . $coin->slug . '"><i class="far fa-star"></i> '. __($actionText, 'coinpress') . '</a></li>';
                            if ($this->options['config']['changelly'] !== '' && strpos($this->options['config']['changelly'], 'changelly.com') !== false) {
                                $html .= '<li class="coinmc-dropdown__item"><a href="https://changelly.com/exchange/USD/'. $coin->symbol .'/1?ref_id='. (($this->options['config']['changelly'] === '') ? '' : explode('?ref_id=', $this->options['config']['changelly'])[1]) .'" target="_blank" rel="nofollow"><i class="fas fa-shopping-cart"></i>'.__('Buy Now', 'coinpress').'</a></li>';
                                $html .= '<li class="coinmc-dropdown__item"><a href="https://changelly.com/exchange/'. $coin->symbol .'/BTC/1?ref_id='. (($this->options['config']['changelly'] === '') ? '' : explode('?ref_id=', $this->options['config']['changelly'])[1]) .'" target="_blank" rel="nofollow"><i class="fas fa-shopping-cart"></i>'.__('Sell Now', 'coinpress').'</a></li>';
                            } else if ($this->options['config']['changelly'] !== '') {
                                $trade_url = str_replace(array('{symbol}', '{slug}'), array($coin->symbol, $coin->slug), $this->options['config']['changelly']);
                                $html .= '<li class="coinmc-dropdown__item"><a href="' . $trade_url . '" target="_blank" rel="nofollow"><i class="fas fa-shopping-cart"></i>'.__('Buy Now', 'coinpress').'</a></li>';
                                $html .= '<li class="coinmc-dropdown__item"><a href="' . $trade_url . '" target="_blank" rel="nofollow"><i class="fas fa-shopping-cart"></i>'.__('Sell Now', 'coinpress').'</a></li>';
                            }
                            $html .= '</ul>';
                            $html .= '</div>';
                            $html .= '</td>';
                            $temp['actions'] = $html;
                            break;

                    }
        
                }
                $count++;
        
                $data[] = $temp;
            }

            $output = array(
                'recordsTotal' => $numcoins,
                'recordsFiltered' => $numcoins,
                'draw'=> $_GET['draw'],
                'data'=> $data
            );
            
            wp_send_json($output);

        }

        public function ajax_reddit() {

            $sub = $_GET['sub'];
            $cache = get_transient('coinmc-r-' . end(explode('/', $sub)));
            $output = $cache;

            if ($cache === false) {
                $request = wp_remote_get($sub . '.json?limit=10');
                $body = wp_remote_retrieve_body($request);
                $data = json_decode($body);

                if ($data) {
                    $shortcode = new Coinmarketcap_Shortcodes();
                    $shortcode->config = $this->options['config'];
                    $output = $shortcode->reddit_content($data);
                    set_transient('coinmc-r-' . end(explode('/', $sub)), $output, DAY_IN_SECONDS);
                }
            }

            wp_die($output);
        }

        public function time_ago($datetime, $full = false) {
            $now = new DateTime;
            $ago = new DateTime(gmdate("Y-m-d H:i:s", $datetime));
            $diff = $now->diff($ago);
        
            $diff->w = floor($diff->d / 7);
            $diff->d -= $diff->w * 7;
        
            $string = array(
                'y' => __('year', 'coinpress'),
                'm' => __('month', 'coinpress'),
                'w' => __('week', 'coinpress'),
                'd' => __('day', 'coinpress'),
                'h' => __('hour', 'coinpress'),
                'i' => __('minute', 'coinpress'),
                's' => __('second', 'coinpress'),
            );
            foreach ($string as $k => &$v) {
                if ($diff->$k) {
                    $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                } else {
                    unset($string[$k]);
                }
            }
        
            if (!$full) $string = array_slice($string, 0, 1);
            return $string ? implode(', ', $string) . ' ' . __('ago', 'coinpress') : __('just now', 'coinpress');
        }

        public function change_chart_color($color, $options, $coin) {
            if ($color) {
                $hex = str_replace('#', '', $color);
                list($red, $green, $blue) = sscanf($hex, "%02x%02x%02x");
                return $red . ',' . $green . ',' . $blue;
            } else if (isset($coin->percent_change_24h)) {
                return (($coin->percent_change_24h > 0) ? '10,207,151' : '239,71,58');
            }
            return '40,97,245';
        }

        public function refreshLicenseFromPluginInfo($pluginInfo, $result) {
            if (!is_wp_error($result) && isset($result['response']['code'])&& ($result['response']['code'] == 200) && !empty($result['body'])) {
                $apiResponse = json_decode($result['body']);
                if (is_object($apiResponse) && isset($apiResponse->license) && $apiResponse->license === 'false' && $apiResponse->license !== $this->options['config']['license']) {
                    $update = array('license' => 'false', 'license_key' => '');
                    $this->options['config'] = array_merge($this->options['config'], $update);
                    update_option('coinmc_config', $this->options['config']);
                }
            }
            return $pluginInfo;
        }

    }

}

$coinpress = new Coinmarketcap_Prices();