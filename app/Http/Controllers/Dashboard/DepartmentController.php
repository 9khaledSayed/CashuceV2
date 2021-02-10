<?php

namespace App\Http\Controllers\Dashboard;

use App\Department;
use App\Employee;
use App\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepartmentController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()){
            $departments = Department::get();
            return response()->json($departments);
        }
        return view('dashboard.departments.index');
    }

    public function create()
    {
        return view('dashboard.departments.create', [
            'supervisors' => Employee::get(),
        ]);
    }


    public function store(Request $request)
    {
        Department::create($this->validateDepartment());

        return redirect('/dashboard/departments');
    }

    public function show(Department $department)
    {
        return view('dashboard.departments.show', [
            'department' => $department,
            'supervisors' => Employee::get(),
        ]);
    }


    public function edit(Department $department)
    {
        return view('dashboard.departments.edit', [
            'department' => $department,
            'supervisors' => Employee::get(),
        ]);
    }

    public function update(Department $department)
    {
        $department->update($this->validateDepartment());

        //dd($department);

        return redirect(route('dashboard.departments.index'));
    }

    public function destroy(Request $request,Department $department)
    {
        if($request->ajax()){
            $department->delete();
            return response()->json([
                'status' => true,
                'message' => 'Item Deleted Successfully'
            ]);
        }
        return redirect(route('dashboard.departments.index'));
    }

    public function validateDepartment()
    {
        return request()->validate([
            'name_ar'    => 'required',
            'name_en'   => 'required',
            'supervisor_id'   => 'nullable|numeric|exists:employees,id',
        ]);
    }

    public function getSectionList(Department $department, Request $request)
    {
        $sections = $department->sections->map(function($section){
            return [
                "id" => $section->id,
                "name" => $section->name(),
            ];
        });
        return response()->json($sections);
    }
}
