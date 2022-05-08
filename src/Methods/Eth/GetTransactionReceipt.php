<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Arr;
use Awuxtron\Web3\Types\Obj;
use InvalidArgumentException;

/**
 * @description Returns the receipt of a transaction by transaction hash.<br />Note That the receipt is not available for pending transactions.
 */
class GetTransactionReceipt extends Method
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
            throw new InvalidArgumentException('No receipt was found.');
        }

        return static::getTransactionReceiptObject()->decode($value);
    }

    public static function getTransactionReceiptObject(): Obj
    {
        $structure = [
            'status' => 'bool',
            'root' => 'bytes32?',
            'transactionHash' => 'bytes32',
            'transactionIndex' => 'int',
            'blockHash' => 'bytes32',
            'blockNumber' => 'int',
            'from' => 'address',
            'to' => 'address?',
            'cumulativeGasUsed' => 'int',
            'gasUsed' => 'int',
            'contractAddress' => 'address?',
            'logsBloom' => 'bytes256',
            'logs' => [new Arr(GetFilterChanges::getLogObject())],
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
