'use strict';
// Class definition

var KTDatatableChildRemoteDataDemo = function() {
    // Private functions
    var messages = {
        'ar': {
            'Arabic Name': "الاسم بالعربية",
            'English Name': "الاسم بالانجليزية",
            'Load sub table': "اظهار الجدول الفرعي",
            'created': "تاريخ اﻹنشاء",
            'Created': "تاريخ اﻹنشاء",
            "Actions": "الاجراءات",
            'Ability': "الدور",
            'Type': "النوع",
            'System Role': "صلاحية نظام",
            'Are you sure to delete this item?': "هل انت متأكد أنك تريد مسح هذا العنصر؟",
            'Yes, Delete!': "نعم امسح!",
            'Item Deleted Successfully': "تم مسح العنصر بنجاح",
            'No, cancel': "لا الغِ",
            'OK': "تم",
            'Loading...': "تحميل...",
            'Error!': "خطأ!",
            'Deleted!': "تم المسح!",
            'Show': "عرض",
            'Edit': "تعديل",
            'Delete': "مسح",
            "Error Can't Delete System Role!": "لا يمكنك مسح صلاحية النظام"
        }
    };

    var locator = new KTLocator(messages);

    // demo initializer
    var demo = function() {

        var datatable = $('.kt-datatable').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
                        method:'get',
                        url: '/dashboard/roles',
                    },
                },
                pageSize: 10, // display 20 records per page
                serverPaging: true,
                serverFiltering: false,
                serverSorting: true,
                saveState: tablesSaveStatus,
            },

            // layout definition
            layout: {
                scroll: true,
                height: 400,
                footer: false,
            },

            // column sorting
            sortable: true,

            pagination: true,

            detail: {
                title: locator.__('Load sub table'),
                content: subTableInit,
            },

            search: {
                input: $('#generalSearch'),
            }, rows: {
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
                                    },
                                });
                                if (data.type == 'System Role') {
                                    swal.fire({
                                        title: locator.__('Error Can\'t Delete System Role!'),
                                        type: 'error',
                                    });
                                }else {
                                    $.ajax({
                                        method: 'DELETE',
                                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                        url: '/dashboard/roles/' + data.id,
                                        error: function (err) {
                                            if (err.hasOwnProperty('responseJSON')) {
                                                if (err.responseJSON.hasOwnProperty('message')) {
                                                    swal.fire({
                                                        title: locator.__('Error!'),
                                                        text: err.responseJSON.message,
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

                            }
                        });
                    });
                }
            },

            // columns definition
            columns: [
                {
                    field: 'id',
                    title: '',
                    sortable: false,
                    width: 30,
                    textAlign: 'center',
                }, {
                    field: 'checkbox',
                    title: '',
                    template: '{{id}}',
                    sortable: false,
                    width: 20,
                    textAlign: 'center',
                    selector: {class: 'kt-checkbox--solid'},
                }, {
                    field: 'name_arabic',
                    title: locator.__('Arabic Name'),
                    sortable: 'asc',
                }, {
                    field: 'name_english',
                    title: locator.__('English Name'),
                    sortable: 'asc',
                },{

                    field: 'type',
                    title: locator.__('Type'),
                    textAlign: 'center',
                    template: function(row) {
                        var type = {
                            'System Role': {'title': locator.__('System Role')  , 'class': ' kt-badge--danger'},
                            'Owner Role': {'title': locator.__('Owner Role')  , 'class': 'kt-badge--primary'},
                        };
                        return '<span class="kt-badge ' + type[row.type].class + ' kt-badge--inline kt-badge--pill">' + type[row.type].title + '</span>';
                    },
                }, {
                    field: 'created_at',
                    title: locator.__('Created'),
                    textAlign: 'center',
                }, {
                    field: 'Actions',
                    width: 110,
                    title: locator.__('Actions'),
                    sortable: false,
                    overflow: 'visible',
                    autoHide: false,
                    template: function(row) {
                        return '\
                          <div class="dropdown">\
                              <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown">\
                                  <i class="la la-ellipsis-h"></i>\
                              </a>\
                              <div class="dropdown-menu dropdown-menu-right">\
                                  <a class="dropdown-item" href="/dashboard/roles/' + row.id + '/edit"><i class="la la-leaf"></i>' + locator.__('Edit') + '</a>\
                                  <a class="dropdown-item" href="/dashboard/roles/' + row.id + '"><i class="la la-leaf"></i>' + locator.__('Show') + '</a>\
                                  <a class="dropdown-item delete-item" href="#"><i class="la la-leaf"></i>' + locator.__('Delete') + '</a>\
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
                default:
                    datatable.search($(this).val().toLowerCase(), 'created_at');
            }
        });

        $('#kt_form_type').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'Type');
        });

        $('#kt_form_status,#kt_form_date').selectpicker();

        function subTableInit(e) {
            $('<div/>').attr('id', 'child_data_ajax_' + e.data.id).appendTo(e.detailCell).KTDatatable({
                data: {
                    type: 'remote',
                    source: {
                        read: {
                            method:'get',
                            url: '/dashboard/abilities?role_id=' + e.data.id,
                        },
                    },
                    pageSize: 10,
                    serverPaging: true,
                    serverFiltering: false,
                    serverSorting: true,
                },

                // layout definition
                layout: {
                    scroll: true,
                    height: 300,
                    footer: false,

                    // enable/disable datatable spinner.
                    spinner: {
                        type: 1,
                        theme: 'default',
                    },
                },

                sortable: true,

                // columns definition
                columns: [
                    {
                        field: 'id',
                        title: '#',
                        width: 100,
                        sortable: false,
                    }, {
                        field: 'label',
                        title: locator.__('Ability'),
                        width: 300,
                    }, {
                        field: 'created_at',
                        title: locator.__('Created'),
                        width: 300,
                    }
                ],
            });
        }
    };

    return {
        // Public functions
        init: function() {
            // init dmeo
            demo();
        },
    };
}();

jQuery(document).ready(function() {
    KTDatatableChildRemoteDataDemo.init();
});
