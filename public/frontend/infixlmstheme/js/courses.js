$(document).ready(function () {
    $("#order,  .price,  .language, .level, .category").on('change keyup paste', function (e) {
        ApplyFilter();
    });
});

function ApplyFilter() {
    var order = $('#order').find(":selected").val();
    let url = $('.class_route').val();
    let search = $('.search').val();
    var type = [];
    $('.price:checked').each(function (i) {
        type[i] = $(this).val();
    });
    url += '/?price=' + type.toString();

    $('.language:checked').each(function (i) {
        url += '&lang_id[]=' + $(this).val();
    });

    $('.level:checked').each(function (i) {
        url += '&level[]=' + $(this).val();
    });

    $('.category:checked').each(function (i) {
        url += '&category_id[]=' + $(this).val();
    });
    if (order.toString() != "None") {
        url += '&order=' + order.toString();
    }

    if (search != "" && search != undefined) {
        url += '&search=' + search;
    }
    window.location.href = url;

}
