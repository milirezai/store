<?php

namespace App\Http\Services\Payment;

use App\Http\Services\Payment\Support\Contract\PaymentDriverContract;
use App\Http\Services\Payment\ZibalGateway\Zibal;

class Payment implements PaymentDriverContract
{
    private $driver;

    public function driver(string $driver)
    {
        $this->driver = $driver;
        return $this;
    }

    private function setDriver()
    {
        $defaultDriver = config('payment.default');
        $this->driver = $defaultDriver;
    }

    public function pay()
    {
        if ($this->driver === null)
            $this->setDriver();
        $driver = config('payment.'.$this->driver);
        if ($driver['status'])
            return new Zibal();
        else
            null;
    }
}

