<?php

namespace App;

use App\Notifications\EmployeeResetPasswordNotification;
use App\Scopes\CompletedScope;
use App\Scopes\ParentScope;
use App\Scopes\ProviderScope;
use App\Scopes\ServiceStatusScope;
use App\Scopes\SupervisorScope;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;

class Employee extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use LogsActivity;
    use CausesActivity;

    protected $table = 'employees';

    protected $guarded = [];
    protected static $logUnguarded = true;

    protected $hidden = [
        'password', 'remember_token',
    ];


    public static $rules = [
        'name_ar' => ['required', 'string'],
        'name_en' => ['required', 'string'],
        'email' => 'sometimes|required|email|unique:employees',
        'provider_id' => 'nullable|numeric|exists:providers,id',
        'department_id' => 'required|numeric|exists:departments,id',
        'section_id' => 'required|numeric|exists:sections,id',
        'role_id' => 'required|numeric|exists:roles,id',
        'birthdate' => ['required', 'date'],
        'nationality_id' => 'required|numeric|exists:nationalities,id',
        'job_title_id' => 'required|numeric|exists:job_titles,id',
        'marital_status' => ['required'],
        'gender' => ['required'],
        'test_period' => ['required'],
        'city_id' => 'required|numeric|exists:cities,id',
        'id_num' => ['required'],
        'id_expire_date' => ['nullable'],
        'passport_num' => ['nullable'],
        'passport_issue_date' => ['nullable'],
        'passport_expire_date' => ['nullable'],
        'issue_place' => ['nullable'],
        'job_number' =>['required','numeric'],
        'work_shift_id' => ['required', 'exists:work_shifts,id'],
        'contract_type' => ['required'],
        'contract_start_date' => ['required'],
        'contract_end_date' => ['nullable'],
        'contract_period' => 'nullable',
        'salary' => ['required', 'numeric'],
        'phone' => ['required'],
        'leave_balance' => 'required|numeric|min:0|max:365|exists:leave_balances,days_per_year',
        'password' => ['required', 'string', 'min:8', 'confirmed'],

    ];

    public static $fordealRules = [
        'name_en' => ['required', 'string'],
        'email' => 'sometimes|required|email|unique:employees',
        'provider_id' => 'nullable|numeric|exists:providers,id',
        'department_id' => 'required|numeric|exists:departments,id',
        'section_id' => 'required|numeric|exists:sections,id',
        'role_id' => 'required|numeric|exists:roles,id',
        'birthdate' => ['required', 'date'],
        'nationality_id' => 'required|numeric|exists:nationalities,id',
        'job_title_id' => 'required|numeric|exists:job_titles,id',
        'marital_status' => ['required'],
        'gender' => ['required'],
        'city_id' => 'required|numeric|exists:cities,id',
        'id_num' => ['required'],
        'id_issue_date' => ['nullable'],
        'id_expire_date' => ['nullable'],
        'job_number' =>['required','numeric'],
        'work_shift_id' => ['required', 'exists:work_shifts,id'],
        'contract_type' => ['required'],
        'contract_start_date' => ['required'],
        'salary' => ['required', 'numeric'],
        'phone' => ['required'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],

    ];


    public static $saveRules = [
        'name_ar' => ['nullable', 'string'],
        'name_en' => ['nullable', 'string'],
        'email' => 'sometimes|nullable|email|unique:employees',
        'provider_id' => 'nullable|numeric|exists:providers,id',
        'department_id' => 'nullable|numeric|exists:departments,id',
        'section_id' => 'nullable|numeric|exists:sections,id',
        'role_id' => 'nullable|numeric|exists:roles,id',
        'birthdate' => ['nullable', 'date'],
        'nationality_id' => 'nullable|numeric|exists:nationalities,id',
        'job_title_id' => 'nullable|numeric|exists:job_titles,id',
        'marital_status' => ['nullable'],
        'gender' => ['nullable'],
        'test_period' => ['nullable'],
        'city_id' => 'nullable|numeric|exists:cities,id',
        'id_num' => ['nullable'],
        'id_expire_date' => ['nullable'],
        'passport_num' => ['nullable'],
        'passport_issue_date' => ['nullable'],
        'passport_expire_date' => ['nullable'],
        'issue_place' => ['nullable'],
        'job_number' =>['nullable','numeric'],
        'work_shift_id' => ['nullable', 'exists:work_shifts,id'],
        'contract_type' => ['nullable'],
        'contract_start_date' => ['nullable'],
        'contract_end_date' => ['nullable'],
        'contract_period' => 'nullable',
        'salary' => ['nullable', 'numeric'],
        'phone' => ['nullable'],
        'leave_balance' => 'nullable|numeric|min:0|max:365|exists:leave_balances,days_per_year',
        'password' => ['nullable', 'string', 'min:8', 'confirmed'],

    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
        'contract_start_date' => 'date',
        'contract_end_date' => 'date',
        'created_at'  => 'date:D M d Y',
    ];


    public function sendPasswordResetNotification($token)
    {
        $this->notify(new EmployeeResetPasswordNotification($token));
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        $baseName = class_basename(__CLASS__);
        return "$baseName has been {$eventName}";
    }

    public static function booted()
    {
        static::addGlobalScope(new CompletedScope());
        static::addGlobalScope(new ParentScope());
        static::addGlobalScope(new SupervisorScope());
        static::addGlobalScope(new ServiceStatusScope());
        static::addGlobalScope(new ProviderScope());

        static::creating(function ($model){
             if(auth()->check()){

                 $barcode = rand(0, 99999999);
                 $barcode = str_pad($barcode, 8, "0", STR_PAD_LEFT);
                 while (Employee::pluck('job_number')->contains($barcode)){
                     $barcode = rand(0, 99999999);
                     $barcode = str_pad($barcode, 12, "0", STR_PAD_LEFT);
                 }

                 $model->company_id = Company::companyID();
                 $model->barcode = $barcode;

             }
         });

        static::saving(function ($employee){
            if($employee->is_compleated){
                $supervisorID = $employee->department->supervisor_id;
                if($supervisorID != 0){
                    $employee->supervisor_id = $supervisorID;
                    $employee->save();
                }
            }
        });
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function getNationalityNameAttribute()
    {
        $nationality = Nationality::find($this->nationality_id);
        return $nationality ? $nationality->name() : '';
    }

    public function getRoleNameAttribute()
    {
        return $this->role->name();
    }

    public function getJobTitleNameAttribute()
    {
        $job_title = JobTitle::find($this->job_title_id);
        return $job_title ? $job_title->name() : '';
    }

    public function getSupervisorNameAttribute()
    {
        $supervisor = $this->supervisor;
        return $supervisor ? $supervisor->name() : '';
    }

    public function getSectionNameAttribute()
    {
        $section = $this->section;
        return $section ? $section->name() : '';
    }

    public function getDepartmentNameAttribute()
    {
        $department = $this->department;
        return $department ? $department->name() : '';
    }

    public function getProviderNameAttribute()
    {
        $proider = $this->provider;
        return $proider ? $proider->name() : '';
    }

    public function name()
    {
        return $this->{'name_' . app()->getLocale()};
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function abilities()
    {
        return $this->role->abilities->flatten()->pluck('name')->unique();
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }


    public function allowances()
    {
        return $this->belongsToMany(Allowance::class);
    }

    public function hra()
    {
        $add = 0;
        $hra = $this->allowances()->where('label', 'hra')->first();
        if(!isset($hra))
            return 0;
        if($hra->type == 1){ // addition
            if(isset($hra->percentage)){
                $add = $this->salary * ($hra->percentage/100);
            }else{
                $add = $hra->value;
            }
        }
        return number_format($add, 2);
    }
    public function transfer()
    {
        $add = 0;
        $transfer = $this->allowances()->where('label', 'transfer')->first();
        if(!isset($transfer))
            return 0;
        if($transfer->type == 1){ // addition
            if(isset($transfer->percentage)){
                $add = $this->salary * ($transfer->percentage/100);
            }else{
                $add = $transfer->value;
            }
        }
        return number_format($add, 2);
    }

    public function otherAllowances()
    {
        return $this->allowances()->whereNotIn('label', ['transfer', 'hra'])
            ->get()
            ->map(function ($allowance){
                if($allowance->type == 1){ // addition
                    if(isset($allowance->percentage)){
                        return $this->salary * ($allowance->percentage/100);
                    }else{
                        return $allowance->value;
                    }
                }
        })->sum();

    }

    public function workShift()
    {
        return $this->belongsTo(WorkShift::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function dailySalary()
    {
        return $this->salary / 30;
    }

    public function employee_violations()
    {
        return $this->hasMany(EmployeeViolation::class, 'employee_id');
    }




    public function supervisedEmployees()
    {
        return $this->hasMany(Employee::class, 'supervisor_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(Employee::class, 'supervisor_id')->withoutGlobalScope(SupervisorScope::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function nationality()
    {
        $nationality = Nationality::find($this->nationality_id);
        return $nationality ? $nationality->name() : '';
    }

    public function job_title()
    {
        $job_title = JobTitle::find($this->job_title_id);
        return $job_title ? $job_title ->name() : '';
    }

    public function deductions()
    {
        return $this->employee_violations->map(function($employee_violations){
            $deduction =  is_numeric($employee_violations->deduction) ? $employee_violations->deduction : 0;
            $additionTo =  is_numeric($employee_violations->addition_to) ? $employee_violations->addition_to : 0;
            return $deduction + $additionTo;
        })->sum();
    }

    public function workDays($month)
    {
        $work_days = Attendance::where('employee_id', $this->id)->whereNotNull(['time_in', 'time_out'])->whereMonth('date', $month)->count();
        return $work_days;
    }

    public function daysOff()
    {
        $daysOff = isset($this->workShift) ? 7 - count(unserialize($this->workShift->work_days)) : 0;
        return $daysOff * 4;
    }

    public function salary()
    {
        return $this->totalPackage() - $this->gosiDeduction();
    }

    public function totalPackage()
    {
        $add = 0;
//        $deduc = 0;
        foreach ($this->allowances as $allowance) {
            if($allowance->type == 1){ // addition
                if(isset($allowance->percentage)){
                    $add += $this->salary * ($allowance->percentage/100);
                }else{
                    $add += $allowance->value;
                }
            }
//            if($allowance->type == 0 && $allowance->label != 'gosi'){ // deduction
//                if(isset($allowance->percentage)){
//                    $deduc += $this->salary * ($allowance->percentage/100);
//                }else{
//                    $deduc += $allowance->value;
//                }
//            }
        }
        return $this->salary + $add;
    }
    public function totalAdditionAllowances()
    {
        $add = 0;
        foreach ($this->allowances as $allowance) {
            if($allowance->type == 1){ // addition
                if(isset($allowance->percentage)){
                    $add += $this->salary * ($allowance->percentage/100);
                }else{
                    $add += $allowance->value;
                }
            }
        }
        return $add;
    }


    public function gosiDeduction()
    {
        $gosi = $this->allowances()->where('label', 'gosi')->first();
        $hra = $this->allowances()->where('label', 'hra')->first();

        if(isset($gosi) && isset($hra)){
            $hraAddition = 0;
            if(isset($hra->percentage)){
                $hraAddition = $this->salary * ($hra->percentage/100);
            }else{
                $hraAddition = $hra->value;
            }

            if(isset($gosi->percentage)){
                $gosiDeduction = ($this->salary + $hraAddition) * ($gosi->percentage /100);
            }else{
                $gosiDeduction = $gosi->value;
            }

            return $gosiDeduction;
        }

        return 0;
    }

    public function isSupervisor()
    {

        return !auth()->guard('company')->check() && Department::where('supervisor_id', $this->id)->exists();
    }

    public  function isHR()
    {
        $hr = $this->company->HR();

        if(isset($hr)){

            return $this->id == $this->company->HR()->id;

        }else{

            return false;

        }

    }

    public static function supervisorID()
    {
        return auth()->user()->id;
    }

    public function duration($termination_date)
    {
        $termination_date = Carbon::parse($termination_date);
        $total_days = $termination_date->diffInDays($this->contract_start_date);

        $years = floor($total_days / 365);
        $x = ($total_days / 365) - $years;
        $months = floor($x * 12);
        $x = ($x * 12) - $months;
        $days = floor($x * 30);

        return [
            'months' => $months,
            'days'   => $days,
            'years'  => $years
        ];
//        return [
//            'months' => $termination_date->diffInMonths($this->contract_start_date),
//            'days'   => $termination_date->diffInDays($this->contract_start_date),
//            'years'  => $termination_date->diffInYears($this->contract_start_date)
//        ];
    }


}
