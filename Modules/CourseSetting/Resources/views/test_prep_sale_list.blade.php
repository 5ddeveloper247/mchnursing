@extends('backend.master')


@php
    $table_name = 'test_prep_sale';
    // if (\Route::current()->getName() == 'getAllCourse') {
    //     $url = route('getAllCourseData') . '?course_status=3';
    //     $text = trans('common.All');
    // } elseif (\Route::current()->getName() == 'getActiveCourse') {
    //     $url = route('getAllCourseData') . '?course_status=1';
    //     $text = trans('common.Active');
    // } elseif (\Route::current()->getName() == 'getPendingCourse') {
    //     $url = route('getAllCourseData') . '?course_status=0';
    //     $text = trans('common.Pending');
    // } elseif (\Route::current()->getName() == 'courseSortBy' || \Route::current()->getName() == 'courseSortByGet') {
    //     $category = request()->get('category');
    //     $type = request()->get('type');
    //     $instructor = request()->get('instructor');
    //     $status = request()->get('search_status');
    //     $search_required_type = request()->get('search_required_type');
    //     $search_delivery_mode = request()->get('search_delivery_mode');
    //     $url = route('getAllCourseData') . '?search_status=' . $status . '&category=' . $category . '&type=' . $type . '&instructor=' . $instructor . '&required_type=' . $search_required_type . '&mode_of_delivery=' . $search_delivery_mode;
    //     $text = trans('common.Filter');
    // } else {
    $url = route('viewSaleListData');
    // $text = trans('common.All');
    // }
@endphp
{{-- @dd($url) --}}
{{-- @dd($test_prep_sale) --}}
@section('table')
    {{ $table_name }}
@stop
@section('mainContent')
    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center mt-50">
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table">
                            <!-- table-responsive -->
                            <div class="">
                                <table id="lms_table" class="classList table">
                                    <thead>
                                        <tr>
                                            <th scope="col"> {{ __('common.SL') }}</th>

                                            <th scope="col">{{ __('Test-Prep') }} {{ __('coupons.Title') }}</th>
                                            {{-- <th scope="col">{{__('courses.Delivery')}}</th> --}}
                                            <th scope="col">{{ __('Start Date') }}</th>

                                            <th scope="col">{{ __('End Date') }}</th>
                                            <th scope="col">{{ __('Price') }}</th>

                                            <th scope="col">{{ __('common.Status') }}</th>
                                            {{-- <th scope="col">{{ __('common.Action') }}</th> --}}
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
    @include('backend.partials.delete_modal')
    @include('backend.partials.add_to_sale')
@endsection
@push('scripts')
    <script src="{{ asset('/') }}/Modules/CourseSetting/Resources/assets/js/course.js"></script>



    <script>
        let table = $('.classList').DataTable({
            bLengthChange: true,
            "lengthChange": true,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            "bDestroy": true,
            processing: true,
            serverSide: true,
            order: [
                [0, "desc"]
            ],
            "ajax": $.fn.dataTable.pipeline({
                url: '{!! $url !!}',
                pages: 5 // number of pages to cache
            }),
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'id'
                },
                {
                    data: 'test_prep_id',
                    name: 'test_prep_id'
                },
                {
                    data: 'start_date',
                    name: 'start_date'
                },
                {
                    data: 'end_date',
                    name: 'end_date'
                },
                {
                    data: 'price',
                    name: 'price',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false
                },
                // {
                //     data: 'action',
                //     name: 'action',
                //     orderable: false
                // },

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
                    responsivePriority: 2,
                    targets: 2
                },
                {
                    responsivePriority: 2,
                    targets: -2
                },
            ],
            responsive: true,
        });

        $('#lms_table_info').append('<span id="add_here"> new-dynamic-text</span>');

        $(document).ready(function() {
            let form = $('#add_to_sale_link');
            $('#add_to_sale_btn').on('click', function() {
                let start_date = form.find('#start_date');
                let end_date = form.find('#end_date');
                let price = form.find('#price');
                let status = form.find('#status');

                if (start_date.val() == '' || start_date.val() == undefined) {
                    toastr.error('Please Select Start Date !', '', {
                        timeOut: 3000
                    });
                    return false;
                }

                if (end_date.val() == '' || end_date.val() == undefined) {
                    toastr.error('Please Select Start Date !', '', {
                        timeOut: 3000
                    });
                    return false;
                }

                if (price.val() == '' || price.val() == undefined) {
                    toastr.error('Please Enter Price !', '', {
                        timeOut: 3000
                    });
                    return false;
                }

                if (status.val() == '' || status.val() == undefined) {
                    toastr.error('Please Select Status !', '', {
                        timeOut: 3000
                    });
                    return false;
                }
            });
        });
    </script>
@endpush
