<?php

namespace App\Http\Controllers\Dashboard;

use App\Attendance;
use App\Company;
use App\Department;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Nationality;
use App\Notifications\AlarmForEmployee;
use App\Notifications\EmployeesLate;
use App\Notifications\LateWarning;
use App\Provider;
use App\Scopes\SupervisorScope;
use App\Section;
use Box\Spout\Writer\Style\StyleBuilder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Rap2hpoutre\FastExcel\FastExcel;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee,company,provider');
    }

    public function index(Request $request)
    {
        $this->authorize('view_attendance_sheet');

        $requestDate = isset($request->full_date) ? $request->full_date : Carbon::today()->format('Y-m-d');


        if ($request->ajax()) {
            $sortColumn = $request->sort['field'] ?? 'id';
            $sortType = $request->sort['sort'] ?? 'asc';

            $employees = Employee::orderBy($sortColumn, $sortType)->get()->map(function ($employee) use ($requestDate){
                $todayAttendance = $employee->attendances()->whereDate('date', $requestDate);
                $attendanceStatus = $todayAttendance->exists();
                $timeIn = isset($todayAttendance->first()->time_in) ? $todayAttendance->first()->time_in->format('h:i A') : '';
                $timeOut = isset($todayAttendance->first()->time_out) ? $todayAttendance->first()->time_out->format('h:i A') : '';
                return [
                    'id' => $employee->id,
                    'attendance_id' => $attendanceStatus ? $todayAttendance->first()->id : 0,
                    'name' => $employee->name(),
                    'job_number' => $employee->job_number,
                    'status' => $attendanceStatus ? 'Present' : 'Absent',
                    'shift_info' => $employee->workShift->shiftInfo(),
                    'time_in' => $attendanceStatus ? $timeIn : '',
                    'time_out' => $attendanceStatus ? $timeOut : '',
                    'supervisor' => $employee->supervisor_name,
                    'nationality' => $employee->nationality_name,
                    'department' => $employee->department_name,
                    'section' => $employee->section->name(),
                    'provider' => $employee->provider_name,
                    'total_working_hours' => $attendanceStatus ? $todayAttendance->first()->total_working_hours : 0,
                ];

            });

            return response()->json($employees);
        }else{
            return view('dashboard.attendances.index', [
                'supervisors' =>  Company::supervisors(),
                'nationalities' => Nationality::get(),
                'providers' => Provider::get(),
                'departments' => Department::get(),
                'sections' => Section::get(),
                'fullDate' => $requestDate,
            ]);
        }

    }

    public function absentees(Request $request)
    {

        if ($request->ajax()){
            $absentees = Employee::get()->filter(function ($employee){
                if ($employee->attendances()->whereDate('created_at', Carbon::today())->doesntExist()){
                    return $employee;
                }else{
                    return null;
                }
            });
            return  response()->json($absentees);
        }
        return view('dashboard.attendances.absentees');
    }

    public function create()
    {
        $this->authorize('view_attendance_record_page');
        return view('dashboard.attendances.create');
    }

    public function createManually()
    {
        $this->authorize('view_attendance_record_page');
        $employees = Employee::get();
        return view('dashboard.attendances.create_manually', compact('employees'));
    }

    public function store(Request $request)
    {

        $this->authorize('view_attendance_record_page');
        $request->validate([
            'barcode' => 'required|numeric|min:8|exists:employees,barcode',
        ]);
        $employee = Employee::where('barcode', $request->barcode)->first();
        $dateTime = Carbon::now();
        $dateTime->minute = $this->roundToQuarterHour($dateTime);
        $response =  $this->storeAttendance($dateTime, $employee);

        return response()->json($response);
    }

    public function storeManually(Request $request)
    {
        $this->authorize('view_attendance_record_page');
        $request->validate([
            'employee_id' => 'required|numeric|exists:employees,id',
            'date_time' => 'required',
        ]);
        $employee = Employee::find($request->employee_id);

        $dateTime = Carbon::createFromFormat('d/m/Y - g:i:s A', $request->date_time);

        $response = $this->storeAttendance($dateTime, $employee);

        return response()->json($response);
    }


    public function update(Attendance $attendance, Request $request)
    {
        $timeIn = Carbon::createFromFormat('h:i A', $request->time_in);
        $timeOut = Carbon::createFromFormat('h:i A', $request->time_out);
        $this->validateTimeInAndOut();
        $totalWorkingHours = $timeIn->diff($timeOut);
        $attendance->update([
            'time_in' => $timeIn->format('h:i'),
            'time_out' => $timeOut->format('h:i'),
            'total_working_hours' => $totalWorkingHours->format('%h:%I:%s'),
        ]);

        return response()->json([
            'status' => 'done'
        ]);
    }

    public function getOperation(Employee $employee)
    {
        $this->authorize('view_attendance_record_page');
        $attendance = $employee->attendances()->whereDate('created_at', Carbon::today())->first();
        $checked_in = isset($attendance->time_in);
        $checked_out = isset($attendance->time_out);


        if(!$checked_in){
            $status = 'Check in';
        } elseif (!$checked_out){
            $status = 'Check out';
        }else{
            $status = 'Attendance and leave have been recorded';
        }

        return $status;
    }

    public function myAttendance()
    {
        $this->authorize('view_my_attendance_history');
        $this->authorize('must_be_employee');
        return view('dashboard.attendances.my_attendances', [
            'my_attendances' => auth()->user()->attendances()->get()
        ]);
    }

    public function storeAttendance(Carbon $dateTime, $employee)
    {
        $workShift = $employee->workShift ?? null;
        $response  = [];
        if (!isset($employee)){
            return [
                "status" => true,
                "message" => __("This employee is not under your supervision"),
            ];
        }elseif(!isset($workShift)){
            $response = [
                "status" => true,
                "message" => __("There is No Work shift for employee ") . $employee->name(),
            ];
        }else{
            switch($workShift->type){
                case "divided": // time_in, time_out, time_in2, time_out2
                    $todayAttendance = $employee->attendances()->whereDate('date', $dateTime)->first();
                    if(!isset($todayAttendance)){ //check in

                        Attendance::create([
                            'employee_id' => $employee->id,
                            'time_in' => $dateTime->format('H:i'),
                            'date' => $dateTime->format('Y-m-d'),
                        ]);
                        $response = [
                            "status" => true,
                            "message" => __("The operation check in  has been done successfully for employee ") . $employee->name(),
                        ];

                    }elseif (!isset($todayAttendance->time_out)){

                        $timeBetween = $todayAttendance->time_in->diffInHours($dateTime);
                        if($timeBetween >=1) {
                            $todayAttendance->update([
                                'time_out' => $dateTime->format('H:i'),
                            ]);
                            $response = [
                                'status' => true,
                                "message" => __("The operation check out  has been done successfully for employee ") . $employee->name(),
                            ];
                        }else{
                            $response = [
                                'status' => false,
                                "message" => __("It is not possible to record the time out process for the employee ") . $employee->name() . __(" until after at least an hour."),
                            ];
                        }
                    }elseif (!isset($todayAttendance->time_in2)){

                        $timeBetween = $todayAttendance->time_out->diffInHours($dateTime);
                        if($timeBetween >=1) {
                            $todayAttendance->update([
                                'time_in2' => $dateTime->format('H:i'),
                            ]);
                            $response = [
                                'status' => true,
                                "message" => __("The operation check in  has been done successfully for employee ") . $employee->name(),
                            ];
                        }else{
                            $response = [
                                'status' => false,
                                "message" => __("It is not possible to record the time out process for the employee ") . $employee->name() . __(" until after at least an hour."),
                            ];
                        }


                    }elseif (!isset($todayAttendance->time_out2)){

//                    $workingHoursForShift1 = (new Carbon($todayAttendance->time_in))->diff(new Carbon($todayAttendance->time_out));
//                    $workingHoursForShift2 = (new Carbon($todayAttendance->time_in2))->diff($dateTime->format('H:i:s'));
//                    $totalWorkingHours = $workingHoursForShift2->addHours($workingHoursForShift1->format('H'));
//                    $totalWorkingHours->addMinutes($workingHoursForShift1->format('i'));

                        $timeBetween = $todayAttendance->time_in2->diffInHours($dateTime);
                        if($timeBetween >=1) {
                            $totalWorkingHours = (new Carbon($todayAttendance->time_in))->diff(new Carbon($dateTime->format('H:i:s')));
                            $todayAttendance->update([
                                'time_out2' => $dateTime->format('H:i'),
                                'total_working_hours' => $totalWorkingHours->format('%h:%I:%s')
                            ]);
                            $response = [
                                'status' => true,
                                "message" => __("The operation check out  has been done successfully for employee ") . $employee->name(),
                            ];
                        }else{
                            $response = [
                                'status' => false,
                                "message" => __("It is not possible to record the time out process for the employee ") . $employee->name() . __(" until after at least an hour."),
                            ];
                        }

                    }else{

                        $response = [
                            'status' => false,
                            'message' => __('The attendance has been already record for employee ') . $employee->name(),
                        ];

                    }
                    break;
                case "once":
                    $todayAttendance = $employee->attendances()->whereDate('date', $dateTime)->first();
                    if(!isset($todayAttendance)){ //check in

                        Attendance::create([
                            'employee_id' => $employee->id,
                            'time_in' => $dateTime->format('H:i'),
                            'time_out' => $dateTime->addHours($workShift->work_hours),
                            'date' => $dateTime->format('Y-m-d'),
                            'total_working_hours' => Carbon::createFromTime($workShift->work_hours)->format('H:i:s')
                        ]);
                        $response = [
                            "status" => true,
                            "message" => __("The operation check in  has been done successfully for employee ") . $employee->name(),
                        ];

                    }else{
                        $response = [
                            'status' => false,
                            'message' => __('The attendance has been already record for employee ') . $employee->name(),
                        ];
                    }
                    break;
                default: // normal && flexible

                    $todayAttendance = $employee->attendances()->whereDate('date', $dateTime)->first();
                    if(!isset($todayAttendance)){ //check in

                        Attendance::create([
                            'employee_id' => $employee->id,
                            'time_in' => $dateTime->format('H:i'),
                            'date' => $dateTime->format('Y-m-d'),
                        ]);
                        $response = [
                            "status" => true,
                            "message" => __("The operation check in  has been done successfully for employee ") . $employee->name(),
                        ];

                    }elseif (!isset($todayAttendance->time_out)){
                        $timeBetween = $todayAttendance->time_in->diffInHours($dateTime);
                        if($timeBetween >=1){
                            $totalWorkingHours = (new Carbon($todayAttendance->time_in))->diff(new Carbon($dateTime->format('H:i:s')))->format('%h:%I:%s');

                            $todayAttendance->update([
                                'time_out' => $dateTime->format('H:i'),
                                'total_working_hours' => $totalWorkingHours
                            ]);
                            $response = [
                                'status' => true,
                                "message" => __("The operation check out  has been done successfully for employee ") . $employee->name(),
                            ];
                        }else{
                            $response = [
                                'status' => false,
                                "message" => __("It is not possible to record the time out process for the employee ") . $employee->name() . __(" until after at least an hour."),
                            ];
                        }


                    }else{

                        $response = [
                            'status' => false,
                            'message' => __('The attendance has been already record for employee ') . $employee->name(),
                        ];

                    }
                    break;
            }
        }

        $response['image_url'] = asset('storage/employees/avatars/' . ($employee->photo ?? 'default.jpg'));
        $response['employee_name'] = $employee->name();
        return $response;
    }

    function roundToQuarterHour($time) {
        $minutes = $time->minute;
        return $minutes - ($minutes % 15);
    }

    public function extractExcel(Request $request)
    {

        $attendances = Attendance::orderBy('date', 'desc')->get();
        $fileName = 'attendances.xlsx';
        if(isset($request->this_day)){

            $attendances = Attendance::where('date', $request->this_day)->get();
            $fileName = $request->this_day . '&&attendances.xlsx';

        }elseif(isset($request->this_month)){

            $date = Carbon::createFromFormat('Y-m-d', $request->this_month);
            $attendances = Attendance::whereMonth('date', $date->format('m'))->get();
            $fileName = $date->format('F') . '&&attendances.xlsx';

        }




        $attendances = $attendances->map(function($attendance){

            $employee = $attendance->employee ;
            if(isset($employee)){

                $work_shift = $employee->workShift;
                $department = $employee->department->name_en;
                $provider = isset($employee->provider) ? $employee->provider->name_en : '';
                $time_out = $work_shift->type == 'divided' ? $attendance->time_out2 : $attendance->time_out;
                $shift_start_time = $work_shift->type == 'once' ? $work_shift->check_in_time :  $work_shift->shift_start_time;
                $shift_work_hours = $work_shift->work_hours;
                $total_working_hours = $attendance->total_working_hours;

                $delayAllowedTime = $work_shift->is_delay_allowed? $work_shift->time_delay_allowed : Carbon::createFromTime(0,0,0);
                $shiftStartTime = $work_shift->type == 'once' ? $work_shift->check_in_time : $work_shift->shift_start_time;
                $shiftStartTime = Carbon::createFromTimeString($shiftStartTime);
                $shiftStartTime->addMinutes($delayAllowedTime->minute);
                $shiftStartTime->addHours($delayAllowedTime->hour);
                $delay = Carbon::createFromTime(0,0,0)->format('H:i');
                $early = Carbon::createFromTime(0,0,0)->format('H:i');
                $date = $attendance->date;
                $dailyWage = $employee->totalPackage() / (30 - $employee->daysOff());

                if($attendance->time_in->gt($shiftStartTime)){
                    $delay = $attendance->time_in->diff($shiftStartTime)->format('%H:%I:%S');
                    $delay = date('h:i:s', strtotime($delay));
                }else{
                    $early = $attendance->time_in->diff($shiftStartTime)->format('%H:%I:%S');
                    $early = date('h:i:s', strtotime($early));

                }

                return [
                    'Job Number' => $employee->job_number,
                    'Employee Name' => $employee->{'fname_en'} . ' ' . $employee->{'lname_en'},
                    'Department' => $department,
                    'Supplier' => $provider,
                    'Date' => $date,
                    'Shift Start Time' => isset($shift_start_time) ? Carbon::createFromTimeString($shift_start_time)->format('h:iA') : '',
                    'Time In' => $date . $this->modifyMinutes($attendance->time_in),
                    'Time Out' => isset($time_out) ? $date . $this->modifyMinutes($time_out) : '',
                    'WorkShift' => $work_shift->name_en,
                    'Shift Work Hours' => $shift_work_hours ?? '',
                    'Total Working Hours' => $total_working_hours ?? '',
                    'Delay' => $delay,
                    'Early' => $early,
                    'Daily Wage' => round($dailyWage, 2),
                ];
            }

        })->filter();


        $header_style = (new StyleBuilder())
            ->setFontSize(8)
            ->setFontBold()
            ->build();

        $rows_style = (new StyleBuilder())
            ->setFontSize(8)
            ->setBackgroundColor("EDEDED")
            ->build();

        return (new FastExcel($attendances))
            ->headerStyle($header_style)
            ->rowsStyle($rows_style)
            ->download($fileName);
    }


    public function modifyMinutes(Carbon $time)
    {
        $minute = $time->minute;

        if($minute >= 53 || $minute <= 6){

            $time->minute(0);

        }elseif($minute >= 7 && $minute <= 22){

            $time->minute(15);

        }elseif($minute >= 23 && $minute <= 36){

            $time->minute(30);

        }elseif($minute >= 37 && $minute <= 52){

            $time->minute(45);

        }

        return $time->format(' h:i:s');
    }

    public function validateTimeInAndOut()
    {
        return request()->validate([
            'time_in' => 'required',
            'time_out' => 'required',
        ]);
    }
}
