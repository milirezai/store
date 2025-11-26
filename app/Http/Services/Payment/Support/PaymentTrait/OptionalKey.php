<?php

namespace App\Http\Services\Payment\Support\PaymentTrait;

trait OptionalKey
{
    public function apiRequest(string $url)
    {
        $this->apiRequest = $url;
        return $this;
    }
    protected function getApiRequest()
    {
        return $this->apiRequest;
    }
    public function apiStart(string $url)
    {
        $this->apiStart = $url;
        return $this;
    }
    protected function getApiStart()
    {
        return $this->apiStart;
    }
    public function apiVerify(string $url)
    {
        $this->apiVerify = $url;
        return $this;
    }
    protected function getApiVerify()
    {
        return $this->apiVerify;
    }

    public function callbackUrl(string $callbackUrl)
    {
        $this->callbackUrl = $callbackUrl;
        return $this;
    }
    protected function getCallbackUrl()
    {
        return $this->callbackUrl;
    }
    public function merchant(string $merchant)
    {
        $this->merchant = $merchant;
        return $this;
    }
    protected function getMerchant()
    {
        return $this->merchant;
    }
    public function description(string $description)
    {
        $this->description = $description;
        return $this;
    }
    protected function getDescription()
    {
        return $this->description;
    }
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
    public function trackId(int $trackId)
    {
        $this->trackId = $trackId;
        return $this;
    }
    protected function getTrackId()
    {
        return $this->trackId;
    }

    protected function getAmount()
    {
        return $this->amount;
    }

    protected function setDefaultConfig(string $drive)
    {
        $drive = config('payment.'.$drive);
            $this->getApiRequest() ?? $this->apiRequest($drive['apiRequest']);
            $this->getApiStart() ?? $this->apiStart($drive['apiStart']);
            $this->getApiVerify() ?? $this->apiVerify($drive['apiVerify']);
            $this->getMerchant() ?? $this->merchant($drive['merchant']);
            $this->getCallbackUrl() ?? $this->callbackUrl($drive['callback']);
            $this->getDescription() ?? $this->description($drive['description']);
    }
    public function getCodeMessage(int $code)
    {
        // کد رو میدیم بهمون معنی کد رو میده
    }
    public function gatewayName()
    {
        return $this->getMerchant();
    }
    public function response()
    {
        return $this->response;
    }
}
