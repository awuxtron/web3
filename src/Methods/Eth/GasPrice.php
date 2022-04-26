<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Utils\Hex;
use Brick\Math\BigInteger;

class GasPrice extends Method
{
    /**
     * Get the method result value.
     */
    public function value(): BigInteger
    {
        return Hex::of($this->raw())->toInteger();
    }
}
