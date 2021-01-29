<?php

use App\Employee;
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



Route::domain('{company?}.cashuce.com')->group(function () {
    include 'allRoutes.php';
});

//Route::domain('cashuce.com')->group(function () {
//    include 'allRoutes.php';
//});





