<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Block;
use Awuxtron\Web3\Types\Boolean;

class GetBlockByNumber extends Method
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
        return [
            (new Block)->encode($params[0] ?? Block::LATEST),
            (new Boolean)->validated($params[1] ?? true),
        ];
    }
}
