<?php

namespace Awuxtron\Web3\Contracts;

use Awuxtron\Web3\ABI\Coder;
use Awuxtron\Web3\ABI\Fragments\FunctionFragment;
use Awuxtron\Web3\Methods\Eth\Call;
use Awuxtron\Web3\Types\Block;
use Awuxtron\Web3\Types\EthereumType;
use Awuxtron\Web3\Utils\Hex;
use Awuxtron\Web3\Web3;
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
        $result = $this->getRequest($this->getContract()->getWeb3()->setExpectsRequest(false), $options, $block);

        // Decode call result.
        return $this->decode((string) $result->value());
    }

    /**
     * Get the method request.
     *
     * @param Web3         $web3
     * @param array<mixed> $options
     * @param mixed        $block
     *
     * @return array<mixed>|Call
     */
    public function getRequest(Web3 $web3, array $options = [], mixed $block = Block::LATEST): Call|array
    {
        return $web3->eth()->call(array_merge($options, [
            'to' => $this->contract->getAddress(),
            'data' => $this->getEncodedData(),
        ]), $block);
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
}
