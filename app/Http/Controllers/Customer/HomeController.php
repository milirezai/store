<?php

namespace App\Http\Controllers\Customer;

use App\Models\Market\Brand;
use App\Models\Market\OnlinePayment;
use Illuminate\Http\Request;
use App\Models\Content\Banner;
use App\Http\Controllers\Controller;
use App\Models\Market\Product;

class HomeController extends Controller
{


    public function home()
    {
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
