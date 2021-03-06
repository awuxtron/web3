<?php

namespace Awuxtron\Web3;

use Awuxtron\Web3\ABI\JsonInterface;
use Awuxtron\Web3\Contracts\Contract;
use Awuxtron\Web3\JsonRPC\Request;
use Awuxtron\Web3\Methods\CustomMethod;
use Awuxtron\Web3\Methods\Method;
use Awuxtron\Web3\Methods\MethodNamespace;
use Awuxtron\Web3\Multicall\Multicall;
use Awuxtron\Web3\Providers\Provider;
use Awuxtron\Web3\Utils\Hex;
use BadMethodCallException;
use InvalidArgumentException;

/**
 * @mixin Methods\Web3
 *
 * @property Methods\Eth  $eth
 * @property Methods\Net  $net
 * @property Methods\Shh  $shh
 * @property Methods\Web3 $web3
 *
 * @method Methods\Eth  eth()
 * @method Methods\Net  net()
 * @method Methods\Shh  shh()
 * @method Methods\Web3 web3()
 */
class Web3
{
    /**
     * The list of supported namespace classes.
     *
     * @var array<string,class-string<MethodNamespace>>
     */
    protected static array $namespaces = [
        'eth' => Methods\Eth::class,
        'net' => Methods\Net::class,
        'shh' => Methods\Shh::class,
        'web3' => Methods\Web3::class,
    ];

    /**
     * The provider.
     */
    protected Provider $provider;

    /**
     * Determine if the method function will return request instead of call.
     */
    protected bool $expectsRequest = false;

    /**
     * The method namespace.
     */
    protected string $methodNamespace = 'web3';

    /**
     * The multicall address.
     */
    protected Hex $multicallAddress;

    /**
     * Create a new Web3 instance.
     *
     * @param Provider|string $provider
     * @param array<mixed>    $options  the provider options
     */
    public function __construct(Provider|string $provider, array $options = [])
    {
        if (is_string($provider)) {
            $provider = Provider::from(['rpc_url' => $provider, 'options' => $options]);
        }

        $this->provider = $provider;
    }

    /**
     * Determine or call a Web3 method.
     *
     * @param string       $name
     * @param array<mixed> $arguments
     *
     * @return mixed|static
     */
    public function __call(string $name, array $arguments): mixed
    {
        if (str_contains($name, '_')) {
            [$namespace, $method] = explode('_', $name);

            if (array_key_exists($namespace, static::$namespaces)) {
                // @phpstan-ignore-next-line
                return $this->{$namespace}()->{$method}($arguments);
            }
        }

        if (array_key_exists($name, static::$namespaces)) {
            $web3 = clone $this;
            $web3->methodNamespace = $name;

            return $web3;
        }

        $namespaceClass = static::$namespaces[$this->methodNamespace];
        $customMethods = $namespaceClass::getCustomMethods();
        $namespace = rtrim($namespaceClass::getNamespace(), '\\') . '\\';

        /** @var class-string<Method> $class */
        $class = array_key_exists($name, $customMethods) ? $customMethods[$name] : $namespace . ucfirst($name);

        return $this->method($class, $arguments);
    }

    /**
     * Call a web3 method as property.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        $call = function ($name) {
            $func = [$this, $name];

            if (!is_callable($func)) {
                throw new BadMethodCallException(sprintf('Unable to call method: %s.', $name));
            }

            return $func();
        };

        try {
            $instance = $call($name);
        } catch (InvalidArgumentException) {
            $fn = 'get' . ucfirst($name);

            if (str_contains($name, '_')) {
                $parsed = explode('_', $name, 2);

                if (count($parsed) == 2) {
                    $fn = $parsed[0] . '_get' . ucfirst($parsed[1]);
                }
            }

            $instance = $call($fn);
        }

        if ($instance instanceof Method) {
            return $instance->value();
        }

        return $instance;
    }

    /**
     * Extend the web3 instance or method namespace.
     *
     * @param string $name
     * @param string $value
     */
    public function __set(string $name, string $value): void
    {
        $namespace = $this->methodNamespace;

        if (str_contains($name, '_')) {
            [$namespace, $name] = explode('_', $name, 2);
        }

        if ($namespace == 'web3' && is_subclass_of($value, MethodNamespace::class)) {
            static::extend($name, $value);

            return;
        }

        if (!is_subclass_of($value, Method::class)) {
            throw new InvalidArgumentException(
                sprintf('The class: %s is not a subclass of %s.', $value, Method::class)
            );
        }

        static::$namespaces[$namespace]::extend($name, $value);
    }

    /**
     * Determines if the method exists.
     *
     * @param string $name
     *
     * @return bool
     */
    public function __isset(string $name): bool
    {
        if (array_key_exists($name, static::$namespaces)) {
            return true;
        }

        $namespace = $this->methodNamespace;

        if (str_contains($name, '_')) {
            [$namespace, $name] = explode('_', $name, 2);
        }

        $namespace = static::$namespaces[$namespace];

        if (array_key_exists($name, $namespace::getCustomMethods())) {
            return true;
        }

        $prefix = rtrim($namespace::getNamespace(), '\\') . '\\';

        return is_subclass_of($prefix . ucfirst($name), Method::class);
    }

    /**
     * Register a custom method namespace.
     *
     * @phpstan-param class-string<MethodNamespace> $class
     */
    public static function extend(string $namespace, string $class): void
    {
        static::$namespaces[$namespace] = $class;
    }

    /**
     * Determine or call a Web3 method.
     *
     * @template TMethod of Method
     * @phpstan-param class-string<TMethod> $class
     *
     * @param TMethod      $class
     * @param array<mixed> $params
     *
     * @return TMethod|array{class-string<TMethod>,Request}
     */
    public function method(string $class, array $params = []): mixed
    {
        // Validate method class.
        if (!class_exists($class)) {
            throw new InvalidArgumentException(sprintf('The method: %s is not supported.', $class));
        }

        if (is_a($class, CustomMethod::class, true)) {
            return (new $class($this))($params);
        }

        if (!is_a($class, Method::class, true)) {
            throw new InvalidArgumentException(
                sprintf('The class: %s must be subclass of class: %s.', $class, Method::class)
            );
        }

        // Create a new request instance.
        $request = $class::modifyRequest(
            Request::create()->method(
                $class::getName(),
                $class::getParameters($params)
            )
        );

        if ($this->expectsRequest) {
            return [$class, $request];
        }

        return (new $class($this->provider->send($request)))->setRequest($request);
    }

    /**
     * Get the current provider.
     *
     * @return Provider
     */
    public function getProvider(): Provider
    {
        return $this->provider;
    }

    /**
     * Set the provider for current instance.
     *
     * @param Provider $provider
     *
     * @return static
     */
    public function setProvider(Provider $provider): static
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * Call a batch of Web3 requests.
     *
     * @param callable(static): array<int|string, mixed> $callback
     * @param bool                                       $returnValue
     *
     * @return array<mixed>
     */
    public function batch(callable $callback, bool $returnValue = false): array
    {
        // Create a new Web3 instance for batch request.
        $web3 = clone $this;
        $web3->expectsRequest = true;

        // Get classes and requests from the callback.
        $classes = [];
        $requests = [];

        foreach ($callback($web3) as $key => $method) {
            $classes[$key] = $method[0];
            $requests[$key] = $method[1];
        }

        // Call the batch request.
        $responses = $this->provider->batch($requests);

        array_walk($responses, static function (&$response, $key) use ($classes, $requests, $returnValue) {
            $instance = new $classes[$key]($response);

            assert($instance instanceof Method);

            $response = $instance->setRequest($requests[$key]);

            if ($returnValue) {
                $response = $response->value();
            }
        });

        return $responses;
    }

    /**
     * Create a new contract instance.
     *
     * @param array<mixed>|JsonInterface|string $abi
     * @param Hex|string                        $address
     *
     * @return Contract
     */
    public function contract(JsonInterface|string|array $abi, string|Hex $address): Contract
    {
        return new Contract($this, $abi, $address);
    }

    /**
     * Create a new multicall instance.
     *
     * @param mixed ...$args
     *
     * @phpstan-return mixed
     *
     * @return array<mixed>|Multicall
     */
    public function multicall(...$args): mixed
    {
        $args[0] ??= null;

        if (is_bool($args[0])) {
            return $this->newMulticall(tryAggregate: $args[0]);
        }

        if (is_array($args[0]) && !empty($args[0]) && count(
            array_filter($args[0], fn ($v) => $v instanceof Contracts\Method)
        ) == count($args[0])) {
            return $this->newMulticall()->call(...$args);
        }

        return $this->newMulticall(...$args);
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
        if (empty($address)) {
            $address = $this->multicallAddress;
        }

        return new Multicall($this, $address, $tryAggregate);
    }

    /**
     * @return bool
     */
    public function isExpectsRequest(): bool
    {
        return $this->expectsRequest;
    }

    /**
     * @param bool $expectsRequest
     *
     * @return static
     */
    public function setExpectsRequest(bool $expectsRequest): static
    {
        $this->expectsRequest = $expectsRequest;

        return $this;
    }

    /**
     * Set multicall address.
     */
    public function setMulticallAddress(Hex|string $multicallAddress): static
    {
        $this->multicallAddress = Hex::of($multicallAddress);

        return $this;
    }
}
