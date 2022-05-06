<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Bytes;

class SubmitWork extends Method
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
        static::requiredArgs($params, 3);

        return [
            (new Bytes(8))->encode($params[0])->prefixed(),
            (new Bytes(32))->encode($params[1])->prefixed(),
            (new Bytes(32))->encode($params[2])->prefixed(),
        ];
    }

    /**
     * Get the formatted method result.
     */
    public function value(): bool
    {
        return $this->raw();
    }
}
