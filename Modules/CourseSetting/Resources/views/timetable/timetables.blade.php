@extends('backend.master')



@php
    $table_name = 'time_tables';
@endphp
@section('table')
    {{ $table_name }}
@endsection
@section('mainContent')
    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">

            <div class="row justify-content-center mt-50">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('Time Tables')}}</h3>
                                <ul class="d-flex">
                                    <li>
                                        <a class="primary-btn radius_30px mr-10 fix-gr-bg"
                                           href="javascript:void(0)" id="addTimeTable">
                                            <i class="ti-plus"></i>{{__('common.Add')}} {{__('Time Table')}}</a>
                                    </li>
                                </ul>

                        </div>

                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table">
                            <!-- table-responsive -->
                            <div class="">
                                <table id="lms_table" class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col"> {{__('common.SL')}}</th>
                                        <th scope="col"> {{__('Name')}}</th>
                                        <th scope="col">{{__('common.Status')}}</th>
                                        <th scope="col">{{__('common.Action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>



                <div class="modal fade admin-query" id="addTimeTableModel">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{ route('Add.TimeTable') }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h4 class="modal-title">{{__('Add Time Table')}} </h4>
                                    <button type="button" class="close" data-dismiss="modal"><i
                                            class="ti-close "></i></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('Name')}} <strong
                                                        class="text-danger">*</strong></label>
                                                <input class="primary-input primary_input_field form-control"
                                                       {{$errors->first('name') ? 'autofocus' : ''}}
                                                       value="{{old('name')}}"
                                                       name="name"
                                                       placeholder="-" type="text">
                                            </div>
                                        </div>


                                    </div>

                                    <div class="mt-40 d-flex justify-content-between">
                                        <button type="button" class="primary-btn tr-bg"
                                                data-dismiss="modal">{{__('common.Cancel')}}</button>
                                        <button class="primary-btn fix-gr-bg"
                                                type="submit">{{__('common.Save')}}</button>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>


        </div>
    </section>
    @include('backend.partials.delete_modal')
@endsection
@push('scripts')
    @if ($errors->any())
        <script>
            @if(Session::has('Addtime'))
            $('#addTimeTableModel').modal('show');
            @endif
        </script>
    @endif
    <script>
        $(document).on('click', '#addTimeTable', function () {
            $('#addTimeTableModel').modal('show');
        });
    </script>

    @php
        $url = route('getAllTimeTable');
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
                {data: 'name', name: 'name'},
                {data: 'status', name: 'status'},
                {
                    data: 'action', name: 'action'
                },

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
                {responsivePriority: 2, targets: 2},
                {responsivePriority: 2, targets: -2},
            ],
            responsive: true,
        });


    </script>
@endpush
