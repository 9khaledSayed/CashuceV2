class DropzoneClass {
    constructor(url, datatable) {
        $('#kt_dropzone_1').dropzone({
            url: url, // Set the url for your upload script location
            type:'post',
            paramName: "file", // The name that will be used to transfer the file
            maxFiles: 1,
            maxFilesize: 5, // MB
            addRemoveLinks: true,
            sending: function(file, xhr, formData) {
                formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
            },
            accept: function(file, done) {
                if (file.name == "justinbieber.jpg") {
                    done("Naha, you don't.");
                } else {
                    done();
                }
            },
            success:function (response) {
                swal.fire({
                    title: locator.__('Operation Done Successfully'),
                    type: 'success',
                    buttonsStyling: false,
                    confirmButtonText: locator.__("OK"),
                    confirmButtonClass: "btn btn-sm btn-bold btn-brand",
                });
                datatable.reload();
            }

        });
    }
}