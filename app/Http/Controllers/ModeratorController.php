<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use App\Models\Moderator;
use App\Helpers\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ModeratorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin_user');
    }

    public function index()
    {
        if (Auth::guard('admin_user')->user()->cannot('haveAdminAccess', AdminUser::class)) {
            return view('error.401');
        }

        $moderators = Moderator::paginate(8);
        return view('moderators.moderatorList', compact('moderators'));
    }

    public function show()
    {
        return view('error.404');
    }

    public function create()
    {
        if (Auth::guard('admin_user')->user()->cannot('haveAdminAccess', AdminUser::class)) {
            return view('error.401');
        }

        return view('moderators.addModerator');
    }

    public function store(Request $request, ImageUpload $image)
    {

        $this->validate($request, [
            'name' => 'required|string',
            'mobile' => 'required|numeric|digits:11|unique:moderators,mobile',
            'email' => 'required|email|unique:moderators,email',
            'password' => 'required|min:8',
            'nid' => 'required|numeric|unique:moderators,nid',
            'address' => 'required',
            'postal_code' => 'numeric',
            'profile_pic' => 'required|image|max:500',
            'nid_pic' => 'required|image|max:500',
        ]);

        if (Moderator::orderBy('created_at', 'desc')->first() !== null) {
            $last_id = Moderator::orderBy('created_at', 'desc')->first()->system_id;
        } else {
            $last_id = 'MD#1000';
        }
        $last_id = (int)substr($last_id, 3);

        $profilePic = $image->upload($request, 'profile_pic', 'moderator_picture', $request->nid, false);
        $nidPic = $image->upload($request, 'nid_pic', 'moderator_picture', $request->nid, false);

        $moderator = Moderator::create([
            'system_id' => 'MD#' . $last_id + 1,
            'name' => $request['name'],
            'mobile' => $request['mobile'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'nid' => $request['nid'],
            'address' => $request['address'],
            'city' => $request['city'],
            'postal_code' => $request['postal_code'],
            'profile_pic' => $profilePic,
            'nid_pic' => $nidPic,
        ]);

        if ($moderator) {
            $admin = AdminUser::create([
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'user_category' => 'Moderator',
            ]);
            if ($admin) {
                return redirect()->route('admin.moderators.index')->with('success', 'New Moderator Added Successfully');
            }
        } else {
            return redirect()->route('admin.moderators.create')->with('customError', 'Ooops! Something went wrong');
        }
    }

    public function edit($id)
    {
        if (Auth::guard('admin_user')->user()->cannot('haveAdminAccess', AdminUser::class)) {
            return view('error.401');
        }

        $moderator = Moderator::findOrFail($id);
        return view('moderators.editModerator', compact('moderator'));
    }

    public function update(Request $request, $id, ImageUpload $image)
    {
        $moderator = Moderator::findOrFail($id);

        if ($request->status == 'Reject') {
            if (count(AdminUser::where('email', $moderator->email)->get()) > 0) {
                AdminUser::where('email', $moderator->email)->first()->delete();
            }
            $moderator->delete();
            return redirect()->route('admin.moderators.index')->with('success', 'Rejected Moderator Deleted Successfully');
        }

        $this->validate($request, [
            'name' => 'required|string',
            'mobile' => 'required|numeric|digits:11',
            'email' => 'required|email',
            'address' => 'required',
            'postal_code' => 'numeric',
            'profile_pic' => 'image|max:500',
            'nid_pic' => 'image|max:500',
        ]);

        $profilePic = $image->upload($request, 'profile_pic', 'moderator_picture', $moderator->nid, false, $moderator->profile_pic);
        $nidPic = $image->upload($request, 'nid_pic', 'moderator_picture', $moderator->nid, false, $moderator->nid_pic);

        $password = $moderator->password;
        if (!empty($request->password)) {
            $password = Hash::make($request['password']);
        }

        $admin = AdminUser::where('email', $moderator->email)->first();
        $admin->update([
            'email' => $request['email'],
            'password' => $password,
            'status' => $request->status,
        ]);

        $update = $moderator->update([
            'name' => $request['name'],
            'mobile' => $request['mobile'],
            'email' => $request['email'],
            'password' => $password,
            'address' => $request['address'],
            'city' => $request['city'],
            'postal_code' => $request['postal_code'],
            'profile_pic' => $profilePic,
            'nid_pic' => $nidPic,
            'status' => $request->status,
        ]);

        if ($update) {
            return redirect()->route('admin.moderators.index')->with('success', 'Moderator Updated Successfully');
        } else {
            return redirect()->route('admin.moderators.create')->with('customError', 'Ooops! Something went wrong');
        }
    }
}
