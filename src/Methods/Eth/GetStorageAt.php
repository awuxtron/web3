<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Block;
use Awuxtron\Web3\Utils\Hex;

/**
 * @description Returns the value from a storage position at a given address.
 */
class GetStorageAt extends Method
{
    /**
     * Get the method result value.
     */
    public function value(): Hex
    {
        return Hex::of($this->raw());
    }

    /**
     * Get the parameter schemas for this method.
     *
     * @return array<string, array{type: mixed, default: mixed, description: mixed}>
     */
    protected static function getParametersSchema(): array
    {
        return [
            'address' => static::schema('address', description: 'address of the storage.'),
            'position' => static::schema('int', description: 'integer of the position in the storage.'),
            'block' => static::schema('block', Block::LATEST),
        ];
    }
}
