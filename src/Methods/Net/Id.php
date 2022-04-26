<?php

namespace Awuxtron\Web3\Methods\Net;

use Awuxtron\Web3\Methods\Method;

class Id extends Method
{
    /**
     * Get the JSON-RPC method name of this method.
     */
    public static function getName(): string
    {
        return 'net_version';
    }
}
