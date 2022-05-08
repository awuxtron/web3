<?php

namespace Awuxtron\Web3\Methods\Eth;

/**
 * @description Returns the number of most recent block.
 */
class GetBlockNumber extends BlockNumber
{
    /**
     * Get the JSON-RPC method name of this method.
     */
    public static function getName(): string
    {
        return 'eth_blockNumber';
    }
}
