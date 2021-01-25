@extends('layouts.dashboard')

@section('content')
    <!-- begin:: Content Head -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    {{__('Customer Info')}}
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            </div>
            <div class="kt-subheader__toolbar">
                <a href="#" class="">
                </a>
                <a href="{{route('dashboard.companies.index')}}" class="btn btn-secondary">
                    {{__('Back')}}
                </a>
            </div>
        </div>
    </div>
    <!-- end:: Content Head -->

    <!--Begin::Row-->
    <div class="row">
        <div class="kt-portlet col-lg-4 " style="height: fit-content">
            <div class="modal-header">
                <h3 class="modal-title">
                    {{__('Details')}}
                </h3>
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button"></button>
            </div>
            <div class="modal-body">
                <div id="payslip-details-div">
                    <div class="kt-widget kt-widget--user-profile-1" style="padding-bottom:unset;">
                        <div class="kt-widget__head">
                            <div class="kt-widget__media">
                                <div class="kt-badge kt-badge--xl kt-badge--success">{{ mb_substr( $company->name() ,0,2,'utf-8')}}</div>
{{--                                <div class="text-center kt-font-bold kt-margin-t-5">--}}
{{--                                    {{$company->email}}--}}
{{--                                </div>--}}
                            </div>
                            <div class="kt-widget__content">
                                <div class="kt-widget__section">
                                    <a href="#" class="kt-widget__username">
                                        {{$company->name()}}
                                    </a>
                                    <span class="kt-widget__subtitle">
                               {{$company->role->name()}}
                            </span>
                                    <span class="kt-widget__subtitle">
                                {{$company->created_at->format('Y-m-d')}}
                            </span>
                                </div>
                            </div>
                        </div>
                        <div class="kt-widget4 kt-padding-15">
                            <div class="kt-widget4__item">
                            <span class="kt-widget4__icon">
                                <i class="fa fa-users kt-font-success"></i>
                            </span>
                                <a href="#" class="kt-widget4__title kt-widget4__title--light">
                                    {{__('Employees No')}}
                                </a>
                                <span class="kt-widget4__number kt-font-success">
                                {{$company->employees->count()}}
                            </span>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <!--begin:: Widgets/New Users-->
            <div class="kt-portlet kt-portlet--tabs kt-portlet--height-fluid">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            {{__('Employees')}}
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="tab-content">
                        <div class="kt-widget11">
                            <div class="table-responsive">
                                <table class="table text-center">
                                    <thead>
                                    <tr>
                                        <td style="width:15%">{{__('Name')}}</td>
                                        <td style="width:15%">{{__('Email')}}</td>
                                        <td style="width:15%">{{__('Job Number')}}</td>
                                        <td style="width:15%">{{__('Salary')}}</td>
                                        <td style="width:15%">{{__('Role')}}</td>
                                        <td style="width:15%">{{__('Account Status')}}</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($company->employees as $employee)
                                        <tr>
                                            <td>
                                                <span class="kt-widget11__sub">{{$employee->name()}}</span>
                                            </td>
                                            <td>
                                                <span class="kt-widget11__sub">{{$employee->email}}</span>
                                            </td>
                                            <td>
                                                <span class="kt-widget11__sub">{{$employee->job_number}}</span>
                                            </td>
                                            <td>
                                                <span class="kt-widget11__sub">{{$employee->salary}}</span>
                                            </td>
                                            @if($employee->email_verified_at)
                                                <td>
                                            <span class="kt-badge kt-badge--inline kt-badge--success">
                                                {{__('Activated')}}
                                            </span>
                                                </td>
                                            @else
                                                <td>
                                            <span class="kt-badge kt-badge--inline kt-badge--danger">
                                                {{__('Not Activated')}}
                                            </span>
                                                </td>
                                            @endif
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6"> {{__('There is no records')}}</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end:: Widgets/New Users-->
        </div>
    </div>
    <!--End::Row-->

@endsection
