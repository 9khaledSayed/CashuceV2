@extends('layouts.app')

@section('content')
<div class="kt-login__body">

    <!--begin::Signin-->
    <div class="kt-login__form">
        <div class="kt-login__title">
            <h3>{{ __('Provider Reset Password') }}</h3>
        </div>

        <!--begin::Form-->
        <form method="POST" action='{{ route('provider.password.update') }}' aria-label="{{ __('Register') }}">

            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group">
                <input id="email"
                       type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       name="email"
                       value="{{ $email ?? old('email') }}"
                       placeholder="{{__('Email')}}"
                       required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <input id="password"
                       type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="{{__('Password')}}"
                       name="password"
                       required autocomplete="new-password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <input id="password-confirm"
                       type="password"
                       class="form-control"
                       placeholder="{{__('Confirm Password')}}"
                       name="password_confirmation"
                       required autocomplete="new-password">
            </div>
            <div class="kt-login__actions">
                <button  class="btn btn-primary btn-elevate kt-login__btn-primary mx-auto">{{__('Reset Password')}}</button>
            </div>
            <!--end::Action-->
        </form>

        <!--end::Form-->
    </div>

    <!--end::Signin-->
</div>
@endsection
