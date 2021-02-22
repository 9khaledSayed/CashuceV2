@extends('layouts.dashboard')
@section('content')
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    {{__('Attendance')}}
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
    <!-- begin:: Content Head -->
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg d-flex justify-content-between">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{__('Absentees')}}
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="dropdown dropdown-inline">
                <button type="button" class="btn btn-danger btn-icon-sm " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="la la-file-excel-o"></i>  {{__('Export')}}
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <ul class="kt-nav">
                        <li class="kt-nav__item">
                            <a href="#" id="this-day-export" class="kt-nav__link">
                                <span class="kt-nav__link-text">{{__('Export This Day')}}</span>
                            </a>
                        </li>
                        <li class="kt-nav__item">
                            <a href="#" id="this-month-export" class="kt-nav__link">
                                <span class="kt-nav__link-text">{{__('Export This Month')}}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            </div>
        </div>
        <!-- end:: Content Head -->
        <div class="kt-portlet__body">
            <div class="kt-form kt-form--label-right kt-margin-t-20 kt-margin-b-10">
                <div class="row align-items-center">
                    <div class="col-xl-12 order-2 order-xl-1">
                        <div class="row align-items-center">
                            <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">

                                <div class="form-group row">
                                    <label for="example-text-input" class="col-form-label col-lg-3 col-sm-12">{{__('Search')}}:</label>
                                    <div class="col-lg-9 col-md-9 col-sm-12">
                                        <div class="kt-input-icon kt-input-icon--left">
                                            <input type="text" class="form-control" id="generalSearch">
                                            <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                                <span><i class="la la-search"></i></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>


            </div>
            <!-- end:: Content Head -->
        </div>
        <div class="kt-portlet__body kt-portlet__body--fit">

            <!--begin: Datatable -->
            <div class="kt-datatable" id="kt_apps_user_list_datatable"></div>

            <!--end: Datatable -->
        </div>
    </div>

    <!-- end:: Content -->
@endsection

@push('scripts')
    <script src="{{asset('js/datatables/absentees.js?<%=ts %>')}}" type="text/javascript"></script>
@endpush
