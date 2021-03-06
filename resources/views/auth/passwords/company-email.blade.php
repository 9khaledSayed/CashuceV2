@extends('layouts.app')

@section('content')
<!--end::Head-->
<div class=" d-flex justify-content-between">
    <a href="{{route('login.company')}}">
        <span class="kt-font-primary kt-font-xl"><i class="la la-arrow-left"></i></span>
    </a>
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
<!--begin::Body-->
<div class="kt-login__body">

    <!--begin::Signin-->
    <div class="kt-login__form">
        <div class="mb-5">
            <h3>{{ __('Reset Password') }}</h3>
            <h6 class="text-muted"> {{ __('Enter the email associated with you account and we will send an e-mailwith instructions to reset your password') }}</h6>
        </div>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <!--begin::Form-->
        <form method="POST" action="{{ route('company.password.email') }}" aria-label="{{ __('Register') }}">

            @csrf
            <div class="form-group">
                <label>{{__('E-mail Address')}}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="kt-login__actions">
                <button  class="btn btn-primary btn-elevate" style="width: 100%">{{ __('Send') }}</button>
            </div>
            <!--end::Action-->
        </form>

        <!--end::Form-->
    </div>

    <!--end::Signin-->
</div>
@endsection
