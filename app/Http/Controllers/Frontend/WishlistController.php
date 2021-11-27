<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function wishlist()
    {
        $wishlist = Cart::instance('wishlist');
        return view('frontend.pages.wishlist.index', compact('wishlist'));
    }

    public function wishlistStore(Request $request)
    {
        $product_id = $request->input('product_id');
        $product_qty = $request->input('product_qty');
        $product = Product::getProductByCart($product_id);
        $price = $product->offer_price;

        $wishlist_array = [];
        foreach (Cart::instance('wishlist')->content() as $item) {
            $wishlist_array[] = $item->id;
        }
        if (in_array($product_id, $wishlist_array)) {
            $response['present'] = true;
            $response['message'] = "Item is already in your wishlist";

        } else {
            $result = Cart::instance('wishlist')->add($product_id, $product->title, $product_qty, $price)->associate(Product::class);
            if ($result) {
                $response['status'] = true;
                $response['message'] = "Item has been saved in wishlist";
                $response['wishlist_count'] = Cart::instance('wishlist')->count();
            }
        }
        return json_encode($response);
    }

    public function moveToCart(Request $request)
    {
        $item = Cart::instance('wishlist')->get($request->input('rowId'));
        Cart::instance('wishlist')->remove($request->input('rowId'));
        $result = Cart::instance('shopping')->add($item->id, $item->name, 1, $item->price)->associate(Product::class);
        if ($result) {
            $response['status'] = true;
            $response['message'] = 'Item has been moved to cart';
            $response['cart_count'] = Cart::instance('shopping')->count();
        }
        if ($request->ajax()) {
            $header = view('frontend.layouts.header')->render();
            $wishlist = view('frontend.pages.wishlist.component._wishlist-list')->render();
            $response['header'] = $header;
            $response['wishlist'] = $wishlist;
        }
        return $response;
    }

    public function wishlistDelete(Request $request)
    {
        $id = $request->input('rowId');
        Cart::instance('wishlist')->remove($id);
        $response['status'] = true;
        $response['message'] = 'Item successfully removed from wishlist';

        if ($request->ajax()) {
            $header = view('frontend.layouts.header')->render();
            $wishlist = view('frontend.pages.wishlist.component._wishlist-list')->render();
            $response['header'] = $header;
            $response['wishlist'] = $wishlist;
        }
        return $response;
    }
}
