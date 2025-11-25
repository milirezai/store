<?php

namespace App\Http\Services\Payment\Support\Contract;

interface PaymentGatewayContract
{
    public function merchant(string $merchant);
    public function amount(int $amount);
    public function description(string $description);
    public function request();
    public function toGateway();

}
