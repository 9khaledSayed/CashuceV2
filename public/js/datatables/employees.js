"use strict";
// Class definition

var KTDatatableLocalSortDemo = function() {
    // Private functions
    var messages = {
        'ar': {
            'Full Name': "الاسم بالكامل",
            'Created': "تاريخ اﻹنشاء",
            "Email": "البريد اﻹلكتروني",
            "Role": "الصلاحية",
            "Salary": "الراتب",
            "Service Status": "حالة الخدمة",
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

        var datatable = $('.kt-datatable').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'GET',
                        url: '/dashboard/employees',
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
                icons:{
                    // pagination: {
                    //     next: 'la la-angle-right',
                    //     prev: 'la la-angle-left',
                    //     first: 'la la-angle-double-left',
                    //     last: 'la la-angle-double-right',
                    //     more: 'la la-ellipsis-h'
                    // }
                }
            },

            // column sorting
            sortable: true,

            pagination: true,

            search: {
                input: $('#generalSearch'),
                delay: 400,
            }, rows: {
                afterTemplate: function (row, data, index) {
                    row.find('.service-change').on('click', function () {
                        var url = '/dashboard/employees/end_service/' + data.id
                        var submitBtn = $(".submit-end-service");
                        var modal = $('#end-service');
                        var form = $(".end-service-form");

                        modal.modal('show');

                        submitBtn.click(function (e) {
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
                                url: url,
                                data : form.serialize(),
                                success:function (res) {
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
                                        form.resetForm();
                                    }
                                },
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
                                },

                            });

                        });

                    });

                    row.find('.print-item').on('click', function () {
                        var mywindow = window.open('', 'PRINT', 'height=600,width=800');
                        var content = '\
                                <style>\
                                    @media print {\
                                        @page {\
                                            size: 30mm 21mm;\
                                            margin: 0;\
                                            padding: 0;\
                                        }\
                                        html, body {\
                                            position: relative;\
                                            width: 100%;\
                                            height: 100%;\
                                            max-width: 100%;\
                                            max-height: 100%;\
                                            margin: 0;\
                                            padding: 0;\
                                        }\
                                        svg {\
                                            width: 100%;\
                                            height: 100%;\
                                            max-width: 100%;\
                                            max-height: 100%;\
                                        }\
                                    }\
                                </style>'
                        content += '<svg id="code128" jsbarcode-value="123456789012" onload="print()"></svg>'
                        content += '<script src="https://cdn.jsdelivr.net/jsbarcode/3.3.16/barcodes/JsBarcode.code128.min.js"></script>'
                        content += '<script>JsBarcode("#code128", "' + data.barcode + '", { format: "CODE128", displayValue: true});</script>';
                        mywindow.document.write(content);
                        mywindow.document.close(); // necessary for IE >= 10
                        mywindow.focus(); // necessary for IE >= 10*/

                        // mywindow.print();
                        // mywindow.close();
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
                },
                {
                    field: 'fname_ar',
                    title: locator.__('Full Name'),
                    textAlign: 'center',
                    template:function (row){
                        return '<a href="/dashboard/employees/' + row.id + '">' + row.name + '</a>';
                    }
                }, {
                    field: 'job_number',
                    title: locator.__('Job Number'),
                    textAlign: 'center',
                    type: 'number',
                }, {
                    field: 'salary',
                    title: locator.__('Salary'),
                    textAlign: 'center',
                }
                , {
                    field: 'barcode',
                    title: locator.__('Barcode'),
                    template: function(raw) {
                        return '<a class="h5 print-item" href="#"><i class="flaticon-reply"></i>Print ID</a>';
                    },
                } ,{
                    field: 'service_status',
                    title: locator.__('Service Status'),
                    autoHide: false,
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
                    field: 'service_status_search', // 2 inActive or 1 active
                    title: locator.__('Service Status Search'),
                    textAlign: 'center',
                    visible: false,
                }, {
                    field: 'email_verified_at',
                    title: locator.__('Account Status'),
                    textAlign: 'center',
                    visible: false,
                    template: function(row) {
                        var status = {
                            'title': (!row.email_verified_at)?locator.__('Not Activated'):locator.__('Activated'),
                            'class':(!row.email_verified_at)?locator.__(' kt-badge--danger'):locator.__(' kt-badge--success')
                        };
                        return '<span class="kt-badge ' + status.class + ' kt-badge--inline kt-badge--pill">' + status.title + '</span>';
                    },
                },{
                    field: 'nationality',
                    title: locator.__('Nationality'),
                    textAlign: 'center',
                    visible: false,
                },{
                    field: 'provider',
                    title: locator.__('Provider'),
                    textAlign: 'center',
                    visible: false,
                },{
                    field: 'department',
                    title: locator.__('Department'),
                    textAlign: 'center',
                    visible: false,
                },{
                    field: 'section',
                    title: locator.__('Section'),
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
                    field: 'contract_start_date',
                    title: locator.__('Joined Date'),
                    textAlign: 'center',
                    autoHide: false,
                }, {
                    field: 'Actions',
                    title: locator.__('Actions'),
                    sortable: false,
                    width: 110,
                    overflow: 'visible',
                    autoHide: false,
                    textAlign: 'center',
                    template:function (row){
                        return '\
		                  <div class="dropdown">\
		                      <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown">\
		                          <i class="la la-ellipsis-h"></i>\
		                      </a>\
		                      <div class="dropdown-menu dropdown-menu-right">\
		                          <a class="dropdown-item" href="/dashboard/employees/' + row.id + '/edit"><i class="la la-pencil-square-o"></i>' + locator.__('Edit Info') + '</a>\
		                          <a class="dropdown-item" href="/dashboard/employees/' + row.id + '"><i class="la la-eye"></i>' + locator.__('Show Info') + '</a>\
		                      </div>\
		                  </div>\
                        ';
                    }
                }],
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

        $('#kt_form_section').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'section');
        });

        $('#kt_form_provider').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'provider');
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
