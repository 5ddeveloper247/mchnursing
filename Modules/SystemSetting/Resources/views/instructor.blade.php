@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{asset('public/backend/css/student_list.css')}}"/>
@endpush

@section('table')
    @php
        $table_name='users';
    @endphp
    {{$table_name}}
@stop
@section('mainContent')

    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">

            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('quiz.Instructor')}} {{__('common.List')}}</h3>
                            @if (permissionCheck('instructor.store'))
                                <ul class="d-flex">
                                    <li>
                                        {{--                                        @if(isModuleActive('Appointment'))--}}
                                        {{--                                            <a class="primary-btn radius_30px mr-10 fix-gr-bg"--}}
                                        {{--                                               id="add_instructor_btn"--}}
                                        {{--                                               href="{{ route('appointment.instructor.create') }}"><i--}}
                                        {{--                                                    class="ti-plus"></i>{{__('instructor.Add Instructor')}}</a>--}}
                                        {{--                                        @else--}}
                                        {{--                                            <a class="primary-btn radius_30px mr-10 fix-gr-bg" data-toggle="modal"--}}
                                        {{--                                               id="add_instructor_btn"--}}
                                        {{--                                               data-target="#add_instructor" href="#"><i--}}
                                        {{--                                                    class="ti-plus"></i>{{__('instructor.Add Instructor')}}</a>--}}
                                        {{--                                        @endif--}}

                                    </li>
                                </ul>
                            @endif

                        </div>

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
                                        <th scope="col">{{__('common.Image')}}</th>
                                        <th scope="col">{{__('common.Name')}}</th>
                                        <th scope="col">{{__('common.Email')}}</th>
                                        @if(isModuleActive('OrgInstructorPolicy'))
                                            <th scope="col">{{__('policy.Group')}} {{__('policy.Policy')}}</th>
                                        @endif
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
                <!-- Add Modal Item_Details -->
                <!-- new product -->
                <div class="modal fade admin-query" id="add_instructor">
                    <div class="modal-dialog modal_1000px modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{__('common.Add New')}} {{__('quiz.Instructor')}}</h4>
                                <button type="button" class="close " data-dismiss="modal">
                                    <i class="ti-close "></i>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form action="{{route('instructor.store')}}" method="POST"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{__('common.Name')}} <strong
                                                        class="text-danger">*</strong></label>
                                                <input class="primary_input_field" name="name" placeholder="-"
                                                       id="addName"
                                                       type="text"
                                                       value="{{ old('name') }}" {{$errors->first('name') ? 'autofocus' : ''}}>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label"
                                                       for="">{{__('instructor.About')}}</label>
                                                <textarea class="lms_summernote" name="about" id="addAbout" cols="30"
                                                          rows="10">{{ old('about') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label" for="">{{__('common.Date of Birth')}}
                                                </label>
                                                <div class="primary_datepicker_input">
                                                    <div class="no-gutters input-right-icon">
                                                        <div class="col">
                                                            <div class="">
                                                                <input placeholder="{{__('common.Date')}}"
                                                                       class="primary_input_field primary-input date form-control"
                                                                       id="" type="text" name="dob"
                                                                       value="{{old('dob')}}"
                                                                       {{$errors->first('dob') ? 'autofocus' : ''}}
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
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('common.Phone')}} </label>
                                                <input class="primary_input_field" value="{{old('phone')}}" name="phone"
                                                       id="addPhone"
                                                       placeholder="-" {{$errors->first('phone') ? 'autofocus' : ''}}
                                                       type="number">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{__('common.Email')}} <strong
                                                        class="text-danger">*</strong></label>
                                                <input class="primary_input_field" name="email" placeholder="-"
                                                       id="addEmail"
                                                       value="{{old('email')}}"
                                                       {{$errors->first('email') ? 'autofocus' : ''}}
                                                       type="email">
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label" for="">{{__('common.Image')}}
                                                    <small>{{__('student.Recommended size')}} (330x400)</small></label>
                                                <div class="primary_file_uploader">
                                                    <input class="primary-input imgName" type="text"
                                                           id="placeholderFileOneName"
                                                           placeholder="{{__('student.Browse Image file')}}"
                                                           readonly="">
                                                    <button class="" type="button">
                                                        <label class="primary-btn small fix-gr-bg"
                                                               for="document_file">{{__('common.Browse')}}</label>
                                                        <input type="file" class="d-none imgBrowse" name="image"
                                                               id="document_file">
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{__('Password')}} <strong
                                                        class="text-danger">*</strong></label>
                                                <div class="input-group mb-2 mr-sm-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"><i style="cursor:pointer;"
                                                                                         class="fas fa-eye-slash eye toggle-password"></i>
                                                        </div>
                                                    </div>
                                                    <input type="password" class="form-control primary_input_field"
                                                           id="addPassword" name="password"
                                                           placeholder="{{__('common.Minimum 8 characters')}}" {{$errors->first('password') ? 'autofocus' : ''}}>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('Confirm Password')}} <strong
                                                        class="text-danger">*</strong></label>
                                                <div class="input-group mb-2 mr-sm-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"><i style="cursor:pointer;"
                                                                                         class="fas fa-eye-slash eye toggle-password"></i>
                                                        </div>
                                                    </div>
                                                    <input type="password" class="form-control primary_input_field"
                                                           {{$errors->first('password_confirmation') ? 'autofocus' : ''}}
                                                           id="addCpassword" name="password_confirmation"
                                                           placeholder="{{__('common.Minimum 8 characters')}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for=""> {{__('common.Facebook URL')}}</label>
                                                <input class="primary_input_field" name="facebook" placeholder="-"
                                                       id="addFacebook"
                                                       type="text" value="{{ old('facebook') }}">
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for=""> {{__('common.Twitter URL')}}</label>
                                                <input class="primary_input_field" name="twitter" placeholder="-"
                                                       id="addTwitter"
                                                       type="text" value="{{ old('twitter') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for=""> {{__('common.LinkedIn URL')}}</label>
                                                <input class="primary_input_field" name="linkedin" placeholder="-"
                                                       id="addLinkedin"
                                                       type="text" value="{{ old('linkedin') }}">
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for=""> {{__('common.Instagram URL')}}</label>
                                                <input class="primary_input_field" name="instagram" placeholder="-"
                                                       id="addInstagram"
                                                       type="text" value="{{ old('instagram') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-center pt_15">
                                        <div class="d-flex justify-content-center">
                                            <button class="primary-btn semi_large2  fix-gr-bg" id="save_button_parent"
                                                    type="submit"><i
                                                    class="ti-check"></i> {{__('common.Save')}} {{__('courses.Instructor')}}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade admin-query" id="editInstructor">
                    <div class="modal-dialog modal_1000px modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{__('common.Update')}} {{__('quiz.Instructor')}}</h4>
                                <button type="button" class="close " data-dismiss="modal">
                                    <i class="ti-close "></i>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form action="{{route('instructor.update')}}" method="POST"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="" id="instructorId">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('common.Name')}} <strong
                                                        class="text-danger">*</strong></label>
                                                <input class="primary_input_field"
                                                       {{$errors->first('name') ? 'autofocus' : ''}}
                                                       value="{{old('name')}}"
                                                       name="name"
                                                       id="instructorName"
                                                       placeholder="-" type="text">
                                            </div>
                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label"
                                                       for="">{{__('instructor.About')}}</label>
                                                <textarea class="lms_summernote" name="about"
                                                          id="instructorAbout"
                                                          cols="30"
                                                          rows="10">{{old('about')}}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label"
                                                       for="">{{__('instructor.Date of Birth')}}
                                                </label>
                                                <div class="primary_datepicker_input">
                                                    <div class="no-gutters input-right-icon">
                                                        <div class="col">
                                                            <div class="">
                                                                <input placeholder="Date"
                                                                       class="primary_input_field primary-input date form-control"
                                                                       id="instructorDob"
                                                                       {{$errors->first('dob') ? 'autofocus' : ''}}
                                                                       type="text" name="dob"
                                                                       value="{{old('dob')}}"
                                                                       autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <button class="" type="button">
                                                            <i class="ti-calendar"
                                                               id="start-date-icon"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('common.Phone')}}  </label>
                                                <input class="primary_input_field"
                                                       value="{{old('phone')}}"
                                                       name="phone" placeholder="-"
                                                       id="instructorPhone"
                                                       type="number" {{$errors->first('phone') ? 'autofocus' : ''}}>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('common.Email')}} <strong
                                                        class="text-danger">*</strong></label>
                                                <input class="primary_input_field"
                                                       value="{{old('email')}}"
                                                       name="email" placeholder="-"
                                                       id="instructorEmail"
                                                       type="email" {{$errors->first('email') ? 'autofocus' : ''}}>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label"
                                                       for="">{{__('common.Image')}}
                                                    <small>{{__('student.Recommended size')}}
                                                        (330x400)</small></label>
                                                <div class="primary_file_uploader">
                                                    <input class="primary-input imgName"
                                                           type="text"
                                                           id="instructorImage"
                                                           readonly="">
                                                    <button class="" type="button">
                                                        <label
                                                            class="primary-btn small fix-gr-bg"
                                                            for="document_file_edit">{{__('common.Browse')}}</label>
                                                        <input type="file"
                                                               class="d-none imgBrowse"
                                                               name="image"
                                                               id="document_file_edit">
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('common.Password')}} </label>

                                                <div class="input-group mb-2 mr-sm-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"><i
                                                                style="cursor:pointer;"
                                                                class="fas fa-eye-slash eye toggle-password"></i>
                                                        </div>
                                                    </div>
                                                    <input type="password"
                                                           class="form-control primary_input_field"
                                                           id="password" name="password"
                                                           placeholder="{{__('common.Minimum 8 characters')}}" {{$errors->first('password') ? 'autofocus' : ''}}>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('common.Confirm Password')}}
                                                </label>

                                                <div class="input-group mb-2 mr-sm-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"><i
                                                                style="cursor:pointer;"
                                                                class="fas fa-eye-slash eye toggle-password"></i>
                                                        </div>
                                                    </div>
                                                    <input type="password"
                                                           class="form-control primary_input_field"
                                                           id="password"
                                                           name="password_confirmation"
                                                           placeholder="{{__('common.Minimum 8 characters')}}" {{$errors->first('password_confirmation') ? 'autofocus' : ''}}>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for=""> {{__('common.Facebook URL')}}</label>
                                                <input class="primary_input_field"
                                                       value="{{old('facebook')}}"
                                                       name="facebook" placeholder="-"
                                                       id="instructorFacebook"
                                                       type="text">
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for=""> {{__('common.Twitter URL')}}</label>
                                                <input class="primary_input_field"
                                                       value="{{old('twitter')}}"
                                                       name="twitter" placeholder="-"
                                                       id="instructorTwitter"
                                                       type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for=""> {{__('common.LinkedIn URL')}}</label>
                                                <input class="primary_input_field"
                                                       value="{{old('linkedin')}}"
                                                       name="" placeholder="-"
                                                       id="instructorLinkedin"
                                                       type="text">
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for=""> {{__('common.Instagram URL')}}</label>
                                                <input class="primary_input_field"
                                                       value="{{old('instagram')}}"
                                                       name="instagram" placeholder="-"
                                                       id="instructorInstragram"
                                                       type="text">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-center pt_15">
                                        <div class="d-flex justify-content-center">
                                            <button class="primary-btn semi_large2  fix-gr-bg"
                                                    id="save_button_parent" type="submit"><i
                                                    class="ti-check"></i> {{__('common.Update')}} {{__('courses.Instructor')}}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade admin-query" id="deleteInstructor">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{route('instructor.delete')}}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h4 class="modal-title">{{__('common.Delete')}} {{__('quiz.Instructor')}} </h4>
                                    <button type="button" class="close" data-dismiss="modal"><i
                                            class="ti-close "></i></button>
                                </div>

                                <div class="modal-body">
                                    <div class="text-center">

                                        <h4>{{__('common.Are you sure to delete ?')}}</h4>
                                    </div>
                                    <input type="hidden" name="id" value="" id="instructorDeleteId">

                                    <div class="mt-40 d-flex justify-content-between">
                                        <button type="button" class="primary-btn tr-bg"
                                                data-dismiss="modal">{{__('common.Cancel')}}</button>
                                        <button class="primary-btn fix-gr-bg"
                                                type="submit">{{__('common.Delete')}}</button>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade admin-query" id="setHoursInstructor">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{route('instructor.set.hours')}}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h4 class="modal-title">{{__('Set Hours')}} </h4>
                                    <button type="button" class="close" data-dismiss="modal"><i
                                            class="ti-close "></i></button>
                                </div>

                                <div class="modal-body">
                                    <input type="hidden" name="id" value="{{ Session::get('hours_id') }}"
                                           id="instructorSethoursId">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('Type')}} </label>
                                                <div class="col-md-6 col-sm-6 mb-25">
                                                    <label class="primary_checkbox d-flex mr-12 nowrap"
                                                           onclick="setprice(75)">
                                                        <input type="radio" id="instructortypeNursing"
                                                               name="type"
                                                               value="1" {{old('type')==1?"checked":""}} >
                                                        <span class="checkmark mr-2"></span> {{__('Nursing')}}</label>
                                                </div>
                                                <div class="col-md-6 col-sm-6 mb-25">
                                                    <label class="primary_checkbox d-flex mr-12 nowrap"
                                                           onclick="setprice(35)">
                                                        <input type="radio" id="instructortypeGened"
                                                               name="type"
                                                               value="2" {{old('type')==2?"checked":""}} >
                                                        <span class="checkmark mr-2"></span> {{__('Gen-ed')}}</label>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('Hours')}} <strong
                                                        class="text-danger">*</strong></label>
                                                <input class="primary_input_field"
                                                       {{$errors->first('hours') ? 'autofocus' : ''}}
                                                       value="{{old('hours')}}"
                                                       name="hours"
                                                       id="instructorhours"
                                                       placeholder="-" type="text">
                                            </div>
                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('Price')}} <strong
                                                        class="text-danger">*</strong></label>
                                                <input class="primary_input_field"
                                                       {{$errors->first('price') ? 'autofocus' : ''}}
                                                       value="{{old('price')}}"
                                                       name="price"
                                                       id="instructorprice"
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
            @if(Session::has('type'))
            @if(Session::get('type')=="store")
            $('#add_instructor').modal('show');
            @else
            $('#editInstructor').modal('show');
            @endif
            @endif
            @if(Session::has('hours_id'))
            $('#setHoursInstructor').modal('show');
            @endif
        </script>
    @endif

    @php
        $url = route('getAllInstructorData');
    @endphp
    <script>
        $(document).on('click', '.setHoursInstructor', function () {
            let instructor_id = $(this).data('item-id');
            $('#instructorSethoursId').val(instructor_id);
            let instructor_hours = $(this).data('item-hours');
            $('#instructorhours').val(instructor_hours);
            let instructor_price = $(this).data('item-price');
            $('#instructorprice').val(instructor_price);
            let instructor_type = $(this).data('item-type');
            if (instructor_type == 1) {
                $('#instructortypeNursing').attr('checked', true);
                $('#instructortypeGened').attr('checked', false);
            }
            if (instructor_type == 2) {
                $('#instructortypeGened').attr('checked', true);
                $('#instructortypeNursing').attr('checked', false);
            }
            $('#setHoursInstructor').modal('show');

        });

        function setprice(price) {
            $('#instructorprice').val(price);
        }
    </script>
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
                {data: 'image', name: 'image', orderable: false},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                    @if(isModuleActive('OrgInstructorPolicy'))
                {
                    data: 'group_policy', name: 'group_policy'
                },
                    @endif
                {
                    data: 'status', name: 'status', orderable: false
                },
                {data: 'action', name: 'action', orderable: false},

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
    <script src="{{asset('public/backend/js/instructor_list.js')}}"></script>
@endpush


