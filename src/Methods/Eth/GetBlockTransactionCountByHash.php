<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Utils\Hex;
use Brick\Math\BigInteger;
use InvalidArgumentException;

class GetBlockTransactionCountByHash extends Method
{
    /**
     * Returns validated parameters.
     *
     * @param array<mixed> $params
     *
     * @return array<mixed>
     */
    public static function getParameters(array $params): array
    {
        if (empty($params)) {
            throw new InvalidArgumentException('Method GetBlockTransactionCountByHash required 1 parameters, 0 provided.');
        }

        $hex = Hex::of($params[0]);

        if ($hex->length() != 32) {
            throw new InvalidArgumentException('Invalid hash.');
        }

        return [$hex->prefixed()];
    }

    /**
     * Get the method result value.
     */
    public function value(): BigInteger
    {
        return Hex::of($this->raw())->toInteger();
    }
}
