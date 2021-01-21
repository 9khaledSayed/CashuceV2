@extends('layouts.app')

@section('content')
    <!--begin::Head-->
    <div class="kt-login__head d-flex justify-content-between">
        <div>
        <span class="kt-login__signup-label ">{{__('Don\'t have an account yet?')}}</span>&nbsp;&nbsp;
        <a href="{{ route("register") }}" class="kt-link kt-login__signup-link">{{__('Sign Up!')}}</a>
    </div>
    <div>
{{--    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)--}}
{{--        <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">--}}
{{--            {{ $properties['native'] }} <i class="fa fa-globe" aria-hidden="true"></i>--}}
{{--        </a>--}}
{{--    @endforeach--}}
    </div>

</div>

<!--end::Head-->

<!--begin::Body-->
<div class="kt-login__body">

    <!--begin::Signin-->
    <div class="kt-login__form">
        <div class="kt-login__title">
            <h3>{{ __('Login') }} {{isset($url)? ucwords($url) : ''}}</h3>
        </div>
        @include('layouts.dashboard.parts.errorSection')
        <!--begin::Form-->
        @isset($url)
            <form method="POST" action="{{ route("login.$url") }}" aria-label="{{ __('Login') }}">
        @else
            <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
        @endisset

        @csrf
            <div class="form-group">
                <input class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}"
                       type="email"
                       placeholder="{{__('Email')}}"
                       name="email"
                       required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <input class="form-control @error('password') is-invalid @enderror"
                       type="password"
                       placeholder="{{__('Password')}}"
                       name="password"
                       required autocomplete="current-password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <!--begin::Action-->
            <div class="kt-login__actions">
                <a href="{{ route('password.request') }}" class="kt-link kt-login__link-forgot">
                    {{ __('Forgot Your Password?') }}
                </a>
                <button id="" class="btn btn-primary btn-elevate kt-login__btn-primary">{{__('Sign In')}}</button>
            </div>
            <!--end::Action-->
        </form>

        <!--end::Form-->

    </div>

    <!--end::Signin-->
</div>

<!--end::Body-->
@endsection
