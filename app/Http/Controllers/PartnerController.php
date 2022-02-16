<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\AdminUser;
use App\Helpers\ImageUpload;
use App\Models\Moderator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class PartnerController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin_user');
    }

    public function index(Request $request)
    {
        if(Auth::guard('admin_user')->user()->cannot('haveAdminAccess', AdminUser::class) 
        && Auth::guard('admin_user')->user()->cannot('haveModeratorAccess', AdminUser::class)) {
            return view('error.401');
        }

        if($request->has('search_btn')) {
            $search = $request->search;

            $partners = Partner::where('system_id', 'like', "%{$search}%")
            ->orWhere('name', 'like', "%{$search}%")
            ->orWhere('mobile', 'like', "%{$search}%")
            ->orWhere('nid', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->orWhere('status', 'like', "%{$search}%")
            ->orWhere('category', 'like', "%{$search}%")
            ->orWhere('company', 'like', "%{$search}%")
            ->orWhere('created_by', 'like', "%{$search}%")
            ->orWhere('verified_by', 'like', "%{$search}%")
            ->distinct()->paginate(10);

            return view('partners.partnerList', compact('partners'));
        }

        $partners = Partner::paginate(10);
        return view('partners.partnerList', compact('partners'));
    }

    public function create()
    {
        if(Auth::guard('admin_user')->user()->cannot('haveAdminAccess', AdminUser::class)
        && Auth::guard('admin_user')->user()->cannot('haveModeratorAccess', AdminUser::class)) {
            return view('error.401');
        }
        return view('partners.addPartner');
    }

    public function store(Request $request, ImageUpload $image)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'mobile' => 'required|numeric|digits:11|unique:moderators,mobile',
            'email' => 'required|email|unique:moderators,email|unique:admin_users,email',
            'password' => 'required|min:8',
            'nid' => 'required|numeric|unique:moderators,nid',
            'address' => 'required',
            'zip_code' => 'numeric',
            'profile_pic' => 'required|image|max:500',
            'nid_pic' => 'required|image|max:500',
            'company' => 'required_if:category,Company|nullable',
            'trade_license' => 'required_if:category,Company|nullable',
            'trade_license_pic' => 'required_if:category,Company|image|max:500|nullable',
        ]);
        
        if (Partner::orderBy('created_at', 'desc')->first() !== null) {
            $last_id = Partner::orderBy('created_at', 'desc')->first()->system_id;
        } 
        else {
            $last_id = 'PT#1000';
        }
        $last_id = (int)substr($last_id, 3);

        $profilePic = $image->upload($request, 'profile_pic', 'partner_picture', $request->nid, false);
        $nidPic = $image->upload($request, 'nid_pic', 'partner_picture', $request->nid, false);
        $tradePic = $image->upload($request, 'trade_license_pic', 'partner_picture', $request->nid, false);

        if($request['category'] !== 'Company') {
            $request['trade_license'] = $request['company'] = $tradePic = null;
        }

        if(Auth::guard('admin_user')->user()->user_category == 'Admin') {
            $createdBy = 'Admin';
        }
        else {
            $mod = Moderator::where('email', Auth::guard('admin_user')->user()->email)->first();
            $createdBy = $mod->system_id;
        }          

        $partner = Partner::create([
            'system_id' => 'PT#' . $last_id + 1,
            'category' => $request['category'],
            'name' => $request['name'],
            'mobile' => $request['mobile'],
            'company' => $request['company'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'nid' => $request['nid'],
            'trade_license' => $request['trade_license'],
            'address' => $request['address'],
            'city' => $request['city'],
            'postal_code' => $request['zip_code'],
            'profile_picture' => $profilePic,
            'nid_picture' => $nidPic,
            'trade_license_picture' => $tradePic,
            'created_by' => $createdBy,
            'status' => "Pending"
        ]);

        if($partner) {
            $admin = AdminUser::create([
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'user_category' => 'Partner',
            ]);
            if($admin) {
                return redirect()->route('admin.partners.index')->with('success', 'New Partner Added Successfully');
            }
        }
    }

    public function show() {
        return view('error.404');
    }


    public function edit($id)
    {
        if(Auth::guard('admin_user')->user()->cannot('haveAdminAccess', AdminUser::class) 
        && Auth::guard('admin_user')->user()->cannot('haveModeratorAccess', AdminUser::class)) {
            return view('error.401');
        }
        
        $partner =  Partner::findOrFail($id);
        return view('partners.editPatner', compact('partner'));
    }

    public function update(Request $request, $id, ImageUpload $image)
    {
        $partner = Partner::findOrFail($id);

        if($request->status == 'Reject') {
            if($partner->delete()) {
                if(count(AdminUser::where('email', $partner->email)->get()) > 0) {
                    AdminUser::where('email', $partner->email)->first()->delete();
                }
                foreach($partner->vehicles as $vehicle) {
                    $vehicle->delete();
                    File::deleteDirectory(public_path('images/vehicle_picture/' . $vehicle->vehicle_number));
                }

                foreach($partner->drivers as $driver) {
                    $driver->delete();
                    File::deleteDirectory(public_path('images/driver_picture/' . $driver->nid));
                }
                
                foreach($partner->assistants as $assistant) {
                    $assistant->delete();
                    File::deleteDirectory(public_path('images/assistant_picture/' . $assistant->nid));
                }

                File::deleteDirectory(public_path('images/partner_picture/' . $partner->nid));   
                return redirect()->route('admin.partners.index')->with('success', 'Rejected Partner Deleted Successfully');
            }

        }

        $this->validate($request, [
            'name' => 'required|string',
            'mobile' => 'required|numeric|digits:11',
            'email' => 'required|email',
            'address' => 'required',
            'zip_code' => 'numeric',
            'profile_pic' => 'image|max:500',
            'nid_pic' => 'image|max:500',
            'company' => 'required_if:category,Company|nullable',
            'trade_license' => 'required_if:category,Company|nullable',
            'trade_license_pic' => 'nullable|image|max:500',
        ]);

        $profilePic = $image->upload($request, 'profile_pic', 'partner_picture', $partner->nid, false, $partner->profile_picture);
        $nidPic = $image->upload($request, 'nid_pic', 'partner_picture', $partner->nid, false, $partner->nid_picture);
        $tradePic = $image->upload($request, 'trade_license_pic', 'partner_picture', $partner->nid, false, $partner->trade_license_picture);

        $password = $partner->password;
        if($request->password !== null) {
            $password = Hash::make($request['password']);
        }

        $admin = AdminUser::where('email', $partner->email)->first();
        $admin->update([
            'email' => $request['email'],
            'password' => $password,
            'status' => $request->status,
        ]);

        $verifiedBy = $partner->verified_by;
        if($request->status !== $partner->status) {
            if(Auth::guard('admin_user')->user()->user_category == 'Admin') {
                $verifiedBy = 'Admin';
            }
            else {
                $mod = Moderator::where('email', Auth::guard('admin_user')->user()->email)->first();
                $verifiedBy = $mod->system_id;
            }          
        }

        $update = $partner->update([
            'category' => $request['category'],
            'name' => $request['name'],
            'mobile' => $request['mobile'],
            'company' => $request['company'],
            'email' => $request['email'],
            'password' => $password,
            'trade_license' => $request['trade_license'],
            'address' => $request['address'],
            'city' => $request['city'],
            'postal_code' => $request['zip_code'],
            'profile_picture' => $profilePic,
            'nid_picture' => $nidPic,
            'trade_license_picture' => $tradePic,
            'status' => $request->status,
            'verified_by' => $verifiedBy,    
        ]);

        if($update) {
            return redirect()->route('admin.partners.index')->with('success', 'Partner Updated Successfully');
        }
        else {
            return redirect()->route('admin.partners.create')->with('customError', 'Ooops! Something went wrong');
        }      
    }
}
