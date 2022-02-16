<?php

namespace App\Http\Controllers;

use App\Models\Conditions;
use Illuminate\Http\Request;
use App\Models\VehiclesCategory;
use Illuminate\Database\Eloquent\Collection;

class SysController extends Controller
{
    public function category(Request $request)
    {
        $parants = VehiclesCategory::where('parent_id', 0)->get();
        if ($request->has('addCategory')) {
            $category = new VehiclesCategory();
            $category->name = $request->name;
            if ($request->isChild == 'yes') {
                $cityFair = array();
                foreach ($request->km as $key => $km) {
                    array_push($cityFair, array(
                        'km' => (int)$km,
                        'fair' => (int)$request->fair[$key],
                        'booth' => (int)$request->booth[$key]
                    ));
                };
                $category->parent_id = $request->parent_id;
                $category->govt_fair = (int) $request->govt_fair;
                $category->local_fair = (int)$request->local_fair;
                $category->waiting_charge = (int)$request->waiting_charge;
                $category->city_fair = $cityFair;
                $category->extra_charge = (int)$request->extra_charge;
                $category->discount_percent = (int)$request->discount_percent;
                $category->fixed_charge = (int)$request->fixed_charge;
            } else {
                $category->parent_id = 0;
            }
            $category->save();

            return redirect()->route('admin.categories');
        }
        return view('settings.category.index', compact('parants'));
    }

    public function edit($id)
    {
        $parents =  VehiclesCategory::where('parent_id', 0)->get();
        $category = VehiclesCategory::findOrFail($id);

        return view('settings.category.edit', compact('parents', 'category'));
    }

    public function update(Request $request, $id)
    {
        if ($request->parent_id == $id) {
            return redirect()->route('admin.categories');
        }

        $category = VehiclesCategory::findOrFail($id);
        $category->name = $request->name;
        if ($request->isChild == 'yes') {
            $cityFair = array();
            foreach ($request->km as $key => $km) {
                array_push($cityFair, array(
                    'km' => (int)$km,
                    'fair' => (int)$request->fair[$key],
                    'booth' => (int)$request->booth[$key]
                ));
            };
            $category->parent_id = $request->parent_id;
            $category->govt_fair = (int)$request->govt_fair;
            $category->local_fair = (int)$request->local_fair;
            $category->city_fair = $cityFair;
            $category->waiting_charge = (int)$request->waiting_charge;
            $category->extra_charge = (int)$request->extra_charge;
            $category->discount_percent = (int)$request->discount_percent;
            $category->fixed_charge = (int)$request->fixed_charge;
        } else {
            $category->parent_id = 0;
        }
        $category->update();

        return redirect()->route('admin.categories');
    }

    public function destroy($id)
    {
        $category = VehiclesCategory::findOrFail($id);
        if ($category->parent_id == 0) {
            foreach (VehiclesCategory::where('parent_id', $id)->get() as $child) {
                $child->delete();
            }
        }
        if ($category->delete()) {
            return redirect()->route('admin.categories');
        }
    }



    public function conditions(Request $request)
    {
        $conditions = Conditions::first();
        if ($request->has('submitPolicy')) {
            $policy = Conditions::first();
            $policy->user_policy = $request->user_policy;
            $policy->user_tos = $request->user_tos;
            $policy->driver_policy = $request->driver_policy;
            $policy->driver_tos = $request->driver_tos;
            $policy->save();
            return redirect()->back();
        }
        return view('settings.conditions.index', compact('conditions'));
    }
}
