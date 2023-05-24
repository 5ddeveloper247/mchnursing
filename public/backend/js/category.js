function update_active_status(el) {
    let url = $('.status_route').val();
    let token = $('.csrf_token').val();
    if (el.checked) {
        let status = 1;
    } else {
        let status = 0;
    }
    $.post(url, {
            _token: token,
            id: el.value,
            status: status
        },
        function (data) {
            if (data.message == "success") {
                toastr.success('Success', 'Status has been changed');
            } else {
                toastr.error('Error', 'Ops, Something went wrong');
            }
        });
}

if ($('#table_id_table').length) {
    $('#table_id_table').DataTable({
        language: {
            paginate: {
                next: "<i class='ti-arrow-right'></i>",
                previous: "<i class='ti-arrow-left'></i>"
            }
        },
        bFilter: false,
        bLengthChange: false
    });
}

if ($('#table_id_table_one').length) {
    $('#table_id_table_one').DataTable({
        language: {
            paginate: {
                next: "<i class='ti-arrow-right'></i>",
                previous: "<i class='ti-arrow-left'></i>"
            }
        },
        bFilter: false,
        bLengthChange: false
    });
}

if ($('#table_id, .table-data').length) {
    $('#table_id, .table-data').DataTable({
        bLengthChange: true,
        "lengthChange": true,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "bDestroy": true,
        language: {
            search: "<i class='ti-search'></i>",
            searchPlaceholder: 'Quick Search',
            paginate: {
                next: "<i class='ti-arrow-right'></i>",
                previous: "<i class='ti-arrow-left'></i>"
            }
        },
        dom: 'Blfrtip',
        buttons: [
            {
                extend: 'copyHtml5',
                text: '<i class="far fa-copy"></i>',
                title: $("#logo_title").val(),
                titleAttr: '{{ __("common.Copy") }}',
                exportOptions: {
                    columns: ':visible',
                    columns: ':not(:last-child)',
                }
            },
            {
                extend: 'excelHtml5',
                text: '<i class="far fa-file-excel"></i>',
                titleAttr: '{{ __("common.Excel") }}',
                title: $("#logo_title").val(),
                margin: [10, 10, 10, 0],
                exportOptions: {
                    columns: ':visible',
                    columns: ':not(:last-child)',
                },

            },
            {
                extend: 'csvHtml5',
                text: '<i class="far fa-file-alt"></i>',
                titleAttr: '{{ __("common.CSV") }}',
                exportOptions: {
                    columns: ':visible',
                    columns: ':not(:last-child)',
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="far fa-file-pdf"></i>',
                title: $("#logo_title").val(),
                titleAttr: '{{ __("common.PDF") }}',
                exportOptions: {
                    columns: ':visible',
                    columns: ':not(:last-child)',
                },
                orientation: 'landscape',
                pageSize: 'A4',
                margin: [0, 0, 0, 12],
                alignment: 'center',
                header: true,
                customize: function (doc) {
                    doc.content[1].table.widths =
                        Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                }

            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i>',
                titleAttr: '{{ __("common.Print") }}',
                title: $("#logo_title").val(),
                exportOptions: {
                    columns: ':not(:last-child)',
                }
            },
            {
                extend: 'colvis',
                text: '<i class="fa fa-columns"></i>',
                postfixButtons: ['colvisRestore']
            }
        ],

        responsive: true,
        columnDefs: [
            {responsivePriority: 1, targets: 0},
            {responsivePriority: 2, targets: -2},
        ]
    });
}
