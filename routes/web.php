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


Route::domain('cashuce.com')->group(function () {

    Route::group([
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [
            'localeCookieRedirect',
            'localizationRedirect',
            'localeViewPath' ]
    ], function() {

        Auth::routes(['verify' => false]);



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
        Route::redirect('/login', '/login/company');
        Route::get('login/company', 'Auth\LoginController@loginCompanyForm')->name('login.company');
        Route::get('login/employee', 'Auth\LoginController@loginEmployeeForm')->name('login.employee');
        Route::get('login/provider', 'Auth\LoginController@loginProviderForm')->name('login.provider');

        Route::post('login/company', 'Auth\LoginController@loginCompany')->name('login.company');
        Route::post('login/employee', 'Auth\LoginController@loginEmployee')->name('login.employee');
        Route::post('login/provider', 'Auth\LoginController@loginProvider')->name('login.provider');

        Route::namespace('Dashboard')
            ->prefix('dashboard')
            ->name('dashboard.')
            ->middleware('auth:employee,company,provider')
//        ->middleware('verified')
            ->group(function () {
                Route::get('/', 'DashboardController@index')->name('index');
                Route::get('/abilities', 'AbilityController@index');
                Route::get('/violations/{violation}/additions', 'ViolationController@additions');
                Route::any('profile/company_profile', 'ProfileController@companyProfile')->name('profile.company_profile');
                Route::any('myProfile/change_language', 'ProfileController@changeLanguage')->name('myProfile.change_language');
                Route::get('myProfile/account_info', 'ProfileController@accountInfo')->name('myProfile.account_info');
                Route::post('myProfile/update_account_info', 'ProfileController@updateAccountInfo')->name('myProfile.update_account_info');
                Route::get('myProfile/change_password', 'ProfileController@changePasswordForm')->name('myProfile.change_password');
                Route::post('myProfile/change_password', 'ProfileController@changePassword')->name('myProfile.changePassword');
                Route::get('/reports/{report}/forwardToEmployee', 'ReportController@forwardToEmployee');
                Route::get('attendances/check/{employee:barcode}', 'AttendanceController@attendanceCheck');
                Route::get('attendances/myAttendance', 'AttendanceController@myAttendance')->name('attendances.my_attendances');
                Route::get('attendances/lateNotification', 'AttendanceController@lateNotification');
                Route::get('attendances/create_manually', 'AttendanceController@createManually')->name('attendances.create_manually');
                Route::post('attendances/store_manually', 'AttendanceController@storeManually')->name('attendances.store_manually');
                Route::get('notifications', 'NotificationController@index')->name('notifications.index');
                Route::get('notifications/mark_as_read/{id}', 'NotificationController@markAsRead')->name('notifications.mark_as_read');
                Route::get('unReadNotificationsNumber', 'NotificationController@unReadNotificationsNumber')->name('notifications.unReadNotificationsNumber');
                Route::get('employees/late_employees/{id}', 'EmployeeController@lateEmployees')->name('employees.late_employees');
                Route::post('requests/take_action/{request}', 'RequestController@takeAction')->name('requests.take_action');
                Route::get('requests/pending_requests', 'RequestController@pendingRequests')->name('requests.pending_requests');
                Route::get('requests/my_requests', 'RequestController@myRequests')->name('requests.my_requests');
                Route::get('payrolls/approve/{payroll}', 'PayrollController@approve')->name('payrolls.approve');
                Route::get('payrolls/reject/{payroll}', 'PayrollController@reject')->name('payrolls.reject');
                Route::get('payrolls/reissue/{payroll}', 'PayrollController@reissue')->name('payrolls.reissue');
                Route::get('payrolls/pending', 'PayrollController@pending')->name('payrolls.pending');
                Route::get('salaries/my_salaries', 'SalaryController@mySalaries')->name('salaries.my_salaries');
                Route::get('salaries/{salary}', 'SalaryController@show')->name('salaries.show');
                Route::any('settings/payrolls', 'SettingController@payrolls')->name('settings.payrolls');
                Route::get('departments/getSections/{department}', 'DepartmentController@getSectionList');
                Route::get('employees/end_service/{employee}', 'EmployeeController@endService');
                Route::get('employees/back_to_service/{employee}', 'EmployeeController@backToService');
                Route::get('expire_docs', 'DashboardController@expiringDocs');
                Route::get('attendance_summery', 'DashboardController@attendanceSummary');
                Route::get('ended_employees', 'DashboardController@endedEmployees');
                Route::get('employees/ended_employees', 'EmployeeController@endedEmployees')->name('employees.ended_employees');
                Route::get('documents/{document}/download', 'DocumentController@download');
                Route::resource('attendances', 'AttendanceController')->except('show');

                Route::resources([
                    'employees' => 'EmployeeController',
                    'violations' => 'ViolationController',
                    'roles' => 'RoleController',
                    'companies' => 'CompanyController',
                    'employees_violations' => 'EmployeeViolationController',
                    'reports' => 'ReportController',
                    'conversations' => 'ConversationController',
                    'messages' => 'MessageController',
                    'vacations' => 'VacationController',
                    'attendance_forgottens' => 'AttendanceForgottenController',
                    'requests' => 'RequestController',
                    'payrolls' => 'PayrollController',
                    'nationalities' => 'NationalityController',
                    'job_titles' => 'JobTitleController',
                    'allowances' => 'AllowanceController',
                    'work_shifts' => 'WorkShiftController',
                    'vacation_types' => 'VacationTypeController',
                    'feedbacks' => 'ComblaintController',
                    'departments' => 'DepartmentController',
                    'sections' => 'SectionController',
                    'providers' => 'ProviderController',
                    'leave_balances' => 'LeaveBalanceController',
                    'documents' => 'DocumentController',
                ]);

            });

    });

    Route::get('/dashboard/attendances/excel', 'Dashboard\AttendanceController@extractExcel');
});


Route::domain('{organization}.cashuce.com')->group(function () {

    Route::group([
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [
            'localeCookieRedirect',
            'localizationRedirect',
            'localeViewPath' ]
    ], function() {

        Auth::routes(['verify' => false]);



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
        Route::redirect('/login', '/login/company');
        Route::get('login/company', 'Auth\LoginController@loginCompanyForm')->name('login.company');
        Route::get('login/employee', 'Auth\LoginController@loginEmployeeForm')->name('login.employee');
        Route::get('login/provider', 'Auth\LoginController@loginProviderForm')->name('login.provider');

        Route::post('login/company', 'Auth\LoginController@loginCompany')->name('login.company');
        Route::post('login/employee', 'Auth\LoginController@loginEmployee')->name('login.employee');
        Route::post('login/provider', 'Auth\LoginController@loginProvider')->name('login.provider');

        Route::namespace('Dashboard')
            ->prefix('dashboard')
            ->name('dashboard.')
            ->middleware('auth:employee,company,provider')
//        ->middleware('verified')
            ->group(function () {
                Route::get('/', 'DashboardController@index')->name('index');
                Route::get('/abilities', 'AbilityController@index');
                Route::get('/violations/{violation}/additions', 'ViolationController@additions');
                Route::any('profile/company_profile', 'ProfileController@companyProfile')->name('profile.company_profile');
                Route::any('myProfile/change_language', 'ProfileController@changeLanguage')->name('myProfile.change_language');
                Route::get('myProfile/account_info', 'ProfileController@accountInfo')->name('myProfile.account_info');
                Route::post('myProfile/update_account_info', 'ProfileController@updateAccountInfo')->name('myProfile.update_account_info');
                Route::get('myProfile/change_password', 'ProfileController@changePasswordForm')->name('myProfile.change_password');
                Route::post('myProfile/change_password', 'ProfileController@changePassword')->name('myProfile.changePassword');
                Route::get('/reports/{report}/forwardToEmployee', 'ReportController@forwardToEmployee');
                Route::get('attendances/check/{employee:barcode}', 'AttendanceController@attendanceCheck');
                Route::get('attendances/myAttendance', 'AttendanceController@myAttendance')->name('attendances.my_attendances');
                Route::get('attendances/lateNotification', 'AttendanceController@lateNotification');
                Route::get('attendances/create_manually', 'AttendanceController@createManually')->name('attendances.create_manually');
                Route::post('attendances/store_manually', 'AttendanceController@storeManually')->name('attendances.store_manually');
                Route::get('notifications', 'NotificationController@index')->name('notifications.index');
                Route::get('notifications/mark_as_read/{id}', 'NotificationController@markAsRead')->name('notifications.mark_as_read');
                Route::get('unReadNotificationsNumber', 'NotificationController@unReadNotificationsNumber')->name('notifications.unReadNotificationsNumber');
                Route::get('employees/late_employees/{id}', 'EmployeeController@lateEmployees')->name('employees.late_employees');
                Route::post('requests/take_action/{request}', 'RequestController@takeAction')->name('requests.take_action');
                Route::get('requests/pending_requests', 'RequestController@pendingRequests')->name('requests.pending_requests');
                Route::get('requests/my_requests', 'RequestController@myRequests')->name('requests.my_requests');
                Route::get('payrolls/approve/{payroll}', 'PayrollController@approve')->name('payrolls.approve');
                Route::get('payrolls/reject/{payroll}', 'PayrollController@reject')->name('payrolls.reject');
                Route::get('payrolls/reissue/{payroll}', 'PayrollController@reissue')->name('payrolls.reissue');
                Route::get('payrolls/pending', 'PayrollController@pending')->name('payrolls.pending');
                Route::get('salaries/my_salaries', 'SalaryController@mySalaries')->name('salaries.my_salaries');
                Route::get('salaries/{salary}', 'SalaryController@show')->name('salaries.show');
                Route::any('settings/payrolls', 'SettingController@payrolls')->name('settings.payrolls');
                Route::get('departments/getSections/{department}', 'DepartmentController@getSectionList');
                Route::get('employees/end_service/{employee}', 'EmployeeController@endService');
                Route::get('employees/back_to_service/{employee}', 'EmployeeController@backToService');
                Route::get('expire_docs', 'DashboardController@expiringDocs');
                Route::get('attendance_summery', 'DashboardController@attendanceSummary');
                Route::get('ended_employees', 'DashboardController@endedEmployees');
                Route::get('employees/ended_employees', 'EmployeeController@endedEmployees')->name('employees.ended_employees');
                Route::get('documents/{document}/download', 'DocumentController@download');
                Route::resource('attendances', 'AttendanceController')->except('show');

                Route::resources([
                    'employees' => 'EmployeeController',
                    'violations' => 'ViolationController',
                    'roles' => 'RoleController',
                    'companies' => 'CompanyController',
                    'employees_violations' => 'EmployeeViolationController',
                    'reports' => 'ReportController',
                    'conversations' => 'ConversationController',
                    'messages' => 'MessageController',
                    'vacations' => 'VacationController',
                    'attendance_forgottens' => 'AttendanceForgottenController',
                    'requests' => 'RequestController',
                    'payrolls' => 'PayrollController',
                    'nationalities' => 'NationalityController',
                    'job_titles' => 'JobTitleController',
                    'allowances' => 'AllowanceController',
                    'work_shifts' => 'WorkShiftController',
                    'vacation_types' => 'VacationTypeController',
                    'feedbacks' => 'ComblaintController',
                    'departments' => 'DepartmentController',
                    'sections' => 'SectionController',
                    'providers' => 'ProviderController',
                    'leave_balances' => 'LeaveBalanceController',
                    'documents' => 'DocumentController',
                ]);

            });

    });

    Route::get('/dashboard/attendances/excel', 'Dashboard\AttendanceController@extractExcel');
});


