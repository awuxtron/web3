<?php

use Awuxtron\Web3\Providers\HttpProvider;

return [
    'default' => env('WEB3_NETWORK', 'mainnet'),

    'networks' => [
        'mainnet' => [
            'rpc_url' => 'https://mainnet.infura.io/v3/',
            'provider' => 'http',
            'multicall' => [
                'address' => '0x5BA1e12693Dc8F9c48aAD8770482f4739bEeD696',
                'try_aggregate' => false,
            ],
        ],
    ],

    'providers' => [
        'http' => [
            'class' => HttpProvider::class,
            'options' => [],
        ],
    ],
];
