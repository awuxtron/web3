<?php

namespace Awuxtron\Web3\Methods\Net;

/**
 * @description Returns the current network ID.
 */
class Id extends Version
{
    /**
     * Get the JSON-RPC method name of this method.
     */
    public static function getName(): string
    {
        return 'net_version';
    }
}
