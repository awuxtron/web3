<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Bytes;
use Awuxtron\Web3\Utils\Hex;

class SendRawTransaction extends Method
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

        return [(new Bytes)->validated($params[0])->prefixed()];
    }

    /**
     * Get the formatted method result.
     */
    public function value(): Hex
    {
        return (new Bytes(32))->decode($this->raw());
    }
}
