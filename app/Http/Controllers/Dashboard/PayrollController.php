<?php

namespace App\Http\Controllers\Dashboard;

use App\Company;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Payroll;
use App\Provider;
use App\Rules\UniqueMonth;
use App\Salary;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
            'date'               => $request->year_month . '-' . $payrollDay,
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
                $officialWorkingHours = 208;
                    return [
                        'job_number' => $employee->job_number,
                        'employee_name' => $employee->name(),
                        'employee_id' => $employee->id,
                        'nationality' => $employee->nationality(),
                        'salary' => $employee->salary,
                        'officialWorkingHours' => $officialWorkingHours,
                        'hourly_wage' => number_format($employee->salary / $officialWorkingHours, 2),
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
        return view('dashboard.payrolls.show', compact('payroll'));
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
            'date'               => $payroll->year_month . '-' . $payrollDay,
            'issue_date'         => Carbon::now()->toDateTimeString(),
            'employees_no'       => $employees->count(),
            'total_deductions'   => $totalDeductions,
            'include_attendance' => $request->has('include_attendance'),
        ]);
        foreach ($employees as $employee) {
            $payrollDay = setting('payroll_day') ?? 30;
            $workDays = $payroll->include_attendance? $employee->workDays($payroll->date->month) : 30;
            $workDays = ($workDays > $payrollDay) ? $payrollDay : $workDays;  // 26 - 25
            $daysOff = $employee->daysOff();
            $totalPackage = $workDays * ($employee->totalPackage()/(30 - $daysOff));
            $deductions = $employee->deductions() + $employee->gosiDeduction();
            $netPay = $totalPackage  - $deductions;

            Salary::create([
                'employee_id' => $employee->id,
                'payroll_id' => $payroll->id,
                'salary' => $totalPackage,
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
}
