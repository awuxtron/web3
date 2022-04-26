<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Address;
use Awuxtron\Web3\Types\Block;
use Awuxtron\Web3\Utils\Hex;
use Brick\Math\BigInteger;
use InvalidArgumentException;

class GetTransactionCount extends Method
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
        if (empty($params)) {
            throw new InvalidArgumentException('Method GetTransactionCount required 1 parameters, 0 provided.');
        }

        (new Address)->validate($params[0]);

        return [Hex::of($params[0])->prefixed(), (new Block)->encode($params[1] ?? Block::LATEST)];
    }

    /**
     * Get the method result value.
     */
    public function value(): BigInteger
    {
        return Hex::of($this->raw())->toInteger();
    }
}
