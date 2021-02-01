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
            "Check in":"تسجيل الحضور",
            "Check out":"تسجيل الانصراف",
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
                barcode: {

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
        let barcodeInput = $("input[name='barcode']");
        let operation_show = $("textarea[name='operation_show']");


        var delay = (function(){
            var timer = 0;
            return function(callback, ms){
                clearTimeout (timer);
                timer = setTimeout(callback, ms);
            };
        })();

        barcodeInput.on("input", function() {
            delay(function(){
                if (barcodeInput.val().length < 8) {
                    $("#txtInput").val("");
                }else{
                    swal.fire({
                        title: locator.__('Loading...'),
                        onOpen: function () {
                            swal.showLoading();
                        }
                    });
                    formEl.ajaxSubmit({
                        success: function(response) {
                            //KTApp.unblock(formEl);
                            if(response.status === false){
                                swal.fire({
                                    "title": "",
                                    "text": locator.__(response.message),
                                    "type": "error",
                                    timer: 3000,
                                });
                            }else {
                                swal.fire({
                                    title: response.employee_name,
                                    text: locator.__(response.message),
                                    timer: 3000,
                                    imageUrl: response.image_url,
                                    imageWidth: 200,
                                    imageHeight: 200,
                                    animation: true
                                });

                            }

                            barcodeInput.val("")
                            operation_show.val(locator.__(locator.__(response.message)));

                        },
                        error:function (err){
                            let response = err.responseJSON;
                            let errors = '';
                            $.each(response.errors, function( index, value ) {
                                errors += value + '\n';
                            });
                            swal.fire({
                                title: locator.__(response.message),
                                text: errors,
                                type: 'error',
                                timer: 3000,
                            });
                            barcodeInput.val("");
                        }
                    });
                }
            }, 20 );
        });


        // barcodeInput.keydown(function() {
        //     if(barcodeInput.val().length === 8){
        //         console.log('done')
        //
        //     }
        //
        // });


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
    var timeDisplay = $("#time");

    function refreshTime() {
        var dateString = new Date().toLocaleString("en-US", {timeZone: "Asia/Riyadh"});
        var formattedString = dateString.replace(", ", " - ");
        timeDisplay.val(formattedString);
    }
    setInterval(refreshTime, 1000);

    KTContactsAdd.init();
});
