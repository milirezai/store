<?php

namespace App\Http\Services\Payment\Support\Contract;

interface PaymentGatewayContract
{
    public function amount(int $amount);
    public function request();
    public function verify();
    public function pay();
}
