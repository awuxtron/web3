<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Boolean;

/**
 * @description Used for submitting mining hashrate.
 */
class SubmitHashrate extends Method
{
    /**
     * Get the formatted method result.
     */
    public function value(): bool
    {
        if (($val = $this->raw()) === null) {
            return false;
        }

        return (new Boolean)->decode($val);
    }

    /**
     * Get the parameter schemas for this method.
     *
     * @return array<string, array{type: mixed, default: mixed, description: mixed}>
     */
    protected static function getParametersSchema(): array
    {
        return [
            'hashrate' => static::schema('bytes', description: 'a hexadecimal string representation (32 bytes) of the hash rate.'),
            'id' => static::schema('bytes32', description: 'a random hexadecimal(32 bytes) ID identifying the client.'),
        ];
    }
}
