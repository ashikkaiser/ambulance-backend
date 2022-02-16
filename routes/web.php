<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SysController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AssistantController;
use App\Http\Controllers\ModeratorController;
use App\Http\Controllers\AppSettingController;
use App\Http\Controllers\TripDetailsController;
use App\Http\Controllers\VehicleDistributionController;
use App\Http\Controllers\Api\v1\user\VehiclesController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\FairManagementController;
use App\Models\Conditions;
use App\Models\TripDetails;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/otp-verify', function () {
    return view('auth.otpVerify');
})->name('otp');
Route::get('/t', function () {
    event(new \App\Events\FindDriver());
    dd('Event Run Successfully.');
});
Route::get('/user-profile-submit', function () {
    return view('auth.user-profile');
})->name('user.profile.submit');
Route::get('policy/{u}/{t}', function ($u, $t) {
    $con = Conditions::first();
    return view('appview', compact('con', 'u', 't'));
})->name('email');
//logging admin in
Route::name('admin.login.')->group(function () {
    Route::get('admin-login', [AdminUserController::class, 'index'])->name('index');
    Route::post('admin-login', [AdminUserController::class, 'login'])->name('submit');
});

//Auth Admin routes
Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => 'auth:admin_user'], function () {
    /*
    Route::get('/{home?}', function () {
        return view('index.index');
    })->where('home', '(|dashboard)')->name('index');
    */

    Route::get('dashboard', [DashBoardController::class, 'index'])->name('index');

    Route::get('/', [DashBoardController::class, 'index'])->name('index');

    Route::resource('partners', PartnerController::class)->except(['destroy']);

    Route::resource('vehicles', VehicleController::class);

    Route::resource('moderators', ModeratorController::class)->except(['destroy']);

    Route::resource('drivers', DriverController::class);

    Route::resource('assistants', AssistantController::class);
    Route::any('fairmanagement/districts', [FairManagementController::class, 'districts'])->name('fairmanagement.districts');
    Route::any('fairmanagement/locations', [FairManagementController::class, 'locations'])->name('fairmanagement.locations');
    Route::any('fairmanagement', [FairManagementController::class,'index'])->name('fairmanagement.index');



    Route::resource('agents', AgentController::class)->except(['destroy']);

    // Route::get('vehicle/distribution', [VehicleDistributionController::class, 'index'])->name('vehicle.distribution');

    // Route::post('vehicle/distribution/{id}', [VehicleDistributionController::class, 'distribution'])->name('vehicle.distribution.save');

    Route::group(['as' => 'setting.', 'prefix' => 'setting'], function () {
        Route::resource('app', AppSettingController::class)->only(['index', 'create', 'store']);
    });

    Route::any('categories', [SysController::class, 'category'])->name('categories');

    Route::get('categories/{id}/edit', [SysController::class, 'edit'])->name('categories.edit');
    Route::post('categories/{id}', [SysController::class, 'update'])->name('categories.update');
    Route::delete('categories/{id}', [SysController::class, 'destroy'])->name('categories.destroy');

    Route::get('setting/email', function () {
        return view('settings.email_template.template');
    })->name('email');
    Route::any('setting/conditions', [SysController::class, 'conditions'])->name('conditions.index');

    Route::get('/users', [DashBoardController::class, 'user'])->name('users');

    Route::any('trip-details', [TripDetailsController::class, 'index'])->name('tripDetails.list');

    Route::any('trip-details/create', [TripDetailsController::class, 'create'])->name('TripDetails.create');
    Route::any('trip-details/calculation', [TripDetailsController::class, 'distanceCalculation'])->name('TripDetails.calculation');
    Route::any('trip-details/store', [TripDetailsController::class, 'store'])->name('TripDetails.store');

    Route::any('trip-details/amount-submit/{id}', [TripDetailsController::class, 'paymentSubmit'])->name('tripDetails.list.submit');

    Route::post('logout', [AdminUserController::class, 'logout'])->name('logout');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
