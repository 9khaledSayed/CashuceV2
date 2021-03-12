<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::redirect('/', '/dashboard');

Route::name('dashboard.')->prefix(LaravelLocalization::setLocale() . '/dashboard')->group(function () {
            Route::get('/', 'DashboardController@index')->name('index');
            Route::get('/departments_statistics', 'DashboardController@departmentsSection');
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
            Route::get('extract_excel_form', 'EmployeeController@extractExcelForm')->name('employees.export.form');
            Route::get('import', 'EmployeeController@showImportForm')->name('employees.import');
            Route::post('import', 'EmployeeController@import')->name('employees.import');
            Route::get('extract_excel', 'EmployeeController@extractExcel')->name('employees.export');
            Route::get('ended_employees', 'DashboardController@endedEmployees');
            Route::get('employees/ended_employees', 'EmployeeController@endedEmployees')->name('employees.ended_employees');
            Route::get('documents/{document}/download', 'DocumentController@download');
            Route::post('candidates/{candidate}/upload_document', 'CandidateController@uploadDocuments');
            Route::post('profile_picture/upload', 'ProfileController@uploadProfilePicture')->name('profile_picture.upload');
            Route::get('attendances/update/{attendance}', 'AttendanceController@update');
            Route::get('vacations/assign_vacation', 'VacationController@assignVacation')->name('vacations.assign_vacation');
            Route::post('vacations/assign_vacation', 'VacationController@storeAssignedVacation')->name('vacations.store_assigned_vacation');
            Route::get('vacation_types/{vacation_type}/vacation_days', 'VacationTypeController@vacationDays');
            Route::post('candidates/decision/{candidate}', 'CandidateController@decision')->name('candidates.decision');
            Route::get('employees/{employee}/leave_balance', 'EmployeeController@leaveBalance')->name('employees.leave_balance');
            Route::get('payrolls/{payroll}/excel', 'PayrollController@excel')->name('payrolls.excel');
            Route::get('attendances/absentees', 'AttendanceController@absentees')->name('attendances.absentees');
            Route::resource('attendances', 'AttendanceController')->except('show');


            Route::prefix('decisions')->name('decisions.')->group(function (){
                Route::resource('end_services', 'EndServiceController')->except(['index', 'edit', 'update', 'delete']);
                Route::get('end_service_reward', 'EndServiceController@endServiceReward');

            });

            Route::resource('decisions', 'DecisionController')->except(['edit', 'update', 'delete']);

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
                'cities' => 'CityController',
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
                'archives' => 'ArchiveController',
                'candidates' => 'CandidateController',
            ]);

        });
