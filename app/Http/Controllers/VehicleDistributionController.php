<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleDistributionController extends Controller
{
    public function __contruct() {
        $this->middleware('auth:admin_user');
    }

    public function index() {
        
        if(Auth::guard('admin_user')->user()->cannot('havePartnerAccess', AdminUser::class)) {
            return view('error.401');
        }

        $partner = Partner::where('email', Auth::guard('admin_user')->user()->email)->first();
        $vehicles = $partner->vehicles()->where('status', 'Active')->with('drivers')->with('assistants')->get();

        $unAssignedDrivers = $partner->drivers()->where('status', 'Active')->where('vehicle_id', null)->get();
        $unAssignedAssistants = $partner->assistants()->where('status', 'Active')->where('vehicle_id', null)->get();

        return view('vehicles.vehicleDistributionList', compact('vehicles', 'unAssignedDrivers', 'unAssignedAssistants'));
    }

    public function distribution(Request $request, $id) {

        $partner = Partner::where('email', Auth::guard('admin_user')->user()->email)->first();
        $vehicle = $partner->vehicles()->findOrFail($id);
        
        if($request->type == 'driver') {
            if($request->action == 'Add') {
                if(count($vehicle->drivers()->get()) >= 2) {
                    return redirect()->route('admin.vehicle.distribution')
                    ->with('error', 'Maximum 2 drivers allowed');                   
                }
                $driver = $partner->drivers()->findOrFail($request->add);
                $driver->update([
                    'vehicle_id' => $id,
                ]);
                return redirect()->route('admin.vehicle.distribution')
                ->with('success', 'Driver '. $driver->system_id . ' added to vehicle ' . $vehicle->system_id);
            }

            elseif($request->action == 'Remove') {
                $driver = $partner->drivers()->findOrFail($request->remove);
                $driver->update([
                    'vehicle_id' => null,
                ]);
                return redirect()->route('admin.vehicle.distribution')
                ->with('success', 'Driver '. $driver->system_id . ' removed from vehicle ' . $vehicle->system_id);
            }

            else {
                return redirect()->route('admin.vehicle.distribution')
                ->with('error', 'wrong Credentials!!! please check your input');
            }            
        }

        if($request->type == 'assistant') {
            if($request->action == 'Add') {
                if(count($vehicle->assistants()->get()) >= 2) {
                    return redirect()->route('admin.vehicle.distribution')
                    ->with('error', 'Maximum 2 assistants allowed');                   
                }
                $assistant = $partner->assistants()->findOrFail($request->add);
                $assistant->update([
                    'vehicle_id' => $id,
                ]);
                return redirect()->route('admin.vehicle.distribution')
                ->with('success', 'Assistant '. $assistant->system_id . ' added to vehicle ' . $vehicle->system_id);
            }

            elseif($request->action == 'Remove') {
                $assistant = $partner->assistants()->findOrFail($request->remove);
                $assistant->update([
                    'vehicle_id' => null,
                ]);
                return redirect()->route('admin.vehicle.distribution')
                ->with('success', 'Assistant '. $assistant->system_id . ' removed from vehicle ' . $vehicle->system_id);
            }

            else {
                return redirect()->route('admin.vehicle.distribution')
                ->with('error', 'wrong Credentials!!! please check your input');
            }     
        }
    }
}
