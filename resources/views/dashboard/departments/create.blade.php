@extends('layouts.dashboard')
@section('content')
    <!-- begin:: Content Head -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    {{__('Departments')}}
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            </div>
            <div class="kt-subheader__toolbar">
                <a href="#" class="">
                </a>
                <a href="{{route('dashboard.departments.index')}}" class="btn btn-secondary">
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
                    {{__('New Department')}}
                </h3>
            </div>
        </div>
    @include('layouts.dashboard.parts.errorSection')
    <!--begin::Form-->
        <form class="kt-form kt-form--label-right" method="POST" action="{{route('dashboard.departments.store')}}">
            @csrf
            <div class="kt-portlet__body">
                <div class="form-group row">
                    <label for="example-text-input" class="col-form-label col-lg-3 col-sm-12">{{__('Arabic Name')}}</label>
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        <input class="form-control @error('name_ar') is-invalid @enderror"
                               type="text" value="{{ old('name_ar') }}"
                               id="example-text-input"
                               name="name_ar">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-text-input" class="col-form-label col-lg-3 col-sm-12">{{__('English Name')}}</label>
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        <input class="form-control @error('name_en') is-invalid @enderror"
                               type="text" value="{{ old('name_en') }}"
                               id="example-text-input"
                               name="name_en">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="supervisor_id" class="col-form-label col-lg-3 col-sm-12">{{__('Supervisor')}}</label>
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        <select class="form-control @error('supervisor_id') is-invalid @enderror kt-selectpicker"
                            id="supervisor_id"
                            data-size="7"
                            data-live-search="true"
                            data-show-subtext="true" name="supervisor_id" title="{{__('Select')}}">
                        <option value="">{{__('choose')}}</option>
                        @forelse($supervisors as $supervisor)
                            <option
                                    value="{{$supervisor->id}}"
                                    @if($supervisor->id == old('supervisor_id')) selected @endif
                            >{{$supervisor->name()  . '( ' . $supervisor->job_number . ' )'}}</option>
                        @empty
                            <option disabled>{{__('There is no supervisors')}}</option>
                        @endforelse
                    </select>
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
        </form>

        <!--end::Form-->
    </div>

    <!--end::Portlet-->
@endsection

