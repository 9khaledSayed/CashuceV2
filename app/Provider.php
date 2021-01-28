<?php

namespace App;

use App\Notifications\ProviderResetPasswordNotification;
use App\Scopes\ParentScope;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Provider extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use LogsActivity;
    use CausesActivity;

    protected $guarded  = [];
    protected $hidden = [
        'password', 'remember_token',
    ];
    public static $rules = [
        'name_ar' => 'required|string|max:255',
        'name_en' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:providers',
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ProviderResetPasswordNotification($token));
    }

    public static function booted()
    {
        static::addGlobalScope(new ParentScope());

        static::creating(function ($model){
            $model->company_id = Company::companyID();
            $role = Role::withoutGlobalScope(new ParentScope())->where('label', 'provider')->firstOrFail();
            $model->role_id = $role->id;
        });
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function name()
    {
        return $this->{'name_' . app()->getLocale()};
    }

    public function role()
    {
        return $this->belongsTo(Role::class)->withoutGlobalScope(new ParentScope());
    }

    public function abilities()
    {
        return $this->role->abilities->flatten()->pluck('name')->unique();
    }
}
