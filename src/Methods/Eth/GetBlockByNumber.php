<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Types\Block;

/**
 * @description Returns information about a block by block number.
 */
class GetBlockByNumber extends GetBlockByHash
{
    /**
     * Get the parameter schemas for this method.
     *
     * @return array<string, array{type: mixed, default: mixed, description: mixed}>
     */
    public static function getParametersSchema(): array
    {
        return [
            'block' => static::schema('block', Block::LATEST),
            'full' => static::schema('bool', true, 'If true it returns the full transaction objects, if false only the hashes of the transactions.'),
        ];
    }
}
