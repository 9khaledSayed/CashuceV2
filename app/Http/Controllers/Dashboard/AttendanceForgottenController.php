<?php

namespace App\Http\Controllers\Dashboard;

use App\AttendanceForgotten;
use App\Http\Controllers\Controller;
use App\Rules\CheckAttendanceForgotten;
use Illuminate\Http\Request;

class AttendanceForgottenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee,company,provider');
    }

    public function create()
    {
        $this->authorize('create_attendance_record_forgotten_request');
        $this->authorize('not-company');
        return view('dashboard.attendance_forgottens.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create_attendance_record_forgotten_request');
        $this->authorize('not-company');
        if (!auth()->guard('employee')->check()){
            return response()->json(['status' => 0, 'message' => 'Sorry You can\'t use this service because you are not an employee']);
        }else{
            AttendanceForgotten::create($request->validate([
                'forgotten_date' => ['required' , new CheckAttendanceForgotten(auth()->user()->id)]
            ]));
            return response()->json(['status' => 1]);
        }
    }
}
