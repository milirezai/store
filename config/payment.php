<?php

return [

    "default" => 'zibal',

    'drivers' => [
        'zibal',
        'zarinpal'
    ],


    'zibal' =>[
        'status' => true,
        'manager' => \App\Http\Services\Payment\ZibalGateway\Zibal::class,
        'merchant' => 'zibal',
        'callback' => 'http://localhost:8000/pay/request/verfiy',
        'description' => 'Request payment in Zibal',
        'apiRequest' => 'https://gateway.zibal.ir/v1/request',
        'apiStart' => 'https://gateway.zibal.ir/start/',
        'apiVerify' => 'https://gateway.zibal.ir/v1/verify'
    ],

];





//return [
//    'default' => 'zibal',
//
//    // 🎯 لیست درگاه‌های فعال
//    'drivers' => [
//        'zibal',
//        'zarinpal'
//    ],
//
//    'gateways' => [
//        'zibal' => [
//            'status' => true,
//            'manager' => \App\Http\Services\Payment\ZibalGateway\Zibal::class,
//
//            // 🎯 تنظیمات API
//            'api' => [
//                'request_url' => 'https://gateway.zibal.ir/v1/request',
//                'verify_url' => 'https://gateway.zibal.ir/v1/verify',
//                'start_url' => 'https://gateway.zibal.ir/start/',
//            ],
//
//            // 🎯 تنظیمات احراز هویت
//            'credentials' => [
//                'merchant_id' => env('ZIBAL_MERCHANT_ID', 'zibal'),
//                // 'password' => env('ZIBAL_PASSWORD'), // اگر نیاز باشه
//            ],
//
//            // 🎯 تنظیمات اپلیکیشن
//            'settings' => [
//                'callback_url' => env('ZIBAL_CALLBACK_URL', 'http://localhost:8000/payment/verify'),
//                'default_description' => 'پرداخت آنلاین',
//                'supported_currencies' => ['IRT', 'IRR'],
//            ],
//
//            // 🎯 تنظیمات پیشرفته
//            'options' => [
//                'timeout' => 30,
//                'retry_attempts' => 3,
//                'log_requests' => env('APP_DEBUG', false),
//            ]
//        ],
//
//        'zarinpal' => [
//            'status' => false, // 🎯 غیرفعال موقت
//            'manager' => \App\Http\Services\Payment\ZarinpalGateway\Zarinpal::class,
//
//            'api' => [
//                'request_url' => 'https://api.zarinpal.com/pg/v4/payment/request.json',
//                'verify_url' => 'https://api.zarinpal.com/pg/v4/payment/verify.json',
//                'start_url' => 'https://www.zarinpal.com/pg/StartPay/',
//            ],
//
//            'credentials' => [
//                'merchant_id' => env('ZARINPAL_MERCHANT_ID'),
//            ],
//
//            'settings' => [
//                'callback_url' => env('ZARINPAL_CALLBACK_URL', 'http://localhost:8000/payment/verify'),
//                'default_description' => 'پرداخت آنلاین',
//                'sandbox' => env('ZARINPAL_SANDBOX', true),
//            ],
//        ]
//    ]
//];
