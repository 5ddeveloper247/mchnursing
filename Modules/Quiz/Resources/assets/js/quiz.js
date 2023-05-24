$(document).ready(function () {
    $("#category_id").on("change", function () {
        var url = $("#url").val();
        var lang = window._locale;

        var formData = {
            id: $(this).val(),
        };
        // get section for student
        $.ajax({
            type: "GET",
            data: formData,
            dataType: "json",
            url: url + "/" + "admin/course/ajaxGetCourseSubCategory",
            success: function (data) {
                console.log(data);
                var a = "";
                // $.loading.onAjax({img:'loading.gif'});
                $.each(data, function (i, item) {
                    if (item.length) {
                        $("#subcategory_id").find("option").not(":first").remove();
                        $("#subCategoryDiv ul").find("li").not(":first").remove();

                        $.each(item, function (i, section) {
                            $("#subcategory_id").append($("<option>", {
                                value: section.id, text: section.name[lang],
                            }));

                            $("#subCategoryDiv ul").append("<li data-value='" + section.id + "' class='option'>" + section.name[lang] + "</li>");
                        });
                    } else {
                        $("#subCategoryDiv .current").html("Subcategory");
                        $("#subcategory_id").find("option").not(":first").remove();
                        $("#subCategoryDiv ul").find("li").not(":first").remove();
                    }
                });
                console.log(a);
            },
            error: function (data) {
                console.log("Error:", data);
            },
        });
    });

    $("#subcategory_id").on("change", function () {
        var url = $("#url").val();

        var formData = {
            category_id: $('#category_id').val(), subcategory_id: $(this).val(),
        };
        console.log(formData);
        $.ajax({
            type: "GET",
            data: formData,
            dataType: "json",
            url: url + "/" + "ajaxGetCourseList",
            success: function (data) {
                $.each(data, function (i, item) {
                    if (item.length) {
                        $("#course_id").find("option").not(":first").remove();
                        $("#CourseDiv ul").find("li").not(":first").remove();

                        $.each(item, function (i, course) {
                            $("#course_id").append($("<option>", {
                                value: course.id, text: course.title2,
                            }));
                            $("#CourseDiv ul").append("<li data-value='" + course.id + "' class='option'>" + course.title2 + "</li>");
                        });
                    } else {
                        $("#CourseDiv .current").html("Select A Course *");
                        $("#course_id").find("option").not(":first").remove();
                        $("#CourseDiv ul").find("li").not(":first").remove();
                    }
                });
                console.log(a);
            },
            error: function (data) {
                console.log("Error:", data);
            },
        });
    });
    $("#course_id").on("change", function () {
        var url = $("#url").val();

        var formData = {
            category_id: $('#category_id').val(), subcategory_id: $('#subcategory_id').val(), course_id: $(this).val(),
        };
        console.log(formData);
        $.ajax({
            type: "GET",
            data: formData,
            dataType: "json",
            url: url + "/" + "ajaxGetQuizList",
            success: function (data) {
                console.log(data);
                $.each(data, function (i, item) {
                    if (item.length) {
                        $("#quiz_id").find("option").not(":first").remove();
                        $("#quiz_div ul").find("li").not(":first").remove();

                        $.each(item, function (i, course) {
                            $("#quiz_id").append($("<option>", {
                                value: course.id, text: course.title,
                            }));
                            $("#quiz_div ul").append("<li data-value='" + course.id + "' class='option'>" + course.title + "</li>");
                        });
                    } else {
                        $("#quiz_div .current").html("Select A Course *");
                        $("#quiz_id").find("option").not(":first").remove();
                        $("#quiz_div ul").find("li").not(":first").remove();
                    }
                });
                console.log(a);
            },
            error: function (data) {
                console.log("Error:", data);
            },
        });
    });
});

$(document).on('click', '.change-default-settings', function () {
    if ($(this).val() == 0) {
        $(".default-settings").hide();
    } else {
        $(".default-settings").show();
    }
});

$(document).on('click', '.set_random_question', function () {
    if ($(this).val() == 0) {
        $(".set_random_question_box").addClass('d-none');
    } else {
        $(".set_random_question_box").removeClass('d-none');
    }
});

function changeQuestionReview() {
    var checkStatus = document.getElementById("questionReview").checked;
    var showResult = document.getElementById('showResultDiv');
    if (checkStatus) {
        showResult.style.display = "none";
    } else {
        showResult.style.display = "block";
    }
}


$("#category_id, #subcategory_id, #group_id").on("change", function () {
    var url = $("#url").val();
    var formData = {
        category_id: $('#category_id').val(),
        subcategory_id: $('#subcategory_id').val(),
        group_id: $('#group_id').val(),
    };
    $.ajax({
        type: "GET",
        data: formData,
        dataType: "json",
        url: url + "/quiz/getTotalQuizNumbers",
        success: function (data) {
            $('#TotalQuiz').html(data);
            $('#random_question_number').attr('max', data);
        },
        error: function (data) {
            console.log("Error:", data);
        },
    });
});

if ($('#table_id, .table-data').length) {
    let datatable = $('#table_id, .table-data').DataTable({
        bLengthChange: true,
        "lengthChange": true,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "bDestroy": true,
        language: {
            search: "<i class='ti-search'></i>", searchPlaceholder: 'Quick Search', paginate: {
                next: "<i class='ti-arrow-right'></i>", previous: "<i class='ti-arrow-left'></i>"
            }
        },
        // columns: [
        //     {"width": "15%"},
        //     {"width": "15%"},
        //     {"width": "40%"},
        //     {"width": "10%"},
        //     {"width": "10%"},
        //     {"width": "10%"},
        //
        // ],
        dom: 'Blfrtip',
        buttons: [{
            extend: 'copyHtml5',
            text: '<i class="far fa-copy"></i>',
            title: $("#logo_title").val(),
            titleAttr: '{{ __("common.Copy") }}',
            exportOptions: {
                columns: ':visible', columns: ':not(:last-child)',
            }
        }, {
            extend: 'excelHtml5',
            text: '<i class="far fa-file-excel"></i>',
            titleAttr: '{{ __("common.Excel") }}',
            title: $("#logo_title").val(),
            margin: [10, 10, 10, 0],
            exportOptions: {
                columns: ':visible', columns: ':not(:last-child)',
            },

        }, {
            extend: 'csvHtml5',
            text: '<i class="far fa-file-alt"></i>',
            titleAttr: '{{ __("common.CSV") }}',
            exportOptions: {
                columns: ':visible', columns: ':not(:last-child)',
            }
        }, {
            extend: 'pdfHtml5',
            text: '<i class="far fa-file-pdf"></i>',
            title: $("#logo_title").val(),
            titleAttr: '{{ __("common.PDF") }}',
            exportOptions: {
                columns: ':visible', columns: ':not(:last-child)',
            },
            orientation: 'landscape',
            pageSize: 'A4',
            margin: [0, 0, 0, 12],
            alignment: 'center',
            header: true,
            customize: function (doc) {
                doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
            }

        }, {
            extend: 'print',
            text: '<i class="fa fa-print"></i>',
            titleAttr: '{{ __("common.Print") }}',
            title: $("#logo_title").val(),
            exportOptions: {
                columns: ':not(:last-child)',
            }
        }, {
            extend: 'colvis', text: '<i class="fa fa-columns"></i>', postfixButtons: ['colvisRestore']
        }],

        responsive: true,
        columnDefs: [{responsivePriority: 1, targets: 0}, {responsivePriority: 2, targets: -2},]
    });
}

check_losing_focus();
$('.losing_focus_acceptance_number_check').change(function (e) {
    e.preventDefault();
    check_losing_focus();
});


function check_losing_focus() {
    let isChecked = $('.losing_focus_acceptance_number_check').is(":checked");
    if (isChecked) {
        $('.losing_total_count_div').show();
    } else {
        $('.losing_total_count_div').hide();
    }
}

function setLosingQuestionTime() {
    let perLosingQTime = document.getElementById("losingPerQusCount");
    let totalLosingQTime = document.getElementById("losingTotalQusCount");
    let losingType = document.getElementById("losingType").value;

    if (losingType != 1) {
        perLosingQTime.style.display = "block";
        totalLosingQTime.style.display = "none";
    } else {
        totalLosingQTime.style.display = "block";
        perLosingQTime.style.display = "none";
    }
}


$(document).on('click', '.quiz-re-test', function (e) {
    e.preventDefault();
    let url = $(this).data('url');
    $('#reTestConfirmModal').modal('show');
    $('#reTestConfirm').attr('href', url);
});
