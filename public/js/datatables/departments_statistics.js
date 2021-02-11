"use strict";
// Class definition

var departmentStatistics = function() {
    // Private functions
    var messages = {
        'ar': {

        }
    };

    var locator = new KTLocator(messages);

    // basic demo
    var demo = function() {

        var datatable = $('#department_statistics_table').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'GET',
                        url: '/dashboard/departments_statistics',
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
                height: 270,
                footer: false, // display/hide footer

            },

            // column sorting
            sortable: false,

            pagination: true,

            search: {
                input: $('#generalSearch'),
                delay: 400,
            },

            // columns definition
            columns: [

                 {
                    field: 'name',
                     width: 150,
                    title: locator.__('Name'),
                    textAlign: 'center',
                },{
                    field: 'in_service',
                    width: 150,
                    title: locator.__('In Service'),
                    textAlign: 'center',
                    autoHide: false,

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
    departmentStatistics.init();
});
