<?php

namespace Awuxtron\Web3\Contracts;

use Awuxtron\Web3\ABI\Coder;
use Awuxtron\Web3\ABI\Fragments\FunctionFragment;
use Awuxtron\Web3\Types\Block;
use Awuxtron\Web3\Types\EthereumType;
use Awuxtron\Web3\Utils\Hex;
use Awuxtron\Web3\Web3;
use Brick\Math\BigInteger;
use InvalidArgumentException;

class Method
{
    /**
     * @var EthereumType[]
     */
    protected array $types;

    /**
     * Create a new method instance.
     *
     * @param Contract         $contract
     * @param FunctionFragment $fragment
     * @param array<mixed>     $args
     */
    public function __construct(protected Contract $contract, protected FunctionFragment $fragment, protected array $args = [])
    {
        // Verify arguments.
        $this->types = $this->fragment->getInputTypes();

        if (count($this->types) != count($args)) {
            throw new InvalidArgumentException(sprintf('Method %s expected %d arguments, %d provided.', $fragment->getName(), count($this->types), count($args)));
        }

        foreach ($args as $i => $arg) {
            $this->types[$i]->validate($arg);
        }
    }

    /**
     * Call this method.
     *
     * @param array<mixed> $options
     * @param mixed        $block
     *
     * @return mixed
     */
    public function call(array $options = [], mixed $block = Block::LATEST): mixed
    {
        return $this->decode((string) $this->getResult('call', $options, $block)->value());
    }

    /**
     * Estimate the gas when method call.
     *
     * @param array<mixed> $options
     * @param mixed        $block
     *
     * @return BigInteger
     */
    public function estimateGas(array $options = [], mixed $block = Block::LATEST): BigInteger
    {
        return $this->getResult('estimateGas', $options, $block)->value();
    }

    /**
     * Get the method request.
     *
     * @param Web3         $web3
     * @param string       $type
     * @param array<mixed> $options
     * @param mixed        $block
     *
     * @return mixed
     */
    public function getRequest(Web3 $web3, string $type, array $options = [], mixed $block = Block::LATEST): mixed
    {
        return $web3->eth()->{$type}($this->getTransaction($options), $block);
    }

    /**
     * Get the method transaction object.
     *
     * @param array<mixed> $transaction
     *
     * @return array<mixed>
     */
    public function getTransaction(array $transaction = []): array
    {
        return array_merge($transaction, [
            'to' => $this->contract->getAddress(),
            'data' => $this->getEncodedData(),
        ]);
    }

    /**
     * Decode the method result.
     *
     * @param string $result
     *
     * @return mixed
     */
    public function decode(string $result): mixed
    {
        $decoded = Coder::decode($this->fragment->getOutputTypes(), $result);

        if (count($decoded) == 1) {
            return array_shift($decoded);
        }

        return $decoded;
    }

    /**
     * Get the method encoded data.
     *
     * @return Hex
     */
    public function getEncodedData(): Hex
    {
        $signature = $this->fragment->getSignature();

        if (!empty($this->types)) {
            $signature = $signature->append(Coder::encode($this->types, $this->args));
        }

        return $signature;
    }

    /**
     * Get the method contract instance.
     *
     * @return Contract
     */
    public function getContract(): Contract
    {
        return $this->contract;
    }

    /**
     * Call the method and get result.
     *
     * @param string       $type
     * @param array<mixed> $options
     * @param mixed        $block
     *
     * @return mixed
     */
    protected function getResult(string $type, array $options = [], mixed $block = Block::LATEST): mixed
    {
        return $this->getRequest($this->getContract()->getWeb3()->setExpectsRequest(false), $type, $options, $block);
    }
}
