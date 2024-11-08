<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://abc.com
 * @since      1.0.0
 *
 * @package    Trade_Fish
 * @subpackage Trade_Fish/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Trade_Fish
 * @subpackage Trade_Fish/admin
 * @author     Hztech <obaidullah@hztech.biz>
 */
class Trade_Fish_Admin


{

	// Add the following code to your theme's functions.php file or a custom plugin

	function custom_rest_api_history()
	{
		register_rest_route(
			'fish_trade_api/v1',  // Your unique namespace
			'/get_post',   // The endpoint route
			array(
				'methods' => 'GET',
				'callback' => array($this, 'get_post_history'),
			)
		);
		register_rest_route(
			'fish_trade_api/v1',  // Your unique namespace
			'/get_signals_data',   // The endpoint route
			array(
				'methods' => 'GET',
				'callback' => array($this, 'get_signals_data_api'),
			)
		);
		register_rest_route(
			'fish_trade_api/v1',  // Your unique namespace
			'/syncnewcoins',   // The endpoint route
			array(
				'methods' => 'GET',
				'callback' => array($this, 'syncnewcoins'),
			)
		);
		register_rest_route('fish_trade_api/coins/v1', '/posts/', array(
			'methods' => 'GET',
			'callback' => array($this,'get_coins_new_posts'),
		));
		register_rest_route(
			'fish_trade_api/v1',  // Your unique namespace
			'/add_dataSupaBase',   // The endpoint route
			array(
				'methods' => 'GET',
				'callback' => array($this, 'add_data_in_supabase'),
				'args' => array(
					'page' => array(
						'required' => false,
						'validate_callback' => function($param, $request, $key) {
							return is_numeric($param);
						}
					),
				),
			)
		);


	}

	function get_coins_new_posts() {
		$args = array(
			'post_type' => 'coins_new',
			'posts_per_page' => -1, // Adjust this value if needed
			'post_status' => 'publish',
		);

		$query = new WP_Query($args);
		$posts = array();

		if ($query->have_posts()) {
			while ($query->have_posts()) {
				$query->the_post();

				$post_id = get_the_ID();
				$thumbnail_id = get_post_thumbnail_id($post_id);
				$thumbnail_url = wp_get_attachment_image_url($thumbnail_id, 'full');
				$attachment_post = get_post($thumbnail_id);
				$attachment_id = $attachment_post ? $attachment_post->ID : null;

				$posts[] = array(
					'id' => $post_id,
					'title' => get_the_title(),
					'thumbnail_id' => $thumbnail_id,
					'thumbnail_url' => $thumbnail_url,
					'attachment_id' => $attachment_id
				);
			}
			wp_reset_postdata();
		}

		return new WP_REST_Response($posts, 200);
	}

	function add_data_in_supabase($data) {
		// Get the current page and number of posts per page from query parameters
		$page = isset($data['page']) ? intval($data['page']) : 1;
		$posts_per_page = 20; // Number of posts per page

		// Prepare the query to get posts of custom post type 'signals' with pagination
		$args = array(
			'post_type' => 'signals',
			'posts_per_page' => $posts_per_page, // Fetch posts per page
			'paged' => $page, // Current page number
			'orderby' => 'ID',
			'order' => 'ASC', // Order by ID in ascending order
		);

		// Execute the query
		$query = new WP_Query($args);

		// Prepare an array to store the data
		$signls_data = array();

		if ($query->have_posts()) {
			while ($query->have_posts()) {
				$query->the_post();

				// Get the post data
				$post_data = array(
					'id' => get_the_ID(),
					'title' => get_the_title(),
					'content' => get_the_content(),
					'ticker_type' => get_post_meta(get_the_ID(), 'ticker_type', true),
					'confidence' => get_post_meta(get_the_ID(), 'confidence', true),
					'signal_value_in' => get_post_meta(get_the_ID(), 'signal_value', true),
					'opening_price' => get_post_meta(get_the_ID(), 'opening_price', true),
					'currency' => get_post_meta(get_the_ID(), 'currency', true),
					'risk_label' => get_post_meta(get_the_ID(), 'risk_label', true),
					'advise_text' => get_post_meta(get_the_ID(), 'advise_text', true),
					'closing_date' => get_post_meta(get_the_ID(), 'closing_date', true),
					'title_name' => get_post_meta(get_the_ID(), '_post_title', true),
					'ai_model_drop_down' => get_post_meta(get_the_ID(), 'ai_model_drop_down', true),
					'trading_referral_drop_down' => get_post_meta(get_the_ID(), 'trading_referral_drop_down', true),
//                    'platform_url' => get_post_meta(get_the_ID(), 'platform_url', true),
					'signal_result' => get_post_meta(get_the_ID(), '_signal_result', true),
					'closing_price' =>  get_post_meta(get_the_ID(),'closing_price',true),
					'opening_date'  => get_post_field('post_date', get_the_ID()),
				);

				// Add the post data to the results array
				$signls_data[] = $post_data;
			}
			wp_reset_postdata();
		}

		foreach ($signls_data as $signal) {
			$platform_Id = $signal['trading_referral_drop_down'];


			// use to get platform url and platform name
			if(!empty($platform_Id) && $platform_Id !== "") {
				$selected_trading_referral_link = get_post_meta($platform_Id, 'trading_referral_link', true);
				$link = $selected_trading_referral_link;
				$platform_name = get_the_title($platform_Id);
				$platform_url = $link;
			}else{
				$platform_name = null;
				$platform_url = null;
			}

			$ai_modelId = $signal['ai_model_drop_down'];
			if(!empty($ai_modelId) && $ai_modelId !== "") {
				$selected_post = get_post($ai_modelId);
				$title = isset($ai_modelId) ? $selected_post->post_title : null;
			}
			else{
				$title = null;
			}

//            var_dump("here3");

			if(empty($signal['currency'])){
//                var_dump("here");
				$signal['currency'] = 'USD';
			}
			if(empty($signal['advise_text'])){
//                var_dump("here2");
//
				$signal['advise_text'] =  "We advise users to not use any leverage unless they are very proficient traders";
			}

			$this->check_signal_supabase(
				$signal['id'],
				$signal['title'],
				$signal['ticker_type'],
				$signal['confidence'],
				$signal['signal_value_in'],
				$signal['opening_price'],
				$signal['currency'],
				$signal['risk_label'],
				$title,
				$signal['advise_text'],
				$platform_url,
				$platform_name,
				$signal['signal_result'],
				$signal['closing_date'],
				$signal['closing_price'],
				$signal['opening_date']

			);
		}

		// Return the data as a JSON response
		return new WP_REST_Response(array(
			                            'data' => $signls_data,
			                            'page' => $page,
			                            'posts_per_page' => $posts_per_page,
			                            'total_pages' => $query->max_num_pages,
		                            ), 200);    }


	function get_signals_data_api()
	{

		global $wpdb;
		$data = [];

		$current_year = date('Y');
		for ($i = 1; $i <= 12; $i++) {
			$results = $wpdb->get_results("
    SELECT MONTH(post_date) as month, COUNT(*) as count
    FROM $wpdb->posts
    WHERE post_type = 'signals'
      AND post_status = 'publish'
      AND MONTH(post_date) = $i
      AND YEAR(post_date) = $current_year
    GROUP BY MONTH(post_date)
");
			$data[$i] = isset($results[0]) ? $results[0]->count : 0;
		}


	}

	function get_post_history()
	{

		$args = array(
			'post_type' => 'signals',
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',
		);

		$posts = get_posts($args);
		$title_counts = array();

		foreach ($posts as $post) {
			$title = $post->post_title;
			$title_counts[$title] = isset($title_counts[$title]) ? $title_counts[$title] + 1 : 1;
		}
		arsort($title_counts);

		$top_six_titles = array_slice($title_counts, 0, 6, true);
		$url = home_url('trading-signals');
//        $this->dd($url);
		$result = [];
		foreach ($top_six_titles as $title => $count) {
			$result[] = array(
				'title' => $title,
				'count' => $count,
			);

		}


	}

	public function dd()
	{
		$arguments = func_get_args();

		foreach ($arguments as $argument) {
			echo '<pre>';
			var_dump($argument);
			echo '</pre>';
		}

		die();
	}

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 * @since    1.0.0
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;


	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Trade_Fish_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Trade_Fish_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/trade-fish-admin.css', array(), $this->version, 'all');
		wp_enqueue_style('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css', array(), '4.0.13', 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Trade_Fish_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Trade_Fish_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/trade-fish-admin.js', array('jquery'), rand(), false);
		wp_enqueue_script(
			'select2',
			'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
			array('jquery'),
			'4.1.0',
			true
		);
        $post_type = isset($_GET['post_type']) ? $_GET['post_type'] :  '';
		wp_localize_script($this->plugin_name, 'custom_admin_vars', array(
			'custom_nonce' => wp_create_nonce('custom_nonce'),
			'ajax_url' => admin_url('admin-ajax.php'),
			'post_type' => $post_type // Get the current post type
		));
	}

	public function telegram_key($msg,$image_url='')
	{
//        test
		$apiToken = "6765149908:AAEy8FT1693IDpzTTvC8cmnTmG_Mlln1tPk";
		$chat_id = '@tradefish120';
//        live
//         $apiToken = "6115542028:AAFSBa-kqQuUFdl5za8rVBAMFGBZ28EbIvY";
//         $chat_id = '-1002127518060';
		if($image_url == '') {
			$data = [
//            'chat_id' => '-1002127518060',
				'chat_id' => $chat_id,
				'text' => $msg,
				'parse_mode' => 'Html',
				'disable_web_page_preview' => true
			];
			$response = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" .
			                              http_build_query($data));
			return $response ? true : false;

		}else {
			// Create an associative array for the data to be sent
			$data = [
				'chat_id' => $chat_id,
				'photo' => $image_url,
				'caption' => $msg,
				'parse_mode' => 'HTML'
			];

// Make a request to the sendPhoto endpoint with the given data
			$url = "https://api.telegram.org/bot$apiToken/sendPhoto";
			$options = [
				'http' => [
					'method' => 'POST',
					'header' => 'Content-Type: application/x-www-form-urlencoded',
					'content' => http_build_query($data)
				]
			];
			$context = stream_context_create($options);
			$response = file_get_contents($url, false, $context);
			return $response ? true : false;
		}
	}
	public function twitter_api($msg)
	{

		$data = ['text' => $msg];
		$jsonPayload = json_encode($data);


		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://api.twitter.com/2/tweets',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => $jsonPayload,
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Authorization: OAuth oauth_consumer_key="uiFnhXQYO81WWamlFiJLnCmXC",oauth_token="1303459612021198848-gyFqmZC3FzhsaMHSTVQChSizo9Q3oF",oauth_signature_method="HMAC-SHA1",oauth_timestamp="1705660693",oauth_nonce="h86C5pLMn7z",oauth_version="1.0",oauth_signature="TApfJNADbkefotjLczxDJjJc4cE%3D"',
				'Cookie: guest_id=v1%3A170540573441943863'
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		return $response ? true : false;
	}

	public function signals_post_type()
	{
		$labels = array(
			'name' => _x('Signals', 'post type general name', 'your-text-domain'),
			'singular_name' => _x('Signal', 'post type singular name', 'your-text-domain'),
			'menu_name' => _x('Signals', 'admin menu', 'your-text-domain'),
			'name_admin_bar' => _x('Signal', 'add new on admin bar', 'your-text-domain'),
			'add_new' => _x('Add New', 'signal', 'your-text-domain'),
			'add_new_item' => __('Add New Signal', 'your-text-domain'),
			'new_item' => __('New Signal', 'your-text-domain'),
			'edit_item' => __('Edit Signal', 'your-text-domain'),
			'view_item' => __('View Signal', 'your-text-domain'),
			'all_items' => __('All Signals', 'your-text-domain'),
			'search_items' => __('Search Signals', 'your-text-domain'),
			'parent_item_colon' => __('Parent Signals:', 'your-text-domain'),
			'not_found' => __('No signals found.', 'your-text-domain'),
			'not_found_in_trash' => __('No signals found in Trash.', 'your-text-domain'),
			'archives' => __('Item Archives', 'text_domain'),
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'query_var' => true,
			'rewrite' => array('slug' => 'signals'),
			'capability_type' => 'post',
			'has_archive' => true,
			'hierarchical' => true,
			'menu_position' => 6,
			'menu_icon' => 'dashicons-megaphone',
			'supports' => array('title', 'editor', 'thumbnail'),

		);

		register_post_type('signals', $args);
	}

	function custom_signals_query($query)
	{
		if (is_admin() && $query->is_main_query() && $query->get('post_type') == 'signals') {
			if(isset($_GET['filter_by_type'])){
				if($_GET['filter_by_type'] == 'closed'){
					$query->set('meta_key', 'closing_date'); // Change 'closing_date' to the meta key you want to filter by
					$query->set('meta_compare', '!IS NULL'); // Change 'closing_date' to the meta key you want to filter by
					$query->set('orderby', 'meta_value');
					$query->set('order', 'DESC');
				}
				else if($_GET['filter_by_type'] == 'active'){
//                    var_dump('here');
					$meta_query = array(
						array(
							'key' => 'closing_date',
							'compare' => 'NOT EXISTS'
						),

					);
					$query->set('meta_query', $meta_query);
					$query->set('orderby', 'ID');
					$query->set('order', 'DESC');

				}else{
					$query->set('orderby', 'ID');
					$query->set('order', 'DESC');
				}
			}
			else{
				$query->set('orderby', 'ID');
				$query->set('order', 'DESC');
			}

//            $query->set('meta_key', 'closing_date');
//            $query->set('orderby', 'meta_value_num');

//            $args = $query->query_vars;
//            $args['meta_compare'] = 'NOT EXISTS';

//            $null_q = new WP_Query($args);
//            $combine_posts = array_merge($null_q->posts, $query->get('posts'));
//            $query->set('posts', $combine_posts);
		}
	}

	public function custom_signals_posts(&$posts)
	{
		if (isset($_GET['aa'])) {
			var_dump($posts);
		}

		return $posts;
	}

	public function add_signals_title_field($post)
	{
		if ($post->post_type === 'signals') {
			$second_dropdown = get_post_meta($post->ID, '_post_title', true);
			$_custom_title = get_post_meta($post->ID, '_custom_title', true);
			$selected_coin_type = get_post_meta($post->ID, 'selected_coin_type', true);
			$_coin_symbol = get_post_meta($post->ID, '_coin_symbol', true);
			$get_post = get_post($second_dropdown);
			$coin_display_image = get_the_post_thumbnail_url($get_post);
			$get_post_title = ($get_post) ? $get_post->post_title : '';
			ob_start();
			$public_url = plugin_dir_path(__FILE__) . 'partials/trade-fish-admin-signals-post_title.php';
			include $public_url;
		}
	}


	public function add_signal_details_meta_box()
	{
		add_meta_box(
			'signal_details_meta_box',         // Unique ID
			'Signal Details',                  // Box title
			array($this, 'display_signal_details_meta_box'), // Callback function to display the meta box content
			'signals',                         // Post type
			'normal',                          // Context (normal, advanced, side)
			'high'                             // Priority (high, core, default, low)
		);
	}


	public function display_signal_details_meta_box($post)
	{
		$confidence = get_post_meta($post->ID, 'confidence', true);
//        $this->dd($confidence);
		$signal_value = get_post_meta($post->ID, 'signal_value', true);
		$opening_price = get_post_meta($post->ID, 'opening_price', true);
		$currency = get_post_meta($post->ID, 'currency', true);
		$post_on_twitter = get_post_meta($post->ID, 'post_on_twitter', true);
		$post_on_telegram = get_post_meta($post->ID, 'post_on_telegram', true);
		$ticker_type = get_post_meta($post->ID, 'ticker_type', true);
		$expected_position_holding = get_post_meta($post->ID, 'expected_position_holding', true);
		$risk_label = get_post_meta($post->ID, 'risk_label', true);
		$advise_text = get_post_meta($post->ID, 'advise_text', true);

//        $this->dd($advise_text);
		$ai_model = get_post_meta($post->ID,'ai_model',true);
		$trading_referral_title = get_post_meta($post->ID,'trading_referral_title',true);
		$trading_referral_link = get_post_meta($post->ID,'trading_referral_link',true);
		$currencies = $this->get_currencies();


		$args_trading_referral = array(
			'post_type' => 'trading_referral',
			'posts_per_page' => -1,
		);
		$trading_referral = new WP_Query($args_trading_referral);

		// AI MODEL DROP DOWN
		$args = array(
			'post_type' => 'ai_model',
			'posts_per_page' => -1,
		);
		$ai_models = new WP_Query($args);

		$selected_ai_model = get_post_meta($post->ID, 'ai_model_drop_down', true);
		$selected_trading_referral = get_post_meta($post->ID, 'trading_referral_drop_down', true);


		ob_start();
		$public_url = plugin_dir_path(__FILE__) . 'partials/trade-fish-admin-signal-details.php';
		include $public_url;
	}


	public function update_post_meta($post_id, $post, $update)
	{

		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}
		if (wp_is_post_revision($post_id)) {
			return $post_id;
		}
//        update_post_meta($post_id, 'closing_date', '');

		$select_coin_type = $_POST['select_coin_type'];
		update_post_meta($post_id, 'selected_coin_type', $select_coin_type);
		$new_coin_name = $_POST['new_coin_name'];
		$new_coin_shortname = $_POST['new_coin_shortname'];
		$coin_thumbnail_id = $_POST['coin_thumbnail_id'];


		$is_post_update = get_post_meta($post_id, 'is_post_update', true);
		$is_post_update_twitter = get_post_meta($post_id, 'is_post_update_twitter', true);
		$_edit_post = get_post_meta($post_id, '_edit_post', true);

		if (!current_user_can('edit_post', $post_id)) {
			return $post_id;
		}
		if (get_post_type($post_id) !== 'signals') {
			return $post_id;
		}


		$ai_modelId =  $_POST['ai_model_drop_down'];
		$platform_Id = $_POST['trading_referral_drop_down'];


		$title = get_the_title($ai_modelId);

		$selected_trading_referral_link = get_post_meta($platform_Id,'trading_referral_link',true);
		$link = $selected_trading_referral_link;
		$platform_name = get_the_title($platform_Id);
//        $title = get_the_title($selected_trading_referral_id);

		$platform_url = $link;


		if (isset($select_coin_type) && $select_coin_type != 'new_ticker') {
//            var_dump("here321");

			$selected_post_id = sanitize_text_field($_POST['_second_dropdown']);
			$selected_post = get_post($selected_post_id);

			$this->check_signal_supabase($post_id,$selected_post->post_title,
			                             $_POST['ticker_type'],
			                             $_POST['confidence'],
			                             $_POST['signal_value'],
			                             $_POST['opening_price'],
			                             $_POST['currency'],
			                             $_POST['risk_label'],
			                             $title,
			                             $_POST['advise_text'],
			                             $platform_url,
			                             $platform_name,
			                             null,
			                             null,
			                             null,
			                             get_post_field('post_date', $post_id),
			);

			if ($selected_post) {
				$symbol = get_post_meta($selected_post->ID, '_coin_symbol', true);
				$post_title = $selected_post->post_title;
				if ($post_title !== get_the_title($post_id)) {
					remove_action('save_post', array($this, 'update_post_meta'));
					wp_update_post(array('ID' => $post_id, 'post_title' => $post_title));
					add_action('save_post', array($this, 'update_post_meta'));
					update_post_meta($post_id, '_post_title', $selected_post_id);
					if ($symbol != '') {
						update_post_meta($post_id, '_coin_symbol', $symbol);
					}
				}
			}
		} elseif ($select_coin_type == 'new_ticker' && $_edit_post != 'yes') {

			$args = array(
				'post_title' => $new_coin_name,
				'post_status' => 'publish',
				'post_type' => 'coins_new',

			);

			$new_post_id = wp_insert_post($args);
			if (!is_wp_error($new_post_id)) {
				set_post_thumbnail($new_post_id, $coin_thumbnail_id);
				update_post_meta($new_post_id, '_coin_symbol', $new_coin_shortname);
				update_post_meta($new_post_id, '_coin_type', $_POST['ticker_type']);

				$ai_modelId =  $_POST['ai_model_drop_down'];
				$platform_Id = $_POST['trading_referral_drop_down'];


				$title = get_the_title($ai_modelId);

				$selected_trading_referral_link = get_post_meta($platform_Id,'trading_referral_link',true);
				$link = $selected_trading_referral_link;
				$platform_name = get_the_title($platform_Id);
//        $title = get_the_title($selected_trading_referral_id);

				$platform_url = $link;


				$this->check_signal_supabase($new_post_id,$new_coin_name,
				                             $_POST['ticker_type'],
				                             $_POST['confidence'],
				                             $_POST['signal_value'],
				                             $_POST['opening_price'],
				                             $_POST['currency'],
				                             $_POST['risk_label'],
				                             $title,
				                             $_POST['advise_text'],
				                             $platform_url,
				                             $platform_name,
				                             null,
				                             null,
				                             null,
				                             get_post_field('post_date', $post_id),
				);

				$selected_post = get_post($new_post_id);
				if ($selected_post) {
					$post_title = $selected_post->post_title;
					if ($post_title !== get_the_title($post_id)) {
						remove_action('save_post', array($this, 'update_post_meta'));
						wp_update_post(array('ID' => $post_id, 'post_title' => $post_title));
						add_action('save_post', array($this, 'update_post_meta'));
						update_post_meta($post_id, '_post_title', $new_post_id);
						if ($new_coin_shortname != '') {
							update_post_meta($post_id, '_coin_symbol', $new_coin_shortname);
						}
					}
				}
			}

			update_post_meta($post_id, '_edit_post', 'yes');

		}

		if (isset($_POST['_custom_title'])) {
			update_post_meta($post_id, '_custom_title', $_POST['_custom_title']);
		}
		if (isset($_POST['ticker_type'])) {
			update_post_meta($post_id, 'ticker_type', $_POST['ticker_type']);
		}
		if (isset($_POST['confidence'])) {
			update_post_meta($post_id, 'confidence', $_POST['confidence']);
		}
		if (isset($_POST['signal_value'])) {
			update_post_meta($post_id, 'signal_value', $_POST['signal_value']);
		}
		if (isset($_POST['opening_price'])) {
			update_post_meta($post_id, 'opening_price', $_POST['opening_price']);
		}
		if (isset($_POST['currency'])) {
			update_post_meta($post_id, 'currency', $_POST['currency']);
		}
		if (isset($_POST['expected_position_holding'])) {
			update_post_meta($post_id, 'expected_position_holding', $_POST['expected_position_holding']);
		}
		if (isset($_POST['risk_label'])) {
			update_post_meta($post_id, 'risk_label', $_POST['risk_label']);
		}
		if (isset($_POST['post_on_twitter'])) {
			update_post_meta($post_id, 'post_on_twitter', $_POST['post_on_twitter']);
		}
		if (isset($_POST['post_on_telegram'])) {
			update_post_meta($post_id, 'post_on_telegram', $_POST['post_on_telegram']);
		}
		if (isset($_POST['advise_text'])) {
			update_post_meta($post_id, 'advise_text', $_POST['advise_text']);
		}
		if (get_post_meta($post_id, '_signal_result', true) == '' && empty(get_post_meta($post_id, '_signal_result', true))) {
			update_post_meta($post_id, '_signal_result', 'unset');
		}
		if (isset($_POST['ai_model_drop_down'])) {
			update_post_meta($post_id, 'ai_model_drop_down', sanitize_text_field($_POST['ai_model_drop_down']));
		}

		if (isset($_POST['trading_referral_drop_down'])) {
			update_post_meta($post_id, 'trading_referral_drop_down', sanitize_text_field($_POST['trading_referral_drop_down']));
		}

		if (isset($_POST['trading_referral_link'])) {
			update_post_meta($post_id, 'trading_referral_link', $_POST['trading_referral_link']);
		}

		if (isset($_POST['trading_referral_title'])) {
			update_post_meta($post_id, 'trading_referral_title', $_POST['trading_referral_title']);
		}




		$msg = '';
		$signal_post_title = str_replace(['“', '”'], '', get_the_title($post_id));
		$decoded_title = html_entity_decode($signal_post_title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
		$token_name = $_POST['_custom_title'] != '' && !empty($_POST['_custom_title'])
			? ucwords($_POST['_custom_title']) : $decoded_title;
		$ticker_type = $_POST['ticker_type'];
		$modified_ticker_type = $ticker_type != '' && $ticker_type == 'fx'
			? mb_strtoupper($ticker_type) : ucfirst($ticker_type);
		$getcurrencies = $this->get_currencies();
		$currency = $_POST['currency'];
		$sign = $getcurrencies[$currency];
		$expected_position_holding = ucfirst(str_replace('_', '-', $_POST['expected_position_holding']));

		$advise_text = $_POST['advise_text'];
		// Get the GMT date and time of the post creation
		$post_date_gmt = get_post_time('U', true, $post_id, true);
		$date_gmt = new DateTime();
		$date_gmt->setTimestamp($post_date_gmt);
		$date_gmt->setTimezone(new DateTimeZone('UTC'));
		$formatted_date = $date_gmt->format('d M. Y, H:i:s T');

		$confidence = $_POST['confidence'];
		$risk_label = $_POST['risk_label'];


		if ($_POST['post_on_telegram'] != '' && !empty($_POST['post_on_telegram'])) {
			if ($is_post_update !== 'yes') {
				if ($token_name != '' && !empty($token_name)) {
					$msg = "🔔 <b>New FishAI Signal:</b> ".$token_name ;
					$msg .= "\n";
					$msg .= "\n";
					$msg .= "<b> » Ticker: </b>$" . (($symbol != '') ? $symbol : $token_name);
				}

				if ($modified_ticker_type != '' && !empty($modified_ticker_type)) {
					$msg .= "\n";
					$msg .= "<b> » Type:</b> " . $modified_ticker_type;
				}
				if ($_POST['signal_value'] != '' && !empty($_POST['signal_value'])) {
					$msg .= "\n";
					$msg .= "<b> » Position:</b> " . ucfirst($_POST['signal_value']);
				}
				if ($_POST['opening_price'] != '' && !empty($_POST['opening_price'])) {
					$msg .= "\n";
					if(is_numeric($_POST['opening_price']) && floor($_POST['opening_price']) != $_POST['opening_price']){
						$msg .= "<b> » Entry Price:</b> " . $sign . $_POST['opening_price'];
					}
					else{
						$number = number_format($_POST['opening_price']);
						$msg .= "<b> » Entry Prices:</b> " . $sign . $number;
					}
				}
				if (isset($_POST['ai_model_drop_down']) && $_POST['ai_model_drop_down'] != '') {
					$selected_ai_model_id = $_POST['ai_model_drop_down'];
					$selected_ai_model_name = get_the_title($selected_ai_model_id);
					$msg .= "\n";
					$msg .= "<b> » AI Model:</b> " . ucfirst($selected_ai_model_name);
				}



				$msg .= "\n";
				$msg .= "<b> » Time:</b> " . $formatted_date;
				if ($expected_position_holding != '' && !empty($expected_position_holding)) {
					$msg .= "\n";
					$msg .= "<b> » Expected Position Holding:</b> " . $expected_position_holding;
				}
				if ($confidence != '' && !empty($confidence)) {
					if (strpos($confidence, '%') !== false) {
						$msg .= "\n";
						$msg .= "<b> » Confidence score:</b> " . $confidence;
					}else{
						$msg .= "\n";
						$msg .= "<b> » Confidence score:</b> " . $confidence."%";
					}

				}
				if ($risk_label != '' && !empty($risk_label)) {
					$risk = str_replace('_'," ",$risk_label);
					$msg .= "\n";
					$msg .= "<b> » Risk:</b> " . ucwords($risk);
				}

				$msg .= "\n";
				$msg .= "\n";
//                $msg .= "<i><b>" . $advise_text . "</b></i>";
//                $msg .= "\n";
//                $msg .= "\n";

				if (isset($_POST['trading_referral_drop_down']) && $_POST['trading_referral_drop_down'] != '') {
					$selected_trading_referral_id = $_POST['trading_referral_drop_down'];
					$selected_trading_referral_link = get_post_meta($selected_trading_referral_id,'trading_referral_link',true);
					$link = $selected_trading_referral_link;
					$title = get_the_title($selected_trading_referral_id);
					$msg .= "<b>Trade Now: </b><a href=\"$link\">$title</a>";
				}
				$img_url = 'https://tradefish.app/wp-content/uploads/2024/04/tradefish_signal_new.jpg';

				$this->telegram_key($msg,$img_url);
				update_post_meta($post_id, 'is_post_update', 'yes');
			}
//            } else {
//                $msg = "🐟 <b>TradeFish AI has Updated a  Signal: " . $token_name . " </b>🌟";
//                $msg .= "\n";
//                $msg .= "\n";
//                $msg .= "<b> » Ticker: $" . (($symbol != '') ? $symbol: $token_name) . "</b>";
//                $msg .= "\n";
//                $msg .= "<b> » Type:</b> " . $modified_ticker_type;
//                $msg .= "\n";
//                $msg .= "<b> » Position:</b> " . ucfirst($_POST['signal_value']);
//                $msg .= "\n";
//                $msg .= "<b> » Entry Price:</b> " . $sign . $_POST['opening_price'];
//                $msg .= "\n";
//                $msg .= "<b> » Time:</b> " . $formatted_date;
//                $msg .= "\n";
//                $msg .= "<b> » Expected Position Holding:</b> " . $expected_position_holding;
//                $msg .= "\n";
//                $msg .= "\n";
//                $msg .= "<i><b>" . $advise_text . "</b></i>";
//                $msg .= "\n";
//                $msg .= "\n";
//                $msg .= "<b>More info:</b> tradefish.app";
//                $this->telegram_key($msg);
//            }

		}

		$text = '';
		if ($_POST['post_on_twitter'] != '' && !empty($_POST['post_on_twitter'])) {
			if ($is_post_update_twitter !== 'yes') {
				$text = "🐟 TradeFish AI has initiated a new Signal: " . $token_name . " 🌟";
				$text .= "\n";
//				$text .= "\n";
				$text .= "Ticker: $" . get_the_title($post_id);
				$text .= "\n";
//				$text .= "\n";
				$text .= "Type: " . $modified_ticker_type;
//				$text .= "\n";
				$text .= "Position: " . ucfirst($_POST['signal_value']);
//				$text .= "\n";
				$text .= "Entry Price: " . $sign . $_POST['opening_price'];
//				$text .= "\n";
				$text .= "Time: " . $formatted_date;
//				$text .= "\n";
//				$text .= "\n";
				$text .= "Expected Position Holding: " . $expected_position_holding;
//				$text .= "\n";
//				$text .= "\n";
//                $text .= "We advise users to not use any leverage unless they are very proficient traders.";
//                  $text .= "More info: https://tradefish.app/trading-signals";

				$this->twitter_api($text);
				update_post_meta($post_id, 'is_post_update_twitter', 'yes');
			} else {
				$text = "🐟 TradeFish AI has Updated a  Signal: " . $token_name . " 🌟";
				$text .= "\n";
//				$text .= "\n";
				$text .= "Ticker: $" . get_the_title($post_id);
				$text .= "\n";
//				$text .= "\n";
				$text .= "Type: " . $modified_ticker_type;
				$text .= "\n";
				$text .= "Position: " . ucfirst($_POST['signal_value']);
				$text .= "\n";
				$text .= "Entry Price: " . $sign . $_POST['opening_price'];
				$text .= "\n";
				$text .= "Time: " . $formatted_date;
//				$text .= "\n";
//				$text .= "\n";
				$text .= "Expected Position Holding: " . $expected_position_holding;
//				$text .= "\n";
//				$text .= "\n";
//                $text .= "We advise users to not use any leverage unless they are very proficient traders.";
//                  $text .= "More info: https://tradefish.app/trading-signals";

				$this->twitter_api($text);
			}
		}

	}


	public function get_signals_data()
	{
		$search_term = sanitize_text_field($_GET['q']);
		$limit = isset($_GET['limit']) ? absint($_GET['limit']) : 5;

		$args = array(
			'post_type' => 'coins_new',
			'posts_per_page' => $limit,
			's' => $search_term,
			'orderby' => 'title',
			'order' => 'ASC',
		);
		$posts = get_posts($args);
		$results = array();
		foreach ($posts as $post) {
			$thumbnail_url = get_the_post_thumbnail_url($post->ID, 'full');
			$results[] = array(
				'id' => $post->ID,
				'text' => $post->post_title,
				'thumbnail' => $thumbnail_url,
			);
		}
		header('Content-Type: application/json');
		echo json_encode(array('results' => $results));
		wp_die();
	}

	public function custom_column_header($columns)
	{
		unset($columns['title']);
		unset($columns['date']);

		$new_columns = array(
			'_title' => 'TICKER DETAILS',
			'_status' => 'STATUS',
			'_label' => 'LABEL',
			'_confidence' => 'CONFIDENCE',
			'_info' => 'INFOS',
			'_signal_result' => '',
			'_ticker_type' => "Ticker Type",

		);

		$columns = array_merge($columns, $new_columns);

		return $columns;
	}

	public function custom_columns_content($column, $post_id)
	{
		$post = get_post($post_id);
		$closing_prize = get_post_meta($post_id, 'closing_price', true);
		$closing_date = (get_post_meta($post_id, 'closing_date', true) != '') ? get_post_meta($post_id, 'closing_date', true) : '-';
		$post_modified = ($closing_date != '-') ? $closing_date : get_post_field('post_modified', $post_id);
		$coin_post_id = get_post_meta($post_id, '_post_title', true);
		$opening_price = get_post_meta($post_id, 'opening_price', true);

		$realized_profit_or_loss = get_post_meta($post_id, 'realized_profit_or_loss', true);
		$leverage = get_post_meta($post_id, '_leverage', true);
		$platform_name = get_post_meta($post_id, 'platform_name', true);
		$platform_url = get_post_meta($post_id, 'platform_url', true);
		$risk_label = get_post_meta($post_id, 'risk_label', true);
		$_coin_symbol = get_post_meta($post_id, '_coin_symbol', true);
		$risk_label_formatted = ucwords(str_replace('_', ' ', $risk_label));


		switch ($column) {

			case '_title':
				$post_title = $post->post_title;
				$post_tumbnail = get_the_post_thumbnail_url($coin_post_id, array(20, 20));

				echo '<span class="span_ticker"><img src="' . $post_tumbnail . '" class="thumbnail-image" style="height:50px;width:50px"/> ' . $post_title . '</span>';
				break;
			case '_status':
				echo ucwords(esc_html(get_post_meta($post_id, 'signal_value', true)));
				break;
			case '_label':
				echo esc_html($risk_label_formatted);
				break;
			case '_confidence':
				echo esc_html(get_post_meta($post_id, 'confidence', true));
				break;
			case '_info':
				echo 'Created at:<br>' . $post->post_date . '<br>';
				echo 'Updated at:<br>' . $post_modified . '<br>';
				echo 'Position closed at:<br>' . $closing_date;
				echo '<br> OPENING PRICE :' . $opening_price;
				break;
			case '_signal_result':

				$signal_result = get_post_meta($post_id, '_signal_result', true);
				ob_start();
				$public_url = plugin_dir_path(__FILE__) . 'partials/trade-fish-admin-table-colunm.php';
				include $public_url;
				break;

			case '_ticker_type':

				$ticker_type = get_post_meta($post->ID, 'ticker_type', true);
				$row_number = $post->ID;
				ob_start();
				$public_url = plugin_dir_path(__FILE__) . 'partials/trade-fish-admin-ticker-type-column.php';
				include $public_url;
				break;
		}
	}


	public function save_signal_result()
	{
		$post_id = $_GET['post_id'];
		$symbol = get_post_meta($post_id, '_coin_symbol', true);
		$post = get_post($post_id);

		$post_date_gmt = get_post_time('U', true, $post_id, true);
		$date_gmt = new DateTime();
		$date_gmt->setTimestamp($post_date_gmt);
		$date_gmt->setTimezone(new DateTimeZone('UTC'));
		$opening_formatted_date = $date_gmt->format('d M. Y, H:i:s T');

//        var_dump($opening_formatted_date);
		$date_closing = date('Y-m-d H:i:s');
		$date_object = new DateTime($date_closing);
		$date_object->setTimezone(new DateTimeZone('UTC'));
		$closing_formatted_date = $date_object->format('d M. Y, H:i:s T');


		$signal_value = sanitize_text_field($_GET['signal_value']);
		$closing_price = $_GET['_closing_prize'];
		$realized_profit_or_loss = sanitize_text_field($_GET['realized_profit_or_loss']);
		$leverage = '';
		$platform_name = '';
		$platform_url = '';
		if (isset($signal_value)) {
			update_post_meta($post_id, '_signal_result', $signal_value);
		}
		update_post_meta($post_id, 'closing_price', $closing_price);
		update_post_meta($post_id, 'closing_date', $date_closing);
		update_post_meta($post_id, 'realized_profit_or_loss', $realized_profit_or_loss);


//        $this->dd($leverage);
		$currency = get_post_meta($post_id, 'currency', true);
		$getcurrencies = $this->get_currencies();
		$sign = $getcurrencies[$currency];
		$post_on_telegram = get_post_meta($post->ID, 'post_on_telegram', true);
		$post_on_twitter = get_post_meta($post->ID, 'post_on_twitter', true);

		$trading_platform = get_post_meta($post->ID,'trading_referral_drop_down', true);
		$signal_post_title = str_replace(['“', '”'], '', get_the_title($post_id));
		$decoded_title = html_entity_decode($signal_post_title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
// data for supabase
		$ai_modelId =  $aiModel;
		$platform_Id = $trading_platform;


		$title = get_the_title($ai_modelId);

		$selected_trading_referral_link = get_post_meta($platform_Id,'trading_referral_link',true);
		$link = $selected_trading_referral_link;
		$platform_name = get_the_title($platform_Id);

		$platform_url = $link;

		$ticker_type = get_post_meta($post->ID,'ticker_type', true);
		$confidence = get_post_meta($post->ID,'confidence', true);
		$signal_value_in = get_post_meta($post->ID,'signal_value', true);
		$opening_price = get_post_meta($post->ID,'opening_price', true);
		$currency = get_post_meta($post->ID,'currency', true);
		$risk_label = get_post_meta($post->ID,'risk_label', true);
		$advise_text = get_post_meta($post->ID,'advise_text', true);
		$closing_date = get_post_meta($post->ID,'closing_date', true);
		$title_name = get_post_meta($post->ID, '_post_title', true);
		$closing_price =  get_post_meta($post->ID,'closing_price',true);
		$opening_date =  get_post_field('post_date', $post->ID);

		$selected_post = get_post($title_name);

		$this->check_signal_supabase($post_id, $selected_post->post_title,
		                             $ticker_type,
		                             $confidence,
		                             $signal_value_in,
		                             $opening_price,
		                             $currency,
		                             $risk_label,
		                             $title,
		                             $advise_text,
		                             $platform_url,
		                             $platform_name,
		                             $signal_value,
		                             $closing_date,
		                             $closing_price,
		                             $opening_date,
		);

//        var_dump($post_on_telegram);
		// CLOSING SIGNAL MSG FOR TELEGRAM
		if ($post_on_telegram != '' && !empty($post_on_telegram)) {
//            var_dump("here");
			if ($signal_value != '' && $signal_value == 'correct') {
				$msg = "📈 <b>FishAI Update:</b> " . (($symbol != '') ? $symbol : $decoded_title) . " " . ucfirst(get_post_meta($post_id, 'signal_value', true));
				$msg .= "\n";
				if (get_post_meta($post_id, 'opening_price', true) != '' && !empty(get_post_meta($post_id, 'opening_price', true))) {
					$msg .= "\n";
					$open_price = get_post_meta($post_id, 'opening_price', true);
					if(is_numeric($open_price) && floor($open_price) != $open_price){
						$data = $opening_formatted_date . " | " . $sign .$open_price;
//                        var_dump($data);
						$msg .= "» <b>Opened:</b> " . $data;
					}
					else{

						$number = number_format($open_price);
						$data = $opening_formatted_date . " | " . $sign .$number;
//                        var_dump($data);
						$msg .= "» <b>Opened:</b> " . $data;
					}
				}
				if ($closing_price != '' && !empty($closing_price)) {
					$msg .= "\n";
					if(is_numeric($closing_price) && floor($closing_price) != $closing_price){
						$msg .= "» <b>Closed:</b> " . $closing_formatted_date . " | " . $sign . $closing_price;
					}
					else{
						$closed_number = number_format($closing_price);
						$msg .= "» <b>Closed:</b> " . $closing_formatted_date . " | " . $sign . $closed_number;
					}
				}
				if ($realized_profit_or_loss != '' && !empty($realized_profit_or_loss)) {
					$msg .= "\n";
					$msg .= "» <b>Realized P/L:</b> " . $realized_profit_or_loss;
				}


				$msg .= "\n";
				$msg .= "\n";
				$msg .= "✅ <b>" . ucfirst($signal_value) . " Signal from TradeFish</b>";
				$msg .= "\n";
				$msg .= "\n";

				if (isset($trading_platform) && $trading_platform != '') {
					$selected_trading_referral_id = $trading_platform;
					$selected_trading_referral_link = get_post_meta($selected_trading_referral_id,'trading_referral_link',true);
					$link = $selected_trading_referral_link;
					$title = get_the_title($selected_trading_referral_id);
					$msg .= "<b>Trade Now: </b><a href=\"$link\">$title</a>";
				}

				$img_url = 'https://tradefish.app/wp-content/uploads/2024/04/tradefish_signal_closed.jpg';
				$this->telegram_key($msg,$img_url);
			}
			if ($signal_value != '' && $signal_value == 'incorrect') {
				$msg = "📈 <b>FishAI Update:</b> " . (($symbol != '') ? $symbol : $decoded_title) . " " . ucfirst(get_post_meta($post_id, 'signal_value', true));
				$msg .= "\n";

				if (get_post_meta($post_id, 'opening_price', true) != '' && !empty(get_post_meta($post_id, 'opening_price', true))) {
					$msg .= "\n";
					$open_price = get_post_meta($post_id, 'opening_price', true);
					if(is_numeric($open_price) && floor($open_price) != $open_price){
						$data = $opening_formatted_date . " | " . $sign .$open_price;
//                        var_dump($data);
						$msg .= "» <b>Opened:</b> " . $data;
//                        $msg .= " » <b>Opened:</b> " . $opening_formatted_date . " | " . $sign .$open_price;
					}
					else{
						$number = number_format($open_price);
						$data = $opening_formatted_date . " | " . $sign .$number;
//                        var_dump($data);
						$msg .= "» <b>Opened:</b> " . $data;
					}
				}
				if ($closing_price != '' && !empty($closing_price)) {
					$msg .= "\n";
					if(is_numeric($closing_price) && floor($closing_price) != $closing_price){
						$msg .= "» <b>Closed:</b> " . $closing_formatted_date . " | " . $sign . $closing_price;
					}
					else{
						$closed_number = number_format($closing_price);
						$msg .= "» <b>Closed:</b> " . $closing_formatted_date . " | " . $sign . $closed_number;
					}
				}
				if ($realized_profit_or_loss != '' && !empty($realized_profit_or_loss)) {
					$msg .= "\n";
					$msg .= "» <b>Realized P/L:</b> " . $realized_profit_or_loss;
				}

				$msg .= "\n";
				$msg .= "\n";
				$msg .= "👎 <b>" . ucfirst($signal_value) . " Signal from TradeFish</b>";
				$msg .= "\n";
				$msg .= "\n";

				if (isset($trading_platform) && $trading_platform != '') {
					$selected_trading_referral_id = $trading_platform;
					$selected_trading_referral_link = get_post_meta($selected_trading_referral_id,'trading_referral_link',true);
					$link = $selected_trading_referral_link;
					$title = get_the_title($selected_trading_referral_id);
					$msg .= "<b>Trade Now: </b><a href=\"$link\">$title</a>";
				}

				$img_url = 'https://tradefish.app/wp-content/uploads/2024/04/tradefish_signal_closed.jpg';
				$this->telegram_key($msg,$img_url);
//                $this->telegram_key($msg);
			}
		}
		// SIGNAL CLOSING MSG FOR TWITTER
		if ($post_on_twitter != '' && !empty($post_on_twitter)) {
			if ($_GET['_closing_prize'] != '' && !empty($_GET['_closing_prize'])) {
				$msg = "🚨 TradeFish AI Update: " . get_the_title($post_id) . " " . ucfirst(get_post_meta($post_id, 'signal_value', true)) . " Signal Closed  🚨";
				$msg .= "\n";
				$msg .= "\n";
				$msg .= "⏰Opened: " . $opening_formatted_date . " | " . $sign . get_post_meta($post_id, 'opening_price', true);
				$msg .= "\n";
				$msg .= "🔒Closed: " . $closing_formatted_date . " | " . $sign . $closing_price;
				$msg .= "\n";
				$msg .= "📈Realized P/L: " . $realized_profit_or_loss;
				$msg .= "\n";
				$msg .= "\n";
				$msg .= "✅" . ucfirst($signal_value) . " Signal from TradeFish";
				$msg .= "\n";
				$msg .= "\n";
				$msg .= "Platform: Bybit";

				if ($signal_value != '' && $signal_value == 'correct') {
					$this->twitter_api($msg);
				}
			}
		}


		update_post_meta($post_id, '_leverage', $leverage);
		update_post_meta($post_id, 'platform_name', $platform_name);
		update_post_meta($post_id, 'platform_url', $platform_url);
		die();

	}

	public function get_currencies()
	{

		$currencies = array(
			'USD' => '$', // US Dollar
			'EUR' => '€', // Euro
			'CHF' => '₣', // Swiss Franc
			'JPY' => '¥', // Japanese Yen
			'GBP' => '£', // British Pound Sterling
			'CAD' => 'C$', // Canadian Dollar
			'AUD' => 'A$', // Australian Dollar
			'NZD' => 'NZ$', // New Zealand Dollar
			'SGD' => 'S$', // Singapore Dollar
			'DKK' => 'kr', // Danish Krone
			'NOK' => 'kr', // Norwegian Krone

		);

		return $currencies;
	}



	function syncnewcoins()
	{
		$signal_posts = get_posts(['post_type' => 'signals', 'post_status' => 'draft', 'posts_per_page' => -1]);
		$data_array = [];
		foreach ($signal_posts as $p) {
			$existing_post = get_page_by_title($p->post_title, OBJECT, 'coins_new');
			if ($existing_post) {
				update_post_meta($p->ID, '_post_title', $existing_post->ID);
			} else {
				$filePath = plugin_dir_path(__FILE__) . '/ids.txt';
				$data = $c . '-' . $p->ID . '-' . $p->post_title . PHP_EOL;
//                   $data = $p->post_title.PHP_EOL;
				// Write data to the file (append mode)
				if (!in_array($p->post_title, $data_array)) {
					array_push($data_array, $p->post_title);
					file_put_contents($filePath, $data, FILE_APPEND);
				}
				$c++;
			}
		}
	}

	function custom_post_type_filter() {
		global $typenow;
		$post_type = 'signals'; // Change 'your_custom_post_type' to your actual custom post type
		if ($typenow == $post_type) {
			$selected = isset($_GET['filter_by_type']) ? $_GET['filter_by_type'] : '';
			$options = array(
				'' => 'All',
				'closed' => 'Closed',
				'active' => 'Active'
				// Add more options as needed
			);
			echo '<select name="filter_by_type">';
			echo '<option value="" disabled>' . __('Filter by', 'your_theme_textdomain') . '</option>';
			foreach ($options as $value => $label) {
				echo '<option value="' . $value . '" ' . selected($selected, $value, false) . '>' . $label . '</option>';
			}
			echo '</select>';
		}
	}
	function members_skip_trash($post_id) {
		if (get_post_type($post_id) == 'signals') {

			$this->delete_signal_supabase($post_id);
		}
	}

	public function check_signal_supabase($id, $name, $ticker_type, $confidence, $s_value, $o_price, $currency, $risk,$ai_model,$advise, $platform_url,$platform_name, $signal_value, $closing_formatted_date,$closing_price,$opening_date)
	{

		$url = 'https://fztbojbqsietuamhlfqk.supabase.co/rest/v1/signals?select=id';
		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'apikey: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImZ6dGJvamJxc2lldHVhbWhsZnFrIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MTQ1OTI0NTksImV4cCI6MjAzMDE2ODQ1OX0.K_vttXCKzzL0C09YYSSOiWrYKffSwQ4TsS-VRuS4DUk',
			'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImZ6dGJvamJxc2lldHVhbWhsZnFrIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MTQ1OTI0NTksImV4cCI6MjAzMDE2ODQ1OX0.K_vttXCKzzL0C09YYSSOiWrYKffSwQ4TsS-VRuS4DUk'
		));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$response = curl_exec($ch);

		if ($response === false) {
			$error = curl_error($ch);
			curl_close($ch);
			die('Curl error: ' . $error);
		}

		curl_close($ch);

		$responseData = json_decode($response, true);
		$found = false;
		if (is_array($responseData)) {
			foreach ($responseData as $item) {
				if (isset($item['id']) && $item['id'] == $id) {
					$found = true;
					break;
				}
			}
		}
		if ($found) {
			$this->update_signal_supabase($id, $name, $ticker_type, $confidence, $s_value, $o_price, $currency, $risk, $ai_model,$advise,$platform_url,$platform_name,$signal_value,$closing_formatted_date,$closing_price,$opening_date);
		} else {
			$this->add_signal_supabase($id, $name, $ticker_type, $confidence, $s_value, $o_price, $currency, $risk, $ai_model,$advise,$platform_url,$platform_name,$signal_value,$closing_formatted_date,$closing_price,$opening_date);
		}
	}
	public function add_signal_supabase($id, $name, $ticker_type, $confidence, $s_value, $o_price, $currency, $risk, $ai_model,$advise_text,$platform_url,$platform_name,$signal_value,$closing_formatted_date,$closing_price,$opening_date)
	{

		$url = 'https://fztbojbqsietuamhlfqk.supabase.co/rest/v1/signals';
		$data = array(
			'id'            => $id,
			'Title'         => $name,
			'opening_price' => $o_price,
			'signal_value'  => $s_value,
			'currency'      => $currency,
			'ticker_type'   => $ticker_type,
			'confidence'    => $confidence,
			'risk_label'    => $risk,
			'ai_model'      => $ai_model,
			'advise_text'   => $advise_text,
			'platform_url'   => $platform_url,
			'platform_name' => $platform_name,
			'_signal_result' => $signal_value,
			'closing_date' => $closing_formatted_date,
			'closing_price' => $closing_price,
			'opening_date' => $opening_date
		);
		$payload = json_encode($data);


		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'apikey: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImZ6dGJvamJxc2lldHVhbWhsZnFrIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MTQ1OTI0NTksImV4cCI6MjAzMDE2ODQ1OX0.K_vttXCKzzL0C09YYSSOiWrYKffSwQ4TsS-VRuS4DUk',
			'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImZ6dGJvamJxc2lldHVhbWhsZnFrIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MTQ1OTI0NTksImV4cCI6MjAzMDE2ODQ1OX0.K_vttXCKzzL0C09YYSSOiWrYKffSwQ4TsS-VRuS4DUk',
			'Content-Type: application/json',
			'Prefer: return=minimal'
		));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

		$response = curl_exec($ch);

		if($response === false) {
			$error = curl_error($ch);
			curl_close($ch);
			die('Curl error: ' . $error);
		}

		curl_close($ch);
//        echo $response;
	}
	public function update_signal_supabase($id, $name, $ticker_type, $confidence, $s_value, $o_price, $currency, $risk,$ai_model,$advise_text,$platform_url,$platform_name,$signal_value,$closing_formatted_date,$closing_price,$opening_date)
	{
		$curl = curl_init();

		$data = array(
			'Title'         => $name,
			'opening_price' => $o_price,
			'signal_value'  => $s_value,
			'currency'      => $currency,
			'ticker_type'   => $ticker_type,
			'confidence'    => $confidence,
			'risk_label'    => $risk,
			'ai_model'      => $ai_model,
			'advise_text'   => $advise_text,
			'platform_url'   => $platform_url,
			'platform_name' => $platform_name,
			'_signal_result' => $signal_value,
			'closing_date' => $closing_formatted_date,
			'closing_price' => $closing_price,
			'opening_date' => $opening_date
		);
		$payload = json_encode($data);
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://fztbojbqsietuamhlfqk.supabase.co/rest/v1/signals?id=eq.'.$id,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'PATCH',
			CURLOPT_POSTFIELDS => $payload,
			CURLOPT_HTTPHEADER => array(
				'apikey: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImZ6dGJvamJxc2lldHVhbWhsZnFrIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MTQ1OTI0NTksImV4cCI6MjAzMDE2ODQ1OX0.K_vttXCKzzL0C09YYSSOiWrYKffSwQ4TsS-VRuS4DUk',
				'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImZ6dGJvamJxc2lldHVhbWhsZnFrIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MTQ1OTI0NTksImV4cCI6MjAzMDE2ODQ1OX0.K_vttXCKzzL0C09YYSSOiWrYKffSwQ4TsS-VRuS4DUk',
				'Content-Type: application/json'
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo 'cURL Error #: ' . $err;
		} else {
//            echo $response;
		}
	}

	public function delete_signal_supabase($id){

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://fztbojbqsietuamhlfqk.supabase.co/rest/v1/signals?id=eq.'.$id,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'DELETE',
			CURLOPT_HTTPHEADER => array(
				'apikey: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImZ6dGJvamJxc2lldHVhbWhsZnFrIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MTQ1OTI0NTksImV4cCI6MjAzMDE2ODQ1OX0.K_vttXCKzzL0C09YYSSOiWrYKffSwQ4TsS-VRuS4DUk',
				'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImZ6dGJvamJxc2lldHVhbWhsZnFrIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MTQ1OTI0NTksImV4cCI6MjAzMDE2ODQ1OX0.K_vttXCKzzL0C09YYSSOiWrYKffSwQ4TsS-VRuS4DUk',
				'Content-Type: application/json'
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo 'cURL Error #: ' . $err;
		} else {
//            echo $response;
		}
	}


	public function custom_admin_script(){
		?>

        <script>
            jQuery(document).ready(function($) {
                $('.update-Ticker').on('click', function(e) {
                    e.preventDefault();
                    var postId = $(this).data('row-id');
                    var tickerType = $("#ticker_type_"+postId).val();

                    $.ajax({
                        url: '<?php echo admin_url('admin-ajax.php'); ?>',
                        type: 'POST',
                        data: {
                            action: 'update_ticker',
                            post_id: postId,
                            ticker_type: tickerType,
                        },
                        success: function(response) {
                            alert(response.data);
                        },
                        error: function(response) {
                            alert('Error updating ticker.');
                        }
                    });
                });
            });

        </script>
		<?php
	}
	public function update_ticker()
	{

		$id = $_POST['post_id'];
		$ticker_type = $_POST['ticker_type'];

		if(!empty($id) && $ticker_type != null && !empty($ticker_type)){
			try {
				$updated = update_post_meta($id, 'ticker_type', $ticker_type);

				if ($updated !== false) {
					wp_send_json_success('Ticker updated.');
				} else {
					throw new Exception('Failed to update ticker.');
				}

			} catch (Exception $ex) {
				wp_send_json_error('Error updating ticker: ' . $ex->getMessage());
			}
		}
		else{
			wp_send_json_error('Id is empty.');
		}
	}
}
