<?php

namespace Awuxtron\Web3\Methods;

use Awuxtron\Web3\JsonRPC\Request;
use Awuxtron\Web3\JsonRPC\Response;
use Awuxtron\Web3\Types\Boolean;
use Awuxtron\Web3\Types\EthereumType;
use Awuxtron\Web3\Types\Str;
use Awuxtron\Web3\Utils\Hex;
use BadMethodCallException;
use InvalidArgumentException;

abstract class Method
{
    /**
     * The request instance.
     *
     * @var Request
     */
    protected Request $request;

    /**
     * Create a new method instance.
     *
     * @param Response $response
     */
    final public function __construct(protected Response $response)
    {
    }

    /**
     * Get the JSON-RPC method name of this method.
     */
    public static function getName(): string
    {
        [$namespace, $method] = array_slice(explode('\\', static::class), -2, 2);

        return strtolower($namespace) . '_' . lcfirst($method);
    }

    /**
     * Returns validated parameters.
     *
     * @param array<mixed> $params
     *
     * @return array<mixed>
     */
    public static function getParameters(array $params): array
    {
        $schemas = static::getParametersSchema();

        if (empty($schemas)) {
            return [];
        }

        if (array_is_list($params)) {
            $schemas = array_values($schemas);
        }

        foreach ($schemas as $key => $schema) {
            if (!isset($params[$key]) && $schema['default'] !== null) {
                $params[$key] = $schema['default'];
            }

            // Check required param.
            if (!array_key_exists($key, $params)) {
                throw new InvalidArgumentException(sprintf(
                    'Parameter #%s of method %s is required.',
                    $key,
                    static::getName()
                ));
            }

            foreach ($schema['type'] as $type) {
                $type = EthereumType::resolve($type);

                if (!$type->validate($params[$key], false)) {
                    continue;
                }

                if ($type instanceof Boolean || $type instanceof Str) {
                    $formatted = $type->validated($params[$key]);
                } else {
                    $func = [$type, $m = 'encode'];

                    if (method_exists($type, 'encodeToArray')) {
                        $func = [$type, $m = 'encodeToArray'];
                    }

                    if (!is_callable($func)) {
                        throw new BadMethodCallException(
                            sprintf('Unable to call method: %s in class %s.', $m, get_class($type))
                        );
                    }

                    $formatted = call_user_func_array($func, [$params[$key], false, false]);
                }

                if ($formatted instanceof Hex) {
                    $formatted = $formatted->prefixed();
                }
            }

            if (!isset($formatted)) {
                throw new InvalidArgumentException(sprintf(
                    'Parameter #%s must be of types: %s.',
                    $key,
                    implode('|', $schema['type'])
                ));
            }

            $params[$key] = $formatted;
        }

        return array_values($params);
    }

    /**
     * Modify the request instance before send.
     *
     * @param Request $request
     *
     * @return Request
     */
    public static function modifyRequest(Request $request): Request
    {
        return $request;
    }

    /**
     * Get the raw method result.
     */
    public function raw(): mixed
    {
        return $this->response->getResult();
    }

    /**
     * Get the formatted method result.
     */
    public function value(): mixed
    {
        return $this->raw();
    }

    /**
     * Get the request instance.
     *
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * Set the request instance.
     *
     * @param Request $request
     *
     * @return static
     */
    public function setRequest(Request $request): static
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Get the parameter schemas for this method.
     *
     * @return array<string, array{type: mixed, default: mixed, description: mixed}>
     */
    protected static function getParametersSchema(): array
    {
        return [];
    }

    /**
     * The parameter schema.
     *
     * @param mixed      $type
     * @param null|mixed $default
     * @param string     $description
     *
     * @return array{type: mixed, default: mixed, description: mixed}
     */
    protected static function schema(mixed $type, mixed $default = null, string $description = ''): array
    {
        if (!is_array($type)) {
            $type = [$type];
        }

        return [
            'type' => $type,
            'default' => $default,
            'description' => $description,
        ];
    }
}
