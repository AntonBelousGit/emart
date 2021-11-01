<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products_query = Product::query();
        $products_count = $products_query->count();
//        $products = $products_query->orderBy('id', 'DESC')->get();
        $products = DB::table('products')->orderBy('id', 'DESC')->get();;
        return view('backend.products.index', compact('products', 'products_count'));
    }

    public function productStatus(Request $request)
    {
        if ($request->mode == 'true') {
            DB::table('products')->where('id', $request->id)->update(['status' => 'active']);
        } else {
            DB::table('products')->where('id', $request->id)->update(['status' => 'inactive']);
        }

        return response()->json(['msg' => 'Successfully updated status', 'status' => true]);
    }

    public function productView(Request $request){

        $product = Product::with('category','childCategory','brand','vendor')->find($request->id);

        return response()->json([
            'category' => $product->category->title,
            'childCategory' => $product->childCategory->title,
            'brand' => $product->brand->title,
            'vendor' => $product->vendor->full_name,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cat = Category::query();
        $vendors = User::where('role', 'vendor')->get();
        $categories = $cat->where('is_parent', 1)->get();
//        $childCategories = $cat->where('is_parent',1)->get();
        $brands = Brand::all();
        return view('backend.products.create', compact('brands', 'vendors', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate_data = $this->validate($request, [
            'title' => 'string|required',
            'summary' => 'string|required',
            'description' => 'string|nullable',
            'stock' => 'nullable|numeric',
            'price' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'photo' => 'required',
            'cat_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'vendor_id' => 'required|exists:users,id',
            'child_cat_id' => 'nullable|exists:categories,id',
            'condition' => 'required',
            'size' => 'nullable',
            'status' => 'nullable|in:active,inactive'
        ]);


        $slug = Str::slug($request->input('title'));
        $slug_count = Product::where('slug', $slug)->count();
        if ($slug_count > 0) {
            $slug = time() . '_' . $slug;
        }
        $validate_data['slug'] = $slug;
        $validate_data['offer_price'] = ($request->price - (($request->price * $request->discount) / 100));
//        return $validate_data;
        $status = Product::create($validate_data);
        if ($status) {
            return redirect()->route('product.index')->with('success', 'Successfully created product');
        } else {
            return back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if ($product) {
            return view('backend.categories.view', compact('product'));
        } else {
            return back()->with('error', 'Product not found');
        }
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
