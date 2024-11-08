<?php

namespace losnappas\Ethpress_NFT_Access\Token;

defined('ABSPATH') || die;

use losnappas\Ethpress_NFT_Access\BlockchainConnection;
use losnappas\Ethpress\Logger;



/**
 * BulkBalance
 */
class BulkBalance
{
    protected static $tokenBalanceABI = '[{"inputs": [{"internalType": "address","name": "tokenAddress","type": "address"},{"internalType": "uint256","name": "tokenID","type": "uint256"},{"internalType": "address","name": "userAddress","type": "address"}],"name": "_isOwnerERC1155","outputs": [{"internalType": "bool","name": "","type": "bool"}],"stateMutability": "view","type": "function"},{"inputs": [{"internalType": "address","name": "tokenAddress","type": "address"},{"internalType": "uint256","name": "tokenID","type": "uint256"},{"internalType": "address","name": "userAddress","type": "address"}],"name": "_isOwnerERC721","outputs": [{"internalType": "bool","name": "","type": "bool"}],"stateMutability": "view","type": "function"},{"inputs": [{"internalType": "address","name": "tokenAddress","type": "address"},{"internalType": "uint256","name": "minBalance","type": "uint256"},{"internalType": "address","name": "userAddress","type": "address"}],"name": "getBalanceERC20","outputs": [{"internalType": "bool","name": "","type": "bool"}],"stateMutability":"view","type": "function"},{"inputs": [{"internalType": "address[]","name": "tokenAddress","type": "address[]"},{"internalType": "uint256[]","name": "tokenID","type": "uint256[]"},{"internalType": "address[]","name": "userAddress","type": "address[]"}],"name": "isOwner","outputs": [{"internalType": "bool","name": "","type": "bool"}],"stateMutability": "view","type": "function"},{"inputs": [{"internalType": "address[]","name": "tokenAddress","type": "address[]"},{"internalType": "uint256[]","name": "tokenID","type": "uint256[]"},{"internalType": "address","name": "userAddress","type": "address"}],"name": "isOwner","outputs": [{"internalType": "bool","name": "","type": "bool"}],"stateMutability": "view","type": "function"},{"inputs": [{"internalType": "address[]","name": "tokenAddress","type":"address[]"},{"internalType": "uint256[]","name": "minBalance","type": "uint256[]"},{"internalType": "address[]","name": "userAddress","type": "address[]"}],"name": "isOwnerERC20","outputs": [{"internalType": "bool","name": "","type": "bool"}],"stateMutability": "view","type": "function"}]';

    public static function isOwnerTokenBalance($arrNft, $wallets)
    {
        $bulkBalanceContractAddress = BulkBalance::getBulkBalanceContractAddress();
        if (empty($bulkBalanceContractAddress)) {
            return self::isOwnerSingleRequest($arrNft, $wallets);
        } else {
            return self::isOwnerBulkRequest($arrNft, $wallets, $bulkBalanceContractAddress);
        }
        return false;
    }

    /**
     * has_nft_single_requests
     *
     * @param  array [[$contractAddress, $tokenID]]
     * @param  array [wallets]
     * @return bool true - if the user is the owner of the token
     */
    private static function isOwnerSingleRequest($arrNft, $wallets)
    {

        if ($wallets) foreach ($wallets as $wallet) {
            if ($arrNft) foreach ($arrNft as $nft) {
                $contractAddress = $nft[0];
                $tokenID = $nft[1];
                if (\Web3\Utils::isAddress($contractAddress)) {
                    $token = TokenFactory::createToken($contractAddress);
                    $isOwner = $token->isOwner($contractAddress, $tokenID, $wallet);
                    if ($isOwner) {
                        return $isOwner;
                    }
                }
            }
        }
        // Logger::log('restricting');
        return false;
    }


    private static function getTokenAddress($arrNft)
    {
        return $arrNft[0];
    }

    private static function getTokenIDs($arrNft)
    {
        return $arrNft[1];
    }

    /**
     * isOwnerBulkRequest
     *
     * @param  mixed $arrNft
     * @param  mixed $wallets
     * @param  mixed $bulkBalanceContractAddress
     * @return bool true - if the user is the owner of the token
     */
    private static function isOwnerBulkRequest($arrNft, $wallets, $bulkBalanceContractAddress)
    {
        $abi = self::$tokenBalanceABI;
        $httpProvider = BlockchainConnection::getInstance()->getHttpProvider();

        $tokenAddress = array_map(array(__CLASS__, 'getTokenAddress'), $arrNft);
        $tokenIDs = array_map(array(__CLASS__, 'getTokenIDs'), $arrNft);

        // Logger::log("ownerOf($tokenAddress, $tokenIDs)");
        $ret = null;
        $err = null;
        $callback = function ($error, $result) use (&$ret, &$err, $tokenAddress, $tokenIDs, $wallets) {
            // Logger::log("ownerOf cb: error = " . print_r($error, true) . "; result = " . $result);
            if ($error !== null) {
                $err = $error;
                Logger::log("isOwner: " . $err);
                $allowedMessages = [
                    'owner query for nonexistent token',
                ];
                if (empty(array_filter($allowedMessages, function ($m) use ($error) {
                    return false !== strpos($error, $m);
                }))) {
                    //	Logger::log("balanceOf($tokenAddress, wallet, $tokenIDs): " . $error);
                }
                return;
            }
            if ($result) foreach ($result as $key => $res) {
                $ret = $res;
                break;
            }
        };
        // call contract function
        $contract = new \Web3\Contract($httpProvider, $abi);
        $contract->at($bulkBalanceContractAddress)->call("isOwner", $tokenAddress, $tokenIDs, $wallets, $callback);
        if (!is_null($err)) {
            throw new \Exception($err);
        }
        return $ret;
    }

    /**
     * getBulkBalanceContractAddress
     *
     * @return ContractAddress|null
     */
    private static function getBulkBalanceContractAddress()
    {
        $chainId = BlockchainConnection::getInstance()->getChainId();
        $blockchainInfo = apply_filters('ethereumico.io/blockchain-info', null, $chainId);
        if (is_null($blockchainInfo)) {
            ETHEREUM_WALLET_log("Bad chain id:" . $chainId);
            return null;
        }
        return $blockchainInfo['bulk_balance_contract_address'];
    }
}
