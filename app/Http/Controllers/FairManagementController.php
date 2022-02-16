<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Fare;
use App\Models\Location;
use App\Models\VehiclesCategory;
use Illuminate\Support\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FairManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin_user');
    }
    public function index(Request $request)
    {

        $districts =  District::all();
        $locations = Location::all();
        $categories = VehiclesCategory::all();
        $fares =  Fare::all();
        if ($request->method() == "POST") {
            $this->validate($request, [
                'location_id' => 'required|string|unique:fares,location_id',
               
            ]);
            $fare = new Fare();
            $fare->location_id = $request->location_id;
            $fare->district =  Location::find($request->location_id)->district->id;
            $fareRate = new Collection();
            foreach ($request->except(['_token', 'location_id']) as $key => $req) {
                $fareRate->put($key,  $req);
            }
            $fare->rate = $fareRate->toArray();

            $fare->save();
            return redirect()->back();
        }

        return view('fairmanagement.index', compact('districts', 'locations', 'categories', 'fares'));
    }

    public function districts(Request $request)
    {
        $districts =  District::all();
        if ($request->method() == "POST") {

            if ($request->has('addDistricts')) {
                $this->validate($request, [
                    'name_en' => 'required|string|unique:districts,name_en',
                    'name_bn' => 'required|string',
                    'lat' => 'required|numeric',
                    'long' => 'required|numeric',
                    'postal_code' => 'numeric',
                ]);
                return new JsonResponse(['data' => "hello"], 200);
            }
        }
        return view('fairmanagement.districts', compact('districts'));
    }
    public function locations(Request $request)
    {
        $districts =  District::all();
        if ($request->method() == "POST") {
            $this->validate($request, [
                'district_id' => 'required|string',
                'name_en' => 'required|string|unique:locations,name_en',
                'name_bn' => 'required|string',
                'lat' => 'required|numeric',
                'long' => 'required|numeric',
            ]);
            $location = new Location();
            $location->district_id = $request->district_id;
            $location->name_en = $request->name_en;
            $location->name_bn = $request->name_bn;
            $location->lat = $request->lat;
            $location->long = $request->long;
            $location->save();
            return new JsonResponse(['data' => "hello"], 200);
        }
        $locations = Location::all();
        return view('fairmanagement.location', compact('districts', 'locations'));
    }
}
