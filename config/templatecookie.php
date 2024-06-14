<?php

/*
 * This file is part of the Laravel Rave package.
 *
 * (c) templatecookie.com - Zakir Hossen <zakirsoft20@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [
    'default_language' => env('APP_DEFAULT_LANGUAGE'),
    'timezone' => env('APP_TIMEZONE'),
    'currency' => env('APP_CURRENCY', 'USD'),
    'currency_symbol' => env('APP_CURRENCY_SYMBOL', '$'),
    'currency_symbol_position' => env('APP_CURRENCY_SYMBOL_POSITION', 'left'),

    'stripe_key' => 'pk_test_51JAbnoDHsbz9CBNMjbDtUrA8pfBWkC9yvXqzFQYHeEJokRKFvpAedEruhqCxJhzqOflDi0KH1E020J5kitkMWV4q00fl2LBk6p',
    'stripe_secret' => 'sk_test_51JAbnoDHsbz9CBNM3FjZDwFH9rC3sr8q06vu9dDS0cjzY0o7a0VnC5KbcED1YUAEcryuro0xkDUKq8rKqVi1R9SX00idI7OL7i',
    'stripe_webhook_secret' => 'whsec_zH3RykA7qTcP8tWuSmxSl9lTHLzQHyTV',
    'stripe_active' => false,

    'razorpay_key' => 'rzp_test_V7zKmP7nti57DU',
    'razorpay_secret' => '3cbGRKMlwixOtuLXXdaHkrfn',
    'razorpay_active' => true,

    'paystack_public_key' => 'sk_test_13cb7967851092da5996bab4cfe4f834e5795895',
    'paystack_secret_key' => 'pk_test_934e46b979e2f764fe7e0fd411cb07c1771ad200',
    'paystack_payment_url' => 'https://api.paystack.co',
    'merchant_email' => 'devboyarif@gmail.com',
    'paystack_active' => true,

    'store_id' => '',
    'store_password' => '',
    'ssl_active' => false,
    'ssl_live_mode' => 'sandbox',

    'flw_public_key' => '',
    'flw_secret_key' => '',
    'flw_secret_hash' => '',
    'flw_active' => true,

    'im_key' => '',
    'im_secret' => '',
    'im_url' => 'https://test.instamojo.com/api/1.1/',
    'im_active' => false,

    'midtrans_merchat_id' => '',
    'midtrans_client_key' => '',
    'midtrans_server_key' => '',
    'midtrans_active' => false,

    'mollie_key' => 'test_Q9JvB3aM6e2Wkc92QjpBV3k88AF3x6',
    'mollie_active' => true,

    'paypal_sandbox_client_id' => 'Aa5dMaGzSheN82k47r5ZzdlbhGZavLnybxbcjBiKuQAM-2l27ANG7w3PHlzLwi2aNeyT7uCgPGTCrblg',
    'paypal_sandbox_client_secret' => 'EE3hQ9KwbPOQ_PNZUjZ_prJgHc0NKVgWcV7qgZkGgm0oPB9M0XcmsixnC8g-PmAG8i46L_6YMRR1hs8O',
    'paypal_live_client_id' => 'Aa5dMaGzSheN82k47r5ZzdlbhGZavLnybxbcjBiKuQAM-2l27ANG7w3PHlzLwi2aNeyT7uCgPGTCrblg',
    'paypal_live_client_secret' => 'EE3hQ9KwbPOQ_PNZUjZ_prJgHc0NKVgWcV7qgZkGgm0oPB9M0XcmsixnC8g-PmAG8i46L_6YMRR1hs8O',
    'paypal_live_mode' => 'sandbox',
    'paypal_active' => true,

    'fb_pixel' => '',
    'google_analytics' => '',

    // pusher
    'pusher_app_id' => env('PUSHER_APP_ID'),
    'pusher_app_key' => env('PUSHER_APP_KEY'),
    'pusher_app_secret' => env('PUSHER_APP_SECRET'),
    'pusher_host' => env('PUSHER_HOST'),
    'pusher_port' => env('PUSHER_PORT'),
    'pusher_schema' => env('PUSHER_SCHEME', 'https'),
    'pusher_app_cluster' => env('PUSHER_APP_CLUSTER'),

    // map show
    'map_show' => false,
];
