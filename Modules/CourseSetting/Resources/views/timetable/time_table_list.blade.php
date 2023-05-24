@extends('backend.master')
@push('styles')

@endpush

@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">


        <div class="white_box mb_30  student-details header-menu">
            <div class="white_box_tittle list_header">
                <h4>{{ $time_table->name }} {{__('View')}} </h4>

            </div>
            <div class="col-lg-12">
                <div class="QA_section QA_section_heading_custom check_box_table">
                    <div class="QA_table">
                        <!-- table-responsive -->
                        <div class="">
                            <table id="lms_table" class="table">
                                <thead>
                                <tr>
                                    <th scope="col" style="width: 135px;"> {{__('Weeks')}}</th>
                                    <th scope="col" style="width: 135px;"> {{__('Monday')}}</th>
                                    <th scope="col" style="width: 135px;"> {{__('Tuesday')}}</th>
                                    <th scope="col" style="width: 135px;"> {{__('Wednesday')}}</th>
                                    <th scope="col" style="width: 135px;"> {{__('Thursday')}}</th>
                                    <th scope="col" style="width: 135px;"> {{__('Friday')}}</th>
                                    <th scope="col" style="width: 135px;"> {{__('Saturday')}}</th>
                                    <th scope="col" style="width: 135px;"> {{__('Sunday')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($time_tables as $time_table)
                                    <tr>
                                        <td>Week {{ $time_table->week }}</td>
                                        @foreach($time_table->weekWiseDays as $WeekWiseDay)
                                            <td class="p-1">
                                               <span class="float-right" data-id="{{ $WeekWiseDay->id }}"
                                                     data-date="{{ $WeekWiseDay->date }}"
                                                     data-Instructor_id="{{ $WeekWiseDay->Instructor_id }}"
                                                     data-comment="{!! $WeekWiseDay->comment !!}"
                                                     onclick="edit(this,{{ $time_table->week }},{{ $WeekWiseDay->week }})">
                                                    <i class="fa fa-pencil-alt" aria-hidden="true"></i>
                                               </span>
                                                <div id="block_{{ $time_table->week }}_{{ $WeekWiseDay->week }}"  >
                                                    @if(!empty($WeekWiseDay->date))
                                                        <p>({{ Carbon\Carbon::parse($WeekWiseDay->date)->format('Y M d') }})</p>
                                                        @if(!empty($WeekWiseDay->Instructor_id))
                                                            <p><strong>{{ !empty($WeekWiseDay->Instructor_id) ? (!empty($WeekWiseDay->instructor) ?$WeekWiseDay->instructor->name : 'Deleted User' ):'' }}</strong></p>
                                                        @endif
{{--                                                        @if(!empty($WeekWiseDay->comment))--}}
{{--                                                            <p>{!! substr($WeekWiseDay->comment ,0,40) !!}...</p>--}}
{{--                                                        @endif--}}
                                                    @else
                                                        <h1>-</h1>
                                                    @endif
                                                </div>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <div class="modal fade admin-query" id="addTimeTableModel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('Add.list.TimeTable') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">{{__('Add Time Table')}} </h4>
                        <button type="button" class="close" data-dismiss="modal"><i
                                class="ti-close "></i></button>
                    </div>
                    <input type="hidden" name="id" id="time_table_id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for="">{{__('Date')}} <strong
                                            class="text-danger">*</strong></label>
                                    <input class="primary-input primary_input_field date form-control"
                                           {{$errors->first('date') ? 'autofocus' : ''}}
                                           value="{{old('date')}}"
                                           name="date"
                                           placeholder="-" type="text" id="date">
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for="">{{__('Tutor')}} <strong
                                            class="text-danger">*</strong></label>
                                    <select class="primary_select " name="Instructor_id"
                                            id="Instructor_id" {{$errors->has('assign_instructor') ? 'autofocus' : ''}}>
                                        <option data-display="{{__('common.Select')}} {{__('courses.Instructor')}}"
                                                value="">{{__('common.Select')}} {{__('courses.Instructor')}} </option>
                                        @foreach($instructors as $instructor)
                                            <option value="{{$instructor->id}}">{{@$instructor->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for="">{{__('Comment')}} <strong
                                            class="text-danger">*</strong></label>
                                    <textarea class="primary-input primary_input_field form-control"
                                              {{$errors->first('comment') ? 'autofocus' : ''}}
                                              name="comment"
                                              rows="4" id="comment">{{old('date')}}</textarea>
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
        function edit(el, week, day) {
            var id = $(el).attr('data-id');
            var date = $(el).attr('data-date');
            var Instructor_id = $(el).attr('data-Instructor_id');
            var comment = $(el).attr('data-comment');

            $('#date').val(date);
            $('#Instructor_id').val(Instructor_id);
            $('#Instructor_id').niceSelect('update');
            $('#comment').val(comment);
            $('#time_table_id').val(id);

            $('#addTimeTableModel').modal('show');
        }
    </script>
@endpush
