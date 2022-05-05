<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Block;
use Awuxtron\Web3\Types\Integer;
use Awuxtron\Web3\Types\Transaction;
use Brick\Math\BigInteger;

class EstimateGas extends Method
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
        static::requiredArgs($params, 1);

        return [(new Transaction)->encode($params[0]), (new Block)->encode($params[1] ?? Block::LATEST)];
    }

    /**
     * Get the formatted method result.
     */
    public function value(): BigInteger
    {
        return (new Integer)->decode($this->raw());
    }
}
