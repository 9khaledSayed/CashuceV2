<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//,company-api,employee-api,provider-api
Route::middleware(['cors', 'json.response', 'auth:user-api,company-api,employee-api,provider-api'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['cors']], function () {

    // public routes
    Route::post('/login', 'API\Auth\ApiAuthController@login')->name('login.api');
    Route::post('/register','API\Auth\ApiAuthController@register')->name('register.api');
    Route::post('/logout', 'API\Auth\ApiAuthController@logout')->name('logout.api');
});

//Route::middleware('auth:company-api,employee-api,provider-api')->group(function () {
//    Route::get('/employees', 'API\EmployeeController@index');
//});
