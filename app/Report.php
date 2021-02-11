<?php

namespace App;

use App\Scopes\ParentScope;
use App\Scopes\SupervisorScope;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Report extends Model
{
    use LogsActivity;

    protected $guarded = [];

    protected $casts = [
        'created_at'  => 'date:D M d Y',
    ];
    public static $rules = [
        'employee_id' => 'required|numeric|exists:employees,id',
        'violation_date' => 'required|date',
        'description' => ['required', 'string'],
    ];

    protected static $logUnguarded = true;

    public function getDescriptionForEvent(string $eventName): string
    {
        $baseName = class_basename(__CLASS__);
        return "$baseName has been {$eventName}";
    }

    public static function booted()
    {
        static::creating(function ($model){
            $model->company_id = Company::companyID();
            $model->supervisor_id = auth()->user()->id; // for director
        });

        static::addGlobalScope(new ParentScope());
    }


    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(Employee::class, 'supervisor_id')->withoutGlobalScopes([ParentScope::class, SupervisorScope::class]);
    }
}
