<?php

namespace Awuxtron\Web3\Methods\Eth;

/**
 * @description Returns the chain ID of the current connected node as described in the EIP-695.
 */
class GetChainId extends ChainId
{
    /**
     * Get the JSON-RPC method name of this method.
     */
    public static function getName(): string
    {
        return 'eth_chainId';
    }
}
