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
                    {{__('Ended Employees')}}
                </h3>
            </div>
        </div>

        <div class="kt-portlet__body">

            <!--begin: Search Form -->
            <div class="kt-form kt-form--label-right kt-margin-t-20 kt-margin-b-10">
                <div class="row align-items-center">
                    <div class="col-xl-12 order-2 order-xl-1">
                        <div class="row align-items-center">
                            <div class="col-md-3 kt-margin-b-20-tablet-and-mobile">
                                <div class="kt-input-icon kt-input-icon--left">
                                    <input type="text" class="form-control" placeholder="{{__('Search...')}}" id="generalSearch">
                                    <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                        <span><i class="la la-search"></i></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mt-5 ">
                    <div class="col-xl-12 order-2 order-xl-1">
                        <div class="row align-items-center">
                            <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
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
                            <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
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
                            <div class="col-md-2 kt-margin-b-20-tablet-and-mobile">
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

                            <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
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
                        </div>
                    </div>
                </div>
            </div>
            <!--end: Search Form -->
        </div>
        <div class="kt-portlet__body kt-portlet__body--fit">

            <!--begin: Datatable -->
            <div class="kt-datatable" id="ended_employees_table"></div>

            <!--end: Datatable -->
        </div>


        @include('layouts.components.back_to_service_modal')
    </div>
@endsection

@push('scripts')
    <script>
        var url = '/dashboard/employees/ended_employees';
    </script>
    <script src="{{asset('js/datatables/ended_employees.js')}}" type="text/javascript"></script>
@endpush
