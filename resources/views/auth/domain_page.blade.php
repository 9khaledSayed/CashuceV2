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
            <h3> {{ __('Organization!') }}</h3>
            <h6> {{ __('Enter your organaization name') }}</h6>
        </div>
        

        @include('layouts.dashboard.parts.errorSection')
        <!--begin::Form-->
        <form method="POST" action="" aria-label="{{ __('Login') }}">

        @csrf
            <div class="form-group">
                <label>{{__('Organization Name')}}</label>
                <div class="kt-input-icon kt-input-icon--left">
                    <input class="form-control @error('organization') is-invalid @enderror"
                           value="{{ old('organization') }}"
                           type="organization"
                           name="text"
                           required >
                    <span class="kt-input-icon__icon kt-input-icon__icon--left">
                        <span><i class="fa fa-building"></i></span>
                    </span>
                    @error('organization')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <!--begin::Action-->
            <div class=" ">
                <button id="" class="btn btn-primary btn-elevate" style="width: 100%">{{__('Submit')}}</button>
            </div>
        </form>


        <!--end::Form-->

    </div>
    <!--end::Signin-->

</div>



<!--end::Body-->
@endsection
