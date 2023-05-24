@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{ asset('public/backend/css/student_list.css') }}" />
@endpush
@php
    $table_name = 'payment_plans';
@endphp
@section('table')
    {{ $table_name }}
@endsection

@section('mainContent')
    <section id="new_plan" class="admin-visitor-area up_st_admin_visitor" style="display: none;">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mr-30 mb_xs_15px mb_sm_20px mb-0">{{ __('Program Plan') }}</h3>
                            <ul class="d-flex">
                                <li><button class="primary-btn radius_30px fix-gr-bg mr-10"
                                        id="hideplan">{{ __('Back') }}</button>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="white_box mb_30">
                        <form action="javascript:void(0)" id="addplanform">
                            @csrf
                            <input type="hidden" id="plan_id" value="0">
                            <input type="hidden" id="programs_id" value="0">
                            <div class="row">
                                <div class="col-lg-3 mt-30">
                                    <label class="primary_input_label" for="category">{{ __('Programs') }}</label>
                                    <select class="primary_select" name="programs" id="programs">
                                        <option data-display="{{ __('common.Select') }} {{ __('Program') }}" value="">
                                            {{ __('common.Select') }} {{ __('Program') }}</option>
                                        @foreach ($programs as $program)
                                            <option value="{{ $program->id }}">{{ $program->programtitle }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3 mt-30">

                                    <label class="primary_input_label" for="type">{{ __('Name') }}</label>
                                    <input class="primary_input_field" name="program_name" placeholder="-" type="text"
                                        id="program_name" value="" disabled>

                                </div>
                                <div class="col-lg-3 mt-30" style="display: none;">

                                    <label class="primary_input_label" for="instructor">{{ __('Program Amount') }}</label>
                                    <input class="primary_input_field" name="program_amount" placeholder="-" type="number"
                                        id="program_amount" value="" disabled>

                                </div>
                                <div class="col-lg-3 mt-30">
                                    <label class="primary_input_label" for="status">{{ __('No. of students') }}</label>
                                    <input class="primary_input_field" name="no_of_students" placeholder="-" type="number"
                                        id="no_of_students" value="0">
                                </div>
                                <div class="col-lg-3 mt-30">
                                    <label class="primary_input_label" for="course">{{ __('Amount') }}</label>
                                    <input class="primary_input_field" name="amount" placeholder="-" type="number"
                                        id="addAmount" value="">
                                </div>
                                <div class="col-lg-3 mt-30">
                                    <label class="primary_input_label" for="status">{{ __('Planed Amount') }}</label>
                                    <input class="primary_input_field" name="planed_amount" placeholder="-" type="number"
                                        id="planed_amount" value="0" disabled>
                                </div>
                                <div class="col-xl-3 mt-30">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{ __('Start Date') }} <strong
                                                class="text-danger">*</strong> </label>
                                        <div class="primary_datepicker_input">
                                            <div class="no-gutters input-right-icon">
                                                <div class="col">
                                                    <div class="">
                                                        <input placeholder="Date"
                                                            class="primary_input_field primary-input date form-control"
                                                            id="plansdate"
                                                            {{ $errors->first('plansdate') ? 'autofocus' : '' }}
                                                            type="text" name="plansdate" value="{{ old('plansdate') }}"
                                                            autocomplete="off">
                                                    </div>
                                                </div>
                                                <button class="" type="button">
                                                    <i class="ti-calendar" id="start-date-icon"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 mt-30">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{ __('end Date') }} <strong
                                                class="text-danger">*</strong></label>
                                        <div class="primary_datepicker_input">
                                            <div class="no-gutters input-right-icon">
                                                <div class="col">
                                                    <div class="">
                                                        <input placeholder="Date"
                                                            class="primary_input_field primary-input date form-control"
                                                            id="planedate"
                                                            {{ $errors->first('planedate') ? 'autofocus' : '' }}
                                                            type="text" name="planedate"
                                                            value="{{ old('planedate') }}" autocomplete="off">
                                                    </div>
                                                </div>
                                                <button class="" type="button">
                                                    <i class="ti-calendar" id="start-date-icon"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 mt-30">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{ __('Class Date') }} <strong
                                                class="text-danger">*</strong></label>
                                        <div class="primary_datepicker_input">
                                            <div class="no-gutters input-right-icon">
                                                <div class="col">
                                                    <div class="">
                                                        <input placeholder="Date"
                                                            class="primary_input_field primary-input date form-control"
                                                            id="Classdate"
                                                            {{ $errors->first('Classdate') ? 'autofocus' : '' }}
                                                            type="text" name="Classdate"
                                                            value="{{ old('Classdate') }}" autocomplete="off">
                                                    </div>
                                                </div>
                                                <button class="" type="button">
                                                    <i class="ti-calendar" id="start-date-icon"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-20">
                                    <div class="search_course_btn text-right">
                                        <input type="reset" id="configreset" value="Reset" hidden>
                                        <button class="primary-btn radius_30px fix-gr-bg save_button_parent mr-10"
                                            id="saveplandata"><i class=""></i> {{ __('Save') }} </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="d-flex p-3">
                            <li><a class="primary-btn radius_30px fix-gr-bg mr-10" data-toggle="modal"
                                    id="add_student_btn" data-target="#add_student" href="#"><i
                                        class="ti-plus"></i>{{ __('Add Program Plan Detail') }}</a>
                            </li>

                        </ul>
                    </div>
                </div>
                <div class="col-lg-12 mt-40">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table">
                            <!-- table-responsive -->
                            <div class="">
                                <table id="plan_detail_table" class="Crm_table_active3 table">
                                    <thead>
                                        <tr>
                                            <th scope="col">{{ __('common.SL') }}</th>
                                            <th scope="col">{{ __('Type') }}</th>
                                            <th scope="col">{{ __('Amount') }}</th>
                                            <th scope="col">{{ __('Start Date') }}</th>
                                            <th scope="col">{{ __('End Date') }}</th>
                                            <th scope="col">{{ __('common.Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>


    <section id="plans" class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mr-30 mb_xs_15px mb_sm_20px mb-0">{{ __('Program Plan') }}</h3>

                            <ul class="d-flex">

                                <li><button class="primary-btn radius_30px fix-gr-bg mr-10" id="Addplan"><i
                                            class="ti-plus"></i>{{ __('Add Program Plan') }}</button>
                                </li>

                            </ul>

                        </div>
                    </div>
                </div>
                <div class="col-lg-12 m-5">
                    <div class="white_box p-3" style="height: 120px;">
                        <label class="primary_input_label" for="category">{{ __('Programs') }}</label>
                        <select class="primary_select" onchange="planlist(this.value)">
                            <option data-display="{{ __('common.Select') }} {{ __('Program') }}" value="">
                                {{ __('common.Select') }} {{ __('Program') }}</option>
                            @foreach ($programs as $program)
                                <option value="{{ $program->id }}">{{ $program->programtitle }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg-12 mt-40">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table">
                            <!-- table-responsive -->
                            <div class="">
                                <table id="lms_table" class="Crm_table_active3 table">
                                    <thead>
                                        <tr>
                                            <th scope="col">{{ __('common.SL') }}</th>
                                            <th scope="col">{{ __('Program') }}</th>
                                            <th scope="col">{{ __('Start Date') }}</th>
                                            <th scope="col">{{ __('End Date') }}</th>
                                            <th scope="col">{{ __('Amount') }}</th>
                                            {{--                                        <th scope="col">{{__('Planed Amount')}}</th> --}}
                                            <th scope="col">{{ __('common.Status') }}</th>
                                            <th scope="col">{{ __('common.Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <div class="modal fade admin-query" id="add_student">
        <div class="modal-dialog modal_1000px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('Add New Installment') }}</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="ti-close"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="javascript:void(0)">
                        @csrf
                        <input type="hidden" id="plandetailId" value="0">
                        <input type="hidden" id="preamount" value="0">

                        <div class="row">
                            {{--                            <div class="col-xl-6"> --}}
                            {{--                                <div class="primary_input mb-25"> --}}
                            {{--                                    <label class="primary_input_label" for="">{{__('Type')}} --}}
                            {{--                                        <strong --}}
                            {{--                                            class="text-danger">*</strong></label> --}}
                            {{--                                    <select class="primary_select" name="type" id="plandetialtype"> --}}
                            {{--                                        <option data-display="{{__('common.Select')}} {{__('Type')}}" --}}
                            {{--                                                value="">{{__('common.Select')}} {{__('Type')}}</option> --}}
                            {{--                                            <option --}}
                            {{--                                                value="initial" >Initial</option> --}}
                            {{--                                        @for ($i = 1; $i <= 9; $i++) --}}
                            {{--                                        <option --}}
                            {{--                                            value="installment{{ $i }}" >Installment{{ $i }}</option> --}}
                            {{--                                        @endfor --}}
                            {{--                                    </select> --}}
                            {{--                                </div> --}}
                            {{--                            </div> --}}
                            <div class="col-xl-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('Amount') }}
                                        <strong class="text-danger">*</strong></label>
                                    <input class="primary_input_field" name="amount" placeholder="-" type="number"
                                        id="plandetailAmount" value="{{ old('amount') }}"
                                        {{ $errors->first('type') ? 'autofocus' : '' }}>
                                </div>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ __('Start Date') }} <strong
                                            class="text-danger">*</strong> </label>
                                    <div class="primary_datepicker_input">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="">
                                                    <input placeholder="Date"
                                                        class="primary_input_field primary-input date form-control"
                                                        id="sdate" {{ $errors->first('sdate') ? 'autofocus' : '' }}
                                                        type="text" name="sdate" value="{{ old('sdate') }}"
                                                        autocomplete="off">
                                                </div>
                                            </div>
                                            <button class="" type="button">
                                                <i class="ti-calendar" id="start-date-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ __('end Date') }} <strong
                                            class="text-danger">*</strong></label>
                                    <div class="primary_datepicker_input">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="">
                                                    <input placeholder="Date"
                                                        class="primary_input_field primary-input date form-control"
                                                        id="edate" {{ $errors->first('edate') ? 'autofocus' : '' }}
                                                        type="text" name="edate" value="{{ old('edate') }}"
                                                        autocomplete="off">
                                                </div>
                                            </div>
                                            <input type="reset" id="configreset1" value="Reset" hidden>
                                            <button class="" type="button">
                                                <i class="ti-calendar" id="start-date-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 pt_15 text-center">
                            <div class="d-flex justify-content-center">
                                <button class="primary-btn semi_large2 fix-gr-bg save_button_parent"
                                    id="saveplandetail"><i class="ti-check"></i> {{ __('common.Save') }}
                                    {{ __('Plan') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="modal fade admin-query" id="deleteStudent">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('common.Delete')}} {{__('student.Student')}} </h4>
                    <button type="button" class="close" data-dismiss="modal"><i
                            class="ti-close "></i></button>
                </div>

                <div class="modal-body">
                    <form action="" method="post">
                        @csrf

                        <div class="text-center">

                            <h4>{{__('common.Are you sure to delete ?')}} </h4>
                        </div>
                        <input type="hidden" name="id" value="" id="studentDeleteId">
                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="primary-btn tr-bg"
                                    data-dismiss="modal">{{__('common.Cancel')}}</button>

                            <button class="primary-btn fix-gr-bg"
                                    type="submit">{{__('common.Delete')}}</button>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div> --}}
    <div class="modal fade admin-query" id="delete_plan">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('Delete Plan') }}</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="ti-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">{{ __('common.Are you sure to delete') }}?</h3>
                    <div class="col-lg-12 text-center">
                        <div class="d-flex justify-content-between mt-40">
                            <button type="button" class="primary-btn tr-bg"
                                data-dismiss="modal">{{ __('common.Cancel') }}</button>
                            <a id="delete_plan_link"
                                class="primary-btn semi_large2 fix-gr-bg">{{ __('common.Delete') }}</a>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade admin-query" id="delete_installment">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('Delete Installment') }}</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="ti-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">{{ __('common.Are you sure to delete') }}?</h3>
                    <div class="col-lg-12 text-center">
                        <div class="d-flex justify-content-between mt-40">
                            <button type="button" class="primary-btn tr-bg"
                                data-dismiss="modal">{{ __('common.Cancel') }}</button>
                            <a id="delete_installment_link"
                                class="primary-btn semi_large2 fix-gr-bg">{{ __('common.Delete') }}</a>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function confirm_plan_modal(delete_url) {
            jQuery('#delete_plan').modal('show', {
                backdrop: 'static'
            });
            document.getElementById('delete_plan_link').setAttribute('href', delete_url);
        }

        function confirm_installment_modal(delete_url) {
            jQuery('#delete_installment').modal('show', {
                backdrop: 'static'
            });
            document.getElementById('delete_installment_link').setAttribute('href', delete_url);
        }
    </script>
    @if ($errors->any())
        <script>
            @if (Session::has('type'))
                @if (Session::get('type') == 'store')
                    $('#add_student').modal('show');
                @else
                    $('#editStudent').modal('show');
                @endif
            @endif
        </script>
    @endif


    @php
        $url = route('plan.getAllPlans');
        $plandetailurl = route('plan.getPlandetails');
    @endphp



    <script>
        planlist();

        function planlist(id = null) {
            let table = $('#lms_table').DataTable({
                bLengthChange: true,
                "bDestroy": true,
                "lengthChange": true,
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                processing: true,
                serverSide: true,
                order: [
                    [0, "desc"]
                ],
                "ajax": $.fn.dataTable.pipeline({
                    url: '{!! $url !!}',
                    data: {
                        'program_id': id
                    },
                    pages: 5 // number of pages to cache
                }),
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id',
                        orderable: true
                    },
                    // {data: 'planed_amount', name: 'planed_amount'},
                    {
                        data: 'program',
                        name: 'program'
                    },
                    {
                        data: 'sdate',
                        name: 'sdate'
                    },
                    {
                        data: 'edate',
                        name: 'edate'
                    },
                    {
                        data: 'amount',
                        name: 'amount',
                        orderable: false
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
                language: {
                    emptyTable: "{{ __('common.No data available in the table') }}",
                    search: "<i class='ti-search'></i>",
                    searchPlaceholder: '{{ __('common.Quick Search') }}',
                    paginate: {
                        next: "<i class='ti-arrow-right'></i>",
                        previous: "<i class='ti-arrow-left'></i>"
                    }
                },
                dom: 'Blfrtip',
                buttons: [{
                        extend: 'copyHtml5',
                        text: '<i class="far fa-copy"></i>',
                        title: $("#logo_title").val(),
                        titleAttr: '{{ __('common.Copy') }}',
                        exportOptions: {
                            columns: ':visible',
                            columns: ':not(:last-child)',
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="far fa-file-excel"></i>',
                        titleAttr: '{{ __('common.Excel') }}',
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
                        titleAttr: '{{ __('common.CSV') }}',
                        exportOptions: {
                            columns: ':visible',
                            columns: ':not(:last-child)',
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="far fa-file-pdf"></i>',
                        title: $("#logo_title").val(),
                        titleAttr: '{{ __('common.PDF') }}',
                        exportOptions: {
                            columns: ':visible',
                            columns: ':not(:last-child)',
                        },
                        orientation: 'landscape',
                        pageSize: 'A4',
                        margin: [0, 0, 0, 12],
                        alignment: 'center',
                        header: true,
                        customize: function(doc) {
                            doc.content[1].table.widths =
                                Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        }

                    },
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i>',
                        titleAttr: '{{ __('common.Print') }}',
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
                    {
                        responsivePriority: 1,
                        targets: 0
                    },
                    {
                        responsivePriority: 1,
                        targets: 2
                    },
                    {
                        responsivePriority: 1,
                        targets: -1
                    },
                    {
                        responsivePriority: 2,
                        targets: -2
                    },
                ],
                responsive: true,
            });
        }

        function plandetaillist(id) {
            let table = $('#plan_detail_table').DataTable({
                bLengthChange: true,
                "bDestroy": true,
                "lengthChange": true,
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                processing: true,
                serverSide: true,
                order: [
                    [1, "asc"]
                ],
                "ajax": $.fn.dataTable.pipeline({
                    url: '{!! $plandetailurl !!}',
                    data: {
                        'plan_id': id
                    },
                    pages: 5 // number of pages to cache
                }),
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id',
                        orderable: true
                    },
                    {
                        data: 'type',
                        name: 'type',
                        orderable: false
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'sdate',
                        name: 'sdate'
                    },
                    {
                        data: 'edate',
                        name: 'edate',
                        orderable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ],
                language: {
                    emptyTable: "{{ __('common.No data available in the table') }}",
                    search: "<i class='ti-search'></i>",
                    searchPlaceholder: '{{ __('common.Quick Search') }}',
                    paginate: {
                        next: "<i class='ti-arrow-right'></i>",
                        previous: "<i class='ti-arrow-left'></i>"
                    }
                },
                dom: 'Blfrtip',
                buttons: [{
                        extend: 'copyHtml5',
                        text: '<i class="far fa-copy"></i>',
                        title: $("#logo_title").val(),
                        titleAttr: '{{ __('common.Copy') }}',
                        exportOptions: {
                            columns: ':visible',
                            columns: ':not(:last-child)',
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="far fa-file-excel"></i>',
                        titleAttr: '{{ __('common.Excel') }}',
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
                        titleAttr: '{{ __('common.CSV') }}',
                        exportOptions: {
                            columns: ':visible',
                            columns: ':not(:last-child)',
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="far fa-file-pdf"></i>',
                        title: $("#logo_title").val(),
                        titleAttr: '{{ __('common.PDF') }}',
                        exportOptions: {
                            columns: ':visible',
                            columns: ':not(:last-child)',
                        },
                        orientation: 'landscape',
                        pageSize: 'A4',
                        margin: [0, 0, 0, 12],
                        alignment: 'center',
                        header: true,
                        customize: function(doc) {
                            doc.content[1].table.widths =
                                Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        }

                    },
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i>',
                        titleAttr: '{{ __('common.Print') }}',
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
                    {
                        responsivePriority: 1,
                        targets: 0
                    },
                    {
                        responsivePriority: 1,
                        targets: 2
                    },
                    {
                        responsivePriority: 1,
                        targets: -1
                    },
                    {
                        responsivePriority: 2,
                        targets: -2
                    },
                ],
                responsive: true,
            });
        }


        // let table = $('#allData').DataTable() ;
        // table.clearPipeline();
        // table.ajax.reload();
    </script>
    <script></script>
    <script src="{{ asset('public/backend/js/program_plan.js') }}"></script>

@endpush
