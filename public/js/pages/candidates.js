$(function () {
    //
    var fileUploader = new FileUploader();
    $("button[type='submit']").on("click", function (e) {
        e.preventDefault();

        $("#form_candidate").ajaxSubmit({
            success:function (response) {
                var candidateID = response.id;

                fileUploader.uploadFile("/dashboard/candidates/" + candidateID + "/upload_document");

                swal.fire({
                    title: locator.__('Operation Done Successfully'),
                    type: 'success',
                    buttonsStyling: false,
                    confirmButtonText: locator.__("OK"),
                    confirmButtonClass: "btn btn-sm btn-bold btn-brand",
                });
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
                    type: 'error'
                });
            }
        });
    });
})