<?php

namespace App\Scopes;

use App\Company;
use App\Employee;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class CompletedScope implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
        $builder->where('is_completed', true);
    }
}
