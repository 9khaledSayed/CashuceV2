<?php

namespace App;

use App\Scopes\ParentScope;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class JobTitle extends Model
{
    use LogsActivity;

    protected $guarded = [];
    public static $rules = [
        'name_ar' => 'required|string|max:255|unique:nationalities',
        'name_en' => 'required|string|max:255|unique:nationalities',
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
        static::creating(function ($model){
            $model->company_id = Company::companyID();
        });


    }

    public function name()
    {
        return $this->{'name_' . app()->getLocale()};
    }
}
