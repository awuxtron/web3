<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Address;
use Awuxtron\Web3\Types\Bytes;
use Awuxtron\Web3\Utils\Hex;

class Sign extends Method
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
            (new Address)->validated($params[0])->prefixed(),
            (new Bytes)->validated($params[1])->prefixed(),
        ];
    }

    /**
     * Get the formatted method result.
     */
    public function value(): Hex
    {
        return (new Bytes)->decode($this->raw());
    }
}
