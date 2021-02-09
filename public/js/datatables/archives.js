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
                        url: '/dashboard/archives',
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
                    field: 'name_ar',
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
		                          <a class="dropdown-item" href="/dashboard/archives/' + row.id + '/edit"><i class="la la-pencil-square-o"></i>' + locator.__('Edit Info') + '</a>\
		                      </div>\
		                  </div>\
                        ';
                    }
                }],
        });


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
