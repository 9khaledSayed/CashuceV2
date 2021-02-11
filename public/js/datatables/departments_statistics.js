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
                height: 600,
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
                     width: 200,
                    title: locator.__('Name'),
                    textAlign: 'center',
                },{
                    field: 'in_service',
                    width: 200,
                    title: locator.__('In Service'),
                    textAlign: 'center',
                    autoHide: false,

                }],
        });

        datatable.on('' , function () {
            console.log('init')
        });
    };

    var eventsCapture = function() {
        $('#department_statistics_table').on('kt-datatable--on-ajax-done', function(e, response) {
                var data = [];
                $.each(response, function(index, value){
                    data[index] = {label: value.name, value: value.percentage }
                })

            new Morris.Donut({
                element: 'kt_morris_4',
                data: data,
                colors: ["#22b9ff",
                    "#282a3c",
                    "#5867dd",
                    "#34bfa3",
                    "#36a3f7",
                    "#ffb822",
                    "#fd3995",
                    "#c5cbe3",
                    "#3d4465",
                    "#3e4466"]
            });
        });
    };
    return {
        // public functions
        init: function() {
            demo();
            eventsCapture();
        },
    };
}();

jQuery(document).ready(function() {
    departmentStatistics.init();
});
