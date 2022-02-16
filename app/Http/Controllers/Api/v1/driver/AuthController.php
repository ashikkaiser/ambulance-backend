<?php

namespace App\Http\Controllers\Api\v1\driver;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;
use JWTAuth;

class AuthController extends Controller
{
    function __construct()
    {
        Config::set('jwt.user', Driver::class);
        Config::set('auth.providers', ['users' => [
            'driver' => 'eloquent',
            'model' => Driver::class,
        ]]);
    }

    public function sendOtp(Request $request)
    {
        $driver = Driver::where('mobile', $request->mobile)->where('status', "Active")->first();
        $otp = rand(11111, 99999);
        if ($driver) {
            $driver->otp_token = $otp;
            $driver->save();
            return response()->json([
                'success' => true,
                'message' => 'Otp Send Successfully',
                'otp' => $otp
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Account Not Found Or Inactive, Please Contact Your Provider',
            ]);
        }
    }



    public function login(Request $request)
    {
        $token = null;
        $current = Driver::where('mobile', $request->mobile)->first();
        $running = Driver::where('vehicle_id', $current->vehicle_id)->where('online_status', 1)->get();
        // $curentDriverID = Driver::where('vehicle_id', $find->vehicle_id)->where('online_status', 1)->first();
        if (count($running) != 0 && $running[0]->id !== $current->id) {
            return response()->json([
                'success' => false,
                'message' => "Another Driver Online",
            ]);
        } else {
            if (!$token = JWTAuth::fromUser($current)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Email or Password',
                ], Response::HTTP_UNAUTHORIZED);
            }
            return response()->json([
                'success' => true,
                'token' => $token,
                'user_id' => $current->id
            ]);
        }
    }

    public function getAuthenticatedUser()
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());
        }
        // $vehicle= Vehicle::find()

        return response()->json([
            "user" => $user
        ]);
    }



    public function getDistrict()
    {

        $districts = District::all();
        return response()->json($districts);
    }




    public function updateDriver(Request $request, $type)
    {
        $driver = Driver::find(Auth::user()->id);
        if ($type == 'status') {
            $driver->online_status = $request->data[0];
            $driver->preferred_destination = $request->data[1];
        }
        if ($type == "token") {
            $driver->pushToken = $request->data;
        }
        if ($type == "lastlocation") {
            $driver->lastlocation = $request->data;
        }

        $driver->save();

        return response()->json([
            'success' => true,
            'user' => $driver
        ]);
    }
}
