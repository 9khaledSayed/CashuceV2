<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee,company,provider');
    }

    public function index(Request $request)
    {
        $this->authorize('view_users');
        if ($request->ajax()){
            $users = User::with('roles')->get();
            return response()->json($users);
        }
        return view('dashboard.users.index');
    }

    public function create()
    {

        $this->authorize('create_users');
        $roles = Role::whereIn('id', [1,2])->get();
        return view('dashboard.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $this->authorize('create_users');
        $rules = User::$rules;
        $request->password = Hash::make($request->password);
        $user = User::create($request->validate($rules));
//        $role = Role::find($request->validate(['role_id' => 'required|numeric|exists:roles,id']));
        $user->assignRole('User');
        $user->generateDefaultRoles();
//        $user->assignRole($role);
        return redirect(route('dashboard.users.index'));
    }

    public function edit(User $user)
    {
        $this->authorize('update_users');
        $roles = Role::get();
        return view('dashboard.users.edit', compact('user', 'roles'));
    }

    public function update(User $user, Request $request)
    {
        $this->authorize('update_users');
        $rules = User::$rules;
        $rules['email'] = ($rules['email'] . ',email,' . $user->id);
        $user->update($request->validate($rules));
//        $role = Role::find($request->validate(['role_id' => 'required|numeric|exists:roles,id']));
//        $user->roles()->detach($user->roles);
//        $user->assignRole($role);
        return redirect(route('dashboard.users.index'));
    }

    public function destroy(User $user, Request $request)
    {
        $this->authorize('delete_users');
        if($request->ajax()){
            $user->delete();
            return response()->json([
                'status' => true,
                'message' => 'Item Deleted Successfully'
            ]);
        }
        return redirect(route('dashboard.users.index'));
    }
}
