@extends('layouts.app')

@section('content')



<div class="kt-login__head d-flex justify-content-between">
    <div class="kt-login__head">
        <span class="kt-login__signup-label">{{__('Already have an account ?')}}</span>&nbsp;&nbsp;
        <a href="{{ route("login.company") }}" class="kt-link kt-login__signup-link">{{__('Log in!')}}</a>
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
        <div class="kt-login__title">
            <h3> {{ __('Register') }}</h3>
        </div>
        <!--begin::Form-->
            <form method="POST" action='{{ route("register") }}' aria-label="{{ __('Register') }}">

                @csrf
                <div class="form-group row">
                    <div class="col-lg-12">
                        <input name="name_ar"
                               class="form-control @error('name_ar') is-invalid @enderror"
                               value="{{old('name_ar')}}"
                               placeholder="{{__('Arabic Name')}}"
                               type="text">
                        @error('name_ar')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <input name="name_en"
                               class="form-control @error('name_en') is-invalid @enderror"
                               value="{{old('name_en')}}"
                               placeholder="{{__('English Name')}}"
                               type="text">
                        @error('name_en')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <input id="email"
                               type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               name="email"
                               value="{{ old('email') }}"
                               placeholder="{{__('Email')}}"
                               required
                               autocomplete="email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
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
                    <div class="col-lg-6">
                        <input id="password-confirm"
                               type="password"
                               class="form-control"
                               placeholder="{{__('Confirm Password')}}"
                               name="password_confirmation"
                               required autocomplete="new-password">
                    </div>
                </div>
                <div class="kt-login__actions">
                    <button  class="btn btn-primary btn-elevate kt-login__btn-primary mx-auto">{{__('Register')}}</button>
                </div>
            <!--end::Action-->
            </form>

            <!--end::Form-->
    </div>

    <!--end::Signin-->
</div>

<!--end::Body-->
@endsection
