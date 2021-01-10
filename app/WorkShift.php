<?php

namespace App;

use App\Scopes\ParentScope;
use Illuminate\Database\Eloquent\Model;

class WorkShift extends Model
{

    protected $guarded = [];
    public static $rules = [
        'name_ar' => ['required', 'string', 'max:255'],
        'name_en' => ['required', 'string', 'max:255'],
        'work_days' => ['required', 'array'],
        'shift_start_time' => ['required_if:type,normal,divided,flexible', 'exclude_if:type,once'],
        'shift_end_time' => ['required_if:type,normal,divided,flexible', 'exclude_if:type,once'],
        'second_shift_start_time' => ['required_if:type,divided','exclude_unless:type,divided'],
        'second_shift_end_time' => ['required_if:type,divided','exclude_unless:type,divided'],
        'work_hours' => [ 'required_if:type,flexible,once', 'exclude_unless:type,flexible,once', 'max:12'],
        'check_in_time' => ['required_if:type,once', 'exclude_unless:type,once'],
        'overtime_hours' => ['required'],
        'is_delay_allowed' => ['nullable'],
        'time_delay_allowed' => ['required_if:is_delay_allowed,1'],
        'type' => ['required', 'string', 'max:255'],
    ];
    protected $casts = [
        'shift_start_time' => 'date:h:i',
        'shift_end_time' => 'date:h:i',
        'second_shift_start_time' => 'date:h:i',
        'second_shift_end_time' => 'date:h:i',
        'check_in_time' => 'date:h:i',
        'overtime_hours' => 'date:h:i',
        'time_delay_allowed' => 'date:h:i',
    ];

    public function saveWithoutEvents(array $options=[])
    {
        return static::withoutEvents(function() use ($options) {
            return $this->save($options);
        });
    }

    public static function booted()
    {
        static::creating(static function ($model){
            $employee = auth()->user();
            $manager_id = $employee->is_manager? $employee->id:$employee->manager->id;
            $model->manager_id = $manager_id; // Ceo Id
        });
        static::addGlobalScope(new ParentScope());
    }

    public function setWorkDaysAttribute($workDays)
    {
        $this->attributes['work_days'] = serialize($workDays);
    }


    public function name()
    {
        return $this->{'name_' . app()->getLocale()};
    }

}
