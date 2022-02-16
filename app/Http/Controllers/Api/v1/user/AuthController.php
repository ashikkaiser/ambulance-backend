<?php

namespace App\Http\Controllers\Api\v1\user;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use JWTAuth;

class AuthController extends Controller
{

    public function checkMobile(Request $request)
    {
    }
    protected function guard()
    {
        return Auth::guard();
    }
    public function sendOtp(Request $request)
    {
        $user = User::where('mobile', $request->mobile)->first();
        $otp = rand(11111, 99999);
        if ($user) {
            $user->otp_token = $otp;
            $user->save();
            return response()->json([
                'success' => true,
                'message' => 'Otp Send Successfully',
                'otp' => $otp
            ]);
        } else {
            $curl = curl_init();
            $fields = array(
                "username" => "ashikkaiser",
                "password" => "MEG4CNSF",
                "number" => $request->mobile,
                "message" => "Your APP OTP code is " . $otp

            );


            curl_setopt($curl, CURLOPT_URL, env('MIMO_SENDER_ID'));
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($fields));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl);
            curl_close($curl);
            return response()->json([
                'success' => true,
                'message' => 'Otp Send Successfully',
                'otp' => $otp,
            ]);
        }
    }



    public function login(Request $request)
    {
        $info = $request->only('mobile', 'otp_token');
        $token = null;
        $find = User::where('mobile', $request->mobile)->where('otp_token', $request->otp_token)->first();
        $count = User::where('mobile', $request->mobile)->where('otp_token', $request->otp_token)->count();

        if ($count !== 0) {

            if (!$token = JWTAuth::fromUser($find)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Email or Password',
                ], Response::HTTP_UNAUTHORIZED);
            }
            return response()->json([
                'success' => true,
                'token' => $token,

            ]);
        } else {
            $user = new User();
            $user->mobile = $request->mobile;
            $user->otp_token = $request->otp_token;
            $user->status = 0;
            $user->profile_completed = 0;
            $user->save();
            if (!$token = JWTAuth::fromUser($user)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Email or Password',
                ], Response::HTTP_UNAUTHORIZED);
            }
            return response()->json([
                'success' => true,
                'token' => $token,
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

        return response()->json(compact('user'));
    }
    public function updateUser(Request $request, $type)
    {
        $user = User::find(Auth::user()->id);
        if ($type == 'name') {
            $user->name = $request->data;
        }
        if ($type == 'nid') {
            $user->nid_number = $request->data;
        }
        if ($type == 'email') {
            $user->email = $request->data;
        }
        if ($type == "push") {
            $user->pushToken = $request->data;
        }
        if ($user->name || $user->nid_number) {
            $user->profile_completed = 1;
        }
        $user->save();

        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }
}
