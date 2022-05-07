<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Address;
use Awuxtron\Web3\Utils\Hex;

/**
 * Returns a list of addresses owned by client.
 */
class Accounts extends Method
{
    /**
     * Get the method result value.
     *
     * @return Hex[]
     */
    public function value(): array
    {
        return array_map(fn (string $address) => (new Address)->encode($address, pad: false), $this->raw());
    }
}
