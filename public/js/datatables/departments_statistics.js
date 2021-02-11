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

        datatable.on('' , function () {
            console.log('init')
        });
    };

    var eventsCapture = function() {
        $('#department_statistics_table').on('kt-datatable--on-ajax-done', function(e, response) {
                var data = [];
                $.each(response, function(index, value){
                    data[index] = {label: value.name, data: value.percentage }
                })

                $.plot($("#kt_flotcharts_11"), data, {
                    series: {
                        pie: {
                            show: true,
                            label: {
                                show: true,
                                radius: 1,
                                formatter: function(label, series) {
                                    return '<div style="font-size:8pt;font-weight: 900;text-align:center;padding:2px;color:white;">' + label + '<br/>' + Math.round(series.percent) + '%</div>';
                                },
                                background: {
                                    opacity: 0.8
                                }
                            }
                        }
                    },
                    legend: {
                        show: false
                    }
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
