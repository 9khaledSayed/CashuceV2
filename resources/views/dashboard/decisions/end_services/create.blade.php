@extends('layouts.dashboard')
@push('styles')
    <link href="{{asset('assets/css/pages/wizard/wizard-1' . (App::isLocale('ar')?'.rtl':'') . '.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    {{__('Decisions')}}
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            </div>
            <div class="kt-subheader__toolbar">
                <a href="#" class="">
                </a>
{{--                <a href="{{route('dashboard.decisions.terminated_employees')}}" class="btn btn-secondary">--}}
{{--                    {{__('Back')}}--}}
{{--                </a>--}}
            </div>
        </div>
    </div>


    <div class="kt-portlet kt-portlet--responsive-mobile">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="fa fa-ban kt-font-brand"></i>
                    </span>
                <h3 class="kt-portlet__head-title kt-font-brand">
                    {{__('End of service for employee')}}
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">

            </div>
        </div>

        @include('layouts.dashboard.parts.errorSection')

        <form method="post"  action="{{route('dashboard.decisions.end_services.store')}}">
            @csrf
            <div class="kt-portlet__body">
                <div class="row text-center m-3">
                    <div class="col-lg-4">
                        <label for="kt_select2">{{__('Employee Name / ID')}} *</label>
                        <select class="form-control selectpicker"
                                name="employee_id"
                                title="{{__('choose')}}">
                            @foreach($employees as $employee)
                                <option value="{{$employee->id}}">{{$employee->name()}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-4">
                        <label for="kt_select2_1">{{__('Termination reason')}} *</label>
                        <select class="form-control selectpicker"
                                name="reason"
                                title="{{__('choose')}}">
                            @foreach($reasons as $key => $reason)
                                <option value="{{$key}}">{{__($reason)}}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label for="termination_date">{{__('Termination Date')}} *</label>
                        <div class="input-group date">
                            <input name="termination_date" type="text" class="form-control datepicker" readonly/>
                            <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="la la-calendar"></i>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div id="info-div" class="col-lg-12  mt-5" style="display: none">
                        <div class="kt-section kt-section--first">
                            <h3 class="kt-section__title">1. {{__('Employee Information')}}</h3>
                            <div class="row text-center">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label >
                                            <strong>{{__('Employee Number')}}</strong>
                                        </label>
                                        <p class="emp_num"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label >
                                            <strong>{{__('Employee Name')}}</strong>
                                        </label>
                                        <p class="emp_name"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>
                                            <strong>{{__('Joined Date')}}</strong>
                                        </label>
                                        <p class="emp_joined_date"></p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="kt-separator kt-separator--space-lg kt-separator--portlet-fit"></div>

                        <div class="kt-section">
                            <h3 class="kt-section__title">2. {{__('Years Of Service')}}</h3>
                            <div class="row text-center">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>
                                            <strong>{{__('Years')}}</strong>
                                        </label>
                                        <p class="years"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Months">
                                            <strong>{{__('Months')}}</strong>
                                        </label>
                                        <p class="months"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>
                                            <strong>{{__('Days')}}</strong>
                                        </label>
                                        <p class="days"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="kt-separator  kt-separator--space-lg kt-separator--portlet-fit"></div>
                        <div class="kt-section">
                            <h3 class="kt-section__title">3. {{__('Entitlements')}}</h3>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <div class="form-group m-form__group row bg-light kt-margin-0">
                                        <label class="col-lg-5 col-form-label">
                                            {{__('End of service reward')}}
                                        </label>
                                        <div class="col-lg-6">
                                            <p class="form-control-plaintext service_reward">

                                            </p>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row kt-margin-0">
                                        <label class="col-lg-5 col-form-label">
                                            {{__('Leave Balance')}}
                                        </label>
                                        <div class="col-lg-6">
                                            <p class="form-control-plaintext leave_balance">

                                            </p>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row bg-light kt-margin-0">
                                        <label class="col-lg-5 col-form-label">
                                            {{__('Benefit')}}
                                        </label>
                                        <div class="col-lg-6">
                                            <p class="form-control-plaintext benefit">

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

                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 mt-5">
                        <label>
                            {{__('Notes')}}
                        </label>
                        <textarea rows="5" class="form-control" id="Note" name="notes"></textarea>
                        <span class="field-validation-valid" data-valmsg-for="Note" data-valmsg-replace="true"></span>
                    </div>
                </div>


            </div>
            <div class="kt-portlet__foot">
                <button type="submit" class="btn btn-brand m-btn m-btn--custom btn-sm">
                        <span>
                            <i class="fa fa-plus"></i>
                            <span>
                                {{__('Submit')}}
                            </span>
                        </span>

                </button>
                <a href="{{route('dashboard.index')}}" class="btn btn-secondary btn-sm">
                        <span>
                            <i class="fa fa-ban"></i>
                            <span>
                                {{__('Cancel')}}
                            </span>
                        </span>
                </a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(function (){
            let employee_id = $("select[name='employee_id']");
            let termination_date = $("input[name='termination_date']");
            let reason = $("select[name='reason']");

            // CSRF Token

            $("select[name='reason'], select[name='employee_id']").on('change', function(){
                endServiceReward();
            });

            termination_date.change(function (){
                endServiceReward();
            })

            function endServiceReward(){
                if(termination_date.val() !== '' && employee_id.val() !== '' && reason.val() !== ''){
                    $.ajax({
                        method: "get",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "/dashboard/decisions/end_service_reward",
                        data: {
                            "reason": reason.val(),
                            "employee_id": employee_id.val(),
                            "termination_date": termination_date.val(),
                        },
                        success:function(data){

                            $(".emp_num").text(data.emp_num);
                            $(".emp_name").text(data.emp_name);
                            $(".emp_joined_date").text(data.emp_joined_date);
                            $(".years").text(data.years);
                            $(".months").text(data.months);
                            $(".days").text(data.days);
                            $(".service_reward").text(data.service_reward.toFixed(2) + ' {{__('SAR')}}');
                            $(".leave_balance").text(data.leave_balance);
                            $(".benefit").text(data.benefit.toFixed(2) + ' {{__('SAR')}}');
                            {{--$(".debets").text(data.debets.toFixed(2) + ' {{__('SAR')}}');--}}
                            $(".total").text(data.total.toFixed(2) + ' {{__('SAR')}}');
                            $("#info-div").fadeIn(2);
                        }
                    });
                }

            }

        });
    </script>
@endpush
