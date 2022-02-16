<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Partner;
use App\Models\AdminUser;
use App\Models\Moderator;
use App\Helpers\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class DriverController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:admin_user')->except(['otpToken']);
    }

    public function index(Request $request)
    {
        $authUser = Auth::guard('admin_user')->user();

        if ($authUser->can('haveAdminAccess', AdminUser::class) || $authUser->can('haveModeratorAccess', AdminUser::class)) {
            if ($request->has('search_btn')) {
                $search = $request->search;

                $drivers = Driver::with('partner')
                    ->where('system_id', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%")
                    ->orWhere('nid', 'like', "%{$search}%")
                    ->orWhere('driving_license', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('created_by', 'like', "%{$search}%")
                    ->orWhere('verified_by', 'like', "%{$search}%")
                    ->orWhereExists(function ($query) use ($search) {
                        $query->select(DB::raw('*'))->from('partners')->whereRaw('partners.id = drivers.partner_id')
                            ->where(function ($query) use ($search) {
                                $query->orWhere('system_id', 'like', "%{$search}%")
                                    ->orWhere('name', 'like', "%{$search}%")
                                    ->orWhere('mobile', 'like', "%{$search}%")
                                    ->orWhere('email', 'like', "%{$search}%")
                                    ->orWhere('trade_license', 'like', "%{$search}%");
                            });
                    })->distinct()->paginate(6);

                return view('driver.driverList', compact('drivers'));
            }

            $drivers = Driver::with('partner')->paginate(6);
            return view('driver.driverList', compact('drivers'));
        }

        if ($authUser->can('havePartnerAccess', AdminUser::class)) {
            $partner = Partner::where('email', Auth::guard('admin_user')->user()->email)->first();

            if ($request->has('search_btn')) {
                $search = $request->search;

                $drivers = $partner->drivers()->where('system_id', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%")
                    ->orWhere('nid', 'like', "%{$search}%")
                    ->orWhere('driving_license', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->distinct()->paginate(6);

                return view('driver.driverList', compact('drivers'));
            }

            $drivers = $partner->drivers()->paginate(6);
            return view('driver.driverList', compact('drivers'));
        }

        return view('error.401');
    }

    public function show()
    {
        return view('error.404');
    }

    public function create()
    {
        if (
            Auth::guard('admin_user')->user()->cannot('havePartnerAccess', AdminUser::class)
            && Auth::guard('admin_user')->user()->cannot('haveModeratorAccess', AdminUser::class)
        ) {
            return view('error.401');
        }

        $partners = Partner::get();
        return view('driver.addDriver', compact('partners'));
    }

    public function store(Request $request, ImageUpload $image)
    {
        if (Auth::guard('admin_user')->user()->cannot('haveModeratorAccess', AdminUser::class)) {
            return view('error.401');
        }

        $this->validate($request, [
            'name' => 'required|string',
            'mobile' => 'required|numeric|digits:11|unique:moderators,mobile',
            'nid' => 'required|numeric|unique:moderators,nid',
            'driving_license' => 'required',
            'address' => 'required',
            'city' => 'required',
            'zip_code' => 'numeric',
            'profile_pic' => 'required|image|max:500',
            'nid_pic' => 'required|image|max:500',
            'driving_license_pic' => 'image|max:500|required',
        ]);

        // if (Auth::guard('admin_user')->user()->user_category == 'Moderator') {
        //     // if ($request->partner_select == '') {
        //     //     return redirect()->route('admin.drivers.index')->with('error', 'Please select partner first');
        //     // }
        //     // $partner = Partner::findOrFail($request->partner_select);
        //     $createdBy = Moderator::where('email', Auth::guard('admin_user')->user()->email)->first()->system_id;
        // } else {
        //     $partner = Partner::where('email', Auth::guard('admin_user')->user()->email)->first();
        //     $createdBy = $partner->system_id;
        // }
        $createdBy = Moderator::where('email', Auth::guard('admin_user')->user()->email)->first()->system_id;

        if (Driver::orderBy('created_at', 'desc')->first() !== null) {
            $last_id = Driver::orderBy('created_at', 'desc')->first()->system_id;
        } else {
            $last_id = 'DR#1000';
        }
        $last_id = (int)substr($last_id, 3);

        $profilePic = $image->upload($request, 'profile_pic', 'driver_picture', $request->nid, false);
        $nidPic = $image->upload($request, 'nid_pic', 'driver_picture', $request->nid, false);
        $drivingLicensePic = $image->upload($request, 'driving_license_pic', 'driver_picture', $request->nid, false);

        $driver = Driver::create([
            'system_id' => 'DR#' . $last_id + 1,
            'name' => $request['name'],
            'mobile' => $request['mobile'],
            'nid' => $request['nid'],
            'driving_license' => $request['driving_license'],
            'address' => $request['address'],
            'city' => $request['city'],
            'postal_code' => $request['zip_code'],
            'profile_pic' => $profilePic,
            'nid_pic' => $nidPic,
            'driving_license_pic' => $drivingLicensePic,
            'created_by' => $createdBy,
            'online_status' => false,
            'preferred_destination' => (int)1
        ]);

        if ($driver) {
            return redirect()->route('admin.drivers.index')->with('success', 'New Driver Added Successfully');
        }
    }

    public function edit($id)
    {
        $authUser = Auth::guard('admin_user')->user();
        $driver = Driver::findOrFail($id);
        // dd($driver);

        if ($authUser->can('haveAdminAccess', AdminUser::class)) {
            return view('driver.editDriver', compact('driver'));
        }

        if ($authUser->can('haveModeratorAccess', AdminUser::class)) {
            // $partner = Partner::findOrFail($driver->partner_id);
            // $partnerDrivers = $partner->drivers()->pluck('_id')->toArray();

            // if (!in_array($id, $partnerDrivers)) {
            //     return view('error.404');
            // }

            return view('driver.editDriver', compact('driver'));
        }
        return view('error.401');
    }

    public function update(Request $request, $id, ImageUpload $image)
    {
        $authUser = Auth::guard('admin_user')->user();
        $driver = Driver::findOrFail($id);

        if ($request->has('status')) {
            if ($request->status == 'Reject') {
                $driver->delete();
                File::deleteDirectory(public_path('images/driver_picture/' . $driver->nid));

                return redirect()->route('admin.drivers.index')->with('success', 'Rejected Driver deleted Successfully');
            }

            if ($request->status == 'Pending') {
                if ($driver->vehicle_id !== null) {
                    $driver->update(['vehicle_id' => null]);
                }
            }
        }

        if ($authUser->can('haveAdminAccess', AdminUser::class)) {
            $verifiedBy = $driver->verified_by;
            if ($request->status !== $driver->status) {
                $verifiedBy = 'Admin';
            }

            $driver->update([
                'status' => $request->status,
                'verified_by' => $verifiedBy
            ]);
            return redirect()->route('admin.drivers.index')->with('success', 'Driver updated successfully');
        }

        if ($authUser->can('haveModeratorAccess', AdminUser::class)) {
            $verifiedBy = $driver->verified_by;
            if ($request->status !== $driver->status) {
                $verifiedBy = Moderator::where('email', $authUser->email)->first()->system_id;
            }

            $driver->update([
                'status' => $request->status,
                'verified_by' => $verifiedBy
            ]);
        }

        if ($authUser->can('haveModeratorAccess', AdminUser::class)) {
            // $partner = Partner::findOrFail($driver->partner_id);
            // $partnerDrivers = $partner->drivers()->pluck('_id')->toArray();
            // if (!in_array($id, $partnerDrivers)) {
            //     return view('error.404');
            // }

            $this->validate($request, [
                'name' => 'required|string',
                'mobile' => 'required|numeric|digits:11',
                'driving_license' => 'required',
                'address' => 'required',
                'city' => 'required',
                'postal_code' => 'numeric',
                'profile_pic' => 'nullable|image|max:500',
                'nid_pic' => 'nullable|image|max:500',
                'driving_license_pic' => 'nullable|image|max:500',
                'verified_by' => $verifiedBy,
            ]);

            $profilePic = $image->upload($request, 'profile_pic', 'driver_picture', $driver->nid, false, $driver->profile_pic);
            $nidPic = $image->upload($request, 'nid_pic', 'driver_picture', $driver->nid, false, $driver->nid_pic);
            $drivingLicensePic = $image->upload($request, 'driving_license_pic', 'driver_picture', $driver->nid, false, $driver->nid_pic);

            $update = $driver->update([
                'name' => $request['name'],
                'mobile' => $request['mobile'],
                'driving_license' => $request['driving_license'],
                'address' => $request['address'],
                'city' => $request['city'],
                'postal_code' => $request['postal_code'],
                'profile_pic' => $profilePic,
                'nid_pic' => $nidPic,
                'driving_license_pic' => $drivingLicensePic,
            ]);

            if ($update) {
                return redirect()->route('admin.drivers.index')->with('success', 'Driver Updated Successfully');
            } else {
                return redirect()->route('admin.drivers.create')->with('customError', 'Ooops! Something went wrong');
            }
        }
    }

    public function destroy($id)
    {


        // dd(Auth::user());

        $partner = Partner::where('email', Auth::guard('admin_user')->user()->email)->first();
        $partnerDrivers = $partner->drivers()->pluck('_id')->toArray();
        if (!in_array($id, $partnerDrivers)) {
            return view('error.401');
        }
        $driver = Driver::findOrFail($id);
        if ($driver->delete()) {
            File::deleteDirectory(public_path('images/driver_picture/' . $driver->nid));
            return redirect()->route('admin.drivers.index')->with('success', 'Driver deleted Successfully');
        }
    }
}
