<?php

namespace App\Http\Controllers\Dashboard;

use App\Employee;
use App\EndService;
use App\Decision;
use App\Http\Controllers\Controller;
use App\Scopes\ServiceStatusScope;
use Illuminate\Http\Request;

class EndServiceController extends Controller
{
    public $reasons=[
        0 => 'The term of the contract expires, or the parties agree to terminate the contract', // 0 ==> case1
        1 => 'worker resigned',// 1 ==> case2
        2 => 'The contract was terminated by the employer of one of the cases contained in Article (80)', // 2 ==> case3
//        3 => 'Termination of the contract from the employer',// 3 ==> case4
//        4 => 'Leaving work is the result of a force majeure',// 4 ==> case1
//        5 => 'Leaving the worker in a case in article 81',// 5 ==> case1
//        6 => 'Termination of employment within six months of the marriage contract Or within three months of the situation',// 6 ==> case1
        7 => 'According to article (81)',// 7 ==> case3
        8 => 'Request to terminate the contract based on the article (77)'// 8 ==> case3
    ];

    public function create()
    {
        return view('dashboard.decisions.end_services.create', [
            'reasons' => $this->reasons,
            'employees' => Employee::get()
        ]);
    }


    public function store(Request $request)
    {
        $this->validator($request);
        $result = $this->calculateEndServiceReward($request->employee_id, $request->reason, $request->temination_date);
        $endService = EndService::create([
            'termination_date' => $request->termination_date,
            'end_service_reward' => $result['service_reward'],
            'benefit' => $result['benefit'],
            'reason' => $request->reason,
        ]);

        Decision::create([
            'company_id' => auth()->user()->id,
            'employee_id' => $request->employee_id,
            'decisionable_id' => $endService->id,
            'decisionable_type' => 'App\EndService',
            'notes' => $request->notes,
        ]);

        Employee::find($request->employee_id)->update([
            'contract_end_date' => $request->termination_date,
            'service_status' => 0
        ]);

        return redirect(route('dashboard.decisions.index'));
    }


    public function show(EndService $endService)
    {
        $decision = $endService->decision;
        $results = $this->calculateEndServiceReward($decision->employee_id, $endService->reason, $endService->temination_date);
        return view('dashboard.decisions.end_services.show', [
            'results' => $results,
        ]);
    }

    public function endServiceReward(Request $request){
        $this->validator($request);
        $results = $this->calculateEndServiceReward($request->employee_id, $request->reason, $request->temination_date);
        return response()->json($results);
    }

    public function calculateEndServiceReward($employeeId, $reason, $terminationDate)
    {
        $employee = Employee::withoutGlobalScope(ServiceStatusScope::class)->find($employeeId);
        $duration = $employee->duration($terminationDate);
        $salary = $employee->salary;
        $leave_balance = $employee->leave_balance;
        $benefit = $leave_balance * $employee->dailySalary();
//        $debets = $employee->deductions->where('payroll_status', 1)->where('status',1)->pluck('amount')->sum();
        $debets = 0;
        $end_of_service = 0;

        if(in_array($reason, [0,4,5,6,7,8])){
            $end_of_service = $this->case1($duration, $salary);
        }elseif ($reason == 1){
            $end_of_service = $this->case2($duration, $salary);
        }
        elseif (in_array($reason, [2])){
            $end_of_service = 0;
        }
        elseif ($reason == 3){
            $end_of_service = $this->case4($duration, $salary, $employee, $terminationDate);
        }

        $total_amount = $end_of_service + $benefit - $debets;

        return [
            "emp_num" => $employee->job_number,
            "emp_name" => $employee->name(),
            "emp_joined_date" => $employee->contract_start_date->format("Y-m-d"),
            "years" => $duration['years'],
            "months" => $duration['months'],
            "days" => $duration['days'],
            "service_reward" => $end_of_service,
            "leave_balance" => $leave_balance,
            "benefit" => $benefit,
//            "debets" => $debets,
            "total" => $total_amount,
        ];
    }

    public function case1($duration, $salary)
    {
        $end_of_service = 0;
        if($duration['years'] > 5 ){
            $yearsAfter5 = $duration['years'] - 5;
            $end_of_service += ($salary / 2) * 5;   // نصف الراتب في حالة الخمس سنوات
            $end_of_service += ($salary) * $yearsAfter5; //  المرتب كامل في حالة اكثر من خمس سنوات
        }else{
            $salary/=2;
            $end_of_service = $salary * $duration['years'];
        }
        $monthsReward = ($salary / 12) * $duration['months'];
        $daysReward = ($salary / (12 * 30)) * $duration['days'];
        $end_of_service += ($monthsReward + $daysReward);
        return $end_of_service;
    }

    public function case2($duration, $salary)
    {
        $end_of_service = 0;
        if($duration['years'] < 2){ // لا يستحق مكافاة
            return $end_of_service; //0
        }
        $end_of_service = $this->case1($duration, $salary);
        if($duration['years'] >= 2 &&  $duration['years'] <=5){ //  يستحق ثلث المكافاة
            $end_of_service = $end_of_service/3;
        }elseif($duration['years'] >= 6 &&  $duration['years'] <10){//  يستحق ثلثين المكافاة
            $end_of_service = ($end_of_service/3) * 2;
        }   // المكافاة كاملة من 10 سنوات الي اكثر

        return $end_of_service;
    }


    public function case4($duration, $salary, Employee $employee, $termination_date)
    {
        $end_of_service = 0;
//        if($employee->contract_type == 1){
//            $end_of_service = $this->case1($duration, $salary);
//            $contract_end_date = $employee->start_date->addMonth($employee->contract_period);
//            $months_due = $contract_end_date->diffInMonths($termination_date) * $salary;
//            $end_of_service += $months_due;
//        }else {
//            $end_of_service = $this->case1($duration, $salary);
//        }
        return $end_of_service;
    }

    public function validator(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|numeric',
            'termination_date' => 'required|date',
            'reason' => 'required|numeric'
        ]);
    }

}
