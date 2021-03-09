"use strict";
// Class definition

var KTDatatableLocalSortDemo = function() {
    // Private functions
    var messages = {
        'ar': {
            'Employee': "الموظف",
            "Total Deductions":"إجمالي الحسومات",
            "Net Salary":"صافي الراتب",
            // "Net Pay":"صافي المبلغ",
            "Work Days":"ايام العمل",
            "Actions":"اجراءات",

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
                        url: '/dashboard/payroll_special/' + payroll_id,
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
                height: 550,
                footer: false, // display/hide footer
            },

            // column sorting
            sortable: false,

            pagination: true,

            search: {
                input: $('#generalSearch'),
            },
            rows: {
                autoHide: false,
            },
            // columns definition
            columns: [
                 {
                    field: 'job_number',
                    title: locator.__('Job Number'),
                     autoHide: false,
                },{
                    field: "employee",
                    title: locator.__("Employee"),
                    width: 200,
                    autoHide: false,
                    // callback function support for column rendering
                    template: function(data) {
                        var output = '';
                        var stateNo = KTUtil.getRandomInt(0, 6);
                        var states = [
                            'success',
                            'brand',
                            'danger',
                            'success',
                            'warning',
                            'primary',
                            'info'
                        ];
                        var state = states[stateNo];

                        output = '<div class="kt-user-card-v2">\
								<div class="kt-user-card-v2__pic">\
									<div class="kt-badge kt-badge--xl kt-badge--' + state + '">' + data.employee_name.substring(0, 2) + '</div>\
								</div>\
								<div class="kt-user-card-v2__details">\
									<a href="/dashboard/employees/' + data.employee_id + '" class="kt-user-card-v2__name">' + data.employee_name + '</a>\
								</div>\
							</div>';

                        return output;
                    }
                }, {
                    field: 'department',
                    title: locator.__('Department'),
                    autoHide: false,
                }, {
                    field: 'officialWorkingHours',
                    title: locator.__('Official Working Hours'),
                    autoHide: false,
                }, {
                    field: 'officialWorkingHoursWithOverTime',
                    title: locator.__('Official Working Hours With Overtime'),
                    autoHide: false,
                }, {
                    field: 'officialAbsentHours',
                    title: locator.__('Official Absent Hours'),
                    autoHide: false,
                }, {
                    field: 'hourly_wage',
                    title: locator.__('Hourly Wage'),
                    autoHide: false,
                }, {
                    field: 'salary',
                    title: locator.__('Salary'),
                    autoHide: false,
                }, {
                    field: 'net_pay',
                    title: locator.__('Net Pay'),
                    autoHide: false,
                }, {
                    field: "Actions",
                    title: locator.__("Actions"),
                    sortable: false,
                    autoHide: false,
                    overflow: 'visible',
                    template: function(row) {
                        return '\
		                  <a href="/dashboard/salaries/' + row.id + '" class="btn btn-sm btn-default btn-font-sm" title="Edit details">\
		                      <i class="flaticon2-document"></i> ' + locator.__('Details') +'\
		                  </a>';
                    },
                }]
        });

        $('#kt_form_supervisor').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'supervisor');
        });
        $('#kt_form_nationality').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'nationality');
        });

        $('#kt_form_department').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'department');
        });

        $('#kt_form_provider').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'provider');
        });

        $('#kt_form_section').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'section');
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
