<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Rules\UniqueItem;
use App\WorkShift;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WorkShiftController extends Controller
{
    public $weekDays = [
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
    ];
    public $shiftTypes = [
        'normal',
        'divided',
        'flexible',
        'once'
    ];

    public function index()
    {
        $workShifts = WorkShift::paginate(4);

        return view('dashboard.settings.work_shifts.index', compact('workShifts'));
    }


    public function create()
    {
        return view('dashboard.settings.work_shifts.create', [
            'weekDays' => $this->weekDays,
            'shiftTypes' => $this->shiftTypes
        ]);
    }


    public function store(Request $request)
    {
        WorkShift::create($this->validator($request));
        return redirect(route('dashboard.work_shifts.index'));
    }


    public function show(WorkShift $workShift)
    {
        //
    }


    public function edit(WorkShift $workShift)
    {
        return view('dashboard.settings.work_shifts.edit', [
            'workShift' => $workShift,
            'weekDays' => $this->weekDays,
            'shiftTypes' => $this->shiftTypes
        ]);
    }


    public function update(Request $request, WorkShift $workShift)
    {
        if(!$request->has('is_delay_allowed')){
            $request['is_delay_allowed'] = 0;
        }
//        dd($this->validator($request, $workShift->id));
        $workShift->update($this->validator($request, $workShift->id));
        return redirect(route('dashboard.work_shifts.index'));
    }


//    public function destroy( Request $request , WorkShift $workShift)
//    {
//        $this->authorize('view_settings');
//        if(!$workShift->is_defualt){
//            $workShift->delete();
//        }
//        return redirect(route('dashboard.work_shifts.index'));
//
//    }

    public function validator(Request $request, $id = null)
    {
        $rules = WorkShift::$rules;
        array_push($rules['name_ar'], new UniqueItem(new WorkShift(), $id));

        return $request->validate($rules);
    }
}
