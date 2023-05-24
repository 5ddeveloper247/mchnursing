$(document).on('click', '#Addplan', function () {
    $('#plans').hide();
    $('#new_plan').show();
    $("#configreset").trigger('click');
    $("#programs_id").val(0);
});
$(document).on('click', '#hideplan', function () {
    $('#plans').show();
    $('#new_plan').hide();
    $('#plan_id').val('');
    $("#programs").next(".nice-select").find('.current').text('Select Program');
    $("#programs").next(".nice-select").css('pointer-events', '');
    $("#configreset").trigger('click');
});
// $(".save_button_parent").click(function () {
//     $(this).attr('disabled','true');
//     $(this).find('i').attr('class','').addClass('fa fa-spinner fa-spin fa-lg');
// });
$(document).on('click', '#add_student_btn', function () {
    $('#plandetailId').val(0)
    $("#configreset1").trigger('click');
    $("#plandetialtype").next(".nice-select").find('.current').text('Select Type');
    $("#plandetialtype").next(".nice-select").css('pointer-events', '');
});
$(document).on('change', '#programs', function () {
    let program_id = $('#programs').val();
    getProgram(program_id);

});

$(document).on('click', '#saveplandata', function () {

    $(this).attr('disabled', 'true');
    $(this).find('i').attr('class', '').addClass('fa fa-spinner fa-spin fa-lg');
    let id = $('#plan_id').val();
    let program_id = $('#programs').val();
  
    if($('#programs_id').val() != 0){
      
        program_id = $('#programs_id').val();
       
    }
    let url = $('#url').val();


    url = url + '/admin/program/plan/save';

    let token = $('.csrf_token').val();
    let amount = $('#addAmount').val();
    let sdate = $('#plansdate').val();
    let edate = $('#planedate').val();
    let cdate = $('#Classdate').val();
    let no_of_students = $('#no_of_students').val();

    
    if (program_id == '') {
        $(this).removeAttr('disabled');
        $(this).find('i').attr('class', '');
        toastr.error('Program must be select', 'Error');
        return false;
    }
    if (no_of_students == '') {
        $(this).removeAttr('disabled');
        $(this).find('i').attr('class', '');
        toastr.error('No of students must be added', 'Error');
        return false;
    }
    if (no_of_students <= 0) {
        $(this).removeAttr('disabled');
        $(this).find('i').attr('class', '');
        toastr.error('No of students must be greater than 0', 'Error');
        return false;
    }

    if (amount == '') {
        $(this).removeAttr('disabled');
        $(this).find('i').attr('class', '');
        toastr.error('Amount must be added', 'Error');
        return false;
    }

    if (amount <= 0) {
        $(this).removeAttr('disabled');
        $(this).find('i').attr('class', '');
        toastr.error('Amount must be greater than 0', 'Error');
        return false;
    }
    if (sdate == '') {
        $(this).removeAttr('disabled', 'true');
        $(this).find('i').attr('class', '').addClass('ti-check');
        toastr.error('Start date must be select', 'Error');
        return false;
    }
    if (edate == '') {
        $(this).removeAttr('disabled', 'true');
        $(this).find('i').attr('class', '').addClass('ti-check');
        toastr.error('End date must be select', 'Error');
        return false;
    }
    if (cdate == '') {
        $(this).removeAttr('disabled', 'true');
        $(this).find('i').attr('class', '').addClass('ti-check');
        toastr.error('Class date must be select', 'Error');
        return false;
    }
   

    $.ajax({

        type: 'GET',

        url: url,

        data: {

            '_token': token,
            'amount': amount,
            'parent_id': program_id,
            'type': 'program',
            'sdate': sdate,
            'edate': edate,
            'cdate': cdate,
            'no_of_students': no_of_students,
            'id': id

        },

        success: function (plan) {

            console.log(plan)
            $('#saveplandata').removeAttr('disabled');
            $('#saveplandata').find('i').attr('class', '');
            if (plan.msg) {
                toastr.error(plan.msg, 'Error');
            } else {
                $('#plan_id').val(plan.id);
                plandetaillist(plan.id);
                planlist();
                toastr.success('PLan Created Successfully', 'Success');
            }

        },

        error: function (data) {
            $('#saveplandata').removeAttr('disabled');
            $('#saveplandata').find('i').attr('class', '');
            toastr.error('Something Went Wrong', 'Error');

        }

    });


});

$(document).on('click', '#saveplandetail', function () {

    $(this).attr('disabled', 'true');
    $(this).find('i').attr('class', '').addClass('fa fa-spinner fa-spin fa-lg');

    let total_amount = parseInt($('#addAmount').val());
    let planed_amount = parseInt($('#planed_amount').val());
    let pre_amount = parseInt($('#planed_amount').val());

    let id = $('#plandetailId').val();
    let plan_id = $('#plan_id').val();

    let url = $('#url').val();

    url = url + '/admin/program/plan/detail/save';

    let token = $('.csrf_token').val();
    let type = $('#plandetialtype').val();
    let amount = $('#plandetailAmount').val();
    let sdate = $('#sdate').val();
    let edate = $('#edate').val();

    let total_planed_amount = parseInt(amount) + planed_amount;
    if (parseInt(id) > 0) {
        total_planed_amount = total_planed_amount - pre_amount;
    }

    if (plan_id == 0 && plan_id == '') {
        $(this).removeAttr('disabled', 'true');
        $(this).find('i').attr('class', '').addClass('ti-check');
        toastr.error('Plan  must be save', 'Error');
        return false;
    }
    // if(type == ''){
    //     $(this).removeAttr('disabled','true');
    //     $(this).find('i').attr('class','').addClass('ti-check');
    //     toastr.error('Type must be select', 'Error');
    //     return false;
    // }
    if (amount == '') {
        $(this).removeAttr('disabled', 'true');
        $(this).find('i').attr('class', '').addClass('ti-check');
        toastr.error('Amount must be added', 'Error');
        return false;
    }
    if (amount <= 0) {
        $(this).removeAttr('disabled');
        $(this).find('i').attr('class', '');
        toastr.error('Amount must be greater than 0', 'Error');
        return false;
    }
    if (sdate == '') {
        $(this).removeAttr('disabled', 'true');
        $(this).find('i').attr('class', '').addClass('ti-check');
        toastr.error('Start date must be select', 'Error');
        return false;
    }
    if (edate == '') {
        $(this).removeAttr('disabled', 'true');
        $(this).find('i').attr('class', '').addClass('ti-check');
        toastr.error('End date must be select', 'Error');
        return false;
    }
    if (total_planed_amount > total_amount) {
        $(this).removeAttr('disabled', 'true');
        $(this).find('i').attr('class', '').addClass('ti-check');
        toastr.error('You enter a greater amount', 'Error');
        return false;
    }


    $.ajax({

        type: 'GET',

        url: url,

        data: {

            '_token': token,
            'amount': amount,
            'sdate': sdate,
            'type': type,
            'edate': edate,
            'plan_id': plan_id,
            'id': id

        },

        success: function (planDetail) {

            console.log(planDetail)
            $("#saveplandetail").removeAttr('disabled', 'true');
            $("#saveplandetail").find('i').attr('class', '').addClass('ti-check');
            if (planDetail.msg) {
                toastr.error(planDetail.msg, 'Error');
            } else {
                $('#planed_amount').val(planDetail.planed_amount);
                $("#configreset1").trigger('click');
                $('#add_student').modal('hide');
                plandetaillist(plan_id);
                planlist();
                toastr.success('PLan Created Successfully', 'Success');
            }
        },

        error: function (data) {

            $("#saveplandetail").removeAttr('disabled', 'true');
            $("#saveplandetail").find('i').attr('class', '').addClass('ti-check');
            toastr.error('Something Went Wrong', 'Error');

        }

    });


});

function editPlan(plan_id, program_id) {
    $('#plans').hide();
    $('#new_plan').show();
    $("#plan_id").val(plan_id);
    $("#programs").val(program_id);
    $("#programs_id").val(program_id);
    $("#programs").next(".nice-select").css('pointer-events', 'none');
    getProgram(program_id);
    getPlan(plan_id)
    plandetaillist(plan_id);
}

function getProgram(program_id) {
    let url = $('#url').val();

    url = url + '/admin/program/getprogram/' + program_id;

    // let token = $('.csrf_token').val();


    $.ajax({

        type: 'GET',

        url: url,

        data: {

            // '_token': token,

        },

        success: function (program) {

            console.log(program)

            $('#program_name').val(program.programtitle);
            $('#program_amount').val(program.totalcost);
            $("#programs").next(".nice-select").find('.current').text(program.programtitle);

        },

        error: function (data) {

            toastr.error('Something Went Wrong', 'Error');

        }

    });


}

function getPlan(plan_id) {
    let url = $('#url').val();

    url = url + '/admin/program/plan/get/' + plan_id;

    // let token = $('.csrf_token').val();


    $.ajax({

        type: 'GET',

        url: url,

        data: {

            // '_token': token,

        },

        success: function (plan) {

            console.log(plan)
            $('#plan_id').val(plan.id);
            $('#addAmount').val(plan.amount);
            $('#planed_amount').val(plan.planed_amount);
            $('#plansdate').val(plan.sdate);
            $('#planedate').val(plan.edate);
            $('#Classdate').val(plan.cdate);
            $('#no_of_students').val(plan.no_of_students);

        },

        error: function (data) {

            toastr.error('Something Went Wrong', 'Error');

        }

    });


}

function editPlandetail(plandetail_id) {
    let url = $('#url').val();

    url = url + '/admin/program/plan/detail/get/' + plandetail_id;

    // let token = $('.csrf_token').val();


    $.ajax({

        type: 'GET',

        url: url,

        data: {

            // '_token': token,

        },

        success: function (plandetail) {

            console.log(plandetail)
            $('#plandetailId').val(plandetail.id);
            // $('#plandetialtype').val(plandetail.type);
            // $('#plandetialtype > option[value='+plandetail.type+']').attr('selected',true);
            $('#plandetailAmount').val(plandetail.amount);
            $('#preamount').val(plandetail.amount);
            $('#sdate').val(plandetail.sdate);
            $('#edate').val(plandetail.edate);

            // $("#plandetialtype").next(".nice-select").find('.current').text(plandetail.type);
            // $("#plandetialtype").next(".nice-select").css('pointer-events','none');
        },

        error: function (data) {

            toastr.error('Something Went Wrong', 'Error');

        }

    });


}


