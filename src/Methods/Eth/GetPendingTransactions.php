<?php

namespace Awuxtron\Web3\Methods\Eth;

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
