<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'passport' => [
        'login_endpoint' => env('APP_API_URL') . '/oauth/token',
    ],

    'google' => [
        'package_name' => env('GOOGLE_PACKAGE_NAME'),
        'subscription_id' => env('GOOGLE_SUBSCRIPTION_ID')
    ],

    'apple' => [
        'store' => [
            'production' =>  env('APPLE_STORE_PRODUCTION_ENDPOINT'),
            'test' =>  env('APPLE_STORE_TEST_ENDPOINT'),
        ],
        'secret' => env('APPLE_SHARED_SECRET'),
    ],

];
