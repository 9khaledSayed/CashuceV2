<?php

namespace App\Http\Controllers\API\Auth;

use App\Company;
use App\Employee;
use App\Provider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiAuthController extends Controller
{
    public function register (Request $request) {
        $validator = Validator::make($request->all(), [
            'name_en' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:companies'],
            'domain' => ['required', 'regex:/^[a-z]+$/', 'max:20', 'unique:companies'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $request['password']=Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $user = Company::create($request->toArray());
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['token' => $token];
        return response($response, 200);
    }

    public function login (Request $request) {

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $company = Company::where('email', $request->email)->first();
        $employee = Employee::where('email', $request->email)->first();
        $provider = Provider::where('email', $request->email)->first();
        if ($company) {

            if (Hash::check($request->password, $company->password)) {
                $token = $company->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['token' => $token, 'user' => $company];
                return response($response, 200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        }elseif($provider){
            if (Hash::check($request->password, $provider->password)) {
                $token = $provider->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['token' => $token, 'user' => $provider];
                return response($response, 200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        }elseif($employee){
            if (Hash::check($request->password, $employee->password)) {
                $token = $employee->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['token' => $token, 'user' => $employee];
                return response($response, 200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" =>'User does not exist'];
            return response($response, 422);
        }
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
