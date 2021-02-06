<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class City extends Model
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

    public function name()
    {
        return $this->{'name_' . app()->getLocale()};
    }
    //
}
