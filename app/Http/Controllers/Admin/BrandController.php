<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brand_count = Brand::count();
        $brands = Brand::orderBy('id', 'DESC')->get();
        return view('backend.brand.index', compact('brands', 'brand_count'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.brand.create');
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
            'photo' => 'required',
            'status' => 'nullable|in:active,inactive'
        ]);

        $slug = Str::slug($request->input('title'));
        $slug_count = Brand::where('slug', $slug)->count();
        if ($slug_count > 0) {
            $slug = time() . '_' . $slug;
        }
        $validate_data['slug'] = $slug;

        $brand = Brand::create($validate_data);
        if ($brand) {
            return redirect()->route('brand.index')->with('success', 'Successfully created brand');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = Brand::find($id);
        if ($brand) {
            return view('backend.brand.edit', compact('brand'));
        }
        return back()->with('error', 'Data not found');
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
        $brand = Brand::find($id);
        if ($brand) {
            $validate_data = $this->validate($request, [
                'title' => 'string|required',
                'photo' => 'required',
                'status' => 'nullable|in:active,inactive'
            ]);
            $status = $brand->fill($validate_data)->save();

            if ($status) {
                return redirect()->route('brand.index')->with('success', 'Successfully updated brand');
            }
            return back()->with('error', 'Something went wrong!');
        }
        return back()->with('error', 'Data not found');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::find($id);
        if ($brand) {
            $status = $brand->delete();
            if ($status) {
                return redirect()->route('brand.index')->with('success', 'Successfully deleted brand');
            }
            return back()->with('error', 'Something went wrong!');
        }
        return back()->with('error', 'Data not found');
    }

    public function brandStatus(Request $request)
    {
        if ($request->mode == 'true') {
            DB::table('brands')->where('id', $request->id)->update(['status' => 'active']);
        } else {
            DB::table('brands')->where('id', $request->id)->update(['status' => 'inactive']);
        }

        return response()->json(['msg' => 'Successfully updated status', 'status' => true]);

    }
}
