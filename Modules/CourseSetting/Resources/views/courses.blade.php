@extends('backend.master')


@php
    $table_name = 'courses';
    if (\Route::current()->getName() == 'getAllCourse') {
        $url = route('getAllCourseData') . '?course_status=3';
        $text = trans('common.All');
    } elseif (\Route::current()->getName() == 'getActiveCourse') {
        $url = route('getAllCourseData') . '?course_status=1';
        $text = trans('common.Active');
    } elseif (\Route::current()->getName() == 'getPendingCourse') {
        $url = route('getAllCourseData') . '?course_status=0';
        $text = trans('common.Pending');
    } elseif (\Route::current()->getName() == 'courseSortBy' || \Route::current()->getName() == 'courseSortByGet') {
        $category = request()->get('category');
        $type = request()->get('type');
        $instructor = request()->get('instructor');
        $status = request()->get('search_status');
        $search_required_type = request()->get('search_required_type');
        $search_delivery_mode = request()->get('search_delivery_mode');
        $url = route('getAllCourseData') . '?search_status=' . $status . '&category=' . $category . '&type=' . $type . '&instructor=' . $instructor . '&required_type=' . $search_required_type . '&mode_of_delivery=' . $search_delivery_mode;
        $text = trans('common.Filter');
    } else {
        $url = route('getAllCourseData');
        $text = trans('common.All');
    }
@endphp
@section('table')
    {{ $table_name }}
@stop
@section('mainContent')
    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">

            <div class="row justify-content-center mt-50">
                <div class="col-lg-12">
                    <div class="white_box mb_30">
                        <div class="white_box_tittle list_header">
                            <h4>{{ __('courses.Advanced Filter') }} </h4>
                        </div>
                        <form action="{{ route('courseSortBy') }}" method="POST">
                            @csrf
                            <div class="row">

                                <div class="col-lg-3 mt-30">

                                    <label class="primary_input_label" for="category">{{ __('courses.Category') }}</label>
                                    <select class="primary_select" name="category" id="category">
                                        <option data-display="{{ __('common.Select') }} {{ __('courses.Category') }}"
                                            value="">{{ __('common.Select') }} {{ __('courses.Category') }}</option>
                                        @foreach ($categories as $category)
                                            @if ($category->parent_id == 0)
                                                @include('backend.categories._single_select_option', [
                                                    'category' => $category,
                                                    'level' => 1,
                                                ])
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3 mt-30">

                                    <label class="primary_input_label" for="type">{{ __('courses.Type') }}</label>
                                    <select class="primary_select" name="type" id="type">
                                        <option data-display="{{ __('common.Select') }} {{ __('courses.Type') }}"
                                            value="">{{ __('common.Select') }} {{ __('courses.Type') }}</option>
                                        <option value="1"
                                            {{ isset($category_type) ? ($category_type == 1 ? 'selected' : '') : '' }}>
                                            {{ __('courses.Course') }}</option>
                                        <option value="2"
                                            {{ isset($category_type) ? ($category_type == 2 ? 'selected' : '') : '' }}>
                                            {{ __('quiz.Quiz') }}</option>
                                    </select>

                                </div>
                                <div class="col-lg-3 mt-30">

                                    <label class="primary_input_label"
                                        for="instructor">{{ __('courses.Instructor') }}</label>
                                    <select class="primary_select" name="instructor" id="instructor">
                                        <option data-display="{{ __('common.Select') }} {{ __('courses.Instructor') }}"
                                            value="">{{ __('common.Select') }} {{ __('courses.Instructor') }}
                                        </option>
                                        @foreach ($instructors as $instructor)
                                            <option value="{{ $instructor->id }}"
                                                {{ isset($category_instructor) ? ($category_instructor == $instructor->id ? 'selected' : '') : '' }}>
                                                {{ @$instructor->name }} </option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="col-lg-3 mt-30 d-none">
                                    <label class="primary_input_label"
                                        for="course">{{ __('courses.Statistics') }}</label>
                                    <select class="primary_select" name="course" id="course">
                                        <option data-display="{{ __('common.Select') }} {{ __('courses.Statistics') }}"
                                            value="">{{ __('common.Select') }} {{ __('courses.Statistics') }}
                                        </option>
                                        <option value="statistics">{{ __('courses.Statistics') }}</option>
                                        <option value="topSell">Top Sells</option>
                                        <option value="mostReview">Most Review</option>
                                        <option value="mostComment">Most Comment</option>
                                        <option value="topReview">Top Review</option>
                                    </select>

                                </div>
                                <div class="col-lg-3 mt-30">

                                    <label class="primary_input_label" for="status">{{ __('common.Status') }}</label>
                                    <select class="primary_select" name="search_status" id="status">
                                        <option data-display="{{ __('common.Select') }} {{ __('common.Status') }}"
                                            value="">{{ __('common.Select') }} {{ __('common.Status') }}</option>
                                        <option value="1"
                                            {{ isset($category_status) ? ($category_status == '1' ? 'selected' : '') : '' }}>
                                            {{ __('courses.Active') }} </option>
                                        <option value="0"
                                            {{ isset($category_status) ? ($category_status != '1' ? 'selected' : '') : '' }}>
                                            {{ __('courses.Pending') }} </option>
                                    </select>

                                </div>
                                @if (isModuleActive('Org'))
                                    <div class="col-lg-3 mt-30">
                                        <label class="primary_input_label"
                                            for="search_required_type">{{ __('courses.Required Type') }}</label>
                                        <select class="primary_select" name="search_required_type"
                                            id="search_required_type">
                                            <option
                                                data-display="{{ __('common.Select') }} {{ __('courses.Required Type') }}"
                                                value="">{{ __('common.Select') }} {{ __('courses.Required Type') }}
                                            </option>
                                            <option value="1"
                                                {{ isset($search_required_type) ? ($search_required_type == '1' ? 'selected' : '') : '' }}>
                                                {{ __('courses.Compulsory') }} </option>
                                            <option value="0"
                                                {{ isset($search_required_type) ? ($search_required_type == '0' ? 'selected' : '') : '' }}>
                                                {{ __('courses.Open') }}</option>
                                        </select>

                                    </div>

                                    <div class="col-lg-3 mt-30">

                                        <label class="primary_input_label"
                                            for="status">{{ __('courses.Delivery Mode') }}</label>
                                        <select class="primary_select" name="search_delivery_mode" id="status">
                                            <option
                                                data-display="{{ __('common.Select') }} {{ __('courses.Delivery Mode') }}"
                                                value="">{{ __('common.Select') }} {{ __('courses.Delivery Mode') }}
                                            </option>
                                            <option value="1"
                                                {{ isset($search_delivery_mode) ? ($search_delivery_mode == '1' ? 'selected' : '') : '' }}>
                                                {{ __('courses.Online') }} </option>
                                            <option value="3"
                                                {{ isset($search_delivery_mode) ? ($search_delivery_mode == '3' ? 'selected' : '') : '' }}>
                                                {{ __('courses.Offline') }}</option>
                                        </select>

                                    </div>
                                @endif
                                <div class="col-12 mt-20">
                                    <div class="search_course_btn text-right">
                                        <button type="submit"
                                            class="primary-btn radius_30px fix-gr-bg mr-10">{{ __('courses.Filter') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mr-30 mb_xs_15px mb_sm_20px mb-0">{{ $title ?? '' }} {{ __('courses.Course') }}
                                /{{ __('Test-Prep') }} {{ __('courses.List') }}</h3>
                            @if (permissionCheck('course.store'))
                                <ul class="d-flex">
                                    <li>


                                        <a class="primary-btn radius_30px fix-gr-bg mr-10"
                                            href="{{ route('course.store') }}">
                                            <i class="ti-plus"></i>{{ __('common.Add') }} {{ __('courses.Course') }}
                                            /{{ __('Test-Prep') }}</a>
                                    </li>
                                </ul>
                            @endif
                        </div>

                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table">
                            <!-- table-responsive -->
                            <div class="">
                                <table id="lms_table" class="classList table">
                                    <thead>
                                        <tr>
                                            <th scope="col"> {{ __('common.SL') }}</th>
                                            <th scope="col"> {{ __('coupons.Type') }}</th>
                                            @if (isModuleActive('Org'))
                                                <th scope="col"> {{ __('courses.Required Type') }}</th>
                                            @endif
                                            <th scope="col">{{ __('courses.Course') }}
                                                /{{ __('Test-Prep') }} {{ __('coupons.Title') }}</th>
                                            {{-- <th scope="col">{{__('courses.Delivery')}}</th> --}}
                                            <th scope="col">{{ __('quiz.Category') }}</th>
                                            @if (!isModuleActive('Org'))
                                                <th scope="col">{{ __('Test-Prep') }}</th>
                                            @endif
                                            <th scope="col">{{ __('courses.Instructor') }}</th>
                                            <th scope="col">{{ __('courses.Lesson') }}</th>
                                            {{-- <th scope="col">{{__('courses.Enrolled')}}</th> --}}
                                            @if (showEcommerce())
                                                {{-- <th scope="col">{{__('courses.Price')}}</th> --}}
                                            @endif
                                            {{-- <th scope="col">{{__('courses.View Scope')}}</th> --}}
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
                {{-- @dd(Auth::user()) --}}


                <div class="modal fade admin-query" id="editCourse">
                    <div class="modal-dialog modal_1000px modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{ __('common.Edit') }} {{ __('quiz.Topic') }} </h4>
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="ti-close"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('AdminUpdateCourse') }}" method="POST"
                                    enctype="multipart/form-data" id="courseEditForm">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="primary_input mb-25">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="primary_input_label" for="    ">
                                                            {{ __('courses.Type') }}</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="radio" class="common-radio type1" id="type_edit_1"
                                                            name="type" value="1">
                                                        <label for="type_edit_1">{{ __('courses.Course') }}</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="radio" class="common-radio type2" id="type_edit_2"
                                                            name="type" value="2">
                                                        <label for="type_edit_2">{{ __('quiz.Quiz') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-xl-6 dripCheck">
                                            <div class="primary_input mb-25">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="primary_input_label" for="    ">
                                                            {{ __('common.Drip Content') }}</label>
                                                    </div>

                                                    <div class="col-md-6">

                                                        <input type="radio" class="common-radio drip0" id="drip_edit_0"
                                                            name="drip" value="0"
                                                            {{ @$course->drip == 0 ? 'checked' : '' }}>
                                                        <label for="drip_edit_0">{{ __('common.No') }}</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="radio" class="common-radio drip1" id="drip_edit_1"
                                                            name="drip" value="1"
                                                            {{ @$course->drip == 1 ? 'checked' : '' }}>
                                                        <label for="drip_edit_1">{{ __('common.Yes') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="title">{{ __('quiz.Topic') }}
                                                    {{ __('common.Title') }}
                                                    *</label>
                                                <input class="primary_input_field" name="title" id="title"
                                                    placeholder="-" type="text"
                                                    {{ $errors->has('title') ? 'autofocus' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="id" class="course_id" id="editCourseId"
                                        value="">

                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label"
                                                    for="about">{{ __('courses.Course') }}
                                                    {{ __('courses.Requirements') }} </label>
                                                <textarea class="lms_summernote" name="requirements" id="requirementsEdit" cols="30" rows="10"> </textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label"
                                                    for="about">{{ __('courses.Course') }}
                                                    {{ __('courses.Description') }}</label>
                                                <textarea class="lms_summernote" name="about" id="aboutEdit" cols="30" rows="10"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label"
                                                    for="about">{{ __('courses.Course') }}
                                                    {{ __('courses.Outcomes') }} </label>
                                                <textarea class="lms_summernote" name="outcomes" id="outcomesEdit" cols="30" rows="10"> </textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-xl-6 courseBox">
                                            <select class="primary_select edit_category_id" name="category"
                                                {{ $errors->has('category') ? 'autofocus' : '' }}>
                                                <option
                                                    data-display="{{ __('common.Select') }} {{ __('quiz.Category') }}"
                                                    value="">{{ __('common.Select') }} {{ __('quiz.Category') }}
                                                    *
                                                </option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ @$category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-xl-6 courseBox" id="edit_subCategoryDiv{{ @$course->id }}">
                                            <select class="primary_select" name="sub_category" id="edit_subcategory_id"
                                                {{ $errors->has('sub_category') ? 'autofocus' : '' }}>
                                                <option
                                                    data-display="{{ __('common.Select') }} {{ __('courses.Sub Category') }}"
                                                    value="">{{ __('common.Select') }}
                                                    {{ __('courses.Sub Category') }}

                                                </option>


                                            </select>
                                        </div>
                                        <div class="col-xl-6 mt-30 quizBox" style="display: none">
                                            <select class="primary_select" name="quiz" id="quiz_edit_id"
                                                {{ $errors->has('quiz') ? 'autofocus' : '' }}>
                                                <option data-display="{{ __('common.Select') }} {{ __('quiz.Quiz') }}"
                                                    value="">{{ __('common.Select') }} {{ __('quiz.Quiz') }}
                                                    *
                                                </option>
                                                @foreach ($quizzes as $quiz)
                                                    <option value="{{ $quiz->id }}">{{ @$quiz->title }} </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-xl-4 mt-30 makeResize">
                                            <select class="primary_select" id="levelEdit" name="level"
                                                {{ $errors->has('level') ? 'autofocus' : '' }}>
                                                <option
                                                    data-display="{{ __('common.Select') }} {{ __('courses.Level') }}"
                                                    value="">{{ __('common.Select') }} {{ __('courses.Level') }}
                                                    *
                                                </option>
                                                @foreach ($levels as $level)
                                                    <option value="{{ $level->id }}">
                                                        {{ $level->title }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="col-xl-4 mt-30 makeResize" id="">
                                            <select class="primary_select mb_30" name="language" id="languageEdit"
                                                {{ $errors->has('language') ? 'autofocus' : '' }}>
                                                <option
                                                    data-display="{{ __('common.Select') }} {{ __('courses.Language') }}"
                                                    value="">{{ __('common.Select') }}
                                                    {{ __('courses.Language') }}
                                                    *
                                                </option>

                                                @foreach ($languages as $language)
                                                    <option value="{{ $language->id }}">{{ $language->native }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-xl-4 makeResize">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                    for="">{{ __('common.Duration') }}
                                                    ({{ __('common.In Minute') }})
                                                    *</label>
                                                <input class="primary_input_field" id="durationEdit" name="duration"
                                                    placeholder="-" min="0" step="any" type="number"
                                                    {{ $errors->has('duration') ? 'autofocus' : '' }}>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row d-none">
                                        <div class="col-lg-6">
                                            <div class="checkbox_wrap d-flex align-items-center">
                                                <label for="course_1" class="switch_toggle">
                                                    <input type="checkbox" id="edit_course_1">
                                                    <i class="slider round"></i>
                                                </label>
                                                <label>{{ __('courses.This course is a top course') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-20">
                                        <div class="col-lg-6">
                                            <div class="checkbox_wrap d-flex align-items-center mt-40">
                                                <label for="editCourseFree" class="switch_toggle">
                                                    <input type="checkbox" class="edit_course_2" name="is_free"
                                                        value="1" id="editCourseFree">
                                                    <i class="slider round"></i>
                                                </label>
                                                <label>{{ __('courses.This course is a free course') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-xl-4" id="edit_price_div">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                    for="">{{ __('courses.Price') }}</label>
                                                <input class="primary_input_field" name="price" id="priceEdit"
                                                    placeholder="-" value="" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row editDiscountDiv mt-20">
                                        <div class="col-lg-6">
                                            <div class="checkbox_wrap d-flex align-items-center mt-40">
                                                <label for="editCourseDiscount" class="switch_toggle">
                                                    <input type="checkbox" class="edit_course_3" name="is_discount"
                                                        value="1" id="editCourseDiscount">
                                                    <i class="slider round"></i>
                                                </label>
                                                <label>{{ __('courses.This course has discounted price') }}</label>
                                            </div>
                                        </div>

                                        <div class="col-xl-4" id="edit_discount_price_div">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                    for="">{{ __('courses.Discount') }}
                                                    {{ __('courses.Price') }}</label>
                                                <input class="primary_input_field editDiscount" name="discount_price"
                                                    id="editDiscountPrice" placeholder="-" type="text">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row videoOption mt-20">
                                        <div class="col-xl-4 mt-25">
                                            <select class="primary_select category_id" name="host"
                                                id="editCourseHost">
                                                <option data-display="{{ __('courses.Course overview host') }} *"
                                                    value="">{{ __('courses.Course overview host') }}
                                                </option>

                                                <option value="Youtube">
                                                    {{ __('courses.Youtube') }}
                                                </option>
                                                <option value="Vimeo">
                                                    {{ __('courses.Vimeo') }}
                                                </option>
                                                @if (isModuleActive('AmazonS3'))
                                                    <option value="AmazonS3">
                                                        {{ __('courses.Amazon S3') }}
                                                    </option>
                                                @endif

                                                <option value="Self">
                                                    {{ __('courses.Self Host') }}
                                                </option>


                                            </select>
                                        </div>
                                        <div class="col-xl-8">
                                            <div class="input-effect videoUrl"
                                                style="display:@if ((isset($course) && @$course->host != 'Youtube') || !isset($course)) none @endif">
                                                <label>{{ __('courses.Video URL') }}
                                                    <span>*</span></label>
                                                <input id="couseEditViewUrl"
                                                    class="primary_input_field youtubeVideo name{{ $errors->has('trailer_link') ? ' is-invalid' : '' }}"
                                                    type="text" name="trailer_link"
                                                    placeholder="{{ __('courses.Video URL') }}" autocomplete="off"
                                                    value=" " {{ $errors->has('trailer_link') ? 'autofocus' : '' }}>
                                                <span class="focus-border"></span>
                                                @if ($errors->has('trailer_link'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('trailer_link') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="row vimeoUrl" id=""
                                                style="display: @if ((isset($course) && @$course->host != 'Vimeo') || !isset($course)) none @endif">
                                                <div class="col-lg-12" id="">
                                                    <label class="primary_input_label"
                                                        for="">{{ __('courses.Vimeo Video') }}</label>
                                                    <select class="primary_select vimeoVideo" name="vimeo"
                                                        id="viemoEditCourse">
                                                        <option
                                                            data-display="{{ __('common.Select') }} {{ __('courses.Video') }}"
                                                            value="">{{ __('common.Select') }}
                                                            {{ __('courses.Video') }}
                                                        </option>
                                                        @if (isset($video_list))
                                                            @foreach ($video_list as $video)
                                                                <option value="{{ @$video['uri'] }}">
                                                                    {{ @$video['name'] }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    @if ($errors->has('vimeo'))
                                                        <span class="invalid-feedback invalid-select" role="alert">
                                                            <strong>{{ $errors->first('vimeo') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="row videofileupload" id=""
                                                style="display: @if ((isset($course) && (@$course->host == 'Vimeo' || @$course->host == 'Youtube')) || !isset($course)) none @endif">

                                                <div class="col-xl-12">
                                                    <div class="primary_input">
                                                        <label class="primary_input_label"
                                                            for="">{{ __('courses.Video File') }}</label>
                                                        <div class="primary_file_uploader">
                                                            {{-- <input
                                                                 class="primary-input filePlaceholder"
                                                                 type="text"

                                                                 placeholder="{{__('courses.Browse Video file')}}"
                                                                 readonly="">
                                                             <button class="" type="button">
                                                                 <label
                                                                     class="primary-btn small fix-gr-bg"
                                                                     for="document_file_edit">{{__('common.Browse') }}</label>
                                                                 <input type="file"
                                                                        class="d-none fileUpload"
                                                                        name="file"
                                                                        id="document_file_edit">
                                                             </button>

                                                             @if ($errors->has('file'))
                                                                 <span
                                                                     class="invalid-feedback invalid-select"
                                                                     role="alert">
                                             <strong>{{ $errors->first('file') }}</strong>
                                         </span>
                                                             @endif --}}
                                                            <input type="file" class="filepond" name="file">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-20">


                                        <div class="col-xl-6">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label"
                                                    for="">{{ __('courses.Course Thumbnail') }}
                                                    ({{ __('common.Max Image Size 1MB') }})
                                                    *</label>
                                                <div class="primary_file_uploader">
                                                    <input class="primary-input filePlaceholder" type="text"
                                                        id=""
                                                        placeholder="{{ __('courses.Browse Image file') }}"
                                                        readonly="" {{ $errors->has('image') ? 'autofocus' : '' }}>
                                                    <button class="" type="button">
                                                        <label class="primary-btn small fix-gr-bg"
                                                            for="document_file_1_edit_">{{ __('common.Browse') }}</label>
                                                        <input type="file" class="d-none fileUpload" name="image"
                                                            id="document_file_1_edit_">
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        @if (\Illuminate\Support\Facades\Auth::user()->subscription_api_status == 1)
                                            <div class="col-xl-6">
                                                <label class="primary_input_label"
                                                    for="">{{ __('newsletter.Subscription List') }}
                                                </label>
                                                <select class="primary_select" id="subscriptionEdit"
                                                    name="subscription_list"
                                                    {{ $errors->has('subscription_list') ? 'autofocus' : '' }}>
                                                    <option
                                                        data-display="{{ __('common.Select') }} {{ __('newsletter.Subscription List') }}"
                                                        value="">{{ __('common.Select') }}
                                                        {{ __('newsletter.Subscription List') }}

                                                    </option>
                                                    @foreach ($sub_lists as $list)
                                                        <option value="{{ $list['id'] }}">
                                                            {{ $list['name'] }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row">


                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                    for="">{{ __('courses.Meta keywords') }}</label>
                                                <input class="primary_input_field" name="meta_keywords" id="editMetaKey"
                                                    placeholder="-" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                    for="">{{ __('courses.Meta description') }}</label>
                                                <textarea id="editMetaDetails" class="primary_input_field" name="meta_description" style="height: 200px"
                                                    rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 pt_15 text-center">
                                        <div class="d-flex justify-content-center">
                                            <button class="primary-btn semi_large2 fix-gr-bg" id="save_button_parent"
                                                type="submit"><i class="ti-check"></i> {{ __('common.Update') }}
                                                {{ __('courses.Course') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
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
                    data: 'type',
                    name: 'type'
                },
                @if (isModuleActive('Org'))
                    {
                        data: 'required_type',
                        name: 'required_type'
                    },
                @endif {
                    data: 'title',
                    name: 'title'
                },
                // {data: 'mode_of_delivery', name: 'mode_of_delivery'},
                {
                    data: 'category',
                    name: 'category.name'
                },
                @if (!isModuleActive('Org'))
                    {
                        data: 'quiz',
                        name: 'quiz.title'
                    },
                @endif {
                    data: 'user',
                    name: 'user.name'
                },

                {
                    data: 'lessons',
                    name: 'lessons'
                },
                // {data: 'enrolled_users', name: 'enrolled_users'},
                @if (showEcommerce())
                    // {data: 'price', name: 'price'},
                @endif
                // {data: 'scope', name: 'scope'},
                {
                    data: 'status',
                    name: 'search_status',
                    orderable: false,
                    searchable: false
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

                // if (start_date >= end_date) {
                //     toastr.error('Start Date Sjould Not Greater than End Date !', '', {
                //         timeOut: 3000
                //     });
                //     return false;
                // }
                if (start_date.val() == '' || start_date.val() == undefined) {
                    toastr.error('Please Select Start Date !', '', {
                        timeOut: 3000
                    });
                    return false;
                }

                if (end_date.val() == '' || end_date.val() == undefined) {
                    toastr.error('Please Select End Date !', '', {
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
