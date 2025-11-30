<?php

return [
    /*
    |--------------------------------------------------------------------------
    | WABLAS Token
    |--------------------------------------------------------------------------
    |
    | This value is the token that get from WABLAS
    */
    'token' => env('9fh0ZS1bjWwn6fD016NZhBl41go4HqGVLzwc0kn5l6qIlLCKd6LrCOQ', null),

    /*
    |--------------------------------------------------------------------------
    | WABLAS URL
    |--------------------------------------------------------------------------
    |
    | This values is the URL subdomain from WABLAS.
    | If your domain is https://bandung.wablas.com, only input "bandung" as the URL
    */
    'server' => env('WABLAS_URL', 'surabaya'),

    /*
    |--------------------------------------------------------------------------
    | DEBUG NUMBER
    |--------------------------------------------------------------------------
     */
    'debug_number' => env('WABLAS_DEBUG_NUMBER', null),
];
