<?php

namespace App\Http\Controllers\Dashboard;

use anlutro\LaravelSettings\Facade as Setting;
use App\Company;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Rules\EqualToCurrentPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee,company,provider');
    }

    public function accountInfo()
    {
        $user = auth()->user();
        return view('dashboard.myProfile.account_info', compact('user'));
    }

    public function updateAccountInfo(Request $request)
    {
        $user = auth()->user();
        $user->update($request->validate([
            'fname_ar' => 'required|string|max:191',
            'lname_ar' => 'required|string|max:191',
            'fname_en' => 'required|string|max:191',
            'lname_en' => 'required|string|max:191',
            'email' => 'sometimes|required|email|unique:employees,email,' . $user->id,
        ]));

        return redirect(route('dashboard.myProfile.account_info'))->with('success', 'true');
    }

    public function changePasswordForm()
    {
        $user = auth()->user();
        return view('dashboard.myProfile.change_password', compact('user'));
    }
    public function changePassword(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'current_password' => ['required', 'string', new EqualToCurrentPassword()],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);
        $user->update(['password' => $request->password ]);
        return redirect(route('dashboard.myProfile.change_password'))->with('success', 'true');
    }

    public function companyProfile(Request $request)
    {
        $company = auth()->user();
        $employees = $company->employees;
        if ($request->post()){
            $rules = Company::$rules;
            $rules['email'] = ($rules['email'] . ',email,' . $company->id);
            unset($rules['password']);
            $company->update($request->validate($rules));
            if(isset($request->logo)){
                $fileName = $request->file('logo')->getClientOriginalName();
                $request->file('logo')->storeAs('public/companies/logos/', $fileName);

                $company->logo = $fileName;
                $company->save();
            }
            return redirect(route('dashboard.profile.company_profile'))->with('success', 'true');
        }
        return view('dashboard.myProfile.company_profile', compact('company', 'employees'));
    }


    public function uploadProfilePicture(Request $request)
    {
        $request->validate([
            'profile_avatar' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        $fileExtension = '.' . $request->file('profile_avatar')->getClientOriginalExtension();
        $fileName = date('mdYHis') . uniqid() . $fileExtension;

        $request->file('profile_avatar')->storeAs('public/employees/avatars/', $fileName);
        auth()->user()->update([
            'photo' => $fileName
        ]);

        return response()->json([
            'status' => true,
        ]);
    }
}
