<?php

return [
    /*
    |--------------------------------------------------------------------------
    | MoMo payment configuration
    |--------------------------------------------------------------------------
    | UI NOTE: Để demo nhanh có thể dùng QR tĩnh bằng cách đặt ảnh QR vào public/images/momo-qr.png
    | và khai báo MOMO_STATIC_QR_IMAGE=/images/momo-qr.png. Nếu muốn MoMo xác nhận tự động,
    | cần đăng ký Merchant/Sandbox và điền partner_code, access_key, secret_key.
    */

    'enabled' => env('MOMO_ENABLED', false),
    'environment' => env('MOMO_ENV', 'test'),
    'endpoint' => env('MOMO_ENDPOINT', 'https://test-payment.momo.vn/v2/gateway/api/create'),
    'partner_code' => env('MOMO_PARTNER_CODE', ''),
    'access_key' => env('MOMO_ACCESS_KEY', ''),
    'secret_key' => env('MOMO_SECRET_KEY', ''),
    'request_type' => env('MOMO_REQUEST_TYPE', 'captureWallet'),
    'lang' => env('MOMO_LANG', 'vi'),
    'auto_capture' => env('MOMO_AUTO_CAPTURE', true),

    // QR tĩnh / chuyển khoản thủ công dùng cho demo khi chưa có Merchant API.
    'static_qr_image' => env('MOMO_STATIC_QR_IMAGE', '/images/momo-qr-placeholder.svg'),
    'receiver_name' => env('MOMO_RECEIVER_NAME', 'BARBER HOUSE'),
    'receiver_phone' => env('MOMO_RECEIVER_PHONE', '0900000000'),
];
