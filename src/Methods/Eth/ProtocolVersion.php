<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Utils\Hex;

/**
 * @description Returns the current ethereum protocol version.
 */
class ProtocolVersion extends Method
{
    /**
     * Get the formatted method result.
     */
    public function value(): string
    {
        $value = $this->raw();

        if (Hex::isValid($value, true)) {
            return Hex::of($value)->toInteger();
        }

        return $value;
    }
}
