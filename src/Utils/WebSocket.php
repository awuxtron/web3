<?php

namespace Awuxtron\Web3\Utils;

use Awuxtron\Web3\JsonRPC\Request;
use Awuxtron\Web3\JsonRPC\Response;
use Awuxtron\Web3\Methods\Method;
use Ratchet\RFC6455\Messaging\MessageInterface;
use React\Promise\Promise;
use Throwable;
use function React\Async\await;

class WebSocket
{
    /**
     * Create a new websocket helper instance.
     *
     * @param \Ratchet\Client\WebSocket $socket
     */
    public function __construct(protected \Ratchet\Client\WebSocket $socket)
    {
    }

    /**
     * Send message to provider and receive the result.
     *
     * @param mixed $data
     * @param bool  $decodeRpcMethod
     *
     * @throws Throwable
     *
     * @return mixed
     */
    public function sendAndReceive(mixed $data, bool $decodeRpcMethod = true): mixed
    {
        $promise = new Promise(function ($resolve) {
            $this->socket->on('message', function (MessageInterface $message) use ($resolve) {
                $resolve((string) $message);
            });
        });

        $decoder = fn ($v) => $v;

        if (is_array($data)) {
            if (count($data) == 2 && array_is_list($data)) {
                $isRpcRequest = is_subclass_of($data[0], Method::class) && $data[1] instanceof Request;

                if ($isRpcRequest) {
                    /** @var array{Method, Request} $data */

                    /**
                     * Decode value to method.
                     */
                    $decoder = function (string $value) use ($data, $decodeRpcMethod) {
                        $result = (new $data[0](new Response(Json::decode($value))))->setRequest($data[1]);

                        return $decodeRpcMethod ? $result->value() : $result;
                    };

                    $data = $data[1]->getRequestData();
                }
            }

            $data = Json::encode($data);
        }

        $this->socket->send($data);

        return $decoder(await($promise));
    }

    /**
     * Send a batch of web3 requests to provider.
     *
     * @param array<mixed> $methods
     * @param bool         $returnValue
     *
     * @throws Throwable
     *
     * @return array<mixed>
     */
    public function web3Batch(array $methods, bool $returnValue = true): array
    {
        $ids = array_map(fn ($v) => $v[1]->getId(), $methods);
        $keys = array_combine($ids, array_keys($methods));

        // Get responses from provider.
        $responses = Json::decode(
            $this->sendAndReceive(
                array_map(fn ($method) => $method[1]->getRequestData(), array_values($methods))
            )
        );

        // Map responses to method object.
        $result = [];

        foreach ($responses as $response) {
            /** @var array{Method, Request} $method */
            $method = $methods[$key = $keys[$response['id']]];
            $method = (new $method[0](new Response($response)))->setRequest($method[1]);

            if ($returnValue) {
                $method = $method->value();
            }

            $result[$key] = $method;
        }

        return $result;
    }

    /**
     * Close the current connection.
     *
     * @param null|callable $callback
     * @param int           $code
     * @param string        $reason
     */
    public function close(?callable $callback = null, int $code = 1000, string $reason = ''): void
    {
        if (is_callable($callback)) {
            $this->socket->on('close', $callback);
        }

        $this->socket->close($code, $reason);
    }
}
