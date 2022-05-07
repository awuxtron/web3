<?php

namespace Awuxtron\Web3\Methods\Net;

/**
 * @description Returns true if client is actively listening for network connections.
 */
class IsListening extends Listening
{
    /**
     * Get the JSON-RPC method name of this method.
     */
    public static function getName(): string
    {
        return 'net_listening';
    }
}
