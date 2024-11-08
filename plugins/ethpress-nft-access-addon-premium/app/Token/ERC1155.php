<?php

namespace losnappas\Ethpress_NFT_Access\Token;

defined('ABSPATH') || die;

use losnappas\Ethpress_NFT_Access\BlockchainConnection;
use losnappas\Ethpress\Logger;


/**
 * ERC1155
 */
class ERC1155 implements IToken
{
    protected static $erc1155ContractABI = '[{"anonymous": false,"inputs": [{"indexed": true,"internalType": "address","name": "account","type": "address"},{"indexed": true,"internalType": "address","name": "operator","type": "address"},{"indexed": false,"internalType": "bool","name": "approved","type": "bool"}],"name": "ApprovalForAll","type": "event"},{"anonymous": false,"inputs": [{"indexed": true,"internalType": "address","name": "previousOwner","type": "address"},{"indexed": true,"internalType": "address","name": "newOwner","type": "address"}],"name": "OwnershipTransferred","type": "event"},{"anonymous": false,"inputs": [{"indexed": true,"internalType": "address","name": "operator","type": "address"},{"indexed": true,"internalType": "address","name": "from","type": "address"},{"indexed": true,"internalType": "address","name": "to","type": "address"},{"indexed": false,"internalType": "uint256[]","name": "ids","type": "uint256[]"},{"indexed": false,"internalType": "uint256[]","name": "values","type": "uint256[]"}],"name": "TransferBatch","type": "event"},{"anonymous": false,"inputs": [{"indexed": true,"internalType": "address","name": "operator","type": "address"},{"indexed": true,"internalType": "address","name": "from","type": "address"},{"indexed": true,"internalType": "address","name": "to","type": "address"},{"indexed": false,"internalType": "uint256","name": "id","type": "uint256"},{"indexed": false,"internalType": "uint256","name": "value","type": "uint256"}],"name": "TransferSingle","type": "event"},{"anonymous": false,"inputs": [{"indexed": false,"internalType": "string","name": "value","type": "string"},{"indexed": true,"internalType": "uint256","name": "id","type": "uint256"}],"name": "URI","type": "event"},{"inputs": [{"internalType": "address","name": "account","type": "address"},{"internalType": "uint256","name": "id","type": "uint256"},{"internalType": "uint256","name": "amount","type": "uint256"},{"internalType": "bytes","name": "data","type": "bytes"}],"name": "mint","outputs": [],"stateMutability": "nonpayable","type": "function"},{"inputs": [{"internalType": "address","name": "to","type": "address"},{"internalType": "uint256[]","name": "ids","type": "uint256[]"},{"internalType": "uint256[]","name": "amounts","type": "uint256[]"},{"internalType": "bytes","name": "data","type": "bytes"}],"name": "mintBatch","outputs": [],"stateMutability": "nonpayable","type": "function"},{"inputs": [],"name": "renounceOwnership","outputs": [],"stateMutability": "nonpayable","type": "function"},{"inputs": [{"internalType": "address","name": "from","type": "address"},{"internalType": "address","name": "to","type": "address"},{"internalType": "uint256[]","name": "ids","type": "uint256[]"},{"internalType": "uint256[]","name": "amounts","type": "uint256[]"},{"internalType": "bytes","name": "data","type": "bytes"}],"name": "safeBatchTransferFrom","outputs": [],"stateMutability": "nonpayable","type": "function"},{"inputs": [{"internalType": "address","name": "from","type": "address"},{"internalType": "address","name": "to","type": "address"},{"internalType": "uint256","name": "id","type": "uint256"},{"internalType": "uint256","name": "amount","type": "uint256"},{"internalType": "bytes","name": "data","type": "bytes"}],"name": "safeTransferFrom","outputs": [],"stateMutability": "nonpayable","type": "function"},{"inputs": [{"internalType": "address","name": "operator","type": "address"},{"internalType": "bool","name": "approved","type": "bool"}],"name": "setApprovalForAll","outputs": [],"stateMutability": "nonpayable","type": "function"},{"inputs": [{"internalType": "string","name": "newuri","type": "string"}],"name": "setURI","outputs": [],"stateMutability": "nonpayable","type": "function"},{"inputs": [{"internalType": "address","name": "newOwner","type": "address"}],"name": "transferOwnership","outputs": [],"stateMutability": "nonpayable","type": "function"},{"inputs": [],"stateMutability": "nonpayable","type": "constructor"},{"inputs": [{"internalType": "address","name": "account","type": "address"},{"internalType": "uint256","name": "id","type": "uint256"}],"name": "balanceOf","outputs": [{"internalType": "uint256","name": "","type": "uint256"}],"stateMutability": "view","type": "function"},{"inputs": [{"internalType": "address[]","name": "accounts","type": "address[]"},{"internalType": "uint256[]","name": "ids","type": "uint256[]"}],"name": "balanceOfBatch","outputs": [{"internalType": "uint256[]","name": "","type": "uint256[]"}],"stateMutability": "view","type": "function"},{"inputs": [{"internalType": "uint256","name": "id","type": "uint256"}],"name": "exists","outputs": [{"internalType": "bool","name": "","type": "bool"}],"stateMutability": "view","type": "function"},{"inputs": [{"internalType": "address","name": "account","type": "address"},{"internalType": "address","name": "operator","type": "address"}],"name": "isApprovedForAll","outputs": [{"internalType": "bool","name": "","type": "bool"}],"stateMutability": "view","type": "function"},{"inputs": [],"name": "owner","outputs": [{"internalType": "address","name": "","type": "address"}],"stateMutability": "view","type": "function"},{"inputs": [{"internalType": "bytes4","name": "interfaceId","type": "bytes4"}],"name": "supportsInterface","outputs": [{"internalType": "bool","name": "","type": "bool"}],"stateMutability": "view","type": "function"},{"inputs": [{"internalType": "uint256","name": "id","type": "uint256"}],"name": "totalSupply","outputs": [{"internalType": "uint256","name": "","type": "uint256"}],"stateMutability": "view","type": "function"},{"inputs": [{"internalType": "uint256","name": "","type": "uint256"}],"name": "uri","outputs": [{"internalType": "string","name": "","type": "string"}],"stateMutability": "view","type": "function"}]';

    public function isOwner($contractAddress, $tokenID, $userWallet)
    {
        $httpProvider = BlockchainConnection::getInstance()->getHttpProvider();
        try {
            if (!empty($contractAddress) && !empty($tokenID)) {
                // Logger::log(print_r($tokenID, true));
                $nToken  = self::erc1155_balanceOf($contractAddress, $tokenID, $userWallet, $httpProvider);

                if (is_null($nToken)) {
                    return false;
                }
                $nTokenBI = new \phpseclib3\Math\BigInteger($nToken);
                // Logger::log(print_r($nTokenBI->toString(), true));
                if ($nTokenBI->compare(new \phpseclib3\Math\BigInteger(0)) > 0) {
                    // Logger::log('ownership ok balance');
                    return true;
                }
            }
        } catch (\Exception $ex) {
            Logger::log("ERC1155::isOwner: " . $ex->getMessage());
        }
        return false;
    }

    /**
     * Find the number of tokens the owner has
     * 
     * @dev NFTs assigned to zero address are considered invalid, and queries about them do throw.
     *
     * @param  string $tokenAddress
     * @param  string $ownerAddress
     * @param  \Web3\Providers\HttpProvider $httpProvider
     * @return \phpseclib3\Math\BigInteger|string|null The number of tokens the owner has
     */
    private static function erc1155_balanceOf($tokenAddress, $tokenID, $userWallet, $httpProvider)
    {
        $abi = self::$erc1155ContractABI;
        // Logger::log("ownerOf($tokenAddress, $tokenID)");
        $ret = null;
        $err = null;
        $callback = function ($error, $result) use (&$ret, &$err, $userWallet, $tokenID) {
            // Logger::log("ownerOf cb: error = " . print_r($error, true) . "; result = " . $result);
            if ($error !== null) {
                $err = $error;
                Logger::log("balanceOf1155: " . $err);
                $allowedMessages = [
                    'owner query for nonexistent token',
                ];
                if (empty(array_filter($allowedMessages, function ($m) use ($error) {
                    return false !== strpos($error, $m);
                }))) {
                    //	Logger::log("balanceOf($tokenAddress, wallet, $tokenID): " . $error);
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
        $contract->at($tokenAddress)->call("balanceOf", $userWallet, $tokenID, $callback);
        if (!is_null($err)) {
            throw new \Exception($err);
        }
        return $ret;
    }
}
