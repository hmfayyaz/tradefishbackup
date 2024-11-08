<?php

/**
 * NFT blockchain interactions
 *
 * @package Ethpress_NFT_Access
 *
 * @since 0.1.0
 */

namespace losnappas\Ethpress_NFT_Access;

defined('ABSPATH') || die;

use losnappas\Ethpress\Address;
//use losnappas\Ethpress\Logger;
use losnappas\Ethpress_NFT_Access\Token\TokenFactory;
use losnappas\Ethpress_NFT_Access\Token\BulkBalance;

/**
 * Wraps NFT api calls.
 *
 * @since 0.1.0
 */
class NFT
{
	public static $noNFT = 'noNFT';

	/**
	 * has_nft_for_current_user
	 *
	 * @param  mixed $arrNft
	 * @return bool true - if the user is the owner of the token
	 */
	public static function has_nft_for_current_user($arrNft)
	{
		return self::has_nft($arrNft, null, null);
	}

	/**
	 * has_nft_for_user_address
	 *
	 * @param  mixed $arrNft
	 * @param  mixed $userAddress
	 * @return bool true - if the user is the owner of the token
	 */
	public static function has_nft_for_user_address($arrNft, $userAddress)
	{
		return self::has_nft($arrNft, null, $userAddress);
	}

	/**
	 * has_nft_for_user_id
	 *
	 * @param  mixed $arrNft
	 * @param  mixed $user_id
	 * @return bool true - if the user is the owner of the token
	 */
	public static function has_nft_for_user_id($arrNft, $user_id)
	{
		return self::has_nft($arrNft, $user_id, null);
	}

	/**
	 * has_nft
	 *
	 * @param  array [[$contractAddress, $tokenID]]
	 * @return bool true - if the user is the owner of the token
	 */
	private static function has_nft($arrNft, $user_id = null, $userAddress = null)
	{
		$wallets = self::getWallets($user_id, $userAddress);
		if (!$wallets) {
			return false;
		}
		return BulkBalance::isOwnerTokenBalance($arrNft, $wallets);
	}

	/**
	 * getWallets
	 *
	 * @param  int|null $user_id
	 * @param  string|null $userAddress
	 * @return array|false wallets
	 */
	private static function getWallets($user_id = null, $userAddress = null)
	{
		if (!is_null($userAddress)) {
			return [$userAddress];
		}
		if (is_null($user_id)) {
			$user_id = get_current_user_id();
		}
		if (!$user_id) {
			return false;
		}
		$address = Address::find_by_user($user_id);
		if (is_wp_error($address)) {
			return false;
		}
		return apply_filters('ethpress_nft_access_get_user_accounts', [
			$address->get_address(),
		], $user_id);
	}
}
