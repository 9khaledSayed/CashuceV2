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
    <div class="kt-portlet kt-portlet--responsive-mobile">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="flaticon-file-1 kt-font-brand"></i>
                    </span>
                <h3 class="kt-portlet__head-title kt-font-brand">
                    {{__('Details')}}
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">

            </div>
        </div>

        <div class="kt-portlet__body">
            <div class="kt-section">
                <div class="kt-section__content kt-section__content--border">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="kt-user-card-v2 employee-card employee-card-small">
                                    <div class="kt-user-card-v2__pic">
                                        <div class="kt-widget__media">
                                            <div class="kt-badge kt-badge--xl kt-badge--success">{{ mb_substr( $candidate->name() ,0,2,'utf-8')}}</div>
                                        </div>
                                    </div>
                                    <div class="kt-user-card-v2__details">
                                        <a class="kt-user-card-v2__name" href="{{route('dashboard.employees.show', $candidate)}}">
                                            {{$candidate->name()}}
                                        </a>
                                        <span class="kt-user-card-v2__desc">{{isset($candidate->provider) ? $candidate->provider->name() : __('Supplier Not Found')}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group"><label><strong>{{__('Age')}}</strong></label>
                                <p>{{$candidate->birthdate->diffInYears(\Carbon\Carbon::today()) . __(' years')}}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group"><label ><strong>{{__('Interview Date')}}</strong></label>
                                <p>{{$candidate->interview_date->format('Y-m-d')}}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="Request.WorkflowInstance.State"><strong>{{__('Status')}}</strong></label>
                                <p>
                                    <span class="kt-badge {{$candidate->status_class}} kt-badge--inline kt-badge--pill">{{$candidate->status_name}}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-section">
                <div class="kt-section__content kt-section__content--border">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group"><label><strong>{{__('Nationality')}}</strong></label>
                                <p>{{$candidate->nationality_name}}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group"><label><strong>{{__('Department')}}</strong></label>
                                <p>
                                    {{$candidate->department_name}}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group"><label><strong>{{__('Section')}}</strong></label>
                                <p>{{$candidate->section_name}}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group"><label><strong>{{__('Position')}}</strong></label>
                                <p>{{$candidate->job_title}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
{{--        @can('proceed_candidates')--}}
        <div class="kt-portlet__foot mt-0">
            <div class="row">
                <div class="col-lg-6">
                    <div class="kt-section">
                    <h3 class="kt-section__title">{{__('Take action')}}</h3>
                    <div class="kt-section__content kt-section__content--border">
                        <!-- Begin Action Form-->
                        @include('layouts.dashboard.parts.errorSection')
                        <form method="post" action="{{route('dashboard.candidates.decision', $candidate)}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">{{__('Action')}}</label>
                                        <select name="status"  class="form-control selectpicker" >
                                            <option value="">{{__('Choose')}}</option>
                                            <option value="{{config('enums.candidate.pending')}}">{{__('Pending')}}</option>
                                            <option value="{{config('enums.candidate.training')}}">{{__('Training')}}</option>
                                            <option value="{{config('enums.candidate.approved')}}">{{__('Approved')}}</option>
                                            <option value="{{config('enums.candidate.disapproved')}}">{{__('Disapproved')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">{{__('Comments')}}</label>
                                        <textarea name="comments" class="form-control" rows="6">{{$candidate->comments}}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="kt-form__actions">

                                <button type="submit" class="btn btn-success">{{__('Submit')}}</button>

                                <a href="{{route('dashboard.candidates.index')}}" class="btn btn-secondary">
                                    Cancel
                                </a>
                            </div>
                        </form>
                        <!-- Begin Action Form END-->
                    </div>
                </div>
                </div>
                <div class="col-lg-6">
                    <div class="kt-section">
                    <h3 class="kt-section__title">{{__('Documents')}}</h3>
                    <div class="kt-section__content ">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>{{__('File Name')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($candidate->documents as $document)
                                <tr>
                                    <td>{{$document->file_name}}</td>
                                    <td>
                                        <a href="/dashboard/documents/{{$document->id}}/download" class="btn btn-sm btn-primary m-btn m-btn--icon">
                                            <i class="fa fa-download"></i>{{__('Download')}}
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">{{__('There is no records')}}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
            </div>
            </div>
{{--        @endcan--}}
    </div>
    <!--Begin::Row-->



@endsection
