<?php
return [
    'parameters' => [
        'database' => [
            'driver' => 'mysql',
            'host' => getenv('DATABASE1_HOST'),
            'port' => getenv('DATABASE1_PORT'),
            'dbname' => getenv('DATABASE1_NAME'),
            'user' => getenv('DATABASE1_USER'),
            'password' => getenv('DATABASE1_PASS'),
        ],
        'redis' => [
            'host' => getenv('CACHE1_HOST'),
            'port' => getenv('CACHE1_PORT'),
        ]
    ],
];
