<?php

use Illuminate\Support\Facades\Route;

Route::name('dashboard.fordeal.')->group(function () {
    Route::resource('employees_special', 'FordealEmployeeController');
    Route::get('payroll_special/{payroll}', 'FordealPayrollController@show')->name('payroll_special.show');
    Route::get('payroll_special/{payroll}/excel', 'FordealPayrollController@excel')->name('payroll_special.excel');
});
