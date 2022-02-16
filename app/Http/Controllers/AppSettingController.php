<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use App\Models\AppSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin_user');
    }

    public function index() 
    {
        if(Auth::guard('admin_user')->user()->cannot('haveAdminAccess', AdminUser::class)) {
            return view('error.401');
        }

        //
    }

    public function create()
    {
        if(Auth::guard('admin_user')->user()->cannot('haveAdminAccess', AdminUser::class)) {
            return view('error.401');
        }
        
        return view('settings.appSetting.addSetting');
    }

    public function store(Request $request)
    {
        AppSetting::create($request->all());
        return redirect()->route('admin.index');
    }
}
