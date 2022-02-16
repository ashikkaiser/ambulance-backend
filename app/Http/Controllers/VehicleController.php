<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Vehicle;
use App\Models\AdminUser;
use App\Models\Moderator;
use App\Helpers\ImageUpload;
use Illuminate\Http\Request;
use App\Models\VehiclesCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


class VehicleController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin_user');
    }

    public function index(Request $request) {

        $authUser = Auth::guard('admin_user')->user();

        if($authUser->can('haveAdminAccess', AdminUser::class) || $authUser->can('haveModeratorAccess', AdminUser::class)) {
            if($request->has('search_btn')) {
                $search = $request->search;

                $vehicles = Vehicle::with('partner')
                ->where('system_id', 'like', "%{$search}%")
                ->orWhere('vehicle_number', 'like', "%{$search}%")
                ->orWhere('vehicle_type', 'like', "%{$search}%")
                ->orWhere('sub_category', 'like', "%{$search}%")
                ->orWhere('owner_name', 'like', "%{$search}%")
                ->orWhere('owner_mobile', 'like', "%{$search}%")
                ->orWhere('owner_nid', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%")
                ->orWhere('created_by', 'like', "%{$search}%")
                ->orWhere('verified_by', 'like', "%{$search}%")
                ->orWhereExists(function($query) use($search){
                    $query->select(DB::raw('*'))->from('partners')->whereRaw('partners.id = vehicles.partner_id')
                    ->where(function($query) use($search){
                        $query->orWhere('system_id', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('mobile', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('trade_license', 'like', "%{$search}%");
                    });
                })->distinct()->paginate(6);

                return view('vehicles.vehicleList', compact('vehicles'));
            }

            $vehicles = Vehicle::with('partner')->paginate(6);
            return view('vehicles.vehicleList', compact('vehicles'));
        }
        
        if($authUser->can('havePartnerAccess', AdminUser::class)) {
            if($request->has('search_btn')) {
                $search = $request->search;

                $vehicles = Vehicle::with('partner')
                ->where('system_id', 'like', "%{$search}%")
                ->orWhere('vehicle_number', 'like', "%{$search}%")
                ->orWhere('vehicle_type', 'like', "%{$search}%")
                ->orWhere('sub_category', 'like', "%{$search}%")
                ->orWhere('owner_name', 'like', "%{$search}%")
                ->orWhere('owner_mobile', 'like', "%{$search}%")
                ->orWhere('owner_nid', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%")
                ->distinct()->paginate(6);

                return view('vehicles.vehicleList', compact('vehicles'));
            }

            $partner = Partner::where('email', Auth::guard('admin_user')->user()->email)->first();
            $vehicles = $partner->vehicles()->paginate(6);
            return view('vehicles.vehicleList', compact('vehicles'));
        }

        return view('error.401');
    }

    public function show() {
        return view('error.404');
    }

    public function create() {
        if(Auth::guard('admin_user')->user()->cannot('havePartnerAccess', AdminUser::class)
        && Auth::guard('admin_user')->user()->cannot('haveModeratorAccess', AdminUser::class)) {
            return view('error.401');
        }

        $partners = Partner::get();
        $categories = VehiclesCategory::get();
        return view('vehicles.addVehicles', compact('categories', 'partners'));        
    }

    public function store(Request $request, ImageUpload $image) {
        if(Auth::guard('admin_user')->user()->cannot('havePartnerAccess', AdminUser::class)
        && Auth::guard('admin_user')->user()->cannot('haveModeratorAccess', AdminUser::class)) {
            return view('error.401');
        }

        $this->validate($request, [
            'vehicle_type' => 'required',
            'vehicle_number' => 'required|unique:vehicles,vehicle_number',
            'vehicle_color' => 'required',
            'owner_name' => 'required',
            'owner_nid' => 'required|numeric',
            'owner_mobile' => 'required|numeric|digits:11',
            'owner_address' => 'required',
            'vehicle_1_pic' => 'required|image|max:1000',
            'vehicle_2_pic' => 'required|image|max:1000',
            'smart_card_pic' => 'required|image|max:1000',
            'tax_token_pic' => 'required|image|max:1000',
            'fitness_pic' => 'required|image|max:1000',
            'insurance_pic' => 'required|image|max:1000',
            'owner_profile_pic' => 'required|image|max:1000',
            'owner_nid_pic' => 'required|image|max:1000',
        ]);
        
        if(Auth::guard('admin_user')->user()->user_category == 'Moderator') {
            if($request->partner_select == '') {
                return redirect()->route('admin.vehicles.index')->with('error', 'Please select partner first');
            }
            $partner = Partner::findOrFail($request->partner_select);
            $createdBy = Moderator::where('email', Auth::guard('admin_user')->user()->email)->first()->system_id;
        }
        else {
            $partner = Partner::where('email', Auth::guard('admin_user')->user()->email)->first();
            $createdBy = $partner->system_id;
        }
      
        if(Vehicle::orderBy('created_at', 'desc')->first() !== null) {
            $last_id = Vehicle::orderBy('created_at', 'desc')->first()->system_id;
        }
        else {
            $last_id = 'VH#1000';
        }
        $last_id = (int)substr($last_id, 3);

        $vehicle1Pic = $image->upload($request, 'vehicle_1_pic', 'vehicle_picture', $request->vehicle_number, false);
        $vehicle2Pic = $image->upload($request, 'vehicle_2_pic', 'vehicle_picture', $request->vehicle_number, false);
        $smartCardPic = $image->upload($request, 'smart_card_pic', 'vehicle_picture', $request->vehicle_number, false);
        $taxTokenPic = $image->upload($request, 'tax_token_pic', 'vehicle_picture', $request->vehicle_number, false);
        $fitnessPic = $image->upload($request, 'fitness_pic', 'vehicle_picture', $request->vehicle_number, false);
        $insurancePic = $image->upload($request, 'insurance_pic', 'vehicle_picture', $request->vehicle_number, false);
        $ownerProfilePic = $image->upload($request, 'owner_profile_pic', 'vehicle_picture', $request->vehicle_number, false);
        $ownerNidPic = $image->upload($request, 'owner_nid_pic', 'vehicle_picture', $request->vehicle_number, false);

        $vehicle = $partner->vehicles()->create([
            'system_id' => 'VH#' . $last_id + 1,
            'vehicle_type' => str_replace('_', ' ', $request['vehicle_type']),
            'sub_category' => $request[$request['vehicle_type']], 
            'vehicle_number' => $request['vehicle_number'],
            'vehicle_color' => $request['vehicle_color'],
            'owner_name' => $request['owner_name'],
            'owner_nid' => $request['owner_nid'],
            'owner_mobile' => $request['owner_mobile'],
            'owner_address' => $request['owner_address'],
            'created_by' => $createdBy,
        ]);
        
        if($vehicle) {
            $picture = $vehicle->picture()->create([
                'vehicle_1_pic' => $vehicle1Pic,
                'vehicle_2_pic' => $vehicle2Pic,
                'smart_card_pic' => $smartCardPic,
                'tax_token_pic' => $taxTokenPic,
                'fitness_pic' => $fitnessPic,
                'insurance_pic' => $insurancePic,
                'owner_profile_pic' => $ownerProfilePic,
                'owner_nid_pic' => $ownerNidPic,
            ]);

            if($picture) {
                return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle Added Successfully');
            }
            return redirect()->route('admin.vehicles.create')->with('error', 'Ooops! Something went wrong');
        }
        return redirect()->route('admin.vehicles.create')->with('error', 'Ooops! Something went wrong');
    }

    public function edit($id) {
        $authUser = Auth::guard('admin_user')->user();
        $vehicle = Vehicle::findOrFail($id);

        if($authUser->can('haveAdminAccess', AdminUser::class)) {
            return view('vehicles.editVehicle', compact('vehicle'));
        }

        if($authUser->can('havePartnerAccess', AdminUser::class) || $authUser->can('haveModeratorAccess', AdminUser::class)) {
            $partner = Partner::findOrFail($vehicle->partner_id);

            $partnerVehicles = $partner->vehicles()->pluck('_id')->toArray();
            if(!in_array($id, $partnerVehicles)) {
                return view('error.404');
            }
            
            $vehicle = Vehicle::findOrFail($id);
            $categories = VehiclesCategory::get();
            return view('vehicles.editVehicle', compact('vehicle', 'categories'));
        }
        
        return view('error.401');
    }

    public function update(Request $request, $id, ImageUpload $image) {
        $authUser = Auth::guard('admin_user')->user();
        $vehicle = Vehicle::findOrFail($id);

        if($request->has('status')) {
            if($request->status == 'Reject') {
                if($vehicle->drivers !== null) {
                    foreach($vehicle->drivers as $driver) {
                        $driver->update(['vehicle_id' => null]);
                    }
                }
                if($vehicle->assistants !== null) {
                    foreach($vehicle->assistants as $assistant) {
                        $assistant->update(['vehicle_id' => null]);
                    }
                } 
                $vehicle->picture->delete();
                $vehicle->delete();
                File::deleteDirectory(public_path('images/vehicle_picture/' . $vehicle->vehicle_number));

                return redirect()->route('admin.vehicles.index')->with('success', 'Rejected Vehicle deleted Successfully');
            }

            if($request->status == 'Pending') {
                if($vehicle->drivers !== null) {
                    foreach($vehicle->drivers as $driver) {
                        $driver->update(['vehicle_id' => null]);
                    }
                }
                if($vehicle->assistants !== null) {
                    foreach($vehicle->assistants as $assistant) {
                        $assistant->update(['vehicle_id' => null]);
                    }
                }           
            }
        }

        if($authUser->can('haveModeratorAccess', AdminUser::class)) {
            $verifiedBy = $vehicle->verified_by;
            if($request->status !== $vehicle->status) {
                $verifiedBy = Moderator::where('email', $authUser->email)->first()->system_id;
            }

            $vehicle->update([
                'status' => $request->status,
                'verified_by' => $verifiedBy
            ]);
        }

        if($authUser->can('haveAdminAccess', AdminUser::class)) {

            $verifiedBy = $vehicle->verified_by;
            if($request->status !== $vehicle->status) {
                $verifiedBy = 'Admin';
            }

            $vehicle->update([
                'status' => $request->status,
                'verified_by' => $verifiedBy
            ]);

            return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle updated successfully');
        }

        if($authUser->can('havePartnerAccess', AdminUser::class) || $authUser->can('haveModeratorAccess', AdminUser::class)) {
            $partner = Partner::findOrFail($vehicle->partner_id);

            $partnerVehicles = $partner->vehicles()->pluck('_id')->toArray();
            if(!in_array($id, $partnerVehicles)) {
                return view('error.401');
            }

            $this->validate($request, [
                'vehicle_type' => 'required',
                'vehicle_color' => 'required',
                'owner_name' => 'required',
                'owner_nid' => 'required|numeric',
                'owner_mobile' => 'required|numeric|digits:11',
                'owner_address' => 'required',
                'vehicle_1_pic' => 'nullable|image|max:1000',
                'vehicle_2_pic' => 'nullable|image|max:1000',
                'smart_card_pic' => 'nullable|image|max:1000',
                'tax_token_pic' => 'nullable|image|max:1000',
                'fitness_pic' => 'nullable|image|max:1000',
                'insurance_pic' => 'nullable|image|max:1000',
                'owner_profile_pic' => 'nullable|image|max:1000',
                'owner_nid_pic' => 'nullable|image|max:1000',
            ]);

            $vehicle = Vehicle::findOrFail($id);

            $vehicle1Pic = $image->upload($request, 'vehicle_1_pic', 'vehicle_picture', $vehicle->vehicle_number, false, $vehicle->picture->vehicle_1_pic);
            $vehicle2Pic = $image->upload($request, 'vehicle_2_pic', 'vehicle_picture', $vehicle->vehicle_number, false, $vehicle->picture->vehicle_2_pic);
            $smartCardPic = $image->upload($request, 'smart_card_pic', 'vehicle_picture', $vehicle->vehicle_number, false, $vehicle->picture->smart_card_pic);
            $taxTokenPic = $image->upload($request, 'tax_token_pic', 'vehicle_picture', $vehicle->vehicle_number, false, $vehicle->picture->tax_token_pic);
            $fitnessPic = $image->upload($request, 'fitness_pic', 'vehicle_picture', $vehicle->vehicle_number, false, $vehicle->picture->fitness_pic);
            $insurancePic = $image->upload($request, 'insurance_pic', 'vehicle_picture', $vehicle->vehicle_number, false, $vehicle->picture->insurance_pic);
            $ownerProfilePic = $image->upload($request, 'owner_profile_pic', 'vehicle_picture', $vehicle->vehicle_number, false, $vehicle->picture->owner_profile_pic);
            $ownerNidPic = $image->upload($request, 'owner_nid_pic', 'vehicle_picture', $vehicle->vehicle_number, false, $vehicle->picture->owner_nid_pic);

            $update = $vehicle->update([
                'vehicle_type' => str_replace('_', ' ', $request['vehicle_type']),
                'sub_category' => $request[$request['vehicle_type']], 
                'vehicle_color' => $request['vehicle_color'],
                'owner_name' => $request['owner_name'],
                'owner_nid' => $request['owner_nid'],
                'owner_mobile' => $request['owner_mobile'],
                'owner_address' => $request['owner_address'],
            ]);

            if($update) {
                $picture = $vehicle->picture()->update([
                    'vehicle_1_pic' => $vehicle1Pic,
                    'vehicle_2_pic' => $vehicle2Pic,
                    'smart_card_pic' => $smartCardPic,
                    'tax_token_pic' => $taxTokenPic,
                    'fitness_pic' => $fitnessPic,
                    'insurance_pic' => $insurancePic,
                    'owner_profile_pic' => $ownerProfilePic,
                    'owner_nid_pic' => $ownerNidPic,
                ]);

                if($picture) {
                    return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle Added Successfully');
                }
                return redirect()->route('admin.vehicles.create')->with('error', 'Ooops! Something went wrong');
            }
            return redirect()->route('admin.vehicles.create')->with('error', 'Ooops! Something went wrong');
        }
        return view('error.401');
    }

    public function destroy($id) {
        $authUser = Auth::guard('admin_user')->user();

        if($authUser->can('havePartnerAccess', AdminUser::class)) {
            $partner = Partner::where('email', Auth::guard('admin_user')->user()->email)->first();
            $partnerVehicles = $partner->vehicles()->pluck('_id')->toArray();
            if(!in_array($id, $partnerVehicles)) {
                return view('error.401');
            }
            $vehicle = Vehicle::findOrFail($id);
            if($vehicle->delete()) {
                $vehicle->picture()->delete();
                File::deleteDirectory(public_path('images/vehicle_picture/' . $vehicle->vehicle_number));
                return redirect()->route('admin.vehicles.index')->with('success', 'vehicle deleted Successfully');
            }
        }

        return view('error.401');
    }
}
