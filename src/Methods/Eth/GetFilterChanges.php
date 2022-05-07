<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Bytes;
use Awuxtron\Web3\Types\Obj;

/**
 * @description Polling method for a filter, which returns an array of logs which occurred since last poll.
 */
class GetFilterChanges extends Method
{
    /**
     * Get the formatted method result.
     *
     * @return array<mixed>
     */
    public function value(): array
    {
        $result = [];

        foreach ($this->raw() as $i => $item) {
            if (is_string($item)) {
                $result[$i] = (new Bytes(32))->validated($item);

                continue;
            }

            $result[$i] = static::getLogObject()->decode($item);
        }

        return $result;
    }

    public static function getLogObject(): Obj
    {
        return new Obj([
            'removed' => 'bool',
            'logIndex' => 'int?',
            'transactionIndex' => 'int?',
            'transactionHash' => 'bytes32?',
            'blockHash' => 'bytes32?',
            'blockNumber' => 'int?',
            'address' => 'address',
            'data' => 'bytes',
            'topics' => 'topics',
        ]);
    }

    /**
     * Get the parameter schemas for this method.
     *
     * @return array<string, array{type: mixed, default: mixed, description: mixed}>
     */
    protected static function getParametersSchema(): array
    {
        return [
            'id' => static::schema('int'),
        ];
    }
}
