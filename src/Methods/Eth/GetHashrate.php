<?php

namespace Awuxtron\Web3\Methods\Eth;

/**
 * @description Returns the number of hashes per second that the node is mining with.
 */
class GetHashrate extends Hashrate
{
    /**
     * Get the JSON-RPC method name of this method.
     */
    public static function getName(): string
    {
        return 'eth_hashrate';
    }
}
