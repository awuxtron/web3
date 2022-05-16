<?php

namespace Awuxtron\Web3\Tests;

use Awuxtron\Web3\Facades\Multicall;
use Awuxtron\Web3\Facades\Web3;
use Awuxtron\Web3\Web3ServiceProvider;
use Illuminate\Foundation\Application;

/**
 * @internal
 * @coversNothing
 */
class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Get package providers.
     *
     * @param Application $app
     *
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [Web3ServiceProvider::class];
    }

    /**
     * Override application aliases.
     *
     * @param Application $app
     *
     * @return array<string, class-string>
     */
    protected function getPackageAliases($app): array
    {
        return [
            'Web3' => Web3::class,
            'Multicall' => Multicall::class,
        ];
    }
}
