@extends('layouts.dashboard')
@push('styles')
    <link href="{{asset('assets/css/pages/wizard/wizard-1.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <!-- begin:: Content Head -->
    <div class="kt-subheader   kt-grid__item mt-4" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    {{__('Employees Services')}}
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

    <div class="kt-portlet" >
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{__('Vacation Request')}}
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body kt-portlet__body--fit">
            <div class="kt-grid  kt-wizard-v1 kt-wizard-v1--white droid_font" id="kt_contacts_add" data-ktwizard-state="step-first">
                <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v1__wrapper">
                    <!--begin: Form Wizard Form-->
                    <form action="{{route('dashboard.vacations.store_assigned_vacation')}}" method="post" class="kt-form" id="kt_contacts_add_form">
                    @csrf
                    <!--begin: Form Wizard Step 1-->
                        <div class="kt-wizard-v1__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
                            <div class="kt-section kt-section--first">
                                <div class="kt-wizard-v1__form">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="kt-section__body">
                                                <div class="kt-section">
                                                    <div class="kt-section__body">
                                                        <div class="kt-portlet__body">
                                                            <div class="form-group row ">
                                                                <div class="col-lg-3">
                                                                    <label for="employees">
                                                                        {{__('Employee')}}
                                                                    </label>
                                                                    <select class="form-control @error('employee_id') is-invalid @enderror kt-selectpicker"
                                                                            id="employees"
                                                                            data-size="7"
                                                                            data-live-search="true"
                                                                            data-show-subtext="true" name="employee_id" title="{{__('Select')}}">
                                                                        @forelse($employees as $employee)
                                                                            <option
                                                                                    value="{{$employee->id}}"
                                                                                    @if(old('employee_id') == $employee->id) selected @endif
                                                                            >{{$employee->name() . ' - ' . $employee->job_number}}</option>
                                                                        @empty
                                                                            <option disabled>{{__('There is no employees under your supervision')}}</option>
                                                                        @endforelse
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <label for="LeaveTypeId">
                                                                        {{__('Vacation Type')}}
                                                                    </label>
                                                                    <select class="form-control kt-selectpicker" data-val="true" id="vacationTypes" name="vacation_type_id" id="vacation_id">
                                                                        <option value="">
                                                                            {{__('Choose')}}
                                                                        </option>
                                                                        <option value="0">{{__('Other')}}</option>
                                                                        @foreach($vacationTypes as $vacationType)
                                                                            <option value="{{$vacationType->id}}">{{$vacationType->name()}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <label for="start_date">{{__('Start Date')}}<span class="required">*</span></label>
                                                                    <div class="input-group date">
                                                                        <input name="start_date" type="text" class="form-control start_date datepicker" readonly />
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text">
                                                                                <i class="la la-calendar"></i>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <label for="end_date">{{__('Return Date')}}<span class="required">*</span></label>
                                                                    <div class="input-group date">
                                                                        <input name="end_date" type="text" class="form-control end_date datepicker" readonly />
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text">
                                                                                <i class="la la-calendar"></i>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row" style="display: none" id="reason">
                                                                <div class="col-lg-6">
                                                                    <label>{{__('Reason In Arabic')}}</label>
                                                                    <input name="reason_ar" value="{{old('reason_ar')}}" class="form-control @error('reason_ar') is-invalid @enderror">
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <label>{{__('Reason In English')}}</label>
                                                                    <input name="reason_en" value="{{old('reason_en')}}" class="form-control @error('reason_en') is-invalid @enderror">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-3 col-form-label">{{__('Paid In Advance')}}</label>
                                                                <div class="col-3">
                                                                    <span class="kt-switch kt-switch--icon">
                                                                        <label>
                                                                            <input type="checkbox" @if(old('paid_in_advance')) checked @endif  name="paid_in_advance">
                                                                            <span></span>
                                                                        </label>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row mt-3">
                                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                                    <div class="kt-portlet kt-portlet--unelevate kt-portlet--bordered">
                                                                        <div class="kt-portlet__body text-center">
                                                                            <span class="display-4" id="vacation_days">0</span>
                                                                            {{__('Vacation Days')}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                                    <div class="kt-portlet kt-portlet--unelevate kt-portlet--bordered">
                                                                        <div class="kt-portlet__body text-center">
                                                                        <span class="display-4" id="vacation_balance">
                                                                            0
                                                                        </span>
                                                                            {{__('Available Balance')}}
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
                        </div>
                        <!--end: Form Wizard Step 1-->
                        <!--begin: Form Actions -->
                        <div class="kt-form__actions">
                            <div class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u mx-auto" style="display: block" data-ktwizard-type="action-submit">
                                {{__('confirm')}}
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
<script src="{{asset('js/pages/vacation_request_form.js?<%=ts %>')}}" type="text/javascript"></script>
@endpush
