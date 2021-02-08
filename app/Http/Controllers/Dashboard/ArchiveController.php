<?php

namespace App\Http\Controllers\Dashboard;

use App\Company;
use App\Department;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Nationality;
use App\Provider;
use App\Role;
use App\Scopes\CompletedScope;
use App\Section;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view_employees');
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
            return view('dashboard.employees.archives', [
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
}
