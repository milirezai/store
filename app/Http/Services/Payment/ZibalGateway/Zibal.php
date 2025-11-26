<?php

namespace App\Http\Services\Payment\ZibalGateway;

use App\Http\Services\Payment\AbstractPaymentGateway;
use App\Http\Services\Payment\Support\Contract\PaymentGatewayContract;
use function Livewire\str;

class Zibal extends AbstractPaymentGateway implements PaymentGatewayContract
{

    public function amount(int $amount)
    {
        $this->amount = $amount;
        return $this;
    }

    protected function buildRequestData()
    {
        $requestData = [
            'merchant' => $this->getMerchant(),
            'amount' => $this->getAmount(),
            'callbackUrl' => $this->getCallbackUrl(),
            'description' => $this->getDescription(),
            'orderId' => $this->getOrderId(),
            'mobile' => $this->getMobile(),
            'nationalCode' => (string) $this->getNationalCode(),
        ];

        $filteredData = array_filter($requestData, function($value) {
            return $value !== null && $value !== '';
        });

        return $filteredData;
    }

    public function request()
    {
        $this->setDefaultConfig('zibal');
        $response = $this->sendRequest();
        $this->response = $response;
        return $this;
    }

    public function verify()
    {
        $this->setDefaultConfig('zibal');
        $response = $this->sendVerifyRequest();
        $this->response = $response;
        return $this;
    }

    public function pay()
    {
        if ($this->response->result === 100)
            return redirect()->away($this->getApiStart().$this->response->trackId);
        else
            return false;
    }
}
