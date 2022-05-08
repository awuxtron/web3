<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Block;
use Awuxtron\Web3\Utils\Hex;

/**
 * @description Executes a new message call immediately without creating a transaction on the blockchain.
 */
class Call extends Method
{
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

    /**
     * Get the parameter schemas for this method.
     *
     * @return array<string, array{type: mixed, default: mixed, description: mixed}>
     */
    public static function getParametersSchema(): array
    {
        return [
            'transaction' => static::schema('transaction'),
            'block' => static::schema('block', Block::LATEST),
        ];
    }
}
