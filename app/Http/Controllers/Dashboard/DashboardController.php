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

    public function index(Request $request)
    {

        $employeesInTrail = $this->expiringDocs($request);
        $attendanceSummary = $this->attendanceSummary($request);
        $employeesStatistics = $this->employeesStatistics();
        $activities = $this->employeesActivities();
        $departmentsStatistics = $this->departmentsSection($request);

        return view('dashboard.index', compact([
            'employeesStatistics',
            'activities',
            'employeesInTrail',
            'attendanceSummary',
            'departmentsStatistics',
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

    public function departmentsSection(Request $request)
    {
        $totalActiveEmployees = Company::find(Company::companyID())->employees->count();
        $x = 0;
        $departments =  Department::get()->map(function ($department) use ($totalActiveEmployees, &$x){
            $colors = [
                '#017cc4',
                '#e83e8c',
                '#fd7e14',
                '#28a745',
                '#17a2b8',
                '#6c757d',
                '#343a40',
                '#017cc4',
                '#1dc9b7',
                '#ffb822',
                '#d2061e',
                '#343a40'
            ];
            $activeEmployeesInDepartment = $department->employees->count();

            if($activeEmployeesInDepartment > 0 && $totalActiveEmployees > 0){
                $percentage = ($activeEmployeesInDepartment / $totalActiveEmployees) * 100;
            }else{
                $percentage = 0;
            }
            return[
                'name' => $department->name(),
                'in_service' => $activeEmployeesInDepartment,
                'percentage' => number_format($percentage, 2),
                'color' => $colors[$x++ % count($colors)]
            ];
        });

        return json_decode($departments);
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
        $totalAttendees = 0;
        $employeesAttendance = [];

        foreach ($activeEmployees as $employee) {

            $todayAttendance = $employee->attendances()->whereDate('created_at', Carbon::today())->first();
            $employeeWorkShift = $employee->workShift;

            if(isset($todayAttendance)){
                $absent--;
                $totalAttendees++;
                $employeeTimeIn = $todayAttendance->time_in;

                $shiftStartTime = $employeeWorkShift->type == 'once' ? $employeeWorkShift->check_in_time :  $employeeWorkShift->shift_start_time;
                $delayAllowedTime = $employeeWorkShift->is_delay_allowed? $employeeWorkShift->time_delay_allowed : Carbon::createFromTime(0,0,0);
                $shiftStartTime = Carbon::createFromTimeString($shiftStartTime);
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
            'totalAttendees' => $totalAttendees,
            'absent' => $absent,
            'delay' => $delay,
            'early' => $early,
        ];
    }

    public function expiringDocs(Request $request)
    {
        $employeesInTrail = Employee::where('test_period' , '>' , 0)->get()->count();
        $activeEmployees = Company::find(Company::companyID())->employees;

        if($request->ajax()){
            $expiringDocs = $activeEmployees->map(function ($employee){
                $now = Carbon::now();
                if(isset($employee->contract_end_date) && isset($employee->test_period)){
                    $serviceLeftDays = $employee->contract_end_date->diff($now)->days;
                    $trailLeftDays = $employee->contract_start_date->addDays($employee->test_period)->diff($now)->days;
//
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
        $nationality = Nationality::where('name_en', 'Saudi')->first();
        return $employees->map(function ($employee) use ($nationality){
            if ($employee->nationality() == $nationality->name()){
                return $employee;
            }
        })->filter()->count();
    }
    public function nonSaudisNumber($employees)
    {
        $nationality = Nationality::where('name_en', 'Saudi')->first();
        return $employees->map(function ($employee) use ($nationality){
            if ($employee->nationality() != $nationality->name()){
                return $employee;
            }
        })->filter()->count();
    }
}
