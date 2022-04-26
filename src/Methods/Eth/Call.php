<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Block;
use Awuxtron\Web3\Types\Transaction;
use Awuxtron\Web3\Utils\Hex;
use InvalidArgumentException;

class Call extends Method
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
            throw new InvalidArgumentException('Parameter #1 of method "eth_call" is required.');
        }

        return [(new Transaction)->encode($params[0]), (new Block)->encode($params[1] ?? Block::LATEST)];
    }

    /**
     * Get the formatted method result.
     */
    public function value(): ?Hex
    {
        $result = $this->raw();

        if ($result != null) {
            return Hex::of($result);
        }

        return null;
    }
}
