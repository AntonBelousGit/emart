<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Size;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    public function index()
    {
        $products_query = Product::query();
        $products_count = $products_query->count();
//        $products = $products_query->orderBy('id', 'DESC')->get();
        $products = $products_query->with('size')->orderBy('id', 'DESC')->get();
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

    public function productView(Request $request)
    {

        $product = Product::with('category', 'childCategory', 'brand', 'vendor', 'size')->find($request->id);

        $returnHTML = view('backend.products.layouts.modal-body', ['product' => $product])->render();

        return response()->json(['html' => $returnHTML]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cat = Category::query();
        $vendors = User::where('role', 'seller')->get();
        $categories = $cat->where('is_parent', 1)->get();
//        $childCategories = $cat->where('is_parent',1)->get();
        $sizes = Size::all();
        $brands = Brand::all();
        return view('backend.products.create', compact('brands', 'vendors', 'categories', 'sizes'));
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
            'additional_info' => 'string|nullable',
            'return_cancel' => 'string|nullable',
            'stock' => 'nullable|numeric',
            'price' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'photo' => 'required',
            'size_guide' => 'nullable',
            'cat_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'vendor_id' => 'required|exists:users,id',
            'size_id' => 'required|exists:sizes,id',
            'child_cat_id' => 'nullable|exists:categories,id',
            'condition' => 'required',
            'status' => 'nullable|in:active,inactive'
        ]);

        $slug = Str::slug($request->input('title'));
        $slug_count = Product::where('slug', $slug)->count();
        if ($slug_count > 0) {
            $slug = time() . '_' . $slug;
        }
        $validate_data['slug'] = $slug;
        $validate_data['offer_price'] = ($request->price - (($request->price * $request->discount) / 100));
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
        $product_attribute = ProductAttribute::where('product_id',$id)->orderBy('id','DESC')->get();
        if ($product) {
            return view('backend.products.product-attribute', compact('product','product_attribute'));
        }
        return back()->with('error', 'Product not found');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::where('is_parent', 1)->get();
        $vendors = User::where('role', 'seller')->get();
        $brands = Brand::all();
        $sizes = Size::all();

        if ($product) {
            return view('backend.products.edit', compact('product', 'categories', 'brands', 'vendors', 'sizes'));
        }
        return back()->with('error', 'Category not found');
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
        $product = Product::find($id);
        if ($product) {
            $validate_data = $this->validate($request, [
                'title' => 'string|required',
                'summary' => 'string|required',
                'description' => 'string|nullable',
                'additional_info' => 'string|nullable',
                'return_cancel' => 'string|nullable',
                'stock' => 'nullable|numeric',
                'price' => 'nullable|numeric',
                'discount' => 'nullable|numeric',
                'photo' => 'required',
                'size_guide' => 'nullable',
                'cat_id' => 'required|exists:categories,id',
                'brand_id' => 'required|exists:brands,id',
                'vendor_id' => 'required|exists:users,id',
                'size_id' => 'required|exists:sizes,id',
                'child_cat_id' => 'nullable|exists:categories,id',
                'condition' => 'required',
                'size' => 'nullable',
                'status' => 'nullable|in:active,inactive'
            ]);

            $validate_data['offer_price'] = ($request->price - (($request->price * $request->discount) / 100));

            $product = $product->fill($validate_data)->save();
            if ($product) {
                return redirect()->route('product.index')->with('success', 'Successfully updated product');
            } else {
                return back()->with('error', 'Something went wrong!');
            }
        } else {
            return back()->with('error', 'Product not found');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            $status = $product->delete();
            if ($status) {
                return redirect()->route('product.index')->with('success', 'Successfully deleted product');
            }
            return back()->with('error', 'Something went wrong!');
        }
        return back()->with('error', 'Data not found');
    }

    public function addProductAttribute(Request $request, $id)
    {
        $this->validate($request, [
            'size[]'=>'nullable|string',
            'original_price[]'=>'nullable|numeric',
            'offer_price[]'=>'nullable|numeric',
            'stock[]'=>'nullable|numeric',
        ]);
        $data = $request->all();

        foreach ($data['original_price'] as $key => $val) {
            if (!empty($val)) {
                $attribute = new ProductAttribute;
                $attribute['original_price'] = $val;
                $attribute['offer_price'] = $data['offer_price'][$key];
                $attribute['stock'] = $data['stock'][$key];
                $attribute['product_id'] = $id;
                $attribute['size'] = $data['size'][$key];
                $attribute->save();
            }
        }
        return redirect()->back()->with('success', 'Product attribute successfully added');
    }

    public function addProductAttributeDelete($id)
    {
        $product_attr = ProductAttribute::find($id);
        if ($product_attr) {
            $status = $product_attr->delete();
            if ($status) {
                return redirect()->back()->with('success', 'Product attribute successfully deleted!');
            }
            return back()->with('error', 'Something went wrong!');
        }
        return back()->with('error', 'Data not found');
    }
}
