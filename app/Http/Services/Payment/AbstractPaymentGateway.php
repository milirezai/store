<?php
namespace App\Http\Services\Payment;

use App\Http\Services\Payment\Support\PaymentTrait\BasicPayRequest;
use App\Http\Services\Payment\Support\PaymentTrait\OptionalKey;

abstract class AbstractPaymentGateway
{
    use OptionalKey, BasicPayRequest;
    protected $urlRequest;
    protected $merchant;
    protected $amount;
    protected $callbackUrl;
    protected $description;
    protected $orderId;
    protected $mobile;
    protected $nationalCode;
    protected $response;

    protected abstract function buildRequestData();

//    public abstract function trackId();
//    public abstract function result();
//    public abstract function results();
//    public abstract function request();
//    public abstract function verify();
}
