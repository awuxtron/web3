<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Integer;
use Brick\Math\BigInteger;

/**
 * @description Creates a filter in the node, to notify when new pending transactions arrive.
 */
class NewPendingTransactionFilter extends Method
{
    /**
     * Get the formatted method result.
     */
    public function value(): BigInteger
    {
        return (new Integer)->decode($this->raw());
    }
}
