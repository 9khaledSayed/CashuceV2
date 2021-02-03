<?php

use Illuminate\Support\Facades\Route;

Route::name('dashboard.fordeal.')->group(function () {
    Route::resource('employees_special', 'FordealEmployeeController');

});
