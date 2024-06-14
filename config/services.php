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

    'google' => [
        'client_id' => '799453836707-aj9lt08133ea19pqh56ed3b70tq9292c.apps.googleusercontent.com',
        'client_secret' => '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s',
        'redirect' => '/auth/google/callback',
        'analytics_id' => config('templatecookie.google_analytics'),
        'active' => true,
    ],

    'facebook' => [
        'client_id' => '',
        'client_secret' => '',
        'redirect' => '/auth/facebook/callback',
        'active' => false,
    ],

    'twitter' => [
        'client_id' => '',
        'client_secret' => '',
        'redirect' => '/auth/twitter/callback',
        'active' => false,
    ],

    'linkedin' => [
        'client_id' => '77v61asy42i1hb',
        'client_secret' => 'y1M5NE7u7e23bu6m',
        'redirect' => '/auth/linkedin/callback',
        'active' => true,
    ],

    'github' => [
        'client_id' => 'd981718bc6657f215589',
        'client_secret' => '833af7d3b653f378bd219528148ade71f5663f0f',
        'redirect' => '/auth/github/callback',
        'active' => true,
    ],
];
