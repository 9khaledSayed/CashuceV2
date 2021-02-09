<?php

use App\Ability;
use App\Employee;
use App\Scopes\ParentScope;
use \Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [
        'localeCookieRedirect',
        'localizationRedirect',
        'localeViewPath' ]
], function() {

    Auth::routes([
        'login' => false, // Registration Routes...
        'reset' => false, // Password Reset Routes...
//        'verify' => false, // Email Verification Routes...
    ]);

    Route::prefix('employee')->group(function() {
        //Employee Password Reset routes
        Route::post('/password/email','Auth\EmployeeForgotPasswordController@sendResetLinkEmail')->name('employee.password.email');
        Route::post('/password/reset', 'Auth\EmployeeResetPasswordController@reset')->name('employee.password.update');
        Route::get('/password/reset', 'Auth\EmployeeForgotPasswordController@showLinkRequestForm')->name('employee.password.request');
        Route::get('/password/reset/{token}', 'Auth\EmployeeResetPasswordController@showResetForm')->name('employee.password.reset');
    });
    Route::prefix('company')->group(function() {
        //Employee Password Reset routes
        Route::post('/password/email','Auth\CompanyForgotPasswordController@sendResetLinkEmail')->name('company.password.email');
        Route::post('/password/reset', 'Auth\CompanyResetPasswordController@reset')->name('company.password.update');
        Route::get('/password/reset', 'Auth\CompanyForgotPasswordController@showLinkRequestForm')->name('company.password.request');
        Route::get('/password/reset/{token}', 'Auth\CompanyResetPasswordController@showResetForm')->name('company.password.reset');
    });
    Route::prefix('provider')->group(function() {
        //Employee Password Reset routes
        Route::post('/password/email','Auth\ProviderForgotPasswordController@sendResetLinkEmail')->name('provider.password.email');
        Route::post('/password/reset', 'Auth\ProviderResetPasswordController@reset')->name('provider.password.update');
        Route::get('/password/reset', 'Auth\ProviderForgotPasswordController@showLinkRequestForm')->name('provider.password.request');
        Route::get('/password/reset/{token}', 'Auth\ProviderResetPasswordController@showResetForm')->name('provider.password.reset');
    });

    Route::redirect('/', '/login/company');
    Route::get('login/company', 'Auth\LoginController@loginCompanyForm')->name('login.company');
    Route::get('login/employee', 'Auth\LoginController@loginEmployeeForm')->name('login.employee');
    Route::get('login/provider', 'Auth\LoginController@loginProviderForm')->name('login.provider');

    Route::post('login/company', 'Auth\LoginController@loginCompany')->name('login.company');
    Route::post('login/employee', 'Auth\LoginController@loginEmployee')->name('login.employee');
    Route::post('login/provider', 'Auth\LoginController@loginProvider')->name('login.provider');

});

Route::get('attendances_sheet/excel', 'Dashboard\AttendanceController@extractExcel');
Route::get('payroll_special/excel/{payroll}', 'Dashboard\Fordeal\FordealPayrollController@excel');

Route::domain('www.cashuce.com')->group(function () {

    Route::redirect('/', 'https://cashuce.com');
});

//Route::get('fix', function(){
//   $fordeal = new \App\Role([
//       'name_arabic' => 'صلاحية Fordeal',
//       'name_english' => 'Fordeal Role',
//       'label' => 'fordeal',
//       'for' => 'fordeal',
//       'type' => 'System Role',
//       'company_id' => 1
//   ]);
//    $fordeal->saveWithoutEvents(['creating']);
//
//
//
//    \App\Ability::create([
//        'name'  => 'create_employees_fordeal',
//        'label' => 'Create Employees',
//        'category' => 'employees',
//        'for' => 'fordeal'
//    ]);
//    \App\Ability::create([
//        'name'  => 'update_employees_fordeal',
//        'label' => 'Update Employees',
//        'category' => 'employees',
//        'for' => 'fordeal'
//    ]);
//    \App\Ability::create([
//        'name'  => 'show_employees_fordeal',
//        'label' => 'Show Employees',
//        'category' => 'employees',
//        'for' => 'fordeal'
//    ]);
//
//    \App\Ability::create([
//        'name'  => 'show_payrolls_fordeal',
//        'label' => 'Show Payrolls',
//        'category' => 'payrolls',
//        'for' => 'fordeal'
//    ]);
//
//    \App\Ability::create([
//        'name'  => 'view_employees_fordeal',
//        'label' => 'View Employees',
//        'category' => 'employees',
//        'for' => 'fordeal'
//    ]);
//
//
//    $abilities = Ability::where('for', 'shared')->orWhere('for', 'fordeal')->get();
//
//    foreach($abilities->whereIn('category',[
//        'roles',
//        'employees',
//        'employees_violations',
//        'reports',
//        'conversations',
//        'payrolls',
//        'requests',
//        'employees_services',
//        'attendances'
//    ]) as $ability){
//        $fordeal->allowTo($ability);
//    }
//
//    dd('done');
//});


Route::get('edit', function(){

    $jobTitles = \App\JobTitle::withoutGlobalScope(ParentScope::class)->whereNull('company_id')->get();

    foreach ($jobTitles as $jobTitle) {
        $jobTitle->company_id = 5;
        $jobTitle->save();

    }
    dd('done');

});

Route::get('/fix_names', function (){
   $employees = Employee::withoutGlobalScope(new ParentScope())->withoutGlobalScope(new \App\Scopes\ServiceStatusScope)->get();

    foreach ($employees as $employee) {
        $namesARS = [$employee->fname_ar , $employee->snam_ar , $employee->tname_ar  , $employee->lname_ar];
        $namesENS = [$employee->fname_en , $employee->snam_en , $employee->tname_en  , $employee->lname_en];

        $employee->name_ar = implode(' ', array_filter($namesARS));
        $employee->name_en = implode(' ', array_filter($namesENS));
        $employee->save();
   }
    dd('done');
});


Route::get('/countries', function (){

    dd(Countries::lookup('ar'));
});

Route::get('/ability', function (){
    \App\Ability::create([
        'name'  => 'show_payrolls_fordeal',
        'label' => 'Show Payrolls',
        'category' => 'payrolls',
        'for' => 'fordeal'
    ]);
});




