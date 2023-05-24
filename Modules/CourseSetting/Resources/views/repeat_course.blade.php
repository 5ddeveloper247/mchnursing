@extends('backend.master')
@push('styles')
    <style>
        .select2-container--default .select2-selection--single {
            background-color: #fff;
            width: 100%;
            height: 46px;
            line-height: 46px;
            font-size: 13px;
            padding: 3px 20px;
            padding-left: 20px;
            font-weight: 300;
            border-radius: 30px;
            color: var(--base_color);
            border: 1px solid #ECEEF4
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px;
            position: absolute;
            top: 1px;
            right: 20px;
            width: 20px;
            color: var(--text-color);
        }

        .select2-dropdown {
            background-color: white;
            border: 1px solid #ECEEF4;
            border-radius: 4px;
            box-sizing: border-box;
            display: block;
            position: absolute;
            left: -100000px;
            width: 100%;
            width: 100%;
            background: var(--bg_white);
            overflow: auto !important;
            border-radius: 0px 0px 10px 10px;
            margin-top: 1px;
            z-index: 9999 !important;
            border: 0;
            box-shadow: 0px 10px 20px rgb(108 39 255 / 30%);
            z-index: 1051;
            min-width: 200px;
        }

        .select2-search--dropdown .select2-search__field {
            padding: 4px;
            width: 100%;
            box-sizing: border-box;
            box-sizing: border-box;
            background-color: #fff;
            border: 1px solid rgba(130, 139, 178, 0.3) !important;
            border-radius: 3px;
            box-shadow: none;
            color: #333;
            display: inline-block;
            vertical-align: middle;
            padding: 0px 8px;
            width: 100% !important;
            height: 46px;
            line-height: 46px;
            outline: 0 !important;
        }

        .select2-container {
            width: 100% !important;
            min-width: 90px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 40px;
        }


        .makeResize.responsiveResize.col-xl-6 {
            margin-top: 30px;
        }

        @media (max-width: 1199px) {
            .responsiveResize2 {
                margin-top: 30px;
            }
        }
    </style>
@endpush
@php
    $table_name = 'courses';
@endphp
@section('table')
    {{ $table_name }}
@stop

@section('mainContent')
    @php
        $required_type = false;
        if (isModuleActive('Org')) {
            $required_type = true;
        }
    @endphp
    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">


        <div class="white_box mb_30 student-details header-menu">
            <div class="white_box_tittle list_header">
                <h4>{{ __('common.Add New') }} {{ __('quiz.Topic') }} </h4>

            </div>
            <div class="col-lg-12">


                <input type="hidden" id="url" value="{{ url('/') }}">
                <form action="{{ route('AdminSaveCourse') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="primary_input">
                                <div class="row toggle_course_testPrep">
                                    <div class="col-md-12">
                                        <label class="primary_input_label" for=""> {{ __('courses.Type') }} </label>
                                    </div>
                                    <div class="col-md-4 col-sm-4 mb-25">
                                        <label class="primary_checkbox d-flex mr-12" onclick="removecol()">
                                            <input type="radio" id="type1" name="type" value="1"
                                                @if (empty(old('type'))) checked @else
                                                {{ old('type') == 1 ? 'checked' : '' }} @endif>
                                            <span class="checkmark mr-2"></span>{{ __('courses.Course') }}
                                        </label>
                                    </div>
                                    <div class="col-md-4 col-sm-4 mb-25">
                                        <label class="primary_checkbox d-flex nowrap mr-12" onclick="timecol()">
                                            <input type="radio" id="type2" name="type" value="7"
                                                {{ old('type') == 7 ? 'checked' : '' }}>
                                            <span class="checkmark mr-2"></span> {{ __('Time Table') }}</label>
                                    </div>
                                    <div class="col-md-4 col-sm-4 mb-25">
                                        <label class="primary_checkbox d-flex nowrap mr-12" onclick="addcol()">
                                            <input type="radio" id="type2" name="type" value="2"
                                                {{ old('type') == 2 ? 'checked' : '' }}
                                                {{ auth()->user()->role_id == 2 ? 'disabled' : '' }}>
                                            <span class="checkmark mr-2"></span> {{ __('Big Quiz') }}</label>
                                    </div>
                                    <script>
                                        function addcol() {

                                            $('.courseBox').addClass('d-none');
                                            $('.testPrepBox').removeClass('d-none');
                                            $('.timetableBox').addClass('d-none');
                                            $('.addnewdo').addClass('col-xl-12');
                                            $('.addnewdo').removeClass('col-xl-6');
                                        }

                                        function removecol() {
                                            $('.addnewdo').addClass('col-xl-6');
                                            $('.addnewdo').removeClass('col-xl-12');
                                            $('.timetableBox').addClass('d-none');
                                            $('.testPrepBox').addClass('d-none');
                                            $('.courseBox').removeClass('d-none');
                                        }

                                        function timecol() {

                                            $('.courseBox').addClass('d-none');
                                            $('.testPrepBox').addClass('d-none');
                                            $('.timetableBox').removeClass('d-none');
                                            $('.addnewdo').addClass('col-xl-12');
                                            $('.addnewdo').removeClass('col-xl-6');
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 courseBox">
                            <div class="primary_input">
                                <div class="row toggle_course_testPrep">
                                    <div class="col-md-12">
                                        <label class="primary_input_label" for=""> {{ __('PREP TYPE') }}</label>
                                    </div>
                                    <div class="col-md-4 col-sm-4 mb-25">
                                        <label class="primary_checkbox d-flex mr-12">
                                            <input type="checkbox" name="cna_prep_type" value="1"
                                                onchange="showCnaPrepPrice()">
                                            <span class="checkmark mr-2"></span>{{ __('Full Course') }}</label>
                                    </div>
                                    <div class="col-md-4 col-sm-4 mb-25">
                                        <label class="primary_checkbox d-flex nowrap mr-12">
                                            <input type="checkbox" name="test_prep_type" value="1"
                                                onchange="showPrepDemandPrice()">
                                            <span class="checkmark mr-2"></span> {{ __('Test-Prep(on-demand)') }}</label>
                                    </div>
                                    <div class="col-md-4 col-sm-4 mb-25">
                                        <label class="primary_checkbox d-flex nowrap mr-12">
                                            <input type="checkbox" name="test_prep_graded_type" value="1"
                                                onchange="showPrepGradedPrice()">
                                            <span class="checkmark mr-2"></span> {{ __('Test-Prep(Live)') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="cna_prep_type" class="col-xl-6 d-none">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('Full Course Price') }}</label>
                                <input class="primary_input_field" name="cna_prep_price" placeholder="-" type="text"
                                    value="{{ old('cna_prep_price') }}">
                            </div>
                        </div>
                        <div id="test_prep_type" class="col-xl-6 d-none">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label"
                                    for="">{{ __('TEST PREP Price(on-demand)') }}</label>
                                <input class="primary_input_field" name="test_prep_price" placeholder="-" type="text"
                                    value="{{ old('test_prep_price') }}">
                            </div>
                        </div>
                        <div id="test_prep_graded_type" class="col-xl-6 d-none">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('TEST PREP Price(Live)') }}</label>
                                <input class="primary_input_field" name="test_prep_graded_price" placeholder="-"
                                    type="text" value="{{ old('test_prep_graded_price') }}">
                            </div>
                        </div>
                        <div class="col-xl-6 courseBox">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="assistant_instructors">{{ __('Total Classes') }}
                                </label>
                                <input type="number" name="total_courses" id="total_courses" placeholder="-"
                                    class="primary_input_field active mb-15 e1" multiple>
                            </div>

                        </div>
                    </div>
                    <div class="row">

                        @if ($required_type)
                            <div class="{{ $required_type ? 'col-xl-4' : 'col-xl-6' }}">
                                <div class="primary_input">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="primary_input_label" for="">
                                                {{ __('courses.Required Type') }} * </label>
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-25">
                                            <label class="primary_checkbox d-flex mr-12">
                                                <input type="radio" id="" name="required_type" value="1"
                                                    checked>
                                                <span class="checkmark mr-2"></span>{{ __('courses.Compulsory') }}
                                            </label>
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-25">
                                            <label class="primary_checkbox d-flex mr-12">
                                                <input type="radio" name="required_type" value="0">
                                                <span class="checkmark mr-2"></span> {{ __('courses.Open') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        {{--                        <div class=" {{$required_type?'col-xl-4':'col-xl-6'}} " id="dripCheck"> --}}
                        {{--                            <div class="primary_input mb-25 d-none"> --}}
                        {{--                                <label class="primary_input_label mt-1" --}}
                        {{--                                       for=""> {{__('common.Drip Content')}}</label> --}}
                        {{--                                <div class="row"> --}}
                        {{--                                    <div class="col-md-4 col-sm-6 mb-25"> --}}
                        {{--                                        <label class="primary_checkbox d-flex mr-12"> --}}
                        {{--                                            <input type="radio" class="drip0" --}}
                        {{--                                                   id="drip0" name="drip" --}}
                        {{--                                                   value="0" checked> --}}
                        {{--                                            <span class="checkmark mr-2"></span> {{__('common.No')}} --}}
                        {{--                                        </label> --}}
                        {{--                                    </div> --}}
                        {{--                                    <div class="col-md-4 col-sm-6 mb-25"> --}}
                        {{--                                        <label class="primary_checkbox d-flex mr-12"> --}}
                        {{--                                            <input type="radio" class=" drip1" --}}
                        {{--                                                   id="drip1" name="drip" --}}
                        {{--                                                   value="1"> --}}
                        {{--                                            <span class="checkmark mr-2"></span> {{__('common.Yes')}}</label> --}}
                        {{--                                    </div> --}}
                        {{--                                </div> --}}
                        {{--                            </div> --}}


                        {{--                        </div> --}}

                        @if (\Illuminate\Support\Facades\Auth::user()->role_id != 2)
                            <div class="col-xl-6 courseBox testPrepBox">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                        for="assign_instructor">{{ __('courses.Assign Instructor') }} </label>
                                    <select class="primary_select category_id" name="assign_instructor"
                                        id="assign_instructor" {{ $errors->has('assign_instructor') ? 'autofocus' : '' }}>
                                        <option data-display="{{ __('common.Select') }} {{ __('courses.Instructor') }}"
                                            value="">{{ __('common.Select') }} {{ __('courses.Instructor') }}
                                        </option>
                                        @foreach ($instructors as $instructor)
                                            <option value="{{ $instructor->id }}">{{ @$instructor->name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>




                        @endif
                        <div class="col-xl-6 courseBox testPrepBox">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label"
                                    for="assistant_instructors">{{ __('courses.Assistant Instructor') }} </label>
                                <select name="assistant_instructors[]" id="assistant_instructors"
                                    class="multypol_check_select active mb-15 e1" multiple>
                                    @foreach ($instructors as $instructor)
                                        <option value="{{ $instructor->id }}">{{ @$instructor->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- wwwwwwwwwwww -->


                    </div>

                    @php
                        $LanguageList = getLanguageList();
                    @endphp
                    <div class="row pt-0">
                        @if (isModuleActive('FrontendMultiLang'))
                            <ul class="nav nav-tabs no-bottom-border mt-sm-md-20 mb-10 ml-3" role="tablist">
                                @foreach ($LanguageList as $key => $language)
                                    <li class="nav-item">
                                        <a class="nav-link @if (auth()->user()->language_code == $language->code) active @endif"
                                            href="#element{{ $language->code }}" role="tab"
                                            data-toggle="tab">{{ $language->native }} </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="tab-content">
                        @foreach ($LanguageList as $key => $language)
                            <div role="tabpanel"
                                class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif"
                                id="element{{ $language->code }}">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="">{{ __('quiz.Topic') }}
                                                {{ __('common.Title') }} *</label>
                                            <input class="primary_input_field"
                                                name="{{ $language->code == 'en' ? 'title' : '' }}" placeholder="-"
                                                id="addTitle" type="text"
                                                {{ $errors->has('title') ? 'autofocus' : '' }} value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="primary_input mb-35">
                                            <label class="primary_input_label" for="">{{ __('courses.Course') }}
                                                {{ __('courses.Requirements') }}
                                            </label>
                                            <textarea class="lms_summernote" name="requirements[{{ $language->code }}]" id="addRequirements" cols="30"
                                                rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="primary_input mb-35">
                                            <label class="primary_input_label" for="">{{ __('courses.Course') }}
                                                {{ __('courses.Description') }}
                                            </label>
                                            <textarea class="lms_summernote" name="about[{{ $language->code }}]" id="addAbout" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="primary_input mb-35">
                                            <label class="primary_input_label" for="">{{ __('courses.Course') }}
                                                {{ __('courses.Outcomes') }}
                                            </label>
                                            <textarea class="lms_summernote" name="outcomes[{{ $language->code }}]" id="addOutcomes" cols="30"
                                                rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @php
                        if (courseSetting()->show_mode_of_delivery == 1 || isModuleActive('Org')) {
                            $col_size = 4;
                        } elseif (currentTheme() == 'tvt') {
                            $col_size = 3;
                        } else {
                            $col_size = 6;
                        }
                    @endphp
                    <div class="row">

                        @if (currentTheme() == 'tvt')
                            <!-- {{ $col_size }}  -->
                            <div class="col-xl-6 mb_30">
                                <select class="primary_select school_subject_id" name="school_subject_id"
                                    id="school_subject_id" {{ $errors->has('category') ? 'autofocus' : '' }}>
                                    <option data-display="{{ __('common.Select') }} {{ __('courses.School Subject') }} *"
                                        value="">{{ __('common.Select') }} {{ __('courses.School Subject') }}
                                    </option>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="col-xl-6 courseBox mb_30">
                            <select class="primary_select category_id" name="category" id="category_id"
                                {{ $errors->has('category') ? 'autofocus' : '' }}>
                                <option data-display="{{ __('common.Select') }} {{ __('quiz.Category') }} *"
                                    value="">{{ __('common.Select') }} {{ __('quiz.Category') }} </option>
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
                        <div class="col-xl-6 courseBox mb_30" id="subCategoryDiv">
                            <select class="primary_select" name="sub_category" id="subcategory_id"
                                {{ $errors->has('sub_category') ? 'autofocus' : '' }}>
                                <option data-display="{{ __('common.Select') }} {{ __('courses.Sub Category') }}  "
                                    value="">{{ __('common.Select') }} {{ __('courses.Sub Category') }}
                                </option>
                            </select>
                        </div>
                        @if (courseSetting()->show_mode_of_delivery == 1 || isModuleActive('Org'))
                            <div class="d-none col-xl-6 mt_60">
                                <select class="primary_select mode_of_delivery" name="mode_of_delivery" required>
                                    <option
                                        data-display="{{ __('common.Select') }} {{ __('courses.Mode of Delivery') }}*"
                                        value="">{{ __('common.Select') }} {{ __('courses.Mode of Delivery') }}*
                                    </option>
                                    <option value="1" selected>{{ __('courses.Online') }}</option>
                                    @if (!isModuleActive('Org'))
                                        <option value="2">{{ __('courses.Distance Learning') }}</option>
                                        <option value="3">{{ __('courses.Face-to-Face') }}</option>
                                    @else
                                        <option value="3">{{ __('courses.Offline') }}</option>
                                    @endif

                                </select>
                            </div>
                        @endif
                        <div class="col-xl-6 testPrepBox mt-30 d-none">
                            <select class="primary_select" name="quiz" id="quiz_id"
                                {{ $errors->has('quiz') ? 'autofocus' : '' }}>
                                <option data-display="{{ __('common.Select') }} {{ __('Test-Prep') }} *" value="">
                                    {{ __('common.Select') }} {{ __('Test-Prep') }} </option>
                                @foreach ($quizzes as $quiz)
                                    <option value="{{ $quiz->id }}">{{ @$quiz->title }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-6 timetableBox mt-30 d-none">
                            <select class="primary_select" name="timetable" id="quiz_id"
                                {{ $errors->has('timetable') ? 'autofocus' : '' }}>
                                <option data-display="{{ __('common.Select') }} {{ __('Time Table') }} *"
                                    value="">{{ __('common.Select') }} {{ __('Time Table') }} </option>
                                @foreach ($timetables as $timetable)
                                    <option value="{{ $timetable->id }}">{{ @$timetable->name }} </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-xl-6 mt-30">
                            <select class="primary_select" name="level">
                                <option data-display="{{ __('common.Select') }} {{ __('courses.Level') }} *"
                                    value="">{{ __('common.Select') }} {{ __('courses.Level') }}
                                </option>
                                @foreach ($levels as $level)
                                    <option value="{{ $level->id }}"
                                        {{ old('level') == $level->id ? 'selected' : '' }}>
                                        {{ $level->title }}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-xl-6 mt-30" id="">
                            <select class="primary_select mb-25" name="language" id=""
                                {{ $errors->has('language') ? 'autofocus' : '' }}>
                                <option data-display="{{ __('common.Select') }} {{ __('common.Language') }} *"
                                    value="">{{ __('common.Select') }} {{ __('common.Language') }}</option>
                                @foreach ($languages as $language)
                                    <option value="{{ $language->id }}"
                                        {{ old('language') == $language->id ? 'selected' : '' }}
                                        {{ auth()->user()->language_id == $language->id ? 'selected' : '' }}>
                                        {{ $language->native }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-none col-xl-6" id="durationBox">
                            <div class="primary_input mb-25">

                                <input class="primary_input_field" name="duration"
                                    placeholder="{{ __('common.Duration') }} ({{ __('common.In Minute') }})"
                                    id="addDuration" min="0" step="any" type="number"
                                    value="{{ old('duration') }}" {{ $errors->has('duration') ? 'autofocus' : '' }}>
                            </div>
                        </div>
                        <div class="col-xl-6 d-none">
                            <div class="primary_input mb-25">

                                <div class="row pt-2">
                                    <div class="col-md-6 mb-25">
                                        <label class="primary_input_label mt-1" for="">
                                            {{ __('common.Complete course sequence') }}</label>
                                    </div>
                                    <div class="col-md-3 mb-25">
                                        <label class="primary_checkbox d-flex mr-12">
                                            <input type="radio" class="complete_order0" id="complete_order0"
                                                name="complete_order" value="0" checked>
                                            <span class="checkmark mr-2"></span> {{ __('common.No') }}</label>
                                    </div>
                                    <div class="col-md-3 mb-25">
                                        <label class="primary_checkbox d-flex mr-12">
                                            <input type="radio" class="complete_order1" id="complete_order1"
                                                name="complete_order" value="1">
                                            <span class="checkmark mr-2"></span>{{ __('common.Yes') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row d-none">
                        <div class="col-lg-6">
                            <div class="checkbox_wrap d-flex align-items-center">
                                <label for="course_1" class="switch_toggle mr-2">
                                    <input type="checkbox" id="course_1">
                                    <i class="slider round"></i>
                                </label>
                                <label class="mb-0">{{ __('courses.This course is a top course') }}</label>
                            </div>
                        </div>
                    </div>
                    @if (showEcommerce())
                        <div class="row">
                            <div class="col-lg-6 mb-25 d-none">
                                <div class="checkbox_wrap d-flex align-items-center mt-40">
                                    <label for="course_2" class="switch_toggle mr-2">
                                        <input type="checkbox" id="course_2" value="1" name="is_free">
                                        <i class="slider round"></i>
                                    </label>
                                    <label class="mb-0">{{ __('courses.This course is a free course') }}</label>
                                </div>
                            </div>
                            <div class="col-xl-12 d-none" id="price_div">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('courses.Price') }}</label>
                                    <input class="primary_input_field" name="price" placeholder="-" id="addPrice"
                                        type="text" value="{{ old('price') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row d-none mt-20" id="discountDiv">
                            <div class="col-lg-6">
                                <div class="checkbox_wrap d-flex align-items-center mt-40">
                                    <label for="course_3" class="switch_toggle mr-2">
                                        <input type="checkbox" id="course_3" value="1" name="is_discount">
                                        <i class="slider round"></i>
                                    </label>
                                    <label class="mb-0">{{ __('courses.This course has discounted price') }}</label>
                                </div>
                            </div>
                            <div class="col-xl-4" id="discount_price_div" style="display: none">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('courses.Discount') }}
                                        {{ __('courses.Price') }}</label>
                                    <input class="primary_input_field" name="discount_price" placeholder="-"
                                        id="addDiscount" type="text" value="{{ old('discount_price') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row d-none mt-20">
                            <div class="col-lg-6 mb-25">
                                <div class="checkbox_wrap d-flex align-items-center mt-40">
                                    <label for="iap" class="switch_toggle mr-2">
                                        <input type="checkbox" id="iap" value="1" name="iap">
                                        <i class="slider round"></i>
                                    </label>
                                    <label
                                        class="mb-0">{{ __('courses.This course is a In App purchase course') }}</label>
                                </div>
                            </div>
                            <div class="col-xl-6 d-none" id="iap_div">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                        for="">{{ __('courses.In App purchase product ID') }}</label>
                                    <input class="primary_input_field" name="iap_product_id" placeholder="-"
                                        id="" type="text" value="{{ old('iap_product_id') }}">
                                </div>
                            </div>
                        </div>
                    @endif
                    <!--vvvvvvvvvvvvvvvvvvvvvv -->
                    <div class="row videoOption d-none mt-20 mb-10">
                        <div class="col-lg-6 d-none">
                            <div class="checkbox_wrap d-flex align-items-center mt-40">
                                <label for="show_overview_media" class="switch_toggle mr-2">
                                    <input type="checkbox" id="show_overview_media" value="1"
                                        name="show_overview_media">
                                    <i class="slider round"></i>
                                </label>
                                <label class="mb-0">{{ __('courses.Show Overview Video') }}</label>
                            </div>
                        </div>
                        <div class="col-xl-6 mt-25">
                            <select class="primary_select category_id" name="host" id="">
                                <option data-display="{{ __('courses.Course overview host') }} *" value="">
                                    {{ __('courses.Course overview host') }}
                                </option>
                                <option data-display="{{ __('courses.Image Preview') }}" value="ImagePreview"
                                    {{ @$course->host == 'ImagePreview' ? 'selected' : '' }}>
                                    {{ __('courses.Image Preview') }}
                                </option>

                                <option {{ @$course->host == 'Youtube' ? 'selected' : '' }} value="Youtube">
                                    {{ __('courses.Youtube') }}
                                </option>
                                <option value="VdoCipher" {{ @$course->host == 'VdoCipher' ? 'selected' : '' }}>
                                    VdoCipher
                                </option>

                                <option value="Vimeo" {{ @$course->host == 'Vimeo' ? 'selected' : '' }}>
                                    {{ __('courses.Vimeo') }}
                                </option>
                                @if (isModuleActive('AmazonS3'))
                                    <option value="AmazonS3" {{ @$course->host == 'AmazonS3' ? 'selected' : '' }}>
                                        {{ __('courses.Amazon S3') }}
                                    </option>
                                @endif

                                <option value="Self" {{ @$course->host == 'Self' ? 'selected' : '' }}>
                                    {{ __('courses.Self') }}
                                </option>


                            </select>
                        </div>
                    </div>

                    <div class="row videoOption mt-20" id="overview_host_section" style="display: none">

                        <div class="col-xl-8">
                            <div class="input-effect videoUrl"
                                style="display:@if ((isset($course) && @$course->host != 'Youtube') || !isset($course)) none @endif">
                                <label>{{ __('courses.Video URL') }}
                                    <span>*</span></label>
                                <input id=""
                                    class="primary_input_field youtubeVideo name{{ $errors->has('trailer_link') ? ' is-invalid' : '' }}"
                                    type="text" name="trailer_link" placeholder="{{ __('courses.Video URL') }}"
                                    autocomplete="off" value=""
                                    {{ $errors->has('trailer_link') ? 'autofocus' : '' }}>
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


                                    @if (config('vimeo.connections.main.upload_type') == 'Direct')
                                        <div class="primary_file_uploader">
                                            <input class="primary-input filePlaceholder" type="text" id=""
                                                {{ $errors->has('image') ? 'autofocus' : '' }}
                                                placeholder="{{ __('courses.Browse Video file') }}" readonly="">
                                            <button class="" type="button">
                                                <label class="primary-btn small fix-gr-bg"
                                                    for="document_file_thumb_vimeo_add">{{ __('common.Browse') }}</label>
                                                <input type="file" class="d-none fileUpload" name="vimeo"
                                                    id="document_file_thumb_vimeo_add">
                                            </button>
                                        </div>
                                    @else
                                        <select class="select2 vimeoVideo vimeoList" name="vimeo" id="">
                                            <option data-display="{{ __('common.Select') }} {{ __('courses.Video') }}"
                                                value="">{{ __('common.Select') }} {{ __('courses.Video') }}
                                            </option>
                                        </select>
                                    @endif
                                    @if ($errors->has('vimeo'))
                                        <span class="invalid-feedback invalid-select" role="alert">
                                            <strong>{{ $errors->first('vimeo') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row VdoCipherUrl" style="display: @if ((isset($course) && $course->trailer_link != 'VdoCipher') || !isset($editLesson)) none @endif">
                                <div class="input-effect" id="">
                                    <div class="" id="">
                                        <label class="primary_input_label"
                                            for="">{{ __('courses.VdoCipher Video') }}</label>
                                        <select class="select2 vdocipherList" name="vdocipher" id="VdoCipherVideo">
                                            <option data-display="{{ __('common.Select') }} video " value="">
                                                {{ __('common.Select') }} video
                                            </option>
                                            @foreach ($vdocipher_list as $vdo)
                                                @if (isset($editLesson))
                                                    <option value="{{ @$vdo->id }}"
                                                        {{ $vdo->id == $editLesson->video_url ? 'selected' : '' }}>
                                                        {{ @$vdo->title }}</option>
                                                @else
                                                    <option value="{{ @$vdo->id }}">{{ @$vdo->title }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @if ($errors->has('vdocipher'))
                                            <span class="invalid-feedback invalid-select" role="alert">
                                                <strong>{{ $errors->first('vdocipher') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row videofileupload" id=""
                                style="display: @if ((isset($course) && (@$course->host == 'Vimeo' || @$course->host == 'Youtube')) || !isset($course)) none @endif">

                                <div class="col-xl-12">
                                    <div class="primary_input">
                                        <label class="primary_input_label"
                                            for="">{{ __('courses.Video File') }}</label>
                                        <div class="primary_file_uploader">
                                            <input type="file" class="filepond" name="file">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row d-none">
                        <div class="col-xl-4 mt-25">
                            <label>{{ __('courses.View Scope') }} </label>
                            <select class="primary_select" name="scope" id="">
                                <option value="1" {{ @$course->scope == '1' ? 'selected' : '' }}>
                                    {{ __('courses.Public') }}
                                </option>

                                <option {{ @$course->scope == '0' ? 'selected' : '' }} value="0">
                                    {{ __('courses.Private') }}
                                </option>

                            </select>
                        </div>
                    </div>
                    <div class="row mt-60">
                        <!-- ppppp -->
                        <div class="col-xl-6">
                            <label class="primary_input_label">
                                COURSE THUMBNAIL (MAX IMAGE SIZE 1MB) (RECOMMEND SIZE: 1170X600)

                            </label>

                        </div>
                        <div class="col-xl-6">
                            <div class="primary_input mb-35">
                                <div class="primary_file_uploader">
                                    <input class="primary-input filePlaceholder" type="text" id=""
                                        {{ $errors->has('image') ? 'autofocus' : '' }}
                                        placeholder="{{ __('courses.Browse Image file') }}" readonly="">
                                    <button class="" type="button">
                                        <label class="primary-btn small fix-gr-bg"
                                            for="document_file_thumb_2">{{ __('common.Browse') }}</label>
                                        <input type="file" class="d-none fileUpload" name="image"
                                            id="document_file_thumb_2">
                                    </button>
                                </div>
                            </div>
                        </div>
                        @if (\Illuminate\Support\Facades\Auth::user()->subscription_api_status == 1)
                            <div class="col-xl-6">
                                <label class="primary_input_label"
                                    for="">{{ __('newsletter.Subscription List') }}
                                </label>
                                <select class="primary_select" name="subscription_list"
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

                    @if (Settings('frontend_active_theme') == 'edume')
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('courses.Key Point') }}
                                        (1)</label>
                                    <input class="primary_input_field" name="what_learn1" placeholder="-" type="text"
                                        value="{{ old('what_learn1') }}">
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('courses.Key Point') }} (2)
                                    </label>
                                    <input class="primary_input_field" name="what_learn2" placeholder="-" type="text"
                                        value="{{ old('what_learn2') }}">
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row">

                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label"
                                    for="">{{ __('courses.Meta keywords') }}</label>
                                <input class="primary_input_field" name="meta_keywords" placeholder="-" id="addMeta"
                                    type="text" value="{{ old('meta_keywords') }}">
                            </div>
                        </div>

                    </div>
                    <div class="row">

                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label"
                                    for="">{{ __('courses.Meta description') }}</label>
                                <textarea id="my-textarea" class="primary_input_field" id name="meta_description" style="height: 200px"
                                    rows="3">{{ old('meta_keywords') }}</textarea>
                            </div>

                        </div>

                    </div>

                    <div class="col-lg-12 pt_15 text-center">
                        <div class="d-flex justify-content-center">
                            <button class="primary-btn semi_large2 fix-gr-bg" id="save_button_parent" type="submit"><i
                                    class="ti-check"></i> {{ __('common.Add') }} {{ __('courses.Course') }}
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </section>
    @include('backend.partials.delete_modal')
@endsection
@push('js')
    <script>
        function showCnaPrepPrice() {
            $('#cna_prep_type').toggleClass('d-none');
        }

        function showPrepDemandPrice() {
            $('#test_prep_type').toggleClass('d-none');
        }

        function showPrepGradedPrice() {
            $('#test_prep_graded_type').toggleClass('d-none');
        }
    </script>

    <script>
        let show_overview_media = $('#show_overview_media');
        let overview_host_section = $('#overview_host_section');
        show_overview_media.change(function() {
            if (show_overview_media.is(':checked')) {
                overview_host_section.show();
            } else {
                overview_host_section.hide();
            }
        });
    </script>
    <script>
        $('.toggle_course_testPrep').change(function() {
            if ($('#type2').is(':checked')) {
                $('#price_div').removeClass('d-none');
            } else {
                $('#price_div').addClass('d-none');
            }
        });

        let show_mode_of_delivery = $('#show_mode_of_delivery');
        let mode_of_delivery_options = $('#mode_of_delivery_options');
        show_mode_of_delivery.change(function() {
            if (show_mode_of_delivery.is(':checked')) {
                mode_of_delivery_options.show();
            } else {
                mode_of_delivery_options.hide();
            }
        });


        $('.mode_of_delivery').change(function() {
            let option = $(".mode_of_delivery option:selected").val();
            if (option == 3) {
                $('.testPrepBox').hide();
            } else {
                if ($('#type2').is(':checked')) {
                    $('.testPrepBox').show();
                }
            }
        });

        $('#iap').change(function() {
            if ($('#iap').is(':checked')) {
                $('#iap_div').removeClass('d-none');
            } else {
                $('#iap_div').addClass('d-none');
            }
        });
    </script>
@endpush
@push('scripts')
    <script src="{{ asset('/') }}/Modules/CourseSetting/Resources/assets/js/course.js"></script>



    <script>
        let vdocipherList = $('.vdocipherList');

        vdocipherList.select2({
            ajax: {
                url: '{{ route('getAllVdocipherData') }}',
                type: "GET",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    var query = {
                        search: params.term,
                        page: params.page || 1,
                        // id: $('#country').find(':selected').val(),
                    }
                    return query;
                },
                cache: false
            }
        });

        $('.vimeoList').select2({
            ajax: {
                url: '{{ route('getAllVimeoData') }}',
                type: "GET",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term,
                        page: params.page || 1,
                    }
                },
                cache: false
            }
        });
    </script>
@endpush
