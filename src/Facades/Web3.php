<?php

namespace Awuxtron\Web3\Facades;

use Illuminate\Support\Facades\Facade;

class Web3 extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'web3';
    }
}
