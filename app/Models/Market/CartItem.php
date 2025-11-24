<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','product_id','color_id','guarantee_id','number'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function guarantee()
    {
        return $this->belongsTo(Guarantee::class);
    }


    public function color()
    {
        return $this->belongsTo(ProductColor::class);
    }

    //productPrice + colorPrice + guranateePrice
    public function cartItemProductPrice()
    {
        $guaranteePriceIncrease = empty($this->guarantee_id) ? 0 : $this->guarantee->price_increase;
        $colorPriceIncrease = empty($this->color_id) ? 0 : $this->color->price_increase;
        return $this->product->price + $guaranteePriceIncrease + $colorPriceIncrease;
    }

    // productPrice * (discount Percentage / 100)
    public function cartItemProductDiscount()
    {
        $cartItemProductPrice = $this->cartItemProductPrice();
        $discountPercentage = $this->product->activeAmazingSales()->percentage;
        $productDiscount = empty($this->product->activeAmazingSales()) ? 0 : discount($cartItemProductPrice, $discountPercentage);
        return $productDiscount;
    }

    //number * (productPrice + colorPrice + guranateePrice - discountPrice)
    public function cartItemFinalPrice()
    {
        $cartItemProductPrice = $this->cartItemProductPrice();
        $productDiscount = $this->cartItemProductDiscount();
        return $this->number * ($cartItemProductPrice - $productDiscount);
    }

    //number * productDiscount
    public function cartItemFinalDiscount()
    {
        $productDiscount = $this->cartItemProductDiscount();
        return $this->number * $productDiscount;
    }



}
