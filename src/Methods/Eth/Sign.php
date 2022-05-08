<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Bytes;
use Awuxtron\Web3\Utils\Hex;

/**
 * @description Signs data using a specific account. This account needs to be unlocked.
 */
class Sign extends Method
{
    /**
     * Get the formatted method result.
     */
    public function value(): Hex
    {
        return (new Bytes)->decode($this->raw());
    }

    /**
     * Get the parameter schemas for this method.
     *
     * @return array<string, array{type: mixed, default: mixed, description: mixed}>
     */
    public static function getParametersSchema(): array
    {
        return [
            'address' => static::schema('address'),
            'message' => static::schema('bytes'),
        ];
    }
}
