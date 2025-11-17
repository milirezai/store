<?php

namespace App\Http\Controllers\Customer\SalesProcess;

use App\Models\Market\CartItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function addressAndDelivery()
    {
        //check profile
        $user = Auth::user();
        if(empty($user->mobile) || empty($user->first_name) || empty($user->last_name) || empty($user->email))
        {
            return redirect()->route('customer.sales-process.profile-completion');
        }

        if(empty(CartItem::where('user_id', $user->id)->count()))
        {
            return redirect()->route('customer.sales-process.cart');
        }

        return view('customer.sales-process.address-and-delivery');
    }
}
