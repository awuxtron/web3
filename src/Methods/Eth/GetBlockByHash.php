<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Boolean;
use Awuxtron\Web3\Types\Bytes;

class GetBlockByHash extends Method
{
    /**
     * Returns validated parameters.
     *
     * @param array<mixed> $params
     *
     * @return array<mixed>
     */
    public static function getParameters(array $params): array
    {
        static::requiredArgs($params, 1);

        return [
            (new Bytes(32))->validated($params[0])->prefixed(),
            (new Boolean)->validated($params[1] ?? true),
        ];
    }
}
