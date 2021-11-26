<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cartStore(Request $request)
    {
        $product_qty = $request->input('product_qty');
        $product_id = $request->input('product_id');

        $product = Product::getProductByCart($product_id);
        $price = $product->offer_price;

//        $cart_array=[];
//
//        foreach (Cart::instance('shopping')->content() as $item)
//        {
//            $cart_array[] = $item->id;
//        }

        $result = Cart::instance('shopping')->add($product_id, $product->title, $product_qty, $price)->associate(Product::class);

        if ($result) {
            $response['status'] = true;
            $response['product_id'] = $product_id;
            $response['total'] = Cart::subtotal();
            $response['cart_count'] = Cart::instance('shopping')->count();
            $response['message'] = "Item was added to your cart";
        }

        if ($request->ajax()) {
            $header = view('frontend.layouts.header')->render();
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

        if ($request->ajax()) {
            $header = view('frontend.layouts.header')->render();
            $response['header'] = $header;
        }
        return json_encode($response, JSON_THROW_ON_ERROR);
    }
}
