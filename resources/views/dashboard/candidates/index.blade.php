@extends('layouts.dashboard')

@section('content')
    <!-- begin:: Content Head -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    {{__('Dashboard')}}
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
    <!-- end:: Content Head -->
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon2-user-1"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    {{__('Candidates')}}
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <a href="{{route('dashboard.candidates.create')}}" class="btn btn-brand btn-icon-sm ml-2 mr-2">
                        <i class="fa fa-plus"></i> {{__('Add New')}}
                    </a>
                    <a href="{{route('dashboard.candidates.index')}}" class="btn btn-primary btn-icon-sm ml-2 mr-2">
                        <i class="fa fa-users"></i> {{__('All Candidates')}}
                    </a>
                    <a href="{{route('dashboard.candidates.index' ,['req_parameter' => 'departments_candidates'])}}" class="btn btn-warning btn-icon-sm ml-2 mr-2">
                        <i class="fa fa-users"></i> {{__('Departments Candidates')}}
                    </a>
                    <a href="{{route('dashboard.candidates.index' ,['req_parameter' => 'training_candidates'])}}" class="btn btn-success btn-icon-sm ml-2 mr-2">
                        <i class="fa fa-users"></i> {{__('Candidates In Training')}}
                    </a>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">

            <!--begin: Search Form -->
            <div class="kt-form kt-form--label-right kt-margin-t-20 kt-margin-b-10">
                <div class="row align-items-center">
                    <div class="col-xl-8 order-2 order-xl-1">
                        <div class="row align-items-center">
                            <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                                <div class="kt-input-icon kt-input-icon--left">
                                    <input type="text" class="form-control" placeholder="{{__('Search...')}}" id="generalSearch">
                                    <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                        <span><i class="la la-search"></i></span>
                                    </span>
                                </div>
                            </div>
                            @if(!auth()->user()->isSupervisor())
                                <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                                    <div class="kt-form__group kt-form__group--inline">
                                        <div class="kt-form__label">
                                            <label>{{__('Department')}}:</label>
                                        </div>
                                        <div class="kt-form__control">
                                            <select class="form-control selectpicker" id="kt_form_department">
                                                <option value="">{{__('All')}}</option>
                                                @forelse($departments as $department)
                                                    <option value="{{$department->name()}}">{{$department->name()}}</option>
                                                @empty
                                                    <option disabled>{{__('There is no departments in your company')}}</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                                <div class="kt-form__group kt-form__group--inline">
                                    <div class="kt-form__label">
                                        <label>{{__('Status')}}:</label>
                                    </div>
                                    <div class="kt-form__control">
                                        <select class="form-control selectpicker" id="kt_form_status">
                                            <option value="">{{__('All')}}</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Approved">HR-Approved</option>
                                            <option value="Disapproved">Disapproved</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 order-1 order-xl-2 kt-align-right">
                        <a href="#" class="btn btn-default kt-hidden">
                            <i class="la la-cart-plus"></i> New Order
                        </a>
                        <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg d-xl-none"></div>
                    </div>
                </div>
            </div>

            <!--end: Search Form -->
        </div>
        <div class="kt-portlet__body kt-portlet__body--fit">

            <!--begin: Datatable -->
            <div class="kt-datatable" id="ajax_data"></div>

            <!--end: Datatable -->
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{asset('js/datatables/candidates.js?<%=ts %>')}}" type="text/javascript"></script>
@endpush
