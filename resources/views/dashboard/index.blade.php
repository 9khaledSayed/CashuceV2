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
    <!--Begin::Dashboard 6-->

    <!--begin:: Widgets/Stats-->
    <div class="kt-portlet">
        <div class="kt-portlet__body  kt-portlet__body--fit">
            <div class="row row-no-padding row-col-separator-lg">
                <div class="col-md-6 col-lg-2 col-xl-2">
                    <!--begin::Total Profit-->
                    <div class="kt-widget24">
                        <div class="kt-widget24__details">
                            <div class="kt-widget24__info">

                                <a href="#">
                                    <h4 class="kt-widget24__title">
                                        {{__('All Employees')}}
                                    </h4>
                                </a>
                            </div>
                            <span class="kt-widget24__stats kt-font-brand">
                                {{$employeesStatistics['totalActiveEmployees']}}
                            </span>
                        </div>
                    </div>
                    <!--end::Total Profit-->
                </div>
                <div class="col-md-6 col-lg-2 col-xl-2">

                    <!--begin::New Feedbacks-->
                    <div class="kt-widget24">
                        <div class="kt-widget24__details">
                            <div class="kt-widget24__info">

                                <a href="#">
                                    <h4 class="kt-widget24__title">
                                        {{__('Saudis')}}
                                    </h4>
                                </a>

                            </div>
                            <span class="kt-widget24__stats kt-font-warning">
                                {{$employeesStatistics['total_saudis']}}
                            </span>
                        </div>
                    </div>

                    <!--end::New Feedbacks-->
                </div>
                <div class="col-md-6 col-lg-2 col-xl-2">

                    <!--begin::New Orders-->
                    <div class="kt-widget24">
                        <div class="kt-widget24__details">
                            <div class="kt-widget24__info">
                                <a href="#">
                                    <h4 class="kt-widget24__title">
                                        {{__('Non-Saudis')}}
                                    </h4>
                                </a>
                            </div>
                            <span class="kt-widget24__stats kt-font-danger">
                                {{$employeesStatistics['total_non_saudis']}}
                            </span>
                        </div>
                    </div>

                    <!--end::New Orders-->
                </div>
                <div class="col-md-6 col-lg-2 col-xl-2">
                    <!--begin::Total Profit-->
                    <div class="kt-widget24">
                        <div class="kt-widget24__details">
                            <div class="kt-widget24__info">

                                <a href="#">
                                    <h4 class="kt-widget24__title">
                                        {{__('Married')}}
                                    </h4>
                                </a>

                            </div>
                            <span class="kt-widget24__stats kt-font-warning">
                                {{$employeesStatistics['total_married']}}
                            </span>
                        </div>
                    </div>
                    <!--end::Total Profit-->
                </div>
                <div class="col-md-6 col-lg-2 col-xl-2">

                    <!--begin::New Feedbacks-->
                    <div class="kt-widget24">
                        <div class="kt-widget24__details">
                            <div class="kt-widget24__info">

                                <a href="#">
                                    <h4 class="kt-widget24__title">
                                        {{__('Single')}}
                                    </h4>
                                </a>

                            </div>
                            <span class="kt-widget24__stats kt-font-warning">
                                {{$employeesStatistics['total_single']}}
                            </span>
                        </div>
                    </div>

                    <!--end::New Feedbacks-->
                </div>
                <div class="col-md-6 col-lg-2 col-xl-2">

                    <!--begin::New Orders-->
                    <div class="kt-widget24">
                        <div class="kt-widget24__details">
                            <div class="kt-widget24__info">
                                <a href="#">
                                    <h4 class="kt-widget24__title">
                                        {{__('Trial Period')}}
                                    </h4>
                                </a>
                            </div>
                            <span class="kt-widget24__stats kt-font-danger">
                                {{$employeesStatistics['total_trail']}}
                            </span>
                        </div>
                    </div>

                    <!--end::New Orders-->
                </div>
            </div>

        </div>
    </div>

    <!--end:: Widgets/Stats-->

    <!--Begin::Row-->
    <div class="row">
        <div class="col-lg-6">
            <!--begin:: Widgets/Sale Reports-->
            <div class="kt-portlet kt-portlet--height-fluid kt-portlet--mobile ">
                <div class="kt-portlet__head kt-portlet__head--lg kt-portlet__head--noborder kt-portlet__head--break-sm">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            {{__('Employees In Departments')}}
                        </h3>
                    </div>
                </div>

                <div class="kt-portlet__body kt-portlet__body--fit">
                    <!--begin: Datatable -->
                    <div class="kt-datatable" id="department_statistics_table"></div>

                    <!--end: Datatable -->
                </div>
            </div>

            <!--end:: Widgets/Sale Reports-->
        </div>
        <div class="col-lg-6">
            <!--begin::Portlet-->
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <span class="kt-portlet__head-icon kt-hidden">
                            <i class="la la-gear"></i>
                        </span>
                        <h3 class="kt-portlet__head-title">
                            {{__('Employees In Departments')}}
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div id="kt_flotcharts_11" style="height: 300px;"></div>
                </div>
            </div>
            <!--End::Dashboard 6-->
        </div>
    </div>
    <!--End::Row-->

    <div class="row">
        <div class="col-xl-12">

            <div class="kt-portlet kt-portlet--height-fluid kt-portlet--mobile ">
                <div class="kt-portlet__head kt-portlet__head--lg kt-portlet__head--noborder kt-portlet__head--break-sm">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            {{__('Expiring Documents')}}
                        </h3>
                    </div>
                </div>

                <div class="kt-portlet__body kt-portlet__body--fit">
                    <div class="row row-no-padding row-col-separator-lg">
                        <div class="col-md-6 col-lg-2 col-xl-3 mx-auto">
                            <!--begin::Total Profit-->
                            <div class="kt-widget24">
                                <div class="kt-widget24__details">
                                    <div class="kt-widget24__info mx-auto">
                                        <h4 class="kt-widget24__title">
                                            {{__('Employees In Trail')}}
                                        </h4>
                                        <span class="kt-widget24__stats kt-font-brand" style="display:flex;margin: auto;width: fit-content">
                                            {{$employeesInTrail}}
                                        </span>
                                    </div>

                                </div>
                            </div>
                            <!--end::Total Profit-->
                        </div>
                    </div>
                    <!--begin: Datatable -->
                    <div class="kt-datatable" id="expiring_documents_table"></div>

                    <!--end: Datatable -->
                </div>
            </div>
        </div>

    </div>
    <!--Begin::Section-->
    <div class="row">
        <div class="col-xl-12">

            <div class="kt-portlet kt-portlet--height-fluid kt-portlet--mobile ">
                <div class="kt-portlet__head kt-portlet__head--lg kt-portlet__head--noborder kt-portlet__head--break-sm">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            {{__('Attendance Summary')}}
                        </h3>
                    </div>
                </div>

                <div class="kt-portlet__body kt-portlet__body--fit">
                    <div class="row row-no-padding row-col-separator-lg">
                        <div class="col-md-6 col-lg-2 col-xl-3">
                            <!--begin::Total Profit-->
                            <div class="kt-widget24">
                                <div class="kt-widget24__details">
                                    <div class="kt-widget24__info">
                                        <h4 class="kt-widget24__title">
                                            {{__('Attendees')}}
                                        </h4>
                                    </div>
                                    <span class="kt-widget24__stats kt-font-brand">
                                        {{$attendanceSummary['totalActiveEmployees']}}
                                    </span>
                                </div>
                            </div>
                            <!--end::Total Profit-->
                        </div>
                        <div class="col-md-6 col-lg-2 col-xl-3">

                            <!--begin::New Feedbacks-->
                            <div class="kt-widget24">
                                <div class="kt-widget24__details">
                                    <div class="kt-widget24__info">
                                        <h4 class="kt-widget24__title">
                                            {{__('Absent')}}
                                        </h4>
                                    </div>
                                    <span class="kt-widget24__stats kt-font-brand">
                                {{$attendanceSummary['absent']}}
                            </span>
                                </div>
                            </div>

                            <!--end::New Feedbacks-->
                        </div>
                        <div class="col-md-6 col-lg-2 col-xl-3">

                            <!--begin::New Orders-->
                            <div class="kt-widget24">
                                <div class="kt-widget24__details">
                                    <div class="kt-widget24__info">
                                        <h4 class="kt-widget24__title">
                                            {{__('Delay')}}
                                        </h4>
                                    </div>
                                    <span class="kt-widget24__stats kt-font-brand">
                                {{$attendanceSummary['delay']}}
                            </span>
                                </div>
                            </div>

                            <!--end::New Orders-->
                        </div>
                        <div class="col-md-6 col-lg-2 col-xl-3">
                            <!--begin::Total Profit-->
                            <div class="kt-widget24">
                                <div class="kt-widget24__details">
                                    <div class="kt-widget24__info">
                                        <h4 class="kt-widget24__title">
                                            {{__('Early')}}
                                        </h4>
                                    </div>
                                    <span class="kt-widget24__stats kt-font-brand">
                                {{$attendanceSummary['early']}}
                            </span>
                                </div>
                            </div>
                            <!--end::Total Profit-->
                        </div>
                    </div>
                    <!--begin: Datatable -->
                    <div class="kt-datatable" id="attendance_summary"></div>

                    <!--end: Datatable -->
                </div>
            </div>
        </div>
    </div>

    <!--End::Section-->
    <!--Begin::Row-->
    <div class="row">
        <div class="col-lg-6">
            <!--begin:: Widgets/Sale Reports-->
            <div class="kt-portlet kt-portlet--height-fluid kt-portlet--mobile ">
                <div class="kt-portlet__head kt-portlet__head--lg kt-portlet__head--noborder kt-portlet__head--break-sm">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            {{__('Ended Employees')}}
                        </h3>
                    </div>
                </div>

                <div class="kt-portlet__body kt-portlet__body--fit">
                    <!--begin: Datatable -->
                    <div class="kt-datatable" id="ended_employees_table"></div>

                    <!--end: Datatable -->
                </div>
            </div>

    <!--end:: Widgets/Sale Reports-->
        </div>
        <div class="col-lg-6">

            <!--begin:: Widgets/Audit Log-->
            <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            {{__('Employees Activities')}}
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="kt_widget4_tab11_content">
                            <div class="kt-scroll" data-scroll="true" data-height="400" style="height: 400px;">
                                <div class="kt-list-timeline">
                                    <div class="kt-list-timeline__items">
                                        @forelse($activities as $activity)
                                            <div class="kt-list-timeline__item">
                                                <span class="kt-list-timeline__badge kt-list-timeline__badge--{{$activity->statusColor()}}"></span>
                                                <span class="kt-list-timeline__text">{{$activity->description . " by ( " . $activity->causer->name() . " )"}}</span>
                                                <span class="kt-list-timeline__time">{{$activity->created_at->diffForHumans()}}</span>
                                            </div>
                                        @empty
                                            <div class="kt-grid kt-grid--ver" style="min-height: 200px;">
                                                <div class="kt-grid kt-grid--hor kt-grid__item kt-grid__item--fluid kt-grid__item--middle">
                                                    <div class="kt-grid__item kt-grid__item--middle kt-align-center">
                                                        {{__('There Is No Activities Yet !')}}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforelse

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--end:: Widgets/Audit Log-->
        </div>


    </div>



    <!--begin::Modal-->
    <div class="modal fade" id="back-to-service" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('Update Info')}}</h5>
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

@endsection

@push('scripts')
    <script>
        var url = '/dashboard/ended_employees';
    </script>
    <script src="{{asset('js/datatables/attendance_summary.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/datatables/expiring_documents.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/datatables/ended_employees.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/datatables/departments_statistics.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/custom/flot/flot.bundle.js')}}" type="text/javascript"></script>
    <!--end::Page Vendors -->
    <script>
        $(function () {
            var demo11 = function() {
                var data = [
                    @foreach($departments as $department)
                    {label: "{{$department['name']}}", data: {{$department['percentage']}}, color:  KTApp.getStateColor("{{$department['color']}}")},
                    @endforeach
                ];

                $.plot($("#kt_flotcharts_11"), data, {
                    series: {
                        pie: {
                            show: true,
                            radius: 1,
                            label: {
                                show: true,
                                radius: 1,
                                formatter: function(label, series, ) {
                                    return '<div style="font-size:12pt;font-weight:900;text-align:center;padding:2px;color:white;">' + label + '<br/>' + Math.round(series.percent) + '%</div>';
                                },
                                background: {
                                    opacity: 0.8
                                }
                            }
                        }
                    },
                    legend: {
                        show: false
                    }
                });
            }
            demo11();
        })
    </script>
@endpush
