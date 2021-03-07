<?php

namespace App\Http\Controllers\Dashboard\Fordeal;

use App\Allowance;
use App\City;
use App\Company;
use App\Department;
use App\Employee;
use App\Http\Controllers\Dashboard\EmployeeController;
use App\JobTitle;
use App\LeaveBalance;
use App\Nationality;
use App\Provider;
use App\Role;
use App\Rules\UniqueJopNumber;
use App\Scopes\ServiceStatusScope;
use App\WorkShift;
use Illuminate\Http\Request;
use Illuminate\View\View;


class FordealEmployeeController extends EmployeeController
{
    public $contract_type = [
        'limited',
        'unlimited',
        'temporary',
    ];

    public function index(Request $request)
    {
        $this->authorize('view_employees_fordeal');
        if ($request->ajax()){
            $sortColumn = $request->sort['field'];
            $sortType = $request->sort['sort'];

            $employees = Employee::orderBy($sortColumn, $sortType)->get()->map(function($employee){
                $supervisor = $employee->supervisor? $employee->supervisor->name(): '';
                $department = $employee->department? $employee->department->name(): '';

                return [
                    'id' => $employee->id,
                    'supervisor' => $supervisor,
                    'nationality' => $employee->nationality(),
                    'name' => $employee->name(),
                    'department' => $department,
                    'job_number' => $employee->job_number,
                    'salary' => $employee->salary,
                    'barcode' => $employee->barcode,
                    'service_status_search' => $employee->service_status == 0 ? 2 : 1,
                    'email_verified_at' => $employee->email_verified_at,
                    'contract_start_date' => $employee->contract_start_date->format('Y-m-d'),
                ];
            });

            return response()->json($employees);
        }else{

            return view('dashboard.fordeal.employees.index', [
                'employeesNo' => Employee::get()->count(),
                'supervisors' =>  Company::supervisors(),
                'nationalities' => Nationality::get(),
                'roles' => Role::get(),
                'departments' => Department::get(),
            ]);
        }

    }



    public function create()
    {
        $this->authorize('create_employees_fordeal');
        $allJobNumbers = Employee::withoutGlobalScope(ServiceStatusScope::class)->pluck('job_number')->sort();
        $jobNumber = 1000;

        if($allJobNumbers->count() != 0){
            $jobNumber = $allJobNumbers->last() + 1;
        }

        $data = [
            'nationalities' => Nationality::all(),
            'job_titles' => JobTitle::all(),
            'roles' => Role::get(),
            'cities' => City::all(),
            'contract_type' => $this->contract_type,
            'allowances' => Allowance::all(),
            'supervisors' => Employee::whereNull('supervisor_id')->get(),
            'workShifts' => WorkShift::get(),
            'departments' => Department::all(),
            'jobNumber' => $jobNumber,
            'providers' => Provider::get(),
        ];


        return view('dashboard.fordeal.employees.create', $data);
    }

    public function store(Request $request)
    {
        $this->authorize('create_employees_fordeal');
        if($request->ajax()){
            $employee = Employee::create($this->validator($request));
            $employee->allowances()->attach($request->allowance);
            $employee->update(['is_completed' => true]);
            return response()->json([
                'status' => true,
            ]);

        }
        return 0;
    }


    public function edit($id)
    {
        $employee = Employee::find($id);
        $this->authorize('update_employees_fordeal');

        return view('dashboard.fordeal.employees.edit', [
            'employee' => $employee,
            'nationalities' => Nationality::all(),
            'job_titles' => JobTitle::all(),
            'roles' => Role::get(),
            'cities' => City::all(),
            'contract_type' => $this->contract_type,
            'allowances' => Allowance::all(),
            'supervisors' =>Employee::whereNull('supervisor_id')->get(),
            'workShifts' => WorkShift::get(),
            'departments' => Department::get(),
            'providers' => Provider::get(),
        ]);
    }


    public function update(Request $request, $id)
    {
        $this->authorize('update_employees_fordeal');
        $employee = Employee::find($id);
        if($request->ajax()){
            $employee->update($this->validator($request, $employee->id));
            $employee->allowances()->detach($request->allowance);
            $employee->allowances()->attach($request->allowance);
            return response()->json([
                'status' => true,
            ]);
        }
        return 0;
    }

    public function show($id)
    {
        $employee = Employee::find($id);
        $allowances = Allowance::all();
        $nationalities = Nationality::all();
        $job_titles = JobTitle::all();
        $workShifts = WorkShift::get();
        $roles = Role::get();
        $leaveBalances = LeaveBalance::get();
        $supervisors = Employee::whereNull('supervisor_id')->get();
        return view('dashboard.fordeal.employees.show', [
            'employee' => $employee,
            'nationalities' => $nationalities,
            'job_titles' => $job_titles,
            'roles' => $roles,
            'cities' => City::all(),
            'contract_type' => $this->contract_type,
            'leaveBalances' =>$leaveBalances,
            'allowances' =>$allowances,
            'supervisors' =>$supervisors,
            'workShifts' =>$workShifts,
        ]);
    }

    public function validator(Request $request, $id = null)
    {
        $request->validate([
            'role_id' => 'required|numeric|exists:roles,id',
        ]);
        $fordealRules = Employee::$fordealRules;
        array_push($fordealRules['job_number'], new UniqueJopNumber($id));
        if($id){
            $fordealRules['email'] = ($fordealRules['email'] . ',email,' . $id);
            unset($fordealRules['password']);
        }
        return $request->validate($fordealRules);
    }
}
