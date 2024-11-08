<?php

namespace losnappas\Ethpress_NFT_Access\Token;

defined('ABSPATH') || die;


interface IToken
{
    /**
     * isOwner
     *
     * @param  string $contractAddress - smart contract address
     * @param  string $tokenID The identifier for an token
     * @param  string  $userWallet
     * @return bool true - if the user is the owner of the token 
     */
    public function isOwner($contractAddress, $tokenID, $userWallet);
}
