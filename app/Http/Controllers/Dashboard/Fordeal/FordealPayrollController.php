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
use Box\Spout\Writer\Style\StyleBuilder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

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
                $officialWorkingHours = 208;
                $officialAbsentHours = isset($employee->workShift) ? $employee->workShift->officialAbsentHours() : 0;
                return [
                    'job_number' => $employee->job_number,
                    'employee_name' => $employee->name_en,
                    'department' => $employee->department->name(),
                    'supplier' => $provider,
                    'officialWorkingHours' => $officialWorkingHours,
                    'officialWorkingHoursWithOverTime' => $officialWorkingHours,
                    'officialAbsentHours' => $officialAbsentHours,
                    'hourly_wage' => number_format($employee->totalPackage() / $officialWorkingHours, 2),
                    'salary' => $employee->salary,
                    'net_pay' => $salary->net_salary,
                    'employee_id' => $employee->id,
                ];
            });
            return response()->json($salaries);
        }
        return view('dashboard.fordeal.payrolls.show', compact('payroll'));
    }

    public function excel(Payroll $payroll)
    {
        $fileName = 'payroll.xlsx';

        $salaries = Salary::where('payroll_id', $payroll->id)->get()->map(function ($salary){
            $employee = $salary->employee;
            $provider = $employee->provider;
            $provider = isset($provider) ? $employee->provider->name(): '';
            $officialWorkingHours = 208;
            $officialAbsentHours = isset($employee->workShift) ? $employee->workShift->officialAbsentHours() : 0;
            return [
                'Job Number' => $employee->job_number,
                'Employee' => $employee->name_en,
                'Department' => $employee->department->name(),
                'Supplier' => $provider,
                'Official Working Hours' => $officialWorkingHours,
                'Official Working Hours With OverTime' => $officialWorkingHours,
                'Official Absent Hours' => $officialAbsentHours,
                'Hourly Wage' => number_format($employee->salary / $officialWorkingHours, 2),
                'Salary' => $employee->salary,
                'Net Pay' => $salary->net_salary,
            ];
        });

        $header_style = (new StyleBuilder())
            ->setFontSize(8)
            ->setFontBold()
            ->build();

        $rows_style = (new StyleBuilder())
            ->setFontSize(8)
            ->setBackgroundColor("EDEDED")
            ->build();

        return (new FastExcel($salaries))
            ->headerStyle($header_style)
            ->rowsStyle($rows_style)
            ->download($fileName);
    }

    public function destroy(Payroll $payroll)
    {
        //
    }
}
