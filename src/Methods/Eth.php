<?php

namespace Awuxtron\Web3\Methods;

use Awuxtron\Web3\Methods\Eth\Accounts;
use Awuxtron\Web3\Methods\Eth\BlockNumber;
use Awuxtron\Web3\Methods\Eth\Call;
use Awuxtron\Web3\Methods\Eth\ChainId;
use Awuxtron\Web3\Methods\Eth\Coinbase;
use Awuxtron\Web3\Methods\Eth\CompileLLL;
use Awuxtron\Web3\Methods\Eth\CompileSerpent;
use Awuxtron\Web3\Methods\Eth\CompileSolidity;
use Awuxtron\Web3\Methods\Eth\EstimateGas;
use Awuxtron\Web3\Methods\Eth\FeeHistory;
use Awuxtron\Web3\Methods\Eth\GasPrice;
use Awuxtron\Web3\Methods\Eth\GetAccounts;
use Awuxtron\Web3\Methods\Eth\GetBalance;
use Awuxtron\Web3\Methods\Eth\GetBlock;
use Awuxtron\Web3\Methods\Eth\GetBlockByHash;
use Awuxtron\Web3\Methods\Eth\GetBlockByNumber;
use Awuxtron\Web3\Methods\Eth\GetBlockNumber;
use Awuxtron\Web3\Methods\Eth\GetBlockTransactionCount;
use Awuxtron\Web3\Methods\Eth\GetBlockTransactionCountByHash;
use Awuxtron\Web3\Methods\Eth\GetBlockTransactionCountByNumber;
use Awuxtron\Web3\Methods\Eth\GetBlockUncleCount;
use Awuxtron\Web3\Methods\Eth\GetChainId;
use Awuxtron\Web3\Methods\Eth\GetCode;
use Awuxtron\Web3\Methods\Eth\GetCoinbase;
use Awuxtron\Web3\Methods\Eth\GetCompilers;
use Awuxtron\Web3\Methods\Eth\GetFeeHistory;
use Awuxtron\Web3\Methods\Eth\GetFilterChanges;
use Awuxtron\Web3\Methods\Eth\GetFilterLogs;
use Awuxtron\Web3\Methods\Eth\GetGasPrice;
use Awuxtron\Web3\Methods\Eth\GetHashrate;
use Awuxtron\Web3\Methods\Eth\GetLogs;
use Awuxtron\Web3\Methods\Eth\GetNodeInfo;
use Awuxtron\Web3\Methods\Eth\GetPastLogs;
use Awuxtron\Web3\Methods\Eth\GetPendingTransactions;
use Awuxtron\Web3\Methods\Eth\GetProtocolVersion;
use Awuxtron\Web3\Methods\Eth\GetStorageAt;
use Awuxtron\Web3\Methods\Eth\GetTransaction;
use Awuxtron\Web3\Methods\Eth\GetTransactionByBlockHashAndIndex;
use Awuxtron\Web3\Methods\Eth\GetTransactionByBlockNumberAndIndex;
use Awuxtron\Web3\Methods\Eth\GetTransactionByHash;
use Awuxtron\Web3\Methods\Eth\GetTransactionCount;
use Awuxtron\Web3\Methods\Eth\GetTransactionFromBlock;
use Awuxtron\Web3\Methods\Eth\GetTransactionReceipt;
use Awuxtron\Web3\Methods\Eth\GetUncle;
use Awuxtron\Web3\Methods\Eth\GetUncleByBlockHashAndIndex;
use Awuxtron\Web3\Methods\Eth\GetUncleByBlockNumberAndIndex;
use Awuxtron\Web3\Methods\Eth\GetUncleCount;
use Awuxtron\Web3\Methods\Eth\GetUncleCountByBlockHash;
use Awuxtron\Web3\Methods\Eth\GetUncleCountByBlockNumber;
use Awuxtron\Web3\Methods\Eth\GetWork;
use Awuxtron\Web3\Methods\Eth\Hashrate;
use Awuxtron\Web3\Methods\Eth\IsMining;
use Awuxtron\Web3\Methods\Eth\IsSyncing;
use Awuxtron\Web3\Methods\Eth\Mining;
use Awuxtron\Web3\Methods\Eth\NewBlockFilter;
use Awuxtron\Web3\Methods\Eth\NewFilter;
use Awuxtron\Web3\Methods\Eth\NewPendingTransactionFilter;
use Awuxtron\Web3\Methods\Eth\NodeInfo;
use Awuxtron\Web3\Methods\Eth\PendingTransactions;
use Awuxtron\Web3\Methods\Eth\ProtocolVersion;
use Awuxtron\Web3\Methods\Eth\SendRawTransaction;
use Awuxtron\Web3\Methods\Eth\SendSignedTransaction;
use Awuxtron\Web3\Methods\Eth\SendTransaction;
use Awuxtron\Web3\Methods\Eth\Sign;
use Awuxtron\Web3\Methods\Eth\SignTransaction;
use Awuxtron\Web3\Methods\Eth\SubmitHashrate;
use Awuxtron\Web3\Methods\Eth\SubmitWork;
use Awuxtron\Web3\Methods\Eth\Syncing;
use Awuxtron\Web3\Methods\Eth\UninstallFilter;
use Awuxtron\Web3\Utils\Hex;
use Brick\Math\BigInteger;

/**
 * @property Hex[]                  $accounts                         Returns a list of addresses owned by client.
 * @property BigInteger             $blockNumber                      Returns the number of most recent block.
 * @property BigInteger             $chainId                          Returns the chain ID of the current connected node as described in the EIP-695.
 * @property Hex                    $coinbase                         Returns the client coinbase address.
 * @property BigInteger             $gasPrice                         Returns the current price per gas in wei.
 * @property Hex[]                  $getAccounts                      Returns a list of addresses owned by client.
 * @property array<string, mixed>   $getBlock                         Returns a block matching the block number or block hash.
 * @property array<string, mixed>   $block                            Returns a block matching the block number or block hash.
 * @property array<string, mixed>   $getBlockByNumber                 Returns information about a block by block number.
 * @property array<string, mixed>   $blockByNumber                    Returns information about a block by block number.
 * @property BigInteger             $getBlockNumber                   Returns the number of most recent block.
 * @property BigInteger             $getBlockTransactionCount         Returns the number of transaction in a given block.
 * @property BigInteger             $blockTransactionCount            Returns the number of transaction in a given block.
 * @property BigInteger             $getBlockTransactionCountByNumber Returns the number of transactions in a block matching the given block number.
 * @property BigInteger             $blockTransactionCountByNumber    Returns the number of transactions in a block matching the given block number.
 * @property BigInteger             $getBlockUncleCount               Returns the number of uncles in a block from a block matching the given block hash.
 * @property BigInteger             $blockUncleCount                  Returns the number of uncles in a block from a block matching the given block hash.
 * @property BigInteger             $getUncleCount                    Returns the number of uncles in a block from a block matching the given block hash.
 * @property BigInteger             $uncleCount                       Returns the number of uncles in a block from a block matching the given block hash.
 * @property BigInteger             $getChainId                       Returns the chain ID of the current connected node as described in the EIP-695.
 * @property Hex                    $getCoinbase                      Returns the client coinbase address.
 * @property mixed                  $getCompilers                     Returns a list of available compilers in the client.
 * @property mixed                  $compilers                        Returns a list of available compilers in the client.
 * @property BigInteger             $getGasPrice                      Returns the current price per gas in wei.
 * @property BigInteger             $getHashrate                      Returns the number of hashes per second that the node is mining with.
 * @property BigInteger             $hashrate                         Returns the number of hashes per second that the node is mining with.
 * @property array<mixed>           $getLogs                          Returns an array of all logs matching a given filter object.
 * @property array<mixed>           $logs                             Returns an array of all logs matching a given filter object.
 * @property string                 $getNodeInfo                      The current client version.
 * @property string                 $nodeInfo                         The current client version.
 * @property array<mixed>           $getPastLogs                      Returns an array of all logs matching a given filter object.
 * @property array<mixed>           $pastLogs                         Returns an array of all logs matching a given filter object.
 * @property array<string, mixed>   $getPendingTransactions           Returns a list of pending transactions.
 * @property array<string, mixed>   $pendingTransactions              Returns a list of pending transactions.
 * @property string                 $getProtocolVersion               Returns the current ethereum protocol version.
 * @property string                 $protocolVersion                  Returns the current ethereum protocol version.
 * @property BigInteger             $getUncleCountByBlockNumber       Returns the number of uncles in a block from a block matching the given block number.
 * @property BigInteger             $uncleCountByBlockNumber          Returns the number of uncles in a block from a block matching the given block number.
 * @property Hex[]                  $getWork                          Returns the hash of the current block, the seedHash, and the boundary condition to be met (“target”).
 * @property Hex[]                  $work                             Returns the hash of the current block, the seedHash, and the boundary condition to be met (“target”).
 * @property mixed                  $isMining                         Returns true if client is actively mining new blocks.
 * @property bool                   $isSyncing                        Returns an object with data about the sync status or false.
 * @property array<BigInteger>|bool $syncing                          Returns an object with data about the sync status or false.
 * @property mixed                  $mining                           Returns true if client is actively mining new blocks.
 * @property BigInteger             $newBlockFilter                   Creates a filter in the node, to notify when a new block arrives.
 * @property BigInteger             $newFilter                        Creates a filter object, based on filter options, to notify when the state changes (logs).
 * @property BigInteger             $newPendingTransactionFilter      Creates a filter in the node, to notify when new pending transactions arrive.
 *
 * @method Accounts                            accounts()                                                                     Returns a list of addresses owned by client.
 * @method BlockNumber                         blockNumber()                                                                  Returns the number of most recent block.
 * @method Call                                call(array $transaction, mixed $block = 'latest')                              Executes a new message call immediately without creating a transaction on the blockchain.
 * @method ChainId                             chainId()                                                                      Returns the chain ID of the current connected node as described in the EIP-695.
 * @method Coinbase                            coinbase()                                                                     Returns the client coinbase address.
 * @method CompileLLL                          compileLLL(string $sourcecode)                                                 Returns compiled LLL code.
 * @method CompileSolidity                     compileSolidity(string $sourcecode)                                            Returns compiled solidity code.
 * @method CompileSerpent                      compileSerpent(string $sourcecode)                                             Returns compiled serpent code.
 * @method EstimateGas                         estimateGas(array $transaction, mixed $block = 'latest')                       Executes a message call or transaction and returns the amount of the gas used.<br />Note: You must specify a from address otherwise you may experience odd behavior.
 * @method FeeHistory                          feeHistory(mixed $blockCount, mixed $newestBlock, array $rewardPercentiles)    Transaction fee history Returns base fee per gas and transaction effective priority fee per gas history for the requested block range if available. The range between headBlock-4 and headBlock is guaranteed to be available while retrieving data from the pending block and older history are optional to support. For pre-EIP-1559 blocks the gas prices are returned as rewards and zeroes are returned for the base fee per gas.
 * @method GasPrice                            gasPrice()                                                                     Returns the current price per gas in wei.
 * @method GetAccounts                         getAccounts()                                                                  Returns a list of addresses owned by client.
 * @method GetBalance                          getBalance(Hex|string $address, mixed $block = 'latest')                       Returns the balance of the account of given address.
 * @method GetBlock                            getBlock(mixed $block = 'latest', bool $full = true)                           Returns a block matching the block number or block hash.
 * @method GetBlockByHash                      getBlockByHash(Hex|string $hash, bool $full = true)                            Returns information about a block by hash.
 * @method GetBlockByNumber                    getBlockByNumber(mixed $block = 'latest', bool $full = true)                   Returns information about a block by block number.
 * @method GetBlockNumber                      getBlockNumber()                                                               Returns the number of most recent block.
 * @method GetBlockTransactionCount            getBlockTransactionCount(mixed $block = 'latest')                              Returns the number of transaction in a given block.
 * @method GetBlockTransactionCountByHash      getBlockTransactionCountByHash(Hex|string $hash)                               Returns the number of transactions in a block matching the given hash.
 * @method GetBlockTransactionCountByNumber    getBlockTransactionCountByNumber(mixed $block = 'latest')                      Returns the number of transactions in a block matching the given block number.
 * @method GetBlockUncleCount                  getBlockUncleCount(mixed $block = 'latest')                                    Returns the number of uncles in a block from a block matching the given block hash.
 * @method GetUncleCount                       getUncleCount(mixed $block = 'latest')                                         Returns the number of uncles in a block from a block matching the given block hash.
 * @method GetUncleCountByBlockHash            getUncleCountByBlockHash(Hex|string $hash)                                     Returns the number of uncles in a block from a block matching the given block hash.
 * @method GetChainId                          getChainId()                                                                   Returns the chain ID of the current connected node as described in the EIP-695.
 * @method GetCode                             getCode(Hex|string $address, mixed $block = 'latest')                          Returns code at a given address.
 * @method GetCoinbase                         getCoinbase()                                                                  Returns the client coinbase address.
 * @method GetCompilers                        getCompilers()                                                                 Returns a list of available compilers in the client.
 * @method GetFeeHistory                       getFeeHistory(mixed $blockCount, mixed $newestBlock, array $rewardPercentiles) Transaction fee history Returns base fee per gas and transaction effective priority fee per gas history for the requested block range if available. The range between headBlock-4 and headBlock is guaranteed to be available while retrieving data from the pending block and older history are optional to support. For pre-EIP-1559 blocks the gas prices are returned as rewards and zeroes are returned for the base fee per gas.
 * @method GetFilterChanges                    getFilterChanges(mixed $id)                                                    Polling method for a filter, which returns an array of logs which occurred since last poll.
 * @method GetFilterLogs                       getFilterLogs(mixed $id)                                                       Returns an array of all logs matching filter with given ID.
 * @method GetGasPrice                         getGasPrice()                                                                  Returns the current price per gas in wei.
 * @method GetHashrate                         getHashrate()                                                                  Returns the number of hashes per second that the node is mining with.
 * @method Hashrate                            hashrate()                                                                     Returns the number of hashes per second that the node is mining with.
 * @method GetLogs                             getLogs(array $filter = [])                                                    Returns an array of all logs matching a given filter object.
 * @method GetNodeInfo                         getNodeInfo()                                                                  The current client version.
 * @method NodeInfo                            nodeInfo()                                                                     The current client version.
 * @method GetPastLogs                         getPastLogs(array $filter = [])                                                Returns an array of all logs matching a given filter object.
 * @method GetPendingTransactions              getPendingTransactions()                                                       Returns a list of pending transactions.
 * @method PendingTransactions                 pendingTransactions()                                                          Returns a list of pending transactions.
 * @method GetTransactionByHash                getTransactionByHash(Hex|string $hash)                                         Returns the information about a transaction requested by transaction hash.
 * @method GetProtocolVersion                  getProtocolVersion()                                                           Returns the current ethereum protocol version.
 * @method ProtocolVersion                     protocolVersion()                                                              Returns the current ethereum protocol version.
 * @method GetStorageAt                        getStorageAt(Hex|string $address, mixed $position, mixed $block = 'latest')    Returns the value from a storage position at a given address.
 * @method GetTransaction                      getTransaction(Hex|string $hash)                                               Returns the information about a transaction requested by transaction hash.
 * @method GetTransactionByBlockHashAndIndex   getTransactionByBlockHashAndIndex(Hex|string $hash, mixed $position)           Returns information about a transaction by block hash and transaction index position.
 * @method GetTransactionByBlockNumberAndIndex getTransactionByBlockNumberAndIndex(mixed $block, mixed $position)             Returns information about a transaction by block number and transaction index position.
 * @method GetTransactionCount                 getTransactionCount(Hex|string $address, mixed $block = 'latest')              Returns the number of transactions sent from an address.
 * @method GetTransactionFromBlock             getTransactionFromBlock(mixed $block, mixed $position)                         Returns information about a transaction by block hash and transaction index position.
 * @method GetTransactionReceipt               getTransactionReceipt(Hex|string $hash)                                        Returns the receipt of a transaction by transaction hash.<br />Note That the receipt is not available for pending transactions.
 * @method GetUncle                            getUncle(mixed $block, mixed $position)                                        Returns a block's uncle by a given uncle index position.
 * @method GetUncleByBlockHashAndIndex         getUncleByBlockHashAndIndex(Hex|string $hash, mixed $position)                 Returns information about an uncle of a block by hash and uncle index position.
 * @method GetUncleByBlockNumberAndIndex       getUncleByBlockNumberAndIndex(mixed $block, mixed $position)                   Returns information about an uncle of a block by number and uncle index position.
 * @method GetUncleCountByBlockNumber          getUncleCountByBlockNumber(mixed $block = 'latest')                            Returns the number of uncles in a block from a block matching the given block number.
 * @method GetWork                             getWork()                                                                      Returns the hash of the current block, the seedHash, and the boundary condition to be met (“target”).
 * @method IsMining                            isMining()                                                                     Returns true if client is actively mining new blocks.
 * @method IsSyncing                           isSyncing()                                                                    Returns an object with data about the sync status or false.
 * @method Syncing                             syncing()                                                                      Returns an object with data about the sync status or false.
 * @method Mining                              mining()                                                                       Returns true if client is actively mining new blocks.
 * @method NewBlockFilter                      newBlockFilter()                                                               Creates a filter in the node, to notify when a new block arrives.
 * @method NewFilter                           newFilter(array $filter = [])                                                  Creates a filter object, based on filter options, to notify when the state changes (logs).
 * @method NewPendingTransactionFilter         newPendingTransactionFilter()                                                  Creates a filter in the node, to notify when new pending transactions arrive.
 * @method SendRawTransaction                  sendRawTransaction(Hex|string $transaction)                                    Creates new message call transaction or a contract creation for signed transactions.
 * @method SendSignedTransaction               sendSignedTransaction(Hex|string $transaction)                                 Creates new message call transaction or a contract creation for signed transactions.
 * @method SendTransaction                     sendTransaction(array $transaction)                                            Creates new message call transaction or a contract creation, if the data field contains code.
 * @method Sign                                sign(Hex|string $address, Hex|string $message)                                 Signs data using a specific account. This account needs to be unlocked.
 * @method SignTransaction                     signTransaction(array $transaction)                                            Signs a transaction. This account needs to be unlocked.
 * @method SubmitHashrate                      submitHashrate(Hex|string $hashrate, Hex|string $id)                           Used for submitting mining hashrate.
 * @method SubmitWork                          submitWork(Hex|string $nonce, Hex|string $header, Hex|string $digest)          Used for submitting a proof-of-work solution.
 * @method UninstallFilter                     uninstallFilter(mixed $id)                                                     Uninstalls a filter with given ID. Should always be called when watch is no longer needed.
 */
class Eth extends MethodNamespace
{
}
