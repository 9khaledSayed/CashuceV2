<?php

use Illuminate\Support\Facades\Route;

Route::name('dashboard.')->group(function () {

    Route::get('employees/create', 'FordealEmployeeController@create');

});
