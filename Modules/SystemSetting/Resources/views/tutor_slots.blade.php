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


    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">

            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('Tutor Slots')}} {{__('common.List')}}</h3>
                        </div>

                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">

                                <table class="table Crm_table_active3">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{__('common.SL')}}</th>
                                        <th scope="col">{{__('Slot')}}</th>
                                        <th scope="col">{{__('Start Time')}}</th>
                                        <th scope="col">{{__('End Time')}}</th>
                                        <th scope="col">{{__('common.Action')}}</th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                    @php
                                        $i =0;
                                    @endphp

                                    @foreach($slots as $slot)
                                        @php
                                            $i++;
                                        @endphp
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{__('Slot')}} {{ $i }}</td>
                                            <td>{{$slot->start_time}}</td>
                                            <td>{{$slot->end_time}}</td>
                                            <td> <button data-item-id="{{$slot->id}}"
                                                         class="dropdown-item primary-btn fix-gr-bg setHoursInstructor"
                                                         type="button">
                                                    Set
                                                </button></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Add Modal Item_Details -->

                {{--                <div class="modal fade admin-query" id="deleteInstructor">--}}
                {{--                    <div class="modal-dialog modal-dialog-centered">--}}
                {{--                        <div class="modal-content">--}}
                {{--                            <form action="{{route('instructor.delete')}}" method="POST">--}}
                {{--                                @csrf--}}
                {{--                                <div class="modal-header">--}}
                {{--                                    <h4 class="modal-title">{{__('common.Delete')}} {{__('quiz.Instructor')}} </h4>--}}
                {{--                                    <button type="button" class="close" data-dismiss="modal"><i--}}
                {{--                                            class="ti-close "></i></button>--}}
                {{--                                </div>--}}

                {{--                                <div class="modal-body">--}}
                {{--                                    <div class="text-center">--}}

                {{--                                        <h4>{{__('common.Are you sure to delete ?')}}</h4>--}}
                {{--                                    </div>--}}
                {{--                                    <input type="hidden" name="id" value="" id="instructorDeleteId">--}}

                {{--                                    <div class="mt-40 d-flex justify-content-between">--}}
                {{--                                        <button type="button" class="primary-btn tr-bg"--}}
                {{--                                                data-dismiss="modal">{{__('common.Cancel')}}</button>--}}
                {{--                                        <button class="primary-btn fix-gr-bg"--}}
                {{--                                                type="submit">{{__('common.Delete')}}</button>--}}

                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                            </form>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                                <div class="modal fade admin-query" id="setHoursInstructor">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form action="{{route('set.slot.time')}}" method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h4 class="modal-title">{{__('Set Hours')}} </h4>
                                                    <button type="button" class="close" data-dismiss="modal"><i
                                                            class="ti-close "></i></button>
                                                </div>

                                                <div class="modal-body">
                                                    <input type="hidden" name="id" value="{{ Session::get('slot_id') }}" id="slot_id">
                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="">{{__('Start Time')}} <strong
                                                                        class="text-danger">*</strong></label>
                                                                <input class="primary-input primary_input_field  time form-control"
                                                                       {{$errors->first('start_time') ? 'autofocus' : ''}}
                                                                       value="{{old('start_time')}}"
                                                                       name="start_time"
                                                                       id="start_time"
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
@endsection

@push('scripts')
    @if ($errors->any())
        <script>

            @if(Session::has('slot_id'))
            $('#setHoursInstructor').modal('show');
            @endif
        </script>
    @endif


<script>
    $(document).on('click', '.setHoursInstructor', function () {
        let slot_id = $(this).data('item-id');
        $('#slot_id').val(slot_id);
        let instructor_hours = $(this).data('item-hours');
        $('#instructorhours').val(instructor_hours);
        $('#setHoursInstructor').modal('show');

    });
</script>

@endpush


