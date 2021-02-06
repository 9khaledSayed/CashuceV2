"use strict";
// Class definition

var KTDatatableLocalSortDemo = function() {
    // Private functions
    var messages = {
        'ar': {
            'Payroll Date': "تاريخ مسير الرواتب",
            "Employees No":"عدد الموظفين",
            "Total Additions":"اجمالي الاضافي",
            "Total Deductions":"إجمالي الحسومات",
            "Total Net Salary":"اجمالي صافي الراتب",
            "Total Days":"ايام العمل",
            "Actions":"إجراءات",
            "Approve":"اعتماد",
            "Reject":"رفض",
            "Cancel":"إلغاء",
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
                        url: '/dashboard/payrolls/pending',
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
            },
            rows: {
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
                                    url: '/dashboard/home_visits/' + data.id,
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
                },{
                    field: 'date',
                    title: locator.__('Payroll Date'),
                    textAlign: 'center',
                }, {
                    field: 'employees_no',
                    title: locator.__('Employees No'),
                    textAlign: 'center',
                },{
                    field: 'total_deductions',
                    title: locator.__('Total Deductions'),
                    textAlign: 'center',
                    template:function(row){
                        return '<span class="kt-font-danger">' + row.total_deductions + '</span>';
                    }
                }, {
                    field: 'total_net_salary',
                    title: locator.__('Total Net Salary'),
                    textAlign: 'center',
                    template:function(row){
                        return '<span class="kt-font-primary">' + row.total_net_salary + '</span>';
                    }

                },{
                    field: 'Actions',
                    title: locator.__('Actions'),
                    sortable: false,
                    width: 110,
                    overflow: 'visible',
                    autoHide: false,
                    textAlign: 'center',
                    template: function(row) {
                        return  '\
                                  <div class="dropdown">\
                                      <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown">\
                                          <i class="la la-ellipsis-h"></i>\
                                      </a>\
                                      <div class="dropdown-menu dropdown-menu-right">\
                                          <a class="dropdown-item" href="/dashboard/payrolls/approve/' + row.id + '"><i class="la la-check kt-font-success"></i>' + locator.__('Approve') + '</a>\
                                          <a class="dropdown-item" href="/dashboard/payrolls/reject/' + row.id + '">' + '<i class="la la-times kt-font-reject"></i>' + locator.__('Reject') + '</a>\
                                      </div>\
                                  </div>\
		                    ';

                    },
                }],
        });

        $('#kt_form_date').on('change', function() {
            var current_datetime = new Date()
            var value = $(this).val();
            switch (value) {
                case '1': // today
                    datatable.search(current_datetime.toDateString(), 'created_at');
                    break;
                case '2':
                    current_datetime.setDate(current_datetime.getDate() - 7);
                    datatable.search(current_datetime.toDateString(), 'created_at');
                    break;
                case '3':
                    current_datetime.setMonth(current_datetime.getMonth() - 1);
                    datatable.search(current_datetime.toLocaleString('default', { month: 'short' }), 'created_at');
                    break;
                case '4':
                    current_datetime.setFullYear(current_datetime.getFullYear() - 1);
                    datatable.search(current_datetime.toLocaleString('default', { month: 'short' }), 'created_at');
                    break;
                default:
                    datatable.search($(this).val().toLowerCase(), 'created_at');
            }
        });

        $('#kt_form_status').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'status');
        });

        $('#kt_form_date, #kt_form_status').selectpicker();

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
