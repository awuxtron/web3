<?php

namespace Awuxtron\Web3;

use Awuxtron\Web3\Multicall\Multicall;
use Awuxtron\Web3\Types\EthereumType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class Web3ServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/web3.php', 'web3');

        $this->app->singleton('web3', function () {
            $provider = config('web3.provider');
            $rpcUrl = config('web3.rpc_url');

            // @phpstan-ignore-next-line
            return new Web3(new $provider($rpcUrl));
        });

        $this->app->singleton('web3.multicall', function () {
            return new Multicall($this->app->get('web3'), config('web3.multicall.address'), config('web3.multicall.try_aggregate'));
        });
    }

    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        $this->registerCustomValidationRules();
        $this->registerPublishing();
    }

    /**
     * Register the package custom validation rules.
     */
    protected function registerCustomValidationRules(): void
    {
        Validator::extend('ethereum', static function ($attribute, $value, $parameters, $validator) {
            $type = implode(',', $parameters);

            $validator->addReplacer('ethereum', static fn ($message) => str_replace(':type', $type, $message));

            return EthereumType::resolve($type)->validate($value, false);
        });
    }

    /**
     * Register the package's publishable resources.
     */
    private function registerPublishing(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/web3.php' => config_path('web3.php'),
            ], 'web3-config');
        }
    }
}
