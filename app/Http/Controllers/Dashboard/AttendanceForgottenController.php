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
        return view('dashboard.attendance_forgottens.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create_attendance_record_forgotten_request');
        AttendanceForgotten::create($request->validate([
            'forgotten_date' => ['required' , new CheckAttendanceForgotten(auth()->user()->id)]
        ]));
        return response()->json(['status' => 'success']);
    }
}
