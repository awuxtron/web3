<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\JsonRPC\Request;
use Awuxtron\Web3\Types\Block;
use Awuxtron\Web3\Types\Bytes;

/**
 * @description Returns information about a transaction by block hash and transaction index position.
 */
class GetTransactionFromBlock extends GetTransactionByBlockHashAndIndex
{
    /**
     * Modify the request instance before send.
     *
     * @param Request $request
     *
     * @return Request
     */
    public static function modifyRequest(Request $request): Request
    {
        $block = $request->getParams()[0];

        if ((new Bytes(32))->validate($block, false)) {
            $method = 'eth_getTransactionByBlockHashAndIndex';
        } else {
            $method = 'eth_getTransactionByBlockNumberAndIndex';
        }

        return $request->setMethod($method);
    }

    /**
     * Get the parameter schemas for this method.
     *
     * @return array<string, array{type: mixed, default: mixed, description: mixed}>
     */
    public static function getParametersSchema(): array
    {
        return [
            'block' => static::schema(['bytes32', 'block'], description: 'the block number or hash.'),
            'position' => static::schema('int', description: 'integer of the transaction index position.'),
        ];
    }
}
