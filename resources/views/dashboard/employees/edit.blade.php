@extends('layouts.dashboard')
@push('styles')
    <link href="{{asset('assets/css/pages/wizard/wizard-1' . (App::isLocale('ar')?'.rtl':'') . '.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <!-- begin:: Content Head -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    {{__('Update Info')}}
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            </div>
            <div class="kt-subheader__toolbar">
                <a href="#" class="">
                </a>
                <a href="{{route('dashboard.employees.index')}}" class="btn btn-secondary">
                    {{__('Back')}}
                </a>
            </div>
        </div>
    </div>
    <!-- end:: Content Head -->

    <div class="kt-portlet">
        <div class="kt-portlet__body kt-portlet__body--fit">
            <div class="kt-grid  kt-wizard-v1 kt-wizard-v1--white droid_font" id="kt_contacts_add" data-ktwizard-state="step-first">
                <div class="kt-grid__item">

                    <!--begin: Form Wizard Nav -->
                    <div class="kt-wizard-v1__nav">
                        <div class="kt-wizard-v1__nav-items">

                            <!--doc: Replace A tag with SPAN tag to disable the step link click -->
                            <div class="kt-wizard-v1__nav-item" data-ktwizard-type="step" data-ktwizard-state="current">
                                <div class="kt-wizard-v1__nav-body">
                                    <div class="kt-wizard-v1__nav-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--xl">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                <path d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                <path d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                                            </g>
                                        </svg> </div>
                                    <div class="kt-wizard-v1__nav-label">
                                        1. {{__('Basic Information')}}
                                    </div>
                                </div>
                            </div>
                            <div class="kt-wizard-v1__nav-item" data-ktwizard-type="step">
                                <div class="kt-wizard-v1__nav-body">
                                    <div class="kt-wizard-v1__nav-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--xl">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <polygon fill="#000000" opacity="0.3" points="6 3 18 3 20 6.5 4 6.5"/>
                                                <path d="M6,5 L18,5 C19.1045695,5 20,5.8954305 20,7 L20,19 C20,20.1045695 19.1045695,21 18,21 L6,21 C4.8954305,21 4,20.1045695 4,19 L4,7 C4,5.8954305 4.8954305,5 6,5 Z M9,9 C8.44771525,9 8,9.44771525 8,10 C8,10.5522847 8.44771525,11 9,11 L15,11 C15.5522847,11 16,10.5522847 16,10 C16,9.44771525 15.5522847,9 15,9 L9,9 Z" fill="#000000"/>
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="kt-wizard-v1__nav-label">
                                        2. {{__('Job')}}
                                    </div>
                                </div>
                            </div>
                            <div class="kt-wizard-v1__nav-item" data-ktwizard-type="step">
                                <div class="kt-wizard-v1__nav-body">
                                    <div class="kt-wizard-v1__nav-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--xl">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M2,6 L21,6 C21.5522847,6 22,6.44771525 22,7 L22,17 C22,17.5522847 21.5522847,18 21,18 L2,18 C1.44771525,18 1,17.5522847 1,17 L1,7 C1,6.44771525 1.44771525,6 2,6 Z M11.5,16 C13.709139,16 15.5,14.209139 15.5,12 C15.5,9.790861 13.709139,8 11.5,8 C9.290861,8 7.5,9.790861 7.5,12 C7.5,14.209139 9.290861,16 11.5,16 Z" fill="#000000" opacity="0.3" transform="translate(11.500000, 12.000000) rotate(-345.000000) translate(-11.500000, -12.000000) "/>
                                                <path d="M2,6 L21,6 C21.5522847,6 22,6.44771525 22,7 L22,17 C22,17.5522847 21.5522847,18 21,18 L2,18 C1.44771525,18 1,17.5522847 1,17 L1,7 C1,6.44771525 1.44771525,6 2,6 Z M11.5,16 C13.709139,16 15.5,14.209139 15.5,12 C15.5,9.790861 13.709139,8 11.5,8 C9.290861,8 7.5,9.790861 7.5,12 C7.5,14.209139 9.290861,16 11.5,16 Z M11.5,14 C12.6045695,14 13.5,13.1045695 13.5,12 C13.5,10.8954305 12.6045695,10 11.5,10 C10.3954305,10 9.5,10.8954305 9.5,12 C9.5,13.1045695 10.3954305,14 11.5,14 Z" fill="#000000"/>
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="kt-wizard-v1__nav-label">
                                        3. {{__('Salary Information')}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--end: Form Wizard Nav -->
                </div>
                <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v1__wrapper">
                    <!--begin: Form Wizard Form-->
                    <form action="{{route('dashboard.employees.update', $employee)}}" method="post" class="kt-form" style="width: 65%" id="kt_contacts_add_form">
                    @csrf
                    @method('put')
                    <!--begin: Form Wizard Step 1-->
                        <div class="kt-wizard-v1__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
                            <div class="kt-section kt-section--first">
                                <div class="kt-wizard-v1__form">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="kt-section__body">
                                                <div class="kt-section">
                                                    <div class="kt-section__body">
                                                        <h3 class="kt-section__title kt-section__title-lg">{{__('Basic Information')}}:</h3>
                                                        <div class="form-group row">
                                                            <div class="col-lg-3">
                                                                <label>{{__('First Name Arabic')}} *</label>
                                                                <input name="fname_ar" class="form-control" type="text"  value="{{$employee->fname_ar}}">
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label>{{__('Second Name Arabic')}}</label>
                                                                <input name="sname_ar" class="form-control" type="text"  value="{{$employee->sname_ar}}">
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label>{{__('Third Name Arabic')}}</label>
                                                                <input name="tname_ar" class="form-control" type="text"  value="{{$employee->tname_ar}}">
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label>{{__('Fourth Name Arabic')}} *</label>
                                                                <input name="lname_ar" class="form-control" type="text"  value="{{$employee->lname_ar}}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-lg-3">
                                                                <label>{{__('First Name English')}} *</label>
                                                                <input name="fname_en" class="form-control" type="text"  value="{{$employee->fname_en}}">
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label>{{__('Second Name English')}}</label>
                                                                <input name="sname_en" class="form-control" type="text"  value="{{$employee->sname_en}}">
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label>{{__('Third Name English')}}</label>
                                                                <input name="tname_en" class="form-control" type="text"  value="{{$employee->tname_en}}">
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label>{{__('Fourth Name English')}} *</label>
                                                                <input name="lname_en" class="form-control" type="text"  value="{{$employee->lname_en}}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-lg-12">
                                                                <label>{{__('Trial Period')}}</label>
                                                                <input name="test_period" class="form-control" type="text" value="{{$employee->test_period}}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-lg-6">
                                                                <label>{{__('Birthdate')}} *</label>
                                                                <div class="input-group date">
                                                                    <input
                                                                        name="birthdate"
                                                                        type="text"
                                                                        class="form-control datepicker"
                                                                        value="{{$employee->birthdate}}"
                                                                        readonly />
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text">
                                                                            <i class="la la-calendar"></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label>{{__('Nationality')}} *</label>
                                                                <select name="nationality_id"  class="form-control kt-selectpicker" title="Choose">
                                                                    <option value="">{{__('Choose')}}</option>
                                                                    @foreach($nationalities as $nationality)
                                                                        <option value="{{$nationality->id}}"
                                                                                @if($employee->nationality_id == $nationality->id)selected @endif
                                                                        >{{$nationality->name()}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-lg-6">
                                                                <label >{{__('Marital Status')}}</label>
                                                                <div class="kt-radio-list mx-auto text-center">
                                                                    <label class="kt-radio kt-radio--bold kt-radio--brand">
                                                                        <input type="radio" name="marital_status" value="0"  @if($employee->marital_status == 0) checked @endif>
                                                                        {{__('Single')}}
                                                                        <span></span>
                                                                    </label>
                                                                    <label class="kt-radio kt-radio--bold kt-radio--brand">
                                                                        <input type="radio" name="marital_status" value="1"  @if($employee->marital_status == 1) checked @endif>
                                                                        {{__('Married')}}
                                                                        <span></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label>{{__('Gender')}}</label>
                                                                <div class="kt-radio-list mx-auto text-center">
                                                                    <label class="kt-radio kt-radio--bold kt-radio--brand">
                                                                        <input type="radio" name="gender" value="0"  @if($employee->gender == 0) checked @endif>
                                                                        {{__('Male')}}
                                                                        <span></span>
                                                                    </label>
                                                                    <label class="kt-radio kt-radio--bold kt-radio--brand">
                                                                        <input type="radio" name="gender" value="1"  @if($employee->gender == 1) checked @endif>
                                                                        {{__('Female')}}
                                                                        <span></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
                                                <div class="kt-section">
                                                    <div class="kt-section__body">
                                                        <h3 class="kt-section__title kt-section__title-lg">{{__('Address Details')}}:</h3>
                                                        <div class="form-group row">
                                                            <div class="col-lg-4">
                                                                <label>{{__('ID Number')}} *</label>
                                                                <input name="id_num" class="form-control" type="text"  value="{{$employee->id_num}}">
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <label>{{__('Issue Date')}}</label>
                                                                <div class="input-group date">
                                                                    <input name="id_issue_date"
                                                                           type="text"
                                                                           class="form-control datepicker"
                                                                           readonly
                                                                           value="{{$employee->id_issue_date}}" />
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text">
                                                                            <i class="la la-calendar"></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <label>{{__('Expire Date')}}</label>
                                                                <div class="input-group date">
                                                                    <input name="id_expire_date"
                                                                           type="text"
                                                                           class="form-control datepicker"
                                                                           readonly
                                                                            value="{{$employee->id_expire_date}}"/>
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text">
                                                                            <i class="la la-calendar"></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-lg-6">
                                                                <label>{{__('City Name In Arabic')}}</label>
                                                                <input name="city_name_ar" class="form-control" type="text" value="{{$employee->city_name_ar}}">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label>{{__('City Name In English')}}</label>
                                                                <input name="city_name_en" class="form-control" type="text" value="{{$employee->city_name_en}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="kt-section">
                                                    <div class="kt-section__body">
                                                        <h3 class="kt-section__title kt-section__title-lg">{{__('Passport Information')}}:</h3>
                                                        <div class="form-group row">
                                                            <div class="col-lg-12">
                                                                <label>{{__('Passport Number')}}</label>
                                                                <input name="passport_num" class="form-control" type="text"  value="{{$employee->passport_num}}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-lg-4">
                                                                <label>{{__('Issue Date')}}</label>
                                                                <div class="input-group date">
                                                                    <input name="passport_issue_date"
                                                                           type="text"
                                                                           class="form-control datepicker"
                                                                           readonly
                                                                            value="{{$employee->passport_issue_date}}"/>
                                                                    <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="la la-calendar"></i>
                                                                    </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <label>{{__('Expire Date')}}</label>
                                                                <div class="input-group date">
                                                                    <input name="passport_expire_date"
                                                                           type="text"
                                                                           class="form-control datepicker"
                                                                           readonly
                                                                           value="{{$employee->passport_expire_date}}"/>
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text">
                                                                            <i class="la la-calendar"></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <label>{{__('Issue Place')}}</label>
                                                                <input name="issue_place" class="form-control" type="text"  value="{{$employee->issue_place}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="kt-section">
                                                    <div class="kt-section__body">
                                                        <h3 class="kt-section__title kt-section__title-lg">{{__('Contact')}}</h3>
                                                        <div class="form-group row">
                                                            <div class="col-lg-6">
                                                                <label>{{__('Mobile')}} *</label>
                                                                <input name="phone" class="form-control" type="text"  value="{{$employee->phone}}">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label>{{__('Email')}} *</label>
                                                                <input name="email" class="form-control" type="text"  value="{{$employee->email}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--end: Form Wizard Step 1-->

                        <!--begin: Form Wizard Step 2-->
                        <div class="kt-wizard-v1__content" data-ktwizard-type="step-content">
                            <div class="kt-section kt-section--first">
                                <div class="kt-wizard-v1__form">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="kt-section__body">
                                                <div class="kt-section">
                                                    <div class="kt-section__body">
                                                        <h3 class="kt-section__title kt-section__title-lg">{{__('Job')}}</h3>
                                                        <div class="form-group row">
                                                            <div class="col-lg-6">
                                                                <label>{{__('Employee Number')}} *</label>
                                                                <input name="job_number"
                                                                       class="form-control"
                                                                       type="text"
                                                                       value="{{$employee->job_number}}">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label>{{__('Joined Date')}} *</label>
                                                                <div class="input-group date">
                                                                    <input name="joined_date"
                                                                           type="text"
                                                                           class="form-control datepicker"
                                                                           readonly
                                                                           value="{{$employee->joined_date}}"/>
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text">
                                                                            <i class="la la-calendar"></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-lg-4">
                                                                <label>{{__('Role')}} *</label>
                                                                <select name="role_id" class="form-control kt-selectpicker" title="Choose" >
                                                                    @foreach($roles as $role)
                                                                        <option value="{{$role->id}}" @if($employee->role->id == $role->id) selected @endif>{{$role->Name()}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <label>{{__('Job Title')}} *</label>
                                                                <select name="job_title_id" class="form-control kt-selectpicker" title="Choose">
                                                                    <option value="">{{__('Choose')}}</option>
                                                                    @foreach($job_titles as $job_title)
                                                                        <option value="{{$job_title->id}}"
                                                                                @if($employee->job_title_id == $job_title->id)selected @endif
                                                                        >{{$job_title->name()}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <label for="supervisor_id">{{__('Supervisor')}}</label>
                                                                <select class="form-control @error('supervisor_id') is-invalid @enderror kt-selectpicker"
                                                                        id="supervisor_id"
                                                                        data-size="7"
                                                                        data-live-search="true"
                                                                        data-show-subtext="true" name="supervisor_id" title="{{__('Select')}}">
                                                                    <option value="">{{__('choose')}}</option>
                                                                    @forelse($supervisors as $supervisor)
                                                                        <option
                                                                                value="{{$supervisor->id}}"
                                                                                @if($supervisor->id == (old('supervisor_id') ?? $employee->supervisor_id)) selected @endif
                                                                        >{{$supervisor->name()  . '( ' . $supervisor->job_number . ' )'}}</option>
                                                                    @empty
                                                                        <option disabled>{{__('There is no supervisors')}}</option>
                                                                    @endforelse
                                                                </select>
                                                            </div>

                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-lg-4">
                                                                <label>{{__('Provider')}} *</label>
                                                                <select name="provider_id" class="form-control kt-selectpicker" title="Choose">
                                                                    @foreach($providers as $provider)
                                                                        <option value="{{$provider->id}}"
                                                                            @if($employee->provider_id == $provider->id) selected @endif
                                                                        >{{$provider->name()}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <label>{{__('Department')}}</label>
                                                                <select name="department_id" id="department" class="form-control kt-selectpicker" title="Choose" value="">
                                                                    @foreach($departments as $department)
                                                                        <option value="{{$department->id}}" @if($employee->department_id == $department->id) selected @endif>{{ $department->name() }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <label>{{__('Section')}}</label>
                                                                <select name="section_id" id="section" class="form-control" title="Choose">

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="kt-section">
                                                    <div class="kt-section__body">
                                                        <h3 class="kt-section__title kt-section__title-lg">{{__('Contract Information')}}</h3>
                                                        <div class="form-group row">
                                                            <div class="col-lg-12">
                                                                <label>{{__('Contract Type')}} *</label>
                                                                <select name="contract_type" class="form-control kt-selectpicker" title="Choose" >
                                                                    @foreach($contract_type as $key => $value)
                                                                        <option value="{{$key}}" @if($employee->contract_type == $key) selected @endif>{{__($value)}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-lg-4">
                                                                <label>{{__('Contract Start Date')}} *</label>
                                                                <div class="input-group date">
                                                                    <input name="contract_start_date" type="text" class="form-control datepicker" readonly value="{{$employee->contract_start_date->format('Y-m-d')}}"/>
                                                                    <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="la la-calendar"></i>
                                                                    </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3" id="period">
                                                                <label>{{__('Contract period')}} *</label>
                                                                <select name="contract_period" id="period" class="form-control" title="Choose">
                                                                    @if($employee->contract_period == 12)
                                                                        <option value="12" selected>{{ __('1 year') }}</option>
                                                                        <option value="24">{{ __('2 years') }}</option>
                                                                    @elseif($employee->contract_period == 24)
                                                                        <option value="24" selected>{{ __('2 years') }}</option>
                                                                        <option value="12">{{ __('1 year') }}</option>
                                                                    @endif
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-5">
                                                                <label>{{__('Contract End Date')}} *</label>
                                                                <input name="contract_end_date" class="form-control" value="{{ $employee->contract_end_date }}" type="text" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="kt-section">
                                                    <div class="kt-section__body">
                                                        <h3 class="kt-section__title kt-section__title-lg">{{__('Work Shift')}}:</h3>
                                                        <div class="form-group">
                                                            <label>{{__('Work Shift')}}</label>
                                                            <div class="kt-radio-list">
                                                                @foreach($workShifts as $workShift)
                                                                    <label class="kt-radio kt-radio--tick kt-radio--brand">
                                                                        <input
                                                                                type="radio" name="work_shift_id"
                                                                                value="{{$workShift->id}}"
                                                                                @if((old('work_shift_id') ?? $employee->work_shift_id) == $workShift->id) checked @endif>
                                                                        {{$workShift->name()}}
                                                                        <span></span>
                                                                    </label>
                                                                @endforeach
                                                            </div>
                                                            @error('work_shift_id')
                                                            <span class="form-text text-danger">Some help text goes here</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--end: Form Wizard Step 2-->

                        <!--begin: Form Wizard Step 4-->
                        <div class="kt-wizard-v1__content" data-ktwizard-type="step-content">
                            <div class="kt-section kt-section--first">
                                <div class="kt-wizard-v1__form">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="kt-section__body">
                                                <div class="kt-section">
                                                    <div class="kt-section__body">
                                                        <h3 class="kt-section__title kt-section__title-lg">{{__('Salary Information')}}</h3>
                                                        <div class="form-group row">
                                                            <div class="col-lg-12">
                                                                <label>{{__('Basic Salary')}} *</label>
                                                                <input name="salary" class="form-control" type="text"  value="{{$employee->salary}}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="form-group">
                                                                <div class="col-lg-12">
                                                                    <h3 class="kt-section__title kt-section__title-lg" style="margin: 25px 0 20px 0;">{{__('Allowances')}}</h3>
                                                                    <div class="kt-checkbox-list">
                                                                        @foreach($allowances as $allowance)
                                                                        <label class="kt-checkbox kt-checkbox--bold  @if($allowance->type == 1) kt-checkbox--success @else kt-checkbox--danger @endif ">
                                                                            <input name="allowance[]" @if($employee->allowances->contains($allowance)) checked @endif value="{{$allowance->id}}" type="checkbox">
                                                                            {{$allowance->name()}}

                                                                            @if($allowance->value)
                                                                           ( {{$allowance->value . __(' S.R')}} )
                                                                            @else
                                                                            {{ '( ' .$allowance->percentage . ' % )' }}
                                                                            @endif
                                                                            <span></span>
                                                                        </label>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--end: Form Wizard Step 4-->

                        <!--begin: Form Actions -->
                        <div class="kt-form__actions">
                            <div class="btn btn-secondary btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-prev">
                                {{__('Previous')}}
                            </div>
                            <div class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-submit">
                                {{__('Submit')}}
                            </div>
                            <div class="btn btn-brand btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-next">
                                {{__('Next')}}
                            </div>
                        </div>

                        <!--end: Form Actions -->
                    </form>

                    <!--end: Form Wizard Form-->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <script src="{{asset('js/pages/employees.js')}}" type="text/javascript"></script>

    <script type=text/javascript>
        $(function(){
            var sections = $("#section") ;
            var department_id = $('#department').val();
            console.log(department_id);
            sectionAjax(department_id);

            $('#department').change(function(){
                department_id = $(this).val();
                sectionAjax(department_id);
            });
            function sectionAjax(department_id) {
                if(department_id){
                    $.ajax({
                        type:"GET",
                        url:"/dashboard/departments/getSections/" + department_id,
                        success:function(res){
                            if(res){
                                sections.empty();
                                $.each(res,function(index,section){
                                    sections.append('<option value="'+section.id+'">'+section.name_ar+'</option>');
                                });
                                sections.selectpicker('val', {{ $employee->section_id }}) ;
                                sections.selectpicker('refresh');
                            }else{
                                sections.empty();
                            }
                        }
                    });
                }else{
                    sections.empty();
                }
            }
        });

    </script>
@endpush
