<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Address;
use Awuxtron\Web3\Types\Block;
use Awuxtron\Web3\Types\Bytes;
use Awuxtron\Web3\Utils\Hex;

class GetCode extends Method
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
            (new Address)->validated($params[0])->prefixed(),
            (new Block)->encode($params[1] ?? Block::LATEST),
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
