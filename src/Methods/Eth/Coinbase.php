<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Address;
use Awuxtron\Web3\Utils\Hex;

/**
 * @description Returns the client coinbase address.
 */
class Coinbase extends Method
{
    /**
     * Get the formatted method result.
     */
    public function value(): Hex
    {
        return (new Address)->decode($this->raw());
    }
}
