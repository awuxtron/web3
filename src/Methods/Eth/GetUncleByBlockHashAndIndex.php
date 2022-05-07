<?php

namespace Awuxtron\Web3\Methods\Eth;

/**
 * @description Returns information about an uncle of a block by hash and uncle index position.
 */
class GetUncleByBlockHashAndIndex extends GetBlockByHash
{
    /**
     * Get the parameter schemas for this method.
     *
     * @return array<string, array{type: mixed, default: mixed, description: mixed}>
     */
    protected static function getParametersSchema(): array
    {
        return [
            'hash' => static::schema('bytes32', description: 'The hash of a block.'),
            'position' => static::schema('int', description: 'The uncle’s index position.'),
        ];
    }
}
