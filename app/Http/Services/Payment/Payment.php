<?php
namespace App\Http\Services\Payment;

class Payment
{
    public function withGateway($paymentGateway)
    {
        return new $paymentGateway;
        $gateways = config('payment.paymentGateway');
        foreach ($gateways as $gateway => $gatewayStatus){
            if ($paymentGateway === $gateway){
                if ($gatewayStatus){
                    return app()->make($gateway);
                }
            }
        }
    }
}
