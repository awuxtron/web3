<?php

use Awuxtron\Web3\Providers\HttpProvider;
use Awuxtron\Web3\Providers\InfuraProvider;

return [
    'default' => env('WEB3_NETWORK', 'mainnet'),

    'networks' => [
        'mainnet' => [
            'provider' => [
                'class' => InfuraProvider::class,
                'options' => [
                    'scheme' => env('INFURA_SCHEME'),
                    'network' => env('INFURA_NETWORK'),
                    'version' => env('INFURA_VERSION', 'v3'),
                    'id' => env('INFURA_PROJECT_ID'),
                    'secret' => env('INFURA_PROJECT_SECRET'),
                    'jwt' => env('INFURA_PROJECT_JWT'),
                ],
            ],
            'multicall' => [
                'address' => '0x5BA1e12693Dc8F9c48aAD8770482f4739bEeD696',
                'try_aggregate' => false,
            ],
        ],
        'bsc' => [
            'provider' => [
                'class' => HttpProvider::class,
                'options' => [
                    'rpc_url' => env('BSC_RPC_URL', 'https://bsc-dataseed.binance.org/'),
                ],
            ],
            'multicall' => [
                'address' => '0xC50F4c1E81c873B2204D7eFf7069Ffec6Fbe136D',
                'try_aggregate' => false,
            ],
        ],
    ],
];
