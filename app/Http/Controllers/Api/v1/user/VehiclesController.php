<?php

namespace App\Http\Controllers\Api\v1\user;

use App\Http\Controllers\Controller;
use App\Models\TripDetails;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\VehiclesCategory;
use Carbon\Carbon;
use App\Helpers\AppNotification;
use App\Models\District;
use App\Models\Driver;
use Ixudra\Curl\Facades\Curl;
use stdClass;

class VehiclesController extends Controller
{

    public function getCategory()
    {
        $category = VehiclesCategory::all();
        return response()->json([
            'success' => true,
            'data' => $category,
        ]);
    }


    public function newTrips(Request $request)
    {
        $trip = new TripDetails();
        $trip->booking_date = Carbon::now();
        $trip->ambulance_type = $request->veiclesCategory;
        $trip->user_id = Auth::user()->id;
        $trip->booking_otp = rand(11111, 99999);
        $trip->start_point = "Dhaka Medical College Hospital";
        $trip->end_point = $request->end_point;
        $trip->district = District::where('District', $request->district)->first()->id;
        $trip->booking_id = rand(11111111, 99999999);
        $trip->booking_status = "pending";
        $trip->start_lat_long = $request->origin;
        $trip->end_lat_long = $request->destination;
        $trip->estimated_time = $request->estimatedTime;
        $trip->estimated_distance = $request->estimatedDistance;
        $trip->estimated_fair = $request->estimatedFair;
        if ($trip->save()) {
            $push  = new AppNotification;
            $push->push([
                'to' => Auth::user()->pushToken,
                'title' => "Booking Request Successful",
                'body' => "Your booking Request has been confirmed. TOKEN DMBK#" . $trip->booking_id,
            ]);
            $this->SearchDriver($trip);
            return response()->json([
                'success' => true,
                'message' => "Booking Request Success",
                'booking_code' => "DMBK#" . $trip->booking_id,
                'trip' => $trip

            ]);
        }
    }



    public function SearchDriver($trip)
    {
        $push  = new AppNotification;
        $findDrivers = Driver::where('preferred_destination', $trip->district)->where('online_status', 1)->get();
        $newTrips = $trip->with('getUser')->get()[0];
        $object = new stdClass;
        $object->type = 'tripNotification';
        $object->data = $newTrips;
        $AllDriver = Driver::where('preferred_destination', 1)->where('online_status', 1)->get();
        if ($findDrivers->count() != 0) {
            foreach ($findDrivers as $driver) {
                $push->push([
                    'to' => $driver->pushToken,
                    'title' => "Booking Request Successful",
                    'body' => "Your booking Request has been confirmed. TOKEN DMBK#" . $newTrips->booking_id,
                    'data' => $object
                ]);
            }
        } else {
            $AllDriver = Driver::where('preferred_destination', 1)->where('online_status', 1)->get();
            foreach ($AllDriver as $dxriver) {
                $push->push([
                    'to' => $dxriver->pushToken,
                    'title' => "Booking Request Successful",
                    'body' => "Your booking Request has been confirmed. TOKEN DMBK#" . $newTrips->booking_id,
                    'data' => $object
                ]);
            }
        }
    }



    function getTripHistory()
    {
        $history = TripDetails::where('user_id', Auth::user()->id)->get();
        return response()->json([
            'success' => true,
            "data" => $history
        ]);
    }



    public function sendpush()
    {
        $push  = new AppNotification;
        $trip = TripDetails::find(8);
        $newTrips = $trip->with('getUser')->get()[0];
        $object = new stdClass;
        $object->type = 'tripNotification';
        $object->data = $newTrips;
        $findDrivers = Driver::where('preferred_destination', $newTrips->district)->where('online_status', 1)->get();
        $AllDriver = Driver::where('preferred_destination', 1)->where('online_status', 1)->get();
        if ($findDrivers->count() != 0) {
            foreach ($findDrivers as $driver) {
                $push->push([
                    'to' => $driver->pushToken,
                    'title' => "Booking Request Successful",
                    'body' => "Your booking Request has been confirmed. TOKEN DMBK#" . $newTrips->booking_id,
                    'data' => $object
                ]);
            }
        } else {
            $AllDriver = Driver::where('preferred_destination', 1)->where('online_status', 1)->get();
            foreach ($AllDriver as $dxriver) {
                $push->push([
                    'to' => $dxriver->pushToken,
                    'title' => "Booking Request Successful",
                    'body' => "Your booking Request has been confirmed. TOKEN DMBK#" . $newTrips->booking_id,
                    'data' => $object
                ]);
            }
        }
        return $AllDriver;
        // $trips = TripDetails::where('booking_id', 55045012)->with('getUser')->get()[0];
        // $push  = new AppNotification;
        // $trip = "ddfdf8765";
        // $object = new stdClass;
        // $object->type = 'tripNotification';
        // $object->data = $trips;
        // $object->url = "RideInfo";
        // $push->push([
        //     'to' => "ExponentPushToken[2jyOtOFo4X3aD6rarMaXLQ]",
        //     'title' => "Booking Request Successful",
        //     'subtitle' => "hello",
        //     'body' => "Your booking Request has been confirmed. TOKEN DMBK#" . $trip,
        //     'data' => $object
        // ]);
    }

    public function singleTrip(Request $request)
    {
        $trips = TripDetails::find($request->id)->with('driver')->get()[0];
        return $trips;
    }


    public function getOnlineDrivers()
    {
        $driver = Driver::where('online_status', 1)->get(['lastlocation']);
        return $driver;
    }
}
