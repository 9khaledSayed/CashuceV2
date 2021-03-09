<?php

namespace App\Http\Controllers\Dashboard;

use App\Employee;
use App\EmployeeViolation;
use App\Http\Controllers\Controller;
use App\Rules\NotRepeated;
use App\Violation;
use Illuminate\Http\Request;

class EmployeeViolationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee,company,provider');
    }

    public function index(Request $request)
    {
        $this->authorize('view_employees_violations');
        if ($request->ajax()){
            $employees_violations = EmployeeViolation::with(['employee', 'violation'])->get();
            return response()->json($employees_violations);
        }
        return view('dashboard.employees_violations.index');
    }


    public function create()
    {
        $this->authorize('create_employees_violations');
        $employees = Employee::get();
        $violations = Violation::get();
        return view('dashboard.employees_violations.create', compact('employees', 'violations'));
    }


    public function store(Request $request)
    {
        $this->authorize('create_employees_violations');
        $employeeViolation = new EmployeeViolation($this->validator($request));
        $this->calculateViolation($employeeViolation)->save();
        return redirect(route('dashboard.employees_violations.show', $employeeViolation));
    }


    public function show($id)
    {
        $employeeViolation = EmployeeViolation::find($id);
        $deduction = is_numeric($employeeViolation->deduction)? $employeeViolation->deduction . __(" S.R") : $employeeViolation->deduction;
        return view('dashboard.employees_violations.show', compact('employeeViolation', 'deduction'));
    }


    public function edit($id)
    {
        $this->authorize('update_employees_violations');
        $employeeViolation = EmployeeViolation::find($id);
        $employees = Employee::get();
        $violations = Violation::get();
        return view('dashboard.employees_violations.edit', compact('employees', 'violations', 'employeeViolation'));
    }


    public function update(Request $request, $id)
    {
        $this->authorize('update_employees_violations');
        $employeeViolation = EmployeeViolation::find($id);
        $employeeViolation->update($this->validator($request, $employeeViolation));
        return redirect(route('dashboard.employees_violations.index'));
    }


    public function destroy(Request $request,$id)
    {
        $this->authorize('delete_employees_violations');
        if($request->ajax()){
            EmployeeViolation::find($id)->delete();
            return response()->json([
                'status' => true,
                'message' => 'Item Deleted Successfully'
            ]);
        }
        return redirect(route('dashboard.employees_violations.index'));
    }
    public function calculateDeduction($dailySalary, $panelValue)
    {
        if (@number_format($panelValue) != null)
            return number_format($dailySalary * ($panelValue/100), 2);
        return $panelValue;
    }

    public function calculateViolation(EmployeeViolation $employeeViolation)
    {
        $employee = $employeeViolation->employee;
        $violation = $employeeViolation->violation;
        $repeats = EmployeeViolation::where('employee_id',$employee->id)
                ->where('violation_id', $violation->id)
                ->count() + 1;
        $employeeViolation->repeats = $repeats;
        $panels = Violation::find($violation->id,['panel1','panel2', 'panel3', 'panel4'])->toArray();
        $lastPanelExist = array_key_last(array_filter($panels));
        $dailySalary = $employee->dailySalary();

        if( $repeats < 4 && isset($violation->{'panel' . $repeats})){
            $employeeViolation->deduction = $this->calculateDeduction($dailySalary, $violation->{'panel' . $repeats});
        }else{
            $employeeViolation->deduction = $this->calculateDeduction($dailySalary, $violation->{$lastPanelExist});
        }

        if($violation->addition_to == "minutes_deduc") // minutes late deduction
            $employeeViolation->addition_to = $employeeViolation->minutes_late * ($dailySalary/(8*60));
        else // absence days deductions
            $employeeViolation->addition_to = $employeeViolation->absence_days * $dailySalary;

        return $employeeViolation;
    }

    public function validator(Request $request, EmployeeViolation $employeeViolation = null)
    {
        $rules = EmployeeViolation::$rules;
        array_push($rules['employee_id'], new NotRepeated($request->violation_id, $request->date));
        return $request->validate($rules);
    }
}
