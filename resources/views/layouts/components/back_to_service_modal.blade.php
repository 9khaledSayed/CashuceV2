<!--begin::Modal-->
<div class="modal fade" id="back-to-service" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('Back To Service')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <!--begin::Form-->
                <form class="kt-form kt-form--label-right back-to-service-form" method="POST" action="">
                    <div class="kt-portlet__body">

                        <div class="form-group row">
                            <label for="example-text-input" class="col-form-label col-lg-3 col-sm-12">{{__('Working Start Day')}}</label>
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                <div class="input-group date">
                                    <input name="contract_start_date" value="{{old('contract_start_date')}}" type="text" class="form-control datepicker" readonly/>
                                    <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar"></i>
                                                </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-form-label col-lg-3 col-sm-12">{{__('Last Working Day')}}</label>
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                <div class="input-group date">
                                    <input name="contract_end_date" value="{{old('contract_end_date')}}" type="text" class="form-control datepicker" readonly/>
                                    <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar"></i>
                                                </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot" style="text-align: center">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-primary submit-back-to-service">{{__('confirm')}}</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('back')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
</div>

<!--end::Modal-->