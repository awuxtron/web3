<?php

namespace Awuxtron\Web3\Methods\Eth;

/**
 * @description Returns the information about a transaction requested by transaction hash.
 */
class GetTransaction extends GetTransactionByHash
{
    /**
     * Get the JSON-RPC method name of this method.
     */
    public static function getName(): string
    {
        return 'eth_getTransactionByHash';
    }
}
