<?php
namespace App\Http\Services\Payment;

use App\Http\Services\Payment\Support\PaymentTrait\BasicPayRequest;
use App\Http\Services\Payment\Support\PaymentTrait\OptionalKey;

abstract class AbstractPaymentGateway
{
    use OptionalKey, BasicPayRequest;
    protected $apiRequest;
    protected $apiStart;
    protected $apiVerify;
    protected $merchant;
    protected $amount;
    protected $callbackUrl;
    protected $description;
    protected $orderId;
    protected $mobile;
    protected $nationalCode;
    protected $response;
    protected $trackId;

    protected abstract function buildRequestData();

 }
