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

        $cart_array=[];

        foreach (Cart::instance('shopping')->content() as $item)
        {
            $cart_array[] = $item->id;
        }

        $result = Cart::instance('shopping')->add($product_id,$product->title,$product_qty,$price)->associate(Product::class);

        if ($result) {
            $response['status']=true;
            $response['product_id']=$product_id;
            $response['total']=Cart::subtotal();
            $response['cart_count']=Cart::instance('shopping')->count();
        }
        return json_encode($response);
    }
}
