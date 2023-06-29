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

    'emails' => [
        'office' => env('MAIL_RECIPIENT', 'myemail@email.com'),
        'developer' => env('MAIL_OF_THE_DEV', 'myemail@email.com'),
    ],

    'booking' => [
        'max_days' => env('BOOKING_MAX_DAYS', 14),
        'min_days' => env('BOOKING_MIN_DAYS', 3),
    ],

    'starting_times' => [
        '08:00',
        '08:30',
        '09:00',
        '09:30',
        '10:00',
        '10:30',
        '11:00',
        '11:30',
        '13:00',
        '13:30',
        '14:00',
        '14:30',
        '15:00',
        '15:30',
        '16:00',
        '16:30',
    ],

    'ending_times' => [
        '08:29',
        '08:59',
        '09:29',
        '09:59',
        '10:29',
        '10:59',
        '11:29',
        '11:59',
        '13:29',
        '13:59',
        '14:29',
        '14:59',
        '15:29',
        '15:59',
        '16:29',
        '16:59',
    ]


];
