<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Rules\UniqueItem;
use App\VacationType;
use Illuminate\Http\Request;

class VacationTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee,company,provider');
    }

    public function index(Request $request)
    {
        $this->authorize('view_settings');
        if($request->ajax()){
            $vacation_types = VacationType::get();
            return response()->json($vacation_types);
        }
        return view('dashboard.settings.vacation_types.index');
    }

    public function create()
    {
        $this->authorize('view_settings');
        return view('dashboard.settings.vacation_types.create');
    }

    public function store(Request $request)
    {
        $this->authorize('view_settings');
        VacationType::create($this->validator($request));
        return redirect(route('dashboard.vacation_types.index'));
    }

    public function edit(VacationType $vacationType)
    {
        $this->authorize('view_settings');
        return view('dashboard.settings.vacation_types.edit', compact('vacationType'));
    }

    public function update(VacationType $vacationType , Request $request)
    {
        $this->authorize('view_settings');
        $vacationType->update($this->validator($request, $vacationType->id));
        return redirect(route('dashboard.vacation_types.index'));
    }

    public function destroy( Request $request , VacationType $vacationType)
    {
        $this->authorize('view_settings');
        if($request->ajax()){
            $vacationType->delete();
            return response()->json([
                'status' => true,
                'message' => 'Item Deleted Successfully'
            ]);
        }

    }

    public function validator(Request $request, $id = null)
    {
        $rules = VacationType::$rules;
        array_push($rules['name_ar'], new UniqueItem(new VacationType(), $id));

        return $request->validate($rules);
    }

    public function vacationDays(VacationType $vacationType)
    {
        return response()->json([
           'vacation_days' => $vacationType->num_of_days
        ]);
    }
}
