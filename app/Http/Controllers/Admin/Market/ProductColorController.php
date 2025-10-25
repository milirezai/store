<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\ProductColorRequest;
use App\Models\Market\Product;
use App\Models\Market\ProductColor;
use Illuminate\Http\Request;

class ProductColorController extends Controller
{

    public function index(Product $product)
    {
        return view('admin.market.product.color.index', compact('product'));
    }

    public function create(Product $product)
    {
        return view('admin.market.product.color.create', compact('product'));
    }

    public function store(ProductColorRequest $request, Product $product)
    {
        $inputs = $request->all();
        $inputs['product_id'] = $product->id;
        ProductColor::create($inputs);
        return redirect()->route('admin.market.color.index', $product->id)->with('swal-success', 'رنگ جدید شما با موفقیت ثبت شد');
    }

    public function destroy(Product $product, ProductColor $productColor)
    {
        $result = $productColor->delete();
        return redirect()->route('admin.market.color.index', $product->id)->with('swal-success', 'رنگ شما با موفقیت حذف شد');
    }
}
