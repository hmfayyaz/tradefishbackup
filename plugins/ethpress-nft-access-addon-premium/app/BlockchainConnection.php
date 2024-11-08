<?php

namespace losnappas\Ethpress_NFT_Access;

defined('ABSPATH') || die;

use losnappas\Ethpress\Logger;

/**
 * BlockchainConnection
 */
class BlockchainConnection
{
    private static $_httpProvider = null;
    private static $_saved_chain_id = null;

    private function __construct()
    {
    }

    private static $instance = null;
    public static function getInstance()
    {
        if (is_Null(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    /**
     * getWeb3Endpoint
     *
     * @return string web3Endpoint
     */
    public function getWeb3Endpoint()
    {
        // Logger::log('getWeb3Endpoint');
        global $ETHPRESS_NFT_ACCESS_ADDON_options;
        $blockchainAPINodeType = $this->getBlockchainAPINodeType();
        switch ($blockchainAPINodeType) {
            case 'infuraio': {

                    $infuraApiKey = isset($ETHPRESS_NFT_ACCESS_ADDON_options['infuraApiKey']) ?
                        esc_attr($ETHPRESS_NFT_ACCESS_ADDON_options['infuraApiKey']) : '';
                    $blockchainNetwork = $this->getBlockchainNetwork();

                    // Logger::log(print_r($infuraApiKey, true));

                    if (empty($blockchainNetwork)) {
                        $blockchainNetwork = 'mainnet';
                    }
                    $web3Endpoint = "https://" . esc_attr($blockchainNetwork) . ".infura.io/v3/" . esc_attr($infuraApiKey);
                }
                break;
            case 'custom': {

                    $web3Endpoint = isset($ETHPRESS_NFT_ACCESS_ADDON_options['web3Endpoint']) ?
                        esc_attr($ETHPRESS_NFT_ACCESS_ADDON_options['web3Endpoint']) : '';
                }
                break;
        }
        return $web3Endpoint;
    }

    /**
     * Get the HttpProvider connection object
     *
     * @return HttpProvider
     */
    public function getHttpProvider($providerUrl = null)
    {
        if (is_null($providerUrl)) {
            $providerUrl = $this->getWeb3Endpoint();
        }
        if (is_null(self::$_httpProvider)) {
            self::$_httpProvider = [];
        }
        if (!isset(self::$_httpProvider[$providerUrl])) {
            $requestManager = new \Web3\RequestManagers\HttpRequestManager($providerUrl, 10/* seconds */);
            $httpProvider = new \Web3\Providers\HttpProvider($requestManager);
            self::$_httpProvider[$providerUrl] = $httpProvider;
        }
        return self::$_httpProvider[$providerUrl];
    }

    /**
     * Get the blockchain API node type
     *
     * @return string infuraio|custom
     */
    public function getBlockchainAPINodeType()
    {
        global $ETHPRESS_NFT_ACCESS_ADDON_options;
        $blockchainAPINodeType = 'infuraio';
        if (isset($ETHPRESS_NFT_ACCESS_ADDON_options['blockchain_api_node']) && !empty($ETHPRESS_NFT_ACCESS_ADDON_options['blockchain_api_node'])) {
            $blockchainAPINodeType =
                $ETHPRESS_NFT_ACCESS_ADDON_options['blockchain_api_node'];
        } else if (isset($ETHPRESS_NFT_ACCESS_ADDON_options['web3Endpoint']) && !empty($ETHPRESS_NFT_ACCESS_ADDON_options['web3Endpoint'])) {
            $blockchainAPINodeType = 'custom';
        }
        // Logger::log('getBlockchainNetwork: blockchainAPINodeType = ' . $blockchainAPINodeType);
        return $blockchainAPINodeType;
    }

    /**
     * getBlockchainNetwork
     *
     * @return string blockchainNetwork
     */
    public function getBlockchainNetwork()
    {
        global $ETHPRESS_NFT_ACCESS_ADDON_options;
        $blockchainNetwork = 'mainnet';

        $blockchainAPINodeType = $this->getBlockchainAPINodeType();
        switch ($blockchainAPINodeType) {
            case 'infuraio': {
                    if (
                        isset($ETHPRESS_NFT_ACCESS_ADDON_options['blockchain_network']) &&
                        !empty($ETHPRESS_NFT_ACCESS_ADDON_options['blockchain_network'])
                    ) {
                        $blockchainNetwork = strtolower($ETHPRESS_NFT_ACCESS_ADDON_options['blockchain_network']);
                    }
                }
                break;
            case 'custom': {
                    $web3Endpoint = isset($ETHPRESS_NFT_ACCESS_ADDON_options['web3Endpoint']) ?
                        esc_attr($ETHPRESS_NFT_ACCESS_ADDON_options['web3Endpoint']) : '';
                    if (!empty($web3Endpoint)) {
                        $chainId = $this->_getChainId_network_impl($web3Endpoint);
                        $blockchainNetwork = apply_filters('ethereumico.io/blockchain-info/blockchain-name', $blockchainNetwork, $chainId);
                    }
                }
                break;
        }
        return $blockchainNetwork;
    }

    public function getChainId()
    {
        if (is_null(self::$_saved_chain_id)) {
            self::$_saved_chain_id = $this->_getChainId_impl();
        }
        return self::$_saved_chain_id;
    }

    private function _getChainId_network_impl($providerUrl)
    {
        if (empty($providerUrl)) {
            return null;
        }
        $option_name = 'ethereumicoio-blockchain-id-' . hash('haval256,4', $providerUrl);
        $_version = get_option($option_name, '');

        if ('' === $_version) {
            $_version = null;
            try {
                $web3 = new \Web3\Web3($this->getHttpProvider($providerUrl));
                $web3->net->version(function ($err, $version) use (&$_version, $providerUrl) {
                    if ($err !== null) {
                        Logger::log("_getChainId_network_impl: Failed to get blockchain version for '$providerUrl': " . $err);
                        return;
                    }
                    $_version = $version;
                });
            } catch (\Exception $ex) {
                Logger::log("_getChainId_network_impl: " . $ex->getMessage());
                $_version = null;
            }
            if (get_option($option_name)) {
                update_option($option_name, $_version);
            } else {
                $deprecated = '';
                $autoload = 'no';
                add_option($option_name, $_version, $deprecated, $autoload);
            }
        }

        if (!is_null($_version)) {
            $_version = intval($_version);
        }

        return $_version;
    }

    private function _getChainId_impl()
    {
        global $ETHPRESS_NFT_ACCESS_ADDON_options;
        if (\losnappas\Ethpress_NFT_Access\ethpress_nft_access_addon_freemius_init()->can_use_premium_code__premium_only()) {
            $blockchainAPINodeType = $this->getBlockchainAPINodeType();
            if ('custom' === $blockchainAPINodeType) {
                $web3Endpoint = isset($ETHPRESS_NFT_ACCESS_ADDON_options['web3Endpoint']) ?
                    esc_attr($ETHPRESS_NFT_ACCESS_ADDON_options['web3Endpoint']) : '';
                if (!empty($web3Endpoint)) {
                    return $this->_getChainId_network_impl($web3Endpoint);
                }
            }
        }

        $blockchainNetwork = $this->getBlockchainNetwork();
        if (empty($blockchainNetwork)) {
            $blockchainNetwork = 'mainnet';
        }
        $blockchainId = apply_filters('ethereumico.io/blockchain-info/blockchain-id', null, $blockchainNetwork);
        if (is_null($blockchainId)) {
            Logger::log("Bad blockchain_network setting:" . $blockchainNetwork);
        }
        Logger::log("_getChainId_impl: blockchainNetwork = " . $blockchainNetwork . '; blockchainId = ' . $blockchainId);
        return $blockchainId;
    }
}
