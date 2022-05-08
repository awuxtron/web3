<?php

namespace Awuxtron\Web3\Methods\Shh;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Boolean;

/**
 * @description Uninstalls a filter with given ID. Should always be called when watch is no longer needed.
 */
class UninstallFilter extends Method
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
            'id' => static::schema('int'),
        ];
    }
}
