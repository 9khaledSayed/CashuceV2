@extends('layouts.dashboard')

@section('content')
    <!-- begin:: Content Head -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    {{__('Payrolls')}}
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
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{__('Salary Details')}}
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div id="payslip-details-div">
                <div class="kt-widget kt-widget--user-profile-1 employee-card employee-card-medium" style="padding-bottom:unset;">
                    <div class="kt-widget__head">
                        <div class="kt-widget__media">
                            <div class="kt-badge kt-badge--xl kt-badge--success">SA</div>
                            <div class="text-center kt-font-bold kt-margin-t-5">
                                {{$salary->employee->job_number}}
                            </div>
                        </div>
                        <div class="kt-widget__content">
                            <div class="kt-widget__section">
                                <a href="#" class="kt-widget__username">
                                    {{$salary->employee->name()}}
                                </a>
                                <span class="kt-widget__subtitle">
                                   {{$salary->employee->role->name()}}
                                </span>
                                <span class="kt-widget__subtitle">
                                    {{$salary->employee->created_at}}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="kt-widget4">
                    <div class="kt-widget4__item">
                        <span class="kt-widget4__icon">
                            <i class="fa fa-plus-circle kt-font-success"></i>
                        </span>
                        <a href="#" class="kt-widget4__title kt-widget4__title--light">
                            {{__('Basic Salary')}}
                        </a>
                        <span class="kt-widget4__number kt-font-success">
                            {{$salary->employee->salary . __(' S.R')}}
                        </span>
                    </div>
                </div>
                <div class="kt-widget kt-widget--user-profile-3">
                    <div class="kt-widget__bottom">
                        <div class="kt-widget__item">
                            <div class="kt-widget__icon">
                                <i class="flaticon-coins kt-font-danger"></i>
                            </div>
                            <div class="kt-widget__details">
                                <span class="kt-widget__title">
                                    {{__('Total Deductions')}}
                                </span>
                                <span class="kt-widget__value kt-font-danger">
                                     {{$salary->employee->deductions() . __(' S.R')}}
                                </span>
                            </div>
                        </div>
                        <div class="kt-widget__item">
                            <div class="kt-widget__icon">
                                <i class="flaticon-coins kt-font-brand"></i>
                            </div>
                            <div class="kt-widget__details">
                                <span class="kt-widget__title">
                                    {{__('Net Pay')}}
                                </span>
                                <span class="kt-widget__value kt-font-brand">
                                    {{$salary->net_salary . __(' S.R')}}
                                </span>
                            </div>
                        </div>
                        <div class="kt-widget__item">
                            <div class="kt-widget__icon">
                                <i class="flaticon-calendar"></i>
                            </div>
                            <div class="kt-widget__details">
                                <span class="kt-widget__title">
                                    {{__('Work Days')}}
                                </span>
                                <span class="kt-widget__value kt-font-brand">
                                     {{$salary->work_days}}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>





    <!--end::Portlet-->
@endsection

@push('scripts')
    <script src="{{asset('js/datatables/my_salaries.js')}}" type="text/javascript"></script>
@endpush
