<?php

namespace Awuxtron\Web3\Methods\Shh;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Obj;

/**
 * @description Polling method for whisper filters. Returns new messages since the last call of this method.
 */
class GetFilterChanges extends Method
{
    /**
     * Get the formatted method result.
     *
     * @return array<string, mixed>
     */
    public function value(): array
    {
        $structure = [
            'hash' => 'bytes32?',
            'from' => 'bytes60',
            'to' => 'bytes60',
            'expiry' => 'int?',
            'ttl' => 'int?',
            'sent' => 'int?',
            'topics' => 'topics',
            'payload' => 'bytes',
            'workProved' => 'int?',
        ];

        return (new Obj($structure))->decode($this->raw());
    }

    /**
     * Get the parameter schemas for this method.
     *
     * @return array<string, array{type: mixed, default: mixed, description: mixed}>
     */
    public static function getParametersSchema(): array
    {
        return [
            'id' => static::schema('int'),
        ];
    }
}
