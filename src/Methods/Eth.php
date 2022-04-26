<?php

namespace Awuxtron\Web3\Methods;

use Awuxtron\Web3\Methods\Eth\Accounts;
use Awuxtron\Web3\Methods\Eth\BlockNumber;
use Awuxtron\Web3\Methods\Eth\Call;
use Awuxtron\Web3\Methods\Eth\Coinbase;
use Awuxtron\Web3\Methods\Eth\GasPrice;
use Awuxtron\Web3\Methods\Eth\GetBalance;
use Awuxtron\Web3\Methods\Eth\GetBlockTransactionCountByHash;
use Awuxtron\Web3\Methods\Eth\GetBlockTransactionCountByNumber;
use Awuxtron\Web3\Methods\Eth\GetStorageAt;
use Awuxtron\Web3\Methods\Eth\GetTransactionCount;
use Awuxtron\Web3\Methods\Eth\Hashrate;
use Awuxtron\Web3\Methods\Eth\Mining;
use Awuxtron\Web3\Methods\Eth\ProtocolVersion;
use Awuxtron\Web3\Methods\Eth\Syncing;
use Awuxtron\Web3\Types\Block;
use Awuxtron\Web3\Utils\Hex;

/**
 * @method ProtocolVersion                  protocolVersion()
 * @method Syncing                          syncing()
 * @method Coinbase                         coinbase()
 * @method Mining                           mining()
 * @method Hashrate                         hashrate()
 * @method GasPrice                         gasPrice()
 * @method Accounts                         accounts()
 * @method BlockNumber                      blockNumber()
 * @method GetBalance                       getBalance(Hex|string $address, mixed $block = Block::LATEST)
 * @method GetStorageAt                     getStorageAt(Hex|string $address, mixed $position, mixed $block = Block::LATEST)
 * @method GetTransactionCount              getTransactionCount(Hex|string $address, mixed $block = Block::LATEST)
 * @method GetBlockTransactionCountByHash   getBlockTransactionCountByHash(Hex|string $hash)
 * @method GetBlockTransactionCountByNumber getBlockTransactionCountByNumber(mixed $block = Block::LATEST)
 * @method Call                             call(array $transaction, mixed $block = Block::LATEST)
 */
class Eth extends MethodNamespace
{
}
