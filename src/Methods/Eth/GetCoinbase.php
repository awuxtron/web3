<?php

namespace Awuxtron\Web3\Methods\Eth;

/**
 * @description Returns the client coinbase address.
 */
class GetCoinbase extends Coinbase
{
    /**
     * Get the JSON-RPC method name of this method.
     */
    public static function getName(): string
    {
        return 'eth_coinbase';
    }
}
