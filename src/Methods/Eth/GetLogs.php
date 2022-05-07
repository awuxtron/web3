<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Filter;

class GetLogs extends Method
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
        $params[0] ??= [];

        if (!empty($params[0]) && !is_array($params[0])) {
            $params[0] = array_filter([
                'fromBlock' => $params[0],
                'toBlock' => $params[1] ?? null,
                'address' => $params[2] ?? null,
                'topics' => $params[3] ?? null,
                'blockhash' => $params[4] ?? null,
            ]);
        }

        return [(new Filter)->encode($params[0])];
    }
}
