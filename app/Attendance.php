<?php

namespace App;

use App\Scopes\ParentScope;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $guarded = [];
    protected $casts = [
        'time_in'  => 'date:h:i',
        'time_out'  => 'date:h:i',
        'time_in2'  => 'date:h:i',
        'time_out2'  => 'date:h:i',
        'date'  => 'date',
    ];

    protected static function booted()
    {
        parent::booted(); // TODO: Change the autogenerated stub
        static::addGlobalScope(new ParentScope());

        static::creating(static function ($model){
            $model->company_id = Company::companyID();
        });
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
