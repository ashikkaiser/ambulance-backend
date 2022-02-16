<?php

namespace App\Http\Controllers\Api\v1\driver;

use App\Helpers\AppNotification;
use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Driver;
use App\Models\TripDetails;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;
use JWTAuth;
use Ixudra\Curl\Facades\Curl;
use stdClass;
use GoogleMaps;

class TripController extends Controller
{
    function __construct()
    {
        Config::set('jwt.user', Driver::class);
        Config::set('auth.providers', ['users' => [
            'driver' => 'eloquent',
            'model' => Driver::class,
        ]]);
    }

    public function getNewTrips()
    {
        if (Auth::user()->preferred_destination == "60cf086e8161574acb5ea137") {
            $trips = TripDetails::where('booking_status', 'pending')->whereNull(['driver_id', 'vehicle_id'])->with('getUser')->get();
        } else {
            $trips = TripDetails::where('booking_status', 'pending')->whereNull(['driver_id', 'vehicle_id'])->where('district', Auth::user()->preferred_destination)->with('getUser')->get();
        }
        // if ($trips->count() !== 0) {
        //     $response = Curl::to('http://103.133.142.58:6001/send')
        //         ->withData(json_decode($trips))
        //         ->post();
        // }
        return $trips;
    }

    public function updateTrips(Request $request, $type)
    {
        if ($type == 'accept') {
            $trip = TripDetails::find($request->data)->first();
            $trip->booking_status = "processing";
            $trip->driver_id = Auth::user()->id;
            $trip->vehicle_id = Auth::user()->vehicle->id;
            $trip->save();
            $push  = new AppNotification;
            $object = new stdClass;
            $object->type = 'accepted';
            $push->push([
                'to' => $trip->getUser->pushToken,
                'title' => "Booking Request Accepted",
                'body' => "Your booking Request has been Accepted",
                'data' => $object
            ]);
            return response()->json([
                'success' => true,
            ]);
        }
        if ($type == 'checkPayment') {
            $trip = TripDetails::find($request->data)->first();
            if (strtolower($trip->booking_status) === "processed") {
                return response()->json([
                    'payment' => true,

                ]);
            } else {
                return response()->json([
                    'payment' => false,

                ]);
            }
        }

        if ($type == 'otpCheck') {
            $trip = TripDetails::find($request->data[0])->where('booking_otp', $request->data[1])->with('getUser')->get();
            if (count($trip) == 0) {
                return response()->json([
                    'trip' => false,
                    'details' => $trip
                ]);
            } else {
                $update = TripDetails::find($request->data[0])->where('booking_otp', $request->data[1])->first();
                $update->booking_status = "running";
                $update->save();

                return response()->json([
                    'trip' => true,
                    'details' => $update->with('getUser')->get()[0]
                ]);
            }
        }
        return response()->json([
            'success' => false,

        ]);
    }

    public function driverTripsHistory()
    {
        $trips = TripDetails::where('driver_id', Auth::user()->id)->where('booking_status', '!=', "pending")->with("getUser")->get();
        return $trips;
    }
    public function singleTrip(Request $request)
    {
        $trip = TripDetails::find($request->id)->with('getUser')->get()[0];
        return response()->json([
            'trip' => true,
            'details' => $trip
        ]);
    }

    public function otpCheck(Request $request)
    {
        $trip = TripDetails::find($request->id)->where('booking_otp', $request->otp)->with('getUser')->with('driver')->get();
        if (count($trip) == 0) {
            return response()->json([
                'trip' => false,
                'details' => $trip
            ]);
        } else {
            $update = TripDetails::find($request->id)->where('booking_otp', $request->otp)->first();
            $update->booking_status = "running";
            $update->save();

            userTripStartnotificaiton($update);
            driverTripStartnotificaiton($update);
            return response()->json([
                'trip' => true,
                'details' => $update->with('getUser')->get()[0]
            ]);
        }
    }
    // "distance": {
    //     "text": "168 km",
    //     "value": 167703
    // },
    // "duration": {
    //     "text": "5 hours 43 mins",
    //     "value": 20551
    // },
    public function fairCalculation(Request $request)
    {
        $trip = TripDetails::find($request->trip_id);
        $start = $trip->start_lat_long;
        $end = $request->location;
        $pricelist = $trip->category;
        // $response = \GoogleMaps::load('directions')
        //     ->setParam([
        //         'origin'          => 'Toronto',
        //         'destination'     => 'Montreal',
        //     ]);
        $response = Curl::to('https://maps.googleapis.com/maps/api/directions/json')
            ->withData([
                'origin' => $start['latitude'] . "," . $start['longitude'],
                'destination' => $end['latitude'] . "," . $end['longitude'],
                // 'waypoints' => "23.7706618,90.3570905",
                'mode' => 'driving',
                'key' => "AIzaSyA9NjyJPS6SI3x2hK1LueRQb74RHlQnjiU"
            ])
            ->get();


        return json_decode($response, true);
    }


    public function tripLocationHistory(Request $request, $tripID)
    {
        $tripDetials = TripDetails::find($tripID);
        $tripDetials->push('locationHistory', $request->locations);
        // $tripDetials->save();
        return $request->locations;
    }
}
