<?php

namespace Awuxtron\Web3\Methods\Shh;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Integer;
use Brick\Math\BigInteger;

/**
 * @description Creates filter to notify, when client receives whisper message matching the filter options.
 */
class NewFilter extends Method
{
    /**
     * Get the parameter schemas for this method.
     *
     * @return array<string, array{type: mixed, default: mixed, description: mixed}>
     */
    protected static function getParametersSchema(): array
    {
        return [
            'filter' => static::schema('object:to_bytes60?,topics_topics?', []),
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
