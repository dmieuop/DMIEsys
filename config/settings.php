<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    |
    |
    |
    */
    'system' => [
        'version' => env('APP_VERSION', 'v2.0.0'),
        'path' => env('APP_PUBLIC_PATH', public_path() . '\\'),
        'main_site' => env('ENABLE_MAIN_SITE', false),
    ],


];
