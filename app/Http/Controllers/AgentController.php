<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\AdminUser;
use App\Helpers\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AgentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin_user');
    }

    public function index()
    {
        if (
            Auth::guard('admin_user')->user()->cannot('haveAdminAccess', AdminUser::class)
            && Auth::guard('admin_user')->user()->cannot('haveModeratorAccess', AdminUser::class)
        ) {
            return view('error.401');
        }

        $agents = Agent::paginate(8);
        return view('agents.agentList', compact('agents'));
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

        return view('agents.addAgent');
    }

    public function store(Request $request, ImageUpload $image)
    {

        $this->validate($request, [
            'name' => 'required|string',
            'mobile' => 'required|numeric|digits:11|unique:agents,mobile',
            'email' => 'required|email|unique:agents,email',
            'password' => 'required|min:8',
            'nid' => 'required|numeric|unique:agents,nid',
            'address' => 'required',
            'postal_code' => 'numeric',
            'profile_pic' => 'required|image|max:500',
            'nid_pic' => 'required|image|max:500',
        ]);

        if (Agent::orderBy('created_at', 'desc')->first() !== null) {
            $last_id = Agent::orderBy('created_at', 'desc')->first()->system_id;
        } else {
            $last_id = 'AG#1000';
        }
        $last_id = (int)substr($last_id, 3);

        $profilePic = $image->upload($request, 'profile_pic', 'agent_picture', $request->nid, false);
        $nidPic = $image->upload($request, 'nid_pic', 'agent_picture', $request->nid, false);

        $agent = Agent::create([
            'system_id' => 'AG#' . $last_id + 1,
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
            'status' => false
        ]);

        if ($agent) {
            $admin = AdminUser::create([
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'user_category' => 'Agent',
            ]);
            if ($admin) {
                return redirect()->route('admin.agents.index')->with('success', 'New Agent Added Successfully');
            }
        } else {
            return redirect()->route('admin.agents.create')->with('customError', 'Ooops! Something went wrong');
        }
    }

    public function edit($id)
    {
        if (Auth::guard('admin_user')->user()->cannot('haveAdminAccess', AdminUser::class)) {
            return view('error.401');
        }

        $agent = Agent::findOrFail($id);
        return view('agents.editAgent', compact('agent'));
    }

    public function update(Request $request, $id, ImageUpload $image)
    {
        $agent = Agent::findOrFail($id);

        if ($request->status == 'Reject') {
            if (count(AdminUser::where('email', $agent->email)->get()) > 0) {
                AdminUser::where('email', $agent->email)->first()->delete();
            }
            $agent->delete();
            return redirect()->route('admin.agents.index')->with('success', 'Rejected Agent Deleted Successfully');
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

        $profilePic = $image->upload($request, 'profile_pic', 'agent_picture', $agent->nid, false, $agent->profile_pic);
        $nidPic = $image->upload($request, 'nid_pic', 'agent_picture', $agent->nid, false, $agent->nid_pic);

        $password = $agent->password;
        if (!empty($request->password)) {
            $password = Hash::make($request['password']);
        }

        $admin = AdminUser::where('email', $agent->email)->first();
        $admin->update([
            'email' => $request['email'],
            'password' => $password,
            'status' => $request->status,
        ]);

        $update = $agent->update([
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
            return redirect()->route('admin.agents.index')->with('success', 'Agent Updated Successfully');
        } else {
            return redirect()->route('admin.agents.create')->with('customError', 'Ooops! Something went wrong');
        }
    }
}
