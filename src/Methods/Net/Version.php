<?php

namespace Awuxtron\Web3\Methods\Net;

use Awuxtron\Web3\Methods\Method;

/**
 * @description Returns the current network ID.
 */
class Version extends Method
{
    /**
     * Get the formatted method result.
     */
    public function value(): string
    {
        return $this->raw();
    }
}
