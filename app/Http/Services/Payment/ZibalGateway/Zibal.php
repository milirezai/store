<?php

namespace App\Http\Services\Payment\ZibalGateway;

use App\Http\Services\Payment\AbstractPaymentGateway;
use App\Http\Services\Payment\PaymentTrait\PaymentRequest;

class Zibal extends AbstractPaymentGateway
{
    use PaymentRequest;

    protected $urlRequest = 'https://gateway.zibal.ir/v1/request';
    public function merchant(string $merchant)
    {
        $this->merchant = $merchant;
        return $this;
    }

    public function amount(int $amount)
    {
        $this->amount = $amount;
        return $this;
    }

    public function callbackUrl(string $callbackUrl)
    {
        $this->callbackUrl = $callbackUrl;
        return $this;
    }

    public function description(string $description)
    {
        $this->description = $description;
        return $this;
    }

    public function orderId(int $orderId)
    {
        $this->orderId = $orderId;
        return $this;
    }

    public function mobile(int $mobile)
    {
        $this->mobile = $mobile;
        return $this;
    }

    public function nationalCode(int $nationalCode)
    {
        $this->nationalCode = $nationalCode;
        return $this;
    }

    public function trackId()
    {

    }

    public function result()
    {

    }

    public function results()
    {
        return json_decode($this->message);
    }

    public function request()
    {
        $add = json_encode([ "trackId" => 15966442233311, "result" => 100, "message" => "success"]);
        $this->message = $add;
        return $this;
    }

    public function verify()
    {

    }

}
