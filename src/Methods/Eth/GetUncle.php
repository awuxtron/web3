<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\JsonRPC\Request;
use Awuxtron\Web3\Types\Block;
use Awuxtron\Web3\Types\Bytes;

/**
 * @description Returns a block's uncle by a given uncle index position.
 */
class GetUncle extends GetUncleByBlockHashAndIndex
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
            $method = 'eth_getUncleByBlockHashAndIndex';
        } else {
            $method = 'eth_getUncleByBlockNumberAndIndex';
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
            'block' => static::schema(['bytes32', 'block'], description: 'The block number or hash.'),
            'position' => static::schema('int', description: 'The uncle’s index position.'),
        ];
    }
}
