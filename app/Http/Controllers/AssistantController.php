<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Assistant;
use App\Models\Moderator;
use App\Helpers\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AssistantController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin_user');
    }

    public function index(Request $request)
    {
        $authUser = Auth::guard('admin_user')->user();

        if($authUser->can('haveAdminAccess', AdminUser::class) || $authUser->can('haveModeratorAccess', AdminUser::class)) {
            if($request->has('search_btn')) {
                $search = $request->search;

                $assistants = Assistant::with('partner')
                ->where('system_id', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%")
                ->orWhere('mobile', 'like', "%{$search}%")
                ->orWhere('nid', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%")
                ->orWhere('created_by', 'like', "%{$search}%")
                ->orWhere('verified_by', 'like', "%{$search}%")
                ->orWhereExists(function($query) use($search){
                    $query->select(DB::raw('*'))->from('partners')->whereRaw('partners.id = assistants.partner_id')
                    ->where(function($query) use($search){
                        $query->orWhere('system_id', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('mobile', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('trade_license', 'like', "%{$search}%");
                    });
                })->distinct()->paginate(6);

                return view('assistant.assistantList', compact('assistants'));
            }

            $assistants = Assistant::with('partner')->paginate(6);
            return view('assistant.assistantList', compact('assistants'));
        }

        if($authUser->can('havePartnerAccess', AdminUser::class)) {
            $partner = Partner::where('email', Auth::guard('admin_user')->user()->email)->first();

            if($request->has('search_btn')) {
                $search = $request->search;

                $assistants = $partner->assistants()->where('system_id', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%")
                ->orWhere('mobile', 'like', "%{$search}%")
                ->orWhere('nid', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%")
                ->distinct()->paginate(6);

                return view('assistant.assistantList', compact('assistants'));
            }

            $assistants = $partner->assistants()->paginate(6);
            return view('assistant.assistantList', compact('assistants'));
        }
        
        return view('error.401');

    }

    public function create()
    {
        if(Auth::guard('admin_user')->user()->cannot('haveModeratorAccess', AdminUser::class)) {
            return view('error.401');
        }

        $partners = Partner::get();
        return view('assistant.addAssistant', compact('partners'));
    }

    public function show() {
        return view('error.404');
    }

    public function store(Request $request, ImageUpload $image)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'mobile' => 'required|numeric|digits:11|unique:moderators,mobile',
            'nid' => 'required|numeric|unique:moderators,nid',
            'driving_license' => 'nullable',
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'numeric',
            'profile_pic' => 'required|image|max:500',
            'nid_pic' => 'required|image|max:500',
            'driving_license_pic' => 'nullable|image|max:500',
        ]);
        
        // if(Auth::guard('admin_user')->user()->user_category == 'Moderator') {
        //     if($request->partner_select == '') {
        //         return redirect()->route('admin.assistants.index')->with('error', 'Please select partner first');
        //     }
        //     $partner = Partner::findOrFail($request->partner_select);
        //     $createdBy = Moderator::where('email', Auth::guard('admin_user')->user()->email)->first()->system_id;
        // }
        // else {
        //     $partner = Partner::where('email', Auth::guard('admin_user')->user()->email)->first();
        //     $createdBy = $partner->system_id;
        // }
        $createdBy = Moderator::where('email', Auth::guard('admin_user')->user()->email)->first()->system_id;
        
        if (Assistant::orderBy('created_at', 'desc')->first() !== null) {
            $last_id = Assistant::orderBy('created_at', 'desc')->first()->system_id;
        } 
        else {
            $last_id = 'AST#1000';
        }
        $last_id = (int)substr($last_id, 4);

        $profilePic = $image->upload($request, 'profile_pic', 'assistant_picture', $request->nid, false);
        $nidPic = $image->upload($request, 'nid_pic', 'assistant_picture', $request->nid, false);
        $drivingLicensePic = $image->upload($request, 'driving_license_pic', 'assistant_picture', $request->nid, false);

        $assistant = Assistant::create([
            'system_id' => 'AST#' . $last_id + 1,
            'name' => $request['name'],
            'mobile' => $request['mobile'],
            'nid' => $request['nid'],
            'driving_license' => $request['driving_license'],
            'address' => $request['address'],
            'city' => $request['city'],
            'postal_code' => $request['postal_code'],
            'profile_pic' => $profilePic,
            'nid_pic' => $nidPic,
            'driving_license_pic' => $drivingLicensePic,
            'created_by' => $createdBy,
        ]);

        if($assistant) {
            return redirect()->route('admin.assistants.index')->with('success', 'New Assistant Added Successfully');
        }
    }
    
    public function edit($id)
    {
        $authUser = Auth::guard('admin_user')->user();
        $assistant = Assistant::findOrFail($id);

        if($authUser->can('haveAdminAccess', AdminUser::class)) {
            return view('assistant.editAssistant', compact('assistant'));
        }

        if($authUser->can('haveModeratorAccess', AdminUser::class)) {
            // $partner = Partner::findOrFail($assistant->partner_id);
            // $partnerAssistants = $partner->assistants()->pluck('_id')->toArray();

            // if(!in_array($id, $partnerAssistants)) {
            //     return view('error.404');
            // }

            return view('assistant.editAssistant', compact('assistant'));
        }
        return view('error.401');        
    }

    public function update(Request $request, $id, ImageUpload $image)
    {
        $authUser = Auth::guard('admin_user')->user();
        $assistant = Assistant::findOrFail($id);

        if($request->has('status')) {
            if($request->status == 'Reject') {
                $assistant->delete();
                File::deleteDirectory(public_path('images/assistant_picture/' . $assistant->nid));

                return redirect()->route('admin.assistants.index')->with('success', 'Rejected Assistant deleted Successfully');
            }

            if($request->status == 'Pending') {
                if($assistant->vehicle_id !== null) {
                    $assistant->update(['vehicle_id' => null]);
                }         
            }
        }

        if($authUser->can('haveAdminAccess', AdminUser::class)) {
            $verifiedBy = $assistant->verified_by;
            if($request->status !== $assistant->status) {
                $verifiedBy = 'Admin';
            }

            $assistant->update([
                'status' => $request->status,
                'verified_by' => $verifiedBy
            ]);
            return redirect()->route('admin.assistants.index')->with('success', 'Driver updated successfully');
        }

        if($authUser->can('haveModeratorAccess', AdminUser::class)) {
            $verifiedBy = $assistant->verified_by;
            if($request->status !== $assistant->status) {
                $verifiedBy = Moderator::where('email', $authUser->email)->first()->system_id;
            }

            $assistant->update([
                'status' => $request->status,
                'verified_by' => $verifiedBy
            ]);
        }

        if($authUser->can('haveModeratorAccess', AdminUser::class)) {
            // $partner = Partner::findOrFail($assistant->partner_id);
            // $partnerAssistants = $partner->assistants()->pluck('_id')->toArray();
            // if(!in_array($id, $partnerAssistants)) {
            //     return view('error.404');
            // }
    
            $assistant = Assistant::findOrFail($id);
    
            $this->validate($request, [
                'name' => 'required|string',
                'mobile' => 'required|numeric|digits:11',
                'driving_license' => 'nullable',
                'address' => 'required',
                'city' => 'required',
                'postal_code' => 'numeric',
                'profile_pic' => 'nullable|image|max:500',
                'nid_pic' => 'nullable|image|max:500',
                'driving_license_pic' => 'nullable|image|max:500',
            ]);
    
            $profilePic = $image->upload($request, 'profile_pic', 'assistant_picture', $assistant->nid, false, $assistant->profile_pic);
            $nidPic = $image->upload($request, 'nid_pic', 'assistant_picture', $assistant->nid, false, $assistant->nid_pic);
            $drivingLicensePic = $image->upload($request, 'driving_license_pic', 'assistant_picture', $assistant->nid, false, $assistant->nid_pic);
    
            $update = $assistant->update([
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
    
            if($update) {
                return redirect()->route('admin.assistants.index')->with('success', 'Assistant Updated Successfully');
            }
            else {
                return redirect()->route('admin.assistants.create')->with('customError', 'Ooops! Something went wrong');
            }  
        }  
    }

    public function destroy($id) {
        $partner = Partner::where('email', Auth::guard('admin_user')->user()->email)->first();
        $partnerAssistants = $partner->assistants()->pluck('_id')->toArray();
        if(!in_array($id, $partnerAssistants)) {
            return view('error.401');
        }
        $assistant = Assistant::findOrFail($id);
        if($assistant->delete()) {
            File::deleteDirectory(public_path('images/assistant_picture/' . $assistant->nid));
            return redirect()->route('admin.assistants.index')->with('success', 'Assistant deleted Successfully');
        }
    }
}
