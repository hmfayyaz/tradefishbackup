=== EthPress NFT Access Add-On ===
Contributors: lynn999, ethereumicoio, freemius
Donate link: https://www.crowdrise.com/horn-of-africa/fundraiser/lynn99
Tags: ethpress, token, ownership, NFT, ERC721
Requires at least: 4.6
Tested up to: 6.4.0
Stable tag: 1.6.7
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Check user NFT (non-fungible token, erc-721 and erc-1155) ownership. Perfect for blocking users access to Page, Post and a WooCommerce Products, if they don't own a certain NFT token.

== Description ==

Adds Ethereum NFT access restriction integration with Page, Post and WooCommerce products, via [EthPress](https://wordpress.org/plugins/ethpress/).

Start off by configuring this add-on in your WordPress admin by inputting your

1. Infura.io API key.
2. Your tokens' contract addresses and ids on the WC Product pages, into NFT product data tab.

> Binance Smart Chain (BSC), Polygon (MATIC) and any other EVM-compatible blockchain is supported in the [PRO version](https://checkout.freemius.com/mode/dialog/plugin/10731/plan/18172/?trial=paid "NFT Access Add-On")!

== Features ==

* Site wide NFT verification requirement to register or login
* Restrict access to a `Page` to some NFT token owners only
* Restrict access to a `Post` to some NFT token owners only
* Restrict access to a [WooCommerce](https://woocommerce.com/?aff=12943&cid=17113767) `Product` to some NFT token owners only
* Shortcode to display your access level: [ethpress_nft_access_addon_nft product_id="1337"]
* `ERC721` and `ERC1155` non-fungible token standards are supported
* Custom/private blockchain feature: `Ethereum Node JSON-RPC Endpoint` and other related settings to use Binance Smart Chain (BSC), Polygon (MATIC) and any other EVM compatible blockchain
* Scaling hundreds of NFTs can be configured and checked almost instantly for supported networks: mainnet, goerli, sepolia, polygon, mumbai, bsc, bsctest.
* The `ethpress_nft_access_get_user_accounts` filter can be used to add wallets for testing:

`
    add_filter('ethpress_nft_access_get_user_accounts', function($accounts) {
        $more_accounts = get_more_accounts();
        return array_merge($accounts, $more_accounts);
    });
`

== Integrations ==

* [LearnPress LMS](https://wordpress.org/plugins/learnpress/) support
* [Tutor LMS](https://wordpress.org/plugins/tutor/) support
* [Ethereum Wallet](https://wordpress.org/plugins/ethereum-wallet/) plugin generated accounts are tested

== Installation ==

Download the zip.

Install it via WordPress plugin installer by clicking on "Add New" and then on "Upload Plugin".

== Frequently Asked Questions ==

== Screenshots ==

== Changelog ==

= 1.6.7 =

* Error reporting enhancements

= 1.6.6 =

* PulseChain support added

= 1.6.5 =

* freemius lib version update

= 1.6.4 =

* freemius lib version update

= 1.6.3 =

* freemius lib version update

= 1.6.2 =

* Fix fatal error in strict PHP mode if the blockchain network setting is not set.

= 1.6.1 =

* Fix fatal error if the Ethereum Wallet plugin is not installed.

= 1.6.0 =

* [LearnPress LMS](https://wordpress.org/plugins/learnpress/) support
* [Tutor LMS](https://wordpress.org/plugins/tutor/) support
* Blockchain settings configuration is simplified for both, infura.io supported and custom networks

= 1.5.1 =

* Fix site wide access for already registered user

= 1.5.0 =

* Scaling for many NFTs: hundreds of NFTs can be configured and checked almost instantly for supported networks: mainnet, goerli, sepolia, polygon, mumbai, bsc, bsctest.

= 1.4.1 =

* Site wide NFT Login Access redirect fix

= 1.4.0 =

* Require NFT verification to login

= 1.3.1 =

* `is_ajax` function usage without WC installed fix.

= 1.3.0 =

* `ERC1155` token standard support is added.

= 1.2.2 =

* `ETHPRESS_NFT_ACCESS_ADDON_deactivate` function redeclare fix

= 1.2.1 =

* WooCommerce requirement should be optional fix.

= 1.2.0 =

* [Ethereum Wallet](https://wordpress.org/plugins/ethereum-wallet/) plugin support
* The `ethpress_nft_access_get_user_accounts` filter can be used to add wallets for testing

= 1.1.0 =

* Page and Post types NFT restriction support is added

= 1.0.3 =

* Fix for the "addon license blocking the parent plugin" issue
* freemius lib update

= 1.0.2 =

* Typo fix

= 1.0.1 =

* Better settings page handling.

= 1.0.0 =

* Initial release.

== Upgrade Notice ==
