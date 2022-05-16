<?php

namespace Awuxtron\Web3\Contracts;

use Awuxtron\Web3\ABI\JsonInterface;
use Awuxtron\Web3\Types\Address;
use Awuxtron\Web3\Types\Block;
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
    public function __call(string $name, array $arguments): Method
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

    /**
     * Call a batch of contract methods.
     *
     * @param array<mixed> $methods
     *
     * @return array<mixed>
     */
    public function batch(array $methods): array
    {
        $response = $this->getWeb3()->batch(function (Web3 $web3) use ($methods) {
            $requests = [];

            foreach ($methods as $key => $method) {
                $options = [];
                $block = Block::LATEST;

                if (is_array($method)) {
                    if (!empty($method[1])) {
                        $options = $method[1];
                    }

                    if (!empty($method[2])) {
                        $block = $method[2];
                    }

                    if (!empty($method)) {
                        $method = $method[0];
                    }
                }

                $requests[$key] = $method->getRequest($web3, $options, $block);
            }

            return $requests;
        });

        $result = [];

        foreach ($methods as $key => $method) {
            if (is_array($method) && !empty($method)) {
                $method = $method[0];
            }

            $result[$key] = $method->decode((string) $response[$key]->value());
        }

        return $result;
    }
}
