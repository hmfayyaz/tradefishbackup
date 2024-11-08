<?php

/**
 * Static.
 *
 * @since 0.1.0
 */
/**
 * TokenFactory
 */

namespace losnappas\Ethpress_NFT_Access\Token;

defined('ABSPATH') || die;

//use losnappas\Ethpress\Logger;
use losnappas\Ethpress_NFT_Access\BlockchainConnection;


class TokenFactory
{
    /**
     * createToken
     *
     * @param  string $contractAddress
     * @return IToken
     */
    public static function createToken($contractAddress): IToken
    {
        $web3 = new \Web3\Web3(BlockchainConnection::getInstance()->getHttpProvider());

        $tokenStandard = self::getTokenStandard($contractAddress, $web3->eth);
        if ($tokenStandard == '721') {
            return new ERC721();
        }
        if ($tokenStandard == '1155') {
            return new ERC1155();
        }
        return null;
    }

    /**
     * getContractCode
     *
     * @param  string $contractAddress
     * @param  \Web3\Eth $eth
     * @return $strCode
     */
    public static function getContractCode($contractAddress, $eth = null)
    {
        $strCode = null;
        $strError = null;
        $blockchainNetwork = BlockchainConnection::getInstance()->getBlockchainNetwork();
        // cross-plugin namespace to do it once and use in all plugins
        // @TODO: do the same in the Ethereum Wallet plugin
        $option_name = 'ethereumicoio-contract-code-' . $blockchainNetwork . '-' . $contractAddress;
        $strCode = get_option($option_name, '');

        if ('' === $strCode) {
            try {
                $eth->getCode($contractAddress, function ($err, $code) use (&$strCode, &$strError, $contractAddress) {
                    if ($err !== null) {
                        $strError = $err;
                        return;
                    }
                    $strCode = $code;
                });
            } catch (\Exception $ex) {
                if (is_null($strError)) {
                    $strError = $ex->getMessage();
                }
                return [$strError, null];
            }
        }
        if (get_option($option_name)) {
            update_option($option_name, $strCode);
        } else {
            $deprecated = '';
            $autoload = 'no';
            add_option($option_name, $strCode, $deprecated, $autoload);
        }
        return [$strError, $strCode];
    }

    /**
     * getTokenStandard
     *
     * @param  string $contractAddress
     * @param  \Web3\Eth $eth
     * @return string standard of token
     */
    public static function getTokenStandard($contractAddress, $eth = null)
    {
        // bytes4(keccak256('transferFrom(address,address,uint256)')) === 0x23b872dd
        // @see https://www.4byte.directory/signatures/?bytes4_signature=0x23b872dd		
        $metodNftSignature = '23b872dd';  //transferFrom(address,address,uint256) 
        list($error, $strTokenCode) = self::getContractCode($contractAddress, $eth);
        if (!is_null($error)) {
            return false;
        }
        $isNFT  = stripos($strTokenCode, $metodNftSignature);
        if ($isNFT === false) {
            return '1155';
        } else {
            return '721';
        }
    }
}
