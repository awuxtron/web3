<?php

namespace Awuxtron\Web3\Methods\Eth;

/**
 * @description Returns information about a transaction by block number and transaction index position.
 */
class GetTransactionByBlockNumberAndIndex extends GetTransactionByHash
{
    /**
     * Get the parameter schemas for this method.
     *
     * @return array<string, array{type: mixed, default: mixed, description: mixed}>
     */
    public static function getParametersSchema(): array
    {
        return [
            'block' => static::schema('block'),
            'position' => static::schema('int', description: 'integer of the transaction index position.'),
        ];
    }
}
