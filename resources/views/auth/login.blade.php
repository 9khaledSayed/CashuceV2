@extends('layouts.app')

@section('content')
    <!--begin::Head-->
    <div class="kt-login__head d-flex justify-content-between">
        <div>
            <span class="kt-login__signup-label ">{{__('Don\'t have an account yet?')}}</span>&nbsp;&nbsp;
            <a href="{{ route("register") }}" class="kt-link kt-login__signup-link">{{__('Sign Up!')}}</a>
        </div>
         <div>
         @if(app()->isLocale('en'))
            <a href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}">
                {{ __('Arabic') }} <i class="fa fa-globe" aria-hidden="true"></i>
            </a>
         @else
            <a href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}">
                {{ __('English') }} <i class="fa fa-globe" aria-hidden="true"></i>
            </a>
         @endif
        </div>

    </div>



<!--end::Head-->

<!--begin::Body-->
<div class="kt-login__body">

    <!--begin::Signin-->
    <div class="kt-login__form">
        <div class="mb-5">
            <h3> {{ __('Hello, Welcome Back!') }}</h3>
            <h6> {{ __('Sign in if you have an account') }}</h6>
        </div>

        <div class="kt-user-card-v2 mb-3">
            <div class="kt-user-card-v2__pic">
                <img alt="photo" src="{{asset('assets/media/users/default.jpg')}}">
            </div>
            <div class="kt-user-card-v2__details">
                <a class="kt-user-card-v2__name" href="#">Organization</a>
            </div>
        </div>


        <!--begin::Form-->
        <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">

        @csrf
            <div class="form-group">
                <label>{{__('E-mail Address')}}</label>
                <div class="kt-input-icon kt-input-icon--left">
                    <input class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}"
                           type="email"
                           placeholder="{{__('example40@gmail.com')}}"
                           name="email"
                           required autocomplete="email" autofocus>
                    <span class="kt-input-icon__icon kt-input-icon__icon--left">
                        <span><i class="fa fa-envelope"></i></span>
                    </span>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label>{{__('Password')}}</label>
                <div class="kt-input-icon kt-input-icon--left">
                    <input class="form-control @error('password') is-invalid @enderror"
                           type="password"
                           placeholder="{{__('Password')}}"
                           name="password"
                           required autocomplete="current-password">
                    <span class="kt-input-icon__icon kt-input-icon__icon--left">
                        <span><i class="fa fa-lock"></i></span>
                    </span>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                </div>
                @enderror
            </div>
            <!--begin::Action-->
            <div class="kt-login__actions btn-font-primary mt-2">
                <a href="{{ route((isset($url)? $url . '.' : 'company.') . 'password.request') }}" class="kt-link kt-login__link-forgot">
                    {{ __('Forgot Your Password?') }}
                </a>
            </div>
            <div class=" ">
                <button id="" class="btn btn-primary btn-elevate" style="width: 100%">{{__('Login')}}</button>
            </div>
        </form>


        <!--end::Form-->

    </div>
    <!--end::Signin-->

</div>



<!--end::Body-->
@endsection
