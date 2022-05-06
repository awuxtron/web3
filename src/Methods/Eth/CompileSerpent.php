<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use InvalidArgumentException;

class CompileSerpent extends Method
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

        if (!is_string($params[0])) {
            throw new InvalidArgumentException('Parameter #1  is not a valid string.');
        }

        return [$params[0]];
    }
}
