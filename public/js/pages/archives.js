"use strict";

// Class definition
var KTContactsAdd = function () {
    // Base elements
    var wizardEl;
    var formEl;
    var validator;
    var saveValidator;
    var wizard;
    var avatar;
    let selectContractPeriod = $("select[name='contract_period']");
    var contractEndDate = $("input[name='contract_end_date']");
    let messages = {
        'ar': {
            "please fill the required data":"الرجاء مليء الحقول المطلوبة",
            "The operation has been done successfully !":"لقد تمت العملية بنجاح !",
        }
    };
    let locator = new KTLocator(messages);
    // Private functions
    var initWizard = function () {
        // Initialize form wizard
        wizard = new KTWizard('kt_contacts_add', {
            startStep: 1, // initial active step number
            clickableSteps: true  // allow step clicking
        });

        // Validation before going to next page
        wizard.on('beforeNext', function(wizardObj) {
            if (validator.form() !== true) {
                wizardObj.stop();  // don't go to the next step
            }
        })

        // Change event
        wizard.on('change', function(wizard) {
            KTUtil.scrollTop();
        });
    }

    var initValidation = function() {
        validator = formEl.validate({
            // Validate only visible fields
            ignore: ":hidden",

            // Validation rules
            rules: {
                // Step 1
                fname_arabic: {
                    required: true
                },
                sname_arabic: {
                    required: true
                },
                lname_arabic: {
                    required: true,
                },
                fname_english: {
                    required: true
                },
                sname_english: {
                    required: true
                },
                lname_english: {
                    required: true
                },
                birthdate: {
                    required: true,
                    date:true
                },
                test_period: {
                    required: true,
                    number: true
                },
                city_name_ar: {
                    required: true,
                },
                cityName_en: {
                    required: true,
                },
                nationality_id: {
                    required: true
                },
                id_num: {
                    required: true,
                    number: true
                },
                emp_num: {
                    required: true
                },
                contract_start_date: {
                    required: true,
                    date:true
                },
                role_id: {
                    required: true
                },
                leave_balance: {
                    required: true
                },
                work_shift_id: {
                    required: true
                },
                branch_id: {
                    required: true
                },
                contract_type: {
                    required: true
                },
                start_date: {
                    required: true,
                    date:true
                },
                contract_period: {
                    required: true,
                    number:true,
                },
                phone: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                },
                password_confirmation: {
                    required: true,
                },
                basic_salary: {
                    required: true
                }
            },

            // Display error
            invalidHandler: function(event, validator) {
                KTUtil.scrollTop();

                swal.fire({
                    "title": "",
                    "text": locator.__("please fill the required data"),
                    "type": "error",
                    "buttonStyling": false,
                    "confirmButtonClass": "btn btn-brand btn-sm btn-bold"
                });
            },

            // Submit valid form
            submitHandler: function (form) {

            }
        });
    }

    var initSubmit = function() {
        var btn = formEl.find('[data-ktwizard-type="action-submit"]');

        btn.on('click', function(e) {
            e.preventDefault();

            if (validator.form()) {
                // See: src\js\framework\base\app.js
                KTApp.progress(btn);
                //KTApp.block(formEl);

                // See: http://malsup.com/jquery/form/#ajaxSubmit
                formEl.ajaxSubmit({
                    data : {
                        is_submitted : 1
                    },
                    success: function(response) {
                        KTApp.unprogress(btn);
                        //KTApp.unblock(formEl);
                        swal.fire({
                            "title": "",
                            "text": locator.__("The operation has been done successfully !"),
                            "type": "success",
                            "confirmButtonClass": "btn btn-secondary"
                        },function (isConfirm) {
                            if(isConfirm){
                                window.location.replace("/dashboard/archives");
                            }
                        });

                    }
                    ,error:function (err){
                        KTApp.unprogress(btn);
                        let response = err.responseJSON;
                        let errors = '';
                        $.each(response.errors, function( index, value ) {
                            errors += value + '\n';
                        });
                        swal.fire({
                            title: locator.__(response.message),
                            text: errors,
                            type: 'error'
                        });
                    }
                });
            }
        });
    }

    var initSave = function() {
        var btn = formEl.find('[id="action-save"]');

        btn.on('click', function(e) {
            e.preventDefault();
            // See: src\js\framework\base\app.js
            KTApp.progress(btn);

            formEl.ajaxSubmit({
                success: function(response) {
                    KTApp.unprogress(btn);
                    //KTApp.unblock(formEl);
                    swal.fire({
                        "title": "",
                        "text": locator.__("The operation has been done successfully !"),
                        "type": "success",
                        "confirmButtonClass": "btn btn-secondary"
                    },function (isConfirm) {
                        console.log('isoncfirmed')
                        if(isConfirm){
                            window.location.replace("/dashboard/archives");
                        }
                    });

                }
                ,error:function (err){
                    KTApp.unprogress(btn);
                    let response = err.responseJSON;
                    let errors = '';
                    $.each(response.errors, function( index, value ) {
                        errors += value + '\n';
                    });
                    swal.fire({
                        title: locator.__(response.message),
                        text: errors,
                        type: 'error'
                    });
                }
            });

        });
    }


    var initAvatar = function() {
        avatar = new KTAvatar('kt_contacts_add_avatar');
    }

    var calculateEndDate = function () {
        var contractStartDate = $("input[name='contract_start_date']").datepicker("getDate");
        var endDate = new Date();
        var contractPeriodValue = selectContractPeriod.val();


        if(contractPeriodValue !== '' && contractStartDate){

            endDate.setMonth(contractStartDate.getMonth());
            endDate.setDate(contractStartDate.getDate() - 1);
            endDate.setFullYear(contractStartDate.getFullYear() + (contractPeriodValue/12));

            contractEndDate.datepicker("setDate", endDate);

        }
    }


    var onChangeContractPeriodOrStartDate = function () {

        $("#startDateInput, #contractPeriodSelect").on('change', function () {
            if( selectContractPeriod.val() === '' ){
                contractEndDate.datepicker("setDate", '');
                contractEndDate.attr("disabled", false);
                contractEndDate.css('backgroundColor','');
            }else {
                calculateEndDate();
                contractEndDate.css('backgroundColor','#AAAA');
                contractEndDate.attr("disabled", true);
            }
        })
    }

    return {
        // public functions
        init: function() {
            formEl = $('#kt_contacts_add_form');

            initWizard();
            initValidation();
            initSubmit();
            initSave();
            initAvatar();
            calculateEndDate();
            onChangeContractPeriodOrStartDate();
        }
    };
}();

jQuery(document).ready(function() {
    KTContactsAdd.init();
});
