"use strict";
// Class definition

var KTDatatableLocalSortDemo = function() {
    // Private functions
    var messages = {
        'ar': {
            'Full Name': "الاسم بالكامل",
            'Created': "تاريخ اﻹنشاء",
            "Supplier": "الشركة المشغلة",
            "Interview Date": "الصلاحية",
            "Actions": "الاجراءات",
            "Show Info": "عرض البيانات",
            'Are you sure to delete this item?': "هل انت متأكد أنك تريد مسح هذا العنصر؟",
            'Item Deleted Successfully': "تم مسح العنصر بنجاح",
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
                        url: '/dashboard/candidates',
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
            sortable: true,

            pagination: true,

            search: {
                input: $('#generalSearch'),
                delay: 400,
            },
            rows: {
                autoHide: false,
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
                                    url: '/dashboard/candidates/' + data.id,
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
                }, {
                    field: 'name',
                    title: locator.__('Full Name'),
                    textAlign: 'center',

                }, {
                    field: 'nationality',
                    title: locator.__('Nationality'),
                    textAlign: 'center',

                }, {
                    field: 'age',
                    title: locator.__('Age'),
                    textAlign: 'center',
                }, {
                    field: 'iqama_no',
                    title: locator.__('Iqama No'),
                    textAlign: 'center',
                }, {
                    field: 'english',
                    title: locator.__('English'),
                    textAlign: 'center',
                    template: function(row) {
                        var fontClass = row.english ? 'kt-font-success' : 'kt-font-danger';
                        return '<span class="' + fontClass + '">' + row.english + '</span>';
                    },
                }, {
                    field: 'arabic',
                    title: locator.__('Arabic'),
                    textAlign: 'center',
                    template: function(row) {
                        var fontClass = row.arabic ? 'kt-font-success' : 'kt-font-danger';
                        return '<span class="' + fontClass + '">' + row.arabic + '</span>';
                    },
                }, {
                    field: 'computer',
                    title: locator.__('Computer'),
                    textAlign: 'center',
                    template: function(row) {
                        var fontClass = row.computer ? 'kt-font-success' : 'kt-font-danger';
                        return '<span class="' + fontClass + '">' + row.computer + '</span>';
                    },
                }, {
                    field: 'bengali',
                    title: locator.__('Bengali'),
                    textAlign: 'center',
                    template: function(row) {
                        var fontClass = row.bengali ? 'kt-font-success' : 'kt-font-danger';
                        return '<span class="' + fontClass + '">' + row.bengali + '</span>';
                    },
                }, {
                    field: 'urdu',
                    title: locator.__('Urdu'),
                    textAlign: 'center',
                    template: function(row) {
                        var fontClass = row.urdu ? 'kt-font-success' : 'kt-font-danger';
                        return '<span class="' + fontClass + '">' + row.urdu + '</span>';
                    },
                }, {
                    field: 'status_name',
                    title: 'Status',
                    // callback function support for column rendering
                    template: function(row) {
                        return '<span class="kt-badge ' + row.status_class + ' kt-badge--inline kt-badge--pill">' + row.status_name + '</span>';
                    },
                }, {
                    field: 'department',
                    title: locator.__('Department'),
                    textAlign: 'center',
                }, {
                    field: 'Actions',
                    title: locator.__('Actions'),
                    sortable: false,
                    width: 110,
                    overflow: 'visible',
                    autoHide: false,
                    textAlign: 'center',
                    template: function (row){
                        if(row.is_provider){
                            return '\
		                  <div class="dropdown">\
		                      <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown">\
		                          <i class="la la-ellipsis-h"></i>\
		                      </a>\
		                      <div class="dropdown-menu dropdown-menu-right">\
		                          <a class="dropdown-item" href="/dashboard/candidates/' + row.id + '/edit"><i class="la la-pencil-square-o"></i>' + locator.__('Edit Info') + '</a>\
		                          <a class="dropdown-item delete-item" href="#"><i class="la la-trash"></i>' + locator.__('Delete') + '</a>\
		                      </div>\
		                  </div>\
                        ';
                        }else{
                            return '\
		                  <div class="dropdown">\
		                      <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown">\
		                          <i class="la la-ellipsis-h"></i>\
		                      </a>\
		                      <div class="dropdown-menu dropdown-menu-right">\
		                          <a class="dropdown-item" href="/dashboard/candidates/' + row.id + '"><i class="la la-eye"></i>' + locator.__('Show Info') + '</a>\
		                      </div>\
		                  </div>\
                        ';
                        }

                    }
                }],
        });

        $('#kt_form_status').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'status_name');
        });
        $('#kt_form_department').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'department');
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
