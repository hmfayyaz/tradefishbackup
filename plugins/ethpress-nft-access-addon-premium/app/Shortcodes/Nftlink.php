<?php

/**
 * Shortcode for NFTs
 *
 * @since 0.5.0
 *
 * @package Ethpress_NFT_Access
 */

namespace losnappas\Ethpress_NFT_Access\Shortcodes;

defined('ABSPATH') || die;

use losnappas\Ethpress_NFT_Access\Nft;
use losnappas\Ethpress\Address;
use losnappas\Ethpress\Logger;

/**
 * Contrainer class for shortcode
 *
 * @since 0.5.0
 */
class Nftlink
{
	public static function ethpress_nft_access_addon_nft_shortcode($attrs)
	{
		$disabled = true;
		// This IF block will be auto removed from the Free version.
		if (\losnappas\Ethpress_NFT_Access\ethpress_nft_access_addon_freemius_init()->is__premium_only()) {
			$disabled = !\losnappas\Ethpress_NFT_Access\ethpress_nft_access_addon_freemius_init()->can_use_premium_code();
		}
		if ($disabled) {
			return '';
		}
		if (!function_exists('\wc_get_product')) {
			// WooCommerce is required
			return '';
		}
		$attributes = shortcode_atts(array(
			'productid' => '',
			'product_id' => '',
			'product' => '',
			// 'tokenaddress' => '',
			//'display' => 'namesurname', // username is also supported
		), $attrs, 'ethpress_nft_access_addon_nft');

		$product_id = !empty($attributes['productid']) ? esc_attr($attributes['productid']) : null;
		if (is_null($product_id)) {
			$product_id = !empty($attributes['product_id']) ? esc_attr($attributes['product_id']) : null;
		}
		if (is_null($product_id)) {
			$product_id = !empty($attributes['product']) ? esc_attr($attributes['product']) : null;
		}
		if (is_null($product_id)) {
			return '<p>' . esc_html__('The product ID not set', 'ethpress_nft_access_addon') . '</p>';
		}

		$product = \wc_get_product((int) $product_id);
		Logger::log(print_r($product_id, true));
		if (!$product) {
			return '<p>' . esc_html__('No product with that ID.', 'ethpress_nft_access_addon') . '</p>';
			Logger::log('product');
		}
		if (!is_user_logged_in()) {
			wp_enqueue_script('ethpress-login-front');
			Logger::log('ethpress-login-front');
		}

		$meta = $product->get_meta('ethpress_nft_access_addon_product_data');
		$url  = '#';
		if (!empty($meta['redirect_url'])) {
			$url = $meta['redirect_url'];
			Logger::log('redirect_url');
		}

		$return_values = array(
			'not_logged_in'    => '<p><a href="' . esc_url($product->get_permalink()) . '" class="button ethpress-nft-access-addon-nft ethpress-metamask-login-button">' . esc_html__('Check for NFT to Access', 'ethpress_nft_access_addon') . '</a></p>',
			'no_nft_data'      => '<p><a href="' . esc_url($product->get_permalink()) . '" class="button ethpress-nft-access-addon-nft no-nft-data">' . esc_html__('View Product', 'ethpress_nft_access_addon') . '</a></p>',
			'does_own_nft'     => '<p><a href="' . esc_url($product->get_permalink()) . '" class="button ethpress-nft-access-addon-nft no-nft-data">' . esc_html__('View Product', 'ethpress_nft_access_addon') . '</a></p>',
			'does_not_own_nft' => '<p><a href="' . esc_url($url) . '" class="button ethpress-nft-access-addon-nft no-nft-data">' . esc_html__('Purchase NFT to Access', 'ethpress_nft_access_addon') . '</a></p>',
		);
		if (empty($meta) || empty($meta['contract_addresses'])) {
			//Logger::log(print_r($meta, true));
			return $return_values['no_nft_data'];
		}
		$user_id = get_current_user_id();
		if (!$user_id) {
			return $return_values['not_logged_in'];
		}
		$address = Address::find_by_user($user_id);
		Logger::log(print_r($address, true));
		if (is_wp_error($address)) {
			return $return_values['not_logged_in'];
		}
		$contracts = array_map('trim', explode(',', $meta['contract_addresses']));
		$tokens    = array_map('trim', explode(',', $meta['token_ids']));
		$arrNft = array_map(null, $contracts, $tokens);

		if (NFT::has_nft_for_current_user($arrNft)) {
			return $return_values['does_own_nft'];
		} else {
			return $return_values['does_not_own_nft'];
		}
	}
}
