<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{
    protected $guarded =[];
    protected $casts = [
        'start_date'  => 'date:Y-m-d',
        'end_date'  => 'date:Y-m-d',
        'created_at'  => 'date:D M d Y',
    ];

    public function saveWithoutEvents(array $options=[])
    {
        return static::withoutEvents(function() use ($options) {
            return $this->save($options);
        });
    }

    protected static function booted()
    {
        static::created(function($vacation){
            Request::create([
                'employee_id' => auth()->user()->id,
                'requestable_id' => $vacation->id,
                'requestable_type' => 'App\Vacation',
            ]);
        });
    }

    protected function getVacationNameAttribute()
    {
        if(isset($this->vacation_type)){
            return $this->vacation_type->name();
        }else{
            return $this->{'reason_' . app()->getLocale()};
        }
    }

//    public function vacationType()
//    {
//        return $this->{'vacation_type_' . app()->getLocale()};
//    }

    public function vacation_type()
    {
        return $this->belongsTo(VacationType::class);
    }
    public function request()
    {
        return $this->morphOne(Request::class, 'requestable');
    }
}
