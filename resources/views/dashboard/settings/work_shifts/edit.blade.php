@extends('layouts.dashboard')
@section('content')
    <!-- begin:: Content Head -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    {{__('Work Shifts')}}
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            </div>
            <div class="kt-subheader__toolbar">
                <a href="#" class="">
                </a>
                <a href="{{route('dashboard.work_shifts.index')}}" class="btn btn-secondary">
                    {{__('Back')}}
                </a>
            </div>
        </div>
    </div>
    <!-- end:: Content Head -->
    <!--begin::Portlet-->
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{__('Update Info')}}
                </h3>
            </div>
        </div>

        @include('layouts.dashboard.parts.errorSection')
        <!--begin::Form-->
        <form class="kt-form kt-form--label-right" method="POST" action="{{route('dashboard.work_shifts.update', $workShift->id)}}"
        style="width: 80%; margin: auto">
            @method('PUT')
            @csrf
            <div class="kt-portlet__body">

                <div class="form-group row">
                    <div class="col-6">
                        <label>{{__('Name In Arabic')}} *</label>
                        <input name="name_ar"
                               value="{{old('name_ar') ?? $workShift->name_ar}}"
                               class="form-control @error('name_ar') is-invalid @enderror"
                               type="text">
                    </div>
                    <div class="col-6">
                        <label>{{__('Name In English')}} *</label>
                        <input name="name_en"
                               value="{{old('name_en') ?? $workShift->name_en}}"
                               class="form-control @error('name_en') is-invalid @enderror"
                               type="text">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12">
                        <label for="work_days">{{__('Work Days')}} *</label>
                        <select class="form-control @error('work_days')is-invalid @enderror kt-selectpicker"
                                name="work_days[]"
                                id="work_days"
                                multiple="multiple"
                                title="{{__('Select')}}">
                            @foreach($weekDays as $day)
                                <option
                                    value="{{$day}}"
                                    data-content="<span class='kt-badge kt-badge--brand kt-badge--inline kt-badge--rounded'>{{$day}}</span>"
                                    {{ (collect(old('work_days') ?? unserialize($workShift->work_days))->contains($day)) ? 'selected':'' }}
                                >{{$day}}</option>
                            @endforeach

                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <label>{{__('Shift Type')}} *</label>
                        <div class="row">
                            @foreach($shiftTypes as $type)
                                <div class="col-lg-3 @error('type') border-danger @enderror">
                                    <label class="kt-option">
                                    <span class="kt-option__control">
                                        <span class="kt-radio">
                                            <input
                                                type="radio"
                                                name="type"
                                                value="{{$type}}"
                                                @if((old('type') ?? $workShift->type) == $type) checked @endif>
                                            <span></span>
                                        </span>
                                    </span>
                                    <span class="kt-option__label">
                                        <span class="kt-option__head">
                                            <span class="kt-option__title">
                                                {{ucfirst($type)}}
                                            </span>
                                        </span>
                                    </span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-4">
                        <label>{{__('Overtime Hours')}} *</label>
                        <input name="overtime_hours"
                               value="{{old('overtime_hours') ?? $workShift->overtime_hours}}"
                               placeholder="Select time"
                               class="form-control overtime @error('overtime_hours') is-invalid @enderror"
                               type="text">
                    </div>
                    <div class="col-4">
                        <div style="width: fit-content; margin: auto">
                            <label>{{__('Is Delay Allowed')}}</label>
                            <div class="col-3">
                            <span class="kt-switch kt-switch--icon">
                                <label>
                                    <input
                                            name="is_delay_allowed"
                                            type="checkbox"
                                            @if((old('is_delay_allowed') ?? $workShift->is_delay_allowed)) checked @endif>
                                    <span></span>
                                </label>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-4" style="display: none" id="timeDelayAllowed">
                        <label>{{__('Time Delay Allowed')}} *</label>
                        <input name="time_delay_allowed"
                               value="{{old('time_delay_allowed') ?? $workShift->time_delay_allowed}}"
                               placeholder="Select time"
                               class="form-control shiftTimes @error('time_delay_allowed') is-invalid @enderror"
                               type="text">
                    </div>
                </div>

                <div class="form-group row normal box">
                    <div class="col-6">
                        <label>{{__('Shift Start Time')}} *</label>
                        <input name="shift_start_time"
                               value="{{old('shift_start_time') ?? $workShift->shift_start_time}}"
                               placeholder="Select time"
                               class="form-control shiftTimes @error('shift_start_time') is-invalid @enderror"
                               type="text">
                    </div>
                    <div class="col-6">
                        <label>{{__('Shift End Time')}} *</label>
                        <input name="shift_end_time"
                               value="{{old('shift_end_time') ?? $workShift->shift_end_time}}"
                               placeholder="Select time"
                               class="form-control endShiftTime @error('shift_end_time') is-invalid @enderror"
                               type="text">
                    </div>
                </div>
                <div class="kt-section divided box">
                    <div class="kt-section__body">
                        <h3 class="kt-section__title kt-section__title-lg">{{__('Second Work Shift')}}:</h3>
                        <div class="form-group row">
                            <div class="col-6">
                                <label>{{__('Shift Start Time')}} *</label>
                                <input name="second_shift_start_time"
                                       value="{{old('second_shift_start_time') ?? $workShift->second_shift_start_time}}"
                                       placeholder="Select time"
                                       class="form-control shiftTimes @error('second_shift_start_time') is-invalid @enderror"
                                       type="text">
                            </div>
                            <div class="col-6">
                                <label>{{__('Shift End Time')}} *</label>
                                <input name="second_shift_end_time"
                                       value="{{old('second_shift_end_time') ?? $workShift->second_shift_end_time}}"
                                       placeholder="Select time"
                                       class="form-control endShiftTime @error('second_shift_end_time') is-invalid @enderror"
                                       type="text">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row flexible once box">
                    <div class="col-6">
                        <label>{{__('Work Hours')}} *</label>
                        <input name="work_hours"
                               value="{{old('work_hours') ?? $workShift->work_hours}}"
                               class="form-control  @error('work_hours') is-invalid @enderror"
                               type="number" max="12">
                    </div>
                </div>
                <div class="form-group row once box">
                    <div class="col-6">
                        <label>{{__('Check In Time')}} *</label>
                        <input name="check_in_time"
                               value="{{old('check_in_time') ?? $workShift->check_in_time}}"
                               placeholder="Select time"
                               class="form-control shiftTimes @error('check_in_time') is-invalid @enderror"
                               type="text">
                    </div>
                </div>

            </div>
            <div class="kt-portlet__foot" style="text-align: center">
                <div class="kt-form__actions">
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary">{{__('confirm')}}</button>
                            <a href="{{route('dashboard.work_shifts.index')}}" class="btn btn-secondary">{{__('back')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!--end::Portlet-->

@endsection

@push('scripts')
    <script>
        $(function (){
            var switchBtn = $("input[name='is_delay_allowed']");
            var timeDelayAllowed = $("#timeDelayAllowed");
            var radioBtn = $("input[name='type']");

            $(".box").fadeOut()

            $('.shiftTimes').timepicker({
                defaultTime: '',
                minuteStep: 2,
                showSeconds: false,
                showMeridian: false,
            });
            $('.endShiftTime').timepicker({
                defaultTime: '',
                minuteStep: 2,
                showSeconds: false,
                showMeridian: false,
            });
            $('.overtime').timepicker({
                defaultTime: '',
                minuteStep: 2,
                showSeconds: false,
                showMeridian: false,
            });

            switchBtn.val(switchBtn.is(':checked') ? 1 : 0);
            switchBtn.is(':checked') ? timeDelayAllowed.fadeIn() : timeDelayAllowed.fadeOut();

            switchBtn.click(function () {
                $(this).is(':checked') ? timeDelayAllowed.fadeIn() : timeDelayAllowed.fadeOut();
                switchBtn.val(switchBtn.is(':checked') ? 1 : 0);
            });

            showTargetBox($("input[name='type']:checked").attr("value"))

            radioBtn.click(function(){
                var inputValue = $(this).attr("value");
                showTargetBox(inputValue)
            });

            function showTargetBox(inputValue) {

                var targetBox = $("." + inputValue);

                $(".box").not(targetBox).fadeOut();
                if(inputValue !== 'once'){
                    $(".normal").fadeIn(10);
                }
                $(targetBox).fadeIn();
            }

        });
    </script>
@endpush