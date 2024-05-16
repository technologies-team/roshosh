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
        'token' => env('POSTMARK_TOKEN'),
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
    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect' => 'http://example.com/callback-url',
    ],
    'fcm' => [
        'key' => env('FCM_SERVER_KEY',"AAAATSK69AA:APA91bFNFSFBzOIk95Fo-IbHebiFUGAWPDjmcTKPXxx6huDsJwCVAiFUCP36sQ2K1mkHcnaD3MP39SVa_LAUyy4GHKm-BshpKX9NAFWeWR-avJn5UZKzDXrpHYgk-25rUknYa8vMk5JS"),
        'sender_id' => env('FCM_SENDER_ID',"331295159296"),
    ],

];
