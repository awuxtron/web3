<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Integer;
use Brick\Math\BigInteger;

/**
 * @description Returns the number of uncles in a block from a block matching the given block hash.
 */
class GetUncleCountByBlockHash extends Method
{
    /**
     * Get the formatted method result.
     */
    public function value(): BigInteger
    {
        return (new Integer)->decode($this->raw());
    }

    /**
     * Get the parameter schemas for this method.
     *
     * @return array<string, array{type: mixed, default: mixed, description: mixed}>
     */
    protected static function getParametersSchema(): array
    {
        return [
            'hash' => static::schema('bytes32', description: 'hash of a block.'),
        ];
    }
}
