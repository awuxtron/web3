<?php

namespace Awuxtron\Web3\Methods;

use Awuxtron\Web3\Methods\Eth\Accounts;
use Awuxtron\Web3\Methods\Eth\BlockNumber;
use Awuxtron\Web3\Methods\Eth\Call;
use Awuxtron\Web3\Methods\Eth\Coinbase;
use Awuxtron\Web3\Methods\Eth\EstimateGas;
use Awuxtron\Web3\Methods\Eth\GasPrice;
use Awuxtron\Web3\Methods\Eth\GetBalance;
use Awuxtron\Web3\Methods\Eth\GetBlockByHash;
use Awuxtron\Web3\Methods\Eth\GetBlockByNumber;
use Awuxtron\Web3\Methods\Eth\GetBlockTransactionCountByHash;
use Awuxtron\Web3\Methods\Eth\GetBlockTransactionCountByNumber;
use Awuxtron\Web3\Methods\Eth\GetCode;
use Awuxtron\Web3\Methods\Eth\GetStorageAt;
use Awuxtron\Web3\Methods\Eth\GetTransactionByBlockHashAndIndex;
use Awuxtron\Web3\Methods\Eth\GetTransactionByBlockNumberAndIndex;
use Awuxtron\Web3\Methods\Eth\GetTransactionByHash;
use Awuxtron\Web3\Methods\Eth\GetTransactionCount;
use Awuxtron\Web3\Methods\Eth\GetTransactionReceipt;
use Awuxtron\Web3\Methods\Eth\GetUncleCountByBlockHash;
use Awuxtron\Web3\Methods\Eth\GetUncleCountByBlockNumber;
use Awuxtron\Web3\Methods\Eth\Hashrate;
use Awuxtron\Web3\Methods\Eth\Mining;
use Awuxtron\Web3\Methods\Eth\ProtocolVersion;
use Awuxtron\Web3\Methods\Eth\SendRawTransaction;
use Awuxtron\Web3\Methods\Eth\SendTransaction;
use Awuxtron\Web3\Methods\Eth\Sign;
use Awuxtron\Web3\Methods\Eth\SignTransaction;
use Awuxtron\Web3\Methods\Eth\Syncing;
use Awuxtron\Web3\Types\Block;
use Awuxtron\Web3\Utils\Hex;

/**
 * @method ProtocolVersion                     protocolVersion()
 * @method Syncing                             syncing()
 * @method Coinbase                            coinbase()
 * @method Mining                              mining()
 * @method Hashrate                            hashrate()
 * @method GasPrice                            gasPrice()
 * @method Accounts                            accounts()
 * @method BlockNumber                         blockNumber()
 * @method GetBalance                          getBalance(Hex|string $address, mixed $block = Block::LATEST)
 * @method GetStorageAt                        getStorageAt(Hex|string $address, mixed $position, mixed $block = Block::LATEST)
 * @method GetTransactionCount                 getTransactionCount(Hex|string $address, mixed $block = Block::LATEST)
 * @method GetBlockTransactionCountByHash      getBlockTransactionCountByHash(Hex|string $hash)
 * @method GetBlockTransactionCountByNumber    getBlockTransactionCountByNumber(mixed $block = Block::LATEST)
 * @method GetUncleCountByBlockHash            getUncleCountByBlockHash(Hex|string $hash)
 * @method GetUncleCountByBlockNumber          getUncleCountByBlockNumber(mixed $block = Block::LATEST)
 * @method GetCode                             getCode(Hex|string $address, mixed $block = Block::LATEST)
 * @method Sign                                sign(Hex|string $address, Hex|string $message)
 * @method SignTransaction                     signTransaction(array $transaction)
 * @method SendTransaction                     sendTransaction(array $transaction)
 * @method SendRawTransaction                  sendRawTransaction(Hex|string $transaction)
 * @method Call                                call(array $transaction, mixed $block = Block::LATEST)
 * @method EstimateGas                         estimateGas(array $transaction, mixed $block = Block::LATEST)
 * @method GetBlockByHash                      getBlockByHash(Hex|string $tx, bool $isFull = false)
 * @method GetBlockByNumber                    getBlockByNumber(mixed $block = Block::LATEST, bool $isFull = false)
 * @method GetTransactionByHash                getTransactionByHash(Hex|string $tx)
 * @method GetTransactionByBlockHashAndIndex   getTransactionByBlockHashAndIndex(Hex|string $tx, mixed $index)
 * @method GetTransactionByBlockNumberAndIndex getTransactionByBlockNumberAndIndex(mixed $block, mixed $index)
 * @method GetTransactionReceipt               getTransactionReceipt(Hex|string $tx)
 */
class Eth extends MethodNamespace
{
}
