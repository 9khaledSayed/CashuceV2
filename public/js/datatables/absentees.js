"use strict";
// Class definition

var KTUserListDatatable = function() {
    // Private functions
    var messages = {
        'ar': {
            'Employee Name': "اسم الموظف",
            'Time In': "وقت الحضور",
            'Time Out': "وقت الانصراف",
            'Date': "التاريخ",
            'Total Working Hours': "ساعات العمل",
            'Actions': "الاجراءات",
        }
    };
    var locator = new KTLocator(messages);
    // basic demo
    // variables
    var datatable;

    // init
    var init = function() {
        // init the datatables. Learn more: https://keenthemes.com/metronic/?page=docs&section=datatable
        datatable = $('#kt_apps_user_list_datatable').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'GET',
                        url: '/dashboard/attendances/absentees',
                    },
                },
                autoColumns:false,
                pageSize: 10,
                serverPaging: true,
                serverFiltering: false,
                serverSorting: true,
                saveState: tablesSaveStatus,
            },

            // layout definition
            layout: {
                scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
                footer: true, // display/hide footer
            },

            // column sorting
            sortable: true,

            pagination: true,

            search: {
                input: $('#generalSearch'),
                delay: 400,
            },

            // columns definition
            columns: [
                {
                    field: 'job_number',
                    title: locator.__('Job Number'),
                },{
                    field: "name",
                    title: locator.__("Employee Name"),
                    width: 200,
                    sortable:true,
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
                        let name = employeeName(data);
                        output = '<div class="kt-user-card-v2" >\
								<div class="kt-user-card-v2__pic">\
									<div class="kt-badge kt-badge--xl kt-badge--' + state + '">' + name.substring(0, 2) + '</div>\
								</div>\
								<div class="kt-user-card-v2__details">\
									<a href="/dashboard/employees/' + data.id + '" class="kt-user-card-v2__name">' + name + '</a>\
								</div>\
							</div>';

                        return output;
                    }
                }, {
                    field: 'salary',
                    title: locator.__('Salary'),
                    textAlign: 'center',
                }, {
                    field: 'contract_start_date',
                    title: locator.__('Contract Start Date'),
                    textAlign: 'center',
                }],
        });
    }



    $('#date-field').on('change', function() {
        datatable.setDataSourceParam('full_date', $(this).val());
        datatable.reload();
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





    // selection
    var selection = function() {
        // init form controls
        //$('#kt_form_status, #kt_form_type').selectpicker();

        // event handler on check and uncheck on records
        datatable.on('kt-datatable--on-check kt-datatable--on-uncheck kt-datatable--on-layout-updated',	function(e) {
            var checkedNodes = datatable.rows('.kt-datatable__row--active').nodes(); // get selected records
            var count = checkedNodes.length; // selected records count

            $('#kt_subheader_group_selected_rows').html(count);

            if (count > 0) {
                $('#kt_subheader_search').addClass('kt-hidden');
                $('#kt_subheader_group_actions').removeClass('kt-hidden');
            } else {
                $('#kt_subheader_search').removeClass('kt-hidden');
                $('#kt_subheader_group_actions').addClass('kt-hidden');
            }
        });
    }

    // fetch selected records
    var selectedFetch = function() {
        // event handler on selected records fetch modal launch
        $('#kt_datatable_records_fetch_modal').on('show.bs.modal', function(e) {
            // show loading dialog
            var loading = new KTDialog({'type': 'loader', 'placement': 'top center', 'message': 'Loading ...'});
            loading.show();

            setTimeout(function() {
                loading.hide();
            }, 1000);

            // fetch selected IDs
            var ids = datatable.rows('.kt-datatable__row--active').nodes().find('.kt-checkbox--single > [type="checkbox"]').map(function(i, chk) {
                return $(chk).val();
            });

            // populate selected IDs
            var c = document.createDocumentFragment();

            for (var i = 0; i < ids.length; i++) {
                var li = document.createElement('li');
                li.setAttribute('data-id', ids[i]);
                li.innerHTML = 'Selected record ID: ' + ids[i];
                c.appendChild(li);
            }

            $(e.target).find('#kt_apps_user_fetch_records_selected').append(c);
        }).on('hide.bs.modal', function(e) {
            $(e.target).find('#kt_apps_user_fetch_records_selected').empty();
        });
    };

    // selected records status update
    var selectedStatusUpdate = function() {
        $('#kt_subheader_group_actions_status_change').on('click', "[data-toggle='status-change']", function() {
            var status = $(this).find(".kt-nav__link-text").html();

            // fetch selected IDs
            var ids = datatable.rows('.kt-datatable__row--active').nodes().find('.kt-checkbox--single > [type="checkbox"]').map(function(i, chk) {
                return $(chk).val();
            });

            if (ids.length > 0) {
                // learn more: https://sweetalert2.github.io/
                swal.fire({
                    buttonsStyling: false,

                    html: "Are you sure to update " + ids.length + " selected records status to " + status + " ?",
                    type: "info",

                    confirmButtonText: "Yes, update!",
                    confirmButtonClass: "btn btn-sm btn-bold btn-brand",

                    showCancelButton: true,
                    cancelButtonText: "No, cancel",
                    cancelButtonClass: "btn btn-sm btn-bold btn-default"
                }).then(function(result) {
                    if (result.value) {
                        swal.fire({
                            title: 'Deleted!',
                            text: 'Your selected records statuses have been updated!',
                            type: 'success',
                            buttonsStyling: false,
                            confirmButtonText: "OK",
                            confirmButtonClass: "btn btn-sm btn-bold btn-brand",
                        })
                        // result.dismiss can be 'cancel', 'overlay',
                        // 'close', and 'timer'
                    } else if (result.dismiss === 'cancel') {
                        swal.fire({
                            title: 'Cancelled',
                            text: 'You selected records statuses have not been updated!',
                            type: 'error',
                            buttonsStyling: false,
                            confirmButtonText: "OK",
                            confirmButtonClass: "btn btn-sm btn-bold btn-brand",
                        });
                    }
                });
            }
        });
    }

    // selected records delete

    var updateTotal = function() {
        datatable.on('kt-datatable--on-layout-updated', function () {
            //$('#kt_subheader_total').html(datatable.getTotalRows() + ' Total');
        });
    };

    return {
        // public functions
        init: function() {
            init();
            // search();
            selection();
            selectedFetch();
            selectedStatusUpdate();
            // selectedDelete();
            updateTotal();

        },
    };
}();

// On document ready
KTUtil.ready(function() {

    KTUserListDatatable.init();

    $('#date-field').datepicker({
        rtl: true,
        language: appLang,
        orientation: "bottom",
        format: "yyyy-mm-dd",
        clearBtn: false,
        lang: appLang
    });

    $('#timeIn, #timeOut').timepicker({
        minuteStep: 5,
        defaultTime: '',
        showSeconds: false,
        showMeridian: true,
    });

    $("#this-day-export").click(function () {
        var fullDate = $('#date-field').val();
        window.location.replace("/attendances_sheet/excel?this_day=" + fullDate);
    });

    $("#this-month-export").click(function () {
        var fullDate = $('#date-field').val();
        window.location.replace("/attendances_sheet/excel?this_month=" + fullDate);
    });

    $("#plus").click(function (){
        changeDate('plus');
    });
    $("#minus").click(function (){
        changeDate('minus');

    });

    function changeDate(operation) {
        var dateField = $('#date-field');
        var currentDate = dateField.datepicker("getDate");
        var newDate = new Date();
        var result;

        if (operation === "plus"){
            result = currentDate.getDate() + 1
        }else {
            result = currentDate.getDate() - 1
        }

        newDate.setMonth(currentDate.getMonth());
        newDate.setDate(result);
        newDate.setFullYear(currentDate.getFullYear());

        dateField.datepicker("setDate", newDate);
    }

});
