<?php

namespace Awuxtron\Web3\Methods\Eth;

/**
 * @description Returns the current price per gas in wei.
 */
class GetGasPrice extends GasPrice
{
    /**
     * Get the JSON-RPC method name of this method.
     */
    public static function getName(): string
    {
        return 'eth_gasPrice';
    }
}
