<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Obj;
use InvalidArgumentException;

/**
 * @description Returns the information about a transaction requested by transaction hash.
 */
class GetTransactionByHash extends Method
{
    /**
     * Get the method result value.
     *
     * @return array<string, mixed>
     */
    public function value(): array
    {
        $value = $this->raw();

        if (empty($value)) {
            throw new InvalidArgumentException('No transaction was found.');
        }

        return static::getTransactionObject()->decode($value);
    }

    public static function getTransactionObject(): Obj
    {
        $structure = [
            'blockHash' => 'bytes32?',
            'blockNumber' => 'int?',
            'from' => 'address',
            'gas' => 'int',
            'gasPrice' => 'int',
            'hash' => 'bytes32',
            'input' => 'bytes',
            'nonce' => 'int',
            'to' => 'address?',
            'transactionIndex' => 'int?',
            'value' => 'int',
            'v' => 'int',
            'r' => 'bytes32',
            's' => 'bytes32',
        ];

        return new Obj($structure);
    }

    /**
     * Get the parameter schemas for this method.
     *
     * @return array<string, array{type: mixed, default: mixed, description: mixed}>
     */
    public static function getParametersSchema(): array
    {
        return [
            'hash' => static::schema('bytes32', description: 'hash of a transaction.'),
        ];
    }
}
