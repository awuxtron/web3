<?php

namespace Awuxtron\Web3\Methods\Net;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Utils\Hex;
use Brick\Math\BigInteger;

/**
 * @description Returns number of peers currently connected to the client.
 */
class PeerCount extends Method
{
    /**
     * Get the formatted method result.
     */
    public function value(): BigInteger
    {
        return Hex::of($this->raw())->toInteger();
    }
}
