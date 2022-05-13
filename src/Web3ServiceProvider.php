<?php

namespace Awuxtron\Web3;

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
            return (new Factory)->setNetwork(config('web3.default'));
        });

        $this->app->singleton('web3.multicall', function () {
            return $this->app->get('web3')->multicall();
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
