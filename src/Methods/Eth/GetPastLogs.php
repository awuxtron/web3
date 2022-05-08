<?php

namespace Awuxtron\Web3\Methods\Eth;

/**
 * @description Returns an array of all logs matching a given filter object.
 */
class GetPastLogs extends GetLogs
{
    /**
     * Get the JSON-RPC method name of this method.
     */
    public static function getName(): string
    {
        return 'eth_getLogs';
    }
}
