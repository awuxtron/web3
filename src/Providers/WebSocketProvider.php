<?php

namespace Awuxtron\Web3\Providers;

use Awuxtron\Web3\Exceptions\JsonRpcResponseException;
use Awuxtron\Web3\Exceptions\ProviderException;
use Awuxtron\Web3\Exceptions\WebSocketProviderException;
use Awuxtron\Web3\JsonRPC\Request;
use Awuxtron\Web3\JsonRPC\Response;
use Exception;
use JsonException;
use Ratchet\Client\Connector;
use Ratchet\Client\WebSocket;
use Ratchet\RFC6455\Messaging\MessageInterface;
use function React\Async\await;
use React\EventLoop\Loop;
use React\EventLoop\LoopInterface;
use React\Promise\Promise;
use React\Promise\PromiseInterface;
use React\Socket\Connector as ReactConnector;
use Throwable;

class WebSocketProvider extends Provider
{
    /**
     * The React connector instance.
     */
    protected ReactConnector $reactConnector;

    /**
     * The React event loop instance.
     *
     * @var LoopInterface
     */
    protected LoopInterface $eventLoop;

    /**
     * The connector instance.
     *
     * @var Connector
     */
    protected Connector $connector;

    /**
     * Create a new websocket provider instance.
     *
     * @param string               $url     the provider url
     * @param array<string, mixed> $options the request options
     */
    public function __construct(protected string $url, protected array $options = [])
    {
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
     * Send a batch of requests.
     *
     * @param Request[] $requests
     *
     * @throws JsonRpcResponseException
     * @throws Throwable
     * @throws JsonException
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
     * Send the request to the provider.
     *
     * @param Request $request
     *
     * @throws Throwable
     * @throws JsonRpcResponseException
     * @throws JsonException
     *
     * @return Response
     */
    public function send(Request $request): Response
    {
        return new Response($this->sendRequest($request->getRequestData()));
    }

    /**
     * Get the React connector options.
     *
     * @return array<mixed>
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Keep provider connect and run any actions after connected.
     *
     * @param callable(\Awuxtron\Web3\Utils\WebSocket): mixed $callback
     *
     * @throws ProviderException
     */
    public function listening(callable $callback): void
    {
        if (PHP_SAPI != 'cli') {
            throw new ProviderException('Can only listening when script run in console.');
        }

        $this->onConnected(fn (WebSocket $socket) => $callback(new \Awuxtron\Web3\Utils\WebSocket($socket)));
    }

    /**
     * Send a single request to websocket server.
     *
     * @param array<mixed> $data
     *
     * @throws Throwable
     * @throws JsonException
     *
     * @return array<mixed>
     */
    protected function sendRequest(array $data): array
    {
        $result = await(
            $this->onConnected(function (WebSocket $socket) use ($data) {
                $promise = new Promise(function ($resolve) use ($socket) {
                    $socket->once('message', function (MessageInterface $message) use ($resolve, $socket) {
                        $resolve($message->getContents());

                        $socket->close();
                    });
                });

                $socket->on('close', function ($code = null, $reason = null) {
                    if ($code == 1000) {
                        return;
                    }

                    throw new WebSocketProviderException($reason, $code);
                });

                $socket->send(json_encode($data, JSON_THROW_ON_ERROR));

                return $promise;
            })
        );

        $result = trim(substr($result, (int) strpos($result, '{')));

        if (str_ends_with($result, ']')) {
            $result = '[' . $result;
        }

        return json_decode($result, true, 512, JSON_THROW_ON_ERROR | JSON_BIGINT_AS_STRING);
    }

    /**
     * Send the websocket request.
     *
     * @param callable $callback
     *
     * @return PromiseInterface
     */
    protected function onConnected(callable $callback): PromiseInterface
    {
        $subProtocols = $this->options['sub_protocols'] ?? [];
        $headers = array_merge(['Content-Type' => 'application/json'], $this->options['headers'] ?? []);

        $onFulfilled = fn (WebSocket $socket) => $callback($socket);

        return $this->getConnector()($this->url, $subProtocols, $headers)->then($onFulfilled, function (Exception $e) {
            $this->getEventLoop()->stop();

            throw $e;
        });
    }

    /**
     * Get the connector instance.
     *
     * @return Connector
     */
    protected function getConnector(): Connector
    {
        return $this->connector ?? ($this->connector = new Connector(
            $this->getEventLoop(),
            $this->getReactConnector()
        ));
    }

    /**
     * Get the React event loop instance.
     *
     * @return LoopInterface
     */
    protected function getEventLoop(): LoopInterface
    {
        return $this->eventLoop ?? ($this->eventLoop = Loop::get());
    }

    /**
     * Get the React connector instance.
     *
     * @return ReactConnector
     */
    protected function getReactConnector(): ReactConnector
    {
        return $this->reactConnector ?? ($this->reactConnector = new ReactConnector($this->getOptions()));
    }
}
