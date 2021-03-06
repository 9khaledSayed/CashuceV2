@extends('layouts.app')

@section('content')



<div class="kt-login__head d-flex justify-content-between">
    <div class="kt-login__head">
        <span class="kt-login__signup-label">{{__('Already have an account ?')}}</span>&nbsp;&nbsp;
        <a href="{{route('login')}}" class="kt-link kt-login__signup-link">{{__('Log in!')}}</a>
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
            <h3> {{ __('Hello, Welcome!') }}</h3>
            <h6> {{ __('Create new account') }}</h6>
        </div>
        <!--begin::Form-->
            <form method="POST" action='{{ route("register") }}' aria-label="{{ __('Register') }}">

                @csrf
                <div class="form-group">
                    <label>{{__('Organization Name')}}</label>
                    <div class="kt-input-icon kt-input-icon--left">
                        <input name="name_en"
                               class="form-control @error('name_en') is-invalid @enderror"
                               value="{{old('name_en')}}"
                               placeholder="{{__('Name In English')}}"
                               type="text">
                        <span class="kt-input-icon__icon kt-input-icon__icon--left">
                            <span><i class="fa fa-building"></i></span>
                        </span>
                        @error('name_en')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group ">
                    <label>{{__('Working E-mail')}}</label>
                    <div class="kt-input-icon kt-input-icon--left">
                        <input id="email"
                               type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               name="email"
                               value="{{ old('email') }}"
                               placeholder="{{__('Email')}}"
                               required
                               autocomplete="email">
                        <span class="kt-input-icon__icon kt-input-icon__icon--left">
                            <span><i class="la la-envelope"></i></span>
                        </span>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group ">
                    <label>{{__('Domain')}}</label>
                    <div class="input-group">
                        <input id="domain"
                               type="text"
                               class="form-control @error('domain') is-invalid @enderror"
                               name="domain"
                               value="{{ old('domain') }}"
                               placeholder="{{__('Domain')}}"
                               required>
                        <div class="input-group-append">
                            <span class="input-group-text border11" id="basic-addon2">.oprnize.com</span>
                        </div>
                        @error('domain')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group ">
                    <label>{{__('Password')}}</label>
                    <div class="kt-input-icon kt-input-icon--left">
                    <input id="password"
                           type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="{{__('Password')}}"
                           name="password"
                           required autocomplete="new-password">
                        <span class="kt-input-icon__icon kt-input-icon__icon--left">
                            <span><i class="la la-lock"></i></span>
                        </span>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group ">
                    <label>{{__('Confirm Password')}}</label>
                    <div class="kt-input-icon kt-input-icon--left">
                        <input id="password-confirm"
                               type="password"
                               class="form-control"
                               placeholder="{{__('Confirm Password')}}"
                               name="password_confirmation"
                               required autocomplete="new-password">
                        <span class="kt-input-icon__icon kt-input-icon__icon--left">
                            <span><i class="la la-lock"></i></span>
                        </span>
                    </div>
                </div>
                <div class="kt-login__actions">
                    <button  class="btn btn-primary btn-elevate btn-wide" style=" width: 100%">{{__('Sign Up')}}</button>
                </div>
            <!--end::Action-->
            </form>

            <!--end::Form-->
    </div>

    <!--end::Signin-->
</div>

<!--end::Body-->
@endsection
