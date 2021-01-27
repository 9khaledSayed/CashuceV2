<?php

namespace App\Http\Controllers\Dashboard;

use App\Allowance;
use App\Company;
use App\Department;
use App\Employee;
use App\Http\Controllers\Controller;
use App\JobTitle;
use App\Nationality;
use App\Provider;
use App\Role;
use App\Rules\UniqueJopNumber;
use App\Scopes\ServiceStatusScope;
use App\Section;
use App\WorkShift;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public $contract_type = [
        'limited',
        'unlimited',
        'seasonal employment',
        'in order to do a specific work',
        'part time',
        'full time',
        'temporary',
        'maritime work',
    ];

    public function __construct()
    {
        $this->middleware('auth:employee,company,provider');
    }

    public function index(Request $request)
    {
        $this->authorize('view_employees');
        if ($request->ajax()){
            $employees = Employee::withoutGlobalScope(new ServiceStatusScope())->get()->map(function($employee){
                $supervisor = $employee->supervisor? $employee->supervisor->name(): '';
                $department = $employee->department? $employee->department->name(): '';

                return [
                    'id' => $employee->id,
                    'role' => $employee->role->name(),
                    'supervisor' => $supervisor,
                    'nationality' => $employee->nationality(),
                    'name' => $employee->name(),
                    'department' => $department,
                    'job_number' => $employee->job_number,
                    'salary' => $employee->salary,
                    'barcode' => $employee->barcode,
                    'service_status' => $employee->service_status,
                    'service_status_search' => $employee->service_status == 0 ? 2 : 1,
                    'email_verified_at' => $employee->email_verified_at,
                    'joined_date' => $employee->joined_date,
                ];
            });

            return response()->json($employees);
        }else{

            return view('dashboard.employees.index', [
                'employeesNo' => Employee::get()->count(),
                'supervisors' =>  Company::supervisors(),
                'nationalities' => Nationality::get(),
                'roles' => Role::get(),
                'departments' => Department::get(),
                ]);
        }

    }


    public function create(Request $request)
    {
        $this->authorize('create_employees');
        $allowances = Allowance::all();
        $nationalities = Nationality::all();
        $job_titles = JobTitle::all();
        $departments = Department::all();
        $providers = Provider::get();
        $roles = Role::get();
        $supervisors = Employee::whereNull('supervisor_id')->get();
        $workShifts = WorkShift::get();
        $employee = Employee::get()->last();
        //dd($employee->job_number);
        if(isset($employee)){
            $employee->job_number = $employee->job_number + 1;
        }else{
            $employee->job_number = 1000;
        }

        //dd($job_titles);

        return view('dashboard.employees.create', [
            'nationalities' => $nationalities,
            'job_titles' => $job_titles,
            'roles' => $roles,
            'contract_type' => $this->contract_type,
            'allowances' =>$allowances,
            'supervisors' =>$supervisors,
            'workShifts' =>$workShifts,
            'departments' => $departments,
            'employee' => $employee,
            'providers' => $providers,
        ]);
    }


    public function store(Request $request)
    {
        $this->authorize('create_employees');
        if($request->ajax()){
            $employee = Employee::create($this->validator($request));
            $employee->allowances()->attach($request->allowance);
            return response()->json([
                'status' => true,
            ]);

        }
        return 0;
    }


    public function show(Employee $employee)
    {
        $allowances = Allowance::all();
        $nationalities = Nationality::all();
        $job_titles = JobTitle::all();
        $workShifts = WorkShift::get();
        $roles = Role::get();
        $supervisors = Employee::whereNull('supervisor_id')->get();
        return view('dashboard.employees.show', [
            'employee' => $employee,
            'nationalities' => $nationalities,
            'job_titles' => $job_titles,
            'roles' => $roles,
            'contract_type' => $this->contract_type,
            'allowances' =>$allowances,
            'supervisors' =>$supervisors,
            'workShifts' =>$workShifts,
        ]);
    }


    public function edit(Employee $employee)
    {
        $this->authorize('update_employees');
        $allowances = Allowance::all();
        $nationalities = Nationality::all();
        $job_titles = JobTitle::all();
        $workShifts = WorkShift::get();
        $roles = Role::get();
        $providers = Provider::get();
        $departments = Department::get();
        $supervisors = Employee::whereNull('supervisor_id')->get();

        return view('dashboard.employees.edit', [
            'employee' => $employee,
            'nationalities' => $nationalities,
            'job_titles' => $job_titles,
            'roles' => $roles,
            'contract_type' => $this->contract_type,
            'allowances' =>$allowances,
            'supervisors' =>$supervisors,
            'workShifts' =>$workShifts,
            'departments' => $departments,
            'providers' => $providers,
        ]);
    }


    public function update(Request $request, Employee $employee)
    {
        $this->authorize('update_employees');
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

    public function lateEmployees($notificationId)
    {
        $notification = auth()->user()->notifications->where('id', $notificationId)->first();
        $lateEmployees = Employee::whereIn('id', $notification->data['lateEmployeesIDs'])->get();

        return view('dashboard.employees.late_employees', compact('lateEmployees'));
    }

    public function destroy(Employee $employee)
    {
        //
    }

    public function endService(Employee $employee, Request $request)
    {

        if($request->ajax()){
            $request->validate([
                'contract_end_date' => 'required|date'
            ]);
            $employee->contract_end_date = $request->contract_end_date;
            $employee->save();
        }
    }
    public function backToService($id, Request $request)
    {
        $employee = Employee::withoutGlobalScope(new ServiceStatusScope())->find($id);
        if($request->ajax()){
            $request->validate([
                'contract_start_date' => 'required|date',
                'contract_end_date' => 'required|date',
            ]);
            $employee->contract_start_date = $request->contract_start_date;
            $employee->contract_end_date = $request->contract_end_date;
            $employee->save();
        }
    }


    public function validator(Request $request, $id = null)
    {
        $request->validate([
            'role_id' => 'required|numeric|exists:roles,id',
            ]);
        $rules = Employee::$rules;
        array_push($rules['job_number'], new UniqueJopNumber($id));
        if($id){
            $rules['email'] = ($rules['email'] . ',email,' . $id);
            unset($rules['password']);
        }
        return $request->validate($rules);
    }

    public function endedEmployees(Request $request)
    {
        //$this->authorize('ended_employees');

        if ($request->ajax()){
            $endedEmployees = Employee::withoutGlobalScope(new ServiceStatusScope())->where('service_status', 0)->get()->map(function($endedEmployee){
                $supervisor = $endedEmployee->supervisor? $endedEmployee->supervisor->name(): '';
                $department = $endedEmployee->department? $endedEmployee->department->name(): '';

                return [
                    'id' => $endedEmployee->id,
                    'role' => $endedEmployee->role->name(),
                    'supervisor' => $supervisor,
                    'nationality' => $endedEmployee->nationality(),
                    'name' => $endedEmployee->name(),
                    'department' => $department,
                    'job_number' => $endedEmployee->job_number,
                    'email' => $endedEmployee->email,
                ];
            });

            return response()->json($endedEmployees);
        }else{

            return view('dashboard.employees.ended_employees', [
                'supervisors' =>  Company::supervisors(),
                'nationalities' => Nationality::get(),
                'roles' => Role::get(),
                'departments' => Department::get(),
            ]);
        }
    }

}
