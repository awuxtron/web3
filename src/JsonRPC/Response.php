<?php

namespace Awuxtron\Web3\JsonRPC;

use Awuxtron\Web3\Exceptions\JsonRpcResponseException;

class Response
{
    /**
     * Create a new response instance.
     *
     * @param array<mixed> $data
     *
     * @throws JsonRpcResponseException
     */
    public function __construct(public array $data)
    {
        if (!$this->isValidResponse($data)) {
            throw (new JsonRpcResponseException('The response data is not a valid JSON-RPC response.'))->setData($data);
        }

        if ($this->getError() != null) {
            throw (new JsonRpcResponseException($this->getError()))->setData($data);
        }
    }

    /**
     * Get the JSON-RPC version from the response.
     */
    public function getVersion(): string
    {
        return $this->data['jsonrpc'];
    }

    /**
     * Get the request ID from the response.
     */
    public function getId(): string
    {
        return $this->data['id'];
    }

    /**
     * Get the result from the response.
     */
    public function getResult(): mixed
    {
        $result = $this->data['result'];

        if ($result == '0x') {
            return null;
        }

        return $result;
    }

    /**
     * Get the error object from the response.
     *
     * @return null|array{code: int, message: string}
     */
    public function getError(): ?array
    {
        return $this->data['error'] ?? null;
    }

    /**
     * Check the array data is valid JSON-RPC response.
     *
     * @param array<mixed> $data
     *
     * @return bool
     */
    protected function isValidResponse(array $data): bool
    {
        if (array_key_exists('result', $data) && array_key_exists('error', $data)) {
            return false;
        }

        if (array_key_exists('error', $data) && (!array_key_exists('code', $data['error']) || !array_key_exists('message', $data['error']))) {
            return false;
        }

        return array_key_exists('jsonrpc', $data) && array_key_exists('id', $data);
    }
}
