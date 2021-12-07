<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\OrderMail;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderInfo;
use App\Models\Shipping;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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
        $this->validate($request, [
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'email' => 'email|required',
            'phone' => 'required',
            'country' => 'string|nullable',
            'address' => 'required',
            'city' => 'required',
            'state' => 'string|nullable',
            'postcode' => 'string|nullable',
            'note' => 'string|nullable',
        ]);

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
        $this->validate($request, [
            'shipping_id' => 'required',
        ]);

        $shipping_charge = Shipping::find($request->shipping_id);
        Session::forget('checkout.delivery_id');
        Session::forget('checkout.delivery_charge');
        Session::push('checkout.delivery_id', $request->shipping_id);
        Session::push('checkout.delivery_charge', $shipping_charge->delivery_charge);


        return view('frontend.pages.checkout.checkout3');
    }

    public function checkout3Store(Request $request)
    {
        $this->validate($request, [
            'payment_method' => 'string|required'
        ]);

        Session::forget('checkout.payment_method');
        Session::forget('checkout.payment_status');

        Session::push('checkout.payment_method', $request->payment_method);
        Session::push('checkout.payment_status', 'paid');

        $full_cart = Cart::class;
        $cart_items = Cart::instance('shopping')->content();
        $checkout = Session::get('checkout');
        $amount = Session::get('coupon');

        return view('frontend.pages.checkout.checkout4', compact('cart_items', 'full_cart', 'checkout', 'amount'));
    }

    public function checkoutStore()
    {
        $order = new Order();
        $shopping = Cart::instance('shopping');
        $checkout = Session::get('checkout');

        $order['user_id'] = auth()->user()->id;
        $order['order_number'] = Str::upper('ORD-' . Str::random());
        $order['sub_total'] = 0;
        $order['coupon'] = 0;
        $order['delivery_charge'] = 0;
        $order['payment_method'] = $checkout['payment_method'][0];
        $order['payment_status'] = $checkout['payment_status'][0];
        $order['condition'] = 'pending';

        if ($checkout['delivery_id']) {
            $delivery = Shipping::find($checkout['delivery_id'][0]);
            $order['delivery_id'] = (int)$checkout['delivery_id'][0];
            $order['delivery_charge'] = $delivery->delivery_charge;
        }
        if ($shopping->content()->count() > 0) {
            foreach ($shopping->content() as $item) {
                $order['sub_total'] += $item->model->offer_price * $item->qty;
            }
        }
        if (Session::get('coupon')) {
            $coupon = Coupon::where('id', Session::get('coupon')['id'])->first();
            if ($coupon) {
                $order['coupon_id'] = Session::get('coupon')['id'];
                $order['coupon'] = $coupon->discount($order['sub_total']);
            }
        }
        $order['total_amount'] = $order['sub_total'] + $order['delivery_charge'] - $order['coupon'];

        $order->save();

        $order_info = new OrderInfo();
        $order_info['order_id'] = $order->id;
        $order_info['first_name'] = $checkout['first_name'];
        $order_info['last_name'] = $checkout['last_name'];
        $order_info['email'] = $checkout['email'];
        $order_info['phone'] = $checkout['phone'];
        $order_info['country'] = $checkout['country'];
        $order_info['address'] = $checkout['address'];
        $order_info['city'] = $checkout['city'];
        $order_info['state'] = $checkout['state'];
        $order_info['note'] = $checkout['note'];
        $order_info['postcode'] = $checkout['postcode'];
        $order_info['sfirst_name'] = $checkout['sfirst_name'];
        $order_info['slast_name'] = $checkout['slast_name'];
        $order_info['semail'] = $checkout['semail'];
        $order_info['sphone'] = $checkout['sphone'];
        $order_info['scountry'] = $checkout['scountry'];
        $order_info['saddress'] = $checkout['saddress'];
        $order_info['scity'] = $checkout['scity'];
        $order_info['sstate'] = $checkout['sstate'];
        $order_info['spostcode'] = $checkout['spostcode'];

        $status = $order_info->save();

        if ($status) {

            Mail::to($order_info['email'])->bcc($order_info['semail'])->cc('antonbelouswork@gmail.com')->send(new OrderMail($order, $order_info));
            $shopping->destroy();
            Session::forget('coupon');
            Session::forget('checkout');
            return redirect()->route('checkout.complete', $order['order_number'])->with('success');
        }

        return redirect()->route('checkout1')->with('error', 'Please try again');
    }

    public function complete($order)
    {
        return view('frontend.pages.checkout.checkout-complate', compact('order'));
    }
}
