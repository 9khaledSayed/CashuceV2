<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Nationality;
use App\Rules\UniqueItem;
use Illuminate\Http\Request;

class NationalityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee,company,provider');
    }

    public function index(Request $request)
    {
        $this->authorize('view_settings');
        if ($request->ajax()) {
            $nationality = Nationality::all();
            return response()->json($nationality);
        }
        return  view('dashboard.settings.nationalities.index');

    }

    public function create()
    {
        $this->authorize('view_settings');
        return  view('dashboard.settings.nationalities.create');
    }

    public function store(Request $request)
    {
        $this->authorize('view_settings');
        Nationality::create($this->validator($request));
        return redirect(route('dashboard.nationalities.index'));
    }

    public function edit(Nationality $nationality)
    {
        $this->authorize('view_settings');
        return  view('dashboard.settings.nationalities.edit',compact('nationality'));
    }

    public function update(Request $request, Nationality $nationality)
    {
        $this->authorize('view_settings');
        $nationality->update($this->validator($request, $nationality->id));
        return redirect(route('dashboard.nationalities.index'));
    }


    public function destroy($id ,Request $request)
    {
//        $this->authorize('delete_nationalities');
//        if($request->ajax()){
//            Nationality::find($id)->destroy($id);
//            return response()->json([
//                'status' => true,
//                'message' => 'Item Deleted Successfully'
//            ]);
//        }
//        return redirect(route('dashboard.nationalities.index'));
    }

    public function validator(Request $request, $id = null)
    {
        $rules = Nationality::$rules;
        if($id){
            $rules['name_ar'] = ($rules['name_ar'] . ',name_ar,' . $id);
            $rules['name_en'] = ($rules['name_en'] . ',name_en,' . $id);
        }
        return $request->validate($rules);
    }

}
