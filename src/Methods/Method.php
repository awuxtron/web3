<?php

namespace Awuxtron\Web3\Methods;

use Awuxtron\Web3\JsonRPC\Response;
use InvalidArgumentException;

abstract class Method
{
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
        return [];
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
     * Check required arguments.
     *
     * @param array<mixed> $params
     * @param int          $count
     */
    protected static function requiredArgs(array $params, int $count): void
    {
        if (($provided = count($params)) < $count) {
            throw new InvalidArgumentException(sprintf(
                'Method %s expects %d parameters, %d provided.',
                static::getName(),
                $count,
                $provided
            ));
        }
    }
}
