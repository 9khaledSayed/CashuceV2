<?php

namespace App;

use App\Scopes\ServiceStatusScope;
use Illuminate\Database\Eloquent\Model;

class Decision extends Model
{
    protected $guarded = [];

    public function decisionable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }
    public function getTypeAttribute()
    {
        $type = '';
        switch ($this->decisionable_type){
            case "App\\EndService":
                $type = __('End Service');
                break;
        }
        return $type;
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class)->withoutGlobalScope(ServiceStatusScope::class);
    }

}
