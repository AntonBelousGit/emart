<?php
namespace App\Utilities;

use App\Models\Product;

class Helpers{
    public static function userDefaultImage()
    {
        return asset('frontend/img/default.png');
    }

    public static  function minPrice(){
        return floor(Product::min('offer_price'));
    }

    public static  function maxPrice(){
        return floor(Product::max('offer_price'));
    }
}
