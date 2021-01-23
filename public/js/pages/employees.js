"use strict";

// Class definition
var KTContactsAdd = function () {
    // Base elements
    var wizardEl;
    var formEl;
    var validator;
    var wizard;
    var avatar;

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
                joined_date: {
                    required: true,
                    date:true
                },
                role_id: {
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
                    success: function(response) {
                        KTApp.unprogress(btn);
                        //KTApp.unblock(formEl);
                        if(response.status == 3){
                            swal.fire({
                                "title": "",
                                "text": response.message,
                                "type": "error",
                                "confirmButtonClass": "btn btn-secondary"
                            });
                        }else{
                            swal.fire({
                                "title": "",
                                "text": locator.__("The operation has been done successfully !"),
                                "type": "success",
                                "confirmButtonClass": "btn btn-secondary"
                            }).then(function (){
                                window.location.replace("/dashboard/employees");
                            });
                        }

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

    var initAvatar = function() {
        avatar = new KTAvatar('kt_contacts_add_avatar');
    }

    return {
        // public functions
        init: function() {
            formEl = $('#kt_contacts_add_form');

            initWizard();
            initValidation();
            initSubmit();
            initAvatar();
        }
    };
}();

jQuery(document).ready(function() {
    let select_contract = $("select[name='contract_type']");

    if(select_contract.val() == 1){
        $('#period').hide()
    }

    select_contract.change(function (){
        if($(this).val() == 1){
            $('#period').hide()
        }else{
            $('#period').show()
        }
    })

    $("input[name='contract_start_date']").on('change', function () {
        calcEndDate();
    })

    $("select[name='contract_period']").on('change', function () {
        calcEndDate();
    })


    function calcEndDate() {
        var contractStartDate = $("input[name='contract_start_date']").val();
        var contractPeriod = $("select[name='contract_period']").val();
        var startDate = new Date(contractStartDate);

        if(contractPeriod !== '' && contractStartDate !== ''){

            let month = startDate.getMonth();
            let day = startDate.getDate();
            let year = startDate.getFullYear() + (contractPeriod/12);

            $("input[name='contract_end_date']").val(year + '-' + month + '-' + day);
        }
    }

    KTContactsAdd.init();

});
