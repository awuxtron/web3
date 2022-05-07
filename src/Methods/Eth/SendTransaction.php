<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Bytes;
use Awuxtron\Web3\Utils\Hex;

// TODO: Need review.

/**
 * @description Creates new message call transaction or a contract creation, if the data field contains code.
 */
class SendTransaction extends Method
{
    /**
     * Get the formatted method result.
     */
    public function value(): Hex
    {
        return (new Bytes(32))->decode($this->raw());
    }

    /**
     * Get the parameter schemas for this method.
     *
     * @return array<string, array{type: mixed, default: mixed, description: mixed}>
     */
    protected static function getParametersSchema(): array
    {
        return [
            'transaction' => static::schema('transaction'),
        ];
    }
}
