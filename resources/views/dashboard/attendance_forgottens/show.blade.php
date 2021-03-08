@extends('layouts.dashboard')

@section('content')
    <!-- begin:: Content Head -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    {{__('Requests')}}
                </h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            </div>
            <div class="kt-subheader__toolbar">
                <a href="#" class="">
                </a>
                <a href="{{route('dashboard.requests.index')}}" class="btn btn-secondary">
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
                                            <div class="kt-badge kt-badge--xl kt-badge--success">{{ mb_substr( $employee->name() ,0,2,'utf-8')}}</div>
                                            <div class="text-center kt-font-bold kt-margin-t-5">
                                                {{$employee->job_number}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kt-user-card-v2__details">
                                        <a class="kt-user-card-v2__name" href="{{route('dashboard.employees.show', $employee)}}">
                                            {{$employee->job_number  . ' - ' . $employee->name()}}
                                        </a>
                                        <span class="kt-user-card-v2__desc">{{$employee->role->name()}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group"><label for="Request.CreatedDate"><strong>{{__('Request Date')}}</strong></label><p>
                                    {{$request->created_at->format('Y-m-d')}}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group"><label for="Request.RequestType"><strong>{{__('Request Type')}}</strong></label><p>{{$request->type()}}</p></div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="Request.WorkflowInstance.State"><strong>{{__('Status')}}</strong></label>
                                <p>
                                    <span class="kt-badge {{$request->statusClass()}} kt-badge--inline kt-badge--pill">{{$request->statusTitle()}}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-section">
                <div class="kt-section__content kt-section__content--border">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group"><label for="Date"><strong>{{__('Request Date')}}</strong></label><p>
                                    {{$request->created_at->format('Y-m-d')}}</p></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"><label for="From"><strong>{{__('Forgotten Date')}}</strong></label><p>{{$requestable->forgotten_date->format('Y-m-d')}}</p></div>
                        </div>
                    </div>


                </div>
            </div>

        </div>
        @can(['proceed_requests', 'not-company'])
        <div class="kt-portlet__foot mt-0">
            <div class="kt-section">
                <h3 class="kt-section__title">{{__('Take action')}}</h3>
                <div class="kt-section__content kt-section__content--border">
                    <!-- Begin Action Form-->
                    @include('layouts.dashboard.parts.errorSection')
                    <form method="post"   action="{{route('dashboard.requests.take_action', $request)}}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">{{__('Action')}}</label>
                                    <select name="status"  class="form-control selectpicker" >
                                        <option value="">{{__('Choose')}}</option>
                                        <option value="1">{{__('Approve')}}</option>
                                        <option value="2">{{__('Disapprove')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">{{__('Comments')}}</label>
                                    <textarea name="comment" class="form-control" rows="6">{{$request->comment}}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="kt-form__acdtions">

                            <button type="submit" class="btn btn-success">{{__('Submit')}}</button>

                            <a href="{{route('dashboard.requests.index')}}" class="btn btn-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                    <!-- Begin Action Form END-->



                </div>
            </div>

        </div>
        @endcan
    </div>
    <!--Begin::Row-->



@endsection
