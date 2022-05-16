<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;

/**
 * @description Uninstalls a filter with given ID. Should always be called when watch is no longer needed.
 */
class UninstallFilter extends Method
{
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

    /**
     * Get the formatted method result.
     */
    public function value(): bool
    {
        return $this->raw() !== false;
    }
}
