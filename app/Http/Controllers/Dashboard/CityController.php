<?php

namespace App\Http\Controllers\Dashboard;

use App\City;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee,company,provider');
    }

    public function index(Request $request)
    {
        $this->authorize('view_settings');
        if ($request->ajax()) {
            $city = City::all();
            return response()->json($city);
        }
        return  view('dashboard.settings.cities.index');

    }

    public function create()
    {
        $this->authorize('view_settings');
        return  view('dashboard.settings.cities.create');
    }

    public function store(Request $request)
    {
        $this->authorize('view_settings');
        City::create($this->validator($request));
        return redirect(route('dashboard.cities.index'));
    }

    public function edit(City $city)
    {
        $this->authorize('view_settings');
        return  view('dashboard.settings.cities.edit',compact('nationality'));
    }

    public function update(Request $request, City $city)
    {
        $this->authorize('view_settings');
        $city->update($this->validator($request, $city->id));
        return redirect(route('dashboard.cities.index'));
    }


    public function destroy($id ,Request $request)
    {
//        $this->authorize('delete_cities');
//        if($request->ajax()){
//            City::find($id)->destroy($id);
//            return response()->json([
//                'status' => true,
//                'message' => 'Item Deleted Successfully'
//            ]);
//        }
//        return redirect(route('dashboard.cities.index'));
    }

    public function validator(Request $request, $id = null)
    {
        $rules = City::$rules;
        if($id){
            $rules['name_ar'] = ($rules['name_ar'] . ',name_ar,' . $id);
            $rules['name_en'] = ($rules['name_en'] . ',name_en,' . $id);
        }
        return $request->validate($rules);
    }
}
