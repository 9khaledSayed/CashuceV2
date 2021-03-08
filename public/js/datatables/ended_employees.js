"use strict";
// Class definition

var endedEmployees = function() {
    // Private functions
    var messages = {
        'ar': {
            'Full Name': "الاسم بالكامل",
            'Created': "تاريخ اﻹنشاء",
            "Email": "البريد اﻹلكتروني",
            "Role": "الصلاحية",
            "Salary": "الراتب",
            "Show Info": "عرض البيانات",
            "Job Number": "الرقم الوظيفي",
            "Actions": "الاجراءات",
            "Not Activated": "غير فعال",
            "Activated": "فعال",
            "Account Status": "حالة الحساب",
            'Are you sure to delete this item?': "هل انت متأكد أنك تريد مسح هذا العنصر؟",
            'Operation Done Successfully': "تم العملية بنجاح",
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

        var datatable = $('#ended_employees_table').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'GET',
                        url: url,
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
                scroll: true, // enable/disable datatable scroll both horizontal and vertical when needed.
                height: 400,
                footer: false, // display/hide footer
            },

            // column sorting
            sortable: false,

            pagination: true,

            search: {
                input: $('#generalSearch'),
                delay: 400,
            }, rows: {
                autoHide: false,
                afterTemplate: function (row, data, index) {
                    row.find('.service-change').on('click', function () {
                        var modal = $('#back-to-service');
                        var form = $(".back-to-service-form");;

                        modal.modal('show');

                        $(".submit-back-to-service").click(function (e) {
                            e.preventDefault();
                            swal.fire({
                                title: locator.__('Loading...'),
                                onOpen: function () {
                                    swal.showLoading();
                                }
                            });
                            $.ajax({
                                method: 'get',
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                url: '/dashboard/employees/back_to_service/' + data.id,
                                data : form.serialize(),
                                error: function (err) {
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
                                    console.log(err);
                                }
                            }).done(function (res) {
                                if(res.status === 1){
                                    swal.fire({
                                        title: locator.__('Operation Done Successfully'),
                                        text: locator.__(res.message),
                                        type: 'success',
                                        buttonsStyling: false,
                                        confirmButtonText: locator.__("OK"),
                                        confirmButtonClass: "btn btn-sm btn-bold btn-brand",
                                    });
                                    modal.modal('hide');
                                    datatable.reload();
                                }

                            });

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
                },{
                    field: 'job_number',
                    title: locator.__('Job Number'),
                    textAlign: 'center',
                    type: 'number',
                }, {
                    field: 'name',
                    title: locator.__('Full Name'),
                    textAlign: 'center',
                    template:function (row){
                        return '<a href="/dashboard/employees/' + row.id + '">' + row.name + '</a>';
                    }
                }, {
                    field: 'email',
                    title: locator.__('Email'),
                    textAlign: 'center',
                }
                ,{
                    field: 'service_status',
                    title: locator.__('Service Status'),
                    textAlign: 'center',
                    template: function(row) {
                        var status = row.service_status === '1' ? 'checked' : 'unchecked';
                        return '\
                            <span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--warning">\
                            <label class="service-change">\
                                <input type="checkbox"  disabled ' + status + ' name="">\
                                <span></span>\
                            </label>\
                            </span>';
                    },
                },{
                    field: 'nationality',
                    title: locator.__('Nationality'),
                    textAlign: 'center',
                    visible: false,
                },{
                    field: 'supervisor',
                    title: locator.__('Supervisor'),
                    textAlign: 'center',
                    visible: false,
                    template:function (row){
                        return '<a href="/dashboard/employees/' + row.id + '">' + row.supervisor + '</a>';
                    }

                },{
                    field: 'role',
                    title: locator.__('Role'),
                    textAlign: 'center',
                    visible: false,
                },{
                    field: 'department',
                    title: locator.__('Department'),
                    textAlign: 'center',
                    visible: false,
                },
            ],
        });

        $('#kt_form_supervisor').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'supervisor');
        });

        $('#kt_form_role').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'role');
        });

        $('#kt_form_nationality').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'nationality');
        });

        $('#kt_form_service_status').on('change', function() {
            //console.log($(this).val());
            datatable.search($(this).val(), 'service_status_search');
        });

        $('#kt_form_department').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'department');
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
    endedEmployees.init();
});
