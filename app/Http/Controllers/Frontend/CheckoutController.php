<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Shipping;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function checkout1()
    {
        $user = Auth::user();
        return view('frontend.pages.checkout.checkout1', compact('user'));
    }

    public function checkout1Store(Request $request)
    {
        Session::put('checkout', [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'country' => $request->country,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postcode' => $request->postcode,
            'note' => $request->note,
            'sfirst_name' => $request->sfirst_name,
            'slast_name' => $request->slast_name,
            'semail' => $request->semail,
            'sphone' => $request->sphone,
            'scountry' => $request->scountry,
            'saddress' => $request->saddress,
            'scity' => $request->scity,
            'sstate' => $request->sstate,
            'spostcode' => $request->spostcode,
        ]);

        $shippings = Shipping::where('status', 'active')->orderBy('shipping_address', 'ASC')->get();

        return view('frontend.pages.checkout.checkout2', compact('shippings'));
    }

    public function checkout2Store(Request $request)
    {
        $shipping_charge = Shipping::find($request->shipping_id);
        Session::forget('checkout.delivery_charge');
        Session::push('checkout.delivery_charge', $shipping_charge->delivery_charge);

        return view('frontend.pages.checkout.checkout3');
    }

    public function checkout3Store(Request $request)
    {
        Session::forget('checkout.payment_method');
        Session::forget('checkout.payment_status');

        Session::push('checkout.payment_method', $request->payment_method);
        Session::push('checkout.payment_status', 'paid');

        $full_cart = Cart::class;
        $cart_items = Cart::instance('shopping')->content();
        $checkout = Session::get('checkout');
        $amount = Session::get('coupon');

        return view('frontend.pages.checkout.checkout4',compact('cart_items','full_cart','checkout','amount'));
    }

    public function checkoutStore()
    {
        $order = new Order();
        $order['user_id'] = auth()->user()->id;
        $order['order_nuber'] = Str::upper('ORD-'.Str::random());

        return $order;
    }
}
