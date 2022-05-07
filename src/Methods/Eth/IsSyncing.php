<?php

namespace Awuxtron\Web3\Methods\Eth;

/**
 * @description Returns an object with data about the sync status or false.
 */
class IsSyncing extends Syncing
{
    /**
     * Get the JSON-RPC method name of this method.
     */
    public static function getName(): string
    {
        return 'eth_syncing';
    }

    /**
     * Get the method result value.
     *
     * @return bool
     */
    public function value(): bool
    {
        return !empty(parent::value());
    }
}
