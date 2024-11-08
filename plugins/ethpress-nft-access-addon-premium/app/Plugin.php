<?php

/**
 * Plugin's startup
 *
 * Specify addresses and ids in woocommerce Product Data: NFT Data fields.
 *
 * @package Ethpress_NFT_Access
 *
 * @since 0.1.0
 */

namespace losnappas\Ethpress_NFT_Access;

defined('ABSPATH') || die;

use losnappas\Ethpress_NFT_Access\Nft;
use losnappas\Ethpress\Address;
use losnappas\Ethpress\Logger;



/**
 * Starts up the plugin and attaches hooks.
 *
 * @since 0.1.0
 */
class Plugin
{

	/**
	 * Assets array returned from Blockchain, first populated on init
	 *
	 * @var array
	 * @since 1.1.0
	 */

	/**
	 * Hook the plugin.
	 *
	 * @since 0.1.0
	 */
	public static function attach_hooks()
	{
		//Logger::log('Plugin::attach_hooks');
		// @since 1.1.0 -- Forgot it earlier.
		add_action('init', array(__CLASS__, 'load_plugin_textdomain'));

		add_action(
			'init',
			array(__CLASS__, 'init')
		);

		add_action(
			'woocommerce_add_to_cart',
			array(__CLASS__, 'woocommerce_add_to_cart_action'),
			0,
			2
		);

		if (is_admin()) { 
			//Logger::log('Plugin::attach_hooks: is_admin');
			add_action(
				'admin_head',
				array(__CLASS__, 'product_tab_icon')
			);
			add_action(
				'admin_enqueue_scripts',
				array(__CLASS__, 'admin_enqueue_scripts')
			);
			add_action(
				'admin_menu',
				array(ETHPRESS_NFT_ACCESS_ADDON_NS . '\Admin\Options', 'admin_menu')
			);
			add_action(
				'admin_init',
				array(ETHPRESS_NFT_ACCESS_ADDON_NS . '\Admin\Options', 'admin_init')
			);
			$plugin = plugin_basename(ETHPRESS_NFT_ACCESS_ADDON_FILE);
			add_filter("plugin_action_links_$plugin", array(ETHPRESS_NFT_ACCESS_ADDON_NS . '\Admin\Options', 'plugin_action_links'));
		}
		add_action(
			'wp_enqueue_scripts',
			array(__CLASS__, 'wp_enqueue_scripts')
		);

		add_action(
			'template_redirect',
			//'wp',
			array(__CLASS__, 'restrict_access_to_page_post')
		);

		add_action(
			'add_meta_boxes',
			array(__CLASS__, 'add_meta_boxes_hook')
		);
		add_action(
			'save_post',
			array(__CLASS__, 'save_metabox_fields')
		);


		add_filter("ethpress_login_address", array(__CLASS__, 'ethpress_login_address'));
		add_filter("ethpress_login_redirect", array(__CLASS__, 'ethpress_login_redirect'), 10, 3);

		// ***************learn-press**************
		add_filter("learn-press/course/is-free", array(__CLASS__, 'course_isFree'), 10, 2);
		add_filter("learn_press_course_price_html_free", array(__CLASS__, 'learn_press_course_price_html_free'), 10);
		add_action(
			'learn-press/after-purchase-button',
			array(__CLASS__, 'after_purchase_button')
		);
		add_action(
			'learn-press/after-course-summary-sidebar',
			array(__CLASS__, 'after_course_summary_sidebar'),
			1001
		);
		// ***************TutorLMS****************
		add_filter("is_course_purchasable", array(__CLASS__, 'is_course_purchasable'), 1001, 2);
		add_action(
			'tutor_course/loop/after_header',
			array(__CLASS__, 'tutor_course_loop_after_footer')
		);
		add_action(
			'tutor_before_enroll',
			array(__CLASS__, 'tutor_before_enroll')
		);

		add_action(
			'tutor_after_enroll',
			array(__CLASS__, 'tutor_after_enroll'),
			10,
			2
		);

		add_action(
			'tutor_course/single/enrolled/before/lead_info/progress_bar',
			array(__CLASS__, 'tutor_lesson_single_before_content')
		);
		add_filter("tutor_is_enrolled", array(__CLASS__, 'tutor_is_enrolled'), 1001, 3);
	}

	/**
	 * tutor_lesson_single_before_content
	 * Shows the message "NFT access granted" on the page of each course under the progress bar, 
	 * for which the NFT access settings are set, and the "show message" checkbox is checked.
	 * @return void
	 */
	public static function tutor_lesson_single_before_content()

	{
		$user_id = get_current_user_id();
		if (!$user_id) {
			return;
		}
		if (!self::is_set_tu_nft_access_granted_message_checkbox()) {
			return;
		}
		$course_id = tutils()->get_course_id_by_lesson(get_the_ID());
		if ('free' == tutils()->price_type($course_id)) {
			return;
		}
		if (!self::is_set_nft_access($course_id)) {
			return;
		}
		if (NFT::has_nft_for_user_id(self::get_arrNFT($course_id), $user_id)) {
			wp_enqueue_style('nft-access-addon-tutor');

			echo self::get_tu_nft_access_granted_message($course_id);
			//echo __('NFT Access Granted', 'ethpress');
		}
	}


	/**
	 * tutor_after_enroll
	 *
	 * update post meta for NFT Access Granted course
	 * 
	 * @param  mixed $course_id
	 * @param  mixed $isEnrolled
	 * @return void
	 */
	public static function tutor_after_enroll($course_id, $isEnrolled)
	{
		// error_log('---------tutor_after_enroll-----course_id------' . print_r($course_id, true));
		// error_log('---------tutor_after_enroll-----isEnrolled------' . print_r($isEnrolled, true));
		if ('free' == tutils()->price_type($course_id)) {
			return;
		}
		$user_id = get_current_user_id();
		if (!$user_id) {
			return;
		}
		if (!self::is_set_nft_access($course_id)) {
			return;
		}
		$enrolled_user_id = get_post_meta($isEnrolled, '_enrolled_by_nft_access', true);
		if (!empty($enrolled_user_id)) {
			return;
		}
		if (NFT::has_nft_for_user_id(self::get_arrNFT($course_id), $user_id)) {
			update_post_meta($isEnrolled, '_enrolled_by_nft_access', $user_id);
		}
	}

	/**
	 * tutor_before_enroll
	 * 
	 * delete enrolled info and delete post meta for a course that previously had nft access granted
	 *
	 * @param  mixed $course_id
	 * @return void
	 */
	public static function tutor_before_enroll($course_id)
	{
		global $wpdb;
		if ('paid' !== tutils()->price_type($course_id)) {
			return;
		}
		$user_id = get_current_user_id();
		$getEnrolledInfo = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT ID,
						post_author,
						post_date,
						post_date_gmt,
						post_title
				FROM 	{$wpdb->posts}
				WHERE 	post_author>0 
						AND post_parent>0
						AND post_type = %s
						AND post_parent = %d
						AND post_author = %d
						AND post_status = %s;
				",
				'tutor_enrolled',
				$course_id,
				$user_id,
				'completed'
			)
		);
		if ($getEnrolledInfo) {
			// $order_id = get_post_meta($getEnrolledInfo->ID, '_tutor_enrolled_by_order_id', true);
			// if (empty($order_id)) {
			$enrolled_user_id = get_post_meta($getEnrolledInfo->ID, '_enrolled_by_nft_access', true);
			if ($enrolled_user_id == $user_id) {
				tutor_utils()->cancel_course_enrol($course_id, $user_id, 'delete');
				delete_post_meta($getEnrolledInfo->ID, '_enrolled_by_nft_access');
			}
		}
	}

	/**
	 * tutor_is_enrolled
	 *
	 * @param  mixed $getEnrolledInfo
	 * @param  mixed $course_id
	 * @param  mixed $user_id
	 * @return false|getEnrolledInfo
	 */
	public static function tutor_is_enrolled($getEnrolledInfo, $course_id, $user_id)
	{
		$post = get_post();
		if ('courses' !== $post->post_type) {
			return $getEnrolledInfo;
		}
		if ('paid' !== tutils()->price_type($course_id)) {
			return;
		}
		if (self::is_set_nft_access($course_id)) {

			if (NFT::has_nft_for_user_id(self::get_arrNFT($course_id), $user_id)) {
				return $getEnrolledInfo;
			}
		}
		// $order_id = get_post_meta($getEnrolledInfo->ID, '_tutor_enrolled_by_order_id', true);
		// if (empty($order_id)) {
		// 	$getEnrolledInfo = false;
		// }
		$enrolled_user_id = get_post_meta($getEnrolledInfo->ID, '_enrolled_by_nft_access', true);
		// error_log('------tutor_is_enrolled---enrolled_user_id-----------' . print_r($enrolled_user_id, true));
		if ($enrolled_user_id == $user_id) {
			$getEnrolledInfo = false;
		}
		return $getEnrolledInfo;
	}

	/**
	 * tutor_course_loop_after_footer
	 * 
	 * Shows a message 'NFT Access Granted' in the list of courses for each entry for which NFT access settings are set
	 *
	 * @return void
	 */
	public static function tutor_course_loop_after_footer()
	{
		$post = get_post();
		if ('courses' !== $post->post_type) {
			return true;
		}
		$course_id = get_the_ID();
		if ('free' == tutils()->price_type($course_id)) {
			return true;
		}
		if (!self::is_set_nft_access($course_id)) {
			return true;
		}
		$user_id = get_current_user_id();
		if (!$user_id) {
			return true;
		}
		if (NFT::has_nft_for_user_id(self::get_arrNFT($course_id), $user_id)) {
			echo self::get_tu_nft_access_granted_message($course_id);
		} else {
			echo self::get_buy_tu_course_for_nft_html_message($course_id);
		}
	}

	/**
	 * is_course_purchasable
	 * 
	 * change course type paid to free
	 *
	 * @param  mixed $is_purchasable
	 * @param  mixed $course_id
	 * @return void
	 */
	public static function is_course_purchasable($is_purchasable, $course_id)
	{

		$post = get_post();
		if ('courses' !== $post->post_type) {
			return $is_purchasable;
		}
		if ('free' == tutils()->price_type($course_id)) {

			return $is_purchasable;
		}
		$user_id = get_current_user_id();
		if (!$user_id) {
			return $is_purchasable;
		}
		if (!self::is_set_nft_access($course_id)) {
			return $is_purchasable;
		}
		// error_log('---------user_id-----------' . print_r($user_id, true));
		if (NFT::has_nft_for_user_id(self::get_arrNFT($course_id), $user_id)) {
			$is_purchasable = false;
		}
		return $is_purchasable;
	}



	/**
	 * after_course_summary_sidebar
	 * 
	 * Shows the message "NFT access granted" on the page of each course under the progress bar, 
	 * for which the NFT access settings are set, and the "show message" checkbox is checked.
	 * 
	 * @return void
	 */
	public static function after_course_summary_sidebar()
	{
		if (!self::is_set_nft_access_granted_message_checkbox()) {
			return true;
		}
		$post = get_post();
		if ('lp_course' !== $post->post_type) {
			return true;
		}
		if (!function_exists('learn_press_get_course')) {
			return true;
		}
		$course_id = learn_press_get_course()->get_id();
		if (!self::is_set_nft_access($course_id)) {
			return true;
		}
		if (!isset($GLOBALS['lp_user'])) {
			return true;
		}
		$user_id = $GLOBALS['lp_user']->get_id();
		if (!$user_id) {
			return true;
		}
		if (NFT::has_nft_for_user_id(self::get_arrNFT($course_id), $user_id)) {
			echo self::get_lp_nft_access_granted_message($course_id);
		}
	}

	/**
	 * learn_press_course_price_html_free
	 * 
	 * Shows a message 'NFT Access Granted' in the list of courses for each entry for which NFT access settings are set
	 * 
	 * @param  mixed $price_html
	 * @return void
	 */
	public static function learn_press_course_price_html_free($price_html)
	{
		$post = get_post();
		if ('lp_course' !== $post->post_type) {
			return $price_html;
		}
		if (!function_exists('learn_press_get_course')) {
			return $price_html;
		}
		$course_id = learn_press_get_course()->get_id();
		if (!self::is_set_nft_access($course_id)) {
			return $price_html;
		}
		if (!isset($GLOBALS['lp_user'])) {
			return $price_html;
		}
		$user_id = $GLOBALS['lp_user']->get_id();
		if (!$user_id) {
			return $price_html;
		}
		if (NFT::has_nft_for_user_id(self::get_arrNFT($course_id), $user_id)) {
			$price_html = self::get_lp_nft_access_granted_message($course_id);
		} else {
			return $price_html;
		}
		return $price_html;
	}


	/**
	 * after_purchase_button
	 * 
	 * Shows a link to the NFT purchase page under the "Buy" button if the NFT address is specified in the settings
	 * 
	 * @return void
	 */
	public static function after_purchase_button()
	{
		if (!function_exists('learn_press_get_course')) {
			return true;
		}
		$course_id = learn_press_get_course()->get_id();
		if (!self::is_set_nft_access($course_id)) {
			return true;
		}
		echo self::get_buy_course_for_nft_html_message($course_id);
	}

	/**
	 * course_isFree 
	 * 
	 * Changes a paid course to a free one if the user has NFT
	 * 
	 * @param  mixed $price
	 * @param  mixed $course_id
	 * @return true if usder has nft
	 */
	public static function course_isFree($price, $course_id)
	{
		$post = get_post();
		if ('lp_course' !== $post->post_type) {
			return $price;
		}
		if (!self::is_set_nft_access($course_id)) {
			return $price;
		}

		if (!isset($GLOBALS['lp_user'])) {
			return $price;
		}
		$user_id = $GLOBALS['lp_user']->get_id();
		if (!$user_id) {
			return $price;
		}
		$address = Address::find_by_user($user_id);
		if (is_wp_error($address)) {
			return $price;
		}
		if (NFT::has_nft_for_user_id(self::get_arrNFT($course_id), $user_id)) {
			return true;
		} else {
			return $price;
		}

		return $price;
	}

	/**
	 * is_set_nft_access_granted_message_checkbox
	 *
	 * @return true if set nft access granted message
	 */
	private static function is_set_nft_access_granted_message_checkbox()
	{
		global $ETHPRESS_NFT_ACCESS_ADDON_options;
		if (
			!isset($ETHPRESS_NFT_ACCESS_ADDON_options['lp_nft_access_granted_message_checkbox']) ||
			empty($ETHPRESS_NFT_ACCESS_ADDON_options['lp_nft_access_granted_message_checkbox'])
		) {
			return false;
		}
		return true;
	}

	/**
	 * is_set_tu_nft_access_granted_message_checkbox
	 *
	 * @return true if set nft access granted message
	 */
	private static function is_set_tu_nft_access_granted_message_checkbox()
	{
		global $ETHPRESS_NFT_ACCESS_ADDON_options;
		if (
			!isset($ETHPRESS_NFT_ACCESS_ADDON_options['tu_nft_access_granted_message_checkbox']) ||
			empty($ETHPRESS_NFT_ACCESS_ADDON_options['tu_nft_access_granted_message_checkbox'])
		) {
			return false;
		}
		return true;
	}

	/**
	 * is_set_nft_access
	 *
	 * @param  mixed $course_id
	 * @return true if set contract_addresses for course
	 */
	private static function is_set_nft_access($course_id)
	{
		$meta = get_post_meta($course_id, 'ethpress_nft_access_addon_product_data', true);
		if (empty($meta) || empty($meta['contract_addresses'])) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * get_arrNFT
	 *
	 * @param  mixed $course_id
	 * @return array
	 */
	private static function get_arrNFT($course_id)
	{
		$meta = get_post_meta($course_id, 'ethpress_nft_access_addon_product_data', true);
		$contracts = array_map('trim', explode(',', $meta['contract_addresses']));
		$tokens    = array_map('trim', explode(',', $meta['token_ids']));
		$arrNft = array_map(null, $contracts, $tokens);
		//error_log('---------arrNft-----------' . print_r($arrNft, true));
		return $arrNft;
	}

	/**
	 * get_tu_nft_access_granted_message
	 *
	 * @param  mixed $course_id
	 * @return html message
	 */
	private static function get_tu_nft_access_granted_message($course_id)
	{
		global $ETHPRESS_NFT_ACCESS_ADDON_options;
		if (
			!isset($ETHPRESS_NFT_ACCESS_ADDON_options['tu_nft_access_granted_message']) ||
			empty($ETHPRESS_NFT_ACCESS_ADDON_options['tu_nft_access_granted_message'])
		) {
			$message = __('NFT Access Granted', 'ethpress');
		} else {
			$message =  $ETHPRESS_NFT_ACCESS_ADDON_options['tu_nft_access_granted_message'];
		}
		return sprintf('<span class="free nft-access-granted_message">%s</span>', $message);
	}

	/**
	 * get_lp_nft_access_granted_message
	 *
	 * @param  mixed $course_id
	 * @return html message
	 */
	private static function get_lp_nft_access_granted_message($course_id)
	{
		global $ETHPRESS_NFT_ACCESS_ADDON_options;
		if (
			!isset($ETHPRESS_NFT_ACCESS_ADDON_options['lp_nft_access_granted_message']) ||
			empty($ETHPRESS_NFT_ACCESS_ADDON_options['lp_nft_access_granted_message'])
		) {
			$message = __('NFT Access Granted', 'ethpress');
		} else {
			$message =  $ETHPRESS_NFT_ACCESS_ADDON_options['lp_nft_access_granted_message'];
		}
		return sprintf('<span class="nft-access-granted_message">%s</span>', $message);
	}

	/**
	 * get_buy_course_for_nft_html_message
	 *
	 * @param  mixed $course_id
	 * @return html message
	 */
	private static function get_buy_course_for_nft_html_message($course_id)
	{
		global $ETHPRESS_NFT_ACCESS_ADDON_options;
		if (
			!isset($ETHPRESS_NFT_ACCESS_ADDON_options['lp_buy_course_for_nft_message']) ||
			empty($ETHPRESS_NFT_ACCESS_ADDON_options['lp_buy_course_for_nft_message'])
		) {
			$message = __('You can buy NFT to access the course', 'ethpress');
		} else {
			$message =  $ETHPRESS_NFT_ACCESS_ADDON_options['lp_buy_course_for_nft_message'];
		}
		$meta = get_post_meta($course_id, 'ethpress_nft_access_addon_product_data', true);
		$redirect_url = $meta['redirect_url'];
		return "<a target = '_blank' href = $redirect_url >$message</a>";
	}

	/**
	 * get_buy_course_for_nft_html_message
	 *
	 * @param  mixed $course_id
	 * @return html message
	 */
	private static function get_buy_tu_course_for_nft_html_message($course_id)
	{
		global $ETHPRESS_NFT_ACCESS_ADDON_options;
		if (
			!isset($ETHPRESS_NFT_ACCESS_ADDON_options['tu_buy_course_for_nft_message']) ||
			empty($ETHPRESS_NFT_ACCESS_ADDON_options['tu_buy_course_for_nft_message'])
		) {
			$message = __('You can buy NFT to access the course', 'ethpress');
		} else {
			$message =  $ETHPRESS_NFT_ACCESS_ADDON_options['tu_buy_course_for_nft_message'];
		}
		$meta = get_post_meta($course_id, 'ethpress_nft_access_addon_product_data', true);
		$redirect_url = $meta['redirect_url'];
		return "<a target = '_blank' href = $redirect_url >$message</a>";
	}

	public static function ethpress_login_address($address)
	{
		global $ETHPRESS_NFT_ACCESS_ADDON_options;
		if (
			!isset($ETHPRESS_NFT_ACCESS_ADDON_options['redirect_no_login_url']) ||
			empty($ETHPRESS_NFT_ACCESS_ADDON_options['redirect_no_login_url'])
		) {
			return $address;
		}
		$contracts = array_map('trim', explode(',', $ETHPRESS_NFT_ACCESS_ADDON_options['contract_addresses']));
		$tokens    = array_map('trim', explode(',', $ETHPRESS_NFT_ACCESS_ADDON_options['token_ids']));
		if (0 === count($contracts) && 0 === count($tokens)) {
			return $address;
		}
		if (count($contracts) !== count($tokens)) {
			$address = new \WP_Error('NftAccess', __('NFT Access Add-On settings error', 'ethpress'));
			return $address;
		}
		$arrNft = array_map(null, $contracts, $tokens);
		if ($address->get_user()) {
			if (NFT::has_nft_for_user_id($arrNft, $address->get_user()->ID)) {
				return $address;
			}
			return self::_get_no_access_error();
		}
		if (NFT::has_nft_for_user_address($arrNft, $address->get_address())) {
			return $address;
		}
		return self::_get_no_access_error();
	}

	private static function _get_no_access_error()
	{
		global $ETHPRESS_NFT_ACCESS_ADDON_options;
		$redirect_no_login_url = $ETHPRESS_NFT_ACCESS_ADDON_options['redirect_no_login_url'];
		if (
			!isset($ETHPRESS_NFT_ACCESS_ADDON_options['no_token_message']) ||
			empty($ETHPRESS_NFT_ACCESS_ADDON_options['no_token_message'])
		) {
			$message = __('You do not have the NFT required for access. You\'ll be redirected to a page where you can get it.', 'ethpress');
		} else {
			$message = $ETHPRESS_NFT_ACCESS_ADDON_options['no_token_message'];
		}
		return new \WP_Error(Nft::$noNFT, $message);
	}

	public static function ethpress_login_redirect($redirect_to, $requested_redirect_to, $user)
	{
		global $ETHPRESS_NFT_ACCESS_ADDON_options;
		if (is_wp_error($user)) {
			if (Nft::$noNFT == $user->get_error_code()) {
				$redirect_to = $ETHPRESS_NFT_ACCESS_ADDON_options['redirect_no_login_url'];
			}
		}
		return $redirect_to;
	}

	public static function add_meta_boxes_hook()
	{
		$post = get_post();
		if (function_exists('\wc_get_page_id') && in_array($post->ID, [
			\wc_get_page_id('shop'),
			\wc_get_page_id('cart'),
			\wc_get_page_id('checkout'),
			\wc_get_page_id('myaccount'),
		])) {
			return true;
		}
		add_meta_box(
			'ethpress_nft_access_addon_meta_box',
			__('EthPress NFT Access', 'ethpress_nft_access_addon'),
			array(__CLASS__, 'woocommerce_product_data_panels'),
			apply_filters('ethpress_nft_access_addon_meta_box_post_type', array('post', 'page', 'product', 'lp_course', 'courses')),
			'side', //'normal',
			'high'
		);
	}

	public static function save_metabox_fields($post_id)
	{
		if (!wp_verify_nonce($_POST['ethpress_nft_access_addon_meta_box_nonce'], basename(__FILE__)))
			return $post_id;
		// // autosave
		// if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)  
		// 	return $post_id;  
		// if ('page' == $_POST['post_type'] || 'post' == $_POST['post_type']) {  
		// 	if (!current_user_can('edit_page', $post_id))  
		// 		return $post_id;  
		// 	} elseif (!current_user_can('edit_post', $post_id)) {  
		// 		return $post_id;  
		// }  
		self::woocommerce_process_product_meta($post_id);
	}

	/**
	 * Changes woocommerce product tab icon for NFT into dollar.
	 *
	 * @since 0.1.0
	 */
	public static function product_tab_icon()
	{
		echo '<style>ul.wc-tabs .ethpress_nft_access_addon_NFT_tab a::before { content: "\f18e" !important; }</style>';
	}

	/**
	 * Hooked to init.
	 *
	 * @since 0.5.0
	 */
	public static function init()
	{

		add_shortcode(
			'ethpress_nft_access_addon_nft',
			array(ETHPRESS_NFT_ACCESS_ADDON_NS . '\Shortcodes\Nftlink', 'ethpress_nft_access_addon_nft_shortcode')
		);
	}

	/**
	 * Enqueues the admin script.
	 *
	 * @since 0.1.0
	 *
	 * @param string $page Current page.
	 */
	public static function admin_enqueue_scripts($page)
	{
		if ('post.php' === $page || 'post-new.php' === $page) {
			wp_enqueue_script(
				'ethpress_nft_access_addon',
				plugin_dir_url(ETHPRESS_NFT_ACCESS_ADDON_FILE) . '/public/admin/nft-adder.js',
				array('jquery'),
				'1',
				false
			);
			wp_localize_script(
				'ethpress_nft_access_addon',
				'ethpress_nft_access',
				apply_filters(
					'ethpress_nft_access_wp_localize_script',
					[
						// variables
						'nft_contract_address_label' => esc_html__('Contract Address', 'ethpress_nft_access_addon'),
						'nft_token_id_label' => esc_html__('Token ID', 'ethpress_nft_access_addon'),
					]
				)
			);
		}
	}

	/**
	 * Enqueues required scripts.
	 *
	 * @since 0.1.0
	 */
	public static function wp_enqueue_scripts()
	{
		if (!is_user_logged_in()) {
			wp_enqueue_script('ethpress-login-front');
		}

		$base_url = plugin_dir_url(ETHPRESS_NFT_ACCESS_ADDON_FILE);
		error_log('-------wp_enqueue_scripts----base_url---------' . print_r($base_url, true));
		wp_register_style(
			'nft-access-addon-tutor',
			$base_url . 'public/css/tutor.css'
		);
		wp_enqueue_style('nft-access-addon-tutor');

		// wp_register_style( 'my-plugin', plugins_url( 'my-plugin/css/plugin.css' ) );
		// wp_enqueue_style( 'my-plugin' );		
	}

	/**
	 * Adds a woocommerce product data tab.
	 *
	 * @since 0.1.0
	 *
	 * @param Array $tabs Tabs array.
	 */
	public static function woocommerce_product_data_tabs($tabs)
	{
		$tabs['ethpress_nft_access_addon_NFT'] = array(
			'label'    => __('NFT Data', 'ethpress_nft_access_addon'),
			'target'   => 'ethpress_nft_access_addon_product_data',
			'priority' => 21,
		);
		return $tabs;
	}

	/**
	 * Outputs fields to product data thing.
	 *
	 * @since 0.1.0
	 */
	public static function woocommerce_product_data_panels()
	{
		$post = get_post();
		echo '<div id="ethpress_nft_access_addon_product_data">';
		//if (!function_exists(__NAMESPACE__ . '\ethpress_nft_access_addon_freemius_init')) {
		if ($post->post_type == 'product') {
			echo '<p>' . esc_html__('Require an NFT and restrict user access to the product page. Only users with the token will be able to view the product.', 'ethpress_nft_access_addon') . '</p>';
		} elseif ($post->post_type == 'lp_course') {
			echo '<p>' . esc_html__('Require an NFT and restrict user access to the course. Only users with the token will be able to view the course.', 'ethpress_nft_access_addon') . '</p>';
		} else {
			echo '<p>' . esc_html__('Require an NFT and restrict user access to the page. Only users with the token will be able to view the page.', 'ethpress_nft_access_addon') . '</p>';
		}
		//}
		echo '<input type="hidden" name="ethpress_nft_access_addon_meta_box_nonce" value="' . wp_create_nonce(basename(__FILE__)) . '" />';
		$meta = get_post_meta(
			get_the_ID(),
			'ethpress_nft_access_addon_product_data',
			true
		);
		if (empty($meta['contract_addresses'])) {
			$meta = array(
				'redirect_url'       => '',
				'contract_addresses' => '',
				'token_ids'          => '',
			);
		}

?>
		<div class="components-form-token-field" tabindex="-1">
			<label for="ethpress_nft_access_addon_redirect_url" class="components-form-token-field__label"><?php esc_html_e('Redirect URL', 'ethpress_nft_access_addon') ?></label>
			<div class="components-form-token-field__input-container" tabindex="-1">
				<input id="ethpress_nft_access_addon_redirect_url" name="ethpress_nft_access_addon_redirect_url" type="text" autocomplete="off" class="components-form-token-field__input" aria-expanded="false" aria-describedby="ethpress_nft_access_addon_redirect_url-howto" value="<?php echo esc_attr($meta['redirect_url']) ?>">
			</div>
			<p id="ethpress_nft_access_addon_redirect_url-howto" class="components-form-token-field__help"><?php esc_html_e('Redirect user here if they do not own ONE OF the required tokens defined below.', 'ethpress_nft_access_addon') ?></p>
		</div>
		<?php

		?>
		<div class="components-form-token-field" tabindex="-1" style="visibility: hidden;height:0px">
			<label for="ethpress_nft_access_addon_contract_addresses" class="components-form-token-field__label"><?php esc_html_e('NFT Contract Address', 'ethpress_nft_access_addon') ?></label>
			<div class="components-form-token-field__input-container" tabindex="-1">
				<input id="ethpress_nft_access_addon_contract_addresses" name="ethpress_nft_access_addon_contract_addresses" type="hidden" autocomplete="off" class="components-form-token-field__input" aria-expanded="false" aria-describedby="ethpress_nft_access_addon_contract_addresses-howto" value="<?php echo esc_attr($meta['contract_addresses']) ?>">
			</div>
			<p id="ethpress_nft_access_addon_contract_addresses-howto" class="components-form-token-field__help"><?php esc_html_e('A smart contract address.', 'ethpress_nft_access_addon') ?></p>
		</div>
		<?php

		?>
		<div class="components-form-token-field" tabindex="-1" style="visibility: hidden;height:0px">
			<label for="ethpress_nft_access_addon_token_ids" class="components-form-token-field__label"><?php esc_html_e('NFT Token ID', 'ethpress_nft_access_addon') ?></label>
			<div class="components-form-token-field__input-container" tabindex="-1">
				<input id="ethpress_nft_access_addon_token_ids" name="ethpress_nft_access_addon_token_ids" type="hidden" autocomplete="off" class="components-form-token-field__input" aria-expanded="false" aria-describedby="ethpress_nft_access_addon_token_ids-howto" value="<?php echo esc_attr($meta['token_ids']) ?>">
			</div>
			<p id="ethpress_nft_access_addon_token_ids-howto" class="components-form-token-field__help"><?php esc_html_e('The ID of the token.', 'ethpress_nft_access_addon') ?></p>
		</div>
		<?php

		?>
		<div class="form-field">
			<h3><?php esc_html_e('NFT', 'ethpress_nft_access_addon') ?></h3>
			<span style="margin: auto; width: 95%;" id="ethpress_nft_access_addon_show_items">
			</span>
			<span style="padding-top:10px" class="description">
				<a class="button" href="#" id="ethpress_nft_access_addon_add"><?php esc_html_e('Add NFT', 'ethpress_nft_access_addon') ?></a>
			</span>
		</div>
		</div>
<?php
	}


	/**
	 * Saves NFT fields from product data.
	 *
	 * @since 0.1.0
	 *
	 * @param int $post_id Id if product.
	 */
	public static function woocommerce_process_product_meta($post_id)
	{
		if (isset($_POST['ethpress_nft_access_addon_contract_addresses'])) {
			$_POST['ethpress_nft_access_addon_contract_addresses'] = implode(",", isset($_POST['ethpress_nft_access_addon_contract_address']) ? $_POST['ethpress_nft_access_addon_contract_address'] : []);
		}
		if (isset($_POST['ethpress_nft_access_addon_token_ids'])) {
			$_POST['ethpress_nft_access_addon_token_ids'] = implode(",", isset($_POST['ethpress_nft_access_addon_token_id']) ? $_POST['ethpress_nft_access_addon_token_id'] : []);
		}
		$next_meta = array(
			'redirect_url'       => sanitize_url(
				wp_unslash(isset($_POST['ethpress_nft_access_addon_redirect_url']) ? $_POST['ethpress_nft_access_addon_redirect_url'] : '')
			),
			'contract_addresses' => sanitize_text_field(
				wp_unslash(isset($_POST['ethpress_nft_access_addon_contract_addresses']) ? $_POST['ethpress_nft_access_addon_contract_addresses'] : '')
			),
			'token_ids'          => sanitize_text_field(
				wp_unslash(isset($_POST['ethpress_nft_access_addon_token_ids']) ? $_POST['ethpress_nft_access_addon_token_ids'] : '')
			),
		);
		// phpcs:enable WordPress.Security.NonceVerification.Missing
		Logger::log('update');
		update_post_meta(
			$post_id,
			'ethpress_nft_access_addon_product_data',
			$next_meta
		);
	}

	/**
	 * Restrict content from users without NFTs.
	 *
	 * @since 0.1.0
	 *
	 * @param string $content Contet of post.
	 * @return string Content.
	 */
	public static function woocommerce_add_to_cart_action($cart_item_key, $product_id)
	{
		$meta = get_post_meta($product_id, 'ethpress_nft_access_addon_product_data', true);
		if (empty($meta) || empty($meta['contract_addresses'])) {
			return $product_id;
		}
		$user_id = get_current_user_id();
		if (!$user_id) {
			return self::restricting_content($product_id);
		}
		$address = Address::find_by_user($user_id);
		if (is_wp_error($address)) {
			return self::restricting_content($product_id);
		}

		$contracts = array_map('trim', explode(',', $meta['contract_addresses']));
		$tokens    = array_map('trim', explode(',', $meta['token_ids']));
		$arrNft = array_map(null, $contracts, $tokens);

		//checking $contracts for not empty
		$isAddress = false;
		if ($contracts) foreach ($contracts as $contracts1) {
			if (\Web3\Utils::isAddress($contracts1)) {
				$isAddress = true;
			}
		}
		Logger::log('checking $contracts------:' . print_r($contracts, true));
		Logger::log('checking $contracts--$isAddress----:' . print_r($isAddress, true));
		if (!$isAddress) {
			//return true;
			// @TODO: clear address add log for admin
		}

		if (NFT::has_nft_for_current_user($arrNft)) {
			return true;
		} else {
			return self::restricting_content($product_id);
		}
	}

	public static function restrict_access_to_page_post()
	{
		$post = get_post();
		$page_id = $post->ID;
		if ('page' == $post->post_type || 'post' == $post->post_type) {
			$meta = get_post_meta($page_id, 'ethpress_nft_access_addon_product_data', true);
			if (empty($meta) || empty($meta['contract_addresses'])) {
				return $page_id;
			}
			$user_id = get_current_user_id();
			if (!$user_id) {
				return self::restricting_content($page_id);
			}
			$address = Address::find_by_user($user_id);
			if (is_wp_error($address)) {
				return self::restricting_content($page_id);
			}
			$contracts = array_map('trim', explode(',', $meta['contract_addresses']));
			$tokens    = array_map('trim', explode(',', $meta['token_ids']));
			$arrNft = array_map(null, $contracts, $tokens);
			//checking $contracts for not empty
			$isAddress = false;
			if ($contracts) foreach ($contracts as $contracts1) {
				if (\Web3\Utils::isAddress($contracts1)) {
					$isAddress = true;
				}
			}
			Logger::log('checking $contracts------:' . print_r($contracts, true));
			Logger::log('checking $contracts--$isAddress----:' . print_r($isAddress, true));
			if (!$isAddress) {
				//return true;
				// @TODO: clear address add log for admin
			}

			if (NFT::has_nft_for_current_user($arrNft)) {
				return true;
			} else {
				return self::restricting_content($page_id);
			}
		}
	}


	/**
	 * Outputs the content you see when NFT is not owned.
	 *
	 * @since 0.1.0
	 */
	public static function restricting_content($product_id)
	{
		$meta = get_post_meta($product_id, 'ethpress_nft_access_addon_product_data', true);
		Logger::log('-------------meta[redirect_url]---------------' . print_r($meta['redirect_url'], true));
		if (!empty($meta['redirect_url'])) {

			if (wp_doing_ajax()) {
				Logger::log('redirect_ajax');
				wp_send_json([
					"error" => true,
					"product_url" => $meta['redirect_url'],
				]);
			} else {
				wp_safe_redirect($meta['redirect_url']);
			}
		}
		exit;
	}

	/**
	 * Load translation files.
	 *
	 * @since 1.1.0
	 */
	public static function load_plugin_textdomain()
	{
		$path  = dirname(plugin_basename(ETHPRESS_NFT_ACCESS_ADDON_FILE));
		$path .= '/languages';
		load_plugin_textdomain('ethpress_nft_access_addon', false, $path);
	}
}
