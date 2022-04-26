<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Address;
use Awuxtron\Web3\Types\Block;
use Awuxtron\Web3\Types\Integer;
use Awuxtron\Web3\Utils\Hex;
use InvalidArgumentException;

class GetStorageAt extends Method
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
        if (count($params) < 2) {
            throw new InvalidArgumentException(sprintf('Method GetStorageAt required 2 parameters, %d provided.', count($params)));
        }

        (new Address)->validate($params[0]);

        return [
            Hex::of($params[0])->prefixed(),
            (new Integer)->encode($params[1]),
            (new Block)->encode($params[2] ?? Block::LATEST),
        ];
    }

    /**
     * Get the method result value.
     */
    public function value(): Hex
    {
        return Hex::of($this->raw());
    }
}
