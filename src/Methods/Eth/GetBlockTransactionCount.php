<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\JsonRPC\Request;
use Awuxtron\Web3\Types\Block;
use Awuxtron\Web3\Types\Bytes;

/**
 * @description Returns the number of transaction in a given block.
 */
class GetBlockTransactionCount extends GetBlockTransactionCountByHash
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
            $method = 'eth_getBlockTransactionCountByHash';
        } else {
            $method = 'eth_getBlockTransactionCountByNumber';
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
            'block' => static::schema(['bytes32', 'block'], Block::LATEST, 'The block number or block hash.'),
        ];
    }
}
