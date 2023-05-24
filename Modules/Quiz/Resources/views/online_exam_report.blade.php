@php
    $category=request()->get('category');
    $search_required_type=request()->get('search_required_type');
    $search_type=request()->get('search_type');
    $search_delivery_mode=request()->get('search_delivery_mode');
    $search_job_position=request()->get('job_position');
    $org_branch_code_search=request()->get('org_branch_code_search');
    $search_student_status=request()->get('student_status');
    if (!$search_delivery_mode){
        $search_delivery_mode =1;
    }
    if (!$search_student_status){
        $search_student_status =1;
    }
    $parem ='?student_status='.$search_student_status.'&category='.$category. '&type='.$search_type. '&required_type='.$search_required_type.'&mode_of_delivery='.$search_delivery_mode.'&org_branch='.$org_branch_code_search.'&job_position='.$search_job_position;
    $url = route('quizResultData').$parem;

@endphp

@extends('backend.master')
@section('mainContent')
    <input type="text" hidden value="{{ @$clas->class_name }}" id="cls">
    <input type="text" hidden value="{{ @$sec->section_name }}" id="sec">
    {!! generateBreadcrumb() !!}

    <div class="row">

        <div class="col-lg-12">
            <div class="white_box mb_30">
                <div class="white_box_tittle list_header">
                    <h4>{{__('courses.Advanced Filter')}} </h4>
                </div>
                <form action="{{route('quizResult')}}" method="GET">
                    <div class="row">

                        <div class="col-lg-3 mt-30">

                            <label class="primary_input_label" for="category">{{__('courses.Category')}}</label>
                            <select class="primary_select" name="category" id="category">
                                <option data-display="{{__('common.Select')}} {{__('courses.Category')}}"
                                        value="">{{__('common.Select')}} {{__('courses.Category')}}</option>
                                @foreach($categories->where('parent_id',0) as $category)
                                    @include('coursesetting::parts_of_course_details.category_select_option',['category'=>$category,'level'=>1,'category_search'=>request('category')])

                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 mt-30">
                            <label class="primary_input_label"
                                   for="search_type">{{__('courses.Course')}} {{__('common.Type')}}</label>
                            <select class="primary_select" name="search_type"
                                    id="search_type">
                                <option data-display="{{__('common.Select')}} {{__('common.Type')}}"
                                        value="">{{__('common.Select')}} {{__('courses.Type')}}</option>
                                <option
                                    value="1" {{request()->get('search_type')=="1"?'selected':''}}>{{__('courses.Course')}} </option>
                                <option
                                    value="2" {{request()->get('search_type')=="2"?'selected':''}}> {{__('quiz.Quiz')}}</option>
                            </select>

                        </div>
                        @if(isModuleActive('Org'))
                            <div class="col-lg-3 mt-30">
                                <label class="primary_input_label"
                                       for="search_required_type">{{__('courses.Required Type')}}</label>
                                <select class="primary_select" name="search_required_type"
                                        id="search_required_type">
                                    <option data-display="{{__('common.Select')}} {{__('courses.Required Type')}}"
                                            value="">{{__('common.Select')}} {{__('courses.Required Type')}}</option>
                                    <option
                                        value="1" {{request()->get('search_required_type')=="1"?'selected':''}}>{{__('courses.Compulsory')}} </option>
                                    <option
                                        value="0" {{request()->get('search_required_type')=="0"?'selected':''}}> {{__('courses.Open')}}</option>
                                </select>

                            </div>

                            <div class="col-lg-3 mt-30">

                                <label class="primary_input_label"
                                       for="status">{{__('courses.Delivery Mode')}}</label>
                                <select class="primary_select" name="search_delivery_mode" id="status">

                                    <option
                                        value="1" {{request('search_delivery_mode')=="1"?'selected':''}}>{{__('courses.Online')}} </option>
                                    <option
                                        value="3" {{request('search_delivery_mode')=="3"?'selected':''}}>{{__('courses.Offline')}}</option>
                                </select>

                            </div>

                            <div class="col-lg-3 mt-30">

                                <label class="primary_input_label"
                                       for="org_branch_code_search">{{__('org.Org Chart')}}</label>
                                <select class="primary_select" name="org_branch_code_search"
                                        id="org_branch_code_search">
                                    <option data-display="{{__('common.Select')}} {{__('org.Org Chart')}}"
                                            value="">{{__('common.Select')}} {{__('org.Org Chart')}}</option>
                                    @foreach($branches as $key=>$branch)
                                        @include('coursesetting::_single_select_option',['branch'=>$branch,'level'=>1,'org_branch_code_search'=>request('org_branch_code_search')])
                                    @endforeach

                                </select>

                            </div>

                            <div class="col-lg-3 mt-30">

                                <label class="primary_input_label"
                                       for="job_position">{{__('org.Job Position')}}</label>
                                <select class="primary_select" name="job_position" id="job_position">
                                    <option data-display="{{__('common.Select')}} {{__('org.Job Position')}}"
                                            value="">{{__('common.Select')}} {{__('org.Job Position')}}</option>
                                    @foreach($positions as $position)
                                        <option
                                            value="{{$position->code}}" {{request('job_position')==$position->code?'selected':''}}>{{$position->name}} </option>
                                    @endforeach
                                </select>

                            </div>
                        @endif

                        <div class="col-lg-3 mt-30">

                            <label class="primary_input_label"
                                   for="student_status">{{__('student.Student Status')}}</label>
                            <select class="primary_select" name="student_status" id="student_status">

                                <option
                                    value="1" {{request('student_status')=="1"?'selected':''}}>{{__('common.Active')}} </option>
                                <option
                                    value="0" {{request('student_status')=="0"?'selected':''}}>{{__('common.Inactive')}}</option>

                            </select>

                        </div>


                        <div class="col-lg-3  mt-30">
                            <div class="search_course_btn mt-30 ">
                                <button type="submit"
                                        class="primary-btn  mr-10 fix-gr-bg">{{__('courses.Filter')}} </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <section class="mt-20 admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row mt-40">
                <div class="col-lg-12 col-md-6">
                    <div class="box_header">
                        <div class="main-title mb_xs_20px">
                            <h3 class="mb-0 mb_xs_20px"> {{__('quiz.Result')}} {{__('common.View')}}
                                <a href="{{route('quizResultExport').$parem}}" class="primary-btn small fix-gr-bg"
                                   style="position: absolute; right: 15px;">
                                    <span class="ti-download pr-2"></span>
                                    {{__('common.Export')}}
                                </a>
                            </h3>

                        </div>
                    </div>
                </div>
            </div>
            <div class="QA_section QA_section_heading_custom check_box_table">
                <div class="QA_table ">

                    <table id="" class="table Crm_table_active3 quizReportTable">
                        <thead>
                        <tr>
                            <th> {{__('common.SL')}} </th>
                            <th> {{__('quiz.Student')}} </th>
                            <th> {{__('org.Employee ID')}} </th>
                            <th> {{__('org.Branch')}} </th>
                            <th>{{__('org.Position')}}</th>
                            <th>{{__('courses.Course')}}</th>
                            <th>{{__('quiz.Quiz')}}</th>
                            <th>{{__('common.Pass Rate')}}</th>
                            <th> {{__('common.Marks')}} </th>
                            <th> {{__('common.Result')}} </th>
                            <th> {{__('common.Start At')}} </th>
                            <th> {{__('common.End At')}} </th>
                            <th> {{__('common.Duration')}} </th>
                            <th> {{__('common.Status')}} </th>
                        </tr>
                        </thead>
                        <tbody>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection
@push('scripts')
    <script src="{{asset('/')}}/Modules/Quiz/Resources/assets/js/quiz.js"></script>


    <script>
        $('.quizReportTable').DataTable({
            bLengthChange: true,
            "lengthChange": true,
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "bDestroy": true,
            processing: true,
            serverSide: true,
            // order: [[0, "desc"]],
            "ajax": $.fn.dataTable.pipeline({
                url: '{!! $url !!}',
                pages: 5 // number of pages to cache
            }),
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
            columns: [
                {data: 'DT_RowIndex', name: 'id'},
                {data: 'student_name', name: 'student_name'},
                {data: 'employee_id', name: 'employee_id'},
                {data: 'org_chart_code', name: 'org_chart_code'},
                {data: 'org_position_code', name: 'org_position_code'},
                {data: 'course_name', name: 'course_name'},
                {data: 'quiz_name', name: 'course_name'},
                {data: 'percentage', name: 'percentage'},
                {data: 'marks', name: 'marks'},
                {data: 'result', name: 'result'},
                {data: 'start_at', name: 'start_at'},
                {data: 'end_at', name: 'end_at'},
                {data: 'duration', name: 'duration'},
                {data: 'status', name: 'status'},
            ],
            language: {
                emptyTable: "{{ __("common.No data available in the table") }}",
                search: "<i class='ti-search'></i>",
                searchPlaceholder: '{{ __("common.Quick Search") }}',
                paginate: {
                    next: "<i class='ti-arrow-right'></i>",
                    previous: "<i class='ti-arrow-left'></i>"
                }
            },
            dom: 'Blfrtip',

            columnDefs: [{
                visible: false
            }, {responsivePriority: 1, targets: 1},
                {responsivePriority: 2, targets: -1},
            ],
            responsive: true,
        });

    </script>
@endpush
