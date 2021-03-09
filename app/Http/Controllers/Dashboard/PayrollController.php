<?php

namespace App\Http\Controllers\Dashboard;

use App\Company;
use App\Department;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Nationality;
use App\Payroll;
use App\Provider;
use App\Rules\UniqueMonth;
use App\Salary;
use App\Section;
use Box\Spout\Writer\Style\StyleBuilder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

class PayrollController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee,company,provider');
    }

    public function index()
    {
        $this->authorize('view_payrolls');
        $providers = Provider::get();
        return view('dashboard.payrolls.index', [
            'payrolls' => Payroll::orderBy('year_month', 'asc')->paginate(12),
            'providers' => $providers
        ]);
    }

    public function pending(Request $request)
    {
        $this->authorize('view_payrolls');
        $pending_reports = Payroll::where('status', 0)->get();
        if($request->ajax()){
            return response()->json($pending_reports);
        }
        return view('dashboard.payrolls.pending');
    }


    public function create()
    {
        $this->authorize('create_payrolls');
        $providers = Provider::get();
        return view('dashboard.payrolls.create', compact('providers'));
    }


    public function store(Request $request)
    {
        $this->authorize('create_payrolls');
        $request->validate(['year_month' => ['required' ,new UniqueMonth($request->provider_id)]]);
        $payrollDay = setting('payroll_day') ?? 30;
        $employees = isset($payroll->provider_id) ? Employee::where('provider_id', $payroll->provider_id)->get() : Employee::get();

        $total_deductions = $employees->map(function($employee){
           return $employee->deductions() + $employee->gosiDeduction();
        })->sum();
        $payroll = Payroll::create([
            'provider_id'        => $request->provider_id,
            'year_month'         => $request->year_month,
            'date'               => $request->year_month . '-'  . Carbon::now()->format('d'),
            'issue_date'         => Carbon::now()->toDateTimeString(),
            'employees_no'       => $employees->count(),
            'total_deductions'   => $total_deductions,
            'include_attendance' => $request->has('include_attendance'),
        ]);
        $payroll->update([
            'total_net_salary' => $payroll->salaries->pluck('net_salary')->sum(),
        ]);

        return redirect(route('dashboard.payrolls.index'));
    }


    public function show(Payroll $payroll, Request $request)
    {
        $this->authorize('show_payrolls');
        if($request->ajax()){
            $salaries = Salary::where('payroll_id', $payroll->id)->get()->map(function ($salary){
                $employee = $salary->employee;
                $deductions = $employee->deductions();
                $gosiDeduction = $employee->gosiDeduction();
                $officialWorkingHours = 240;
                    return [
                        'id' => $salary->id,
                        'job_number' => $employee->job_number,
                        'employee_name' => $employee->name(),
                        'supervisor' => $employee->supervisor_name,
                        'department' => $employee->department_name,
                        'section' => $employee->section_name,
                        'provider' => $employee->provider_name,
                        'nationality' => $employee->nationality_name,
                        'employee_id' => $employee->id,
                        'salary' => $employee->salary,
                        'officialWorkingHours' => $officialWorkingHours,
                        'hourly_wage' => number_format($employee->totalPackage() / $officialWorkingHours, 2),
                        'hra' => $employee->hra(),
                        'transfer' => $employee->transfer(),
                        'other_allowances' => $employee->otherAllowances(),
                        'total_allowances' => $employee->totalAdditionAllowances(),
                        'total_package' => $employee->totalPackage(),
                        'violations_deduction' => $deductions,
                        'gosi_deduction' => $gosiDeduction,
                        'total_deduction' => $gosiDeduction + $deductions,
                        'net_pay' => $salary->net_salary,
                        'work_days' => $salary->work_days,
                    ];
                });
            return response()->json($salaries);
        }
        return view('dashboard.payrolls.show', [
            'payroll' =>  $payroll,
            'supervisors' =>  Company::supervisors(),
            'nationalities' => Nationality::get(),
            'providers' => Provider::get(),
            'departments' => Department::get(),
            'sections' => Section::get(),
        ]);
    }


    public function reissue(Request $request, Payroll $payroll)
    {
        $this->authorize('proceed_payrolls');
        $payroll->salaries()->delete();
        $employees = isset($payroll->provider_id) ? Employee::where('provider_id', $payroll->provider_id)->get() : Employee::get();
        $payrollDay = setting('payroll_day') ?? 30;
        $totalDeductions = $employees->map(function($employee){
            return $employee->deductions() + $employee->gosiDeduction();
        })->sum();
        $payroll->update([
            'date'               => $payroll->year_month->format('Y-m') . '-' . Carbon::now()->format('d'),
            'issue_date'         => Carbon::now()->toDateTimeString(),
            'employees_no'       => $employees->count(),
            'total_deductions'   => $totalDeductions,
            'include_attendance' => $request->has('include_attendance'),
        ]);

        foreach ($employees as $employee) {
            $settingWorkDays = Company::settingWorkdays() ?? 30;
            $workDays = $payroll->include_attendance? $employee->workDays($payroll->date->month) : $settingWorkDays;

            $deductions = $employee->deductions() + $employee->gosiDeduction();
            $netPay = $workDays * ($employee->totalPackage()/30);
            $netPay = $netPay - $deductions;

            Salary::create([
                'employee_id' => $employee->id,
                'payroll_id' => $payroll->id,
                'salary' => $employee->salary,
                'deductions' => $deductions,
                'net_salary' => $netPay,
                'work_days' => $workDays,
            ]);

        }
        $payroll->update([
            'total_net_salary' => $payroll->salaries->pluck('net_salary')->sum(),
        ]);

        return redirect()->back()->with('reissue', 1);
    }

    public function reject(Payroll $payroll)
    {
        $this->authorize('proceed_payrolls');
        $payroll->update(['status' => 2]);
        return redirect()->back()->with('status', 'reject');
    }

    public function approve(Payroll $payroll)
    {
        $this->authorize('proceed_payrolls');
        $payroll->update(['status' => 1]);
        return redirect()->back()->with('status', 'approve');
    }


    public function destroy(Payroll $payroll)
    {
        //
    }

    public function excel(Payroll $payroll)
    {
        $fileName = 'payroll.xlsx';

        $salaries = Salary::where('payroll_id', $payroll->id)->get()->map(function ($salary){
            $employee = $salary->employee;
            $officialWorkingHours = 240;
            $deductions = $employee->deductions();
            $gosiDeduction = $employee->gosiDeduction();

            return [
                'Job Number' => $employee->job_number,
                'Employee' => $employee->name_en,
                'Nationality' => $employee->nationality_name,
                'Salary' => $employee->salary,
                'Official Working Hours' => $officialWorkingHours,
                'Hourly Wage' => number_format($employee->salary / $officialWorkingHours, 2),
                'Housing' => $employee->hra(),
                'Transfer' => $employee->transfer(),
                'Other Allowances' => $employee->otherAllowances(),
                'Total Allowances' => $employee->totalAdditionAllowances(),
                'Total Package' => $employee->totalPackage(),
                'Violations Deduction' => $deductions,
                'GOSI Deduction' => $gosiDeduction,
                'Total Deduction' => $gosiDeduction + $deductions,
                'Net Pay' => $salary->net_salary,
                'Work Days' => $salary->work_days,
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
}
