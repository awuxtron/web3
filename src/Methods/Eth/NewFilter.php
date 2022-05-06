<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Address;
use Awuxtron\Web3\Types\Block;
use Awuxtron\Web3\Types\Bytes;
use Awuxtron\Web3\Types\Integer;
use Brick\Math\BigInteger;
use InvalidArgumentException;

class NewFilter extends Method
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
        $addresses = [];
        $topics = [];

        if (!empty($params[2])) {
            if (!is_array($params[2])) {
                $params[2] = [$params[2]];
            }

            $addresses = array_values(array_map(fn ($a) => (new Address)->validated($a)->prefixed(), $params[2]));
        }

        if (!empty($params[3])) {
            if (!is_array($params[3])) {
                throw new InvalidArgumentException('Parameter #4 must be type of array.');
            }

            $topics = array_values(array_map(fn ($a) => (new Bytes(32))->validated($a)->prefixed(), $params[3]));
        }

        return [
            (new Block)->encode($params[0] ?? Block::LATEST),
            (new Block)->encode($params[1] ?? Block::LATEST),
            $addresses,
            $topics,
        ];
    }

    /**
     * Get the formatted method result.
     */
    public function value(): BigInteger
    {
        return (new Integer)->decode($this->raw());
    }
}
