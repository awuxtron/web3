<?php

namespace Awuxtron\Web3\Methods\Net;

use Awuxtron\Web3\Methods\Method;

/**
 * @description Returns true if client is actively listening for network connections.
 */
class Listening extends Method
{
    /**
     * Get the formatted method result.
     */
    public function value(): bool
    {
        return $this->raw();
    }
}
