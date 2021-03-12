@extends('layouts.dashboard')

@section('content')
    <!-- begin:: Content Head -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    {{__('End Service')}}
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            </div>
            <div class="kt-subheader__toolbar">
                <a href="#" class="">
                </a>
                <a href="{{route('dashboard.decisions.index')}}" class="btn btn-secondary">
                    {{__('Back')}}
                </a>
            </div>
        </div>
    </div>
    <!-- end:: Content Head -->
    <div class="kt-portlet kt-portlet--responsive-mobile">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="flaticon-file-1 kt-font-brand"></i>
                    </span>
                <h3 class="kt-portlet__head-title kt-font-brand">
                    {{__('Details')}}
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">

            </div>
        </div>

        <div class="kt-portlet__body">

            <div id="info-div" class="col-lg-12  mt-5" >
                <div class="kt-section kt-section--first">
                    <h3 class="kt-section__title text-center">1. {{__('Employee Information')}}</h3>
                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >
                                    <strong>{{__('Employee Number')}}</strong>
                                </label>
                                <p class="emp_num">{{$results['emp_num']}}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >
                                    <strong>{{__('Employee Name')}}</strong>
                                </label>
                                <p class="emp_name">{{$results['emp_name']}}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>
                                    <strong>{{__('Joined Date')}}</strong>
                                </label>
                                <p class="emp_joined_date">{{$results['emp_joined_date']}}</p>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="kt-separator kt-separator--space-lg kt-separator--portlet-fit"></div>

                <div class="kt-section">
                    <h3 class="kt-section__title text-center">2. {{__('Years Of Service')}}</h3>
                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>
                                    <strong>{{__('Years')}}</strong>
                                </label>
                                <p class="years">{{$results['years']}}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="Months">
                                    <strong>{{__('Months')}}</strong>
                                </label>
                                <p class="months">{{$results['months']}}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>
                                    <strong>{{__('Days')}}</strong>
                                </label>
                                <p class="days">{{$results['days']}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kt-separator  kt-separator--space-lg kt-separator--portlet-fit"></div>
                <div class="kt-section">
                    <h3 class="kt-section__title text-center">3. {{__('Entitlements')}}</h3>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="form-group m-form__group row bg-light kt-margin-0">
                                <label class="col-lg-5 col-form-label">
                                    {{__('End of service reward')}}
                                </label>
                                <div class="col-lg-6">
                                    <p class="form-control-plaintext service_reward">
                                        {{number_format($results['service_reward'], 2)}}
                                    </p>
                                </div>
                            </div>

                            <div class="form-group m-form__group row kt-margin-0">
                                <label class="col-lg-5 col-form-label">
                                    {{__('Leave Balance')}}
                                </label>
                                <div class="col-lg-6">
                                    <p class="form-control-plaintext leave_balance">
                                        {{$results['leave_balance']}}
                                    </p>
                                </div>
                            </div>

                            <div class="form-group m-form__group row bg-light kt-margin-0">
                                <label class="col-lg-5 col-form-label">
                                    {{__('Benefit')}}
                                </label>
                                <div class="col-lg-6">
                                    <p class="form-control-plaintext benefit">
                                        {{number_format($results['benefit'], 2)}}
                                    </p>
                                </div>
                            </div>
                            {{--                                    <div class="form-group m-form__group row kt-margin-0">--}}
                            {{--                                        <label class="col-lg-5 col-form-label">--}}
                            {{--                                            {{__('Debets')}}--}}
                            {{--                                        </label>--}}
                            {{--                                        <div class="col-lg-6">--}}
                            {{--                                            <p class="form-control-plaintext debets">--}}

                            {{--                                            </p>--}}
                            {{--                                        </div>--}}
                            {{--                                    </div>--}}

                            <div class="form-group m-form__group row kt-margin-0">
                                <label class="col-lg-5 col-form-label kt-font-bold">
                                    {{__('Total')}}
                                </label>
                                <div class="col-lg-6">
                                    <p class="form-control-plaintext kt-font-bold total" >
                                        {{number_format($results['total'], 2)}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <!--Begin::Row-->



@endsection

