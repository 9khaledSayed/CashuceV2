@extends('layouts.dashboard')
@section('content')
    <!-- begin:: Content Head -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    {{__('Attendances')}}
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            </div>
            <div class="kt-subheader__toolbar">
                <a href="#" class="">
                </a>
                <a href="{{route('dashboard.attendances.index')}}" class="btn btn-secondary">
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
                    {{__('Edit Attendance')}}
                </h3>
            </div>
        </div>
    @include('layouts.dashboard.parts.errorSection')
    <!--begin::Form-->
        <form class="kt-form kt-form--label-right" method="POST" action="{{route('dashboard.attendances.update', $attendance)}}">
            @csrf
            @method('PUT')
            <div class="kt-portlet__body">
                    <div class="form-group row">
                        <label for="example-text-input" class="col-form-label col-lg-3 col-sm-12">{{__('Time in')}}</label>
                        <div class="col-lg-6 col-md-9 col-sm-12">
                            <div class="input-group timepicker">
                                <input class="form-control" name="time_in" value="{{ $attendance->time_in->format('h:i A') }}" id="kt_timepicker_3" readonly="" type="text">
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
                                <input class="form-control" name="time_out" value="{{ $attendance->time_out->format('h:i A')}}" id="kt_timepicker_2" placeholder="Select time in" type="text">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-clock-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                <div class="kt-portlet__foot" style="text-align: center">
                    <div class="kt-form__actions">
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary">{{__('confirm')}}</button>
                                <a href="{{route('dashboard.departments.index')}}" class="btn btn-secondary">{{__('back')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!--end::Form-->
    </div>

    <!--end::Portlet-->
@endsection

@push('scripts')
    <script>
        $(function () {
            $('#kt_timepicker_2').timepicker({
                minuteStep: 1,
                defaultTime: '',
                showSeconds: false,
                showMeridian: true,
                snapToStep: true
            });

            $('#kt_timepicker_3').timepicker({
                defaultTime: '',
                minuteStep: 1,
                showSeconds: false,
                showMeridian: true,
                snapToStep: true
            });
        })
    </script>
@endpush

