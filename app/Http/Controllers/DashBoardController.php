<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use App\Models\User;
use App\Models\Driver;
use App\Models\Partner;
use App\Models\Vehicle;
use App\Models\Assistant;
use App\Models\TripDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashBoardController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin_user');
    }

    public function index () {
        $authUser = Auth::guard('admin_user')->user();

        if($authUser->can('haveAdminAccess', AdminUser::class) || $authUser->can('haveModeratorAccess', AdminUser::class)
        || $authUser->can('haveAgentAccess', AdminUser::class)) {
            $partners = Partner::get();
            $users = User::get();
            $trips = TripDetails::get();
            $tripsToday = TripDetails::whereDate('created_at', Carbon::today())->get();
            $tripsYesterday = TripDetails::whereDate('created_at', Carbon::today()->subdays(1))->get();
            $tripsWeek = TripDetails::where('created_at', '>', Carbon::today()->subDays(7))->get();
            $tripsMonth = TripDetails::where('created_at', '>', Carbon::today()->subDays(30))->get();
            $revTripsToday = TripDetails::whereDate('created_at', Carbon::today())->sum('final_fair');
            $revTripsYesterday = TripDetails::whereDate('created_at', Carbon::today()->subdays(1))->sum('final_fair');
            $revTripsWeek = TripDetails::where('created_at', '>', Carbon::today()->subDays(7))->sum('final_fair');
            $revTripsMonth = TripDetails::where('created_at', '>', Carbon::today()->subDays(30))->sum('final_fair');
            $vehicles = Vehicle::with('drivers')->with('assistants')->get();
            // $onlineVehicles = Vehicle::whereExists(function($query) {
            //     $query->select(DB::raw('*'))->from('drivers')->whereRaw('drivers.vehicle_id = vehicles.id')->where(function($query){
            //         $query->where('online_status', true);
            //     });
            // })->get();
            // dd($onlineVehicles);
            $onlineVehicles=array();
            
            $drivers = Driver::with('vehicle')->with('partner')->get();
            $assistants = Assistant::get();
            return view('index.index', compact(
                'partners', 'users', 'trips', 'tripsToday', 'tripsYesterday', 'tripsWeek', 'tripsMonth', 'revTripsToday', 
                'revTripsYesterday', 'revTripsWeek', 'revTripsMonth',  'vehicles', 'onlineVehicles', 'drivers', 'assistants'
            ));
        }

        if($authUser->can('havePartnerAccess', AdminUser::class)) {
            $partner = Partner::where('email', $authUser->email)->first();
            $vehicles = $partner->vehicles;
            $drivers = $partner->drivers;
            $assistants = $partner->assistants;

            $tripDetails = TripDetails::get();
            $partnerVehicles = $partner->vehicles()->pluck('system_id')->toArray();
            $tripvehicles = $tripDetails->pluck('vehicle_id')->toArray();
            $partnerTripVehicles = array_intersect($tripvehicles, $partnerVehicles);

            $trips = TripDetails::where(function($query) use ($partnerTripVehicles) {
                foreach($partnerTripVehicles as $veh) {
                    $query->orWhere('vehicle_id', $veh);
                }
            })->get();

            $tripsToday = TripDetails::where(function($query) use ($partnerTripVehicles) {
                foreach($partnerTripVehicles as $veh) {
                    $query->orWhere('vehicle_id', $veh);
                }
            })->whereDate('created_at', Carbon::today())->get();

            $revTripsToday = TripDetails::where(function($query) use ($partnerTripVehicles) {
                foreach($partnerTripVehicles as $veh) {
                    $query->orWhere('vehicle_id', $veh);
                }
            })->whereDate('created_at', Carbon::today())->sum('final_fair');

            $tripsYesterday = TripDetails::where(function($query) use ($partnerTripVehicles) {
                foreach($partnerTripVehicles as $veh) {
                    $query->orWhere('vehicle_id', $veh);
                }
            })->whereDate('created_at', Carbon::today()->subDays(1))->get();

            $revTripsYesterday = TripDetails::where(function($query) use ($partnerTripVehicles) {
                foreach($partnerTripVehicles as $veh) {
                    $query->orWhere('vehicle_id', $veh);
                }
            })->whereDate('created_at', Carbon::today()->subDays(1))->sum('final_fair');

            $tripsWeek = TripDetails::where(function($query) use ($partnerTripVehicles) {
                foreach($partnerTripVehicles as $veh) {
                    $query->orWhere('vehicle_id', $veh);
                }
            })->whereDate('created_at', '>', Carbon::today()->subDays(7))->get();

            $revTripsWeek = TripDetails::where(function($query) use ($partnerTripVehicles) {
                foreach($partnerTripVehicles as $veh) {
                    $query->orWhere('vehicle_id', $veh);
                }
            })->whereDate('created_at', '>', Carbon::today()->subDays(7))->sum('final_fair');

            $tripsMonth = TripDetails::where(function($query) use ($partnerTripVehicles) {
                foreach($partnerTripVehicles as $veh) {
                    $query->orWhere('vehicle_id', $veh);
                }
            })->whereDate('created_at', '>', Carbon::today()->subDays(30))->get();

            $revTripsMonth = TripDetails::where(function($query) use ($partnerTripVehicles) {
                foreach($partnerTripVehicles as $veh) {
                    $query->orWhere('vehicle_id', $veh);
                }
            })->whereDate('created_at', '>', Carbon::today()->subDays(30))->sum('final_fair');

            // $onlineVehicles = Vehicle::where('partner_id', $partner->id)->whereExists(function($query) {
            //     $query->select(DB::raw('*'))->from('drivers')->whereRaw('drivers.vehicle_id = vehicles.id')->where(function($query){
            //         $query->where('online_status', true);
            //     });
            // })->get();
            $onlineVehicles =[];

            return view('index.index', compact(
                'trips', 'tripsToday', 'tripsYesterday', 'tripsWeek', 'tripsMonth', 'revTripsToday', 
                'revTripsYesterday', 'revTripsWeek', 'revTripsMonth', 'vehicles', 'drivers', 'assistants', 'onlineVehicles'
            ));
        }

    }

    public function user(Request $request) {
        $authUser = Auth::guard('admin_user')->user();
        if($authUser->can('haveAdminAccess', AdminUser::class) || $authUser->can('haveModeratorAccess', AdminUser::class)) {
            if($request->has('search_btn')) {
                $search = $request->search;

                $users = User::where('system_id', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%")
                ->orWhere('mobile', 'like', "%{$search}%")
                ->orWhere('nid_number', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%")
                ->distinct()->paginate(10);

                return view('users.usersList', compact('users'));
            }

            $users = User::paginate(10);
            return view('users.usersList', compact('users'));
        }
        return view('error.404');
    }
}
