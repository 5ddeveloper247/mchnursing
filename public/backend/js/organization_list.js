$(".toggle-password").click(function () {

    var input = $(this).closest('.input-group').find('input');

    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
});
$(".imgBrowse").change(function (e) {
    e.preventDefault();
    var file = $(this).closest('.primary_file_uploader').find('.imgName');
    var filename = $(this).val().split('\\').pop();
    file.val(filename);
});

$(document).on('click', '.editOrganization', function () {
    let organization_id = $(this).data('item-id');
    let url = $('#url').val();
    url = url + '/admin/get-user-data/' + organization_id
    let token = $('.csrf_token').val();

    $.ajax({
        type: 'POST',
        url: url,
        data: {
            '_token': token,
        },
        success: function (organization) {
            $('#organizationId').val(organization.id);
            $('#organizationName').val(organization.name);
            $('#organizationAbout').summernote("code", organization.about);
            $('#organizationDob').val(organization.dob);
            $('#organizationPhone').val(organization.phone);
            $('#organizationEmail').val(organization.email);
            $('#organizationImage').val(organization.image);
            $('#organizationFacebook').val(organization.facebook);
            $('#organizationTwitter').val(organization.twitter);
            $('#organizationLinkedin').val(organization.linkedin);
            $('#organizationInstragram').val(organization.instagram);
            $("#editOrganization").modal('show');
        },
        error: function (data) {
            toastr.error('Something Went Wrong', 'Error');
        }
    });


});


$(document).on('click', '.deleteOrganization', function () {
    let id = $(this).data('id');
    $('#organizationDeleteId').val(id);
    $("#deleteOrganization").modal('show');
})

$(document).on('click', '#add_organization_btn', function () {
    $('#addName').val('');
    $('#addAbout').html('');
    $('#startDate').val('');
    $('#addPhone').val('');
    $('#addEmail').val('');
    $('#addPassword').val('');
    $('#addCpassword').val('');
    $('#addFacebook').val('');
    $('#addTwitter').val('');
    $('#addLinked').val('');
    $('#addInstagram').val('');
});


let table = $('#lms_table').DataTable({
    bLengthChange: true,
    "lengthChange": true,
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
    "bDestroy": true,
    processing: true,
    serverSide: true,
    order: [[0, "desc"]],
    "ajax": $.fn.dataTable.pipeline({
        url: $('#getAllOrganizationData').val(),
        pages: 5 // number of pages to cache
    }),
    columns: [
        {data: 'DT_RowIndex', name: 'id'},
        {data: 'image', name: 'image', orderable: false},
        {data: 'name', name: 'name'},
        {data: 'email', name: 'email'},
        {data: 'students', name: 'students'},
        {data: 'instructors', name: 'instructors'},
        {data: 'courses', name: 'courses'},
        {data: 'quizzes', name: 'quizzes'},
        {data: 'classes', name: 'classes'},
        {data: 'created_at', name: 'created_at'},
        {data: 'status', name: 'status', orderable: false},
        {data: 'action', name: 'action', orderable: false},

    ],
    language: {
        search: "<i class='ti-search'></i>",
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
            exportOptions: {
                columns: ':visible',
                columns: ':not(:last-child)',
            }
        },
        {
            extend: 'excelHtml5',
            text: '<i class="far fa-file-excel"></i>',
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
            exportOptions: {
                columns: ':visible',
                columns: ':not(:last-child)',
            }
        },
        {
            extend: 'pdfHtml5',
            text: '<i class="far fa-file-pdf"></i>',
            title: $("#logo_title").val(),
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
    columnDefs: [{
        visible: false
    },
        {responsivePriority: 1, targets: 0},
        {responsivePriority: 1, targets: 2},
        {responsivePriority: 2, targets: -2},
    ],
    responsive: true,
});
