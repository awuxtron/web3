<?php

namespace Awuxtron\Web3\Methods\Web3;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Utils\Hex;
use InvalidArgumentException;

class Sha3 extends Method
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
        if (!array_key_exists(0, $params) || !Hex::isValid($params[0], false, true)) {
            throw new InvalidArgumentException(sprintf('"%s" is not a valid hex string.', $params[0] ?? ''));
        }

        return [Hex::of($params[0])->prefixed()];
    }

    /**
     * Get the formatted method result.
     */
    public function value(): Hex
    {
        return Hex::of($this->raw());
    }
}
