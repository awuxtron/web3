<?php

namespace Awuxtron\Web3\Methods\Eth;

/**
 * @description Returns a list of pending transactions.
 */
class PendingTransactions extends GetTransactionByHash
{
    /**
     * Get the parameter schemas for this method.
     *
     * @return array<string, array{type: mixed, default: mixed, description: mixed}>
     */
    protected static function getParametersSchema(): array
    {
        return [];
    }
}
