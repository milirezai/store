<?php

namespace App\Http\Services\Payment\Support\Contract;

interface PaymentDriverContract
{
    public function driver(string $driver);
    public function pay();
}
