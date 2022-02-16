<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Partner;
use App\Models\Vehicle;
use App\Models\TripDetails;
use Illuminate\Http\Request;
use App\Models\VehiclesCategory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AppNotification;
use App\Models\District;
use App\Models\User;
use TeamPickr\DistanceMatrix\Licenses\StandardLicense;
use TeamPickr\DistanceMatrix\DistanceMatrix;

class TripDetailsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin_user');
    }

    public function index(Request $request)
    {
        $search = (!empty($request->search)) ? $request->search : '';
        $tripDetails = TripDetails::with('vehicle')->with('driver')->with('getUser')->paginate(8);

        $auth = Auth::guard('admin_user')->user();

        if ($auth->can('haveAdminAccess', App\Models\AdminUser::class) || $auth->can('haveAgentAccess', App\Models\AdminUser::class)) {
            if ($request->has('search_btn')) {
                if ($auth->can('haveAgentAccess', App\Models\AdminUser::class)) {
                    $tripDetails = TripDetails::with('vehicle')->with('driver')->with('getUser')
                        ->where('booking_id', intval($search))
                        ->orWhere('driver_id', 'like', "%{$search}%")
                        ->orWhere('user_id', 'like', "%{$search}%")
                        ->whereBetween('created_at', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()])
                        ->paginate(8);
                } else {
                    $tripDetails = TripDetails::with('vehicle')->with('driver')->with('getUser')
                        ->where('vehicle_id', 'like', "%{$search}%")
                        ->orWhere('booking_id', 'like', "%{$search}%")
                        ->orWhere('driver_id', 'like', "%{$search}%")
                        ->orWhere('user_id', 'like', "%{$search}%")
                        ->paginate(8);
                }

                return view('trip_details.tripList', compact('tripDetails', 'search'));
            }

            if ($auth->can('haveAgentAccess', App\Models\AdminUser::class)) {
                $tripDetails = TripDetails::with('vehicle')->with('driver')->with('getUser')->whereBetween('created_at', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()])->paginate(8);
                // dd($tripDetails);
            }
            if ($auth->can('haveAdminAccess', App\Models\AdminUser::class)) {
                $tripDetails = TripDetails::with('vehicle')->with('driver')->with('getUser')->paginate(8);
            }

            return view('trip_details.tripList', compact('tripDetails', 'search'));
        }

        if (Auth::guard('admin_user')->user()->can('havePartnerAccess', App\Models\AdminUser::class)) {
            $partner = Partner::where('email', Auth::guard('admin_user')->user()->email)->first();
            $partnerVehicles = $partner->vehicles()->pluck('system_id')->toArray();
            $tripvehicles = $tripDetails->pluck('vehicle_id')->toArray();
            $partnerTripVehicles = array_intersect($tripvehicles, $partnerVehicles);

            $tripDetails = TripDetails::where(function ($query) use ($partnerTripVehicles) {
                foreach ($partnerTripVehicles as $veh) {
                    $query->orWhere('vehicle_id', $veh);
                }
            })->paginate(8);

            if ($request->has('search_btn')) {
                $tripDetails = TripDetails::where(function ($query) use ($partnerTripVehicles) {
                    foreach ($partnerTripVehicles as $veh) {
                        $query->orWhere('vehicle_id', $veh);
                    }
                })->where(function ($query) use ($search) {
                    $query->where('vehicle_id', 'like', "%{$search}%")
                        ->orWhere('driver_id', 'like', "%{$search}%")
                        ->orWhere('user_id', 'like', "%{$search}%");
                })->paginate(8);

                return view('trip_details.tripList', compact('tripDetails', 'search'));
            }

            return view('trip_details.tripList', compact('tripDetails', 'search'));
        }
    }

    public function paymentSubmit(Request $request, $id)
    {
        $this->validate($request, [
            'trip_amount' => 'required|numeric'
        ]);

        $trip = TripDetails::findOrFail($id);
        if ($trip->booking_status == 'Processed' || $trip->booking_status == 'processed') {
            return redirect()->route('admin.tripDetails.list')->with('error', 'Payment already submitted');
        }
        $payment = $trip->systemRevenue()->create([
            'payment_amount' => $request->trip_amount,
        ]);
        if ($payment) {
            $trip->update([
                'booking_status' => 'processed',
            ]);

            paymentNotification($trip);
            userProcessedNotification($trip);

            return redirect()->route('admin.tripDetails.list');
        }
    }

    public function create()
    {
        if (Auth::guard('admin_user')->user()->cannot('haveAgentAccess', AdminUser::class)) {
            return view('error.401');
        }

        // if (request()->ajax()) {

        // }
        $districts = District::all();
        $categories = VehiclesCategory::get();
        return view('trip_details.addTrip', compact('categories', 'districts'));
    }
    public function store(Request $request)
    {


        dd($request->all());
        $subcat = VehiclesCategory::find($request->subcat);
        $user = new User();
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->nid = $request->nid_number;
        if ($user->save()) {
            $trip = new TripDetails();
            $trip->booking_date = Carbon::now();
            $trip->ambulance_type = $request->veiclesCategory;
            $trip->user_id = $user->id;
            $trip->booking_otp = rand(11111, 99999);
            $trip->start_point = "Dhaka Medical College Hospital";
            $trip->end_point = $request->destination;
            $trip->district = District::where('District', $request->district)->first()->id;
            $trip->booking_id = rand(11111111, 99999999);
            $trip->booking_status = "pending";
            // $trip->start_lat_long = array('');
            $trip->end_lat_long = $request->destination;
            $trip->estimated_time = $request->estimatedTime;
            $trip->estimated_distance = $request->estimatedDistance;
            $trip->estimated_fair = $request->estimated_fair;
            // $trip->save();
        }
        //     $trip = new TripDetails();
        //     $trip->booking_date = Carbon::now();
        //     $trip->ambulance_type = $request->veiclesCategory;
        //     $trip->user_id = Auth::user()->id;
        //     $trip->booking_otp = rand(11111, 99999);
        //     $trip->start_point = "Dhaka Medical College Hospital";
        //     $trip->end_point = $request->end_point;
        //     $trip->district = District::where('District', $request->district)->first()->id;
        //     $trip->booking_id = rand(11111111, 99999999);
        //     $trip->booking_status = "pending";
        //     $trip->start_lat_long = $request->origin;
        //     $trip->end_lat_long = $request->destination;
        //     $trip->estimated_time = $request->estimatedTime;
        //     $trip->estimated_distance = $request->estimatedDistance;
        //     $trip->estimated_fair = $request->estimatedFair;
        //     if ($trip->save()) {
        //         $push  = new AppNotification;
        //         $push->push([
        //             'to' => Auth::user()->pushToken,
        //             'title' => "Booking Request Successful",
        //             'body' => "Your booking Request has been confirmed. TOKEN DMBK#" . $trip->booking_id,
        //         ]);
        //         $this->SearchDriver($trip);
        //         return response()->json([
        //             'success' => true,
        //             'message' => "Booking Request Success",
        //             'booking_code' => "DMBK#" . $trip->booking_id,
        //             'trip' => $trip

        //         ]);
        //     }
    }

    public function distanceCalculation(Request $request)
    {
        $subcat = VehiclesCategory::find($request->subcat);
        $apiKey = "AIzaSyA9NjyJPS6SI3x2hK1LueRQb74RHlQnjiU";
        $license = new StandardLicense($apiKey);
        $response = DistanceMatrix::license($license)
            ->addOrigin('23.726109305763742, 90.39752919788403')
            ->addDestination($request->latlong)
            ->request();
        $rows = $response->rows();
        $elements = $rows[0]->elements();
        $element = $elements[0];
        $fairInKm = $subcat->govt_fair * $element->distance() / 1000;
        $discount = ($fairInKm * $subcat->discount_percent) / 100;
        return [
            "time" => $element->durationText(),
            'distance' => $element->distanceText(),
            'fairInKm' => round($fairInKm),
            'discount' => round($discount),
            'finalFair' => round($fairInKm - $discount),
        ];
    }
}
