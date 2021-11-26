<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupon_count = Coupon::count();
        $coupons = Coupon::orderBy('id', 'DESC')->get();
        return view('backend.coupon.index', compact('coupons', 'coupon_count'));
    }

    public function couponStatus(Request $request)
    {
        if ($request->mode == 'true') {
            DB::table('coupons')->where('id', $request->id)->update(['status' => 'active']);
        } else {
            DB::table('coupons')->where('id', $request->id)->update(['status' => 'inactive']);
        }

        return response()->json(['msg' => 'Successfully updated status', 'status' => true]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.coupon.create');
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
            'code' => 'required|min:2|unique:coupons,code',
            'type' => 'required|in:fixed,percent',
            'status' => 'required|in:active,inactive',
            'value' => 'required|numeric'
        ]);
        $status = Coupon::create($validate_data);
        if ($status) {
            return redirect()->route('coupon.index')->with('success', 'Successfully created coupon');
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
        $coupon = Coupon::find($id);
        if ($coupon) {
            return view('backend.coupon.edit', compact('coupon'));
        } else {
            return back()->with('error', 'Coupon not found');
        }
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
        $coupon = Coupon::find($id);
        if ($coupon) {
            $validate_data = $this->validate($request, [
                'code' => 'required|min:2|exists:coupons,code',
                'type' => 'required|in:fixed,percent',
                'status' => 'required|in:active,inactive',
                'value' => 'required|numeric'
            ]);

            $status = $coupon->fill($validate_data)->save();
            if ($status) {
                return redirect()->route('coupon.index')->with('success', 'Successfully updated coupon');
            }

            return back()->with('error', 'Something went wrong!');
        }

        return back()->with('error', 'Coupon not found');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coupon = Coupon::find($id);
        if ($coupon) {
            $status = $coupon->delete();
            if ($status) {
                return redirect()->route('coupon.index')->with('success', 'Successfully deleted coupon');
            }
            return back()->with('error', 'Something went wrong!');
        }
        return back()->with('error', 'Data not found');
    }
}
