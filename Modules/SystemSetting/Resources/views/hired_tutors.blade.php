@extends('backend.master')
@push('styles')
    {{--    <link rel="stylesheet" href="{{asset('public/backend/css/student_list.css')}}"/>--}}
@endpush

{{--@section('table')--}}
{{--    @php--}}
{{--        $table_name='users';--}}
{{--    @endphp--}}
{{--    {{$table_name}}--}}
{{--@stop--}}
@section('mainContent')

    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">

            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('Hired Tutors')}} {{__('common.List')}}</h3>


                        </div>
                        @if(Auth::user()->role_id == 2)
                            <a href="{{ route('tutor.slots') }}" class="primary-btn fix-gr-bg">Set Hours</a>
                        @endif
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <table id="lms_table" class="table Crm_table_active3">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{__('common.SL')}}</th>
                                        @if(\Illuminate\Support\Facades\Auth::user()->role_id == 1)
                                            <th scope="col">{{__('Instructor')}}</th>
                                        @endif
                                        <th scope="col">{{__('Student')}}</th>
                                        <th scope="col">{{__('Course')}}</th>
                                        <th scope="col">{{__('Date')}}</th>
                                        <th scope="col">{{__('Start Time')}}</th>
                                        <th scope="col">{{__('End Time')}}</th>
                                        <th scope="col">{{__('Price')}}</th>
                                        <th scope="col">{{__('Start Join')}}</th>
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
@endsection

@push('scripts')


    @php
        $url = route('get.all.slots');
    @endphp

    <script>
        let table = $('#lms_table').DataTable({
            bLengthChange: true,
            "lengthChange": true,
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "bDestroy": true,
            processing: true,
            serverSide: true,
            order: [[0, "desc"]],
            "ajax": $.fn.dataTable.pipeline({
                url: '{!! $url !!}',
                pages: 5 // number of pages to cache
            }),
            columns: [
                {data: 'DT_RowIndex', name: 'id'},
                    @if(\Illuminate\Support\Facades\Auth::user()->role_id == 1)
                {
                    data: 'instructor', name: 'instructor'
                },
                    @endif
                {
                    data: 'student', name: 'student'
                },
                {
                    data: 'course', name: 'course'
                },
                {data: 'date', name: 'date'},
                {
                    data: 'start_time', name: 'start_time'
                },
                {
                    data: 'end_time', name: 'end_time'
                },
                {
                    data: 'price', name: 'price'
                },
                {data: 'action', name: 'action'},

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
            columnDefs: [{
                visible: false
            },
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 1, targets: 2},
                {responsivePriority: 2, targets: -2},
            ],
            responsive: true,
        });


    </script>
    {{--    <script src="{{asset('public/backend/js/instructor_list.js')}}"></script>--}}
@endpush


