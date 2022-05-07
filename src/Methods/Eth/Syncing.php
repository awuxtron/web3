<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Utils\Hex;
use Brick\Math\BigInteger;

/**
 * @description Returns an object with data about the sync status or false.
 */
class Syncing extends Method
{
    /**
     * Get the method result value.
     *
     * @return array<BigInteger>|bool
     */
    public function value(): array|bool
    {
        $result = $this->raw();

        if (is_bool($result)) {
            return $result;
        }

        return array_map(static fn ($block) => Hex::of($block)->toInteger(), $result);
    }
}
