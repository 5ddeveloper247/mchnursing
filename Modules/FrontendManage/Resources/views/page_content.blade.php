@extends('backend.master')
@section('table')
    {{__('testimonials')}}
@endsection
@section('mainContent')
    @php
        $LanguageList = getLanguageList();
    @endphp
    {!! generateBreadcrumb() !!}


    <section class="mb-40 student-details">
        <div class="container-fluid p-0">
            <div class="row">

                <div class="col-lg-12">


                    @if (permissionCheck('null'))
                        <form class="form-horizontal" action="{{route('frontend.pageContent_Update')}}" method="POST"
                              enctype="multipart/form-data">
                            @endif
                            @csrf
                            <div class="white-box student-details header-menu">

                                <div class="col-md-12 ">
                                    <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                                    <div class="row mb-30">
                                        <div class="col-md-12">

                                            <div class="row pt-0">
                                                @if(isModuleActive('FrontendMultiLang'))
                                                    <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ml-3"
                                                        role="tablist">
                                                        @foreach ($LanguageList as $key => $language)
                                                            <li class="nav-item">
                                                                <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                   href="#element1{{$language->code}}"
                                                                   role="tab"
                                                                   data-toggle="tab">{{ $language->native }}  </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                            <div class="tab-content">
                                                @foreach ($LanguageList as $key => $language)
                                                    <div role="tabpanel"
                                                         class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                                                         id="element1{{$language->code}}">
                                                        <div class="row">
                                                            <div class="col-xl-6">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('frontendmanage.Course Page Title') }}
                                                                    </label>
                                                                    <input class="primary_input_field"
                                                                           placeholder="{{ __('frontendmanage.Course Page Title') }}"
                                                                           type="text"
                                                                           name="course_page_title[{{$language->code}}]"
                                                                           {{ $errors->has('course_page_title') ? ' autofocus' : '' }}
                                                                           value="{{isset($page_content)? getRawHomeContents($page_content,'course_page_title',$language->code) : ''}}">
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-6">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('frontendmanage.Course Page Sub Title') }}</label>
                                                                    <input class="primary_input_field"
                                                                           placeholder="{{ __('frontendmanage.Course Page Sub Title') }}"
                                                                           type="text"
                                                                           name="course_page_sub_title[{{$language->code}}]"
                                                                           {{ $errors->has('course_page_sub_title') ? ' autofocus' : '' }}
                                                                           value="{{isset($page_content)? getRawHomeContents($page_content,'course_page_sub_title',$language->code) : ''}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="row">
                                                @if(currentTheme() == 'infixlmstheme' || currentTheme() == 'wetech' || currentTheme() == 'teachery')
                                                    <div class="col-xl-2">
                                                        <div class="primary_input mb-25">
                                                            <img height="70" class="w-100 imagePreview1"
                                                                 src="{{ asset('/'.getRawHomeContents($page_content,'course_page_banner','en'))}}"
                                                                 alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('frontendmanage.Course Page Banner') }}
                                                                <small>({{__('common.Recommended Size')}}
                                                                    1920x500)</small>
                                                            </label>
                                                            <div class="primary_file_uploader">
                                                                <input
                                                                    class="primary-input  filePlaceholder {{ @$errors->has('course_page_banner') ? ' is-invalid' : '' }}"
                                                                    type="text" id=""
                                                                    placeholder="Browse file"
                                                                    readonly="" {{ $errors->has('course_page_banner') ? ' autofocus' : '' }}>
                                                                <button class="" type="button">
                                                                    <label class="primary-btn small fix-gr-bg"
                                                                           for="file1">{{ __('common.Browse') }}</label>
                                                                    <input type="file"
                                                                           class="d-none fileUpload imgInput1"
                                                                           name="course_page_banner" id="file1">
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="row pt-0">
                                                @if(isModuleActive('FrontendMultiLang'))
                                                    <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ml-3"
                                                        role="tablist">
                                                        @foreach ($LanguageList as $key => $language)
                                                            <li class="nav-item">
                                                                <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                   href="#element2{{$language->code}}"
                                                                   role="tab"
                                                                   data-toggle="tab">{{ $language->native }}  </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                            <div class="tab-content">
                                                @foreach ($LanguageList as $key => $language)
                                                    <div role="tabpanel"
                                                         class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                                                         id="element2{{$language->code}}">
                                                        <div class="row">
                                                            <div class="col-xl-6">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('frontendmanage.Class Page Title') }}
                                                                    </label>
                                                                    <input class="primary_input_field"
                                                                           placeholder="{{ __('frontendmanage.Class Page Title') }}"
                                                                           type="text"
                                                                           name="class_page_title[{{$language->code}}]"
                                                                           {{ $errors->has('class_page_title') ? ' autofocus' : '' }}
                                                                           value="{{isset($page_content)? getRawHomeContents($page_content,'class_page_title',$language->code) : ''}}">
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-6">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('frontendmanage.Class Page Sub Title') }}</label>
                                                                    <input class="primary_input_field"
                                                                           placeholder="{{ __('frontendmanage.Class Page Sub Title') }}"
                                                                           type="text"
                                                                           name="class_page_sub_title[{{$language->code}}]"
                                                                           {{ $errors->has('class_page_sub_title') ? ' autofocus' : '' }}
                                                                           value="{{isset($page_content)? getRawHomeContents($page_content,'class_page_sub_title',$language->code) : ''}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="row">

                                                @if(currentTheme() == 'infixlmstheme' || currentTheme() == 'wetech' || currentTheme() == 'teachery')

                                                    <div class="col-xl-2">
                                                        <div class="primary_input mb-25">
                                                            <img height="70" class="w-100 imagePreview2"
                                                                 src="{{ asset('/'.getRawHomeContents($page_content,'class_page_banner','en'))}}"
                                                                 alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('frontendmanage.Class Page Banner') }}
                                                                <small>({{__('common.Recommended Size')}}
                                                                    1920x500)</small>
                                                            </label>
                                                            <div class="primary_file_uploader">
                                                                <input
                                                                    class="primary-input  filePlaceholder {{ @$errors->has('class_page_banner') ? ' is-invalid' : '' }}"
                                                                    type="text" id=""
                                                                    placeholder="Browse file"
                                                                    readonly="" {{ $errors->has('class_page_banner') ? ' autofocus' : '' }}>
                                                                <button class="" type="button">
                                                                    <label class="primary-btn small fix-gr-bg"
                                                                           for="file2">{{ __('common.Browse') }}</label>
                                                                    <input type="file"
                                                                           class="d-none fileUpload imgInput2"
                                                                           name="class_page_banner" id="file2">
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="row pt-0">
                                                @if(isModuleActive('FrontendMultiLang'))
                                                    <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ml-3"
                                                        role="tablist">
                                                        @foreach ($LanguageList as $key => $language)
                                                            <li class="nav-item">
                                                                <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                   href="#element3{{$language->code}}"
                                                                   role="tab"
                                                                   data-toggle="tab">{{ $language->native }}  </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                            <div class="tab-content">
                                                @foreach ($LanguageList as $key => $language)
                                                    <div role="tabpanel"
                                                         class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                                                         id="element3{{$language->code}}">
                                                        <div class="row">
                                                            <div class="col-xl-6">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('frontendmanage.Quiz Page Title') }}
                                                                    </label>
                                                                    <input class="primary_input_field"
                                                                           placeholder="{{ __('frontendmanage.Quiz Page Title') }}"
                                                                           type="text"
                                                                           name="quiz_page_title[{{$language->code}}]"
                                                                           {{ $errors->has('class_page_title') ? ' autofocus' : '' }}
                                                                           value="{{isset($page_content)? getRawHomeContents($page_content,'quiz_page_title',$language->code) : ''}}">
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-6">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('frontendmanage.Quiz Page Sub Title') }}</label>
                                                                    <input class="primary_input_field"
                                                                           placeholder="{{ __('frontendmanage.Quiz Page Sub Title') }}"
                                                                           type="text"
                                                                           name="quiz_page_sub_title[{{$language->code}}]"
                                                                           {{ $errors->has('quiz_page_sub_title') ? ' autofocus' : '' }}
                                                                           value="{{isset($page_content)? getRawHomeContents($page_content,'quiz_page_sub_title',$language->code) : ''}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="row">

                                                @if(currentTheme() == 'infixlmstheme' || currentTheme() == 'wetech' || currentTheme() == 'teachery')
                                                    <div class="col-xl-2">
                                                        <div class="primary_input mb-25">
                                                            <img height="70" class="w-100 imagePreview3"
                                                                 src="{{ asset('/'.getRawHomeContents($page_content,'quiz_page_banner','en'))}}"
                                                                 alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('frontendmanage.Quiz Page Banner') }}
                                                                <small>({{__('common.Recommended Size')}}
                                                                    1920x500)</small>
                                                            </label>
                                                            <div class="primary_file_uploader">
                                                                <input
                                                                    class="primary-input  filePlaceholder {{ @$errors->has('quiz_page_banner') ? ' is-invalid' : '' }}"
                                                                    type="text" id=""
                                                                    placeholder="Browse file"
                                                                    readonly="" {{ $errors->has('quiz_page_banner') ? ' autofocus' : '' }}>
                                                                <button class="" type="button">
                                                                    <label class="primary-btn small fix-gr-bg"
                                                                           for="file3">{{ __('common.Browse') }}</label>
                                                                    <input type="file"
                                                                           class="d-none fileUpload imgInput3"
                                                                           name="quiz_page_banner" id="file3">
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="row pt-0">
                                                @if(isModuleActive('FrontendMultiLang'))
                                                    <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ml-3"
                                                        role="tablist">
                                                        @foreach ($LanguageList as $key => $language)
                                                            <li class="nav-item">
                                                                <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                   href="#element4{{$language->code}}"
                                                                   role="tab"
                                                                   data-toggle="tab">{{ $language->native }}  </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                            <div class="tab-content">
                                                @foreach ($LanguageList as $key => $language)
                                                    <div role="tabpanel"
                                                         class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                                                         id="element4{{$language->code}}">
                                                        <div class="row">
                                                            <div class="col-xl-6">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('frontendmanage.Instructor Page Title') }}
                                                                    </label>
                                                                    <input class="primary_input_field"
                                                                           placeholder="{{ __('frontendmanage.Instructor Page Title') }}"
                                                                           type="text"
                                                                           name="instructor_page_title[{{$language->code}}]"
                                                                           {{ $errors->has('instructor_page_title') ? ' autofocus' : '' }}
                                                                           value="{{isset($page_content)? getRawHomeContents($page_content,'instructor_page_title',$language->code) : ''}}">
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-6">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('frontendmanage.Instructor Page Sub Title') }}</label>
                                                                    <input class="primary_input_field"
                                                                           placeholder="{{ __('frontendmanage.Instructor Page Sub Title') }}"
                                                                           type="text"
                                                                           name="instructor_page_sub_title[{{$language->code}}]"
                                                                           {{ $errors->has('instructor_page_sub_title') ? ' autofocus' : '' }}
                                                                           value="{{isset($page_content)? getRawHomeContents($page_content,'instructor_page_sub_title',$language->code) : ''}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="row">

                                                @if(currentTheme() == 'infixlmstheme' || currentTheme() == 'wetech' || currentTheme() == 'teachery')
                                                    <div class="col-xl-2">
                                                        <div class="primary_input mb-25">
                                                            <img height="70" class="w-100 imagePreview4"
                                                                 src="{{ asset('/'.getRawHomeContents($page_content,'instructor_page_banner','en'))}}"
                                                                 alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('frontendmanage.Instructor Page Banner') }}
                                                                <small>({{__('common.Recommended Size')}}
                                                                    1920x500)</small>
                                                            </label>
                                                            <div class="primary_file_uploader">
                                                                <input
                                                                    class="primary-input  filePlaceholder {{ @$errors->has('instructor_page_banner') ? ' is-invalid' : '' }}"
                                                                    type="text" id=""
                                                                    placeholder="Browse file"
                                                                    readonly="" {{ $errors->has('instructor_page_banner') ? ' autofocus' : '' }}>
                                                                <button class="" type="button">
                                                                    <label class="primary-btn small fix-gr-bg"
                                                                           for="file4">{{ __('common.Browse') }}</label>
                                                                    <input type="file"
                                                                           class="d-none fileUpload imgInput4   "
                                                                           name="instructor_page_banner" id="file4">
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="row pt-0">
                                                @if(isModuleActive('FrontendMultiLang'))
                                                    <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ml-3"
                                                        role="tablist">
                                                        @foreach ($LanguageList as $key => $language)
                                                            <li class="nav-item">
                                                                <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                   href="#element5{{$language->code}}"
                                                                   role="tab"
                                                                   data-toggle="tab">{{ $language->native }}  </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                            <div class="tab-content">
                                                @foreach ($LanguageList as $key => $language)
                                                    <div role="tabpanel"
                                                         class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                                                         id="element5{{$language->code}}">
                                                        <div class="row">
                                                            <div class="col-xl-6">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('frontendmanage.Become Instructor Page Title') }}
                                                                    </label>
                                                                    <input class="primary_input_field"
                                                                           placeholder="{{ __('frontendmanage.Become Instructor Page Title') }}"
                                                                           type="text"
                                                                           name="become_instructor_page_title[{{$language->code}}]"
                                                                           {{ $errors->has('become_instructor_page_title') ? ' autofocus' : '' }}
                                                                           value="{{isset($page_content)? getRawHomeContents($page_content,'become_instructor_page_title',$language->code) : ''}}">
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-6">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('frontendmanage.Become Instructor Page Sub Title') }}</label>
                                                                    <input class="primary_input_field"
                                                                           placeholder="{{ __('frontendmanage.Become Instructor Page Sub Title') }}"
                                                                           type="text"
                                                                           name="become_instructor_page_sub_title[{{$language->code}}]"
                                                                           {{ $errors->has('become_instructor_sub_title') ? ' autofocus' : '' }}
                                                                           value="{{isset($page_content)? getRawHomeContents($page_content,'become_instructor_page_sub_title',$language->code) : ''}}">
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="row">

                                                @if(currentTheme() == 'infixlmstheme' || currentTheme() == 'wetech' || currentTheme() == 'teachery')
                                                    <div class="col-xl-2">
                                                        <div class="primary_input mb-25">
                                                            <img height="70" class="w-100 imagePreview8"
                                                                 src="{{ asset('/'.getRawHomeContents($page_content,'become_instructor_page_banner','en'))}}"
                                                                 alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('frontendmanage.Become Instructor Page Banner') }}
                                                                <small>({{__('common.Recommended Size')}}
                                                                    1920x500)</small>
                                                            </label>
                                                            <div class="primary_file_uploader">
                                                                <input
                                                                    class="primary-input  filePlaceholder {{ @$errors->has('become_instructor_page_banner') ? ' is-invalid' : '' }}"
                                                                    type="text" id=""
                                                                    placeholder="Browse file"
                                                                    readonly="" {{ $errors->has('become_instructor_page_banner') ? ' autofocus' : '' }}>
                                                                <button class="" type="button">
                                                                    <label class="primary-btn small fix-gr-bg"
                                                                           for="file8">{{ __('common.Browse') }}</label>
                                                                    <input type="file"
                                                                           class="d-none fileUpload imgInput8   "
                                                                           name="become_instructor_page_banner"
                                                                           id="file8">
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="row pt-0">
                                                @if(isModuleActive('FrontendMultiLang'))
                                                    <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ml-3"
                                                        role="tablist">
                                                        @foreach ($LanguageList as $key => $language)
                                                            <li class="nav-item">
                                                                <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                   href="#element6{{$language->code}}"
                                                                   role="tab"
                                                                   data-toggle="tab">{{ $language->native }}  </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                            <div class="tab-content">
                                                @foreach ($LanguageList as $key => $language)
                                                    <div role="tabpanel"
                                                         class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                                                         id="element{{$language->code}}">
                                                        <div class="row">
                                                            <div class="col-xl-6">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('frontendmanage.About Page Title') }}
                                                                    </label>
                                                                    <input class="primary_input_field"
                                                                           placeholder="{{ __('frontendmanage.About Page Title') }}"
                                                                           type="text"
                                                                           name="about_page_title[{{$language->code}}]"
                                                                           {{ $errors->has('about_page_title') ? ' autofocus' : '' }}
                                                                           value="{{isset($page_content)? getRawHomeContents($page_content,'about_page_title',$language->code) : ''}}">
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-6">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('frontendmanage.About Page Sub Title') }}</label>
                                                                    <input class="primary_input_field"
                                                                           placeholder="{{ __('frontendmanage.About Page Sub Title') }}"
                                                                           type="text"
                                                                           name="about_sub_title[{{$language->code}}]"
                                                                           {{ $errors->has('about_sub_title') ? ' autofocus' : '' }}
                                                                           value="{{isset($page_content)? getRawHomeContents($page_content,'about_sub_title',$language->code) : ''}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="row">
                                                @if(currentTheme() == 'infixlmstheme' || currentTheme() == 'wetech' || currentTheme() == 'teachery')
                                                    <div class="col-xl-2">
                                                        <div class="primary_input mb-25">
                                                            <img height="70" class="w-100 imagePreview6"
                                                                 src="{{ asset('/'.getRawHomeContents($page_content,'about_page_banner','en'))}}"
                                                                 alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('frontendmanage.About Page Banner') }}
                                                                <small>({{__('common.Recommended Size')}}
                                                                    1920x500)</small>
                                                            </label>
                                                            <div class="primary_file_uploader">
                                                                <input
                                                                    class="primary-input  filePlaceholder {{ @$errors->has('instructor_page_banner') ? ' is-invalid' : '' }}"
                                                                    type="text" id=""
                                                                    placeholder="Browse file"
                                                                    readonly="" {{ $errors->has('about_page_banner') ? ' autofocus' : '' }}>
                                                                <button class="" type="button">
                                                                    <label
                                                                        class="primary-btn small fix-gr-bg"
                                                                        for="file6">{{ __('common.Browse') }}</label>
                                                                    <input type="file"
                                                                           class="d-none fileUpload imgInput6"
                                                                           name="about_page_banner"
                                                                           id="file6">
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            @if(isModuleActive('Subscription'))
                                                <div class="row pt-0">
                                                    @if(isModuleActive('FrontendMultiLang'))
                                                        <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ml-3"
                                                            role="tablist">
                                                            @foreach ($LanguageList as $key => $language)
                                                                <li class="nav-item">
                                                                    <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                       href="#element7{{$language->code}}"
                                                                       role="tab"
                                                                       data-toggle="tab">{{ $language->native }}  </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                                <div class="tab-content">
                                                    @foreach ($LanguageList as $key => $language)
                                                        <div role="tabpanel"
                                                             class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                                                             id="element7{{$language->code}}">
                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="">{{ __('subscription.Subscription Page Title') }}
                                                                        </label>
                                                                        <input class="primary_input_field"
                                                                               placeholder="{{ __('subscription.Subscription Page Title') }}"
                                                                               type="text"
                                                                               name="subscription_page_title[{{$language->code}}]"
                                                                               {{ $errors->has('subscription_page_title') ? ' autofocus' : '' }}
                                                                               value="{{isset($page_content)? getRawHomeContents($page_content,'subscription_page_title',$language->code) : ''}}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-6">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="">{{ __('subscription.Subscription Page Sub Title') }}</label>
                                                                        <input class="primary_input_field"
                                                                               placeholder="{{ __('subscription.Subscription Page Sub Title') }}"
                                                                               type="text"
                                                                               name="subscription_page_sub_title[{{$language->code}}]"
                                                                               {{ $errors->has('subscription_page_sub_title') ? ' autofocus' : '' }}
                                                                               value="{{isset($page_content)? getRawHomeContents($page_content,'subscription_page_sub_title',$language->code) : ''}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="row">

                                                    <div class="col-xl-2">
                                                        <div class="primary_input mb-25">
                                                            <img height="70" class="w-100 imagePreview9"
                                                                 src="{{ asset('/'.getRawHomeContents($page_content,'subscription_page_banner','en'))}}"
                                                                 alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('frontendmanage.Subscription Page Banner') }}
                                                                <small>({{__('common.Recommended Size')}}
                                                                    1920x500)</small>
                                                            </label>
                                                            <div class="primary_file_uploader">
                                                                <input
                                                                    class="primary-input  filePlaceholder {{ @$errors->has('subscription_page_banner') ? ' is-invalid' : '' }}"
                                                                    type="text" id=""
                                                                    placeholder="Browse file"
                                                                    readonly="" {{ $errors->has('subscription_page_banner') ? ' autofocus' : '' }}>
                                                                <button class="" type="button">
                                                                    <label
                                                                        class="primary-btn small fix-gr-bg"
                                                                        for="file9">{{ __('common.Browse') }}</label>
                                                                    <input type="file"
                                                                           class="d-none fileUpload imgInput9"
                                                                           name="subscription_page_banner"
                                                                           id="file9">
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if(isModuleActive('Forum'))
                                                <div class="row pt-0">
                                                    @if(isModuleActive('FrontendMultiLang'))
                                                        <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ml-3"
                                                            role="tablist">
                                                            @foreach ($LanguageList as $key => $language)
                                                                <li class="nav-item">
                                                                    <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                       href="#element8{{$language->code}}"
                                                                       role="tab"
                                                                       data-toggle="tab">{{ $language->native }}  </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                                <div class="tab-content">
                                                    @foreach ($LanguageList as $key => $language)
                                                        <div role="tabpanel"
                                                             class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                                                             id="element8{{$language->code}}">
                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="">{{ __('forum.Forum Page Title') }}
                                                                        </label>
                                                                        <input class="primary_input_field"
                                                                               placeholder="{{ __('forum.Forum Page Title') }}"
                                                                               type="text"
                                                                               name="forum_title[{{$language->code}}]"
                                                                               {{ $errors->has('forum_title') ? ' autofocus' : '' }}
                                                                               value="{{isset($page_content)? getRawHomeContents($page_content,'forum_title',$language->code) : ''}}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-6">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="">{{ __('forum.Forum Page Sub Title') }}</label>
                                                                        <input class="primary_input_field"
                                                                               placeholder="{{ __('forum.Forum Page Sub Title') }}"
                                                                               type="text"
                                                                               name="forum_sub_title[{{$language->code}}]"
                                                                               {{ $errors->has('forum_sub_title') ? ' autofocus' : '' }}
                                                                               value="{{isset($page_content)? getRawHomeContents($page_content,'forum_sub_title',$language->code) : ''}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="row">


                                                    @if(currentTheme() == 'infixlmstheme' || currentTheme() == 'wetech' || currentTheme() == 'teachery')
                                                        <div class="col-xl-2">
                                                            <div class="primary_input mb-25">
                                                                <img height="70" class="w-100 imagePreview9"
                                                                     src="{{ asset('/'.getRawHomeContents($page_content,'forum_banner','en'))}}"
                                                                     alt="">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="">{{ __('forum.Forum Page Banner') }}
                                                                    <small>({{__('common.Recommended Size')}}
                                                                        1920x500)</small>
                                                                </label>
                                                                <div class="primary_file_uploader">
                                                                    <input
                                                                        class="primary-input  filePlaceholder {{ @$errors->has('forum_banner') ? ' is-invalid' : '' }}"
                                                                        type="text" id=""
                                                                        placeholder="Browse file"
                                                                        readonly="" {{ $errors->has('forum_banner') ? ' autofocus' : '' }}>
                                                                    <button class="" type="button">
                                                                        <label
                                                                            class="primary-btn small fix-gr-bg"
                                                                            for="file9">{{ __('common.Browse') }}</label>
                                                                        <input type="file"
                                                                               class="d-none fileUpload imgInput9"
                                                                               name="forum_banner"
                                                                               id="file9">
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                            <div class="row pt-0">
                                                @if(isModuleActive('FrontendMultiLang'))
                                                    <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ml-3"
                                                        role="tablist">
                                                        @foreach ($LanguageList as $key => $language)
                                                            <li class="nav-item">
                                                                <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                   href="#element9{{$language->code}}"
                                                                   role="tab"
                                                                   data-toggle="tab">{{ $language->native }}  </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                            <div class="tab-content">
                                                @foreach ($LanguageList as $key => $language)
                                                    <div role="tabpanel"
                                                         class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                                                         id="element9{{$language->code}}">
                                                        <div class="row">
                                                            <div class="col-xl-6">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('frontendmanage.Blog Page Title') }}</label>
                                                                    <input class="primary_input_field"
                                                                           placeholder="{{ __('frontendmanage.Blog Page Title') }}"
                                                                           type="text"
                                                                           name="blog_page_title[{{$language->code}}]"
                                                                           {{ $errors->has('blog_page_title') ? ' autofocus' : '' }}
                                                                           value="{{isset($page_content)? getRawHomeContents($page_content,'blog_page_title',$language->code) : ''}}">
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-6">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('frontendmanage.Blog Page Sub Title') }}</label>
                                                                    <input class="primary_input_field"
                                                                           placeholder="{{ __('frontendmanage.Blog Page Sub Title') }}"
                                                                           type="text"
                                                                           name="blog_page_sub_title[{{$language->code}}]"
                                                                           {{ $errors->has('blog_page_sub_title') ? ' autofocus' : '' }}
                                                                           value="{{isset($page_content)? getRawHomeContents($page_content,'blog_page_sub_title',$language->code) : ''}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="row">


                                                @if(currentTheme() == 'infixlmstheme' || currentTheme() == 'wetech' || currentTheme() == 'teachery')
                                                    <div class="col-xl-2">
                                                        <div class="primary_input mb-25">

                                                            <img class=" imagePreview10"
                                                                 style="max-width: 100%"
                                                                 src="{{asset('/'.getRawHomeContents($page_content,'blog_page_banner','en'))}}"
                                                                 alt="">

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('frontendmanage.Blog Page Banner') }}
                                                                <small>({{__('common.Recommended Size')}}
                                                                    1920x500)</small>
                                                            </label>
                                                            <div class="primary_file_uploader">
                                                                <input
                                                                    class="primary-input  filePlaceholder {{ @$errors->has('blog_banner') ? ' is-invalid' : '' }}"
                                                                    type="text" id=""
                                                                    placeholder="Browse file"
                                                                    readonly="" {{ $errors->has('blog_page_banner') ? ' autofocus' : '' }}>
                                                                <button class="" type="button">
                                                                    <label
                                                                        class="primary-btn small fix-gr-bg"
                                                                        for="file10">{{ __('common.Browse') }}</label>
                                                                    <input type="file"
                                                                           class="d-none imgInput10"
                                                                           name="blog_page_banner"
                                                                           id="file10">
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif


                                                <div class="col-xl-12">
                                                    <hr>
                                                    <br>
                                                </div>

                                            </div>

                                            @if(isModuleActive('LmsSaas'))
                                                <div class="row pt-0">
                                                    @if(isModuleActive('FrontendMultiLang'))
                                                        <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ml-3"
                                                            role="tablist">
                                                            @foreach ($LanguageList as $key => $language)
                                                                <li class="nav-item">
                                                                    <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                       href="#element10{{$language->code}}"
                                                                       role="tab"
                                                                       data-toggle="tab">{{ $language->native }}  </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                                <div class="tab-content">
                                                    @foreach ($LanguageList as $key => $language)
                                                        <div role="tabpanel"
                                                             class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                                                             id="element10{{$language->code}}">
                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="">{{ __('frontendmanage.Saas Page Title') }}</label>
                                                                        <input class="primary_input_field"
                                                                               placeholder="{{ __('frontendmanage.Saas Page Title') }}"
                                                                               type="text"
                                                                               name="saas_title{{$language->code}}"
                                                                               {{ $errors->has('saas_title') ? ' autofocus' : '' }}
                                                                               value="{{isset($page_content)? getRawHomeContents($page_content,'saas_title',$language->code) : ''}}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="">{{ __('frontendmanage.Saas Page Sub Title') }}</label>
                                                                        <input class="primary_input_field"
                                                                               placeholder="{{ __('frontendmanage.Saas Page Sub Title') }}"
                                                                               type="text"
                                                                               name="saas_sub_title{{$language->code}}"
                                                                               {{ $errors->has('saas_sub_title') ? ' autofocus' : '' }}
                                                                               value="{{isset($page_content)? getRawHomeContents($page_content,'saas_sub_title',$language->code) : ''}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="row">

                                                    <div class="col-xl-2">
                                                        <div class="primary_input mb-25">
                                                            <img class=" imagePreview12"
                                                                 style="max-width: 100%"
                                                                 src="{{asset('/'.@getRawHomeContents($page_content,'saas_banner','en'))}}"
                                                                 alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('frontendmanage.Saas Plan Banner') }}
                                                                <small>({{__('common.Recommended Size')}}
                                                                    1920x500)</small>
                                                            </label>
                                                            <div class="primary_file_uploader">
                                                                <input
                                                                    class="primary-input  filePlaceholder {{ @$errors->has('saas_banner') ? ' is-invalid' : '' }}"
                                                                    type="text" id=""
                                                                    placeholder="Browse file"
                                                                    readonly="" {{ $errors->has('saas_banner') ? ' autofocus' : '' }}>
                                                                <button class="" type="button">
                                                                    <label
                                                                        class="primary-btn small fix-gr-bg"
                                                                        for="file12">{{ __('common.Browse') }}</label>
                                                                    <input type="file"
                                                                           class="d-none imgInput12"
                                                                           name="saas_banner" id="file12">
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <hr>
                                                        <br>
                                                    </div>
                                                </div>
                                            @endif
                                            @if(isModuleActive('CourseOffer'))
                                                <div class="row pt-0">
                                                    @if(isModuleActive('FrontendMultiLang'))
                                                        <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ml-3"
                                                            role="tablist">
                                                            @foreach ($LanguageList as $key => $language)
                                                                <li class="nav-item">
                                                                    <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                       href="#element11{{$language->code}}"
                                                                       role="tab"
                                                                       data-toggle="tab">{{ $language->native }}  </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                                <div class="tab-content">
                                                    @foreach ($LanguageList as $key => $language)
                                                        <div role="tabpanel"
                                                             class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                                                             id="element11{{$language->code}}">
                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="">{{ __('frontendmanage.Offer Page Title') }}</label>
                                                                        <input class="primary_input_field"
                                                                               placeholder="{{ __('frontendmanage.Offer Page Title') }}"
                                                                               type="text"
                                                                               name="offer_page_title[{{$language->code}}]"
                                                                               {{ $errors->has('offer_page_title') ? ' autofocus' : '' }}
                                                                               value="{{isset($page_content)? getRawHomeContents($page_content,'offer_page_title',$language->code) : ''}}">
                                                                    </div>
                                                                </div>


                                                                <div class="col-xl-6">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="">{{ __('frontendmanage.Offer Page Sub Title') }}</label>
                                                                        <input class="primary_input_field"
                                                                               placeholder="{{ __('frontendmanage.Offer Page Sub Title') }}"
                                                                               type="text"
                                                                               name="offer_page_sub_title[{{$language->code}}]"
                                                                               {{ $errors->has('offer_page_sub_title') ? ' autofocus' : '' }}
                                                                               value="{{isset($page_content)? getRawHomeContents($page_content,'offer_page_sub_title',$language->code) : ''}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-2">
                                                        <div class="primary_input mb-25">

                                                            <img class="imagePreview11"
                                                                 style="max-width: 100%"
                                                                 src="{{asset('/'.getRawHomeContents($page_content,'offer_page_banner','en'))}}"
                                                                 alt="">

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('frontendmanage.Offer Page Banner') }}
                                                                <small>({{__('common.Recommended Size')}}
                                                                    1920x500)</small>
                                                            </label>
                                                            <div class="primary_file_uploader">
                                                                <input
                                                                    class="primary-input  filePlaceholder {{ @$errors->has('offer_banner') ? ' is-invalid' : '' }}"
                                                                    type="text" id=""
                                                                    placeholder="Browse file"
                                                                    readonly="" {{ $errors->has('offer_page_banner') ? ' autofocus' : '' }}>
                                                                <button class="" type="button">
                                                                    <label
                                                                        class="primary-btn small fix-gr-bg"
                                                                        for="file11">{{ __('common.Browse') }}</label>
                                                                    <input type="file"
                                                                           class="d-none imgInput11"
                                                                           name="offer_page_banner"
                                                                           id="file11">
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-xl-12">
                                                        <hr>
                                                        <br>
                                                    </div>

                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                @php
                                    $tooltip = "";
                                    if(permissionCheck('null')){
                                        $tooltip = "";
                                    }else{
                                        $tooltip = "You have no permission to Update";
                                    }
                                @endphp
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-center">
                                        <button class="primary-btn fix-gr-bg" data-toggle="tooltip"
                                                title="{{$tooltip}}">
                                            <span class="ti-check"></span>
                                            {{__('common.Update')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                </div>


            </div>
        </div>
    </section>

@endsection
@push('scripts')
    <script>
        function readURL1(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview1").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput1").change(function () {
            readURL1(this);
        });

        function readURL2(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview2").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput2").change(function () {
            readURL2(this);
        });


        function readURL3(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview3").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput3").change(function () {
            readURL3(this);
        });


        function readURL4(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview4").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput4").change(function () {
            readURL4(this);
        });


        function readURL5(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview5").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput5").change(function () {
            readURL5(this);
        });
        $(".imgInput4").change(function () {
            readURL4(this);
        });


        function readURL6(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview6").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput6").change(function () {
            readURL6(this);
        });

        function readURL7(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview7").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput7").change(function () {
            readURL7(this);
        });

        function readURL8(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview8").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput8").change(function () {
            readURL8(this);
        });


        function readURL9(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview9").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput9").change(function () {
            readURL9(this);
        });

        function readURL10(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview10").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput10").change(function () {
            readURL10(this);
        });


        function readURL11(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview11").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput11").change(function () {
            readURL11(this);
        });

        function readURL12(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview12").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput12").change(function () {
            readURL12(this);
        });
    </script>
@endpush
