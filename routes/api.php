<?php

use App\Http\Controllers\Api\v1\driver\AuthController as DriverAuthController;
use App\Http\Controllers\Api\v1\driver\TripController;
use App\Http\Controllers\Api\v1\user\AuthController;
use App\Http\Controllers\Api\v1\user\VehiclesController;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use SKAgarwal\GoogleApi\PlacesApi;



// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Route::any('login', [AuthController::class, 'login']);
// Route::any('checkMobile', [AuthController::class, 'checkMobile']);
// Route::any('sendOtp', [AuthController::class, 'sendOtp']);
// Route::any('sendpush', [VehiclesController::class, 'sendpush']);
// Route::group(['middleware' => ['jwt.verify']], function () {
//     Route::any('getAuthenticatedUser', [AuthController::class, 'getAuthenticatedUser']);
//     Route::any('updateUser/{type}', [AuthController::class, 'updateUser']);
//     Route::any('getCategory', [VehiclesController::class, 'getCategory']);
//     Route::any('newTrips', [VehiclesController::class, 'newTrips']);
//     Route::any('getTripHistory', [VehiclesController::class, 'getTripHistory']);
//     Route::any('singleTrip', [VehiclesController::class, 'singleTrip']);
//     Route::any('getOnlineDrivers', [VehiclesController::class, 'getOnlineDrivers']);
// });


// Route::group(['prefix' => 'driver'], function () {
//     Route::any('sendOtp', [DriverAuthController::class, 'sendOtp']);
//     Route::any('login', [DriverAuthController::class, 'login']);
//     Route::group(['middleware' => 'jwt.verify'], function () {
//         Route::any('getAuthenticatedUser', [DriverAuthController::class, 'getAuthenticatedUser']);
//         Route::any('updateDriver/{type}', [DriverAuthController::class, 'updateDriver']);
//         Route::any('getDistricts', [DriverAuthController::class, 'getDistrict']);
//         Route::any('getNewTrips', [TripController::class, 'getNewTrips']);
//         Route::any('updateTrips/{type}', [TripController::class, 'updateTrips']);
//         Route::any('driverTripsHistory', [TripController::class, 'driverTripsHistory']);
//         Route::any('singleTrip', [TripController::class, 'singleTrip']);
//         Route::any('otpCheck', [TripController::class, 'otpCheck']);
//         Route::any('fairCalculation', [TripController::class, 'fairCalculation']);
//         Route::any('tripLocationHistory/{tripID}', [TripController::class, 'tripLocationHistory']);
//     });
// });
