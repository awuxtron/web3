<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\JsonRPC\Request;
use Awuxtron\Web3\Types\Block;
use Awuxtron\Web3\Types\Bytes;

/**
 * @description Returns a block matching the block number or block hash.
 */
class GetBlock extends GetBlockByHash
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
            $method = 'eth_getBlockByHash';
        } else {
            $method = 'eth_getBlockByNumber';
        }

        return $request->setMethod($method);
    }

    /**
     * Get the parameter schemas for this method.
     *
     * @return array<string, array{type: mixed, default: mixed, description: mixed}>
     */
    protected static function getParametersSchema(): array
    {
        return [
            'block' => static::schema(['bytes32', 'block'], Block::LATEST, 'The block number or block hash.'),
            'full' => static::schema('bool', true, 'If true it returns the full transaction objects, if false only the hashes of the transactions.'),
        ];
    }
}
