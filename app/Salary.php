<?php

namespace App;

use App\Scopes\ServiceStatusScope;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $guarded =[];
    protected $dates = ['date', 'issue_date'];

    public function employee()
    {
        return $this->belongsTo(Employee::class)->withoutGlobalScope(ServiceStatusScope::class);
    }

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }
}
