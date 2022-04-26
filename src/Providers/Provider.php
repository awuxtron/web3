<?php

namespace Awuxtron\Web3\Providers;

use Awuxtron\Web3\JsonRPC\Request;
use Awuxtron\Web3\JsonRPC\Response;

abstract class Provider
{
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
