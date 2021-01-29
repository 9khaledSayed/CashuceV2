<?php

namespace App\Http\Controllers\Dashboard;

use App\Company;
use App\Department;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Nationality;
use App\Role;
use App\Scopes\ServiceStatusScope;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:employee,company,provider');
    }

    public function index(Request $request, $company = null)
    {

        $employeesInTrail = $this->expiringDocs($request);
        $attendanceSummary = $this->attendanceSummary($request);
        $employeesStatistics = $this->employeesStatistics();
        $departments = $this->departmentsSection();
        $activities = $this->employeesActivities();

        return view('dashboard.index', compact([
            'employeesStatistics',
            'activities',
            'departments',
            'employeesInTrail',
            'attendanceSummary',
        ]));
    }

    public function employeesStatistics()
    {
        $activeEmployees = Company::find(Company::companyID())->employees;
        $totalSingle = $activeEmployees->map(function($employee){
            if(!$employee->marital_status){
                return $employee;
            }
        })->filter()->count();

        $employeesStatistics = [
            "totalActiveEmployees" => $activeEmployees->count(),
            "total_saudis" => $this->saudisNumber($activeEmployees),
            "total_non_saudis" => $this->nonSaudisNumber($activeEmployees),
            "total_married" => $activeEmployees->where('marital_status', '1')->count(),
            "total_single" => $totalSingle,
            "total_trail" => $activeEmployees->whereNotNull('test_period')->count(),
        ];

        return $employeesStatistics;
    }

    public function departmentsSection()
    {
        $totalActiveEmployees = Company::find(Company::companyID())->employees->count();

        return Department::get()->map(function ($department) use ($totalActiveEmployees){
            $colors = [ 'danger', 'success', 'brand', 'warning','info'];
            $activeEmployeesInDepartment = $department->employees;
            $allDepartmentEmployees = Employee::withoutGlobalScope(new ServiceStatusScope())->where('department_id', $department->id)->get();

            if(isset($activeEmployeesInDepartment) && $totalActiveEmployees > 0){
                $percentage = ($activeEmployeesInDepartment->count() / $totalActiveEmployees) * 100;
            }else{
                $percentage = 0;
            }

            return[
                'name' => $department->name(),
                'in_service' => $allDepartmentEmployees->where('service_status' , 1)->count(),
                'out_service' => $allDepartmentEmployees->where('service_status' , 0)->count(),
                'saudi_no' => $this->saudisNumber($allDepartmentEmployees),
                'non_saudi_no' => $this->nonSaudisNumber($allDepartmentEmployees),
                'percentage' => $percentage,
                'color' => array_rand($colors),
            ];
        });
    }

    public function endedEmployees(Request $request)
    {
        if($request->ajax()){
            $endedEmployees = Employee::withoutGlobalScope(new ServiceStatusScope())->where('service_status', 0)->get()->map(function($endedEmployee){

                return [
                    'id' => $endedEmployee->id,
                    'name' => $endedEmployee->name(),
                    'service_status' => $endedEmployee->service_status,
                    'job_number' => $endedEmployee->job_number,
                    'email' => $endedEmployee->email,
                ];
            });
            return response()->json($endedEmployees);
        }
    }

    public function employeesActivities()
    {
        $employeesIDS = Company::find(Company::companyID())->employees->pluck('id');
        return Activity::orderBy('created_at', 'desc')->get()->whereIn('causer_id', $employeesIDS) ?? [];
    }



    public function attendanceSummary(Request $request)
    {
        $activeEmployees = Company::find(Company::companyID())->employees;
        $totalActiveEmployees = $activeEmployees->count();
        $absent = $totalActiveEmployees;
        $delay = 0;
        $early = 0;
        $employeesAttendance = [];

        foreach ($activeEmployees as $employee) {

            $todayAttendance = $employee->attendances()->whereDate('created_at', Carbon::today())->first();
            $employeeWorkShift = $employee->workShift;

            if(isset($todayAttendance)){
                $absent--;
                $employeeTimeIn = $todayAttendance->time_in;
                $shiftStartTime = $employeeWorkShift->type == 'once' ? $employeeWorkShift->check_in_time :  $employeeWorkShift->shift_start_time;
                $delayAllowedTime = $employeeWorkShift->is_delay_allowed? $employeeWorkShift->time_delay_allowed : Carbon::createFromTime(0,0,0);
                $shiftStartTime->addMinutes($delayAllowedTime->minute);
                $shiftStartTime->addHours($delayAllowedTime->hour);
                $employeeTimeOut = isset($todayAttendance->time_out) ? $todayAttendance->time_out->format('h:iA') : '';

                if($employeeWorkShift->type == 'divided'){
                    $employeeTimeOut = isset($todayAttendance->time_out2) ? $todayAttendance->time_out2->format('h:iA') : '';
                }
                if($employeeTimeIn->gt($shiftStartTime)){
                    $delay++;
                }elseif($employeeTimeIn->lt($shiftStartTime)){
                    $early++;
                }

                array_push($employeesAttendance, [
                    'id' => $employee->id,
                    'job_number' => $employee->job_number,
                    'name' => $employee->name(),
                    'status' => $employeeTimeIn->format('h:iA') . ' -- ' . $employeeTimeOut,
                ]);
            }
        }

        if($request->ajax()){
            return response()->json($employeesAttendance);
        }
        return [
            'totalActiveEmployees' => $totalActiveEmployees,
            'absent' => $absent,
            'delay' => $delay,
            'early' => $early,
        ];
    }

    public function expiringDocs(Request $request)
    {
        $employeesInTrail = Employee::whereNotNull('test_period')->get()->count();
        $activeEmployees = Company::find(Company::companyID())->employees;

        if($request->ajax()){
            $expiringDocs = $activeEmployees->map(function ($employee){
                $now = Carbon::now();
                if(isset($employee->contract_end_date) && isset($employee->test_period)){
                    $serviceLeftDays = $employee->contract_end_date->diff($now)->days;
                    $trailEndDate = $employee->contract_end_date->addDays($employee->test_period);
                    $trailLeftDays = 0;
                    if($trailEndDate->lt($now)){
                        $trailLeftDays = ($employee->contract_end_date->addDays($employee->test_period))->diff($now)->days;

                    }
//                    if($serviceLeftDays < 50 && $serviceLeftDays > 0){
                    return[
                        'id' => $employee->id,
                        'job_number' => $employee->job_number,
                        'name' => $employee->name(),
                        'expire_date' => $employee->contract_end_date->format('Y-m-d'),
                        'service_days_left' => $serviceLeftDays . __(' Days Left'),
                        'trail_days_left' => $trailLeftDays . __(' Days Left'),
                    ];
//                    }
                }
            })->filter();

            return response()->json($expiringDocs);
        }
        return $employeesInTrail;
    }

    public function saudisNumber($employees)
    {
        return $employees->map(function ($employee){
            if ($employee->nationality() == __('Saudi')){
                return $employee;
            }
        })->filter()->count();
    }
    public function nonSaudisNumber($employees)
    {
        return $employees->map(function ($employee){
            if ($employee->nationality() != __('Saudi')){
                return $employee;
            }
        })->filter()->count();
    }
}
