<?php

namespace App;


use App\Scopes\ParentScope;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Allowance extends Model
{
    use LogsActivity;

    protected $guarded = [];
    public static $rules = [
        'name_ar'    => ['sometimes', 'required', 'string:191'],
        'name_en'    => ['sometimes', 'required', 'string:191'],
        'percentage' => [] ,
        'value' =>  [],
        'type' => 'required|integer'
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

    public function name()
    {
        return $this->{'name_' . app()->getLocale()};
    }

    public static function generateDefaultAllowances($companyID)
    {
        $hra = new Allowance([
            'name_en'  => 'Housing',
            'name_ar'  => 'سكن',
            'type' => 1,
            'percentage' => 25,
            'label' => 'hra',
            'is_basic' => true,
            'company_id' => $companyID
        ]);
        $transfer = new Allowance([
            'name_en'  => 'Transfer',
            'name_ar'  => 'مواصلات',
            'type' => 1,
            'percentage' => 10,
            'label' => 'transfer',
            'is_basic' => true,
            'company_id' => $companyID
        ]);
        $gosi = new Allowance([
            'name_en'  => 'GOSI Subscription',
            'name_ar'  => 'استقطاع التأمينات الاجتماعية',
            'type' => 0,
            'percentage' => 10,
            'label' => 'gosi',
            'is_basic' => true,
            'company_id' => $companyID
        ]);

        $transfer->saveWithoutEvents(['creating']);
        $hra->saveWithoutEvents(['creating']);
        $gosi->saveWithoutEvents(['creating']);
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::Class);
    }
}
