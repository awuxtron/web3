<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Block;
use Awuxtron\Web3\Types\Integer;

class GetTransactionByBlockNumberAndIndex extends Method
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
            (new Block)->encode($params[0]),
            (new Integer)->encode($params[1])->prefixed(),
        ];
    }
}
