<?php

namespace Awuxtron\Web3\Multicall;

use Awuxtron\Web3\Contracts\Contract;
use Awuxtron\Web3\Contracts\Method;
use Awuxtron\Web3\Types\Block;
use Awuxtron\Web3\Utils\Hex;
use Awuxtron\Web3\Web3;

class Multicall
{
    /**
     * Create a new multicall instance.
     *
     * @param Web3       $web3
     * @param Hex|string $address
     * @param bool       $tryAggregate
     */
    public function __construct(protected Web3 $web3, protected Hex|string $address, protected bool $tryAggregate = false)
    {
    }

    /**
     * Call multiple requests.
     *
     * @param Method[]     $methods
     * @param array<mixed> $options
     * @param mixed        $block
     *
     * @return array<mixed>
     */
    public function call(array $methods, array $options = [], mixed $block = Block::LATEST): array
    {
        $keys = array_keys($methods);
        $methods = array_values($methods);

        if ($this->tryAggregate) {
            $result = $this->tryBlockAndAggregate($methods, $options, $block);
        } else {
            $result = $this->aggregate($methods, $options, $block);
        }

        return array_combine($keys, $result);
    }

    /**
     * Call by using aggregate method.
     *
     * @param Method[]     $methods
     * @param array<mixed> $options
     * @param mixed        $block
     *
     * @return array<mixed>
     */
    protected function aggregate(array $methods, array $options = [], mixed $block = Block::LATEST): array
    {
        $response = $this->getContract()
            ->method('aggregate', [$this->buildMulticallData($methods)])
            ->call($options, $block)
        ;

        $result = [];

        foreach ($methods as $i => $method) {
            $result[$i] = $method->decode($response['returnData'][$i]);
        }

        return $result;
    }

    /**
     * Call by using tryBlockAndAggregate method.
     *
     * @param Method[]     $methods
     * @param array<mixed> $options
     * @param mixed        $block
     *
     * @return array<mixed>
     */
    protected function tryBlockAndAggregate(array $methods, array $options = [], mixed $block = Block::LATEST): array
    {
        $response = $this->getContract()
            ->method('tryBlockAndAggregate', [true, $this->buildMulticallData($methods)])
            ->call($options, $block)
        ;

        $result = [];

        foreach ($methods as $i => $method) {
            $result[$i] = $method->decode($response['returnData'][$i]['returnData']);
        }

        return $result;
    }

    /**
     * Build the multicall data.
     *
     * @param Method[] $methods
     *
     * @phpstan-return array<int, array{Hex, Hex}>
     *
     * @return array
     */
    protected function buildMulticallData(array $methods): array
    {
        $data = [];

        foreach ($methods as $method) {
            $data[] = [
                $method->getContract()->getAddress(),
                $method->getEncodedData(),
            ];
        }

        return $data;
    }

    /**
     * Get the multicall contract instance.
     *
     * @return Contract
     */
    protected function getContract(): Contract
    {
        return $this->web3->contract((string) file_get_contents(__DIR__ . '/multicall.json'), $this->address);
    }
}
