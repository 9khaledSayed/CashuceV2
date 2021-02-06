"use strict";
// Class definition

var expireDocs = function() {
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

        var datatable = $('#expiring_documents_table').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'GET',
                        url: '/dashboard/expire_docs',
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
            sortable: true,

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
                },{
                    field: "name",
                    title: locator.__("Employee"),
                    width: 200,
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
									<div class="kt-badge kt-badge--xl kt-badge--' + state + '">' + data.name.substring(0, 2) + '</div>\
								</div>\
								<div class="kt-user-card-v2__details">\
									<a href="/dashboard/employees/' + data.id + '" class="kt-user-card-v2__name">' + data.name + '</a>\
								</div>\
							</div>';

                        return output;
                    }
                }, {
                    field: 'expire_date',
                    title: locator.__('Expire Date'),
                }, {
                    field: 'service_days_left',
                    title: locator.__('Service Days Left'),
                }, {
                    field: 'trail_days_left',
                    title: locator.__('Trail Days Left'),
                }]
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
    expireDocs.init();
});
