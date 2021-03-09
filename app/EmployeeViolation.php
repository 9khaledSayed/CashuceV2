<?php

namespace App;

use App\Scopes\ParentScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class EmployeeViolation extends Model
{
    use LogsActivity;

    protected $table = 'employee_violation';
    protected $guarded = [];
    protected $dates = ['date'];
    protected $casts = [
        'created_at'  => 'date:D M d Y',
        'date'  => 'date:D M d Y',
    ];
    public static $rules = [
        'employee_id' => ['required','numeric','exists:employees,id'],
        'violation_id' => 'required|numeric|exists:violations,id',
        'date' => 'required|date|before_or_equal:today',
        'minutes_late' => 'nullable|numeric',
        'absences_days' => 'nullable|numeric',
    ];

    protected static $logUnguarded = true;

    public function getDescriptionForEvent(string $eventName): string
    {
        $baseName = class_basename(__CLASS__);
        return "$baseName has been {$eventName}";
    }

    public static function booted()
    {
        static::addGlobalScope(new ParentScope());

        static::creating(static function ($model){
            $model->company_id = Company::companyID();
        });

    }

    public function getViolationDateAttribute()
    {
        return Carbon::createFromFormat('D M d Y', $this->date)->format('Y-m-d');
    }

    public function reason()
    {
        return app()->isLocale('ar')?$this->violation->reason_in_arabic:$this->violation->reason_in_english;
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function violation()
    {
        return $this->belongsTo(Violation::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

}
