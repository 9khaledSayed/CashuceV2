@extends('layouts.dashboard')
@section('content')
    <!-- begin:: Content Head -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    {{__('Import')}}
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
                    {{__('Import')}}
                </h3>
            </div>
        </div>
        @include('layouts.dashboard.parts.errorSection')

    <!--begin::Form-->

        <div class="kt-portlet__body">
                @if(session('message'))
                    <div class="alert alert-solid-success alert-bold fade show kt-margin-t-20 kt-margin-b-40" role="alert">
                        <div class="alert-icon"><i class="fa fa-check-circle"></i></div>
                        <div class="alert-text">{{session('message')}}</div>
                        <div class="alert-close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"><i class="la la-close"></i></span>
                            </button>
                        </div>
                    </div>
                @endif
                <form class="kt-form kt-form--label-right" method="post" action="{{route('dashboard.employees.import')}}" enctype="multipart/form-data" style="width: 80%; margin: auto">
                    @csrf
                    <div class="form-group row">
                        <label for="customFile" class="col-form-label col-lg-2 col-sm-12">{{__('Excel File')}} *</label>
                        <div class="col-lg-6 col-md-9 col-sm-12">
                            <div></div>
                            <div class="custom-file">
                                <input type="file" name="excel_file" class="custom-file-input" id="customFile">
                                <label class="custom-file-label text-center" for="customFile">{{__('Choose file')}}</label>
                            </div>
                        </div>
                        <a href="{{asset('/system_files/templateExcel.xlsx')}}" class="btn btn-outline-brand btn-elevate btn-pill m-auto d-flex align-content-center flex-wrap">
                            <i class="flaticon-download-1"></i> {{__('Download Template')}}
                        </a>
                    </div>
                    <div class="kt-portlet__foot" style="text-align: center">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-primary submit-end-service">{{__('Import')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        <!--end::Form-->
    </div>

    <!--end::Portlet-->
@endsection
