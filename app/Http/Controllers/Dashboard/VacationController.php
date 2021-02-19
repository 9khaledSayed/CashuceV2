<?php

namespace App\Http\Controllers\Dashboard;

use App\Employee;
use App\Http\Controllers\Controller;
use App\Vacation;
use App\VacationType;
use Illuminate\Http\Request;

class VacationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee,company,provider');
    }

    public function create()
    {
        $this->authorize('create_vacation_request');
        $vacationTypes = VacationType::all();
        return view('dashboard.vacations.create',compact('vacationTypes'));
    }

    public function store(Request $request)
    {
        $this->authorize('create_vacation_request');
        if (!auth()->guard('employee')->check()){
            return response()->json(['status' => 0, 'message' => 'Sorry You can\'t use this service because you are not an employee']);
        }
        $vacation_type = VacationType::find($request->vacation_type_id);
        $vacation = new Vacation($request->validate([
            'start_date' => 'required|before:end_date',
            'end_date' => 'required',
        ]));
        $vacation->vacation_type_ar = $vacation_type->name_ar;
        $vacation->vacation_type_en = $vacation_type->name_en;
        $vacation->total_days = $vacation->start_date->diffInDays($vacation->end_date);
        $vacation->save();
        return response()->json(['status' => 'success']);
    }
}
