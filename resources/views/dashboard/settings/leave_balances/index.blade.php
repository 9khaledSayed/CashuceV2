@extends('layouts.dashboard')
@section('content')

    <!-- begin:: Content Head -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">
                        {{__('Leave Balances')}}
                    </h3>
                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                </div>
            </div>
            <div class="kt-subheader__toolbar">
                <a href="#" class="">
                </a>
                <a href="{{route('dashboard.leave_balances.create')}}" class="btn btn-label-brand btn-bold">
                    <i class="fa fa-plus"></i>
                    {{__('Add New')}}
                </a>
                <a href="{{route('dashboard.index')}}" class="btn btn-secondary">
                    {{__('Back')}}
                </a>
            </div>
        </div>
    </div>
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{__('All Leave Balances')}}
                </h3>
            </div>
        </div>
    </div>

    <!-- end:: Content Head -->

    <!-- begin:: Content -->
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid kt-padding-0">

        <!--Begin::Section-->
        <div class="row" id="container_1">
            @foreach($leaveBalances as $leaveBalance)
                <div class="col-xl-3 container_2 droid_font">

                    <!--Begin::Portlet-->
                    <div class="kt-portlet kt-portlet--height-fluid container_3">
                        <div class="kt-portlet__head kt-portlet__head--noborder">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                </h3>
                            </div>
                            <div class="kt-portlet__head-toolbar">
                                <a href="#" class="btn btn-icon" data-toggle="dropdown">
                                    <i class="flaticon-more-1 kt-font-brand"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="kt-nav">
                                        <li class="kt-nav__item">
                                            <a href="{{route('dashboard.leave_balances.edit', $leaveBalance->id)}}" class="kt-nav__link">
                                                <i class="kt-nav__link-icon flaticon2-edit"></i>
                                                <span class="kt-nav__link-text">{{__('Edit')}}</span>
                                            </a>
                                        </li>
{{--                                        <li class="kt-nav__item">--}}
{{--                                            <a href="{{route('dashboard.leave_balances.destroy', $leaveBalance->id)}}" class="kt-nav__link">--}}
{{--                                                <i class="kt-nav__link-icon flaticon2-trash"></i>--}}
{{--                                                <span class="kt-nav__link-text">{{__('Delete')}}</span>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__body container_4">

                            <!--begin::Widget -->
                            <div class="kt-widget kt-widget--user-profile-2">
                                <div class="kt-widget__head">
                                    <div class="kt-widget__info">
                                        <a href="#" class="kt-widget__username search_item">{{ $leaveBalance->days_per_year }}</a>
                                        <a href="#" class="kt-widget__username search_item">{{ __('Day Per Year') }}</a>
                                    </div>
                                </div>
{{--                                <div class="kt-widget__body ">--}}

{{--                                    <div class="kt-widget__item mt-15">--}}
{{--                                        <div class="kt-widget__contact">--}}
{{--                                            <span class="kt-widget__label">{{__('Shift Start Time')}} :</span>--}}
{{--                                            <a href="#" class="kt-widget__data search_item">{{$leaveBalance->shift_start_time}}</a>--}}
{{--                                        </div>--}}
{{--                                        <div class="kt-widget__contact">--}}
{{--                                            <span class="kt-widget__label">{{__('Shift End Time')}} :</span>--}}
{{--                                            <span class="kt-widget__data search_item">{{$leaveBalance->shift_end_time}}</span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            </div>

                            <!--end::Widget -->
                        </div>
                    </div>

                    <!--End::Portlet-->
                </div>
            @endforeach
        </div>

        <!--End::Section-->


        <!--Begin::Pagination-->
        <div class="row">
            <div class="col-xl-12">

                <!--begin:: Components/Pagination/Default-->
                <div class="kt-portlet">
                    <div class="kt-portlet__body">

                        <!--begin: Pagination-->
                    {{$leaveBalances->links('vendor.pagination.simple-tailwind')}}
                        <!--end: Pagination-->
                    </div>
                </div>

                <!--end:: Components/Pagination/Default-->
            </div>
        </div>

        <!--End::Pagination-->
    </div>

    <!-- end:: Content -->


@endsection


