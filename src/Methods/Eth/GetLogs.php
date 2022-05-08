<?php

namespace Awuxtron\Web3\Methods\Eth;

/**
 * @description Returns an array of all logs matching a given filter object.
 */
class GetLogs extends GetFilterChanges
{
    /**
     * Get the parameter schemas for this method.
     *
     * @return array<string, array{type: mixed, default: mixed, description: mixed}>
     */
    public static function getParametersSchema(): array
    {
        return [
            'filter' => static::schema('filter', []),
        ];
    }
}
