<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Types\Arr;
use Awuxtron\Web3\Types\Obj;
use InvalidArgumentException;

/**
 * @description Returns information about a block by hash.
 */
class GetBlockByHash extends Method
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
            throw new InvalidArgumentException('No block was found.');
        }

        $structure = [
            'number' => 'int?',
            'hash' => 'bytes32?',
            'mixHash' => 'bytes32?',
            'parentHash' => 'bytes32',
            'nonce' => 'bytes8?',
            'sha3Uncles' => 'bytes32',
            'logsBloom' => 'bytes256?',
            'transactionsRoot' => 'bytes32',
            'stateRoot' => 'bytes32',
            'receiptsRoot' => 'bytes32',
            'miner' => 'address',
            'difficulty' => 'int',
            'totalDifficulty' => 'int?',
            'extraData' => 'bytes',
            'size' => 'int',
            'gasLimit' => 'int',
            'gasUsed' => 'int',
            'timestamp' => 'int',
            'transactions' => ['bytes32[]?', []],
        ];

        if (!empty($value['transactions']) && !is_string($value['transactions'][0])) {
            $structure['transactions'] = [new Arr(GetTransactionByHash::getTransactionObject())];
        }

        // TODO: uncles.

        return (new Obj($structure))->decode($value);
    }

    /**
     * Get the parameter schemas for this method.
     *
     * @return array<string, array{type: mixed, default: mixed, description: mixed}>
     */
    public static function getParametersSchema(): array
    {
        return [
            'hash' => static::schema('bytes32'),
            'full' => static::schema('bool', true, 'If true it returns the full transaction objects, if false only the hashes of the transactions.'),
        ];
    }
}
