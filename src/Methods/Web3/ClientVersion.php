<?php

namespace Awuxtron\Web3\Methods\Web3;

use Awuxtron\Web3\Methods\Method;

/**
 * @description Returns the current client version.
 */
class ClientVersion extends Method
{
    /**
     * Get the formatted method result.
     */
    public function value(): string
    {
        return $this->raw();
    }
}
