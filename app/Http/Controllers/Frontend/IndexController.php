<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    public function index()
    {
        $banners = Banner::where(['status' => 'active', 'condition' => 'banner'])->orderBy('id', 'DESC')->limit(5)->get();
        $categories = Category::where(['status' => 'active', 'is_parent' => 1])->orderBy('id', 'DESC')->limit(3)->get();
        $new_product = Product::with('brand')->where(['status' => 'active', 'condition' => 'new'])->orderBy('id', 'DESC')->limit(10)->get();

        return view('frontend.index', compact('banners', 'categories','new_product'));
    }

    public function productCategory($slug)
    {
        $categories = Category::with('products.brand')->where('slug', $slug)->first();
        return view('frontend.pages.product-category', compact('categories'));
    }

    public function productDetail($slug)
    {
        $product = Product::where('slug',$slug)->first();
        if ($product) {
            return view('frontend.layouts.product.single-product-detail',compact('product'));
        }
        return 'Product not found';
    }
}
