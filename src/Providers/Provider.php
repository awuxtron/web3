<?php

namespace Awuxtron\Web3\Providers;

use Awuxtron\Web3\JsonRPC\Request;
use Awuxtron\Web3\JsonRPC\Response;
use InvalidArgumentException;

abstract class Provider
{
    /**
     * Create a new provider instance from array of options.
     *
     * @param array<mixed> $options
     *
     * @return Provider
     */
    public static function from(array $options): Provider
    {
        if (empty($options['rpc_url'])) {
            throw new InvalidArgumentException('rpc_url must be provide.');
        }

        $scheme = parse_url($options['rpc_url'], PHP_URL_SCHEME);

        if (in_array($scheme, ['http', 'https'], true)) {
            return HttpProvider::from($options);
        }

        if (in_array($scheme, ['ws', 'wss'], true)) {
            return WebSocketProvider::from($options);
        }

        throw new InvalidArgumentException("Scheme not supported: {$scheme}.");
    }

    /**
     * Send the request to the provider.
     */
    abstract public function send(Request $request): Response;

    /**
     * Send a batch of requests.
     *
     * @param Request[] $requests
     *
     * @return Response[]
     */
    abstract public function batch(array $requests): array;
}
