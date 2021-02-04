"use strict";
// Class definition
var datatable;

var KTDatatableLocalSortDemo = function() {
    // Private functions
    var messages = {
        'ar': {
            'Item': "اسم المنتج",
            'Date': "تاريخ اﻹنشاء",
            "Actions": "الاجراءات",
            'Are you sure to delete this item?': "هل انت متأكد أنك تريد مسح هذا العنصر؟",
            'Item Deleted Successfully': "تم مسح العنصر بنجاح",
            'Yes, Delete!': "نعم امسح!",
            'No, cancel': "لا الغِ",
            'OK': "تم",
            'Loading...': "تحميل...",
            'Error!': "خطأ!",
            'Deleted!': "تم المسح!",
            'Edit': "تعديل",
            'Delete': "مسح",
            "Created At":"تاريخ الأنشاء",
            "Name":"الأسم",
        }
    };

    var locator = new KTLocator(messages);

    // basic demo
    var demo = function() {

         datatable = $('.kt-datatable').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'GET',
                        url: '/dashboard/vacation_types',
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
                                    url: '/dashboard/vacation_types/' + data.id,
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
                    field: 'name_ar',
                    title: locator.__('Arabic Name'),
                    textAlign: 'center',

                }, {
                    field: 'name_en',
                    title: locator.__('English Name'),
                    textAlign: 'center',

                },{
                    field: 'created_at',
                    title: locator.__('Date'),
                    textAlign: 'center',

                },{
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
                                  <a class="dropdown-item " href="/dashboard/vacation_types/' + row.id + '/edit"><i class="la la-pencil"></i>' + locator.__('Edit') + '</a>\
		                          <a class="dropdown-item delete-item" href="#"><i class="la la-trash"></i>' + locator.__('Delete') + '</a>\
		                      </div>\
		                  </div>\
                        ';
                    }
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
        $('#kt_form_date').selectpicker();


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
