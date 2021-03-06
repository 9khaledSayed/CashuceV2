<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::Dashboard;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:company')->except('logout');
        $this->middleware('guest:employee')->except('logout');
        $this->middleware('guest:provider')->except('logout');
    }

    protected function attemptLogin(Request $request)
    {
        $companyAttempt = Auth::guard('company')->attempt(
            $this->credentials($request), $request->has('remember')
        );
        if($companyAttempt){
            return $companyAttempt;
        }
        $providerAttempt =  Auth::guard('provider')->attempt(
            $this->credentials($request), $request->has('remember')
        );

        if($providerAttempt){
            return $providerAttempt;
        }

        $employeeAttempt =  Auth::guard('employee')->attempt(
            $this->credentials($request), $request->has('remember')
        );

        if($employeeAttempt){
            return $providerAttempt;
        }

        return $companyAttempt;
    }

//    public function loginCompanyForm()
//    {
//        return view('auth.login', ['url' => 'company']);
//    }
//
//    public function loginEmployeeForm()
//    {
//        return view('auth.login', ['url' => 'employee']);
//    }
//
//    public function loginProviderForm()
//    {
//        return view('auth.login', ['url' => 'provider']);
//    }
//
//    public function loginCompany(Request $request )
//    {
////        dd($request->getBaseUrl());
//        $this->validate($request, [
//            'email'   => 'required|email',
//            'password' => 'required|min:6'
//        ]);
//
//        if (Auth::guard('company')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
//
//            return redirect()->intended('/dashboard');
//        }
//        return back()->withInput($request->only('email', 'remember'));
//
//    }
//    public function loginEmployee(Request $request )
//    {
//        $this->validate($request, [
//            'email'   => 'required|email',
//            'password' => 'required|min:6'
//        ]);
//
//        if (Auth::guard('employee')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
//
//            return redirect()->intended('/dashboard');
//        }
//        return back()->withInput($request->only('email', 'remember'));
//    }
//    public function loginProvider(Request $request )
//    {
//        $this->validate($request, [
//            'email'   => 'required|email',
//            'password' => 'required|min:6'
//        ]);
//
//        if (Auth::guard('provider')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
//
//            return redirect()->intended('/dashboard');
//        }
//        return back()->withInput($request->only('email', 'remember'));
//    }



}
