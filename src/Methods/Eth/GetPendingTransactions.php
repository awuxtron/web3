<?php

namespace Awuxtron\Web3\Methods\Eth;

/**
 * @description Returns a list of pending transactions.
 */
class GetPendingTransactions extends PendingTransactions
{
    /**
     * Get the JSON-RPC method name of this method.
     */
    public static function getName(): string
    {
        return 'eth_pendingTransactions';
    }
}
