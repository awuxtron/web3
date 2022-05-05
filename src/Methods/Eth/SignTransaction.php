<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Bytes;
use Awuxtron\Web3\Types\Transaction;
use Awuxtron\Web3\Utils\Hex;

class SignTransaction extends Method
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

        return [(new Transaction)->encode($params[0])];
    }

    /**
     * Get the formatted method result.
     */
    public function value(): Hex
    {
        return (new Bytes)->decode($this->raw());
    }
}
