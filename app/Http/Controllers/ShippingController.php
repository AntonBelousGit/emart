<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shippings = Shipping::orderBy('id', 'DESC')->get();
        return view('backend.shipping.index', compact('shippings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.shipping.create');
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
            'shipping_address' => 'string|required',
            'delivery_time' => 'string|required',
            'delivery_charge' => 'numeric|nullable',
            'status' => 'nullable|in:active,inactive',
        ]);

        $shipping = Shipping::create($validate_data);

        if ($shipping) {
            return redirect()->route('shipping.index')->with('success', 'Successfully created shipping');
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
        $shipping = Shipping::find($id);
        if ($shipping) {
            return view('backend.shipping.edit', compact('shipping'));
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
        $shipping = Shipping::find($id);
        if ($shipping) {
            $validate_data = $this->validate($request, [
                'shipping_address' => 'string|required',
                'delivery_time' => 'string|required',
                'delivery_charge' => 'numeric|nullable',
                'status' => 'nullable|in:active,inactive',
            ]);
            $status = $shipping->fill($validate_data)->save();

            if ($status) {
                return redirect()->route('shipping.index')->with('success', 'Successfully updated shipping');
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
        $shipping = Shipping::find($id);
        if ($shipping) {
            $status = $shipping->delete();
            if ($status) {
                return redirect()->route('shipping.index')->with('success', 'Successfully deleted shipping');
            }
            return back()->with('error', 'Something went wrong!');
        }
        return back()->with('error', 'Data not found');  //
    }

    public function shippingStatus(Request $request)
    {
        if ($request->mode == 'true') {
            DB::table('shippings')->where('id', $request->id)->update(['status' => 'active']);
        } else {
            DB::table('shippings')->where('id', $request->id)->update(['status' => 'inactive']);
        }

        return response()->json(['msg' => 'Successfully updated status', 'status' => true]);
    }
}
