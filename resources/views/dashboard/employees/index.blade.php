@extends('layouts.dashboard')

@push('styles')
<style>
    .kt-switch.kt-switch--outline.kt-switch--warning input:checked ~ span:before {
        background-color: #1dc9b7;
    }
    .kt-switch.kt-switch--outline.kt-switch--warning input:checked ~ span:after {
        background-color: #ffffff;
        opacity: 1;
    }
    .kt-switch.kt-switch--icon input:empty ~ span:after {
        content: "\f2be";
    }
    .kt-switch.kt-switch--icon input:checked ~ span:after {
        content: '\f2ad';
    }


</style>
@endpush

@section('content')
    <!-- begin:: Content Head -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    {{__('Dashboard')}}
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
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon2-user-1"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    {{__('Employees')}} ( {{ $employeesNo }} )
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <a href="{{route('dashboard.employees.create')}}" class="btn btn-brand btn-icon-sm ml-2 mr-2">
                        <i class="flaticon2-plus"></i> {{__('Add New')}}
                    </a>
                    <a href="{{route('dashboard.employees.export.form')}}" class="btn btn-danger btn-icon-sm ml-2 mr-2">
                        <i class="la la-file-excel-o"></i> {{__('Export')}}
                    </a>
                </div>
            </div>
        </div>

        <!--begin::Modal-->
        <div class="modal fade" id="end-service" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{__('End Employee Service')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <!--begin::Form-->
                        <form class="kt-form kt-form--label-right end-service-form" method="POST" action="">
                            <div class="kt-portlet__body">

                                <div class="form-group row">
                                    <label for="example-text-input" class="col-form-label col-lg-3 col-sm-12">{{__('Contract End Date')}}</label>
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        <div class="input-group date">
                                            <input name="contract_end_date" value="{{old('contract_end_date')}}" type="text" class="form-control datepicker" readonly/>
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="kt-portlet__foot" style="text-align: center">
                                <div class="kt-form__actions">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn-primary submit-end-service">{{__('confirm')}}</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('back')}}</button>                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                </div>
            </div>
        </div>

        <!--end::Modal-->
        <!--begin::Modal-->
        <div class="modal fade" id="back-to-service" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{__('Back To Service')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <!--begin::Form-->
                        <form class="kt-form kt-form--label-right back-to-service-form" method="POST" action="">
                            <div class="kt-portlet__body">

                                <div class="form-group row">
                                    <label for="example-text-input" class="col-form-label col-lg-3 col-sm-12">{{__('Contract Start Date')}}</label>
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        <div class="input-group date">
                                            <input name="contract_start_date" value="{{old('contract_start_date')}}" type="text" class="form-control datepicker" readonly/>
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-form-label col-lg-3 col-sm-12">{{__('Contract End Date')}}</label>
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        <div class="input-group date">
                                            <input name="contract_end_date" value="{{old('contract_end_date')}}" type="text" class="form-control datepicker" readonly/>
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="kt-portlet__foot" style="text-align: center">
                                <div class="kt-form__actions">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn-primary submit-back-to-service">{{__('confirm')}}</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('back')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                </div>
            </div>
        </div>

        <!--end::Modal-->

        <div class="kt-portlet__body">

            <!--begin: Search Form -->
            <div class="kt-form kt-form--label-right kt-margin-t-20 kt-margin-b-10">

                <div class="row align-items-center">
                    <div class="col-xl-12 order-2 order-xl-1">
                        <div class="row align-items-center">
                            <div class="col-md-3 kt-margin-b-20-tablet-and-mobile">
                                <div class="kt-form__group kt-form__group--inline">
                                    <div class="kt-form__label">
                                        <label>{{__('Search')}}:</label>
                                    </div>
                                    <div class="kt-form__control">
                                        <input type="text" class="form-control" id="generalSearch">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 kt-margin-b-20-tablet-and-mobile">
                                <div class="kt-form__group kt-form__group--inline">
                                    <div class="kt-form__label">
                                        <label>{{__('Supervisor')}}:</label>
                                    </div>
                                    <div class="kt-form__control">
                                        <select class="form-control selectpicker" id="kt_form_supervisor">
                                            <option value="">{{__('All')}}</option>
                                            @forelse($supervisors as $supervisor)
                                                <option value="{{$supervisor->name()}}">{{$supervisor->name()}}</option>
                                            @empty
                                                <option disabled>{{__('There is no supervisors in your company')}}</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 kt-margin-b-20-tablet-and-mobile">
                                <div class="kt-form__group kt-form__group--inline">
                                    <div class="kt-form__label">
                                        <label>{{__('Role')}}:</label>
                                    </div>
                                    <div class="kt-form__control">
                                        <select class="form-control selectpicker" id="kt_form_role">
                                            <option value="">{{__('All')}}</option>
                                            @forelse($roles as $role)
                                                <option value="{{$role->name()}}">{{$role->name()}}</option>
                                            @empty
                                                <option disabled>{{__('There is no roles in your company')}}</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 kt-margin-b-20-tablet-and-mobile">
                                <div class="kt-form__group kt-form__group--inline">
                                    <div class="kt-form__label">
                                        <label>{{__('Nationality')}}:</label>
                                    </div>
                                    <div class="kt-form__control">
                                        <select class="form-control selectpicker" id="kt_form_nationality">
                                            <option value="">{{__('All')}}</option>
                                            @forelse($nationalities as $nationality)
                                                <option value="{{$nationality->name()}}">{{$nationality->name()}}</option>
                                            @empty
                                                <option disabled>{{__('There is no nationalities in your company')}}</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center  mt-3">
                            <div class="col-md-3 kt-margin-b-20-tablet-and-mobile">
                                <div class="kt-form__group kt-form__group--inline">
                                    <div class="kt-form__label">
                                        <label>{{__('Service Statues')}}:</label>
                                    </div>
                                    <div class="kt-form__control">
                                        <select class="form-control selectpicker" id="kt_form_service_status">
                                            <option value="">{{__('All')}}</option>
                                            <option value="1">{{__('Active')}}</option>
                                            <option value="2">{{__('In Active')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 kt-margin-b-20-tablet-and-mobile">
                                <div class="kt-form__group kt-form__group--inline">
                                    <div class="kt-form__label">
                                        <label>{{__('Provider')}}:</label>
                                    </div>
                                    <div class="kt-form__control">
                                        <select class="form-control selectpicker" id="kt_form_provider">
                                            <option value="">{{__('All')}}</option>
                                            @forelse($providers as $provider)
                                                <option value="{{$provider->name()}}">{{$provider->name()}}</option>
                                            @empty
                                                <option disabled>{{__('There is no providers')}}</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 kt-margin-b-20-tablet-and-mobile">
                                <div class="kt-form__group kt-form__group--inline">
                                    <div class="kt-form__label">
                                        <label>{{__('Department')}}:</label>
                                    </div>
                                    <div class="kt-form__control">
                                        <select class="form-control selectpicker" id="kt_form_department">
                                            <option value="">{{__('All')}}</option>
                                            @forelse($departments as $department)
                                                <option value="{{$department->name()}}">{{$department->name()}}</option>
                                            @empty
                                                <option disabled>{{__('There is no departments in your company')}}</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 kt-margin-b-20-tablet-and-mobile">
                                <div class="kt-form__group kt-form__group--inline">
                                    <div class="kt-form__label">
                                        <label>{{__('Section')}}:</label>
                                    </div>
                                    <div class="kt-form__control">
                                        <select class="form-control selectpicker" id="kt_form_section">
                                            <option value="">{{__('All')}}</option>
                                            @forelse($sections as $section)
                                                <option value="{{$section->name()}}">{{$section->name()}}</option>
                                            @empty
                                                <option disabled>{{__('There is no sections in your company')}}</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end: Search Form -->
        </div>
        <div class="kt-portlet__body kt-portlet__body--fit">

            <!--begin: Datatable -->
            <div class="kt-datatable" id="ajax_data"></div>

            <!--end: Datatable -->
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{asset('js/datatables/employees.js')}}" type="text/javascript"></script>
@endpush
