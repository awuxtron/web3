<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Block;
use Awuxtron\Web3\Types\Integer;
use Brick\Math\BigInteger;

/**
 * @description Executes a message call or transaction and returns the amount of the gas used.<br />Note: You must specify a from address otherwise you may experience odd behavior.
 */
class EstimateGas extends Method
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
            'transaction' => static::schema('transaction'),
            'block' => static::schema('block', Block::LATEST),
        ];
    }
}
