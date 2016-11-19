<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default settings for laralang
    |--------------------------------------------------------------------------
    */
    'default'   => [
        'translator'     => 'mymemory',
        'debug'          => false,
        'from_lang'      => 'en',
        'to_lang'        => 'app_locale',
        'prefix'         => 'laralang',
        'middleware'     => Aitor24\Laralang\Middleware\LaralangMiddleware::class,
        'password'       => 'laralangAdmin',
    ],
];
