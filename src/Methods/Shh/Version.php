<?php

namespace Awuxtron\Web3\Methods\Shh;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Utils\Hex;
use Brick\Math\BigInteger;

class Version extends Method
{
    /**
     * Get the formatted method result.
     */
    public function value(): BigInteger
    {
        return Hex::of($this->raw())->toInteger();
    }
}
