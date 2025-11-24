<?php
namespace App\Http\Services\Payment;

abstract class AbstractPaymentGateway
{
    protected $urlRequest;
    protected $merchant;
    protected $amount;
    protected $callbackUrl;
    protected $description;
    protected $orderId;
    protected $mobile;
    protected $nationalCode;
    protected $message;


    public function getUrlRequest()
    {
        return $this->urlRequest;
    }
    public abstract function merchant(string $merchant);
    public function getMerchant()
    {
        return $this->merchant;
    }
    public abstract function amount(int $amount);
    public function getAmount()
    {
        return $this->amount;
    }
    public abstract function callbackUrl(string $callbackUrl);
    public function getCallbackUrl()
    {
        return $this->callbackUrl;
    }
    public abstract function description(string $description);
    public function getDescription()
    {
        return $this->description;
    }
    public abstract function orderId(int $orderId);
    public function getOrderId()
    {
        return $this->orderId;
    }
    public abstract function mobile(int $mobile);
    public function getMobile()
    {
        return $this->mobile;
    }
    public abstract function nationalCode(int $nationalCode);
    public function getNationalCode()
    {
        return $this->nationalCode;
    }

    public abstract function trackId();
    public abstract function result();
    public abstract function results();
    public abstract function request();
    public abstract function verify();
}
