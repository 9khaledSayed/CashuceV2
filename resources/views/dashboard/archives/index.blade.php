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
                    {{__('Archives')}} ( {{ $employeesNo }} )
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
                                <div class="kt-form__group kt-form__group--inline">
                                    <div class="kt-form__label">
                                        <label>{{__('Search')}}:</label>
                                    </div>
                                    <div class="kt-form__control">
                                        <input type="text" class="form-control" id="generalSearch">
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
    <script src="{{asset('js/datatables/archives.js')}}" type="text/javascript"></script>
@endpush
