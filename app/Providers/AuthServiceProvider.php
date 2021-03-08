<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability){
            if(Auth::check() && $user->abilities()->contains($ability)){
                return true;
            }
        });

        Gate::define('not-company', function ($user){
            if(\auth()->guard('company')->check()){
                return false;
            }else{
                return true;
            }
        });
        Gate::define('must_be_employee', function ($user){
            if(\auth()->guard('employee')->check()){
                return true;
            }else{
                return false;
            }
        });
    }
}
