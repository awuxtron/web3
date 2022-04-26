<?php

namespace Awuxtron\Web3\Exceptions;

use Psr\Http\Message\ResponseInterface;

/**
 * @extends ProviderException<\Awuxtron\Web3\Providers\HttpProvider>
 */
class HttpProviderException extends ProviderException
{
    /**
     * The response instance.
     */
    public ResponseInterface $response;

    /**
     * Create a new exception instance.
     */
    public function __construct(string|ResponseInterface $message = '', int $code = 0)
    {
        if ($message instanceof ResponseInterface) {
            $this->response = $message;
            $code = $message->getStatusCode();
            $message = $this->getResponseMessage($message);
        }

        parent::__construct($message, $code);
    }

    /**
     * Get the response object.
     */
    public function getResponse(): ?ResponseInterface
    {
        return $this->response ?? null;
    }

    /**
     * Get the exception message from the response object.
     */
    protected function getResponseMessage(ResponseInterface $response): string
    {
        $message = "HTTP request returned status code {$response->getStatusCode()}";
        $summary = $response->getReasonPhrase();

        return $summary == '' ? $message : $message . ":\n{$summary}\n";
    }
}
