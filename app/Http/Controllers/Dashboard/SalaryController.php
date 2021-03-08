<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Salary;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee,company,provider');
    }

    public function mySalaries(Request $request)
    {
        $this->authorize('view_my_salaries');
        $this->authorize('must_be_employee');
        if($request->ajax()){
            $my_salaries = Salary::where('employee_id', auth()->user()->getAuthIdentifier())->get()->map(function ($salary){
                return [
                    'id' => $salary->id,
                    'date' => $salary->payroll->date->format('Y-m'),
                    'total_package' => $salary->employee->totalPackage(),
                    'gosi_deduction' => $salary->employee->gosiDeduction(),
                    'violations_deduction' => $salary->employee->deductions(),
                    'net_pay' => $salary->net_salary,
                    'work_days' => $salary->work_days,
                ];
            });;
            return response()->json($my_salaries);
        }
        return view('dashboard.salaries.my_salaries');
    }

    public function show(Salary $salary, Request $request)
    {
        return  view('dashboard.salaries.show', compact('salary'));
    }

}
