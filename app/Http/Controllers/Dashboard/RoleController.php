<?php

namespace App\Http\Controllers\Dashboard;

use App\Ability;
use App\Company;
use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    protected $adminCategories = [
        'roles',
        'users',
        'violations',
        'employees',
        'employees_violations',
        'reports',
        'conversations',
        'payrolls',
        'requests',
        'employees_services',
        'attendances',
        'settings'
    ];
    protected $companyCategories = [
        'roles',
        'employees',
        'employees_violations',
        'reports',
        'conversations',
        'payrolls',
        'requests',
        'employees_services',
        'attendances',
        'settings',
    ];

    public function __construct()
    {
        $this->middleware('auth:employee,company,provider');
    }
    public function index(Request $request)
    {
        $this->authorize('view_roles');
        if($request->ajax()){
            $roles = Role::get();
            return response()->json($roles);
        }
        return view('dashboard.roles.index');
    }
    public function create()
    {
        $this->authorize('create_roles');
        $userRole = auth()->user()->role->label;
//        $abilities = Ability::distinct('category')->get(['name', 'category', 'label']);
        $companyRole = Company::find(Company::companyID())->role;
        if($companyRole->label == 'Super Admin'){
            $abilities = Ability::distinct('category')->get()->filter(function($ability){
                return $ability->for == 'public' || $ability->for == 'shared';
            });
        }else{
            $companyRole = Company::find(Company::companyID())->role;
            $abilities = Ability::distinct('category')->get()->filter(function($ability) use ($companyRole){
                return $ability->for == $companyRole->for || $ability->for == 'shared';
            });
        }
        return view('dashboard.roles.create' , [
            'abilities' => $abilities,
            'categories' => $userRole == "Super Admin" ? $this->adminCategories : $this->companyCategories
        ]);
    }
    public function store(Request $request)
    {
        $this->authorize('create_roles');
        $role = Role::create($this->validate($request, [
            'name_arabic' => 'required|string|unique:roles',
            'name_english' => 'required|string|unique:roles',
        ]));
        $abilities = Ability::get();
        foreach($abilities as $ability){
            if (request($ability->name) == "on"){
                $role->allowTo($ability);
            }
        }
        return redirect(route('dashboard.roles.index'));
    }
    public function show(Role $role)
    {
        $userRole = auth()->user()->role->label;

        $companyRole = Company::find(Company::companyID())->role;
        if($companyRole->label == 'Super Admin'){
            $abilities = Ability::distinct('category')->get()->filter(function($ability) use ($role){
                return $ability->for == $role->for || $ability->for == 'shared';
            });
        }else{
            $companyRole = Company::find(Company::companyID())->role;
            $abilities = Ability::distinct('category')->get()->filter(function($ability) use ($companyRole){
                return $ability->for == $companyRole->for || $ability->for == 'shared';
            });
        }

        return view('dashboard.roles.show', [
            'role' => $role,
            'abilities' => $abilities,
            'categories' => $userRole == "Super Admin" ? $this->adminCategories : $this->companyCategories,
            'role_abilities' =>$role->abilities
        ]);
    }
    public function edit(Role $role)
    {
        $companyRole = Company::find(Company::companyID())->role;
        if($companyRole->label == 'Super Admin'){
            $abilities = Ability::distinct('category')->get()->filter(function($ability) use ($role){
                return $ability->for == $role->for || $ability->for == 'shared';
            });
        }else{
            $companyRole = Company::find(Company::companyID())->role;
            $abilities = Ability::distinct('category')->get()->filter(function($ability) use ($companyRole){
                return $ability->for == $companyRole->for || $ability->for == 'shared';
            });
        }


        $this->authorize('update_roles');
        $userRole = auth()->user()->role->label;
        return view('dashboard.roles.edit', [
            'abilities' => $abilities,
            'categories' => $userRole == "Super Admin" ? $this->adminCategories : $this->companyCategories,
            'role_abilities' => $role->abilities,
            'role'  => $role
        ]);
    }
    public function update(Request $request, Role $role)
    {
        $this->authorize('update_roles');
        if($role->name_arabic != $request->name_arabic){
            $role->update($this->validate($request, [
                'name_arabic' => 'required|string|unique:roles',
                'name_english' => 'required|string|unique:roles',
            ]));
        }
        $abilities = Ability::get();
        $role->abilities()->detach();
        foreach($abilities as $ability){
            if (request($ability->name) == "on"){
                $role->allowTo($ability);
            }
        }
        return redirect(route('dashboard.roles.index'));
    }

    public function destroy( Request $request , $id )
    {
        $this->authorize('delete_roles');
        $role = Role::find($id);
        if($request->ajax() && $role->type != 1){
            $role->delete();
            return response()->json([
                'status' => true,
                'message' => 'Item Deleted Successfully'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Can\'t Delete System Role'
            ]);
        }

    }
}
