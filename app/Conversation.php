<?php

namespace App;

use App\Scopes\ParentScope;
use App\Scopes\ServiceStatusScope;
use App\Scopes\SupervisorScope;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $casts = [
        'created_at'  => 'date:D M d Y',
    ];
    protected $guarded = [];

    public static function booted()
    {
        static::addGlobalScope(new ParentScope());

        static::creating(static function ($model){
            $model->company_id = Company::companyID();

        });

    }

    public function getEmployeeNameAttribute()
    {
        $nameParts = explode(' ' ,$this->employee->name());
        return $nameParts[0] . ' ' . $nameParts[count($nameParts) - 1];
    }

    public function getHrNameAttribute()
    {
        $nameParts = explode(' ' ,$this->hr->name());
        return $nameParts[0] . ' ' . $nameParts[count($nameParts) - 1];
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class)->withoutGlobalScopes([ServiceStatusScope::class, SupervisorScope::class]);
    }
    public function hr()
    {
        return $this->belongsTo(Employee::class, 'hr_id')->withoutGlobalScopes([ServiceStatusScope::class, SupervisorScope::class]);
    }

    public function newMessage($senderId, $content)
    {
        Message::create([
            'sender_id' => $senderId,
            'conversation_id' => $this->id,
            'content' => $content,
        ]);
    }
}
