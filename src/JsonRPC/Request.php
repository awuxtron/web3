<?php

namespace Awuxtron\Web3\JsonRPC;

use InvalidArgumentException;
use JsonSerializable;

class Request implements JsonSerializable
{
    /**
     * The increment ID.
     */
    protected static int $incrementId = 1;

    /**
     * The request ID.
     */
    protected string $id;

    /**
     * The JSON-RPC method.
     */
    protected string $method;

    /**
     * The request parameters.
     *
     * @var array<mixed>
     */
    protected array $params = [];

    /**
     * Create a new JSON-RPC request instance.
     */
    public static function create(): static
    {
        // @phpstan-ignore-next-line
        return new static;
    }

    /**
     * Get the current request ID.
     */
    public function getId(): string
    {
        return $this->id ?? ($this->id = (string) (static::$incrementId++));
    }

    /**
     * Set the ID for current request.
     */
    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Determine method and parameters for the current request.
     *
     * @param array<mixed> $params
     */
    public function method(string $method, array $params = []): static
    {
        $this->method = $method;
        $this->params = $params;

        return $this;
    }

    /**
     * Get the current JSON-RPC method.
     */
    public function getMethod(): string
    {
        return $this->method ?? '';
    }

    /**
     * Get the request parameters.
     *
     * @return array<mixed>
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Get the JSON-RPC request data.
     *
     * @phpstan-return array{jsonrpc: '2.0', id: string, method: string, params: array<mixed>}
     */
    public function getRequestData(): array
    {
        $method = $this->getMethod();

        if ($method == '') {
            throw new InvalidArgumentException('The method must be specified for current request.');
        }

        return [
            'jsonrpc' => '2.0',
            'id' => $this->getId(),
            'method' => $method,
            'params' => $this->getParams(),
        ];
    }

    /**
     * Get the JSON serializable representation of the request.
     *
     * @phpstan-return array{jsonrpc: '2.0', id: string, method: string, params: array<mixed>}
     */
    public function jsonSerialize(): array
    {
        return $this->getRequestData();
    }
}
