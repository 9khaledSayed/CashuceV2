<?php

namespace App;

use App\Scopes\ParentScope;
use App\Scopes\ProviderScope;
use App\Scopes\ServiceStatusScope;
use App\Scopes\SupervisorScope;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use anlutro\LaravelSettings\Facade as Setting;
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
        'fname_ar' => ['required', 'string'],
        'sname_ar' => ['required', 'string'],
        'tname_ar' => ['nullable', 'string'],
        'lname_ar' => ['required', 'string'],
        'fname_en' => ['required', 'string'],
        'sname_en' => ['required', 'string'],
        'tname_en' => ['nullable', 'string'],
        'lname_en' => ['required', 'string'],
        'email' => 'sometimes|required|email|unique:employees',
        'provider_id' => 'nullable|numeric|exists:providers,id',
        'supervisor_id' => 'nullable|numeric|exists:employees,id',
        'department_id' => 'required|numeric|exists:departments,id',
        'section_id' => 'required|numeric|exists:sections,id',
        'role_id' => 'required|numeric|exists:roles,id',
        'birthdate' => ['required', 'date'],
        'nationality_id' => 'required|numeric|exists:nationalities,id',
        'job_title_id' => 'required|numeric|exists:job_titles,id',
        'marital_status' => ['required'],
        'gender' => ['required'],
        'test_period' => ['required'],
        'city_name_ar' => ['required'],
        'city_name_en' => ['required'],
        'id_num' => ['required'],
        'id_issue_date' => ['nullable'],
        'id_expire_date' => ['nullable'],
        'passport_num' => ['nullable'],
        'passport_issue_date' => ['nullable'],
        'passport_expire_date' => ['nullable'],
        'issue_place' => ['nullable'],
        'job_number' =>['required'],
        'joined_date' => ['required'],
        'work_shift_id' => ['required', 'exists:work_shifts,id'],
        'contract_type' => ['required'],
        'contract_start_date' => ['required'],
        'contract_end_date' => ['nullable'],
        'contract_period' => 'nullable',
        'salary' => ['required', 'numeric'],
        'phone' => ['required'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],

    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'contract_start_date' => 'datetime',
        'contract_end_date' => 'date Y-m-d',
        'created_at'  => 'date:D M d Y',
    ];


    public function getDescriptionForEvent(string $eventName): string
    {
        $baseName = class_basename(__CLASS__);
        return "$baseName has been {$eventName}";
    }

    public static function booted()
    {
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
                 $model->vacations_balance = 30;

             }
         });
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function name()
    {
        return $this->{'fname_' . app()->getLocale()} . ' ' . $this->{'lname_' . app()->getLocale()};
    }


    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function abilities()
    {
        return $this->role->abilities->flatten()->pluck('name')->unique();
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
        return $add;
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
        return $add;
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
        return $this->belongsTo(Employee::class, 'supervisor_id');
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
        $work_days = Attendance::where('employee_id', $this->id)->whereNotNull(['time_in', 'time_out'])->whereMonth('created_at', $month)->count();
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
        $deduc = 0;
        foreach ($this->allowances as $allowance) {
            if($allowance->type == 1){ // addition
                if(isset($allowance->percentage)){
                    $add += $this->salary * ($allowance->percentage/100);
                }else{
                    $add += $allowance->value;
                }
            }
            if($allowance->type == 0 && $allowance->label != 'gosi'){ // deduction
                if(isset($allowance->percentage)){
                    $deduc += $this->salary * ($allowance->percentage/100);
                }else{
                    $deduc += $allowance->value;
                }
            }
        }
        return $this->salary + $add - $deduc;
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

    public static function isSupervisor()
    {
        return ( auth()->guard('employee')->check() && auth()->user()->role->label == 'Supervisor');
    }

    public static function supervisorID()
    {
        return auth()->user()->id;
    }



}
