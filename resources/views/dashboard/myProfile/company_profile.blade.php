@extends('layouts.dashboard')

@section('content')
    <!-- begin:: Content Head -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    {{__('My Profile')}}
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            </div>
            <div class="kt-subheader__toolbar">
                <a href="#" class="">
                </a>
                <a href="{{route('dashboard.index')}}" class="btn btn-secondary">
                    {{__('Back')}}
                </a>
            </div>
        </div>
    </div>
    <!-- end:: Content Head -->
    <!--Begin::App-->
    <div class="kt-grid kt-grid--desktop kt-grid--ver kt-grid--ver-desktop kt-app">

        <!--Begin:: App Aside Mobile Toggle-->
        <button class="kt-app__aside-close" id="kt_user_profile_aside_close">
            <i class="la la-close"></i>
        </button>

        <!--End:: App Aside Mobile Toggle-->

        <!--Begin:: App Aside-->
        <div class="kt-grid__item kt-app__toggle kt-app__aside" id="kt_user_profile_aside">

            <!--begin:: Widgets/Applications/User/Profile1-->
            <div class="kt-portlet kt-portlet--height-fluid-">
                <div class="kt-portlet__head  kt-portlet__head--noborder">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body kt-portlet__body--fit-y">

                    <!--begin::Widget -->
                    <div class="kt-widget kt-widget--user-profile-1">
                        <div class="kt-widget__head">
                            <div class="kt-widget__media">
                                <div class="kt-badge kt-badge--xl kt-badge--success">{{ ucwords(mb_substr( auth()->user()->name() ,0,2,'utf-8'))}}</div>
                            </div>

                            <div class="kt-widget__content">
                                <div class="kt-widget__section">
                                    <a href="#" class="kt-widget__username">
                                        {{$company->name()}}
                                        <i class="flaticon2-correct kt-font-success"></i>
                                    </a>
                                    <span class="kt-widget__subtitle">
                                        {{$company->role->name()}}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="kt-widget__body">
                            <div class="kt-widget__content">
                                <div class="kt-widget__info">
                                    <span class="kt-widget__label">{{__('Email')}} : </span>
                                    <a href="#" class="kt-widget__data">{{$company->email}}</a>
                                </div>
                            </div>
                            <div class="kt-widget__items">
                                <a href="{{route('dashboard.profile.company_profile')}}" class="kt-widget__item kt-widget__item--active">
                                    <span class="kt-widget__section">
                                        <span class="kt-widget__icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z" fill="#000000" opacity="0.3" />
                                                    <path d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z" fill="#000000" />
                                                </g>
                                            </svg>
                                        </span>
                                        <span class="kt-widget__desc">
                                            {{__('Company Profile')}}
                                        </span>
                                        </span>
                                </a>
                                <a href="{{route('dashboard.myProfile.change_password')}}" class="kt-widget__item ">
                                        <span class="kt-widget__section">
                                            <span class="kt-widget__icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" fill="#000000" opacity="0.3" />
                                                        <path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z" fill="#000000" opacity="0.3" />
                                                        <path d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z" fill="#000000" opacity="0.3" />
                                                    </g>
                                                </svg> </span>
                                            <span class="kt-widget__desc">
                                                {{__('Change Password')}}
                                            </span>
                                        </span>
                                </a>
                                <a href="{{route('dashboard.documents.index')}}" class="kt-widget__item ">
                                        <span class="kt-widget__section">
                                            <span class="kt-widget__icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" fill="#000000" opacity="0.3" />
                                                        <path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z" fill="#000000" opacity="0.3" />
                                                        <path d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z" fill="#000000" opacity="0.3" />
                                                    </g>
                                                </svg> </span>
                                            <span class="kt-widget__desc">
                                                {{__('Documents')}}
                                            </span>
                                        </span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!--end::Widget -->
                </div>
            </div>

            <!--end:: Widgets/Applications/User/Profile1-->
        </div>

        <!--End:: App Aside-->

        <!--Begin:: App Content-->
        <div class="kt-grid__item kt-grid__item--fluid kt-app__content">
            <div class="row">
                <div class="col-xl-12">
                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">{{__('Company Profile')}}</h3>
                            </div>
                        </div>
                        @include('layouts.dashboard.parts.errorSection')
                        @if(session('success'))
                            @include('layouts.dashboard.parts.successSection')
                        @endif
                        <form class="kt-form kt-form--label-right" action="{{route('dashboard.profile.company_profile')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="kt-portlet__body">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="name_ar">{{__('Arabic Name')}} <span class="required">*</span></label>
                                            <input autocomplete="off" class="form-control" id="name_ar" name="name_ar" type="text" value="{{old('name_ar') ?? $company->name_ar}}">
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="name_en">{{__('English Name')}} <span class="required">*</span></label>
                                            <input autocomplete="off" class="form-control" id="name_en" name="name_en" placeholder="" type="text" value="{{old('name_en') ?? $company->name_en}}">
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="cr_number">{{__('CR Number')}}</label>
                                            <input autocomplete="off" class="form-control" id="cr_number" name="cr_number" placeholder="" type="text" value="{{old('cr_number') ?? $company->cr_number}}">
                                            <span class="field-validation-valid text-danger" data-valmsg-for="cr_number" data-valmsg-replace="true"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="ceo_id">{{__('Chief Executive Officer')}}</label>
                                            <select autocomplete="off" class="form-control selectpicker" name="ceo_id">
                                                <option value="" >{{__('Choose')}}</option>
                                                @foreach($employees as $employee)
                                                    <option
                                                            value="{{$employee->id}}"
                                                            @if((old('ceo_id') ?? $company->ceo_id) == $employee->id) selected @endif>
                                                        {{$employee->name()}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="hr_id">{{__('HR Manager')}}</label>
                                            <select autocomplete="off" class="form-control selectpicker" name="hr_id">
                                                <option value="" >{{__('Choose')}}</option>
                                                @foreach($employees as $employee)
                                                    <option
                                                            value="{{$employee->id}}"
                                                            @if((old('hr_id') ?? $company->hr_id) == $employee->id) selected @endif>
                                                        {{$employee->name()}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="kt-section">
                                    <div class="kt-section__title">
                                        {{__('Address')}}
                                    </div>

                                    <div class="kt-section__body">
                                        <div class="row">

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="country_en">{{__('Country (Arabic)')}} <span class="required">*</span></label>
                                                    <input autocomplete="off" class="form-control" id="country_ar" name="country_ar" placeholder="" type="text" value="{{old('country_ar') ?? $company->country_ar}}">
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="country_en">{{__('Country (English)')}} <span class="required">*</span></label>
                                                    <input autocomplete="off" class="form-control" id="country_en" name="country_en" placeholder="" type="text" value="{{old('country_en') ?? $company->country_en}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="city_ar">{{__('City (Arabic)')}}</label>
                                                    <input autocomplete="off" class="form-control" id="city_ar" name="city_ar" placeholder="" type="text" value="{{old('city_ar') ?? $company->city_ar}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="city_en">{{__('City (English)')}}</label>
                                                    <input autocomplete="off" class="form-control" id="city_en" name="city_en" placeholder="" type="text" value="{{old('city_en') ?? $company->city_en}}">
                                                    <span class="field-validation-valid text-danger" data-valmsg-for="city_en" data-valmsg-replace="true"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="address_ar">{{__('Address (Arabic)')}}</label>
                                                    <input autocomplete="off" class="form-control" id="address_ar" name="address_ar" placeholder="" type="text" value="{{old('address_ar') ?? $company->address_ar}}">
                                                    <span class="field-validation-valid text-danger" data-valmsg-for="address_ar" data-valmsg-replace="true"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="address_en">{{__('Address (English)')}}</label>
                                                    <input autocomplete="off" class="form-control" id="address_en" name="address_en" placeholder="" type="text" value="{{old('address_en') ?? $company->address_en}}">
                                                    <span class="field-validation-valid text-danger" data-valmsg-for="address_en" data-valmsg-replace="true"></span>
                                                </div>

                                            </div>
                                        </div>


                                        <div class="row">

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="postal_code">{{__('Postal Code')}}</label>
                                                    <input autocomplete="off" class="form-control" id="postal_code" name="postal_code" placeholder="" type="text" value="{{old('postal_code') ?? $company->postal_code}}">
                                                    <span class="field-validation-valid text-danger" data-valmsg-for="postal_code" data-valmsg-replace="true"></span>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                                <div class="kt-section">
                                    <div class="kt-section__title">
                                        {{__('Contact')}}
                                    </div>
                                    <div class="kt-section__body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="phone">{{__('Phone Number')}}</label>
                                                    <input autocomplete="off" class="form-control" id="phone" name="phone" placeholder="" type="text" value="{{old('phone') ?? $company->phone}}">
                                                    <span class="field-validation-valid text-danger" data-valmsg-for="phone" data-valmsg-replace="true"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="email">{{__('email')}}</label>
                                                    <input autocomplete="off" class="form-control" id="email" name="email" placeholder="" type="text" value="{{old('email') ?? $company->email}}">
                                                    <span class="field-validation-valid text-danger" data-valmsg-for="email" data-valmsg-replace="true"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="kt-section">
                                    <div class="kt-section__title">
                                        Logo
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 m-auto">
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">{{__('Logo')}}</label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <div class="kt-avatar kt-avatar--outline kt-avatar--circle" id="kt_user_avatar_3">
                                                        <div class="kt-avatar__holder" style="background-image: url({{asset('storage/companies/logos/' . $company->logo)}})"></div>
                                                        <label class="kt-avatar__upload" data-toggle="kt-tooltip" title="" data-original-title="Change avatar">
                                                            <i class="fa fa-pen"></i>
                                                            <input type="file" name="logo" accept=".png, .jpg, .jpeg">
                                                        </label>
                                                        <span class="kt-avatar__cancel" data-toggle="kt-tooltip" title="" data-original-title="Cancel avatar">
                                                            <i class="fa fa-times"></i>
                                                        </span>
                                                    </div>
                                                    <span class="form-text text-muted">Allowed file types: png, jpg, jpeg.</span>
                                                </div>
                                                @error('logo')
                                                <span class="invalid-feedback">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="kt-portlet__foot">
                                <div class="kt-form__actions">
                                    <div class="row">
                                        <div class="col-lg-3 col-xl-3">
                                        </div>
                                        <div class="col-lg-9 col-xl-9">
                                            <button type="submit" class="btn btn-success">{{__('confirm')}}</button>&nbsp;
                                            <a href="{{route('dashboard.index')}}" class="btn btn-secondary">{{__('back')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--End:: App Content-->
    </div>

    <!--End::App-->
@endsection

@push('scripts')
    <script src="{{asset('assets/js/pages/custom/user/profile.js')}}" type="text/javascript"></script>
@endpush
