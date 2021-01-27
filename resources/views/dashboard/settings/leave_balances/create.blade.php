@extends('layouts.dashboard')

@push('styles')

@endpush

@section('content')
    <!-- begin:: Content Head -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    {{__('Leave Balances')}}
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            </div>
            <div class="kt-subheader__toolbar">
                <a href="#" class="">
                </a>
                <a href="{{route('dashboard.leave_balances.index')}}" class="btn btn-secondary">
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
                    {{__('New Leave Balance')}}
                </h3>
            </div>
        </div>

        @include('layouts.dashboard.parts.errorSection')
        <!--begin::Form-->
        <form class="kt-form kt-form--label-right" method="POST" action="{{route('dashboard.leave_balances.store')}}"
        style="width: 80%; margin: auto">
            @csrf
            <div class="kt-portlet__body">

                <div class="form-group row">
                    <label for="days_per_year" class="col-form-label col-lg-3 col-sm-12">{{__('Days Per Year')}} *</label>
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        <input name="days_per_year"
                               id="days_per_year"
                               value="{{old('days_per_year')}}"
                               class="form-control @error('days_per_year') is-invalid @enderror"
                               type="text">
                    </div>
                </div>
            </div>
            <div class="kt-portlet__foot" style="text-align: center">
                <div class="kt-form__actions">
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary">{{__('confirm')}}</button>
                            <a href="{{route('dashboard.leave_balances.index')}}" class="btn btn-secondary">{{__('back')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!--end::Portlet-->

@endsection