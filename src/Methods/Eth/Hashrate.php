<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Utils\Hex;
use Brick\Math\BigInteger;

/**
 * @description Returns the number of hashes per second that the node is mining with.
 */
class Hashrate extends Method
{
    /**
     * Get the method result value.
     */
    public function value(): BigInteger
    {
        return Hex::of($this->raw())->toInteger();
    }
}
