<?php

use Awuxtron\Web3\Factory;
use Awuxtron\Web3\Multicall\Multicall;
use Awuxtron\Web3\Providers\HttpProvider;

test('load web3 config from provider', function () {
    expect(config('web3'))->toBeArray();
});

test('bind web3 instance', function () {
    $web3 = app('web3');

    expect($web3)->toBeInstanceOf(Factory::class);
    expect($web3->getProvider())->toBeInstanceOf(HttpProvider::class);
});

test('bind multicall instance', function () {
    expect(app('web3.multicall'))->toBeInstanceOf(Multicall::class);
});

test('web3 validation rule', function () {

});
