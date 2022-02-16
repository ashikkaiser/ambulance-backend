<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin_user')->only('logout');
    }

    public function index() {
        return view('admin_login.login');
    }

    public function login(Request $request) {
        
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:5',
        ]);

        if(Auth::guard('admin_user')->attempt($request->only(['email', 'password']))) {
            if(Auth::guard('admin_user')->user()->status !== 'Active') {
                Auth::guard('admin_user')->logout();
                return redirect()->route('admin.login.index')->with('error', $request->user_category . ' not activated yet');
            }
            return redirect()->route('admin.index');
        }

        return redirect()->back()->with('error', 'Credentials does not match');
    }

    public function logout() {
        Auth::guard('admin_user')->logout();
        return redirect()->route('admin.login.index');
    }
}
