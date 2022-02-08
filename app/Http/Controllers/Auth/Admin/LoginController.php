<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    public  function  loginForm()
    {
        return view('backend.auth.login');
    }
    public  function  login(Request $request)
    {
        if (Auth::guard('admin')->attempt(['email'=>$request->email,'password'=>$request->password])) {
            return redirect()->route('admin')->with('success','You are logged in as admin');
        }
        return  back()->withInput($request->only('email'));
    }
}
