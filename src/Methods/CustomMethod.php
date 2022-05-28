<?php

namespace Awuxtron\Web3\Methods;

abstract class CustomMethod
{
    final public function __construct(protected \Awuxtron\Web3\Web3 $web3)
    {
    }

    /**
     * @param array<mixed> $params
     */
    abstract public function __invoke(array $params): mixed;
}
