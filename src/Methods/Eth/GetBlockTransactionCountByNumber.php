<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Block;
use Awuxtron\Web3\Utils\Hex;
use Brick\Math\BigInteger;

class GetBlockTransactionCountByNumber extends Method
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
        return [(new Block)->encode($params[0] ?? Block::LATEST)];
    }

    /**
     * Get the method result value.
     */
    public function value(): BigInteger
    {
        return Hex::of($this->raw())->toInteger();
    }
}
