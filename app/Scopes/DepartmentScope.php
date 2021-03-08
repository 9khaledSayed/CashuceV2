<?php

namespace App\Scopes;

use App\Company;
use App\Department;
use App\Employee;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class DepartmentScope implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
        if (Auth::hasUser()){
            if(\auth()->guard('employee')->check())
            if(\auth()->user()->isSupervisor()){
                $department = Department::where('supervisor_id', Auth::user()->id)->first();
                $builder->where('department_id', $department->id);
            }
        }

    }
}
