<?php

namespace Awuxtron\Web3\Providers;

use Awuxtron\Web3\Exceptions\JsonRpcResponseException;
use Awuxtron\Web3\Exceptions\WebSocketProviderException;
use Awuxtron\Web3\JsonRPC\Request;
use Awuxtron\Web3\JsonRPC\Response;
use Awuxtron\Websocket\Enums\Opcode;
use Awuxtron\Websocket\Exceptions\BadMessageException;
use Awuxtron\Websocket\Options;
use Awuxtron\Websocket\Websocket;
use JsonException;

class WebSocketProvider extends Provider
{
    /**
     * The websocket instance.
     *
     * @var Websocket
     */
    protected Websocket $ws;

    /**
     * Create a new websocket provider instance.
     *
     * @param string               $url     the provider url
     * @param array<string, mixed> $options the request options, see {@see Options} for list of available options
     */
    public function __construct(protected string $url, protected array $options = [])
    {
        $this->options = array_replace_recursive(
            ['headers' => ['Accept' => 'application/json', 'Content-Type' => 'application/json']],
            $options
        );
    }

    /**
     * Create a new provider instance from array of options.
     *
     * @param array<mixed> $options
     *
     * @return static
     */
    public static function from(array $options): static
    {
        return new static($options['rpc_url'], $options['options']);
    }

    /**
     * Send the request to the provider.
     *
     * @param Request $request
     *
     * @throws BadMessageException
     * @throws JsonException
     * @throws WebSocketProviderException
     * @throws JsonRpcResponseException
     * @return Response
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
     * @throws BadMessageException
     * @throws JsonException
     * @throws JsonRpcResponseException
     * @throws WebSocketProviderException
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
     * Send a single request to websocket server.
     *
     * @param array<mixed> $data
     *
     * @throws JsonException
     * @throws WebSocketProviderException
     * @throws BadMessageException
     * @return array<mixed>
     */
    protected function sendRequest(array $data): array
    {
        $this->getWebsocket()->send(json_encode($data, JSON_THROW_ON_ERROR));

        $response = $this->getWebsocket()->read();

        if ($response->getOpcode() == Opcode::CLOSE) {
            throw new WebSocketProviderException($response->getPayload(), $response->getCloseStatus()?->value ?? 0);
        }

        return json_decode($response->getPayload(), true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * Get the websocket instance.
     *
     * @return Websocket
     */
    protected function getWebsocket(): Websocket
    {
        return $this->ws ?? $this->ws = ws($this->url, $this->options);
    }
}
