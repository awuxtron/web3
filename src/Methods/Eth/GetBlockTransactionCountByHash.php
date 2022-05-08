<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Utils\Hex;
use Brick\Math\BigInteger;

/**
 * @description Returns the number of transactions in a block matching the given hash.
 */
class GetBlockTransactionCountByHash extends Method
{
    /**
     * Get the method result value.
     */
    public function value(): BigInteger
    {
        return Hex::of($this->raw())->toInteger();
    }

    /**
     * Get the parameter schemas for this method.
     *
     * @return array<string, array{type: mixed, default: mixed, description: mixed}>
     */
    public static function getParametersSchema(): array
    {
        return [
            'hash' => static::schema('bytes32', description: 'hash of a block.'),
        ];
    }
}
