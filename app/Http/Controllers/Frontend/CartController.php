<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use function Symfony\Component\String\b;

class CartController extends Controller
{
    public function cart()
    {
        $cart = Cart::instance('shopping')->content();
        $amount = Session::get('coupon');
        $full_cart = Cart::class;

        return view('frontend.pages.cart.index', compact('cart', 'amount', 'full_cart'));
    }

    public function cartStore(Request $request)
    {
        $product_qty = $request->input('product_qty');
        $product_id = $request->input('product_id');

        $product = Product::getProductByCart($product_id);
        $price = $product->offer_price;

        $result = Cart::instance('shopping')->add($product_id, $product->title, $product_qty, $price)->associate(Product::class);

        if ($result) {
            $response['status'] = true;
            $response['product_id'] = $product_id;
            $response['total'] = Cart::subtotal();
            $response['cart_count'] = Cart::instance('shopping')->count();
            $response['message'] = "Item was added to your cart";
        }
        if (Session::has('coupon')) {
            $response['amount'] = $this->updatePercentCoupon();
        }

        if ($request->ajax()) {
            $header = view('frontend.layouts.header')->render();
            $response['cart_total'] = $this->cartTotal();
            $response['header'] = $header;
        }
        return json_encode($response, JSON_THROW_ON_ERROR);
    }

    public function cartDelete(Request $request)
    {
        $id = $request->input('cart_id');
        Cart::instance('shopping')->remove($id);

        $response['status'] = true;
        $response['total'] = Cart::subtotal();
        $response['cart_count'] = Cart::instance('shopping')->count();
        $response['message'] = "Product successfully removed";
        if (Session::has('coupon')) {
            $response['amount'] = $this->updatePercentCoupon();
        }


        if ($request->ajax()) {
            $header = view('frontend.layouts.header')->render();
            $cart_list = view('frontend.pages.cart.component._cart-list')->render();

            $response['cart_list'] = $cart_list;
            $response['cart_total'] = $this->cartTotal();
            $response['header'] = $header;
        }
        return $response;
    }

    public function cartUpdate(Request $request)
    {
        $this->validate($request, [
            'product_qty' => 'required|numeric',
        ]);
        $rowId = $request->input('rowId');
        $request_quantity = $request->input('product_qty');
        $product_quantity = $request->input('productQuantity');

        if ($request_quantity > $product_quantity) {
            $message = "We currently do not have enough item in stock";
            $response['status'] = false;
        } elseif ($request_quantity < 1) {
            $message = "You can't add less than 1 quantity";
            $response['status'] = false;
        } else {
            Cart::instance('shopping')->update($rowId, $request_quantity);
            $message = "Quantity was updated successfully";
            $response['status'] = true;
            $response['total'] = Cart::subtotal();
            $response['cart_count'] = Cart::instance('shopping')->count();
        }
        if (Session::has('coupon')) {
             $response['amount'] = $this->updatePercentCoupon();
        }

        if ($request->ajax()) {
            $header = view('frontend.layouts.header')->render();
            $cart_list = view('frontend.pages.cart.component._cart-list')->render();

            $response['header'] = $header;
            $response['cart_list'] = $cart_list;
            $response['cart_total'] = $this->cartTotal();
            $response['message'] = $message;
        }
        return $response;
    }

    public function couponAdd(Request $request)
    {
        $coupon = Coupon::where('code', $request->input('code'))->first();
        if (!$coupon) {
            return back()->with('error', 'Invalid coupon code, Please enter valid coupon code');
        }

        $total_price = Cart::instance('shopping')->subtotal();
        session()->put('coupon', [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'value' => $coupon->discount($total_price),

        ]);
        return back()->with('success', 'Coupon applied successfully');
    }

    public function updatePercentCoupon()
    {
        $oldcoupon = Session::get('coupon');
        $coupon = Coupon::where('code', $oldcoupon['code'])->first();
        $total_price = Cart::instance('shopping')->subtotal();
        $value = $coupon->discount($total_price);

        session()->put('coupon', [
            'id' => $oldcoupon['id'],
            'code' => $oldcoupon['code'],
            'value' => $value,

        ]);

        return $value;
    }

    public function cartTotal()
    {
        $amount = Session::get('coupon');
        $full_cart = Cart::class;
        return view('frontend.pages.cart.component._cart-total',compact('amount','full_cart'))->render();
    }
}
