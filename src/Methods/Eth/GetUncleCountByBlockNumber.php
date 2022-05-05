<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Block;
use Awuxtron\Web3\Types\Integer;
use Brick\Math\BigInteger;

class GetUncleCountByBlockNumber extends Method
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
     * Get the formatted method result.
     */
    public function value(): BigInteger
    {
        return (new Integer)->decode($this->raw());
    }
}
