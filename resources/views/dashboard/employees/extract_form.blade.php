@extends('layouts.dashboard')
@section('content')
    <!-- begin:: Content Head -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    {{__('Export')}}
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            </div>
            <div class="kt-subheader__toolbar">
                <a href="#" class="">
                </a>
                <a href="{{route('dashboard.employees.index')}}" class="btn btn-secondary">
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
                    {{__('EXport')}}
                </h3>
            </div>
        </div>
    @include('layouts.dashboard.parts.errorSection')
    <!--begin::Form-->
        <form class="kt-form kt-form--label-right" method="GET" action="{{route('dashboard.employees.export')}}" style="width: 80%; margin: auto">
            @csrf
            <div class="kt-portlet__body">
                <div class="form-group row">
                    <div class="col-12">
                        <label for="work_days">{{__('Employees Data')}} *</label>
                        <select class="form-control kt-selectpicker"
                                name="employees_data[]"
                                id="employees_data"
                                multiple="multiple"
                                title="{{__('Select')}}">
                            <option
                                    value="fname_ar"
                                    data-content="<span class='kt-badge kt-badge--brand kt-badge--inline kt-badge--rounded'>{{__('First Name Arabic')}}</span>"
                            >{{__('First Name Arabic')}}</option>

                            <option
                                    value="sname_ar"
                                    data-content="<span class='kt-badge kt-badge--brand kt-badge--inline kt-badge--rounded'>{{__('Second Name Arabic')}}</span>"
                            >{{__('Second Name Arabic')}}</option>

                            <option
                                    value="city_name_ar"
                                    data-content="<span class='kt-badge kt-badge--brand kt-badge--inline kt-badge--rounded'>{{__('City Name Arabic')}}</span>"
                            >{{__('City Name Arabic')}}</option>

                            <option
                                    value="fname_en"
                                    data-content="<span class='kt-badge kt-badge--brand kt-badge--inline kt-badge--rounded'>{{__('First Name Engilsh')}}</span>"
                            >{{__('First Name Engilsh')}}</option>

                            <option
                                    value="sname_en"
                                    data-content="<span class='kt-badge kt-badge--brand kt-badge--inline kt-badge--rounded'>{{__('Second Name English')}}</span>"
                            >{{__('Second Name English')}}</option>

                            <option
                                    value="city_name_en"
                                    data-content="<span class='kt-badge kt-badge--brand kt-badge--inline kt-badge--rounded'>{{__('City Name English')}}</span>"
                            >{{__('City Name English')}}</option>

                        </select>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__foot" style="text-align: center">
                <div class="kt-form__actions">
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary submit-end-service">{{__('Export')}}</button>
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
        $(function (){
            $(".kt-selectpicker").selectpicker();
        });
    </script>
@endpush
