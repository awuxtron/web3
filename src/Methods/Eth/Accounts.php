<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Utils\Hex;

class Accounts extends Method
{
    /**
     * Get the method result value.
     *
     * @return Hex[]
     */
    public function value(): array
    {
        return array_map(fn (string $address) => Hex::of($address), $this->raw());
    }
}
