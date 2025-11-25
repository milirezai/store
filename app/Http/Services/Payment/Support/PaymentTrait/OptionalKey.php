<?php

namespace App\Http\Services\Payment\Support\PaymentTrait;

trait OptionalKey
{
    public function orderId(int $orderId)
    {
        $this->orderId = $orderId;
        return $this;
    }
    protected function getOrderId()
    {
        return $this->orderId;
    }

    public function mobile(string $mobile)
    {
        $this->mobile = $mobile;
        return $this;
    }
    protected function getMobile()
    {
        return $this->mobile;
    }

    public function nationalCode(int $nationalCode)
    {
        $this->nationalCode = $nationalCode;
        return $this;
    }
    protected function getNationalCode()
    {
        return $this->nationalCode;
    }

    public function urlRequest(string $url)
    {
        $this->urlRequest = $url;
        return $this;
    }
    protected function getUrlRequest()
    {
        return $this->urlRequest;
    }

    public function callbackUrl(string $callbackUrl)
    {
        $this->callbackUrl = $callbackUrl;
        return $this;
    }
    public function getCallbackUrl()
    {
        return $this->callbackUrl;
    }

    protected function getMerchant()
    {
        return $this->merchant;
    }
    protected function getAmount()
    {
        return $this->amount;
    }

    protected function getDescription()
    {
        return $this->description;
    }

    protected function setDefaultConfig(string $drive)
    {
        $drive = config('payment.'.$drive);
            $this->getUrlRequest() ?? $this->urlRequest($drive['urlRequest']);
            $this->getMerchant() ?? $this->merchant($drive['merchant']);
            $this->getCallbackUrl() ?? $this->callbackUrl($drive['callback']);
            $this->getDescription() ?? $this->description($drive['description']);
    }
}
