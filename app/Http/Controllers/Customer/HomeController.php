<?php

namespace App\Http\Controllers\Customer;

use App\Http\Services\Payment\Payment;
use App\Models\Market\Brand;
use App\Models\Market\OnlinePayment;
use Illuminate\Http\Request;
use App\Models\Content\Banner;
use App\Http\Controllers\Controller;
use App\Models\Market\Product;

class HomeController extends Controller
{


    public function home(Payment $payment, Request $request)
    {

        $online = OnlinePayment::find(24);

        $response = $payment->gateway()->trackId(json_decode($online->bank_first_response)->trackId)->verify()->response();
//
        $online->bank_second_response = json_encode($response);
        $online->save();
//
        dd($online);

       $pay =  $payment->gateway()->callbackUrl(route('admin.home'))->amount(4242424)->request();
       $addPay = [
           'gateway' => $pay->gatewayName(),
           'amount' => 42442423,
           'user_id' => 1,
           'bank_first_response' => json_encode($pay->response())
       ];
       OnlinePayment::create($addPay);


        $slideShowImages = Banner::orderBy('id','desc')->where('position', 0)->where('status', 1)->take(6)->get();
        $topBanners = Banner::orderBy('id','desc')->where('position', 1)->where('status', 1)->take(2)->get();
        $middleBanners = Banner::orderBy('id','desc')->where('position', 2)->where('status', 1)->take(2)->get();
        $bottomBanner = Banner::orderBy('id','desc')->where('position', 3)->where('status', 1)->first();
        $brands = Brand::orderBy('id','desc')->get();
        $mostVisitedProducts = Product::latest()->take(10)->get();
        $offerProducts = Product::latest()->take(10)->get();
        return view('customer.home', compact('slideShowImages', 'topBanners',
            'middleBanners', 'bottomBanner', 'brands', 'mostVisitedProducts', 'offerProducts'));

    }


}
