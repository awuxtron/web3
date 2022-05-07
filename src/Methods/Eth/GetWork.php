<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Arr;
use Awuxtron\Web3\Types\Bytes;
use Awuxtron\Web3\Utils\Hex;

/**
 * @description Returns the hash of the current block, the seedHash, and the boundary condition to be met (“target”).
 */
class GetWork extends Method
{
    /**
     * Get the formatted method result.
     *
     * @return Hex[]
     */
    public function value(): array
    {
        return (new Arr(new Bytes(32), 3))->decode($this->raw());
    }
}
