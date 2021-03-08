<?php

namespace App\Http\Controllers\Dashboard;

use App\Allowance;
use App\Attendance;
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
use App\Scopes\ServiceStatusScope;
use App\Section;
use App\WorkShift;
use Box\Spout\Writer\Style\StyleBuilder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Rap2hpoutre\FastExcel\FastExcel;

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
            $sortColumn = $request->sort['field'];
            $sortType = $request->sort['sort'];

            $employees = Employee::orderBy($sortColumn, $sortType)->get()->map(function($employee){
                $supervisor = $employee->supervisor? $employee->supervisor->name(): '';
                $department = $employee->department? $employee->department->name(): '';
                $section = $employee->section? $employee->section->name(): '';
                $provider = $employee->provider? $employee->provider->name(): '';

                return [
                    'id' => $employee->id,
                    'supervisor' => $supervisor,
                    'nationality' => $employee->nationality(),
                    'name' => $employee->name(),
                    'department' => $department,
                    'section' => $section,
                    'provider' => $provider,
                    'job_number' => $employee->job_number,
                    'salary' => $employee->salary,
                    'barcode' => $employee->barcode,
                    'service_status' => $employee->service_status,
                    'service_status_search' => $employee->service_status == 0 ? 2 : 1,
                    'email_verified_at' => $employee->email_verified_at,
                    'contract_start_date' => $employee->contract_start_date->format('Y-m-d'),
                ];
            });

            return response()->json($employees);
        }else{

            return view('dashboard.employees.index', [
                'employeesNo' => Employee::get()->count(),
                'supervisors' =>  Company::supervisors(),
                'nationalities' => Nationality::get(),
                'providers' => Provider::get(),
                'roles' => Role::get(),
                'departments' => Department::get(),
                'sections' => Section::get(),
                ]);
        }

    }


    public function create()
    {
        $this->authorize('create_employees');
        $allJobNumbers = Employee::withoutGlobalScopes([ServiceStatusScope::class, CompletedScope::class])->pluck('job_number')->sort();
        $jobNumber = 1000;

        if($allJobNumbers->count() != 0){
            $jobNumber = $allJobNumbers->last() + 1;
        }

        $data = [
            'nationalities' => Nationality::all(),
            'cities' => City::all(),
            'job_titles' => JobTitle::all(),
            'roles' => Role::get(),
            'contract_type' => $this->contract_type,
            'allowances' => Allowance::all(),
            'supervisors' => Employee::whereNull('supervisor_id')->get(),
            'workShifts' => WorkShift::get(),
            'leaveBalances' => LeaveBalance::get(),
            'departments' => Department::all(),
            'jobNumber' => $jobNumber,
            'providers' => Provider::get(),
        ];


        return view('dashboard.employees.create', $data);
    }


    public function store(Request $request)
    {
        $this->authorize('create_employees');
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


    public function show($id)
    {
        $employee = Employee::withoutGlobalScopes([ServiceStatusScope::class, CompletedScope::class])->find($id);
        $allowances = Allowance::all();
        $nationalities = Nationality::all();
        $job_titles = JobTitle::all();
        $workShifts = WorkShift::get();
        $roles = Role::get();
        $leaveBalances = LeaveBalance::get();
        $supervisors = Employee::whereNull('supervisor_id')->get();
        return view('dashboard.employees.show', [
            'employee' => $employee,
            'nationalities' => $nationalities,
            'cities' => City::all(),
            'job_titles' => $job_titles,
            'roles' => $roles,
            'contract_type' => $this->contract_type,
            'leaveBalances' =>$leaveBalances,
            'allowances' =>$allowances,
            'supervisors' =>$supervisors,
            'workShifts' =>$workShifts,
        ]);
    }


    public function edit($id)
    {
        $this->authorize('update_employees');
        $employee = Employee::withoutGlobalScopes([ServiceStatusScope::class, CompletedScope::class])->find($id);
        $allowances = Allowance::all();
        $nationalities = Nationality::all();
        $cities = City::all();
        $jobTitles = JobTitle::all();
        $workShifts = WorkShift::get();
        $roles = Role::get();
        $leaveBalances = LeaveBalance::get();
        $providers = Provider::get();
        $departments = Department::get();
        $supervisors = Employee::whereNull('supervisor_id')->get();

        return view('dashboard.employees.edit', [
            'employee' => $employee,
            'nationalities' => $nationalities,
            'cities' => $cities,
            'jobTitles' => $jobTitles,
            'roles' => $roles,
            'leaveBalances' =>$leaveBalances,
            'contract_type' => $this->contract_type,
            'allowances' =>$allowances,
            'supervisors' =>$supervisors,
            'workShifts' =>$workShifts,
            'departments' => $departments,
            'providers' => $providers,
        ]);
    }


    public function update(Request $request, $id)
    {
        $employee = Employee::withoutGlobalScopes([ServiceStatusScope::class, CompletedScope::class])->find($id);
        $this->authorize('update_employees');
        if($request->ajax()){
            $employee->update($this->validator($request, $employee->id));
            $employee->allowances()->sync([]);
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
                'contract_end_date' => 'required|date|after_or_equal:today'
            ]);
            $employee->contract_end_date = $request->contract_end_date;
            $employee->save();

            $response = [
                'status' => 1,
                'message' => 'service will be ended in ' . $request->contract_end_date  . ' at 12:00 AM'
            ];

            return response()->json($response);
        }
    }

    public function backToService($id, Request $request)
    {
        $employee = Employee::withoutGlobalScope(ServiceStatusScope::class)->find($id);

        if($request->ajax()){
            $request->validate([
                'contract_start_date' => 'required|date|after_or_equal:today',
                'contract_end_date' => 'required|date|after:contract_start_date',
            ]);
            $employee->contract_start_date = $request->contract_start_date;
            $employee->contract_end_date = $request->contract_end_date;

            if($request->contract_start_date == Carbon::today()->format('Y-m-d')){
                $employee->service_status = 1;
                $response = [
                    'status' => 1,
                    'message' => 'Employee has been returned to service successfully'
                ];
            }else{
                $response = [
                    'status' => 1,
                    'message' => 'Employee will be returned to the service at ' . $request->contract_start_date
                ];
            }

            $employee->save();
            return response()->json($response);
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
                    'service_status' => $endedEmployee->service_status,
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


    public function extractExcelForm()
    {
        return view('dashboard.employees.extract_form');
    }

    public function extractExcel(Request $request)
    {
        $fileName = 'employees.xlsx';
        $employees = Employee::select($request->employees_data)->get();

        $header_style = (new StyleBuilder())
            ->setFontSize(8)
            ->setFontBold()
            ->build();

        $rows_style = (new StyleBuilder())
            ->setFontSize(8)
            ->setBackgroundColor("EDEDED")
            ->build();

        return (new FastExcel($employees))
            ->headerStyle($header_style)
            ->rowsStyle($rows_style)
            ->download($fileName);
    }

    public function showImportForm()
    {
        return view('dashboard.employees.import_form');
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|max:50000|mimes:xlsx'
        ]);
        $allEmployeesBeforeImport = Employee::withoutGlobalScope(CompletedScope::class)->count();

        $collection = (new FastExcel)->import($request->file('excel_file'));
        if($collection->isEmpty()){
            return redirect()->back()->withErrors('The selected file is empty');
        }
        $validatorErrors = (new FastExcel)->import($request->file('excel_file'), function ($row) {
            $row['BirthDate'] = $row['BirthDate']->format('Y-m-d');
            $row['Issue Date'] = $row['Issue Date']->format('Y-m-d');
            $row['Expire Date'] = $row['Expire Date']->format('Y-m-d');
            $row['Contract Start Date'] = $row['Contract Start Date']->format('Y-m-d');
            $row['Contract End Date'] = $row['Contract End Date']->format('Y-m-d');
            $validator = Validator::make($row, [
                "Name English"    => "required|String|max:191",
                "Name Arabic"    => "required|String|max:191",
                "BirthDate"    => "required|date_format:Y-m-d",
                "ID Number"    => "required|numeric",
                "Issue Date"    => "required|date_format:Y-m-d",
                "Expire Date"    => "required|date_format:Y-m-d",
                "Mobile"    => "required",
                "Email"    => 'sometimes|required|email|unique:employees',
                "Password"    => "required|min:8",
                "Job Number"    => ["required","numeric", new UniqueJopNumber()],
                "Trail Period Days"    => "required|numeric",
                "Contract Period Months"    => "required|numeric",
                "Contract Start Date"    => "required|date_format:Y-m-d",
                "Contract End Date"    => "required|date_format:Y-m-d",
                "Salary"    => "required|numeric",
            ]);
            if (!$validator->fails()){
                Employee::firstOrCreate([
                    'name_en' => $row['Name English'],
                    'name_ar' => $row['Name Arabic'],
                    'birthdate' => $row['BirthDate'],
                    'id_num' => $row['ID Number'],
                    'id_issue_date' => $row['Issue Date'],
                    'id_expire_date' => $row['Expire Date'],
                    'phone' => $row['Mobile'],
                    'email' => $row['Email'],
                    'password' => $row['Password'],
                    'job_number' => $row['Job Number'],
                    'test_period' => $row['Trail Period Days'],
                    'contract_period' => $row['Contract Period Months'],
                    'contract_start_date' => $row['Contract Start Date'],
                    'contract_end_date' => $row['Contract End Date'],
                    'salary' => $row['Salary'],
                    'is_completed' => false,
                ]);
            }

            return $validator->errors();
        });

        $allEmployeesAfterImport = Employee::withoutGlobalScope(CompletedScope::class)->count();
        $newEmployees = $allEmployeesAfterImport - $allEmployeesBeforeImport;

        if (!$validatorErrors->first()->isEmpty()){
            return redirect(route('dashboard.employees.import'))
                ->with('message' , "There are $newEmployees Employees has been registered into your company")
                ->withErrors($validatorErrors->first());
        }

        return redirect(route('dashboard.employees.import'))->with('message' , "There are $newEmployees Employees has been registered into your company");

    }

    public function leaveBalance(Employee $employee)
    {
        return response()->json(['leave_balance' => $employee->leave_balance]);
    }


}
