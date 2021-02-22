<?php

namespace App;

use App\Scopes\ParentScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class WorkShift extends Model
{
    use LogsActivity;

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
        'shift_start_time' => 'time',
        'shift_end_time' => 'time',
        'second_shift_start_time' => 'time',
        'second_shift_end_time' => 'time',
        'check_in_time' => 'time',
        'overtime_hours' => 'time',
        'time_delay_allowed' => 'date',
    ];

    protected static $logUnguarded = true;

    public function getDescriptionForEvent(string $eventName): string
    {
        $baseName = class_basename(__CLASS__);
        return "$baseName has been {$eventName}";
    }

    public function saveWithoutEvents(array $options=[])
    {
        return static::withoutEvents(function() use ($options) {
            return $this->save($options);
        });
    }

    public static function booted()
    {
        static::addGlobalScope(new ParentScope());
        static::creating(function ($model){
            $model->company_id = Company::companyID();
        });
    }

    public function setWorkDaysAttribute($workDays)
    {
        $this->attributes['work_days'] = serialize($workDays);
    }


    public function name()
    {
        return $this->{'name_' . app()->getLocale()};
    }

    public function workingHours()
    {
        if($this->type == 'normal'){
            $startTime = Carbon::createFromTimeString($this->shift_start_time);
            $endTime = Carbon::createFromTimeString($this->shift_end_time);
            return $startTime->diffInHours($this->endTime);

        }elseif($this->type == 'divided'){

            $startTime = Carbon::createFromTimeString($this->shift_start_time);
            $endTime = Carbon::createFromTimeString($this->shift_end_time);
            $secondStartTime = Carbon::createFromTimeString($this->shift_start_time);
            $secondEndTime = Carbon::createFromTimeString($this->shift_end_time);

            $firstShiftHours = $startTime->diffInHours($endTime);
            $secondShiftHours = $secondStartTime->diffInHours($secondEndTime);
            return  $firstShiftHours + $secondShiftHours;

        }else{
            return $this->work_hours;
        }
    }

    public function workingDays()
    {
        return count(unserialize($this->work_days));
    }

    public function officialWorkingHours()
    {
        $totalHours = $this->workingHours() * $this->workingDays();
        if ($totalHours == 0){
            return 1;
        }
        return  $totalHours;
    }

    public function officialAbsentHours()
    {
        return $this->workingHours() * $this->daysOff();
    }

    public function daysOff()
    {
        $daysOff = 7 - count(unserialize($this->work_days));
        return $daysOff * 4;
    }

    public function shiftInfo()
    {
        $format = 'h:i A';
        if($this->type == 'normal' || $this->type == 'flexible'){
            $startTime = Carbon::createFromTimeString($this->shift_start_time);
            $endTime = Carbon::createFromTimeString($this->shift_end_time);
            return $startTime->format($format) . ' - ' . $endTime->format($format);

        }elseif($this->type == 'divided'){

            $startTime = Carbon::createFromTimeString($this->shift_start_time);
            $endTime = Carbon::createFromTimeString($this->shift_end_time);
            $secondStartTime = Carbon::createFromTimeString($this->shift_start_time);
            $secondEndTime = Carbon::createFromTimeString($this->shift_end_time);

            return "<h6>First Shift :-</h6> " . $startTime->format($format) . "-"  . $endTime->format($format)
                  ."<br><h6>Second Shift :-</h6> " . $secondStartTime->format($format) . "-"  . $secondEndTime->format($format);

        }else{
            return "<h6>Once Shift (Working hours) :-</h6> " . $this->work_hours;
        }
    }

}
