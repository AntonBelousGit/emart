<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    public function index(){
        $banners = Banner::where(['status'=>'active','condition'=>'banner'])->orderBy('id','DESC')->limit(5)->get();
        $categories = Category::where(['status'=>'active','is_parent'=>1])->orderBy('id','DESC')->limit(3)->get();
        return view('frontend.index',compact('banners','categories'));
    }

    public function productCategory($slug)
    {
        $categories = Category::with('products.brand')->where('slug',$slug)->first();
        return view('frontend.pages.product-category',compact('categories'));
    }
}
