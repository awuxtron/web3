<?php

namespace Awuxtron\Web3\Methods\Eth;

use Awuxtron\Web3\Methods\CustomMethod;

class Subscribe extends CustomMethod
{
    public function __invoke(array $params): mixed
    {
        dd($params);
    }
}
