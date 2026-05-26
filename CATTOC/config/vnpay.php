<?php

return [
    /*
    |--------------------------------------------------------------------------
    | VNPAY Sandbox/Demo configuration
    |--------------------------------------------------------------------------
    | UI NOTE: Bản đồ án nên để VNPAY_ENABLED=true với thông tin sandbox.
    | Nếu chưa có TMN_CODE/HASH_SECRET, giao diện vẫn hiển thị hướng dẫn và không tự tạo link thật.
    */

    'enabled' => env('VNPAY_ENABLED', false),
    'environment' => env('VNPAY_ENV', 'sandbox'),
    'url' => env('VNPAY_URL', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html'),
    'tmn_code' => env('VNPAY_TMN_CODE', ''),
    'hash_secret' => env('VNPAY_HASH_SECRET', ''),
    'version' => env('VNPAY_VERSION', '2.1.0'),
    'command' => env('VNPAY_COMMAND', 'pay'),
    'curr_code' => env('VNPAY_CURR_CODE', 'VND'),
    'locale' => env('VNPAY_LOCALE', 'vn'),
    'order_type' => env('VNPAY_ORDER_TYPE', 'billpayment'),
];
