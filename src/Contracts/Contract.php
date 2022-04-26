<?php

namespace Awuxtron\Web3\Contracts;

use Awuxtron\Web3\ABI\JsonInterface;
use Awuxtron\Web3\Types\Address;
use Awuxtron\Web3\Utils\Hex;
use Awuxtron\Web3\Web3;

class Contract
{
    /**
     * The contract abi.
     *
     * @var JsonInterface
     */
    protected JsonInterface $interface;

    /**
     * The contract address.
     *
     * @var Hex
     */
    protected Hex $address;

    /**
     * Create a new contract instance.
     *
     * @param Web3                              $web3
     * @param array<mixed>|JsonInterface|string $abi
     * @param Hex|string                        $address
     */
    public function __construct(protected Web3 $web3, JsonInterface|string|array $abi, string|Hex $address)
    {
        $this->interface = JsonInterface::from($abi);
        $this->address = (new Address)->encode($address)->stripZeros();
    }

    /**
     * Dynamic call contract method.
     *
     * @param string       $name
     * @param array<mixed> $arguments
     *
     * @return Method
     */
    public function __call(string $name, array $arguments)
    {
        return $this->method($name, $arguments);
    }

    /**
     * Get a contract method instance.
     *
     * @param string       $name
     * @param array<mixed> $args
     *
     * @return Method
     */
    public function method(string $name, array $args = []): Method
    {
        return new Method($this, $this->interface->getFunction($name), $args);
    }

    /**
     * Get the Web3 instance.
     *
     * @return Web3
     */
    public function getWeb3(): Web3
    {
        return $this->web3;
    }

    /**
     * Get the contract address.
     *
     * @return Hex
     */
    public function getAddress(): Hex
    {
        return $this->address;
    }
}
