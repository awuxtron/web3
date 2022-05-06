<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Bytes;
use Awuxtron\Web3\Types\Integer;

class GetUncleByBlockHashAndIndex extends Method
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
        static::requiredArgs($params, 2);

        return [
            (new Bytes(32))->validated($params[0])->prefixed(),
            (new Integer)->encode($params[1])->prefixed(),
        ];
    }
}
