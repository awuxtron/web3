<?php

namespace Awuxtron\Web3\Methods\Shh;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Boolean;

/**
 * @description  Checks if the client hold the private keys for a given identity.
 */
class HasIdentity extends Method
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
    public static function getParametersSchema(): array
    {
        return [
            'identity' => static::schema('bytes60', description: 'The identity address to check.'),
        ];
    }
}
