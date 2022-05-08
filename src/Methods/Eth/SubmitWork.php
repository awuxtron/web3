<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Boolean;

/**
 * @description Used for submitting a proof-of-work solution.
 */
class SubmitWork extends Method
{
    /**
     * Get the formatted method result.
     */
    public function value(): bool
    {
        return (new Boolean)->decode($this->raw());
    }

    /**
     * Get the parameter schemas for this method.
     *
     * @return array<string, array{type: mixed, default: mixed, description: mixed}>
     */
    public static function getParametersSchema(): array
    {
        return [
            'nonce' => static::schema('bytes8', description: 'The nonce found (64 bits).'),
            'header' => static::schema('bytes32', description: 'The header’s pow-hash (256 bits).'),
            'digest' => static::schema('bytes32', description: 'The mix digest (256 bits).'),
        ];
    }
}
