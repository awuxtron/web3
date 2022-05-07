<?php

namespace Awuxtron\Web3\Methods\Web3;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Bytes;
use Awuxtron\Web3\Utils\Hex;

/**
 * @description Returns Keccak-256 (not the standardized SHA3-256) of the given data.
 */
class Sha3 extends Method
{
    /**
     * Get the formatted method result.
     */
    public function value(): Hex
    {
        return (new Bytes(32))->encode($this->raw(), pad: false);
    }

    /**
     * Get the parameter schemas for this method.
     *
     * @return array<string, array{type: mixed, default: mixed, description: mixed}>
     */
    protected static function getParametersSchema(): array
    {
        return [
            'data' => static::schema('bytes', description: 'The data to convert into a SHA3 hash.'),
        ];
    }
}
