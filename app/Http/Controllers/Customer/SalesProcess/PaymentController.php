<?php

namespace App\Http\Controllers\Customer\SalesProcess;

use App\Http\Services\Payment\ZibalGateway\Zibal;
use App\Models\Market\Copan;
use App\Models\Market\Order;
use Illuminate\Http\Request;
use App\Models\Market\Payment;
use App\Models\Market\CartItem;
use App\Models\Market\CashPayment;
use App\Http\Controllers\Controller;
use App\Models\Market\OnlinePayment;
use Illuminate\Support\Facades\Auth;
use App\Models\Market\OfflinePayment;
use Illuminate\Database\Eloquent\Model;
use App\Http\Services\Payment\Payment as PaymentService;

class PaymentController extends Controller
{
    public function payment()
    {
        $user = auth()->user();
        $cartItems = CartItem::where('user_id', $user->id)->get();
        $order = Order::where('user_id', Auth::user()->id)->where('order_status', 0)->first();
        return view('customer.sales-process.payment', compact('cartItems', 'order'));
    }

    public function copanDiscount(Request $request)
    {
        $request->validate(
            ['copan' => 'required']
        );

        $copan = Copan::where([['code', $request->copan], ['status', 1], ['end_date', '>', now()], ['start_date', '<', now()]])->first();
        if ($copan != null) {
            if ($copan->user_id != null) {
                $copan = Copan::where([['code', $request->copan], ['status', 1], ['end_date', '>', now()], ['start_date', '<', now()], ['user_id', auth()->user()->id]])->first();
                if ($copan == null) {
                    return redirect()->back()->withErrors(['copan' => ['کد تخفیف اشتباه وارد شده است']]);
                }
            }

            $order = Order::where('user_id', Auth::user()->id)->where('order_status', 0)->where('copan_id', null)->first();

            if ($order) {
                if ($copan->amount_type == 0) {
                    $copanDiscountAmount = $order->order_final_amount * ($copan->amount / 100);
                    if ($copanDiscountAmount > $copan->discount_ceiling) {
                        $copanDiscountAmount = $copan->discount_ceiling;
                    }
                } else {
                    $copanDiscountAmount = $copan->amount;
                }

                $order->order_final_amount = $order->order_final_amount - $copanDiscountAmount;

                $finalDiscount = $order->order_total_products_discount_amount + $copanDiscountAmount;

                $order->update(
                    ['copan_id' => $copan->id, 'order_copan_discount_amount' => $copanDiscountAmount, 'order_total_products_discount_amount' => $finalDiscount]
                );

                return redirect()->back()->with(['copan' => 'کد تخفیف با موفقیت اعمال شد']);
            } else {
                return redirect()->back()->withErrors(['copan' => ['کد تخفیف اشتباه وارد شده است']]);
            }
        } else {
            return redirect()->back()->withErrors(['copan' => ['کد تخفیف اشتباه وارد شده است']]);
        }
    }

    public function paymentSubmit(Request $request, PaymentService $payment)
    {
        $request->validate(
            ['payment_type' => 'required']
        );

        $order = Order::where('user_id', Auth::user()->id)->where('order_status', 0)->first();
        $cartItems = CartItem::where('user_id', Auth::user()->id)->get();
        $cash_receiver = null;

        switch ($request->payment_type) {
            case '1':
                $targetModel = OnlinePayment::class;
                $type = 0;
                break;
            case '2':
                $targetModel = OfflinePayment::class;
                $type = 1;
                break;
            case '3':
                $targetModel = CashPayment::class;
                $type = 2;
                $cash_receiver = $request->cash_receiver ? $request->cash_receiver : null;
                break;
            default:
                return redirect()->back()->withErrors(['error' => 'خطا']);
        }

        $paymented = $targetModel::create([
            'amount' => $order->order_final_amount,
            'user_id' => auth()->user()->id,
            'pay_date' => now(),
            'cash_receiver' => $cash_receiver,
            'status' => 1,
        ]);


        $payment = Payment::create(
            [
                'amount' => $order->order_final_amount,
                'user_id' => auth()->user()->id,
                'pay_date' => now(),
                'type' => $type,
                'paymentable_id' => $paymented->id,
                'paymentable_type' => $targetModel,
                'staus' => 1
            ]
        );

        if ($request->payment_type == 1) {

            $requestPayment = $payment->gateway()->
            callbackUrl(route('customer.sales-process.payment-call-back',[$order,$paymented]))
                ->amount($order->order_final_amount)
                ->request();
            $paymented->bank_first_response = $requestPayment->response(true);
            $paymented->save();


            return $requestPayment->pay();

        };

        $order->update(
            ['order_status' => 3]
        );

        foreach($cartItems as $cartItem)
        {
            $cartItem->delete();
        }


        return redirect()->route('customer.home')->with('success', 'سفارش شما با موفقیت ثبت شد');

    }

    public function paymentCallback(Order $order, OnlinePayment $onlinePayment,PaymentService $payment)
    {
        $onlinePaymentResponse = json_decode($onlinePayment->bank_first_response);
        $verify = $payment->gateway()->trackId($onlinePaymentResponse->trackId)->verify();
        $onlinePayment->bank_second_response = $verify->response(true);
        $onlinePayment->save();
        $cartItems = CartItem::where('user_id', Auth::user()->id)->get();
        foreach($cartItems as $cartItem)
        {
            $cartItem->delete();
        }
        if ($verify->result === 200){
            $order->update(
                ['order_status' => 3]
            );
            return redirect()->route('customer.home');
        }else{
            return redirect()->route('customer.home');
        }
    }











    public function paymentService(PaymentService $payment)
    {

        // send request payment
        $payment->gateway()
            ->amount(24234234)
            ->request();
        // send request payment and go to payment getway
        $payment->gateway()
            ->amount(23424)
            ->request()->pay();
        // send request payment and get respone
        $payment->gateway()
            ->amount(454545)
            ->request()
            ->response(true);
        // send request payment and save respone and got to payment getway
        $paymentRequest = $payment->gateway()
            ->amount(2432423)
            ->request();
        $respone = $paymentRequest->response();
        $paymentRequest->pay();
        // optional key fo request payment
        # set description
        $payment->gateway()
            ->description('pay for mobile')
            ->amount(2323)
            ->request()->pay();
        # set mobile
        $payment->gateway()
            ->mobile('09167516826')
            ->amount(2323)
            ->request()->pay();
        # set orderId
        $payment->gateway()
            ->orderId(21)
            ->amount(2323)
            ->request()->pay();
        # set nationalCode
        $payment->gateway()
            ->nationalCode(2300603942)
            ->amount(424234)
            ->request()->pay();
        # set all options
        $payment->gateway()
            ->amount(2423424)
            ->description('pry for mobile')
            ->orderId(23)
            ->mobile('09167516826')
            ->nationalCode(42434234234)
            ->request()->pay();
        // setings request
        # set api request
        $payment->gateway()
            ->apiRequest('https://gateway.zibal.ir/v1/request')
            ->amount(23424)
            ->request()->pay();
        # set api apiStart
        $payment->gateway()
            ->apiStart('https://gateway.zibal.ir/start/')
            ->amount(23424)
            ->request()->pay();
        # set api apiVerify
        $payment->gateway()
            ->apiVerify('https://gateway.zibal.ir/v1/verify')
            ->amount(23424)
            ->request()->pay();
        # set call back url
        $payment->gateway()
            ->callbackUrl('http://localhost:8000/payment-callback')
            ->amount(2423423)
            ->request()->pay();
        # set merchant
        $payment->gateway()
            ->merchant('zibal')
            ->amount(242342)
            ->request()->pay();
        # set stings all
        $payment->gateway()
            ->merchant('zibal')
            ->apiRequest('https://gateway.zibal.ir/v1/request')
            ->apiStart('https://gateway.zibal.ir/start/')
            ->apiVerify('https://gateway.zibal.ir/v1/verify')
            ->callbackUrl('http://localhost:8000/payment-callback')
            ->amount(23424)
            ->request()->pay();



    }









}
