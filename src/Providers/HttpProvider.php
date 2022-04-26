<?php

namespace Awuxtron\Web3\Providers;

use Awuxtron\Web3\Exceptions\HttpProviderException;
use Awuxtron\Web3\Exceptions\JsonRpcResponseException;
use Awuxtron\Web3\JsonRPC\Request;
use Awuxtron\Web3\JsonRPC\Response;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class HttpProvider extends Provider
{
    /**
     * The Guzzle client instance.
     */
    protected Client $client;

    /**
     * The request options.
     *
     * @var array<string, mixed>
     */
    protected array $options = [];

    /**
     * The HTTP request method.
     */
    protected string $requestMethod = 'POST';

    /**
     * Create a new HTTP provider instance.
     *
     * @param string               $url     the provider url
     * @param array<string, mixed> $options the request options
     *
     * @see https://docs.guzzlephp.org/en/stable/request-options.html
     */
    public function __construct(protected string $url, array $options = [])
    {
        $this->options = [
            'connect_timeout' => 10,
            'http_errors' => false,
            'timeout' => 30,
            ...$options,
        ];
    }

    /**
     * Use other HTTP method for current request.
     */
    public function useHttpMethod(string $method): static
    {
        $this->requestMethod = $method;

        return $this;
    }

    /**
     * Send the request to the provider.
     *
     * @throws HttpProviderException|JsonRpcResponseException
     */
    public function send(Request $request): Response
    {
        return new Response($this->sendRequest($request->getRequestData()));
    }

    /**
     * Send a batch of requests.
     *
     * @param Request[] $requests
     *
     * @throws HttpProviderException|JsonRpcResponseException
     *
     * @return Response[]
     */
    public function batch(array $requests): array
    {
        $data = array_map(static fn (Request $request) => $request->getRequestData(), $requests);

        $responses = array_map(
            static fn ($response) => new Response($response),
            $this->sendRequest(array_values($data))
        );

        return array_combine(array_keys($data), $responses);
    }

    /**
     * Get the Guzzle client.
     */
    public function getClient(): Client
    {
        return $this->client ?? ($this->client = new Client($this->getOptions()));
    }

    /**
     * Get the request options.
     *
     * @return array<mixed>
     */
    public function getOptions(): array
    {
        return [
            ...$this->options,
            'http_errors' => false,
        ];
    }

    /**
     * Get the HTTP request method.
     */
    public function getRequestMethod(): string
    {
        return strtoupper($this->requestMethod);
    }

    /**
     * @param array<mixed> $data
     *
     * @throws HttpProviderException
     *
     * @return array<mixed>
     */
    protected function sendRequest(array $data): array
    {
        $method = $this->getRequestMethod();

        try {
            $response = $this->getClient()->request($method, $this->url, [
                $method === 'GET' ? 'query' : 'json' => $data,
            ]);

            if ($response->getStatusCode() !== 200) {
                throw $this->exception($response);
            }

            return json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR | JSON_BIGINT_AS_STRING);
        } catch (GuzzleException|JsonException $e) {
            throw $this->exception($e);
        }
    }

    /**
     * Get an exception to throw.
     */
    protected function exception(ResponseInterface|Throwable $e): HttpProviderException
    {
        $message = match (get_class($e)) {
            GuzzleException::class => sprintf('Guzzle client returned an error: %s', $e->getMessage()), // @phpstan-ignore-line
            JsonException::class => sprintf('Unable to decode response body into array: %s', $e->getMessage()), // @phpstan-ignore-line
            default => $e,
        };

        $code = $e instanceof ResponseInterface ? $e->getStatusCode() : $e->getCode();

        return (new HttpProviderException($message, $code))->setProvider($this);
    }
}
