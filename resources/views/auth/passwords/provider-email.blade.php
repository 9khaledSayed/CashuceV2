@extends('layouts.app')

@section('content')
<!--end::Head-->

<!--begin::Body-->
<div class="kt-login__body">

    <!--begin::Signin-->
    <div class="kt-login__form">
        <div class="kt-login__title">
            <h3>{{ __('Provider Reset Password') }}</h3>
        </div>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <!--begin::Form-->
        <form method="POST" action="{{ route('provider.password.email') }}" aria-label="{{ __('Register') }}">

            @csrf
            <div class="form-group">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="kt-login__actions">
                <button  class="btn btn-primary btn-elevate kt-login__btn-primary mx-auto">{{ __('Send Password Reset Link') }}</button>
            </div>
            <!--end::Action-->
        </form>

        <!--end::Form-->
    </div>

    <!--end::Signin-->
</div>
@endsection
