<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $department = new \App\Department([
            'name_ar' => 'Dep1',
            'name_en' => 'Dep1',
            'company_id' => 1,
        ]);

        $section = new \App\Section([
            'name_ar' => 'Sec1',
            'name_en' => 'Sec1',
            'department_id' => 1,
            'company_id' => 1
        ]);
        $department->saveWithoutEvents(['creating']);
        $section->saveWithoutEvents(['creating']);

        $supervisor = \App\Employee::create([
            'fname_ar'      => 'Supervisor',
            'lname_ar'      => 'Supervisor',
            'fname_en'      => 'Supervisor',
            'lname_en'      => 'Supervisor',
            'birthdate'      => '2020-08-01',
//            'joined_date'      => '2020-08-01',
            'nationality_id'      => '0',
            'department_id'      => 1,
            'section_id'      => 1,
            'role_id'      => 4,
            'id_num'      => '54566546544',
            'contract_type'      => '1',
            'contract_start_date'      => '2020-08-01',
            'contract_period'      => '12',
            'phone'      => '01021212121',
            'email' => 'supervisor@admin.com',
            'company_id' => 1,
            'work_shift_id' => 1,
            'job_number' => 1112,
            'barcode' => '53070424',
            'leave_balance' => 30,
            'email_verified_at' => now(),
            'password' => 'password', // password
            'remember_token' => Str::random(10),
        ]);
        $hrManager = \App\Employee::create([
            'fname_ar'      => 'hr',
            'lname_ar'      => 'hr',
            'fname_en'      => 'hr',
            'lname_en'      => 'hr',
            'birthdate'      => '2020-08-01',
//            'joined_date'      => '2020-08-01',
            'nationality_id'      => '0',
            'department_id'      => 1,
            'section_id'      => 1,
            'role_id'      => 3,
            'id_num'      => '54566546544',
            'contract_type'      => '1',
            'contract_start_date'      => '2020-08-01',
            'contract_period'      => '12',
            'phone'      => '01021212121',
            'email' => 'hr@admin.com',
            'company_id' => 1,
            'work_shift_id' => 1,
            'job_number' => 1113,
            'barcode' => '53070425',
            'leave_balance' => 30,
            'email_verified_at' => now(),
            'password' => 'password', // password
            'remember_token' => Str::random(10),
        ]);
        $emp1 = \App\Employee::create([
            'fname_ar'      => 'employee1',
            'lname_ar'      => 'employee1',
            'fname_en'      => 'employee1',
            'lname_en'      => 'employee1',
            'birthdate'      => '2020-08-01',
//            'joined_date'      => '2020-08-01',
            'nationality_id'      => '0',
            'department_id'      => 1,
            'section_id'      => 1,
            'role_id'      => 5,
            'id_num'      => '54566546544',
            'contract_type'      => '1',
            'contract_start_date'      => '2020-08-01',
            'contract_period'      => '12',
            'phone'      => '01021212121',
            'email' => 'emp1@admin.com',
            'company_id' => 1,
            'work_shift_id' => 1,
            'job_number' => 1114,
            'barcode' => '53070426',
            'leave_balance' => 30,
            'email_verified_at' => now(),
            'password' => 'password', // password
            'remember_token' => Str::random(10),
        ]);
        $emp2 = \App\Employee::create([
            'fname_ar'      => 'Employee2',
            'lname_ar'      => 'Employee2',
            'fname_en'      => 'Employee2',
            'lname_en'      => 'Employee2',
            'birthdate'      => '2020-08-01',
//            'joined_date'      => '2020-08-01',
            'nationality_id'      => '0',
            'department_id'      => 1,
            'section_id'      => 1,
            'role_id'      => 5,
            'id_num'      => '54566546544',
            'contract_type'      => '1',
            'contract_start_date'      => '2020-08-01',
            'contract_period'      => '12',
            'phone'      => '01021212121',
            'email' => 'emp2@admin.com',
            'company_id' => 1,
            'work_shift_id' => 1,
            'job_number' => 1116,
            'barcode' => '53070427',
            'leave_balance' => 30,
            'email_verified_at' => now(),
            'password' => 'password', // password
            'remember_token' => Str::random(10),
        ]);

    }
}
