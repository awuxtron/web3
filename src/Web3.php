<?php

namespace Awuxtron\Web3;

use Awuxtron\Web3\ABI\JsonInterface;
use Awuxtron\Web3\Contracts\Contract;
use Awuxtron\Web3\JsonRPC\Request;
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
     * Determine if the method function will return request instead of call.
     */
    protected bool $expectsRequest = false;

    /**
     * The method namespace.
     */
    protected string $methodNamespace = 'web3';

    /**
     * Create a new Web3 instance.
     *
     * @param Provider $provider
     */
    final public function __construct(protected Provider $provider)
    {
    }

    /**
     * Determine or call a Web3 method.
     *
     * @param string       $name
     * @param array<mixed> $arguments
     *
     * @return mixed|static
     */
    public function __call(string $name, array $arguments)
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

            return call_user_func($func);
        };

        try {
            $instance = $call($name);
        } catch (InvalidArgumentException) {
            $instance = $call('get' . ucfirst($name));
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
     * Register a custom method namespace.
     *
     * @phpstan-param class-string<MethodNamespace> $class
     */
    public static function extend(string $namespace, string $class): void
    {
        static::$namespaces[$namespace] = $class;
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
     * Get the current provider.
     *
     * @return Provider
     */
    public function getProvider(): Provider
    {
        return $this->provider;
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

        if (!is_a($class, Method::class, true)) {
            throw new InvalidArgumentException(sprintf('The class: %s must be subclass of class: %s.', $class, Method::class));
        }

        // Create a new request instance.
        $request = $class::modifyRequest(Request::create()->method(
            $class::getName(),
            $class::getParameters($params)
        ));

        if ($this->expectsRequest) {
            return [$class, $request];
        }

        return (new $class($this->provider->send($request)))->setRequest($request);
    }

    /**
     * Call a batch of Web3 requests.
     *
     * @param callable(static): array<int|string, mixed> $callback
     *
     * @return array<int|string,Method>
     */
    public function batch(callable $callback): array
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

        array_walk($responses, static function (&$response, $key) use ($classes, $requests) {
            /** @var Method $instance */
            $instance = new $classes[$key]($response);

            $response = $instance->setRequest($requests[$key]);
        });

        // @phpstan-ignore-next-line
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
     * @param Hex|string $address
     * @param bool       $tryAggregate
     *
     * @return Multicall
     */
    public function multicall(Hex|string $address, bool $tryAggregate = false): Multicall
    {
        return new Multicall($this, $address, $tryAggregate);
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
     * @return bool
     */
    public function isExpectsRequest(): bool
    {
        return $this->expectsRequest;
    }
}
