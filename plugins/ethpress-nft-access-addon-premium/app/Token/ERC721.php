<?php

namespace losnappas\Ethpress_NFT_Access\Token;

//use Ethereumico\Epg\Dependencies\Web3\Contracts\Types\Boolean;

defined('ABSPATH') || die;

use losnappas\Ethpress_NFT_Access\BlockchainConnection;
use losnappas\Ethpress\Logger;

/**
 * Static.
 *
 * @since 0.1.0
 */
class ERC721 implements IToken
{
    protected static $erc721ContractABI = '[{"inputs":[],"stateMutability":"nonpayable","type":"constructor"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"owner","type":"address"},{"indexed":true,"internalType":"address","name":"approved","type":"address"},{"indexed":true,"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"Approval","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"owner","type":"address"},{"indexed":true,"internalType":"address","name":"operator","type":"address"},{"indexed":false,"internalType":"bool","name":"approved","type":"bool"}],"name":"ApprovalForAll","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"from","type":"address"},{"indexed":true,"internalType":"address","name":"to","type":"address"},{"indexed":true,"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"Transfer","type":"event"},{"inputs":[{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"approve","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"owner","type":"address"}],"name":"balanceOf","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"getApproved","outputs":[{"internalType":"address","name":"","type":"address"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"owner","type":"address"},{"internalType":"address","name":"operator","type":"address"}],"name":"isApprovedForAll","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"uint256","name":"_tokenId","type":"uint256"},{"internalType":"string","name":"_tokenURI","type":"string"}],"name":"mint","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"_to","type":"address"},{"internalType":"uint256","name":"_tokenId","type":"uint256"},{"internalType":"string","name":"_tokenURI","type":"string"}],"name":"mintTo","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[],"name":"name","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"ownerOf","outputs":[{"internalType":"address","name":"","type":"address"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"from","type":"address"},{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"safeTransferFrom","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"from","type":"address"},{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"tokenId","type":"uint256"},{"internalType":"bytes","name":"_data","type":"bytes"}],"name":"safeTransferFrom","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"operator","type":"address"},{"internalType":"bool","name":"approved","type":"bool"}],"name":"setApprovalForAll","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"bytes4","name":"interfaceId","type":"bytes4"}],"name":"supportsInterface","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"symbol","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"uint256","name":"index","type":"uint256"}],"name":"tokenByIndex","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"owner","type":"address"},{"internalType":"uint256","name":"index","type":"uint256"}],"name":"tokenOfOwnerByIndex","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"tokenURI","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"totalSupply","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"from","type":"address"},{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"transferFrom","outputs":[],"stateMutability":"nonpayable","type":"function"}]';

    public function isOwner($contractAddress, $tokenID, $userWallet)
    {
        $httpProvider = BlockchainConnection::getInstance()->getHttpProvider();

        try {

            if (!empty($contractAddress) && !empty($tokenID)) {
                // Logger::log('ownerOf before');
                $tokenOwnerAddress = self::erc721_ownerOf($contractAddress, $tokenID, $httpProvider);
                // Logger::log('ownerOf after-----:' . $tokenOwnerAddress);
                if (!is_null($tokenOwnerAddress)) {
                    // Logger::log("wallet address-----:" . $wallet);
                    // Logger::log("owner address-----:" . $tokenOwnerAddress);
                    if (strtolower($userWallet) == strtolower($tokenOwnerAddress)) {
                        // Logger::log('ownership ok ownerOf');
                        return true;
                    }
                }
            }
            if (!empty($contractAddress) && empty($tokenID)) {
                // Logger::log(print_r($tokenID, true));
                $nToken  = self::erc721_balanceOf($contractAddress, $userWallet, $httpProvider);
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
            Logger::log("ERC721::isOwner: " . $ex->getMessage());
        }
        return false;
    }

    /**
     * Find the owner of an NFT
     * 
     * @dev NFTs assigned to zero address are considered invalid, and queries about them do throw.
     *
     * @param  string $tokenAddress
     * @param  string $tokenID The identifier for an NFT
     * @param  \Web3\Providers\HttpProvider $httpProvider
     * @return string The address of the owner of the NFT
     */
    private static function erc721_ownerOf($tokenAddress, $tokenID, $httpProvider)
    {
        $abi = self::$erc721ContractABI;
        // Logger::log("ownerOf($tokenAddress, $tokenID)");
        $ret = null;
        $err = null;
        $callback = function ($error, $result) use (&$ret, &$err, $tokenAddress, $tokenID) {
            // Logger::log("ownerOf cb: error = " . print_r($error, true) . "; result = " . $result);
            if ($error !== null) {
                $err = $error;
                Logger::log("ownerOf: " . $err);
                $allowedMessages = [
                    'owner query for nonexistent token',
                    // 'approved for nonexistent token query',
                ];
                if (empty(array_filter($allowedMessages, function ($m) use ($error) {
                    return false !== strpos($error, $m);
                }))) {
                    //	Logger::log("ownerOf($tokenAddress, $tokenID): " . $error);
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
        $contract->at($tokenAddress)->call("ownerOf", $tokenID, $callback);
        if (!is_null($err)) {
            throw new \Exception($err);
        }
        // Logger::log("ownerOf: ret = " . print_r($ret, true));
        return $ret;
        // }
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
    private static function erc721_balanceOf($tokenAddress, $userWallet, $httpProvider)
    {
        $abi = self::$erc721ContractABI;
        $ret = null;
        $err = null;
        // Logger::log('balanceOf');
        // Logger::log('token address ---------------:' . print_r($tokenAddress, true));
        // Logger::log('token address ---------------:' . print_r($ownerAddress, true));
        $callback = function ($error, $result) use (&$ret, &$err, $tokenAddress, $userWallet) {
            if ($error !== null) {
                $err = $error;
                Logger::log("balanceOf: " . $err);
                $allowedMessages = [
                    'owner query for nonexistent token',
                    // 'approved for nonexistent token query',
                ];
                if (empty(array_filter($allowedMessages, function ($m) use ($error) {
                    return false !== strpos($error, $m);
                }))) {
                    //	Logger::log("balanceOf($tokenAddress, $tokenID): " . $error);
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
        $contract->at($tokenAddress)->call("balanceOf", $userWallet, $callback);
        if (!is_null($err)) {
            throw new \Exception($err);
        }
        // Logger::log('ret-----------------:' . print_r($ret, true));
        return $ret;
    }
}
