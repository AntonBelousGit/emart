<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller
{

    public function index()
    {
        $banners = Banner::where(['status' => 'active', 'condition' => 'banner'])->orderBy('id', 'DESC')->limit(5)->get();
        $categories = Category::where(['status' => 'active', 'is_parent' => 1])->orderBy('id', 'DESC')->limit(3)->get();
        $new_product = Product::with('brand')->where(['status' => 'active', 'condition' => 'new'])->orderBy('id', 'DESC')->limit(10)->get();

        return view('frontend.index', compact('banners', 'categories', 'new_product'));
    }

    public function productCategory($slug)
    {
        $categories = Category::with('products.brand')->where('slug', $slug)->first();
        $route = 'category';
        return view('frontend.pages.product-category', compact('categories','route'));
    }

    public function productDetail($slug)
    {
        $product = Product::with('rel_products')->where('slug', $slug)->first();
        if ($product) {
            return view('frontend.layouts.product.single-product-detail', compact('product'));
        }
        return 'Product not found';
    }

    public function userAuth()
    {
        return view('frontend.auth.auth');
    }

    public function loginSubmit(Request $request)
    {
        $validate_data = $this->validate($request, [
            'email' => 'email|required|exists:users,email',
            'password' => 'required|min:3',
        ]);
//        dd($validate_data);
        if (Auth::attempt(['email' => $validate_data['email'], 'password' => $validate_data['password'], 'status' => 'active'])) {
            Session::put('user',$validate_data['email']);
            if (Session::get('url.intended')) {
                return Redirect::to(Session::get('url.intended'));
            }
            return redirect()->route('index')->with('success','Successfully login');
        }
        return back()->with('error', 'Invalid email & password!');
    }

    public function registerSubmit(Request $request)
    {
        $validate_data = $this->validate($request, [
            'username'=>'nullable|string',
            'full_name'=>'required|string',
            'email' => 'email|required|unique:users,email',
            'passwords' => 'min:3|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:3',
        ]);

        $check = $this->createUser($validate_data);
        Session::put('user',$validate_data['email']);
        if ($check) {
            return redirect()->route('index')->with('success','Successfully registered');
        }
        return back()->with('errors','Please check your credential');
    }

    private function createUser(array $validate_data)
    {
        return User::create([
           'full_name'=>$validate_data['full_name'],
           'username'=>$validate_data['username'],
           'email'=>$validate_data['email'],
           'password'=>Hash::make($validate_data['passwords']) ,
        ]);
    }

    public function userLogout(){
        Session::forget('user');
        Auth::logout();
        return \redirect()->home()->with('success','Successfully logout');
    }
}
