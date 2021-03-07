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
                    {{__('Attendance Sheet')}}
                </h3>
            </div>
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title ">
                    <div class="input-group date">
                        <div class="input-group-prepend " id="minus">
                            <span class="input-group-text btn">
                                <i class="fa fa fa-arrow-alt-circle-left kt-font-brand"></i>
                            </span>
                        </div>

                        <input name="full_date" id="date-field" type="text" value="{{$fullDate}}" class="form-control text-center font-weight-bold kt-font-brand " readonly/>

                        <div class="input-group-append " id="plus">
                            <span class="input-group-text btn">
                                <i class="fa fa fa-arrow-alt-circle-right kt-font-brand" ></i>
                            </span>
                        </div>
                    </div>

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
                            <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">

                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">{{__('Supervisor')}}:</label>

                                    <div class="col-lg-9 col-md-9 col-sm-12">
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
                            <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">{{__('Nationality')}}:</label>

                                    <div class="col-lg-9 col-md-9 col-sm-12">
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
                    </div>

                </div>
                <div class="row align-items-center ">
                    <div class="col-xl-12 order-2 order-xl-1">
                        <div class="row align-items-center">


                            <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">{{__('Provider')}}:</label>
                                    <div class="col-lg-9 col-md-9 col-sm-12">
                                        <select class="form-control selectpicker" id="kt_form_provider">
                                            <option value="">{{__('All')}}</option>
                                            @forelse($providers as $provider)
                                                <option value="{{$provider->name()}}">{{$provider->name()}}</option>
                                            @empty
                                                <option disabled>{{__('There is no providers in your company')}}</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">{{__('Section')}}:</label>
                                    <div class="col-lg-9 col-md-9 col-sm-12">
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
                            <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">{{__('Department')}}:</label>
                                    <div class="col-lg-9 col-md-9 col-sm-12">
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
            <!-- end:: Content Head -->
        </div>
        <div class="kt-portlet__body kt-portlet__body--fit">

            <!--begin: Datatable -->
            <div class="kt-datatable" id="kt_apps_user_list_datatable"></div>

            <!--end: Datatable -->
        </div>
    </div>

    <!-- end:: Content -->
    <!--begin::Modal-->
    <div class="modal fade" id="update-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('Update Info')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <!--begin::Form-->
                    <form class="kt-form kt-form--label-right update-attendance-form" method="get" action="">
                        @csrf
                        <div class="kt-portlet__body">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-form-label col-lg-3 col-sm-12">{{__('Time in')}}</label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group timepicker">
                                        <input class="form-control" name="time_in" value="" id="timeIn" readonly type="text">
                                        <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-clock-o"></i>
                                    </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-form-label col-lg-3 col-sm-12">{{__('Time out')}}</label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group timepicker">
                                        <input class="form-control" name="time_out"  value="" id="timeOut" readonly placeholder="Select time in" type="text">
                                        <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-clock-o"></i>
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
                                        <button type="submit" class="btn btn-primary update-attendance-submit">{{__('confirm')}}</button>
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
@endsection

@push('scripts')
    <script src="{{asset('js/datatables/attendances.js?<%=ts %>')}}" type="text/javascript"></script>
@endpush
