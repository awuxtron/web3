<?php

namespace Awuxtron\Web3\Methods\Eth;

/**
 * @description Returns information about a transaction by block hash and transaction index position.
 */
class GetTransactionByBlockHashAndIndex extends GetTransactionByHash
{
    /**
     * Get the parameter schemas for this method.
     *
     * @return array<string, array{type: mixed, default: mixed, description: mixed}>
     */
    protected static function getParametersSchema(): array
    {
        return [
            'hash' => static::schema('bytes32', description: 'hash of a block.'),
            'position' => static::schema('int', description: 'integer of the transaction index position.'),
        ];
    }
}
