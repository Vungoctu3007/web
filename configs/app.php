<?php
$config['app'] = [
    'routeMiddleware' => [
        'dang-nhap' => AuthMiddleware::class,
        'san-pham' => AuthMiddleware::class
    ],
    'globalMiddleware' => [
        ParamsMiddleware::class
    ],  
    'boot' => [
        AppServiceProvider::class
    ]
];