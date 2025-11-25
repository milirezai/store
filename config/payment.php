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
        'urlRequest' => 'https://gateway.zibal.ir/v1/request',
        'merchant' => 'zibal',
        'callback' => 'http://localhost:8000/pay/request/verfiy',
        'description' => 'Request payment in Zibal'
    ],

];


