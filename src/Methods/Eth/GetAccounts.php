<?php

namespace Awuxtron\Web3\Methods\Eth;

/**
 * @description Returns a list of addresses owned by client.
 */
class GetAccounts extends Accounts
{
    /**
     * Get the JSON-RPC method name of this method.
     */
    public static function getName(): string
    {
        return 'eth_accounts';
    }
}
