<?php

namespace Awuxtron\Web3\Methods\Shh;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Bytes;
use Awuxtron\Web3\Utils\Hex;

class NewGroup extends Method
{
    /**
     * Get the formatted method result.
     */
    public function value(): Hex
    {
        return (new Bytes(60))->decode($this->raw());
    }
}
