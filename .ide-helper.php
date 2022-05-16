<?php

namespace Awuxtron\Web3\Methods;

class Eth
{
    /**
     * Returns a list of addresses owned by client.
     *
     * @var \Awuxtron\Web3\Utils\Hex[]
     */
    public array $accounts;

    /**
     * Returns the number of most recent block.
     *
     * @var \Brick\Math\BigInteger
     */
    public \Brick\Math\BigInteger $blockNumber;

    /**
     * Returns the chain ID of the current connected node as described in the EIP-695.
     *
     * @var \Brick\Math\BigInteger
     */
    public \Brick\Math\BigInteger $chainId;

    /**
     * Returns the client coinbase address.
     *
     * @var \Awuxtron\Web3\Utils\Hex
     */
    public \Awuxtron\Web3\Utils\Hex $coinbase;

    /**
     * Returns the current price per gas in wei.
     *
     * @var \Brick\Math\BigInteger
     */
    public \Brick\Math\BigInteger $gasPrice;

    /**
     * Returns a list of addresses owned by client.
     *
     * @var \Awuxtron\Web3\Utils\Hex[]
     */
    public array $getAccounts;

    /**
     * Returns a block matching the block number or block hash.
     *
     * @var array<string, mixed>
     */
    public array $getBlock;

    /**
     * Returns a block matching the block number or block hash.
     *
     * @var array<string, mixed>
     */
    public array $block;

    /**
     * Returns information about a block by block number.
     *
     * @var array<string, mixed>
     */
    public array $getBlockByNumber;

    /**
     * Returns information about a block by block number.
     *
     * @var array<string, mixed>
     */
    public array $blockByNumber;

    /**
     * Returns the number of most recent block.
     *
     * @var \Brick\Math\BigInteger
     */
    public \Brick\Math\BigInteger $getBlockNumber;

    /**
     * Returns the number of transaction in a given block.
     *
     * @var \Brick\Math\BigInteger
     */
    public \Brick\Math\BigInteger $getBlockTransactionCount;

    /**
     * Returns the number of transaction in a given block.
     *
     * @var \Brick\Math\BigInteger
     */
    public \Brick\Math\BigInteger $blockTransactionCount;

    /**
     * Returns the number of transactions in a block matching the given block number.
     *
     * @var \Brick\Math\BigInteger
     */
    public \Brick\Math\BigInteger $getBlockTransactionCountByNumber;

    /**
     * Returns the number of transactions in a block matching the given block number.
     *
     * @var \Brick\Math\BigInteger
     */
    public \Brick\Math\BigInteger $blockTransactionCountByNumber;

    /**
     * Returns the number of uncles in a block from a block matching the given block hash.
     *
     * @var \Brick\Math\BigInteger
     */
    public \Brick\Math\BigInteger $getBlockUncleCount;

    /**
     * Returns the number of uncles in a block from a block matching the given block hash.
     *
     * @var \Brick\Math\BigInteger
     */
    public \Brick\Math\BigInteger $blockUncleCount;

    /**
     * Returns the number of uncles in a block from a block matching the given block hash.
     *
     * @var \Brick\Math\BigInteger
     */
    public \Brick\Math\BigInteger $getUncleCount;

    /**
     * Returns the number of uncles in a block from a block matching the given block hash.
     *
     * @var \Brick\Math\BigInteger
     */
    public \Brick\Math\BigInteger $uncleCount;

    /**
     * Returns the chain ID of the current connected node as described in the EIP-695.
     *
     * @var \Brick\Math\BigInteger
     */
    public \Brick\Math\BigInteger $getChainId;

    /**
     * Returns the client coinbase address.
     *
     * @var \Awuxtron\Web3\Utils\Hex
     */
    public \Awuxtron\Web3\Utils\Hex $getCoinbase;

    /**
     * Returns a list of available compilers in the client.
     *
     * @var mixed
     */
    public mixed $getCompilers;

    /**
     * Returns a list of available compilers in the client.
     *
     * @var mixed
     */
    public mixed $compilers;

    /**
     * Returns the current price per gas in wei.
     *
     * @var \Brick\Math\BigInteger
     */
    public \Brick\Math\BigInteger $getGasPrice;

    /**
     * Returns the number of hashes per second that the node is mining with.
     *
     * @var \Brick\Math\BigInteger
     */
    public \Brick\Math\BigInteger $getHashrate;

    /**
     * Returns the number of hashes per second that the node is mining with.
     *
     * @var \Brick\Math\BigInteger
     */
    public \Brick\Math\BigInteger $hashrate;

    /**
     * Returns an array of all logs matching a given filter object.
     *
     * @var array<mixed>
     */
    public array $getLogs;

    /**
     * Returns an array of all logs matching a given filter object.
     *
     * @var array<mixed>
     */
    public array $logs;

    /**
     * The current client version.
     *
     * @var string
     */
    public string $getNodeInfo;

    /**
     * The current client version.
     *
     * @var string
     */
    public string $nodeInfo;

    /**
     * Returns an array of all logs matching a given filter object.
     *
     * @var array<mixed>
     */
    public array $getPastLogs;

    /**
     * Returns an array of all logs matching a given filter object.
     *
     * @var array<mixed>
     */
    public array $pastLogs;

    /**
     * Returns a list of pending transactions.
     *
     * @var array<string, mixed>
     */
    public array $getPendingTransactions;

    /**
     * Returns a list of pending transactions.
     *
     * @var array<string, mixed>
     */
    public array $pendingTransactions;

    /**
     * Returns the current ethereum protocol version.
     *
     * @var string
     */
    public string $getProtocolVersion;

    /**
     * Returns the current ethereum protocol version.
     *
     * @var string
     */
    public string $protocolVersion;

    /**
     * Returns the number of uncles in a block from a block matching the given block number.
     *
     * @var \Brick\Math\BigInteger
     */
    public \Brick\Math\BigInteger $getUncleCountByBlockNumber;

    /**
     * Returns the number of uncles in a block from a block matching the given block number.
     *
     * @var \Brick\Math\BigInteger
     */
    public \Brick\Math\BigInteger $uncleCountByBlockNumber;

    /**
     * Returns the hash of the current block, the seedHash, and the boundary condition to be met (“target”).
     *
     * @var \Awuxtron\Web3\Utils\Hex[]
     */
    public array $getWork;

    /**
     * Returns the hash of the current block, the seedHash, and the boundary condition to be met (“target”).
     *
     * @var \Awuxtron\Web3\Utils\Hex[]
     */
    public array $work;

    /**
     * Returns true if client is actively mining new blocks.
     *
     * @var mixed
     */
    public mixed $isMining;

    /**
     * Returns an object with data about the sync status or false.
     *
     * @var bool
     */
    public bool $isSyncing;

    /**
     * Returns an object with data about the sync status or false.
     *
     * @var array<\Brick\Math\BigInteger>|bool
     */
    public array|bool $syncing;

    /**
     * Returns true if client is actively mining new blocks.
     *
     * @var mixed
     */
    public mixed $mining;

    /**
     * Creates a filter in the node, to notify when a new block arrives.
     *
     * @var \Brick\Math\BigInteger
     */
    public \Brick\Math\BigInteger $newBlockFilter;

    /**
     * Creates a filter object, based on filter options, to notify when the state changes (logs).
     *
     * @var \Brick\Math\BigInteger
     */
    public \Brick\Math\BigInteger $newFilter;

    /**
     * Creates a filter in the node, to notify when new pending transactions arrive.
     *
     * @var \Brick\Math\BigInteger
     */
    public \Brick\Math\BigInteger $newPendingTransactionFilter;

    /**
     * Returns a list of addresses owned by client.
     *
     * @return \Awuxtron\Web3\Methods\Eth\Accounts
     */
    public function accounts(): \Awuxtron\Web3\Methods\Eth\Accounts
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\Accounts::class);
    }

    /**
     * Returns the number of most recent block.
     *
     * @return \Awuxtron\Web3\Methods\Eth\BlockNumber
     */
    public function blockNumber(): \Awuxtron\Web3\Methods\Eth\BlockNumber
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\BlockNumber::class);
    }

    /**
     * Executes a new message call immediately without creating a transaction on the blockchain.
     *
     * @param array<mixed> $transaction 
     * @param mixed $block 
     *
     * @return \Awuxtron\Web3\Methods\Eth\Call
     */
    public function call(array $transaction, mixed $block = 'latest'): \Awuxtron\Web3\Methods\Eth\Call
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\Call::class);
    }

    /**
     * Returns the chain ID of the current connected node as described in the EIP-695.
     *
     * @return \Awuxtron\Web3\Methods\Eth\ChainId
     */
    public function chainId(): \Awuxtron\Web3\Methods\Eth\ChainId
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\ChainId::class);
    }

    /**
     * Returns the client coinbase address.
     *
     * @return \Awuxtron\Web3\Methods\Eth\Coinbase
     */
    public function coinbase(): \Awuxtron\Web3\Methods\Eth\Coinbase
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\Coinbase::class);
    }

    /**
     * Returns compiled LLL code.
     *
     * @param string $sourcecode 
     *
     * @return \Awuxtron\Web3\Methods\Eth\CompileLLL
     */
    public function compileLLL(string $sourcecode): \Awuxtron\Web3\Methods\Eth\CompileLLL
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\CompileLLL::class);
    }

    /**
     * Returns compiled solidity code.
     *
     * @param string $sourcecode 
     *
     * @return \Awuxtron\Web3\Methods\Eth\CompileSolidity
     */
    public function compileSolidity(string $sourcecode): \Awuxtron\Web3\Methods\Eth\CompileSolidity
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\CompileSolidity::class);
    }

    /**
     * Returns compiled serpent code.
     *
     * @param string $sourcecode 
     *
     * @return \Awuxtron\Web3\Methods\Eth\CompileSerpent
     */
    public function compileSerpent(string $sourcecode): \Awuxtron\Web3\Methods\Eth\CompileSerpent
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\CompileSerpent::class);
    }

    /**
     * Executes a message call or transaction and returns the amount of the gas used.<br />Note: You must specify a from address otherwise you may experience odd behavior.
     *
     * @param array<mixed> $transaction 
     * @param mixed $block 
     *
     * @return \Awuxtron\Web3\Methods\Eth\EstimateGas
     */
    public function estimateGas(array $transaction, mixed $block = 'latest'): \Awuxtron\Web3\Methods\Eth\EstimateGas
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\EstimateGas::class);
    }

    /**
     * Transaction fee history Returns base fee per gas and transaction effective priority fee per gas history for the requested block range if available. The range between headBlock-4 and headBlock is guaranteed to be available while retrieving data from the pending block and older history are optional to support. For pre-EIP-1559 blocks the gas prices are returned as rewards and zeroes are returned for the base fee per gas.
     *
     * @param mixed $blockCount Number of blocks in the requested range. Between 1 and 1024 blocks can be requested in a single query. Less than requested may be returned if not all blocks are available.
     * @param mixed $newestBlock Highest number block of the requested range.
     * @param array<mixed> $rewardPercentiles A monotonically increasing list of percentile values to sample from each block’s effective priority fees per gas in ascending order, weighted by gas used. Example: [“0”, “25”, “50”, “75”, “100”] or [“0”, “0.5”, “1”, “1.5”, “3”, “80”].
     *
     * @return \Awuxtron\Web3\Methods\Eth\FeeHistory
     */
    public function feeHistory(mixed $blockCount, mixed $newestBlock, array $rewardPercentiles): \Awuxtron\Web3\Methods\Eth\FeeHistory
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\FeeHistory::class);
    }

    /**
     * Returns the current price per gas in wei.
     *
     * @return \Awuxtron\Web3\Methods\Eth\GasPrice
     */
    public function gasPrice(): \Awuxtron\Web3\Methods\Eth\GasPrice
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GasPrice::class);
    }

    /**
     * Returns a list of addresses owned by client.
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetAccounts
     */
    public function getAccounts(): \Awuxtron\Web3\Methods\Eth\GetAccounts
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetAccounts::class);
    }

    /**
     * Returns the balance of the account of given address.
     *
     * @param \Awuxtron\Web3\Utils\Hex|string $address address to check for balance.
     * @param mixed $block 
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetBalance
     */
    public function getBalance(\Awuxtron\Web3\Utils\Hex|string $address, mixed $block = 'latest'): \Awuxtron\Web3\Methods\Eth\GetBalance
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetBalance::class);
    }

    /**
     * Returns a block matching the block number or block hash.
     *
     * @param mixed $block The block number or block hash.
     * @param bool $full If true it returns the full transaction objects, if false only the hashes of the transactions.
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetBlock
     */
    public function getBlock(mixed $block = 'latest', bool $full = true): \Awuxtron\Web3\Methods\Eth\GetBlock
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetBlock::class);
    }

    /**
     * Returns information about a block by hash.
     *
     * @param \Awuxtron\Web3\Utils\Hex|string $hash 
     * @param bool $full If true it returns the full transaction objects, if false only the hashes of the transactions.
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetBlockByHash
     */
    public function getBlockByHash(\Awuxtron\Web3\Utils\Hex|string $hash, bool $full = true): \Awuxtron\Web3\Methods\Eth\GetBlockByHash
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetBlockByHash::class);
    }

    /**
     * Returns information about a block by block number.
     *
     * @param mixed $block 
     * @param bool $full If true it returns the full transaction objects, if false only the hashes of the transactions.
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetBlockByNumber
     */
    public function getBlockByNumber(mixed $block = 'latest', bool $full = true): \Awuxtron\Web3\Methods\Eth\GetBlockByNumber
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetBlockByNumber::class);
    }

    /**
     * Returns the number of most recent block.
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetBlockNumber
     */
    public function getBlockNumber(): \Awuxtron\Web3\Methods\Eth\GetBlockNumber
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetBlockNumber::class);
    }

    /**
     * Returns the number of transaction in a given block.
     *
     * @param mixed $block The block number or block hash.
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetBlockTransactionCount
     */
    public function getBlockTransactionCount(mixed $block = 'latest'): \Awuxtron\Web3\Methods\Eth\GetBlockTransactionCount
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetBlockTransactionCount::class);
    }

    /**
     * Returns the number of transactions in a block matching the given hash.
     *
     * @param \Awuxtron\Web3\Utils\Hex|string $hash hash of a block.
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetBlockTransactionCountByHash
     */
    public function getBlockTransactionCountByHash(\Awuxtron\Web3\Utils\Hex|string $hash): \Awuxtron\Web3\Methods\Eth\GetBlockTransactionCountByHash
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetBlockTransactionCountByHash::class);
    }

    /**
     * Returns the number of transactions in a block matching the given block number.
     *
     * @param mixed $block 
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetBlockTransactionCountByNumber
     */
    public function getBlockTransactionCountByNumber(mixed $block = 'latest'): \Awuxtron\Web3\Methods\Eth\GetBlockTransactionCountByNumber
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetBlockTransactionCountByNumber::class);
    }

    /**
     * Returns the number of uncles in a block from a block matching the given block hash.
     *
     * @param mixed $block The block number or block hash.
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetBlockUncleCount
     */
    public function getBlockUncleCount(mixed $block = 'latest'): \Awuxtron\Web3\Methods\Eth\GetBlockUncleCount
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetBlockUncleCount::class);
    }

    /**
     * Returns the number of uncles in a block from a block matching the given block hash.
     *
     * @param mixed $block The block number or block hash.
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetUncleCount
     */
    public function getUncleCount(mixed $block = 'latest'): \Awuxtron\Web3\Methods\Eth\GetUncleCount
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetUncleCount::class);
    }

    /**
     * Returns the number of uncles in a block from a block matching the given block hash.
     *
     * @param \Awuxtron\Web3\Utils\Hex|string $hash hash of a block.
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetUncleCountByBlockHash
     */
    public function getUncleCountByBlockHash(\Awuxtron\Web3\Utils\Hex|string $hash): \Awuxtron\Web3\Methods\Eth\GetUncleCountByBlockHash
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetUncleCountByBlockHash::class);
    }

    /**
     * Returns the chain ID of the current connected node as described in the EIP-695.
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetChainId
     */
    public function getChainId(): \Awuxtron\Web3\Methods\Eth\GetChainId
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetChainId::class);
    }

    /**
     * Returns code at a given address.
     *
     * @param \Awuxtron\Web3\Utils\Hex|string $address 
     * @param mixed $block 
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetCode
     */
    public function getCode(\Awuxtron\Web3\Utils\Hex|string $address, mixed $block = 'latest'): \Awuxtron\Web3\Methods\Eth\GetCode
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetCode::class);
    }

    /**
     * Returns the client coinbase address.
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetCoinbase
     */
    public function getCoinbase(): \Awuxtron\Web3\Methods\Eth\GetCoinbase
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetCoinbase::class);
    }

    /**
     * Returns a list of available compilers in the client.
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetCompilers
     */
    public function getCompilers(): \Awuxtron\Web3\Methods\Eth\GetCompilers
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetCompilers::class);
    }

    /**
     * Transaction fee history Returns base fee per gas and transaction effective priority fee per gas history for the requested block range if available. The range between headBlock-4 and headBlock is guaranteed to be available while retrieving data from the pending block and older history are optional to support. For pre-EIP-1559 blocks the gas prices are returned as rewards and zeroes are returned for the base fee per gas.
     *
     * @param mixed $blockCount Number of blocks in the requested range. Between 1 and 1024 blocks can be requested in a single query. Less than requested may be returned if not all blocks are available.
     * @param mixed $newestBlock Highest number block of the requested range.
     * @param array<mixed> $rewardPercentiles A monotonically increasing list of percentile values to sample from each block’s effective priority fees per gas in ascending order, weighted by gas used. Example: [“0”, “25”, “50”, “75”, “100”] or [“0”, “0.5”, “1”, “1.5”, “3”, “80”].
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetFeeHistory
     */
    public function getFeeHistory(mixed $blockCount, mixed $newestBlock, array $rewardPercentiles): \Awuxtron\Web3\Methods\Eth\GetFeeHistory
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetFeeHistory::class);
    }

    /**
     * Polling method for a filter, which returns an array of logs which occurred since last poll.
     *
     * @param mixed $id 
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetFilterChanges
     */
    public function getFilterChanges(mixed $id): \Awuxtron\Web3\Methods\Eth\GetFilterChanges
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetFilterChanges::class);
    }

    /**
     * Returns an array of all logs matching filter with given ID.
     *
     * @param mixed $id 
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetFilterLogs
     */
    public function getFilterLogs(mixed $id): \Awuxtron\Web3\Methods\Eth\GetFilterLogs
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetFilterLogs::class);
    }

    /**
     * Returns the current price per gas in wei.
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetGasPrice
     */
    public function getGasPrice(): \Awuxtron\Web3\Methods\Eth\GetGasPrice
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetGasPrice::class);
    }

    /**
     * Returns the number of hashes per second that the node is mining with.
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetHashrate
     */
    public function getHashrate(): \Awuxtron\Web3\Methods\Eth\GetHashrate
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetHashrate::class);
    }

    /**
     * Returns the number of hashes per second that the node is mining with.
     *
     * @return \Awuxtron\Web3\Methods\Eth\Hashrate
     */
    public function hashrate(): \Awuxtron\Web3\Methods\Eth\Hashrate
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\Hashrate::class);
    }

    /**
     * Returns an array of all logs matching a given filter object.
     *
     * @param array<mixed> $filter 
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetLogs
     */
    public function getLogs(array $filter = []): \Awuxtron\Web3\Methods\Eth\GetLogs
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetLogs::class);
    }

    /**
     * The current client version.
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetNodeInfo
     */
    public function getNodeInfo(): \Awuxtron\Web3\Methods\Eth\GetNodeInfo
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetNodeInfo::class);
    }

    /**
     * The current client version.
     *
     * @return \Awuxtron\Web3\Methods\Eth\NodeInfo
     */
    public function nodeInfo(): \Awuxtron\Web3\Methods\Eth\NodeInfo
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\NodeInfo::class);
    }

    /**
     * Returns an array of all logs matching a given filter object.
     *
     * @param array<mixed> $filter 
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetPastLogs
     */
    public function getPastLogs(array $filter = []): \Awuxtron\Web3\Methods\Eth\GetPastLogs
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetPastLogs::class);
    }

    /**
     * Returns a list of pending transactions.
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetPendingTransactions
     */
    public function getPendingTransactions(): \Awuxtron\Web3\Methods\Eth\GetPendingTransactions
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetPendingTransactions::class);
    }

    /**
     * Returns a list of pending transactions.
     *
     * @return \Awuxtron\Web3\Methods\Eth\PendingTransactions
     */
    public function pendingTransactions(): \Awuxtron\Web3\Methods\Eth\PendingTransactions
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\PendingTransactions::class);
    }

    /**
     * Returns the information about a transaction requested by transaction hash.
     *
     * @param \Awuxtron\Web3\Utils\Hex|string $hash hash of a transaction.
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetTransactionByHash
     */
    public function getTransactionByHash(\Awuxtron\Web3\Utils\Hex|string $hash): \Awuxtron\Web3\Methods\Eth\GetTransactionByHash
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetTransactionByHash::class);
    }

    /**
     * Returns the current ethereum protocol version.
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetProtocolVersion
     */
    public function getProtocolVersion(): \Awuxtron\Web3\Methods\Eth\GetProtocolVersion
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetProtocolVersion::class);
    }

    /**
     * Returns the current ethereum protocol version.
     *
     * @return \Awuxtron\Web3\Methods\Eth\ProtocolVersion
     */
    public function protocolVersion(): \Awuxtron\Web3\Methods\Eth\ProtocolVersion
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\ProtocolVersion::class);
    }

    /**
     * Returns the value from a storage position at a given address.
     *
     * @param \Awuxtron\Web3\Utils\Hex|string $address address of the storage.
     * @param mixed $position integer of the position in the storage.
     * @param mixed $block 
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetStorageAt
     */
    public function getStorageAt(\Awuxtron\Web3\Utils\Hex|string $address, mixed $position, mixed $block = 'latest'): \Awuxtron\Web3\Methods\Eth\GetStorageAt
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetStorageAt::class);
    }

    /**
     * Returns the information about a transaction requested by transaction hash.
     *
     * @param \Awuxtron\Web3\Utils\Hex|string $hash hash of a transaction.
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetTransaction
     */
    public function getTransaction(\Awuxtron\Web3\Utils\Hex|string $hash): \Awuxtron\Web3\Methods\Eth\GetTransaction
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetTransaction::class);
    }

    /**
     * Returns information about a transaction by block hash and transaction index position.
     *
     * @param \Awuxtron\Web3\Utils\Hex|string $hash hash of a block.
     * @param mixed $position integer of the transaction index position.
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetTransactionByBlockHashAndIndex
     */
    public function getTransactionByBlockHashAndIndex(\Awuxtron\Web3\Utils\Hex|string $hash, mixed $position): \Awuxtron\Web3\Methods\Eth\GetTransactionByBlockHashAndIndex
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetTransactionByBlockHashAndIndex::class);
    }

    /**
     * Returns information about a transaction by block number and transaction index position.
     *
     * @param mixed $block 
     * @param mixed $position integer of the transaction index position.
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetTransactionByBlockNumberAndIndex
     */
    public function getTransactionByBlockNumberAndIndex(mixed $block, mixed $position): \Awuxtron\Web3\Methods\Eth\GetTransactionByBlockNumberAndIndex
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetTransactionByBlockNumberAndIndex::class);
    }

    /**
     * Returns the number of transactions sent from an address.
     *
     * @param \Awuxtron\Web3\Utils\Hex|string $address 
     * @param mixed $block 
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetTransactionCount
     */
    public function getTransactionCount(\Awuxtron\Web3\Utils\Hex|string $address, mixed $block = 'latest'): \Awuxtron\Web3\Methods\Eth\GetTransactionCount
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetTransactionCount::class);
    }

    /**
     * Returns information about a transaction by block hash and transaction index position.
     *
     * @param mixed $block the block number or hash.
     * @param mixed $position integer of the transaction index position.
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetTransactionFromBlock
     */
    public function getTransactionFromBlock(mixed $block, mixed $position): \Awuxtron\Web3\Methods\Eth\GetTransactionFromBlock
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetTransactionFromBlock::class);
    }

    /**
     * Returns the receipt of a transaction by transaction hash.<br />Note That the receipt is not available for pending transactions.
     *
     * @param \Awuxtron\Web3\Utils\Hex|string $hash hash of a transaction.
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetTransactionReceipt
     */
    public function getTransactionReceipt(\Awuxtron\Web3\Utils\Hex|string $hash): \Awuxtron\Web3\Methods\Eth\GetTransactionReceipt
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetTransactionReceipt::class);
    }

    /**
     * Returns a block's uncle by a given uncle index position.
     *
     * @param mixed $block The block number or hash.
     * @param mixed $position The uncle’s index position.
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetUncle
     */
    public function getUncle(mixed $block, mixed $position): \Awuxtron\Web3\Methods\Eth\GetUncle
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetUncle::class);
    }

    /**
     * Returns information about an uncle of a block by hash and uncle index position.
     *
     * @param \Awuxtron\Web3\Utils\Hex|string $hash The hash of a block.
     * @param mixed $position The uncle’s index position.
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetUncleByBlockHashAndIndex
     */
    public function getUncleByBlockHashAndIndex(\Awuxtron\Web3\Utils\Hex|string $hash, mixed $position): \Awuxtron\Web3\Methods\Eth\GetUncleByBlockHashAndIndex
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetUncleByBlockHashAndIndex::class);
    }

    /**
     * Returns information about an uncle of a block by number and uncle index position.
     *
     * @param mixed $block 
     * @param mixed $position The uncle’s index position.
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetUncleByBlockNumberAndIndex
     */
    public function getUncleByBlockNumberAndIndex(mixed $block, mixed $position): \Awuxtron\Web3\Methods\Eth\GetUncleByBlockNumberAndIndex
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetUncleByBlockNumberAndIndex::class);
    }

    /**
     * Returns the number of uncles in a block from a block matching the given block number.
     *
     * @param mixed $block 
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetUncleCountByBlockNumber
     */
    public function getUncleCountByBlockNumber(mixed $block = 'latest'): \Awuxtron\Web3\Methods\Eth\GetUncleCountByBlockNumber
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetUncleCountByBlockNumber::class);
    }

    /**
     * Returns the hash of the current block, the seedHash, and the boundary condition to be met (“target”).
     *
     * @return \Awuxtron\Web3\Methods\Eth\GetWork
     */
    public function getWork(): \Awuxtron\Web3\Methods\Eth\GetWork
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\GetWork::class);
    }

    /**
     * Returns true if client is actively mining new blocks.
     *
     * @return \Awuxtron\Web3\Methods\Eth\IsMining
     */
    public function isMining(): \Awuxtron\Web3\Methods\Eth\IsMining
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\IsMining::class);
    }

    /**
     * Returns an object with data about the sync status or false.
     *
     * @return \Awuxtron\Web3\Methods\Eth\IsSyncing
     */
    public function isSyncing(): \Awuxtron\Web3\Methods\Eth\IsSyncing
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\IsSyncing::class);
    }

    /**
     * Returns an object with data about the sync status or false.
     *
     * @return \Awuxtron\Web3\Methods\Eth\Syncing
     */
    public function syncing(): \Awuxtron\Web3\Methods\Eth\Syncing
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\Syncing::class);
    }

    /**
     * Returns true if client is actively mining new blocks.
     *
     * @return \Awuxtron\Web3\Methods\Eth\Mining
     */
    public function mining(): \Awuxtron\Web3\Methods\Eth\Mining
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\Mining::class);
    }

    /**
     * Creates a filter in the node, to notify when a new block arrives.
     *
     * @return \Awuxtron\Web3\Methods\Eth\NewBlockFilter
     */
    public function newBlockFilter(): \Awuxtron\Web3\Methods\Eth\NewBlockFilter
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\NewBlockFilter::class);
    }

    /**
     * Creates a filter object, based on filter options, to notify when the state changes (logs).
     *
     * @param array<mixed> $filter The filter options.
     *
     * @return \Awuxtron\Web3\Methods\Eth\NewFilter
     */
    public function newFilter(array $filter = []): \Awuxtron\Web3\Methods\Eth\NewFilter
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\NewFilter::class);
    }

    /**
     * Creates a filter in the node, to notify when new pending transactions arrive.
     *
     * @return \Awuxtron\Web3\Methods\Eth\NewPendingTransactionFilter
     */
    public function newPendingTransactionFilter(): \Awuxtron\Web3\Methods\Eth\NewPendingTransactionFilter
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\NewPendingTransactionFilter::class);
    }

    /**
     * Creates new message call transaction or a contract creation for signed transactions.
     *
     * @param \Awuxtron\Web3\Utils\Hex|string $transaction The signed transaction data.
     *
     * @return \Awuxtron\Web3\Methods\Eth\SendRawTransaction
     */
    public function sendRawTransaction(\Awuxtron\Web3\Utils\Hex|string $transaction): \Awuxtron\Web3\Methods\Eth\SendRawTransaction
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\SendRawTransaction::class);
    }

    /**
     * Creates new message call transaction or a contract creation for signed transactions.
     *
     * @param \Awuxtron\Web3\Utils\Hex|string $transaction The signed transaction data.
     *
     * @return \Awuxtron\Web3\Methods\Eth\SendSignedTransaction
     */
    public function sendSignedTransaction(\Awuxtron\Web3\Utils\Hex|string $transaction): \Awuxtron\Web3\Methods\Eth\SendSignedTransaction
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\SendSignedTransaction::class);
    }

    /**
     * Creates new message call transaction or a contract creation, if the data field contains code.
     *
     * @param array<mixed> $transaction 
     *
     * @return \Awuxtron\Web3\Methods\Eth\SendTransaction
     */
    public function sendTransaction(array $transaction): \Awuxtron\Web3\Methods\Eth\SendTransaction
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\SendTransaction::class);
    }

    /**
     * Signs data using a specific account. This account needs to be unlocked.
     *
     * @param \Awuxtron\Web3\Utils\Hex|string $address 
     * @param \Awuxtron\Web3\Utils\Hex|string $message 
     *
     * @return \Awuxtron\Web3\Methods\Eth\Sign
     */
    public function sign(\Awuxtron\Web3\Utils\Hex|string $address, \Awuxtron\Web3\Utils\Hex|string $message): \Awuxtron\Web3\Methods\Eth\Sign
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\Sign::class);
    }

    /**
     * Signs a transaction. This account needs to be unlocked.
     *
     * @param array<mixed> $transaction 
     *
     * @return \Awuxtron\Web3\Methods\Eth\SignTransaction
     */
    public function signTransaction(array $transaction): \Awuxtron\Web3\Methods\Eth\SignTransaction
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\SignTransaction::class);
    }

    /**
     * Used for submitting mining hashrate.
     *
     * @param \Awuxtron\Web3\Utils\Hex|string $hashrate a hexadecimal string representation (32 bytes) of the hash rate.
     * @param \Awuxtron\Web3\Utils\Hex|string $id a random hexadecimal(32 bytes) ID identifying the client.
     *
     * @return \Awuxtron\Web3\Methods\Eth\SubmitHashrate
     */
    public function submitHashrate(\Awuxtron\Web3\Utils\Hex|string $hashrate, \Awuxtron\Web3\Utils\Hex|string $id): \Awuxtron\Web3\Methods\Eth\SubmitHashrate
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\SubmitHashrate::class);
    }

    /**
     * Used for submitting a proof-of-work solution.
     *
     * @param \Awuxtron\Web3\Utils\Hex|string $nonce The nonce found (64 bits).
     * @param \Awuxtron\Web3\Utils\Hex|string $header The header’s pow-hash (256 bits).
     * @param \Awuxtron\Web3\Utils\Hex|string $digest The mix digest (256 bits).
     *
     * @return \Awuxtron\Web3\Methods\Eth\SubmitWork
     */
    public function submitWork(\Awuxtron\Web3\Utils\Hex|string $nonce, \Awuxtron\Web3\Utils\Hex|string $header, \Awuxtron\Web3\Utils\Hex|string $digest): \Awuxtron\Web3\Methods\Eth\SubmitWork
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\SubmitWork::class);
    }

    /**
     * Uninstalls a filter with given ID. Should always be called when watch is no longer needed.
     *
     * @param mixed $id 
     *
     * @return \Awuxtron\Web3\Methods\Eth\UninstallFilter
     */
    public function uninstallFilter(mixed $id): \Awuxtron\Web3\Methods\Eth\UninstallFilter
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Eth\UninstallFilter::class);
    }

}

class Shh
{
    /**
     * Creates filter to notify, when client receives whisper message matching the filter options.
     *
     * @var \Brick\Math\BigInteger
     */
    public \Brick\Math\BigInteger $newFilter;

    /**
     * @var \Awuxtron\Web3\Utils\Hex
     */
    public \Awuxtron\Web3\Utils\Hex $newGroup;

    /**
     * Creates new whisper identity in the client.
     *
     * @var \Awuxtron\Web3\Utils\Hex
     */
    public \Awuxtron\Web3\Utils\Hex $newIdentity;

    /**
     * Returns the current whisper protocol version.
     *
     * @var mixed
     */
    public mixed $version;

    /**
     * @param \Awuxtron\Web3\Utils\Hex|string $identity The identity address to add to a group (?).
     *
     * @return \Awuxtron\Web3\Methods\Shh\AddToGroup
     */
    public function addToGroup(\Awuxtron\Web3\Utils\Hex|string $identity): \Awuxtron\Web3\Methods\Shh\AddToGroup
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Shh\AddToGroup::class);
    }

    /**
     * Polling method for whisper filters. Returns new messages since the last call of this method.
     *
     * @param mixed $id 
     *
     * @return \Awuxtron\Web3\Methods\Shh\GetFilterChanges
     */
    public function getFilterChanges(mixed $id): \Awuxtron\Web3\Methods\Shh\GetFilterChanges
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Shh\GetFilterChanges::class);
    }

    /**
     * Get all messages matching a filter. Unlike shh_getFilterChanges this returns all messages.
     *
     * @param mixed $id 
     *
     * @return \Awuxtron\Web3\Methods\Shh\GetMessages
     */
    public function getMessages(mixed $id): \Awuxtron\Web3\Methods\Shh\GetMessages
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Shh\GetMessages::class);
    }

    /**
     * Checks if the client hold the private keys for a given identity.
     *
     * @param \Awuxtron\Web3\Utils\Hex|string $identity The identity address to check.
     *
     * @return \Awuxtron\Web3\Methods\Shh\HasIdentity
     */
    public function hasIdentity(\Awuxtron\Web3\Utils\Hex|string $identity): \Awuxtron\Web3\Methods\Shh\HasIdentity
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Shh\HasIdentity::class);
    }

    /**
     * Creates filter to notify, when client receives whisper message matching the filter options.
     *
     * @param array<mixed> $filter 
     *
     * @return \Awuxtron\Web3\Methods\Shh\NewFilter
     */
    public function newFilter(array $filter = []): \Awuxtron\Web3\Methods\Shh\NewFilter
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Shh\NewFilter::class);
    }

    /**
     * @return \Awuxtron\Web3\Methods\Shh\NewGroup
     */
    public function newGroup(): \Awuxtron\Web3\Methods\Shh\NewGroup
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Shh\NewGroup::class);
    }

    /**
     * Creates new whisper identity in the client.
     *
     * @return \Awuxtron\Web3\Methods\Shh\NewIdentity
     */
    public function newIdentity(): \Awuxtron\Web3\Methods\Shh\NewIdentity
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Shh\NewIdentity::class);
    }

    /**
     * Sends a whisper message.
     *
     * @param array<mixed> $whisper The whisper post object.
     *
     * @return \Awuxtron\Web3\Methods\Shh\Post
     */
    public function post(array $whisper): \Awuxtron\Web3\Methods\Shh\Post
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Shh\Post::class);
    }

    /**
     * Uninstalls a filter with given ID. Should always be called when watch is no longer needed.
     *
     * @param mixed $id 
     *
     * @return \Awuxtron\Web3\Methods\Shh\UninstallFilter
     */
    public function uninstallFilter(mixed $id): \Awuxtron\Web3\Methods\Shh\UninstallFilter
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Shh\UninstallFilter::class);
    }

    /**
     * Returns the current whisper protocol version.
     *
     * @return \Awuxtron\Web3\Methods\Shh\Version
     */
    public function version(): \Awuxtron\Web3\Methods\Shh\Version
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Shh\Version::class);
    }

}

class Web3
{
    /**
     * Returns the current client version.
     *
     * @var string
     */
    public string $clientVersion;

    /**
     * Returns the current client version.
     *
     * @return \Awuxtron\Web3\Methods\Web3\ClientVersion
     */
    public function clientVersion(): \Awuxtron\Web3\Methods\Web3\ClientVersion
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Web3\ClientVersion::class);
    }

    /**
     * Returns Keccak-256 (not the standardized SHA3-256) of the given data.
     *
     * @param \Awuxtron\Web3\Utils\Hex|string $data The data to convert into a SHA3 hash.
     *
     * @return \Awuxtron\Web3\Methods\Web3\Sha3
     */
    public function sha3(\Awuxtron\Web3\Utils\Hex|string $data): \Awuxtron\Web3\Methods\Web3\Sha3
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Web3\Sha3::class);
    }

}

class Net
{
    /**
     * Returns the current network ID.
     *
     * @var string
     */
    public string $getId;

    /**
     * Returns the current network ID.
     *
     * @var string
     */
    public string $version;

    /**
     * Returns number of peers currently connected to the client.
     *
     * @var \Brick\Math\BigInteger
     */
    public \Brick\Math\BigInteger $getPeerCount;

    /**
     * Returns number of peers currently connected to the client.
     *
     * @var \Brick\Math\BigInteger
     */
    public \Brick\Math\BigInteger $peerCount;

    /**
     * Returns the current network ID.
     *
     * @var string
     */
    public string $id;

    /**
     * Returns true if client is actively listening for network connections.
     *
     * @var bool
     */
    public bool $isListening;

    /**
     * Returns true if client is actively listening for network connections.
     *
     * @var bool
     */
    public bool $listening;

    /**
     * Returns the current network ID.
     *
     * @return \Awuxtron\Web3\Methods\Net\GetId
     */
    public function getId(): \Awuxtron\Web3\Methods\Net\GetId
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Net\GetId::class);
    }

    /**
     * Returns the current network ID.
     *
     * @return \Awuxtron\Web3\Methods\Net\Version
     */
    public function version(): \Awuxtron\Web3\Methods\Net\Version
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Net\Version::class);
    }

    /**
     * Returns number of peers currently connected to the client.
     *
     * @return \Awuxtron\Web3\Methods\Net\GetPeerCount
     */
    public function getPeerCount(): \Awuxtron\Web3\Methods\Net\GetPeerCount
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Net\GetPeerCount::class);
    }

    /**
     * Returns number of peers currently connected to the client.
     *
     * @return \Awuxtron\Web3\Methods\Net\PeerCount
     */
    public function peerCount(): \Awuxtron\Web3\Methods\Net\PeerCount
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Net\PeerCount::class);
    }

    /**
     * Returns the current network ID.
     *
     * @return \Awuxtron\Web3\Methods\Net\Id
     */
    public function id(): \Awuxtron\Web3\Methods\Net\Id
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Net\Id::class);
    }

    /**
     * Returns true if client is actively listening for network connections.
     *
     * @return \Awuxtron\Web3\Methods\Net\IsListening
     */
    public function isListening(): \Awuxtron\Web3\Methods\Net\IsListening
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Net\IsListening::class);
    }

    /**
     * Returns true if client is actively listening for network connections.
     *
     * @return \Awuxtron\Web3\Methods\Net\Listening
     */
    public function listening(): \Awuxtron\Web3\Methods\Net\Listening
    {
        return (new \Awuxtron\Web3\Web3(new \Awuxtron\Web3\Providers\HttpProvider('http://localhost')))->method(\Awuxtron\Web3\Methods\Net\Listening::class);
    }

}

