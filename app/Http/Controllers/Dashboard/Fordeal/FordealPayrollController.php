<?php

namespace App\Http\Controllers\Dashboard\Fordeal;

use App\Company;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\PayrollController;
use App\Payroll;
use App\Provider;
use App\Rules\UniqueMonth;
use App\Salary;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FordealPayrollController extends PayrollController
{


    public function show(Payroll $payroll, Request $request)
    {

        $this->authorize('show_payrolls_fordeal');
        if($request->ajax()){
            $salaries = Salary::where('payroll_id', $payroll->id)->get()->map(function ($salary){
                $employee = $salary->employee;
                $provider = $employee->provider;
                $provider = isset($provider) ? $employee->provider->name(): '';
                $officialWorkingHours = isset($employee->workShift) ? $employee->workShift->officialWorkingHours() : 1;
                $officialAbsentHours = isset($employee->workShift) ? $employee->workShift->officialAbsentHours() : 0;
                return [
                    'job_number' => $employee->job_number,
                    'employee_name' => $employee->name(),
                    'department' => $employee->department->name(),
                    'supplier' => $provider,
                    'officialWorkingHours' => $officialWorkingHours,
                    'officialWorkingHoursWithOverTime' => $officialWorkingHours,
                    'officialAbsentHours' => $officialAbsentHours,
                    'hourly_wage' => number_format($employee->salary / $officialWorkingHours, 2),
                    'salary' => $employee->salary,
                    'net_pay' => $salary->net_salary,
                    'employee_id' => $employee->id,
                ];
            });
            return response()->json($salaries);
        }
        return view('dashboard.fordeal.payrolls.show', compact('payroll'));
    }



    public function destroy(Payroll $payroll)
    {
        //
    }
}
