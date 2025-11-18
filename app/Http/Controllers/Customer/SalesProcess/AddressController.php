<?php

namespace App\Http\Controllers\Customer\SalesProcess;

use App\Models\Market\CartItem;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function addressAndDelivery()
    {

        $cartItems = CartItem::where('user_id',auth()->user()->id)->get();

        if(empty(CartItem::where('user_id', auth()->user()->id)->count()))
        {
            return redirect()->route('customer.sales-process.cart');
        }

        $provinces = Province::all();
        return view('customer.sales-process.address-and-delivery',compact('cartItems','provinces'));
    }

    public function getCities(Province $province)
    {
        $cities = $province->cities;
        if($cities != null)
        {
            return response()->json(['status' => true, 'cities' => $cities]);
        }
        else{
            return response()->json(['status' => false, 'cities' => null]);
        }
    }

}
