<?php

namespace Awuxtron\Web3\Methods\Eth;

/**
 * @description Returns information about an uncle of a block by number and uncle index position.
 */
class GetUncleByBlockNumberAndIndex extends GetUncleByBlockHashAndIndex
{
    /**
     * Get the parameter schemas for this method.
     *
     * @return array<string, array{type: mixed, default: mixed, description: mixed}>
     */
    protected static function getParametersSchema(): array
    {
        return [
            'block' => static::schema('block'),
            'position' => static::schema('int', description: 'The uncle’s index position.'),
        ];
    }
}
