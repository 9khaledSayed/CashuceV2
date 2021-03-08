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
        $this->authorize('not-company');
        $vacationTypes = VacationType::all();
        return view('dashboard.vacations.create',compact('vacationTypes'));
    }


    public function assignVacation()
    {
        $this->authorize('create_vacation_request');
        $this->authorize('not-company');
        $vacationTypes = VacationType::all();
        $employees = Employee::all();
        return view('dashboard.vacations.assign_vacation',compact('vacationTypes', 'employees'));
    }

    public function storeAssignedVacation(Request $request)
    {
        $this->authorize('not-company');
        $request->validate(['employee_id' => 'required|numeric|exists:employees,id']);

        $vacation = new Vacation($this->validator($request));
        $vacation->total_days = $vacation->start_date->diffInDays($vacation->end_date);
        $vacation->saveWithoutEvents(['created']);

        \App\Request::create([
            'employee_id' => $request->employee_id,
            'requestable_id' => $vacation->id,
            'requestable_type' => 'App\Vacation',
        ]);
        return response()->json(['status' => 'success']);

    }

    public function store(Request $request)
    {
        $this->authorize('create_vacation_request');
        $this->authorize('not-company');
        if (!auth()->guard('employee')->check()){
            return response()->json(['status' => 0, 'message' => 'Sorry You can\'t use this service because you are not an employee']);
        }

        $vacation = new Vacation($this->validator($request));
        $vacation->total_days = $vacation->start_date->diffInDays($vacation->end_date);
        $vacation->save();
        return response()->json(['status' => 'success']);
    }

    public function validator(Request $request)
    {
        $request['paid_in_advance'] = $request->has('paid_in_advance');
        return $request->validate([
            'reason_ar' => 'required_if:vacation_type_id,0|exclude_unless:vacation_type_id,0|string|max:191',
            'reason_en' => 'required_if:vacation_type_id,0|exclude_unless:vacation_type_id,0|string|max:191',
            'vacation_type_id' => 'exclude_if:vacation_type_id,0|numeric|exists:vacation_types,id',
            'paid_in_advance' => 'required|boolean',
            'start_date' => 'required|before:end_date',
            'end_date' => 'required',
        ]);
    }
}
