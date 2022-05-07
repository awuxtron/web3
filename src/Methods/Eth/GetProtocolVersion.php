<?php

namespace Awuxtron\Web3\Methods\Eth;

/**
 * @description Returns the current ethereum protocol version.
 */
class GetProtocolVersion extends ProtocolVersion
{
    /**
     * Get the JSON-RPC method name of this method.
     */
    public static function getName(): string
    {
        return 'eth_protocolVersion';
    }
}
