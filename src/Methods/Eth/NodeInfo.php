<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Web3\ClientVersion;

/**
 * @description The current client version.
 */
class NodeInfo extends ClientVersion
{
    /**
     * Get the JSON-RPC method name of this method.
     */
    public static function getName(): string
    {
        return 'web3_clientVersion';
    }
}
