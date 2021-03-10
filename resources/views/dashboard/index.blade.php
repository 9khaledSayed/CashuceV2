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


    <div class="row">
        <div class="col-xl-12">

            <!--begin:: Widgets/Support Requests-->
            <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            {{__('Rate Of Employees In Department')}}
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="kt-widget16">
                        <div class="kt-widget16__items">
                            <div class="kt-widget16__item">
                                <span class="kt-widget16__sceduled">
                                    {{__('Department')}}
                                </span>
                                <span class="kt-widget16__amount">
                                    {{__('In Service')}}
                                </span>
                            </div>
                            @foreach($departmentsStatistics as $department)
                            <div class="kt-widget16__item">
                                <span class="kt-widget16__date">
                                    {{$department->name}}
                                </span>
                                <span class="kt-widget16__price  kt-font-brand">
                                    {{$department->in_service}}
                                </span>
                            </div>
                            @endforeach
                        </div>
                        <div class="kt-widget16__stats d-flex justify-content-center">
                            <div class="kt-widget16__visual">
                                <div id="kt_chart_support_tickets" style="height: 200px; width: 200px;">
                                </div>
                            </div>
                            <div class="kt-widget16__legends" id="legends">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--end:: Widgets/Support Requests-->
        </div>
    </div>
{{--    <!--Begin::Row-->--}}
{{--    <div class="row">--}}
{{--        <div class="col-lg-6">--}}
{{--            <!--begin:: Widgets/Sale Reports-->--}}
{{--            <div class="kt-portlet kt-portlet--height-fluid kt-portlet--mobile ">--}}
{{--                <div class="kt-portlet__head kt-portlet__head--lg kt-portlet__head--noborder kt-portlet__head--break-sm">--}}
{{--                    <div class="kt-portlet__head-label">--}}
{{--                        <h3 class="kt-portlet__head-title">--}}
{{--                            {{__('Number of Employees In Departments')}}--}}
{{--                        </h3>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="kt-portlet__body kt-portlet__body--fit">--}}
{{--                    <!--begin: Datatable -->--}}
{{--                    <div class="kt-datatable" id="department_statistics_table"></div>--}}

{{--                    <!--end: Datatable -->--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <!--end:: Widgets/Sale Reports-->--}}
{{--        </div>--}}
{{--        <div class="col-lg-6">--}}
{{--            <!--begin::Portlet-->--}}
{{--            <div class="kt-portlet kt-portlet--tab">--}}
{{--                <div class="kt-portlet__head">--}}
{{--                    <div class="kt-portlet__head-label">--}}
{{--												<span class="kt-portlet__head-icon kt-hidden">--}}
{{--													<i class="la la-gear"></i>--}}
{{--												</span>--}}
{{--                        <h3 class="kt-portlet__head-title">--}}
{{--                            {{__('Rate Of Employees In Department')}}--}}
{{--                        </h3>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="kt-portlet__body">--}}
{{--                    <div id="kt_morris_4" style="height:500px;"></div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <!--End::Dashboard 6-->--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <!--End::Row-->--}}

    @cannot('view_employees_fordeal')
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
    @endif

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
                                        {{$attendanceSummary['totalAttendees']}}
                                    </span>
                                </div>
                            </div>
                            <!--end::Total Profit-->
                        </div>
                        <div class="col-md-6 col-lg-2 col-xl-3">

                            <!--begin::New Feedbacks-->
                            <div class="kt-widget24">
                                <a href="{{route('dashboard.attendances.absentees')}}">
                                    <div class="kt-widget24__details">
                                        <div class="kt-widget24__info">
                                            <h4 class="kt-widget24__title ">
                                                {{__('Absent')}}
                                            </h4>
                                        </div>
                                        <span class="kt-widget24__stats kt-font-brand">
                                        {{$attendanceSummary['absent']}}
                                        </span>
                                    </div>
                                </a>
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
                                                <span class="kt-list-timeline__text">{{$activity->localized_description . " ( " . $activity->causer->name() . " )"}}</span>
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



   @include('layouts.components.back_to_service_modal')

@endsection

@push('scripts')
    <script>
        var url = '/dashboard/ended_employees';
    </script>
    <script src="{{asset('js/datatables/attendance_summary.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/datatables/expiring_documents.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/datatables/ended_employees.js')}}" type="text/javascript"></script>
{{--    <script src="{{asset('js/datatables/departments_statistics.js?<%=ts %>')}}" type="text/javascript"></script>--}}
    <script src="{{asset('assets/plugins/custom/flot/flot.bundle.js')}}" type="text/javascript"></script>
    <script>
        $(function () {
            // var supportRequests = function(labels, data, colors) {
            //
            //     var container = KTUtil.getByID('kt_chart_support_requests');
            //
            //     if (!container) {
            //         return;
            //     }
            //
            //     var randomScalingFactor = function() {
            //         return Math.round(Math.random() * 100);
            //     };
            //
            //     var config = {
            //         type: 'doughnut',
            //         data: {
            //             datasets: [{
            //                 data: data,
            //                 // backgroundColor: [
            //                 //     KTApp.getStateColor('success'),
            //                 //     KTApp.getStateColor('danger'),
            //                 //     KTApp.getStateColor('brand')
            //                 // ]
            //                 backgroundColor: colors
            //             }],
            //             labels: labels
            //         },
            //         options: {
            //             cutoutPercentage: 75,
            //             responsive: true,
            //             maintainAspectRatio: false,
            //             legend: {
            //                 display: false,
            //                 position: 'top',
            //             },
            //             title: {
            //                 display: false,
            //                 text: 'Technology'
            //             },
            //             animation: {
            //                 animateScale: true,
            //                 animateRotate: true
            //             },
            //             tooltips: {
            //                 enabled: true,
            //                 intersect: false,
            //                 mode: 'nearest',
            //                 bodySpacing: 5,
            //                 yPadding: 10,
            //                 xPadding: 10,
            //                 caretPadding: 0,
            //                 displayColors: false,
            //                 backgroundColor: KTApp.getStateColor('brand'),
            //                 titleFontColor: '#ffffff',
            //                 cornerRadius: 4,
            //                 footerSpacing: 0,
            //                 titleSpacing: 0
            //             }
            //         }
            //     };
            //
            //     var ctx = container.getContext('2d');
            //     var myDoughnut = new Chart(ctx, config);
            // }

            var supportCases = function(data, colors) {
                if ($('#kt_chart_support_tickets').length == 0) {
                    return;
                }

                Morris.Donut({
                    element: 'kt_chart_support_tickets',
                    data: data,
                    labelColor: '#a7a7c2',
                    colors: colors,
                    formatter: function (x) { return x + "%"}
                });
            }
            $.ajax({
                method:'get',
                url:'/dashboard/departments_statistics',
                success:function (res) {
                    if(res.length > 0){
                        var data = [];
                        var colors = [

                            KTApp.getStateColor('success'),
                            KTApp.getStateColor('warning'),
                            KTApp.getStateColor('info'),
                            KTApp.getStateColor('dark'),
                            KTApp.getStateColor('info'),
                            KTApp.getStateColor('secondary'),
                            KTApp.getStateColor('muted'),
                            ];
                        $.each(res, function (key, department) {
                            data.push({
                                label: department.name,
                                value: department.percentage
                            });
                            colors.push(
                                KTApp.getStateColor(department.color),
                            );

                            $("#legends").append('\
                            <div class="kt-widget16__legend">\
                                <span class="kt-widget16__bullet kt-bg-' + department.color + '"></span>\
                                <span class="kt-widget16__stat">' + department.name + ' ' + department.percentage + ' %</span>\
                            </div>\
                        ');
                        })
                        supportCases(data, colors)


                    }

                }
            })

        })
    </script>
@endpush
