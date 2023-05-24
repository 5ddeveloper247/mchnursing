@extends('setting::layouts.master')

@section('mainContent')
    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">

            <h4 class="pl-4 mb-3">Missing Migration</h4>
            <div class="col-lg-12">
                <div class="QA_section QA_section_heading_custom check_box_table">
                    <div class="QA_table ">
                        <!-- table-responsive -->
                        <div class="">
                            <table id="lms_table" class="table Crm_table_active3">
                                <thead>
                                <tr>
                                    <th scope="col">{{__('common.SL')}} </th>
                                    <th scope="col"> File</th>

                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i=0;
                                @endphp
                                @foreach($pendingMigrations as $key=>$migration)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>{{$key}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-auto">
                    <div class="submit_btn text-center mt-4">
                        <button class="primary_btn_large confirmBtn" type="submit" data-toggle="tooltip"
                                id="general_info_sbmt_btn"><i class="ti-check"></i>
                            Migration All missing File
                        </button>
                    </div>
                </div>
            </div>
        </div>


    </section>


    <div class="modal fade admin-query" id="confirmModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('common.Confirm')}}   </h4>
                    <button type="button" class="close" data-dismiss="modal"><i
                            class="ti-close "></i></button>
                </div>

                <div class="modal-body">
                    <form action="{{route('setting.migration')}}" method="post">
                        @csrf

                        <div class="text-center">

                            <h4>{{__('common.Are you sure')}} </h4>
                        </div>
                        <input type="hidden" name="id" value="" id="ipDeleteId">
                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="primary-btn tr-bg"
                                    data-dismiss="modal">{{__('common.Cancel')}}</button>

                            <button class="primary-btn fix-gr-bg"
                                    type="submit">{{__('common.Confirm')}}</button>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        $(document).on('click', '.confirmBtn', function () {
            $("#confirmModal").modal('show');
        })
    </script>
@endpush
