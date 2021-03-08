@extends('layouts.dashboard')
@section('content')
    <!-- begin:: Content Head -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    {{__('Companies')}}
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            </div>
            <div class="kt-subheader__toolbar">
                <a href="#" class="">
                </a>
                <a href="{{route('dashboard.companies.index')}}" class="btn btn-secondary">
                    {{__('Back')}}
                </a>
            </div>
        </div>
    </div>
    <!-- end:: Content Head -->
    <!--begin::Portlet-->
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{__('New Customer')}}
                </h3>
            </div>
        </div>
        @include('layouts.dashboard.parts.errorSection')
        <!--begin::Form-->
        <form class="kt-form kt-form--label-right" method="POST" action="{{route('dashboard.companies.store')}}">
            @csrf
            <div class="kt-portlet__body">
                <div class="form-group row">
                    <div class="col-lg-4 col-md-6 col-sm-9">
                        <label >{{__('Full Arabic Name')}} *</label>
                        <input name="name_ar"
                               class="form-control @error('name_ar') is-invalid @enderror"
                               value="{{old('name_ar')}}"
                               type="text">
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-9">
                        <label >{{__('Full English Name')}} *</label>
                        <input name="name_en"
                               class="form-control @error('name_en') is-invalid @enderror"
                               value="{{old('name_en')}}"
                               type="text">
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-9">
                        <label for="email">{{__('Email')}}</label>
                        <input
                                class="form-control @error('email') is-invalid @enderror"
                                type="email"
                                name="email"
                                id="email"
                                value="{{old('email')}}"
                                required autocomplete="email">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-4">
                        <label for="domain">{{__('Domain')}}</label>
                        <input
                                class="form-control @error('domain')is-invalid @enderror"
                                type="text"
                                name="domain"
                                id="domain"
                                value="{{old('domain')}}">
                    </div>
                    <div class="col-lg-4">
                        <label for="password">{{__('Password')}}</label>
                        <input
                                class="form-control @error('password')is-invalid @enderror"
                                type="password"
                                name="password"
                                id="password"
                                value=""
                                autocomplete="new-password">
                    </div>
                    <div class="col-lg-4">
                        <label for="role_id">{{__('Confirm Password')}}</label>
                        <input
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                >
                    </div>
                </div>


            </div>
            <div class="kt-portlet__foot" style="text-align: center">
                <div class="kt-form__actions">
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary">{{__('confirm')}}</button>
                            <a href="{{route('dashboard.companies.index')}}" class="btn btn-secondary">{{__('back')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!--end::Form-->
    </div>

    <!--end::Portlet-->
@endsection

@push('scripts')
    <script>
        $(function (){
            $(".kt-selectpicker").selectpicker();
        });
    </script>
@endpush
