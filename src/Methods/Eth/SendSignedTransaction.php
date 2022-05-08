<?php

namespace Awuxtron\Web3\Methods\Eth;

/**
 * @description Creates new message call transaction or a contract creation for signed transactions.
 */
class SendSignedTransaction extends SendRawTransaction
{
    /**
     * Get the JSON-RPC method name of this method.
     */
    public static function getName(): string
    {
        return 'eth_sendRawTransaction';
    }
}
