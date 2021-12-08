<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class IndexController extends Controller
{

    public function index()
    {
        $banners = Banner::where(['status' => 'active', 'condition' => 'banner'])->orderBy('id', 'DESC')->limit(5)->get();
        $categories = Category::where(['status' => 'active', 'is_parent' => 1])->orderBy('id', 'DESC')->limit(3)->get();
        $new_product = Product::with('brand')->where(['status' => 'active', 'condition' => 'new'])->orderBy('id', 'DESC')->limit(10)->get();

        return view('frontend.index', compact('banners', 'categories', 'new_product'));
    }

    public function shop(Request $request)
    {
        $products = Product::where('status','active')->paginate(9);
        $categories = Category::where(['status'=>'active','is_parent'=>1])->orderBy('title', 'ASC')->get();
        return view('frontend.pages.product.shop',compact('products','categories'));
    }

    public function productCategory(Request $request, $slug)
    {
        $categories = Category::with('products.brand')->where('slug', $slug)->first();

        $sort = '';
        if ($request->sort != null) {
            $sort = $request->sort;
        }
        if ($categories == null) {
            return view('errors.404');
        }

        $products = Product::where(['status' => 'active', 'cat_id' => $categories->id])
            ->when($sort === 'priceAsc', function ($query) {
                $query->orderBy('offer_price', 'ASC');
            })
            ->when($sort === 'priceDesc', function ($query) {
                $query->orderBy('offer_price', 'DESC');
            })
            ->when($sort === 'discAsc', function ($query) {
                $query->orderBy('price', 'ASC');
            })
            ->when($sort === 'discDesc', function ($query) {
                $query->orderBy('price', 'DESC');
            })
            ->when($sort === 'titleAsc', function ($query) {
                $query->orderBy('price', 'ASC');
            })
            ->when($sort === 'titleDesc', function ($query) {
                $query->orderBy('price', 'DESC');
            })
            ->when($sort === '', function ($query) {
                $query->orderBy('id', 'ASC');
            })
            ->paginate(12);

        $route = 'category';

        if ($request->ajax()) {
            $view = view('frontend.layouts.product.components._single-product', compact('products'))->render();
            return response()->json(['html' => $view]);
        }
        return view('frontend.pages.product.product-category', compact('categories', 'route', 'products'));
    }

    public function productDetail($slug)
    {
        $product = Product::with('rel_products')->where('slug', $slug)->first();
        if ($product) {
            return view('frontend.pages.product.single-product-detail', compact('product'));
        }
        return 'Product not found';
    }

    public function userAuth()
    {
        Session::put('url.intended',URL::previous());
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
            Session::put('user', $validate_data['email']);
            if (Session::get('url.intended')) {
                return Redirect::to(Session::get('url.intended'));
            }
            return redirect()->route('index')->with('success', 'Successfully login');
        }
        return back()->with('error', 'Invalid email & password!');
    }

    public function registerSubmit(Request $request)
    {
        $validate_data = $this->validate($request, [
            'username' => 'nullable|string',
            'full_name' => 'required|string',
            'email' => 'email|required|unique:users,email',
            'passwords' => 'min:3|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:3',
        ]);

        $check = $this->createUser($validate_data);
        Session::put('user', $validate_data['email']);
        if ($check) {
            return redirect()->route('index')->with('success', 'Successfully registered');
        }
        return back()->with('errors', 'Please check your credential');
    }

    private function createUser(array $validate_data)
    {
        return User::create([
            'full_name' => $validate_data['full_name'],
            'username' => $validate_data['username'],
            'email' => $validate_data['email'],
            'password' => Hash::make($validate_data['passwords']),
        ]);
    }

    public function userLogout()
    {
        Session::forget('user');
        Auth::logout();
        return redirect()->route('index')->with('success', 'Successfully logout');
    }

    public function userDashboard()
    {
        $user = Auth::user();
        return view('frontend.user.dashboard', compact('user'));
    }

    public function userOrder()
    {
        $user = Auth::user();
        return view('frontend.user.order', compact('user'));
    }

    public function userAddress()
    {
        $user = Auth::user();
        return view('frontend.user.address', compact('user'));
    }

    public function userAccount()
    {
        $user = Auth::user();
        return view('frontend.user.account', compact('user'));
    }

    public function billingAddress(Request $request, $id)
    {
        $user = User::where('id', $id)
            ->update(
                [
                    'country' => $request->country,
                    'city' => $request->city,
                    'postcode' => $request->postcode,
                    'state' => $request->state,
                    'address' => $request->address
                ]);
        if ($user) {
            return back()->with('success', 'Billing address successfully updated');
        }
        return back()->with('error', 'Something went wrong');

    }

    public function sippingAddress(Request $request, $id)
    {
        $user = User::where('id', $id)
            ->update([
                'scountry' => $request->scountry,
                'scity' => $request->scity,
                'spostcode' => $request->spostcode,
                'sstate' => $request->sstate,
                'saddress' => $request->saddress
            ]);
        if ($user) {
            return back()->with('success', 'Shipping address successfully updated');
        }
        return back()->with('error', 'Something went wrong');
    }

    public function updateAccount(Request $request, $id)
    {
        $this->validate($request,[
            'newpassword' => 'nullable|min:3',
            'oldpassword' => 'nullable|min:3',
            'full_name'=> 'required|string',
            'username'=> 'nullable|string',
            'phone'=>'nullable|min:8|max:25'
        ]);
        $hashpassword = Auth::user()->password;

        if ($request->oldpassword == null && $request->newpassword == null) {
            User::where('id', $id)
                ->update([
                    'full_name' => $request->full_name,
                    'username' => $request->username,
                    'phone' => $request->phone,
                ]);
            return back()->with('success', 'Account successfully updated');
        }

        if (Hash::check($request->oldpassword, $hashpassword)) {
            if (!Hash::check($request->newpassword, $hashpassword)) {
                User::where('id', $id)
                    ->update([
                        'full_name' => $request->full_name,
                        'username' => $request->username,
                        'phone' => $request->phone,
                        'password' => Hash::make($request->newpassword),
                    ]);
                return back()->with('success', 'Account successfully updated');
            }
            return back()->with('error', 'New password can not be same with old password');
        }
        return back()->with('error', 'Old password does not match');

    }

}
