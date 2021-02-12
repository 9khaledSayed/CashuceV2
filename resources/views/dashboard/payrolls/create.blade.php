@extends('layouts.dashboard')
@push('styles')
    <link href="{{asset('assets/css/pages/wizard/wizard-1' . (App::isLocale('ar')?'.rtl':'') . '.css')}}" rel="stylesheet" type="text/css" />
@endpush

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
                <a href="{{route('dashboard.payrolls.index')}}" class="btn btn-secondary">
                    {{__('Back')}}
                </a>
            </div>
        </div>
    </div>
    <!-- end:: Content Head -->

    <div class="kt-portlet" >
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{__('Add New')}}
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body kt-portlet__body--fit">
            <div class="kt-grid  kt-wizard-v1 kt-wizard-v1--white droid_font" id="kt_contacts_add" data-ktwizard-state="step-first">
               @include('layouts.dashboard.parts.errorSection')
                <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v1__wrapper">
                    <!--begin: Form Wizard Form-->
                    <form action="{{route('dashboard.payrolls.store')}}" method="post" class="kt-form" style="width: 80%" id="">
                    @csrf
                    <!--begin: Form Wizard Step 1-->
                        <div class="kt-wizard-v1__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
                            <div class="kt-section kt-section--first">
                                <div class="kt-wizard-v1__form">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="kt-section__body">
                                                <div class="kt-section">
                                                    <div class="kt-section__body">
                                                        <div class="form-group row">
                                                            <label class="col-form-label col-lg-3 col-sm-12">{{__('Date')}} *</label>
                                                            <div class="col-lg-6 col-md-9 col-sm-12">
                                                                <div class="input-group date">
                                                                    <input name="year_month" value="{{old('year_month')}}" type="text" class="form-control datepic" readonly/>
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text">
                                                                            <i class="la la-calendar"></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-form-label col-lg-3 col-sm-12">{{__('Providers')}} *</label>
                                                            <div class="col-lg-6 col-md-9 col-sm-12">
                                                                <select class="form-control @error('provider_id') is-invalid @enderror kt-selectpicker"
                                                                        id="provider_id"
                                                                        data-size="7"
                                                                        data-live-search="true"
                                                                        data-show-subtext="true" name="provider_id" title="{{__('search with name')}}">
                                                                    <option value="" selected>{{__('For Company')}}</option>
                                                                    @forelse($providers as $provider)
                                                                        <option
                                                                                value="{{$provider->id}}"
                                                                                @if($provider->id == old('provider_id')) selected @endif
                                                                        >{{$provider->job_number . ' ( ' . $provider->name() . ' )'}}</option>
                                                                    @empty
                                                                        <option disabled>{{__('There is no providers')}}</option>
                                                                    @endforelse
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-3 col-form-label">{{__('Calculation based on attendance')}}</label>
                                                            <div class="col-3">
                                                                <span class="kt-switch kt-switch--icon">
                                                                    <label>
                                                                        <input type="checkbox" @if(old('include_attendance') == "on") checked @endif name="include_attendance">
                                                                        <span></span>
                                                                    </label>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end: Form Wizard Step 1-->
                        <!--begin: Form Actions -->
                        <div class="kt-form__actions">
                            <button type="submit" class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u mx-auto" style="display: block" data-ktwizard-type="action-submit">
                                {{__('confirm')}}
                            </button>
                        </div>

                        <!--end: Form Actions -->
                    </form>

                    <!--end: Form Wizard Form-->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
{{--    <script src="{{asset('js/pages/payrolls.js')}}" type="text/javascript"></script>--}}
    <script>
        $(function (){
            // enable clear button
            $('.datepic').datepicker({
                rtl: true,
                language: appLang,
                orientation: "bottom",
                format: "yyyy-mm",
                viewMode: "months",
                minViewMode: "months"
            });
        });
    </script>
@endpush
