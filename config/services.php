<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
    'client_id' => '216223718844941',
    'client_secret' => 'a4643961a0cd23db460660cdffc5a8f5',
    'redirect' => 'http://localhost:8000/facebook/callback',
    ],

    'google' => [
    'client_id' => '19239865167-rjaqf4rq71bh4ck8s3k08o9ll3jqolb7.apps.googleusercontent.com',
    'client_secret' => 'hWdoZiQm1MiCFuOUAKsJvAbf',
    'redirect' => 'http://localhost:8000/auth/google/callback',
    ],
];
