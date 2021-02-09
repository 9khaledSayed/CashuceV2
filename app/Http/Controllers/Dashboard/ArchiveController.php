<?php

namespace App\Http\Controllers\Dashboard;

use App\Allowance;
use App\City;
use App\Company;
use App\Department;
use App\Employee;
use App\Http\Controllers\Controller;
use App\JobTitle;
use App\LeaveBalance;
use App\Nationality;
use App\Provider;
use App\Role;
use App\Rules\UniqueJopNumber;
use App\Scopes\CompletedScope;
use App\Section;
use App\WorkShift;
use Illuminate\Http\Request;

class ArchiveController extends EmployeeController
{
    public function index(Request $request)
    {
        if ($request->ajax()){
            $sortColumn = $request->sort['field'];
            $sortType = $request->sort['sort'];
            $employees = Employee::orderBy($sortColumn, $sortType)
                ->withoutGlobalScope(CompletedScope::class)
                ->where('is_completed', false)->get();
            $employees = $employees->map(function($employee){
                $supervisor = $employee->supervisor? $employee->supervisor->name(): '';
                $department = $employee->department? $employee->department->name(): '';
                $section = $employee->section? $employee->section->name(): '';
                $provider = $employee->provider? $employee->provider->name(): '';

                return [
                    'id' => $employee->id,
                    'supervisor' => $supervisor,
                    'name' => $employee->name(),
                    'department' => $department,
                    'section' => $section,
                    'provider' => $provider,
                    'job_number' => $employee->job_number,
                    'salary' => $employee->salary,
                    'barcode' => $employee->barcode,
                    'service_status' => $employee->service_status,
                    'service_status_search' => $employee->service_status == 0 ? 2 : 1,
                ];
            });

            return response()->json($employees);
        }else{
            $employees = Employee::withoutGlobalScope(CompletedScope::class)
                ->where('is_completed', false)->get();
            return view('dashboard.archives.index', [
                'employeesNo' => $employees->count(),
                'supervisors' =>  Company::supervisors(),
                'nationalities' => Nationality::get(),
                'providers' => Provider::get(),
                'roles' => Role::get(),
                'departments' => Department::get(),
                'sections' => Section::get(),
            ]);
        }
    }

    public function store(Request $request)
    {
        Employee::create($request->validate(Employee::$saveRules));
        return response()->json([
            'status' => true,
        ]);
    }

    public function edit($id)
    {
        $employee = Employee::withoutGlobalScope(CompletedScope::class)->find($id);
        $allowances = Allowance::all();
        $nationalities = Nationality::all();
        $cities = City::all();
        $jobTitles = JobTitle::all();
        $workShifts = WorkShift::get();
        $roles = Role::get();
        $leaveBalances = LeaveBalance::get();
        $providers = Provider::get();
        $departments = Department::get();

        return view('dashboard.archives.edit', [
            'employee' => $employee,
            'nationalities' => $nationalities,
            'cities' => $cities,
            'jobTitles' => $jobTitles,
            'roles' => $roles,
            'leaveBalances' =>$leaveBalances,
            'contract_type' => $this->contract_type,
            'allowances' =>$allowances,
            'workShifts' =>$workShifts,
            'departments' => $departments,
            'providers' => $providers,
        ]);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::withoutGlobalScope(CompletedScope::class)->find($id);
        if($request->is_submitted == 1){
            $employee->update($this->validateAttributes($request, $employee->id, Employee::$rules));
            $employee->is_completed = true;
            $employee->save();
        }else{
            $employee->update($this->validateAttributes($request, $employee->id, Employee::$saveRules));

        }

        $employee->allowances()->detach($request->allowance);
        $employee->allowances()->attach($request->allowance);
        return response()->json([
            'status' => true,
        ]);
    }

    public function validateAttributes(Request $request, $id, $rules)
    {
        array_push($rules['job_number'], new UniqueJopNumber($id));
        $rules['email'] = ($rules['email'] . ',email,' . $id);

        return $request->validate($rules);
    }
}
