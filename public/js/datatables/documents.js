"use strict";
// Class definition
var datatable;
var KTDatatableLocalSortDemo = function() {
    // Private functions
    var messages = {
        'ar': {
            "Employee":"الموظف",
            "Manager": "المدير المباشر",
            "Description": "الوصف",
            "Forward to employee": "إعادة توجيه إلي الموظف",
            "Created": "تاريخ البلاغ",
            "Violation Date": "تاريخ المخالفة",
            "Actions": "الاجراءات",
            'Are you sure to delete this item?': "هل انت متأكد أنك تريد مسح هذا العنصر؟",
            'Item Deleted Successfully': "تم مسح العنصر بنجاح",
            'Yes, Delete!': "نعم امسح!",
            'No, cancel': "لا الغِ",
            'OK': "تم",
            'Loading...': "تحميل...",
            'Error!': "خطأ!",
            'Deleted!': "تم المسح!",
            'Show': "عرض",
            'Edit Info': "تعديل البيانات",
            'Delete': "مسح",
        }
    };

    var locator = new KTLocator(messages);

    // basic demo
    var demo = function() {

        datatable = $('.kt-datatable').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'GET',
                        url: '/dashboard/documents',
                    },
                },
                pageSize: 10,
                serverPaging: true,
                serverFiltering: false,
                serverSorting: true,
                saveState: tablesSaveStatus,
            },

            // layout definition
            layout: {
                scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
                footer: false, // display/hide footer
            },

            // column sorting
            sortable: true,

            pagination: true,

            search: {
                input: $('#generalSearch'),
                delay: 400,
            }, rows: {
                afterTemplate: function (row, data, index) {
                    row.find('.delete-item').on('click', function () {
                        swal.fire({
                            buttonsStyling: false,

                            html: locator.__("Are you sure to delete this item?"),
                            type: "info",

                            confirmButtonText: locator.__("Yes, Delete!"),
                            confirmButtonClass: "btn btn-sm btn-bold btn-brand",

                            showCancelButton: true,
                            cancelButtonText: locator.__("No, cancel"),
                            cancelButtonClass: "btn btn-sm btn-bold btn-default"
                        }).then(function (result) {
                            if (result.value) {
                                swal.fire({
                                    title: locator.__('Loading...'),
                                    onOpen: function () {
                                        swal.showLoading();
                                    }
                                });
                                $.ajax({
                                    method: 'DELETE',
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    url: '/dashboard/reports/' + data.id,
                                    error: function (err) {
                                        if (err.hasOwnProperty('responseJSON')) {
                                            if (err.responseJSON.hasOwnProperty('message')) {
                                                swal.fire({
                                                    title: locator.__('Error!'),
                                                    text: locator.__(err.responseJSON.message),
                                                    type: 'error'
                                                });
                                            }
                                        }
                                        console.log(err);
                                    }
                                }).done(function (res) {
                                    swal.fire({
                                        title: locator.__('Deleted!'),
                                        text: locator.__(res.message),
                                        type: 'success',
                                        buttonsStyling: false,
                                        confirmButtonText: locator.__("OK"),
                                        confirmButtonClass: "btn btn-sm btn-bold btn-brand",
                                    });
                                    datatable.reload();
                                });
                            }
                        });
                    });
                }
            },

            // columns definition
            columns: [
                {
                    field: 'id',
                    title: '#',
                    sortable: 'asc',
                    width: 30,
                    type: 'number',
                    selector: false,
                    textAlign: 'center',
                }, {
                    field: 'file_name',
                    title: locator.__('File Name'),
                    textAlign: 'center',
                }, {
                    field: 'Actions',
                    title: locator.__('Actions'),
                    sortable: false,
                    width: 110,
                    overflow: 'visible',
                    autoHide: false,
                    textAlign: 'center',
                    template:function (row){
                        return '\<a href="/dashboard/documents/' + row.id + '/download" class="btn btn-sm btn-primary m-btn m-btn--icon">                            \
                            <i class="fa fa-download"></i>' + locator.__('Download') + '\
                        </a>';
                    }
                }],
        });

        $('#kt_form_status').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'Status');
        });
        $('#kt_form_status,#kt_form_type').selectpicker();

    };

    return {
        // public functions
        init: function() {
            demo();
        },
    };
}();

jQuery(document).ready(function() {
    KTDatatableLocalSortDemo.init();
});
