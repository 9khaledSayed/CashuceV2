<?php

namespace App\Http\Controllers\Auth;

use App\Company;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }


    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'name_en' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:companies'],
            'domain' => ['required', 'regex:/^[a-z]+$/', 'max:20', 'unique:companies'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Employee
     */
    protected function create(array $data)
    {
        return  Company::create([
            'name_ar'     => $data['name_en'],
            'name_en'     => $data['name_en'],
            'email'    => $data['email'],
            'domain'    => $data['domain'],
            'password' => $data['password']
        ]);

//         redirect($this->redirectTo);
    }

    protected function registered(Request $request, $company)
    {
        Auth::guard('company')->loginUsingId($company->id);
        return redirect($this->redirectTo);
    }


}
