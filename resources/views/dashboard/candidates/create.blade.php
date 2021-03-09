@extends('layouts.dashboard')


@section('content')
    <!-- begin:: Content Head -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    {{__('Candidates')}}
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            </div>
            <div class="kt-subheader__toolbar">
                <a href="#" class="">
                </a>
                <a href="{{route('dashboard.candidates.index')}}" class="btn btn-secondary">
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
                    {{__('New Candidate')}}
                </h3>
            </div>
        </div>

    @include('layouts.dashboard.parts.errorSection')
    <!--begin::Form-->
        <form class="kt-form kt-form--label-right" id="form_candidate" method="POST" action="{{route('dashboard.candidates.store')}}"
              style="width: 80%; margin: auto">
            @csrf
            <div class="kt-portlet__body">
                <div class="kt-section divided box">
                    <div class="kt-section__body">
                        <h3 class="kt-section__title kt-section__title-lg">{{__('For Supplier')}}:</h3>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>{{__('Full Name English')}} *</label>
                                <input name="name_en"
                                       value="{{old('name_en')}}"
                                       class="form-control @error('name_en') is-invalid @enderror"
                                       type="text">
                            </div>
                            <div class="col-lg-6">
                                <label>{{__('Birthdate')}} *</label>
                                <div class="input-group date">
                                    <input name="birthdate" type="text" value="{{old('birthdate')}}" class="form-control datepicker" readonly/>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>{{__('Iqama Number')}} *</label>
                                <input name="id_num" type="number" min="0" value="{{old('id_num')}}" class="form-control @error('id_num') is-invalid @enderror">
                            </div>
                            <div class="col-lg-6">
                                <label>{{__('Nationality')}} *</label>
                                <select name="nationality_id"
                                        data-size="7"
                                        data-live-search="true"
                                        data-show-subtext="true"
                                        class="form-control kt-selectpicker" title="Choose">
                                    @foreach($nationalities as $nationality)
                                        <option value="{{$nationality->id}}"
                                                @if(old('nationality_id') == $nationality->id) selected @endif
                                        >{{$nationality->name()}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>{{__('Profession In Iqama')}}</label>
                                <input name="residence_profession" value="{{old('residence_profession')}}" class="form-control @error('residence_profession') is-invalid @enderror">
                            </div>
                            <div class="col-lg-6">
                                <label>{{__('Interview Date')}} *</label>
                                <div class="input-group date">
                                    <input name="interview_date" value="{{old('interview_date')}}" type="text" class="form-control datepicker" readonly/>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label>{{__('Actual Sponsor')}}</label>
                                <input name="enterprise" value="{{old('enterprise')}}" class="form-control @error('enterprise') is-invalid @enderror">
                            </div>
                        </div>
                        <div class="form-group row ">
                        <div class="col-12">
                            <label>{{('Skills')}}</label>
                            <div class="kt-checkbox-inline">
                                @foreach($skills as $skill)

                                    <label class="kt-checkbox kt-checkbox--bold kt-checkbox--success">
                                        <input type="checkbox"
                                               value="{{$skill}}"
                                               name="skills[]"
                                                {{ (collect(old('skills'))->contains($skill)) ? 'checked':'' }}
                                        > {{$skill}}
                                        <span></span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    </div>
                </div>

                <div class="form-group row ">
                    <div class="col-lg-12">
                        <label for="work_days">{{__('Documents')}}</label>
                        <div class="dropzone dropzone-default" id="kt_dropzone_1">
                            <div class="dropzone-msg dz-message needsclick">
                                <h3 class="dropzone-msg-title">{{__('Drop files here or click to upload.')}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__foot" style="text-align: center">
                <div class="kt-form__actions">
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary">{{__('confirm')}}</button>
                            <a href="{{route('dashboard.candidates.index')}}" class="btn btn-secondary">{{__('back')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!--end::Portlet-->
@endsection

@push('scripts')
    <script src="{{asset('js/components/fileUploader.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/pages/candidates.js')}}" type="text/javascript"></script>
@endpush