<?php

namespace App\Http\Controllers\Dashboard;

use App\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee,company,provider');
    }


    public function index(Request $request)
    {
        $this->authorize('view_users');
        if ($request->ajax()){
            $companies = Company::get();
            return response()->json($companies);
        }
        return view('dashboard.companies.index');
    }

    public function create()
    {
        $this->authorize('create_users');
        return view('dashboard.companies.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create_users');
        Company::create($this->validator($request));
        return redirect(route('dashboard.companies.index'));
    }

    public function edit(Company $company)
    {
        $this->authorize('update_users');
        return view('dashboard.companies.edit', compact('company'));
    }

    public function update(Company $company, Request $request)
    {
        $this->authorize('update_users');
        $company->update($this->validator($request, $company->id));
        return redirect(route('dashboard.companies.index'));
    }

    public function show(Company $company)
    {
        return view('dashboard.companies.show', compact('company'));
    }

    public function destroy(Company $company, Request $request)
    {
        $this->authorize('delete_users');
        if($request->ajax()){
            $company->delete();
            return response()->json([
                'status' => true,
                'message' => 'Item Deleted Successfully'
            ]);
        }
        return redirect(route('dashboard.companies.index'));
    }

    public function validator(Request $request, $id = null)
    {

        $rules = Company::$rules;
        if($id){
            $rules['email'] = ($rules['email'] . ',email,' . $id);
            $rules['domain'] = ($rules['domain'] . ',domain,' . $id);
        }
        return $request->validate($rules);
    }

}
