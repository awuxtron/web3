<?php

namespace Awuxtron\Web3;

use Awuxtron\Web3\Multicall\Multicall;
use Awuxtron\Web3\Providers\Provider;
use Awuxtron\Web3\Utils\Hex;
use InvalidArgumentException;

class Factory extends Web3
{
    /**
     * Current network.
     *
     * @var array{rpc_url: string, multicall: array{address: Hex|string, try_aggregate?: bool}, provider: Provider|string}
     */
    protected array $network;

    /**
     * Create a new Web3 instance.
     *
     * @param null|Provider|string $network
     */
    public function __construct(Provider|string|null $network = null)
    {
        if (is_string($network)) {
            $this->setNetwork($network);
        }

        if ($network instanceof Provider) {
            parent::__construct($network);
        }
    }

    /**
     * Set the network for current instance.
     *
     * @param string $name
     *
     * @return static
     */
    public function setNetwork(string $name): static
    {
        $network = config("web3.networks.{$name}");

        if (empty($network)) {
            throw new InvalidArgumentException("Unsupported network: {$name}.");
        }

        $this->network = $network;

        if (empty($network['provider']['class']) && !empty($network['rpc_url'])) {
            $network['provider'] = Provider::from([
                'rpc_url' => $network['rpc_url'],
                'options' => $network['provider']['options'] ?? [],
            ]);
        }

        $this->setProvider($network['provider']);
        $this->setMulticallAddress($network['multicall']['address']);

        return $this;
    }

    /**
     * Set the provider for current instance.
     *
     * @param array<mixed>|Provider $provider
     *
     * @return static
     */
    public function setProvider(Provider|array $provider): static
    {
        if (is_array($provider)) {
            if (empty($provider['class']) || !is_subclass_of($provider['class'], Provider::class)) {
                throw new InvalidArgumentException("Unsupported provider: {$provider['class']}.");
            }

            $provider = $provider['class']::from($provider['options']);
        }

        return parent::setProvider($provider);
    }

    /**
     * Create a new multicall instance.
     *
     * @param null|Hex|string $address
     * @param bool            $tryAggregate
     *
     * @return Multicall
     */
    public function newMulticall(Hex|string|null $address = null, bool $tryAggregate = false): Multicall
    {
        if (empty($address) && !$tryAggregate) {
            $tryAggregate = $this->network['multicall']['try_aggregate'] ?? false;
        }

        return parent::newMulticall($address, $tryAggregate);
    }
}
