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

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'sms' => [
        'api_url' => env('SMS_API_URL'),
        'api_key' => env('SMS_API_KEY'),
        'api_key_header' => env('SMS_API_KEY_HEADER', 'Authorization'),
        'payload_extra' => [],
    ],

    /*
    | REVE SMS (same gateway as UGVOS — HTTP only, do not use https://)
    | Used for registration/campaign SMS when configured (preferred over SMS_API_*).
    */
    'reve_sms' => [
        'api_key' => env('REVE_SMS_API_KEY'),
        'secret_key' => env('REVE_SMS_SECRET_KEY'),
        'caller_id' => env('REVE_SMS_CALLER_ID'),
        'base_url' => env('REVE_SMS_BASE_URL', 'http://sms.sasbulksms.com:3040'),
        'timeout' => env('REVE_SMS_TIMEOUT', 30),
    ],

    'turnstile' => [
        'site_key' => env('TURNSTILE_SITE_KEY', env('APP_ENV') === 'local' ? '1x00000000000000000000AA' : null),
        'secret_key' => env('TURNSTILE_SECRET_KEY', env('APP_ENV') === 'local' ? '1x0000000000000000000000000000000AA' : null),
    ],

    'contest_payment' => [
        'ithq_bkash_number' => env('ITHQ_BKASH_NUMBER', '01703436278'),
        'ithq_bkash_label' => env('ITHQ_BKASH_LABEL', 'personal'),
        'fees' => [
            'SZPC-2026' => 1000,
            'JPC-2026' => 500,
            'ITHQ-2026' => 100,
        ],
    ],

];
