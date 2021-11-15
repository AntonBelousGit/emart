<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user_count = User::count();
        $users = User::orderBy('id', 'DESC')->get();
        return view('backend.user.index', compact('users', 'user_count'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validate_data = $this->validate($request, [
            'full_name' => 'string|required',
            'username' => 'string|required',
            'email' => 'email|required|unique:users,email',
            'phone' => 'string|nullable',
            'address' => 'string|nullable',
            'photo' => 'required',
            'password' => 'required|min:4',
            'role' => 'nullable|in:admin,vendor,customer',
            'status' => 'nullable|in:active,inactive'
        ]);

        $validate_data['password']= Hash::make($request->password);

        $category = User::create($validate_data);
        if ($category) {
            return redirect()->route('user.index')->with('success', 'Successfully created user');
        } else {
            return back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        if ($user) {
            return view('backend.user.edit', compact('user'));
        } else {
            return back()->with('error', 'User not found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $validate_data = $this->validate($request, [
                'full_name' => 'string|required',
                'username' => 'string|required',
                'email' => 'email|required|exists:users,email',
                'phone' => 'string|nullable',
                'address' => 'string|nullable',
                'photo' => 'required',
//                'password' => 'required|min:4',
                'role' => 'nullable|in:admin,vendor,customer',
                'status' => 'nullable|in:active,inactive'
            ]);

            $user = $user->fill($validate_data)->save();
            if ($user) {
                return redirect()->route('user.index')->with('success', 'Successfully updated user');
            } else {
                return back()->with('error', 'Something went wrong!');
            }
        } else {
            return back()->with('error', 'User not found');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $status = $user->delete();
            if ($status) {
                return redirect()->route('user.index')->with('success', 'Successfully deleted user');
            }
            return back()->with('error', 'Something went wrong!');
        }
        return back()->with('error', 'Data not found');
    }

    public function userStatus(Request $request)
    {
        if ($request->mode == 'true') {
            DB::table('users')->where('id', $request->id)->update(['status' => 'active']);
        } else {
            DB::table('users')->where('id', $request->id)->update(['status' => 'inactive']);
        }

        return response()->json(['msg' => 'Successfully updated status', 'status' => true]);
    }
    public function userView(Request $request){

        $user = User::find($request->id);

        $returnHTML = view('backend.user.layouts.modal-body',['user'=> $user])->render();

        return response()->json( ['html'=>$returnHTML]);
    }
}
