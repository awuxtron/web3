<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Utils\Hex;

/**
 * @description Returns compiled solidity code.
 */
class CompileSolidity extends Method
{
    /**
     * Get the formatted method result.
     */
    public function value(): Hex
    {
        return Hex::of($this->raw());
    }

    /**
     * Get the parameter schemas for this method.
     *
     * @return array<string, array{type: mixed, default: mixed, description: mixed}>
     */
    protected static function getParametersSchema(): array
    {
        return [
            'sourcecode' => static::schema('string'),
        ];
    }
}
