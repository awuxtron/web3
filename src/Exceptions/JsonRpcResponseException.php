<?php

namespace Awuxtron\Web3\Exceptions;

class JsonRpcResponseException extends JsonRpcException
{
    /**
     * The response data.
     *
     * @var array<mixed>
     */
    protected array $data;

    /**
     * Create a new exception instance.
     *
     * @param array{code: int, message: string}|string $message
     * @param int                                      $code
     */
    public function __construct(array|string $message = '', int $code = 0)
    {
        if (is_array($message)) {
            $code = $message['code'];
            $message = $message['message'];
        }

        parent::__construct($message, $code);
    }

    /**
     * Get the response data.
     *
     * @return array<mixed>
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Set the response data.
     *
     * @param array<mixed> $data
     *
     * @return static
     */
    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }
}
